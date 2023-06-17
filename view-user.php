<?php
require 'db_conn.php';
session_start();

if (!isset($_SESSION['admin_ID'])) {
    header('location: login.php');
}
?>

<?php
$id=$_REQUEST['id'];    // UserID
$sql_query = "SELECT * FROM user WHERE UserID='".$id."'"; 
$result = mysqli_query($con, $sql_query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-view-user.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>View User</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="admin.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="username">
                    <?php echo $row['User_Name']?>
                </h1>
                <p class="userID">
                    User ID: <?php echo $row['UserID']?>
                </p>
            </div>
        </header>

        <section class="user-info">
            <div class="info-line">
                <i class="fa-solid fa-lock icon-gradient"></i>
                <p class="password">Password:</p>
                <p class="password">
                    <?php echo $row['User_Password']?>
                </p>
            </div>

            <div class="info-line">
                <i class="fa-regular fa-at icon-gradient"></i>
                <p class="user-email">Email:</p>
                <p class="user-email">
                    <?php echo $row['User_Email']?>
                </p>
            </div>

             <div class="info-line">
                <i id="scale-icon" class="fa-solid fa-scale-balanced icon-gradient"></i>
                <p class="balance">Balance:</p>
                <p class="balance">
                    $<?php echo $row['Balance']?>
                </p>
            </div>

        </section>

        <section class="edit-user">
            <a href="edit-user.php?id=<?php echo $row['UserID']; ?>">
                <div class="edit-button">
                    <i class="fa-solid fa-gear icon-gradient"></i>
                </div>
            </a>
        </section>

    </div>


</body>
</html>