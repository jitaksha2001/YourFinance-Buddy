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

    if(isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $amount = $_POST['amount'];   

        $isValid = true;

        //Check fields are empty or not
        if($name == '' || $amount == '') {
            $isValid = false;
            echo "Please fill in all fields.";
        }

        if($isValid) {
            $stmt = mysqli_prepare($con, "UPDATE budget SET Budget_Name=?, Budget_Amount=? WHERE BudgetID='" . $id . "'");
            mysqli_stmt_bind_param($stmt, "sd", $name, $amount);
            if(mysqli_execute($stmt) == TRUE) {
                $url = 'budget.php?id=' . urlencode($session_user);
                header('Location: ' . $url);
            }
            else {
                echo "Error updating budget information." . mysqli_stmt_errno($stmt);
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
    <link rel="stylesheet" type="text/css" href="styles/style-edit-budget.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Edit Budget</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="view-budget.php?id=<?php echo $id; ?>">
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
                    <i class="fa-regular fa-heart icon-gradient"></i>
                    <p class="budget-name">Budget:</p>
                    <input type="text" class="type" name="name" placeholder="Budget Name">
                </div>

                <div class="info-line">
                    <i id="dollar-sign" class="fa-solid fa-dollar-sign icon-gradient"></i>
                    <p class="budget-amount">Amount:</p>
                    <input pattern="^\d*(\.\d{0,2})?$" class="type" name="amount" placeholder="Budget Amount">
                </div>
            </section>

            <section class="button-container">
                <div class="update-budget">
                    <i class="fa-regular fa-circle-check icon-gradient"></i>
                    <input type="submit" value="Save Budget" name="submit"/>
                </div>
            </section>
        </form>

        <form method="post" action="delete-budget.php?id=<?php echo $row['BudgetID']; ?>">
            <section class="button-container">
                <div class="update-budget">
                    <i id="garbage-can" class="fa-regular fa-trash-can icon-gradient"></i>
                    <input type="submit" value="Delete Budget"/>
                </div>
            </section>
        </form>

    </div>

</body>
</html>