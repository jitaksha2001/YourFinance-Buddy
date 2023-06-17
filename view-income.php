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

    $sql_query = "SELECT * FROM income_transaction WHERE TransactionID='".$id."'";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-view-transaction.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>View Income</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="income.php?id=<?php echo $session_user; ?>">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="transaction-name">
                    Income | Source: <?php echo $row['Source']?>
                </h1>
                <p class="transaction-type">
                    Amount: +$<?php echo $row['Amount']?>
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
        </section>

    </div>

</body>
</html>