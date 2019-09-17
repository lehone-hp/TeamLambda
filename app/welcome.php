<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Team Lambda - Welcome</title>
    <link rel="icon" type="image/x-icon" href="assets/fevicon.png">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<header>
    <img src="assets/logo.png">
    <div class="logout-block">
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <div class="page-header text-center">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to TeamLambda.</h1>

        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>

    </div>
</div>
</body>
</html>