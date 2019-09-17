<?php 
include('db_connect.php');

session_start();

if (isset($_POST['register'])) {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($password) || strlen($password) < 8) {
        echo 'password must be at least 8 characters';
    }else{
        $password = md5($password);

    
        $user_check = "SELECT * from users where email = '$email'";
        $result = mysqli_query($conn, $user_check);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if ($user['email'] === $email) {
                echo "email already exists";
            }
        }else{
            $query = "INSERT into users (`firstname`, `lastname`, `email`, `password`) VALUES ('$firstname', '$lastname', '$email', '$password')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                header('location: login.php');
            }
        
        }
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
    <link rel="stylesheet" href="./css/register.css">
</head>
<body>
    <div class="gradient-background"></div>
    <header>
        <img src="./assets/logo.png">
    </header>
    <section>
        <form class="register-form" action="register.php" method="post">
            <h2 class="register-form__welcome-text">Create an account</h2>
            <input type="text" placeholder="First Name" name="firstname">
            <input type="text" placeholder="Last Name" name="lastname" >
            <input type="email" placeholder="Email Address" name="email">
            <input type="password" placeholder="Password" name="password">
            <p class="password-info">Make sure your password has at least 8 characters including at least one number and one uppercase letter</p>
            <button type="submit" name="register">Sign up</button>
            <p class="border-line"></p>
            <small>Already have an account? <a href="login.php">Sign in</a></small>
        </form>
    </section>
</body>
</html>