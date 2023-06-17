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
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);    

    $isValid = true;

    //Check fields are empty or not
    if($email == '' || $username == ''|| $password == '') {
        $isValid = false;
        echo "Please fill in all fields.";
    }

    // Check if Email is valid or not
    if($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        echo "Invalid Email.";
    }

    // Check if Email already exists
    if($isValid) {
        $sql_email_query = $con->prepare("SELECT * FROM user WHERE User_Email = ?");
		$sql_email_query->bind_param("s", $email);
		$sql_email_query->execute();
		$result = $sql_email_query->get_result();
		$sql_email_query->close();
		if($result->num_rows > 0){
			$isValid = false;
			echo "Email already exists.";
		}
    }

    if($isValid) {
        $updateSQL="UPDATE user SET User_Name='".$username."', User_Email='".$email."', User_Password='".$password."' WHERE UserID='".$id."'";

        if($con->query($updateSQL) === TRUE) {
            header('Location: admin.php');
        }
        else {
            echo "Error updating user information.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-edit-user.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Edit User</title>
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

            <section class="user-info">
                <div class="info-line">
                    <i class="fa-regular fa-user icon-gradient"></i>
                    <p class="username">Username:</p>
                    <input type="text" class="type" name="username" placeholder="Username"/>
                </div>

                <div class="info-line">
                    <i class="fa-solid fa-lock icon-gradient"></i>
                    <p class="password">Password:</p>
                    <input type="text" class="type" name="password" placeholder="User Password"/>
                </div>

                <div class="info-line">
                    <i class="fa-regular fa-at icon-gradient"></i>
                    <p class="user-email">Email:</p>
                    <input type="text" class="type" name="email" placeholder="User Email"/>
                </div>

            </section>

            <section class="button-container">
                <div class="update-user">
                    <i class="fa-regular fa-circle-check icon-gradient"></i>
                    <input type="submit" value="Save User" name="submit"/>
                </div>
            </section>
        </form>

        <form method="post" action="delete-user.php?id=<?php echo $row['UserID']; ?>">
            <section class="button-container">
                <div class="update-user">
                    <i id="garbage-can" class="fa-regular fa-trash-can icon-gradient"></i>
                    <input type="submit" value="Delete User"/>
                </div>
            </section>
        </form>

    <div>

</body>
</html>