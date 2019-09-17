<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}


// Define variables and initialize with empty values
$f_name = $l_name = $email = $password = "";
$f_name_err = $l_name_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["f_name"]))) {
        $f_name_err = "Please enter first name.";
    } else {
        $f_name = trim($_POST["f_name"]);
    }

    // Check if email is empty
    if (empty(trim($_POST["l_name"]))) {
        $l_name_err  = "Please enter last name..";
    } else {
        $l_name = trim($_POST["l_name"]);
    }

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
    if (empty($f_name_err) && empty($l_name_err) &&
        empty($email_err) && empty($password_err)) {

        //get contents of your json file and store it in a string
        $str = file_get_contents('users.json');
        $arr = json_decode($str, true);//decode it

        $existing_users = array_filter($arr['users'], function ($arr) use ($email) {
            return ($arr['email'] == $email);
        });

        if (count($existing_users) > 0) {
            $email_err = "A user already exist with this email.";
        } else {

            $arrne['firstname'] = $f_name;
            $arrne['lastname'] = $l_name;
            $arrne['email'] = $email;
            $arrne['password'] = password_hash($password, PASSWORD_DEFAULT);
            array_push($arr['users'], $arrne);//push contents to ur decoded array i.e $arr
            $str = json_encode($arr);

            //now send evrything to ur data.json file using following code
            if (json_decode($str) != null) {
                $file = fopen('users.json', 'w') or die("Unable to open file!");;
                fwrite($file, $str);
                fclose($file);

                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $f_name;
                $_SESSION["email"] = $email;

                // Redirect user to welcome page
                header("location: welcome.php");
            } else {
                //  invalid JSON, handle the error
                echo('err');
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
    <title>Team Lambda - Sign Up</title>
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
        <h2 class="form__welcome-text">Create an account</h2>

        <input type="text"
               class="<?php echo (!empty($f_name_err)) ? 'has-error' : ''; ?>"
               value="<?php echo $f_name; ?>"
               name="f_name"
               placeholder="First Name">
        <p class="help-block"><?php echo $f_name_err; ?></p>

        <input type="text"
               class="<?php echo (!empty($l_name_err)) ? 'has-error' : ''; ?>"
               value="<?php echo $l_name; ?>"
               name="l_name"
               placeholder="Last Name">
        <p class="help-block"><?php echo $l_name_err; ?></p>

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

        <button type="submit">Sign Up</button>

        <p class="border-line"></p>
        <small>Already have an account? <a href="login.php">Sign in</a></small>
    </form>
</section>
</body>
</html>