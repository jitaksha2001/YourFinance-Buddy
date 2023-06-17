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
        $amount = trim($_POST['amount']);
        $percentage = trim($_POST['percentage']);

        $isValid = true;

        //Check fields are empty or not
        if($name == '' || $amount == '' || $percentage == '') {
            $isValid = false;
            echo "Please fill in all fields.";
        }

        if($isValid) {
            $updateSQL = "INSERT INTO goal (Goal_Name, Target_Amount, Percentage, UserID) VALUES ('".$name."', '".$amount."', '".$percentage."', '".$id."')";

            if($con->query($updateSQL) === TRUE) {
                $url = 'goal.php?id=' . urlencode($id);
                header('Location: ' . $url);
            }
            else {
                echo "Error adding goal.";
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
    <link rel="stylesheet" type="text/css" href="styles/style-edit-goal.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Edit Goal</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="goal.php?id=<?php echo $id; ?>">
                    <i class="fa-regular fa-circle-left back-btn"></i>
                </a>

                <div class="header-info">
                    <h1 class="goal-name">Goal Name</h1>
                    <p class="progress">Progress:</p>
                </div>
            </header>

            <section class="goal-info">
                <div class="info-line">
                    <i class="fa-regular fa-heart icon-gradient"></i>
                    <p class="goal-name">Goal:</p>
                    <input type="text" class="type" name="name" placeholder="Goal Name">
                </div>

                <div class="info-line">
                    <i id="dollar-sign" class="fa-solid fa-dollar-sign icon-gradient"></i>
                    <p class="goal-amount">Amount:</p>
                    <input type="text" class="type" name="amount" placeholder="Goal Amount">
                </div>

                <div class="info-line">
                    <i id="percent-sign" class="fa-solid fa-percent icon-gradient"></i>
                    <p class="goal-percentage">Percentage:</p>
                    <input type="text" class="type" name="percentage" placeholder="Percentage">
                </div>
            </section>

            <section class="button-container">
                <div class="update-goal">
                    <i class="fa-regular fa-circle-check icon-gradient"></i>
                    <input type="submit" value="Save Goal" name="submit"/>
                </div>
            </section>
        </form>

    </div>

</body>
</html>