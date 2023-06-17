<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $id=$_REQUEST['id'];    // UserID
    $sql_query = "SELECT * FROM goal WHERE UserID='".$id."' ORDER BY GoalID ASC";
    $result = mysqli_query($con,$sql_query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-goal.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Goal</title>
</head>
<body>
    
    <div class="container">

        <header class="header">
            <a href="home.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="goal-title">Goals</h1>
            </div>

            <a href="add-goal.php?id=<?php echo $id; ?>">
                <i class="fa-solid fa-circle-plus"></i>
            </a>
        </header>

        <section class="goal-library">
            <ul class="goals-list">

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <a href="view-goal.php?id=<?php echo $row['GoalID']; ?>">
                        <div class="goal-section">
                            <li class="list__item">
                                <p class="goal-name">
                                    <?php echo $row['Goal_Name']?>
                                </p>
                                <p class="progress">
                                    Progress: $<?php echo $row['Amount_Collected']?> / $<?php echo $row['Target_Amount']?>
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