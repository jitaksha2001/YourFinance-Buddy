<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $session_user=$_SESSION['user_ID']; // UserID
    $id=$_REQUEST['id'];                // transactionID

    $sql_query = "SELECT * FROM expense_transaction WHERE TransactionID='".$id."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_assoc($result);

    $sql_query_has = "SELECT * FROM has WHERE TransactionID='".$id."'";
    $result_has = mysqli_query($con,$sql_query_has);
    $row_has = mysqli_fetch_assoc($result_has);
    $category_id = $row_has['CategoryID'];

    $sql_query_category = "SELECT * FROM category WHERE CategoryID='".$category_id."'";
    $result_category = mysqli_query($con,$sql_query_category);
    $row_category = mysqli_fetch_assoc($result_category);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-view-transaction.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>View Expense</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="expense.php?id=<?php echo $session_user; ?>">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="transaction-name">
                    Expense | Recipient: <?php echo $row['Recipient']?>
                </h1>
                <p class="transaction-type">
                    Amount: -$<?php echo $row['Amount']?>
                </p>
            </div>
        </header>

        <section class="transaction-info">
            <div class="info-line">
                <i class="fa-regular fa-calendar icon-gradient"></i>
                <p class="transaction-date">Date:</p>
                <p class="transaction-date">
                    <?php echo $row['Date']?>
                </p>
            </div>

            <div class="info-line">
                <i class="fa-solid fa-tag icon-gradient"></i>
                <p class="transaction-t">Category:</p>
                <p class="transaction-t">
                    <?php echo $row_category['Name']?>
                </p>
            </div>
        </section>

    </div>

</body>
</html>