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
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-view-reminder.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>View Reminder</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="reminder.php?id=<?php echo $session_user; ?>">
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

        <section class="edit-reminder">
            <a href="edit-reminder.php?id=<?php echo $row['ReminderID']; ?>">
                <div class="edit-button">
                    <i class="fa-solid fa-gear icon-gradient"></i>
                </div>
            </a>
        </section>

    </div>

</body>
</html>