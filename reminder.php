<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $id=$_REQUEST['id'];    // UserID
    $sql_query = "SELECT * FROM reminder WHERE UserID='".$id."' ORDER BY ReminderID ASC";
    $result = mysqli_query($con,$sql_query);
?>

<!DOCTYPE html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-reminder.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Reminder</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="home.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="reminder-title">Reminders</h1>
            </div>

            <a href="add-reminder.php?id=<?php echo $id; ?>">
                <i class="fa-solid fa-circle-plus"></i>
            </a>
        </header>

        <section class="reminder-library">
            <ul class="reminders-list">

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <a href="view-reminder.php?id=<?php echo $row['ReminderID']; ?>">
                    <div class="reminder-section">
                        <li class="list__item">
                            <p class="reminder-name">
                                <?php echo $row['Reminder_Name']?>
                            </p>
                            <p class="date">
                                Date: <?php echo $row['Reminder_Date']?>
                            </p>
                        </li>
                    </div>
                </a>
                <hr>

                <?php } ?>

            </ul>
        </section>

    </div>

</body>
</html>