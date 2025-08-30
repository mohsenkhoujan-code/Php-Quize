<?php include_once("libraris.php");
$reCaptcha2 = new Captcha();
$reCaptcha2->alert_message = "کد امنیتی را اشتباه وارد کرده اید";
$reCaptcha2->captcha_set_style(
    "border-width: 2px;
     border-color: purple;
     border-style: ridge;
     border-radius: 10px;
     float: center;"
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

<body id="sign-in-bodies">
    <div class="container-s">
        <div id="testzors">
            <h1>
                <span>T</span>
                <span>e</span>
                <span>s</span>
                <span>t</span>
                <span>Z</span>
                <span>o</span>
                <span>r</span>
                <span>s</span>
            </h1>
        </div>
        <div class="form">
            <button id="back" onmouseup="pc_back('p1','p2','p3')">►</button>
            <form action="SingIn.php" method="post" enctype="multipart/form-data">
                <div class="plan1" id="p1">
                    <div id="h1">
                        <input type="text" name="username" placeholder="نام کاربری"><br><br>
                        <input type="password" name="password" placeholder="گذرواژه" id="pssw"><br><br>
                        <input type="password" name="confirm-password" placeholder="تکرار گذرواژه" id="pssw2"><br><br>
                        <span style="font-family:mjmandana;font-size:20px"> نمایش گذرواژه</span><input type="checkbox" onchange="checkeded('pssw','pssw2','chp')" id="chp"><br><br>
                        <input type="button" value="بعدی" class="next" onclick="next_page('p1','p2')"><br>
                        <a href="../index.php"><input type="button" value="خانه" class="prev"></a>
                    </div>
                </div>
                <div class="plan2" id="p2" style="display:none">
                    <div id="h2">
                        <img id="idimage" src="../IMG/icons8-administrator-male-96.png"><br>
                        <input type="file" accept="image/png, image/gif, image/jpeg" id='imgfile' name="profile"><label for="imgfile" id="files">انتخاب تصویر</label><br>
                        <input type="text" name="nikname" id="nikname" placeholder="نام مستعارتان را بنویسید"><br>
                        <!-- captcha position -->
                        <?php $reCaptcha2->echo_captcha($reCaptcha2->get_cpr2(), 1) ?><br><input type="text" name="captcha" id="captcha" placeholder="کد امنیتی را وارد کنید"><br>
                        <input type="button" value="بعدی" class="next" onclick="next_page('p2','p3')"><br>
                        <input type="button" value="قبلی" class="prev" onclick="next_page('p2','p1')"><br>
                        <!-- captcha position -->
                    </div>
                </div>
                <div class="plan3" style="display:none" id="p3">
                    <h1>اگر از صحت اطلاعات خود اطمینان دارد کلید ثبت نام را بفشارید!!</h1>
                    <input type="submit" value="ثبت نام" name="send" id="smit"><br>
                    <input type="button" value="قبلی" class="prev" onclick="next_page('p3','p2')"><br>
                </div>

            </form>

            <script src="../Js/java-script-formulation.js">

            </script>
        </div>
    </div>
</body>

</html>

<?php
include("Database.php");
session_start();
if (isset($_POST['send'])) {
    $reCaptcha2->check_captcha("SingIn.php", $_POST['captcha'], false, false);
    if (
        empty(strpos($_POST['username'], ' '))
    ) {
        if ($_POST['password'] == $_POST['confirm-password']) {
            try {

                $nikname = $_POST['nikname'];
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                if (isset($_FILES['profile'])) {
                    if (!empty($_FILES['profile']['tmp_name'])) {
                        $content = file_get_contents($_FILES['profile']['tmp_name']);
                        $dir = "../IMG/" . $_POST['username'] . "-" . $_FILES['profile']['name'];
                        $file = fopen($dir, "wb");
                        fwrite($file, $content);
                        fclose($file);
                        mysqli_query($con, "INSERT INTO users_bank(username,password_,mark,tests,profile_,nikname) VALUES (\"{$_POST['username']}\",\"$hash\",0,0,\"$dir\",\"$nikname\")");
                    } else {
                        mysqli_query($con, "INSERT INTO users_bank(username,password_,mark,tests,nikname) VALUES (\"{$_POST['username']}\",\"$hash\",0,0,\"$nikname\")");
                    }
                } else {
                    mysqli_query($con, "INSERT INTO users_bank(username,password_,mark,tests,nikname) VALUES (\"{$_POST['username']}\",\"$hash\",0,0,\"$nikname\")");
                }

                //echo "INSERT INTO users_bank(username,password_,mark,tests,profile_,nikname) VALUES (\"{$_POST['username']}\",\"$hash\",0,0,\"profile_\",\"$nikname\")";

                header("Location: ../index.php");
            } catch (mysqli_sql_exception) {
                echo "<script>alert('نام کاربری شما مشابه دارد');</script>";
            }
        } else {
            echo '<script>alert("گذرواژه با تکرار گذرواژه برابر نیست");</script>';
        }
    } else {
    }
}



?>