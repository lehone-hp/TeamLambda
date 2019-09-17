<?php
include('auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Team Lambda</title>
    <link rel="stylesheet" href="./css/landingpage.css">
</head>
<body>
    <div class="gradient-background"></div>
    <header class="landing-page__header">
        <img src="./assets/logo.png">
        <a href="logout.php">Sign out</a>
    </header>
    <section>
        <h1 class="landing-page__welcome-text">Welcome to Lambda <?php echo $_SESSION['email']; ?>!</h1>
        <button class="landing-page__get-started-button">GET STARTED</button>
    </section>
</body>
</html>