<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $session_user=$_SESSION['user_ID']; // UserID
    $id=$_REQUEST['id'];                // ReminderID
    $sql_query = "SELECT * FROM reminder WHERE ReminderID='".$id."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST['submit'])) {
        $deleteSQL = "DELETE FROM reminder WHERE ReminderID='".$id."'";

        if($con->query($deleteSQL) === TRUE) {
            $url = 'reminder.php?id=' . urlencode($session_user);
            header('Location: ' . $url);
        }
        else {
            echo "Error deleting reminder.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-delete-reminder.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Delete Reminder</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="edit-reminder.php?id=<?php echo $id; ?>">
                    <i class="fa-regular fa-circle-left back-btn"></i>
                </a>

                <div class="header-info">
                    <h1 class="reminder-name">
                        <?php echo $row['Reminder_Name']?>
                    </h1>
                    <p class="date">
                        Date: <?php echo $row['Reminder_Date']?>
                    </p>
                </div>
            </header>

            <section class="delete-container">
                <p>Are you sure you want to delete this reminder?</p>
                <div class="delete-reminder">
                    <i class="fa-regular fa-trash-can icon-gradient"></i>
                    <input type="submit" value="Delete Reminder" name="submit" id="deletereminder"/>
                </div>
            </section>
        </form>

    </div>

</body>
</html>