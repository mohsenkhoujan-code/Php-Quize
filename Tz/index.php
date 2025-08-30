<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style-lingard.css">
    <link rel="stylesheet" href="CSS/fonts-Impl.css">
    <link rel="stylesheet" href="CSS/media-queries.css">
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/style-lingard.scss">

</head>

<body id="index-body">
    <?php
    include_once("Pages/Header.php")
    ?>
    <div class="container" id="con">
        <a href="Pages/MakingTest.php"><button id="create-test">ایجاد آزمون</button></a><br>
        <form action="index.php" method="post">
            <input type="text" name="code" id="code" placeholder="کد آزمون را وارد کنید"><br>
            <input type="submit" value="ورود به آزمون" id="enter-test" name="clos"><br>
        </form>
        <a href="Pages/Reports.php"><button id="reports">کارنامه</button></a><br>
        <a href="Pages/ScoreTable.php"><button id="scoreTable">جدول امتیازات</button></a>
    </div>
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <script src="Js/java-script-formulation.js">

    </script>
</body>

</html>



<?php
session_start();
if (isset($_POST['clos'])) {
    $_SESSION['can-test'] = "isset";
    $_SESSION['code'] = $_POST['code'];
    header("Location: Pages/Test.php");
}

if (isset($_GET['popup'])) {
    echo "<script>alert('به تست زورس خوش‌آمدید');window.location.href='index.php'</script>";
}

if (isset($_GET['popup2'])) {
    echo "<script>alert('آزمون شما با موققیت ایجاد شد.');window.location.href='index.php'</script>";
}
if (isset($_GET['logout'])) {
    if (isset($_COOKIE['username'])) {
        setcookie('username', '', time() - 3600, "/");
        echo "<script>alert('از حساب خودتان خارج شدید');window.location.href='index.php'</script>";
        exit();
    }
}

?>