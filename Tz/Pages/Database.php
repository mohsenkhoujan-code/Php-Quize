<?php
$username = "root";
$password = "";
$hostname = "localhost";
$database = "testzors";
$con = "";
try
{
    $con = mysqli_connect($hostname,$username,$password,$database);
}
catch(mysqli_sql_exception)
{
    echo "connection failed";
}



?>