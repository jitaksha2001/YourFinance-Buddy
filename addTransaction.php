<?php
require_once 'db.php';
require_once 'config.php';

session_start();

$currentUser = $_SESSION['user_ID'];

$db = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}

$amount = $_POST["amount"];
$name = $_POST["name"];

$type = "";
if (isset($_POST["type"])) {
    $type = $_POST["type"];
} else {
    echo ("FAILED");
}

if ($type == "I") {
    updateGoals($db, $amount, $currentUser);

    $stmt = $db->prepare("INSERT INTO INCOME_TRANSACTION (Date, Amount, Source, UserID) VALUES (NOW(), ?, ?, ?)");
    $stmt->bind_param("dsi", $amount, $name, $currentUser);
    $stmt->execute();

} else if ($type == "E") {

    updateBudgets($db, $amount, $_POST["budget"]);

    $stmt = $db->prepare("INSERT INTO EXPENSE_TRANSACTION (Date, Amount, Recipient, UserID) VALUES (NOW(), ?, ?, ?)");
    $stmt->bind_param("dsi", $amount, $name, $currentUser);
    $stmt->execute();

    $sql = "SELECT Balance FROM USER WHERE UserID = $currentUser";
    $newAmount = $db->query($sql)->fetch_assoc()["Balance"] - $amount;

    $sql = "UPDATE USER SET Balance = $newAmount WHERE UserID = $currentUser";
    $db->query($sql);

    //deal with the categories
    if (!empty($_POST["categories"])) {
        foreach ($_POST["categories"] as $value) {
            echo $value;
            $sql = "SELECT TransactionID FROM EXPENSE_TRANSACTION WHERE UserID = $currentUser ORDER BY TransactionID DESC"; //fetch the most recent expense
            $transID = $db->query($sql)->fetch_assoc()["TransactionID"];
            $sql = "INSERT INTO HAS (CategoryID, TransactionID) VALUES ($value, $transID)";
            if (!mysqli_query($db, $sql)) {
                echo "<h1>something went wrong with the query" . mysqli_error($db) . "</h1>";
            }

        }
    }
}


//send the user back to the home page. This has the side benifit or forcing the page to refresh
$db->close();
header("Location: home.php");


function updateBudgets($db, $in_amount, $budgetID)
{
    $sql = "SELECT Budget_CurrentAmount FROM BUDGET WHERE BudgetID = $budgetID";
    $newAmount = $db->query($sql)->fetch_assoc()["Budget_CurrentAmount"] + $in_amount;
    $sql = "UPDATE BUDGET SET Budget_CurrentAmount = $newAmount  WHERE BudgetID = $budgetID";
    if (!mysqli_query($db, $sql)) {
        echo "<h1>something went wrong with the query" . mysqli_error($db) . "</h1>";
    }

}

function updateGoals($db, $in_amount, $currentUser)
{
    $amount = $in_amount;
    //get the total amount needed for next months budget
    $sql = "SELECT SUM(BUDGET_AMOUNT) FROM BUDGET WHERE UserID = $currentUser";
    $result = mysqli_query($db, $sql);
    $sql = "SELECT Balance FROM USER WHERE UserID = $currentUser";
    $userBalance = $db->query($sql)->fetch_assoc()["Balance"];
    
    //if there are budgets run some additional checks
    if (!is_null($result->fetch_assoc()["SUM(BUDGET_AMOUNT)"])) {
        $budgetOverhead = $result->fetch_assoc()["SUM(BUDGET_AMOUNT)"];
        
        //if even adding the income doesn't have enough money then return
        if ($userBalance + $amount <= $budgetOverhead) {
            $newUserB = $userBalance + $amount;
            $sql = "UPDATE USER SET Balance = $newUserB WHERE UserID = $currentUser";
            mysqli_query($db, $sql);
            return;
        }

        //if the user doesn't have enough money currently add enough to the users balance so it can cover the budget 
        if ($userBalance < $budgetOverhead) {
            $userBalance = $budgetOverhead;
            $amount = $amount + ($userBalance - $budgetOverhead);
            $sql = "UPDATE USER SET Balance = $userBalance WHERE UserID = $currentUser";
            mysqli_query($db, $sql);
        }

    }

    //update the goals according to priority and the percentage to go to each (I am being lazy with rounding here since this isn't a serious financial project)
    $newAmount = $amount; //newAmount stores the amount left over after all the goals have been updated
    $sql = "SELECT * FROM GOAL WHERE UserID = $currentUser";
    $result = mysqli_query($db, $sql);
    if ($result->num_rows > 0) { //if there is at least one goal
        while ($row = $result->fetch_assoc()) { //loop through each row in the table
            if ($row["Percentage"] <= 0) {
                continue;
            } //if the percentage of the goal is not acceptable skip this goal (avoid divide by 0)

            $amountToAdd = ($row["Percentage"] / 100) * $amount; //calculate how much to add to the goal
            $newAmount = $newAmount - $amountToAdd;

            //if there is enough money to achieve the goal add it to the users balance and delete the goal
            if ($row["Amount_Collected"] + $amountToAdd >= $row["Target_Amount"]) {
                $userBalance = $userBalance + $row["Amount_Collected"] + $amountToAdd;
                $goalID = $row["GoalID"];
                //update the users balance
                $sql = "UPDATE USER SET BALANCE = $userBalance WHERE UserID = $currentUser";
                if (!mysqli_query($db, $sql)) {
                    echo "<h1>something went wrong with the query" . mysqli_error($db) . "</h1>";
                }
                //delete the goal
                $sql = "DELETE FROM GOAL WHERE GoalID = $goalID";
                if (!mysqli_query($db, $sql)) {
                    echo "<h1>something went wrong with the query" . mysqli_error($db) . "</h1>";
                }
                //otherwise just update the goal amount
            } else {
                $newGoalAmount = $row["Amount_Collected"] + $amountToAdd;
                $goalID = $row["GoalID"];
                $sql = "UPDATE GOAL SET Amount_Collected = $newGoalAmount WHERE GoalID = $goalID";
                if (!mysqli_query($db, $sql)) {
                    echo "<h1>something went wrong with the query" . mysqli_error($db) . "</h1>";
                }
            }
        }
    }
            //add the remaining amount to the users balance
            $finalUserAmount = $userBalance + $newAmount;
            $sql = "UPDATE USER SET Balance = $finalUserAmount WHERE UserID = $currentUser";
            $db->query($sql);

    return;
}

?>