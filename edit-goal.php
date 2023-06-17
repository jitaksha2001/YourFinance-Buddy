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
        $name = trim($_POST['name']);
        $amount = trim($_POST['amount']);
        $percentage = trim($_POST['percentage']);

        $isValid = true;

        //Check fields are empty or not
        if($name == '' || $amount == '' || $percentage == '') {
            $isValid = false;
            echo "Please fill in all fields.";
        }

        //check if the percentage is valid
        $sql = "SELECT * FROM GOAL WHERE UserID = $session_user AND GoalID != $id";
        $results = mysqli_query($con,$sql);
        $goalsum = 0;
        foreach($results as $result) {
        $goalsum = $goalsum + $result["Percentage"];
        }
        if($goalsum + $percentage > 100) {
             echo "ERROR: Can't have more than 100% of income going to goals!";
            $isValid = false;
        }

        if($isValid) {
            $sql = "SELECT * FROM GOAL WHERE GoalID = $id";
            $results = mysqli_query($con,$sql);
            $currentGoalAmount = $results->fetch_assoc()["Amount_Collected"];
            if($currentGoalAmount >= $amount) {
                $sql = "SELECT Balance FROM USER WHERE UserID = $session_user";
                $newUserBalance = $con->query($sql)->fetch_assoc()["Balance"] + $currentGoalAmount;
                $sql = "UPDATE USER SET BALANCE = $newUserBalance WHERE UserID = $session_user";
                $con->query($sql);
                $sql = "DELETE FROM GOAL WHERE GoalID = $id";
                $con->query($sql);
                header('Location: home.php');
            } else {

                $stmt = mysqli_prepare($con, "UPDATE goal SET Goal_Name=?, Target_Amount=?, Percentage=? WHERE GoalID='" . $id . "'");
                mysqli_stmt_bind_param($stmt, "sdi", $name, $amount, $percentage);
                if (mysqli_execute($stmt) == TRUE) {
                    $url = 'goal.php?id=' . urlencode($session_user);
                    header('Location: ' . $url);
                } else {
                    echo "Error updating goal information." . mysqli_stmt_error($stmt);
                }
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
                <a href="view-goal.php?id=<?php echo $id; ?>">
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

            <section class="goal-info">
                <div class="info-line">
                    <i class="fa-regular fa-heart icon-gradient"></i>
                    <p class="goal-name">Goal:</p>
                    <input type="text" class="type" name="name" placeholder="Goal Name">
                </div>

                <div class="info-line">
                    <i id="dollar-sign" class="fa-solid fa-dollar-sign icon-gradient"></i>
                    <p class="goal-amount">Amount:</p>
                    <input pattern="^\d*(\.\d{0,2})?$" class="type" name="amount" placeholder="Goal Amount">
                </div>

                <div class="info-line">
                    <i id="percent-sign" class="fa-solid fa-percent icon-gradient"></i>
                    <p class="goal-percentage">Percentage:</p>
                    <input type="text" maxlength="3" class="type" name="percentage" placeholder="Percentage">
                </div>
            </section>

            <section class="button-container">
                <div class="update-goal">
                    <i class="fa-regular fa-circle-check icon-gradient"></i>
                    <input type="submit" value="Save Goal" name="submit"/>
                </div>
            </section>
        </form>

        <form method="post" action="delete-goal.php?id=<?php echo $row['GoalID']; ?>">
            <section class="button-container">
                <div class="update-goal">
                    <i id="garbage-can" class="fa-regular fa-trash-can icon-gradient"></i>
                    <input type="submit" value="Delete Goal"/>
                </div>
            </section>
        </form>

    </div>

</body>
</html>