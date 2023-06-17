<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $session_user=$_SESSION['user_ID']; // UserID
    $id=$_REQUEST['id'];                // BudgetID
    $sql_query = "SELECT * FROM budget WHERE BudgetID='".$id."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-view-budget.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>View Budget</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="budget.php?id=<?php echo $session_user; ?>">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="budget-name">
                    <?php echo $row['Budget_Name']?>
                </h1>
                <p class="spent">
                    Spent: $<?php echo $row['Budget_CurrentAmount']?>
                </p>
            </div>
        </header>

        <section class="budget-info">
            <div class="info-line">
                <i id="dollar-sign" class="fa-solid fa-dollar-sign icon-gradient"></i>
                <p class="budget-amount">Amount:</p>
                <p class="budget-amount">
                    $<?php echo $row['Budget_Amount']?>
                </p>
            </div>
        </section>

        <section class="edit-budget">
            <a href="edit-budget.php?id=<?php echo $row['BudgetID']; ?>">
                <div class="edit-button">
                    <i class="fa-solid fa-gear icon-gradient"></i>
                </div>
            </a>
        </section>

    </div>

</body>
</html>