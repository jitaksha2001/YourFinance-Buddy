<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $id=$_REQUEST['id'];    // UserID
    $sql_query = "SELECT * FROM budget WHERE UserID='".$id."' ORDER BY BudgetID ASC";
    $result = mysqli_query($con,$sql_query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-budget.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Budget</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="home.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="budget-title">Budgets</h1>
            </div>

            <a href="add-budget.php?id=<?php echo $id; ?>">
                <i class="fa-solid fa-circle-plus"></i>
            </a>
        </header>

        <section class="budget-library">
            <ul class="budgets-list">

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <a href="view-budget.php?id=<?php echo $row['BudgetID']; ?>">
                        <div class="budget-section">
                            <li class="list__item">
                                <p class="budget-name">
                                    <?php echo $row['Budget_Name']?>
                                </p>
                                <p class="spent">
                                    Spent: $<?php echo $row['Budget_CurrentAmount']?> / $<?php echo $row['Budget_Amount']?>
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