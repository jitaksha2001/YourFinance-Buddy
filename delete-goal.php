<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $session_user=$_SESSION['user_ID']; // UserID
    $id=$_REQUEST['id'];                // GoalID
    $sql_query = "SELECT * FROM goal WHERE GoalID='".$id."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST['submit'])) {
        $sql = "SELECT Amount_Collected FROM GOAL WHERE GoalID = $id";
        $sql2 = "SELECT Balance FROM USER WHERE UserID = $session_user";
        $newUserAmount = $con->query($sql)->fetch_assoc()["Amount_Collected"] + $con->query($sql2)->fetch_assoc()["Balance"];

        $deleteSQL = "DELETE FROM GOAL WHERE GoalID='".$id."'";

        if($con->query($deleteSQL) === TRUE) {
            $sql = "UPDATE USER SET Balance = $newUserAmount WHERE UserID = $session_user";
            $con->query($sql);
            $url = 'goal.php?id=' . urlencode($session_user);
            header('Location: ' . $url);
        }
        else {
            echo "Error deleting goal.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-delete-goal.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Delete Goal</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="edit-goal.php?id=<?php echo $id; ?>">
                    <i class="fa-regular fa-circle-left back-btn"></i>
                </a>

                <div class="header-info">
                    <h1 class="goal-name">
                        <?php echo $row['Goal_Name']?>
                    </h1>
                    <p class="progress">
                        Progress: $<?php echo $row['Amount_Collected']?>
                    </p>
                </div>
            </header>

            <section class="delete-container">
                <p>Are you sure you want to delete this goal?</p>
                <div class="delete-goal">
                    <i class="fa-regular fa-trash-can icon-gradient"></i>
                    <input type="submit" value="Delete Goal" name="submit" id="deletegoal"/>
                </div>
            </section>
        </form>

</body>
</html>