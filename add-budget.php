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

        $isValid = true;

        //Check fields are empty or not
        if($name == '' || $amount == '') {
            $isValid = false;
            echo "Please fill in all fields.";
        }

        if($isValid) {
            $updateSQL = "INSERT INTO budget (Budget_Name, Budget_Amount, UserID) VALUES ('".$name."','".$amount."', '".$id."')";

            if($con->query($updateSQL) === TRUE) {
                $url = 'budget.php?id=' . urlencode($id);
                header('Location: ' . $url);
            }
            else {
                echo "Error adding budget.";
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
    <link rel="stylesheet" type="text/css" href="styles/style-add-budget.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Edit Budget</title>
</head>
<body>

    <div class="container">

        <form method="post" action="">
            <header class="header">
                <a href="budget.php?id=<?php echo $id; ?>">
                    <i class="fa-regular fa-circle-left back-btn"></i>
                </a>

                <div class="header-info">
                    <h1 class="budget-name">Budget Name</h1>
                    <p class="spent">Spent:</p>
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
                    <input type="text" class="type" name="amount" placeholder="Budget Amount">
                </div>
            </section>

            <section class="button-container">
                <div class="update-budget">
                    <i class="fa-regular fa-circle-check icon-gradient"></i>
                    <input type="submit" value="Save Budget" name="submit" />
                </div>
            </section>
        </form>

    </div>

</body>
</html>