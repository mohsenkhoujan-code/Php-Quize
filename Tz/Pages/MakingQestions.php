<?php
session_start();
if (isset($_SESSION['MaKe-Q-AcCePtORy'])) {
    if (isset($_COOKIE['username'])) {
        include_once("Json-management.php");
        include_once("libraris.php");
        include_once("Database.php");



        $js_code = "%wd\$43&o=13d?l=";



        $res = mysqli_query($con, "SELECT * FROM contact_form");
        $do = true;
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                if ($row['username'] == $_COOKIE['username']) {
                    $js_file = json_file_format($json_dir . $row['testid'] . 'HasblitTest&&Modify');
                    $js_prof = json_file_format($json_dir . $row['testid']);
                    break;
                }
            }
        }
        if (!isset($js_file)) {
            $js_file = $json_dir . "test_json.json";
        }




        if (isset($_POST['Doing'])) {
            if (!empty($_POST['del'])) {
                $api = JsonIntoQ($js_file);
                if ($api != -1) {
                    $del = explode($js_code, $_POST['del']);
                    $blank = array();

                    foreach ($api as $q) {
                        $new_api = array();
                        if (gettype($del) == 'array') {
                            if (!(in_array($q['id'], $del))) {
                                $new_api['q'] = $q['q'];
                                $new_api['id'] = $q['id'];
                                $new_api['options'] = $q['options'];
                                array_push($blank, $new_api);
                            }
                        } elseif (gettype($del) == 'string') {
                            if ($q['id'] != $del) {
                                $new_api['q'] = $q['q'];
                                $new_api['id'] = $q['id'];
                                $new_api['options'] = $q['options'];
                                array_push($blank, $new_api);
                            }
                        }
                    }
                    QintoJson($blank, $js_file, false);
                    reload($js_file);
                }
            }
        }
        if (isset($_POST['save-and-next'])) {

            if (!empty($_POST['q'])) {
                if (!empty($_POST['namespace'])) {
                    if (isset($_POST['optcore'])) {
                        $q = htmlspecialchars($_POST['q']);
                        $g = explode($js_code, $_POST['namespace']);
                        $ques = array("q" => "", 'id' => '', 'copt' => '', "options" => array());
                        $ques['q'] = $q;
                        $ques['id'] = getRandString(getAllChars());
                        $ques['copt'] = $_POST['optcore'];
                        foreach ($g as $i) {
                            array_push($ques['options'], htmlspecialchars($i));
                        }
                        array_push($questions, $ques);
                        QintoJson($questions, $js_file);
                        reload($js_file);
                    } else {
                        echo "<script>alert('شما باید گزینه درست را انتخاب کنید')</script>";
                    }
                } else {
                    echo "<script>alert('شما هیچ گزینه‌ای را وارد نکرده‌اید')</script>";
                }
            } else {
                echo "<script>alert('لطفا سوال خود را بادقت وارد کنید')</script>";
            }
        }

        if (isset($_POST['save-and-close'])) {
            $controller = file_get_contents($js_prof);
            $controller = json_decode($controller, true);
            $api_arr = JsonIntoQ($js_file);

            $test_name = $controller['test-name'];
            $test_code = $controller['test-code'];
            $max_users = $controller['max-users'];
            $time = $controller['time'];
            $test_desc = $controller['test-desc'];
            $rs_desc = $controller['result-desc'];
            $sql = "INSERT INTO tests_bank(name,code,useradmin,maxusers,test_desc,uses,time) values(\"{$test_name}\",\"{$test_code}\",\"{$_COOKIE['username']}\",\"{$max_users}\",\"{$test_desc}\",0,\"{$time}\")";
            mysqli_query($con, $sql);
            foreach ($api_arr as $i) {
                $qs = $i['q'];
                $optid = $i['id'];
                $copt = $i['copt'];
                $sql = "INSERT INTO question_bank(question,copt,optid,testid) values(\"{$qs}\",\"{$copt}\",\"{$optid}\",\"{$test_code}\")";
                mysqli_query($con, $sql);
                foreach ($i['options'] as $option_) {
                    $sql2 = "INSERT INTO options(optid_,option_) values(\"{$optid}\",\"{$option_}\")";
                    mysqli_query($con, $sql2);
                }
            }
            unlink($js_file);
            unlink($js_prof);
            $sql3 = "DELETE FROM contact_form WHERE username = \"{$_COOKIE['username']}\"";
            mysqli_query($con, $sql3);
            header("Location: ../index.php?popup2=success");
        }
    } else {
        header("Location: Login.php");
    }
}
else{
    header("location: ../Pages/404_not_found.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <hr>
    <form action="MakingQestions.php" method="post">
        <input type="text" name="q" placeholder="متن سوال"><br><br>
        <input type="text" name="opt" id="option" placeholder="گزینه">
        <input type="button" value="add" onclick="add_option()">
        <input type="button" value="remove" onclick="remove_option()"><br><br>
        <div id="options">

        </div>
        <input type="text" name="namespace" id="namespace" readonly style="display:none">

        <hr>
        <input type="submit" value="ذخیره" name="save-and-next">
        <input type="submit" value="ثبت نهایی" name="save-and-close">
    </form>
    <script src="../Js/MakingQuestion.js">
        
    </script>
    <script>
        window.addEventListener("beforeunload", function(event) {
            const message = "آیا مطمئن هستید که می‌خواهید خارج شوید؟";
            event.returnValue = message;
            alert(message);
            return message;
        });
    </script>
</body>

</html>