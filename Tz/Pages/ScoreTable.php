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
    <?php
    if (isset($_COOKIE['username'])) {
        include('Database.php');

        $users = mysqli_query(
            $con,
            "SELECT * FROM users_bank ORDER BY mark DESC"
        );

        $idx = 1;
        foreach ($users as $user) {
            if ($user['username'] == $_COOKIE['username']) {
                echo "<div class='self'>";
                echo '<div id="scores"><span>امتیاز:</span>' . $user['mark'] . '</div><div>تعداد آزمون ها:' . $user['tests'] . '</div>' . "<div id='nikname'>{$user['nikname']}</div><div id='uname'>" . $user['username'] . '</div>' . "<div><img id=\"a$idx\"  src='{$user['profile_']}'></div>" . "<div style='background-color:black;color:white' id='rank'>" . $idx . "</div>";
                echo "</div>";
                $idx++;
            } else {
                echo "<div class='card'>";
                echo '<div id="scores"><span>امتیاز:</span>' . $user['mark'] . '</div><div>تعداد آزمون ها:' . $user['tests'] . '</div>' . "<div id='nikname'>{$user['nikname']}</div><div id='uname'>" . $user['username'] . '</div>' . "<div><img id=\"a$idx\"  src='{$user['profile_']}'></div>" . "<div style='background-color:black;color:white' id='rank'>" . $idx . "</div>";
                echo "</div>";
                $idx++;
            }
        }
        $idx2 = 1;
        $userDevice = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match("/mobile/i", $userDevice)) {
            foreach ($users as $user) {
                if ($user['username'] == $_COOKIE['username']) {
                    echo "<div class='self-m'>";
                    echo '<div id="profile"> <img src="'.$user['profile_'].'" class="prof"> </div>';
                    echo '<div id="niknam">'.$user['nikname'].'</div>';
                    echo '<div id="username">'.$user['username'].'</div>';
                    echo '<div id="ninfo">';
                    echo '<div id="mk">امتیاز: '.$user['mark']."</div>";
                    echo '<div id="ts">آزمون ها: '.$user['tests']."</div>";
                    echo '<div>رتبه: '.$idx2.'</div>';
                    echo '</div>';
                    echo "</div>";
                } else {
                    echo "<div class='card-m'>";
                    echo '<div id="profile"> <img src="'.$user['profile_'].'" class="prof"> </div>';
                    echo '<div id="niknam">'.$user['nikname'].'</div>';
                    echo '<div id="username">'.$user['username'].'</div>';
                    echo '<div id="ninfo">';
                    echo '<div id="mk">امتیاز: '.$user['mark']."</div>";
                    echo '<div id="ts">آزمون ها: '.$user['tests']."</div>";
                    echo '<div>رتبه: '.$idx2.'</div>';
                    echo '</div>';
                    echo "</div>";
                    
                }
                $idx2++;
            }
        }
    } else {
        header("Location: Login.php");
    }
    ?>


</body>

</html>