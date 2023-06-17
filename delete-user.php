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

if(isset($_POST['submit'])) {

    $deleteSQL="DELETE FROM user WHERE UserID='".$id."'";

    if($con->query($deleteSQL) === TRUE) {
        header('Location: admin.php');
    }
    else {
        echo "Error deleting user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-delete-user.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Delete User</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="view-user.php?id=<?php echo $row['UserID']; ?>">
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

            <section class="delete-container">
                <p>Are you sure you want to delete this user?</p>
                <div class="delete-user">
                    <i class="fa-regular fa-trash-can icon-gradient"></i>
                    <input type="submit" value="Delete User" name="submit" id="deleteuser"/>
                </div>
            </section>
        </form>

    </div>

</body>
</html>