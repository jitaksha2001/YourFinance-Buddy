<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $id=$_REQUEST['id'];    // UserID

    if(isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $date = trim($_POST['date']);   

        $isValid = true;

        //Check fields are empty or not
        if($name == '' || $date == '') {
            $isValid = false;
            echo "Please fill in all fields.";
        }

        if($isValid) {
            $updateSQL = "INSERT INTO reminder (Reminder_Name, Reminder_Date, UserID) VALUES ('".$name."', '".$date."', '".$id."')";

            if($con->query($updateSQL) === TRUE) {
                $url = 'reminder.php?id=' . urlencode($id);
                header('Location: ' . $url);
            }
            else {
                echo "Error updating reminder information.";
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
    <link rel="stylesheet" type="text/css" href="styles/style-add-reminder.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Edit Reminder</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="reminder.php?id=<?php echo $id; ?>">
                    <i class="fa-regular fa-circle-left back-btn"></i>
                </a>

                <div class="header-info">
                    <h1 class="reminder-name">Reminder Name</h1>
                    <p class="date">Date:</p>
                </div>
            </header>

            <section class="reminder-info">
                <div class="info-line">
                    <i class="fa-regular fa-heart icon-gradient"></i>
                    <p class="reminder-name">Reminder:</p>
                    <input type="text" class="type" name="name" placeholder="Reminder Name">
                </div>

                <div class="info-line">
                    <i class="fa-regular fa-calendar icon-gradient"></i>
                    <p class="reminder-date">Date:</p>
                    <input type="text" class="type" name="date" placeholder="YYYY-MM-DD">
                </div>
            </section>

            <section class="button-container">
                <div class="update-reminder">
                    <i class="fa-regular fa-circle-check icon-gradient"></i>
                    <input type="submit" value="Save Reminder" name="submit"/>
                </div>
            </section>
        </form>

    </div>

</body>
</html>