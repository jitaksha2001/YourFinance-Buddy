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
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-view-goal.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>View Goal</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="goal.php?id=<?php echo $session_user; ?>">
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
                <i id="dollar-sign" class="fa-solid fa-dollar-sign icon-gradient"></i>
                <p class="goal-amount">Amount:</p>
                <p class="goal-amount">
                    $<?php echo $row['Target_Amount']?>
                </p>
            </div>

            <div class="info-line">
                <i id="percent-sign" class="fa-solid fa-percent icon-gradient"></i>
                <p class="goal-percentage">Percentage:</p>
                <p class="goal-percentage">
                    <?php echo $row['Percentage']?>%
                </p>
            </div>
        </section>

        <section class="edit-goal">
            <a href="edit-goal.php?id=<?php echo $row['GoalID']; ?>">
                <div class="edit-button">
                    <i class="fa-solid fa-gear icon-gradient"></i>
                </div>
            </a>
        </section>

    </div>

</body>
</html>