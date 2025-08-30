<?php include_once("libraris.php");
$reCaptcha2 = new Captcha();
$reCaptcha2->alert_message = "کد امنیتی را اشتباه وارد کرده اید";
$reCaptcha2->captcha_set_style(
    "border-width: 2px;
     border-color: purple;
     border-style: ridge;
     border-radius: 10px;
     margin-bottom:10px;"

);
$reCaptcha2->id = "captcha-img";
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

<body class="loginbody">
    <div class="cont">
        <div class="box">
            <div class="inner">
                <span style="font-family:mjmandana">تست زورس</span>
            </div>
            <div class="inner">
                <span style="font-family:mjmandana">پلتفرم آزمون آنلاین</span>
            </div>
        </div>
        <div id="ck" style="padding-right:20px;">
            <h1>Test <span style="color: red" id="spanl">Zors</span></h1>
            <form action="Login.php" method="post" id="ck">
                <input type="text" name="username" placeholder="نام کاربری" id="uname" class="boxes"><br><br>
                <input type="password" name="password" placeholder="گذرواژه" id="passw" class="boxes"><br><br>
                <span style="font-family: mjmandana;font-size:18px">نمایش گذرواژه<input type="checkbox" name="" id="show-password" onchange="checkeded('passw','passw','show-password')"></span><br><br>
                <!-- captcha position -->
                <?php $reCaptcha2->echo_captcha($reCaptcha2->get_cpr2(), 1) ?><br>
                <input type="text" name="captcha2" id="captcha2" class="boxes" placeholder="کد امنیتی را وارد کنید"><br>
                <!-- captcha position -->
                <div>
                <input type="submit" value="ورود به حساب" name="send" class="send f">
                <a href="SingIn.php"><input type="button" class="send unf" value="ایجاد حساب"></a>
                <a href="../index.php"><input type="button" class="send unf" value="خانه"></a>
                
                </div>
                <br><br>
            </form>
        </div>
    </div>
    <script src="../Js/java-script-formulation.js"></script>
</body>

</html>

<?php
include_once("Database.php");
if (isset($_POST['send'])) {
    $reCaptcha2->check_captcha("SingIn.php", $_POST['captcha2'], false, false);
    $itis = false;
    $res = mysqli_query($con, "SELECT * FROM users_bank");
    $it = mysqli_num_rows($res);
    $user_does_not_exist = true;
    $password_is_incorrect = true;
    if (mysqli_num_rows($res) > 0) {
        //$rows = mysqli_fetch_array($res);
        $rows = array();
        foreach ($res as $row) {
            $rowi = array();
            foreach ($row as $i) {
                array_push($rowi, $i);
            }
            array_push($rows, $rowi);
        }
        foreach ($rows as $row) {
            if (in_array($_POST['username'], $row)) {
                $user_does_not_exist = false;
                if (password_verify($_POST['password'], $row[1])) {
                    $password_is_incorrect = false;
                    setcookie("username", $_POST['username'], time() + (3600 * 12), "/");
                    break;
                }
            }
        }
        if ($user_does_not_exist) {
            $alert = 'نام کاربری ';
            $alert = $alert . "'" . $_POST['username'] . "'";
            $alert = $alert . ' موجود نیست';
            echo '<script>alert("' . $alert . '")</script>';
        } else if ($password_is_incorrect) {
            echo '<script>alert("گذرواژه نادرست است")</script>';
        } else {
            header("Location: ../index.php?popup=success");
        }
    }
    else{

    }
}



?>