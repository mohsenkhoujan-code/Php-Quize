<?php include_once("libraris.php");
$reCaptcha2 = new Captcha();
$reCaptcha2->alert_message = "کد امنیتی را اشتباه وارد کرده اید";
$reCaptcha2->captcha_set_style(
    "border-width: 2px;
     border-color: purple;
     border-style: ridge;
     border-radius: 10px;"
);
$reCaptcha2->id = "captcha-img";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="MakingTest.php" method="post">
        <input type="text" name="test-name" placeholder="نام آزمون" require pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"><br><br>
        <input type="text" name="test-code" placeholder="کد آزمون" require minlength="5"><br><br>
        <input type="number" name="max-users" placeholder="حداکثر کاربران" require minlength="1" value='1'><br><br>
        <input type="number" name="time" id="" require value='6'> 'براساس دقیقه' <br><br>
        توضیحات آزمون<br>
        <textarea name="test-desc" id="" cols="30" rows="10"></textarea><br><br>
        <!-- captcha position -->
        <input type="text" name="captcha" id="captcha" placeholder="کد امنیتی را وارد کنید"><?php $reCaptcha2->echo_captcha($reCaptcha2->get_cpr2(),1) ?><br>
        <!-- captcha position -->
        <a href="../index.php"><input type="button" value="خانه" id="home"></a>
        <input type="submit" value="ایجاد سوال" name="confirm">
    </form>
</body>

</html>
<?php
include_once("Database.php");
include_once("Json-management.php");
if (isset($_COOKIE['username'])) {

    session_start();

    if (isset($_POST['confirm'])) {
        $reCaptcha2->check_captcha("MakingTest.php", $_POST['captcha'], false, true);
        if (!empty($_POST['test-name'])) {
            if (count(mb_str_split($_POST['test-code'])) > 5) {
                if ($_POST['time'] > 5) {
                    if ($_POST['max-users'] > 0) {
                        $res = mysqli_query($con, "SELECT * FROM tests_bank");
                        $do = true;
                        if (mysqli_num_rows($res) > 1) {

                            while ($row = mysqli_fetch_assoc($res)) {
                                if ($row == htmlspecialchars($_POST['test-code'])) {
                                    $do = false;
                                    break;
                                }
                            }
                        }
                        if ($do) {
                            try {


                                $api = array();
                                $api['test-name'] = htmlspecialchars($_POST['test-name']);
                                $api['test-code'] = htmlspecialchars($_POST['test-code']);
                                $api['max-users'] = htmlspecialchars($_POST['max-users']);
                                $api['time'] = htmlspecialchars($_POST['time']);
                                $api['test-desc'] = htmlspecialchars($_POST['test-desc']);
                                $rkey = render_code_into_id($api['test-code'], FILTER_VALIDATE_NAME(), $url_key);
                                $tkey = render_code_into_id($api['test-code'], FILTER_VALIDATE_NAME(), $url_key) . 'HasblitTest&&Modify';
                                $path = $json_dir . $rkey;
                                $sql = "INSERT INTO contact_form (username,testid) values(\"{$_COOKIE['username']}\",\"{$api['test-code']}\")";
                                mysqli_query($con, $sql);

                                $apifile = fopen(json_file_format($path), 'w');
                                fwrite($apifile, json_encode($api));
                                fclose($apifile);

                                $path = $json_dir . $tkey;
                                $apifile = fopen(json_file_format($path), 'w');
                                fclose($apifile);
                                $_SESSION['MaKe-Q-AcCePtORy'] = '10';
                                header("Location: MakingQestions.php");
                            } catch (mysqli_sql_exception $e) {

                                if ($e->getCode() === 1062) { // Error code for duplicate entry  
                                    echo "<h3> شما هم اکنون دارای آزمون رزرو هستید برای حل این مشکل به گزارشنامه مراجعه کنید </h3>";
                                    // You can handle the duplicate case here (e.g., log it, return a specific response, etc.)  
                                } else {
                                    // For other errors  
                                    echo "<h3>alert('303 کد آزمون غیر مجاز است')</h3>";
                                }
                            }
                        } else {
                            echo "<script>alert('300 کد آزمون غیر مجاز است')</script>";
                        }
                    } else {
                        echo "<script>alert('لطفا تعداد کاربران را به درستی و بیشتر از 1 وارد کنید')</script>";
                    }
                } else {
                    echo "<script>alert('لطفا زمان را بیشتر از 5 دقیق وارد کنید')</script>";
                }
            } else {
                echo "<script>alert('کد آزمون شما باید بیشتر از 5 نویسه باشد')</script>";
            }
        } else {
            echo "<script>alert('لطفا یک نام برای آزمون خود وارد کنید')</script>";
        }
    }
} else {
    header("Location: Login.php");
}
?>