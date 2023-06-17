<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $id=$_REQUEST['id'];    // UserID
    $sql_query_expense = "SELECT * FROM expense_transaction WHERE UserID='".$id."' ORDER BY TransactionID ASC";
    $result_expense = mysqli_query($con,$sql_query_expense);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-transaction.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Income Expense</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="home.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>
            
            <div class="header-info">
                <h1 class="transaction-title">Expense History</h1>
            </div>
        </header>

        <section class="transaction-library">
            <ul class="transactions-list">

                <?php while($row = mysqli_fetch_assoc($result_expense)) { ?>

                <a href="view-expense.php?id=<?php echo $row['TransactionID']; ?>">
                    <div class="transaction-section">
                        <li class="list__item">
                            <p class="transaction-name">
                                Expense | Recipient: <?php echo $row['Recipient']?>
                            </p>
                            <p class="type">
                                Amount: -$<?php echo $row['Amount']?>
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