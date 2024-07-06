<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login_db";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>