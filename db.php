<?php


function connect() {
    require_once 'config.php';
    $db = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    if($db->connect_error) {
        die('cannot connect to database: \n'
        . $db->connect_error . "\n"
        . $db->connect_errno);
    }
    return $db;
}

