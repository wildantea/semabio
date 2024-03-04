<?php
session_start();
if (!isset($_SESSION['login'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>Seminar Nasional Pertanian 2021</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="assets/login/css/login.css" media="all" rel="stylesheet" type="text/css">  
    <script src="assets/dist/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/login/js/shake.js"></script>
    <script src="assets/login/js/login.js"></script>

<style type="text/css">
body {
  background: url("assets/oriental.png");
}
.forget {
    text-align: center;
}
.forget a {
    color: #ffffff;
}
</style>
</head>
<body>
    <!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <div class="container">
        <div class="card-top card-container-top">
        Seminar Nasional Pertanian 2021
        </div>
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="assets/uin.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin">
                
                <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" id="password" class="form-control" placeholder="Password" required>

                <button class="btn btn-lg btn-login" id="login" type="submit">SIGN IN</button>
                <div class='invalid' style="display: none"></div>

            <div class="forget"><a href="../forgot_password.php">Forgot Password ?</a></div>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
        <script src="assets/login/js/jquery.backstretch.min.js" type="text/javascript"></script>
</html>
<?php
} else {
  header("location:index.php/");
}
?>