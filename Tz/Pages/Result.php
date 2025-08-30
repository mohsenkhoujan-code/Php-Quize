<?php
include("Database.php");

session_start();

$correct_counter = 0;
$incorrect_counter = 0;
$unanswered_counter = 0;
$total = 0;

$correct_api = array(

);
$incorrect_api = array(

);



$test_id = $_SESSION['testid'];

$sql = "SELECT * FROM tests_bank WHERE code = \"$test_id\"";
$sqlshuter = "SELECT * FROM question_bank WHERE testid = \"$test_id\"";
$testres =  mysqli_query($con,$sql);
$qres =  mysqli_query($con,$sqlshuter);


foreach($testres as $r)
{
    echo "<h1>{$r['name']}</h1>";
    echo "<h3>time: {$r['time']}</h3>";
    echo "<h3>code: {$r['code']}</h3>";
    echo "<h3>admin: {$r['useradmin']}</h3>";
    echo "<h3>max users: {$r['maxusers']}</h3>";
    echo "<h3>date created: {$r['date']}</h3>";
    echo "<p>{$r['test_desc']}</p><hr>";
    





}
foreach ($qres as $q)
{
    $qa = array();
    $qa['q'] = $q['question'];
    $qa['copt'] = $q['copt'];
    $qa['selected_opt'] = $_POST[$q['optid']];
    if($q['copt'] == $_POST[$q['optid']])
    {
        
        array_push($correct_api, $qa);
    }
    else
    {
        array_push($incorrect_api, $qa);
    }
    $total += 1;


}
$correct_counter = count($correct_api);
$incorrect_counter = count($incorrect_api);
$unanswered_counter = $total - ($correct_counter + $incorrect_counter);



$score = $correct_counter - $incorrect_counter;

$user = mysqli_query($con,"SELECT mark,tests FROM users_bank WHERE username = \"{$_COOKIE['username']}\"");
$mark = 0;
$tests = 0;
foreach($user as $m)
{
    $mark = $m['mark'];
    $tests = $m['tests'];
}

$mark = $mark + $score;
$tests++;
mysqli_query($con,
    "UPDATE users_bank SET mark = $mark where username = \"{$_COOKIE['username']}\""
);

mysqli_query($con,
    "UPDATE users_bank SET tests = $tests where username = \"{$_COOKIE['username']}\""
);


echo "<h1>تعداد کل سوالات:$total&emsp;&emsp;تعداد سوالات درست:$correct_counter&emsp;&emsp;تعداد سوالات اشتباه:$incorrect_counter&emsp;&emsp;تعداد سوالات بی پاسخ:$unanswered_counter</h1>";

echo "<br><br><h1>سوالات درست:</h1>";
foreach($correct_api as $i)
{
    echo "<b>".$i['q']."</b><br>";
    echo "گزینه درست:&emsp;".$i['copt']."<br>";
    echo "گزینه‌ای که شما انتخاب کرده اید:&emsp;".$i['selected_opt']."<br><br><br>";
    $sql = "INSERT INTO answerform(username,question,testid,copt,choosedopt) values(\"{$_COOKIE['username']}\",\"{$i['q']}\",\"{$test_id}\",\"{$i['copt']}\",\"{$i['selected_opt']}\")";
    mysqli_query($con,$sql);
}

echo "<br><br><h1>سوالات غلط:</h1>";
foreach($incorrect_api as $i)
{
    echo "<b>".$i['q']."</b><br>";
    echo "گزینه درست:&emsp;".$i['copt']."<br>";
    echo "گزینه‌ای که شما انتخاب کرده اید:&emsp;".$i['selected_opt']."<br><br><br>";
    $sql = "INSERT INTO answerform(username,question,testid,copt,choosedopt) values(\"{$_COOKIE['username']}\",\"{$i['q']}\",\"{$test_id}\",\"{$i['copt']}\",\"{$i['selected_opt']}\")";
    mysqli_query($con,$sql);
}

$cond = "$total/$correct_counter/$incorrect_counter";
$mysqlplt = "INSERT INTO reports(username,testid,cond) values(\"{$_COOKIE['username']}\",\"$test_id\",\"$cond\")";
mysqli_query($con,$mysqlplt);

echo "<button onclick='return_report()'>کارنامه</button>&emsp;<button onclick='Close(false)'>خانه</button>";
echo "<script src='../Js/Test.js'></script>";
    


?>
