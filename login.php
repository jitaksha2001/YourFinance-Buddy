<?php

include "db_conn.php";
session_start();

if(isset($_POST['submit'])){

    $username = mysqli_real_escape_string($con,$_POST['uname']);
    $password = mysqli_real_escape_string($con,$_POST['pwd']);

    if ($username != "" && $password != ""){

        // Counting if there exists a user with matching username and password, if greater than 0, then user exists
        $sql_query_user = "select count(*) as cntUser from user where User_Name='".$username."' and User_Password='".$password."'";
        $result_user = mysqli_query($con,$sql_query_user);
        $row_user = mysqli_fetch_array($result_user);

        $sql_query_admin = "select count(*) as cntAdmin from admin where Admin_Name='".$username."' and Admin_Password='".$password."'";
        $result_admin = mysqli_query($con,$sql_query_admin);
        $row_admin = mysqli_fetch_array($result_admin);

        $count_user = $row_user['cntUser'];
        $count_admin = $row_admin['cntAdmin'];

        // Select userID/AdminID and store into $_SESSION
        $sql_query_user_id = "select UserID from user where User_Name='".$username."' and User_Password='".$password."'";
        $result_user_id = mysqli_query($con,$sql_query_user_id);
        $row_user_id = mysqli_fetch_array($result_user_id);

        $sql_query_admin_id = "select AdminID from admin where Admin_Name='".$username."' and Admin_Password='".$password."'";
        $result_admin_id = mysqli_query($con,$sql_query_admin_id);
        $row_admin_id = mysqli_fetch_array($result_admin_id);

        if($count_user > 0){
            // Storing userID into session variable
            $_SESSION['user_ID'] = $row_user_id['UserID'];
            header('Location: home.php');
        }
        else if($count_admin > 0) {
            // Storing adminID into session variable
            $_SESSION['admin_ID'] = $row_admin_id['AdminID'];
            header('Location: admin.php');
        }
        else{
            echo "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> Login </title>
    <link rel='stylesheet' href="styles/style-login.css">
</head>
<body>

    <div class="container">
        <form method="post" action="">
            <div class="login-box">
                <h1>LOGIN</h1>

                <label>Username <span class="req">*</span></label>
                <input type="text" class="textbox" name="uname" placeholder="Username"/>
                <label>Password <span class="req">*</label>
                <input type="password" class="textbox" name="pwd" placeholder="Password"/>

                <input type="submit" value="Log in" name="submit" id="submit"/>

                <p> New to YourFinance Buddy? <a href= "register.php"> Register Here</a></p>
            </div>
        </form>
    </div>

</body>
</html>