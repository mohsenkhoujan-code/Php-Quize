<?php
session_start();
if(!isset($_SESSION['can-test'])){
    header("HTTP/1.0 404 Not Found");
    exit();
}
if(!isset($_COOKIE['username']) ){
    $_SESSION['can-test'] = null;
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit();
}
if(!isset($_SESSION['code'])){
    echo "<error>لطفا کد مورد نظر را وارد کنید</error>";
    exit();
}
include_once('Database.php');


$code = $_SESSION['code'];
$test_res = mysqli_query($con, "SELECT * FROM tests_bank");
$question_res =  mysqli_query($con, "SELECT * FROM question_bank");
$options = mysqli_query($con, "SELECT * FROM options");
$do = false;

if (mysqli_num_rows($test_res) > 0) {
    $test_rows = mysqli_fetch_array($test_res, MYSQLI_ASSOC);
    $qs_rows = mysqli_fetch_array($question_res, MYSQLI_ASSOC);
    $opt_rows = mysqli_fetch_array($options, MYSQLI_ASSOC);
    $do = true;

}
$_SESSION['can-test'] = null;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    foreach ($test_res as $test_row) {
        if ($test_row['code'] == $code) {

            try {
                $spql2 = "SELECT testid FROM blacklist WHERE username = \"{$_COOKIE['username']}\"";
                $blacklist = mysqli_query($con, $spql2);
                $do2 = true;
                foreach ($blacklist as $bt) {
                    if ($bt['testid'] == $code) {
                        $do2 = false;
                        header("Location: Identifier-error.php");
                        break;
                    }
                }
            } catch (mysqli_sql_exception) {
                header("Location: Identifier-error.php");
            }

            if ($do2) {
                $spql = "INSERT INTO blacklist(username,testid) values(\"{$_COOKIE['username']}\",\"{$test_row['code']}\")";
                mysqli_query($con, $spql);
                $q_index = 0;
                if ($test_row['uses'] < $test_row['maxusers']) {
                    $uses = $test_row['uses'] + 1;
                    $update = "UPDATE tests_bank SET uses = $uses WHERE code = \"{$test_row['code']}\"";
                    mysqli_query($con,$update);
                    echo "<form action='result.php' method='post'>";
                    echo "<h1>{$test_row['name']}</h1>";
                    echo "<h2>admin: {$test_row['useradmin']}</h2>";
                    echo "<h2>time: {$test_row['time']}</h2>";
                    echo "<h2>max users: {$test_row['maxusers']}</h2>";
                    echo "<h2>date: {$test_row['date']}</h2>";
                    echo "<h2>code: {$test_row['code']}</h2>";
                    echo "<h2>description: </h2><br><p>{$test_row['test_desc']}</p>";
                    echo "<hr>";
                    $do = true;
                    foreach ($question_res as $qs_row) {
                        if ($qs_row['testid'] == $code) {
                            echo "<h3>" . $q_index++ . " " . $qs_row['question'] . "</h3>";
                            $id_index = 0;
                            foreach ($options as $opt_row) {
                                if ($opt_row['optid_'] == $qs_row['optid']) {
                                    echo "<input type='radio' name='{$opt_row['optid_']}' value='{$opt_row['option_']}' id='{$opt_row['optid_']}{$id_index}'>{$opt_row['option_']}<br><br>";
                                    $id_index++;
                                }
                            }
                            echo "<br><br><br><br><br>";
                        }
                    }
                    echo "<hr>";
                    echo "<button id='scan'>تصحیح آزمون</button>&emsp;";
                    echo "</form>";
                    echo "<button id='cancel' onclick='Close()'>لغو و خروج از آزمون</button>";

                    echo "<script src='../JS/Test.js'></script>";
                    $_SESSION['testid'] = $test_row['code'];
                    break;
                }
                else
                {
                    header("Location: users_is_out_of_range.php");
                }
            }
        }
        else{
            $do = false;
        }
    }



    if (!$do) {
        echo "<error><h1>کد شما نا معتبر است</h1></error>";
    }
    ?>
</body>

</html>