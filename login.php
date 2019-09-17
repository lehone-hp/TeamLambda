<?php 
include('db_connect.php');

session_start();

$login_error = '';
if (isset($_POST['login'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $user_check = "SELECT * from users where email = '$email' and password = '$password'";
    $result = mysqli_query($conn, $user_check);
    $rows = mysqli_num_rows($result);
    if ($rows ==1) {
        $_SESSION['email'] = $email;
        header('location: index.php');
    }else{
        $login_error = "Invalid email or password";
    
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Team Lambda</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <img src="./assets/logo.png">
    </header>
    <section>
        <form class="login-form" action="login.php" method="post">
            <div class="gradient-background"></div>
            <h2 class="login-form__welcome-text">Welcome back!</h2>

            <p class="error_message"><?php echo "$login_error" ?></p>

            <input type="email" placeholder="Email Address" name = "email">
            <input type="password" placeholder="Password" name="password">
            <button type="submit" name='login'>Sign in</button>
            <a class="forgot-password" href='#'>Forgot Password?</a>
            <p class="border-line"></p>
            <small>Don't have an account? <a href="register.php">Sign up</a></small>
        </form>
    </section>
</body>
</html>