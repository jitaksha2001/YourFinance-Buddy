<?php
include "db_conn.php";
?>

<?php

//Register User
if(isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);

    $isValid = true;

    //Check fields are empty or not
    if($email == '' || $username == ''|| $password == '' || $confirmpassword == '') {
        $isValid = false;
        echo "Please fill in all fields.";
    }
    
    // Check if confirm password matching or not
    if($isValid && ($password != $confirmpassword)) {
        $isValid = false;
        echo "Password and Confirm Password does not match.";
    }

    // Check if Email is valid or not
    if($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        echo "Invalid Email.";
    }

    if($isValid) {

        // Check if Email already exists
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

    // Insert Records if passes everything
    if($isValid) {
        $insertSQL = "INSERT INTO user (User_Email, User_Name, User_Password) VALUES (?,?,?)";
		$sql_email_query = $con->prepare($insertSQL);
		$sql_email_query->bind_param("sss", $email, $username, $password);
		$sql_email_query->execute();
		$sql_email_query->close();

		echo "Account created successfully.";
        header('Location: login.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> Registration </title>
    <link rel='stylesheet' href="styles/style-register.css">
</head>
<body>

    <div class="container">
        <form method="post" action="">
            <div class="register-box">
                <h1>REGISTER</h1>

                <label>Email <span class="req">*</label>
                <input type="text" class="textbox" name="email" placeholder="Email"/>

                <label>Username <span class="req">*</label>
                <input type="text" class="textbox" name="username" placeholder="Username"/>

                <label>Password <span class="req">*</span></label>
                <input type="password" class="textbox" name="password" placeholder="Password"/>

                <label>Confirm Password <span class="req">*</label>
                <input type="password" class="textbox" name="confirmpassword" placeholder="Confirm Password"/>

                <input type="submit" value="Sign Up" name="submit" id="signup"/>

                <p>Already a member? <a href= "login.php"> Login here! </a></p>
            </div>
        </form>
    </div>

</body>
</html>