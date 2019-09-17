<?php 
/*Database Credentials*/
define('server', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'teamlambda');

// attempt to connect to database

$conn = mysqli_connect(server, username, password, database);

// check connection

if ($conn == false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>