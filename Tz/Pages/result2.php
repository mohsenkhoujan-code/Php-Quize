<?php

include('Database.php');


if(isset($_POST['code']))
{
    $test_id = $_POST['code'];


    $test_res = mysqli_query($con,
        "SELECT * FROM tests_bank WHERE code = \"$test_id\""
    );

    $desc = "";
    foreach($test_res as $t)
    {
        echo "<h1>{$t['name']}</h1>";
        echo "<h3>code: {$t['code']}</h3>";
        echo "<h3>admin: {$t['useradmin']}</h3>";
        echo "<h3>max users: {$t['maxusers']}</h3>";
        echo "<h3>time: {$t['time']}</h3>";
        echo "<h3>date: {$t['date']}</h3>";
        $desc = $t['test_desc'];
        echo "<hr>";
    }
    

    $sql = "SELECT * FROM answerform WHERE username=\"{$_COOKIE['username']}\" AND testid=\"{$test_id}\"";
    $ares = mysqli_query($con, $sql);

    $c_api = array();
    $inc_api = array();
    foreach($ares as $as)
    {
        $api = array();
        $api['q'] = $as['question'];
        $api['copt'] = $as['copt'];
        $api['selectedopt'] = $as['choosedopt'];
        if($as['copt'] == $as['choosedopt'])
        {
            array_push($c_api, $api);
        }
        else
        {
            array_push($inc_api, $api);
        }
    }
    
    echo "<h1>سوالات درست:</h1>";
    echo "<div style='color:green'>";
    foreach($c_api as $i)
    {
        echo "<h3>{$i['q']}</h3>";
        echo "<h4>گزینه درست:&emsp;{$i['copt']}</h4>";    
        echo "<h4>گزینه‌ای که شما انتخاب کرده اید:&emsp;{$i['selectedopt']}</h4>";
        echo "<br><br><br>";    
    }
    echo "</div>";
    
    echo "<br><h1>سوالات نادرست:</h1>";
    echo "<div style='color:red'>";
    foreach($inc_api as $i)
    {
        echo "<h3>{$i['q']}</h3>";
        echo "<h4>گزینه درست:&emsp;{$i['copt']}</h4>";    
        echo "<h4>گزینه‌ای که شما انتخاب کرده اید:&emsp;{$i['selectedopt']}</h4>";
        echo "<br><br><br>";    
    }
    echo "</div>";
    echo "<hr>";
    echo "<p>$desc</p>";
    echo "<br><br>";
    echo "<button onclick='return_report()'>کارنامه</button>&emsp;<button onclick='Close(false)'>خانه</button>";
    echo "<script src='../Js/Test.js'></script>";
    
    
}


?>
