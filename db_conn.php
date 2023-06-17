<?php
require_once 'config.php';
session_start();

$host = $DB_HOST;
$user = $DB_USERNAME;
$password = $DB_PASSWORD;
$db_name = $DB_NAME;

$con = mysqli_connect($host, $user, $password, $db_name);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}