<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}


// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {

        $str = file_get_contents('users.json');
        $arr = json_decode($str, true);//decode it

        $existing_users = array_filter($arr['users'], function ($arr) use ($email, $password) {
            return ($arr['email'] == $email);
        });

        if (count($existing_users) > 0) {
            $user = reset($existing_users);

            if (password_verify($password, $user['password'])) {
                // Store data in session variables
                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $existing_users['firstname'];
                $_SESSION["email"] = $existing_users['email'];

                // Redirect user to welcome page
                header("location: welcome.php");
            } else {
                $password_err = "Incorrect Password.";
            }
        } else {
            $email_err = "No account found with that email.";
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
    <title>Team Lambda - Login</title>
    <link rel="icon" type="image/x-icon" href="assets/fevicon.png">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<header>
    <img src="assets/logo.png">
</header>
<section>
    <form role="form"
          action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
          ?>" method="post">

        <div class="gradient-background"></div>
        <h2 class="form__welcome-text">Welcome back!</h2>

        <input type="email"
               class="<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>"
               value="<?php echo $email; ?>"
               name="email"
               placeholder="Email Address">
        <p class="help-block"><?php echo $email_err; ?></p>

        <input type="password"
               class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"
               value="<?php echo $password; ?>"
               name="password"
               placeholder="Password">
        <p class="help-block"><?php echo $password_err; ?></p>

        <button type="submit">Sign in</button>
        <a class="forgot-password" href='#'>Forgot Password?</a>
        <p class="border-line"></p>
        <small>Don't have an account? <a href="register.php">Sign up</a></small>
    </form>
</section>
</body>
</html>