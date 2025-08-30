<?php
include_once('libraris.php')

?>

<!-- Top Navigation Menu -->
<div class="phone">
    <a href="../index.php" class="active" id='nav'>خانه</a>
    <!-- Navigation links (hidden by default) -->
    <div id="myLinks">
        <a href="Pages/Blog.php" id='nav'>وبلاگ</a>
        <a href="Pages/Login.php" id='nav'>ورود</a>
        <a href="Pages/SingIn.php" id='nav'>ثبت نام</a>
        <?php
        echo ifndf_add_logout();
        ?>

    </div>
    <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>
<div class="desktop" id="desktop">
    <a href="Pages/Blog.php" id="blog">وبلاگ</a>&emsp;
    <a href="Pages/SingIn.php" id="sign-in">ثبت نام</a>&emsp;
    <a href="Pages/Login.php" id="login">ورود</a>&emsp;
    <a href="../index.php" id="home">خانه</a>&emsp;
    <?php
    echo ifndf_add_logout(false);
    ?>
</div>
<script>
    let res = document.getElementById("logout")
        console.log(res);
        if (res == null) {
            //}
            //catch{
            document.getElementById("desktop").style.textAlign = "center";
            document.getElementById("home").style.marginLeft = "20px";
            //document.getElementById("desktop").style.marginRight = "200px";
        }
</script>