<?php
require_once 'config.php';

session_start();
$currentUser = 1;
if(isset($_SESSION['user_ID'])) {
    $currentUser = $_SESSION['user_ID'];
}

$db = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
if($conn === false){
    die("ERROR: Could not connect. "
    . mysqli_connect_error());
    }

    $type = $_POST["fileType"];
    $path = $_POST["fileToUpload"];
    $document = $_POST["type"];

    if($document == "R") {
    $stmt = $db->prepare("INSERT INTO RECEIPT_DOCUMENT (Date, Receipt_Type, UserID, FilePath) VALUES (NOW(), ?, ?, ?)");
    $stmt->bind_param("sis", $type, $currentUser, $path);
    $stmt->execute();
    } else {
        $stmt = $db->prepare("INSERT INTO TAX_DOCUMENT (Date, Tax_Type, UserID, FilePath) VALUES (NOW(), ?, ?, ?)");
        $stmt->bind_param("sis", $type, $currentUser, $path);
        $stmt->execute();
    }
    $db->close();
    header('location: documents.php');
?>

