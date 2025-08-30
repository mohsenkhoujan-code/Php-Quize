<?php
include_once("Database.php");
class User
{
    public $UserNikname = "";
    public $UserUsername = "";
    public $UserProfile = "";
    public $UserMark = "";
    public $UserTests = "";
    public $OwnerFuncs = 3;

    function UserUsername()
    {
        echo $this->UserUsername;
    }

    function UserNikname()
    {
        echo $this->UserNikname;
    }

    function UserProfile()
    {
        echo "<img src=\"" . $this->UserProfile . "\" alt='Your Avatar' />";
    }

    function UserMark()
    {
        echo $this->UserMark;
    }

    function UserTests()
    {
        echo $this->UserTests;
    }

    function UserIp()
    {
        echo "<div id='shank-card'>" . $_SERVER['REMOTE_ADDR'] . "</div>";
    }

    function UserDevice()
    {
        echo "<div id='shank-card'>" . $_SERVER['HTTP_USER_AGENT'] . "</div>";
    }
}
$user = new User();
if (isset($_COOKIE["username"])) {
    $users = mysqli_query(
        $con,
        "SELECT * FROM users_bank WHERE username = \"{$_COOKIE['username']}\""
    );
    foreach ($users as $u) {
        $user->UserUsername = $u['username'];
        $user->UserNikname = $u['nikname'];
        $user->UserProfile = $u['profile_'];
        $user->UserMark = $u['mark'];
        $user->UserTests = $u['tests'];
    }
} else {
    header("Location: Login.php");
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style-lingard.css">
    <link rel="stylesheet" href="../CSS/media-queries.css">
    <link rel="stylesheet" href="../CSS/fonts-Impl.css">
    <title>Document</title>
</head>

<body>

    <div class="self-card">
        <div><?php $user->UserProfile() ?></div>
        <div>
            <h1 id="h1-1"><?php $user->UserNikname() ?></h1>
        </div>
        <div>
            <h1 id="h1-2"><?php $user->UserUsername() ?></h1>
        </div>
        <div>
            <div id="mark">امتیاز: <?php $user->UserMark() ?></div>
            <div id="tests">آزمون ها: <?php $user->UserTests() ?></div>
        </div>
    </div>

    <?php
    if (isset($_COOKIE["username"])) {
        $rp_sql = "SELECT * FROM reports WHERE username = \"{$_COOKIE['username']}\"";
        $rpres = mysqli_query($con, $rp_sql);
        if (!preg_match("/mobile/i", $_SERVER['HTTP_USER_AGENT'])) {
            echo "<table class='table'>";
            echo "<tr id='header'>";
            echo "  <td style='text-align:center'>نام</td><td style='text-align:center'>کد</td><td style='text-align:center'>ادمین</td><td style='text-align:center'>حداکثر کاربران</td><td style='text-align:center'>تاریخ ایجاد</td><td style='text-align:center'>مدت زمان</td><td style='text-align:center'>توضیحات</td><td style='text-align:center'>مشاهده نتایج</td>";
            echo "</tr>";
            foreach ($rpres as $rp) {
                echo "<tr>";
                $test_bsql = "SELECT * FROM tests_bank WHERE code = \"{$rp['testid']}\"";
                $testres = mysqli_query($con, $test_bsql);
                $keyindex = 0;
                foreach ($testres as $test) {
                    $desc_spliced = substr($test['test_desc'], 0, 35) . " ...";
                    echo "<form action='result2.php' method='post'>";
                    echo "<td style='text-align:center'><strong><b>{$test['name']}</b></strong></td>";
                    echo "<td style='text-align:center'><input style='border-width:0;background-color:rgba(0,0,0,0)' name='code' value='{$test['code']}' class='c-ode' readonly></td>";
                    echo "<td style='text-align:center'><strong><b>{$test['useradmin']}</b></strong></td>";
                    echo "<td style='text-align:center'><strong><b>{$test['maxusers']}</b></strong></td>";
                    echo "<td style='text-align:center'><strong><b>{$test['date']}</b></strong></td>";
                    echo "<td style='text-align:center'><strong><b>{$test['time']}</b></strong></td>";
                    echo "<td style='text-align:center'><strong><b>{$desc_spliced}</b></strong></td>";
                    echo "<td style='text-align:center'><strong><b><button>مشاهده نتایج</button></b></strong></td>";
                    echo "</form>";
                }
                echo "</tr>";
            }
            echo "</table>";

            
    }
    else{
        foreach ($rpres as $rp) {
            echo "<div class='cardrsr'>";
            $test_bsql = "SELECT * FROM tests_bank WHERE code = \"{$rp['testid']}\"";
            $testres = mysqli_query($con, $test_bsql);
            $keyindex = 0;
            foreach ($testres as $test) {
                $desc_spliced = substr($test['test_desc'], 0, 35) . " ...";
                echo "<div class='cardrs'>";
                echo "<form action='result2.php' method='post'>";
                echo "<div class='namec'><strong><b>{$test['name']}</b></strong></div>";
                echo "<div class='codec'><input style='border-width:0;background-color:rgba(0,0,0,0);text-align:center' name='code' value='{$test['code']}' class='c-ode' readonly></div>";
                echo "<div class='maintance'><div><strong><b>ادمین آزمون:</b></strong>{$test['useradmin']}</div>";
                echo "<div><strong><b>حداکثر کاربران:</b></strong>{$test['maxusers']}</div>";
                echo "<div><strong><b>تاریخ ایجاد:</b></strong>{$test['date']}</div>";
                echo "<div><strong><b>مدت زمان آزمون:</b></strong>{$test['time']}</div>";
                echo "<div><strong><b>{$desc_spliced}</b></strong></div>";
                echo "<div><button><strong><b>مشاهده نتایج</b></strong></button></div></div>";
                echo "</form>";
                echo "</div>";
            }
            echo "</div>";
        }
    }
    echo "<button onclick='Close(false)'>خانه</button>";
    echo "<script src='../Js/Test.js'></script>";

    }
    ?>
</body>

</html>