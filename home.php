<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_ID'])) {
    header('location: login.php');
}

$db = connect();
if ($db instanceof mysqli) {
} else {
  echo "Failed to connect";
}

$session_user = $_SESSION['user_ID'];
$sql_query = "SELECT * FROM user WHERE UserID='$session_user'"; 
$result = mysqli_query($db, $sql_query);
$row = mysqli_fetch_assoc($result);
$username = $row['User_Name'];
?>

<?php

if(isset($_POST['addReport']))
{
  $sql = "INSERT INTO REPORT (UserID, FilePath) VALUES ($session_user, 'C:/AppServ/www/CPSC-471/reports/report3.pdf')";
  $db->query($sql);
}

?>

<!DOCTYPE html>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="styles/home-style.css">
  <title>Home</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />;

</head>

<body>
  <div class="container">

    <div class="split-screen">
      <div class="sidebar">
        <form action="addTransaction.php" method="post">
          <h1 style="font-size: 25px">REPORT TRANSACTION</h1>
          <div class="button-container">
            <div><label for="amount">Amount</label><input id = "amount" pattern="^\d*(\.\d{0,2})?$" name="amount" style="Height: 50px; width:100%; font-size: 35px;"></div>
            <div><label for="name">Recipient/source</label><input type="text" name="name" id="name" style="Height: 50px; width:100%; font-size: 35px;"></div>
            <div>
            <input type="radio" id="income" name="type" value="I">
            <label for="income">Income</label>
          </div>
            <div>
            <input type="radio" id="expense" name="type" value="E">
            <label for="expense">Expense</label>
          </div>
          </div>


          <table style="width:100%; font-size: 20px;">
            <tr>
              <th>Category</th>
            </tr>
            <?php
                    $sql = "SELECT * FROM CATEGORY";

                    $results = $db->query($sql);
                    if ($results->num_rows > 0) {
                      foreach ($results as $result) {
                    ?>
            <tr>
              <td style="display:inline">
                <input type="checkbox" id=<?php echo $result['CategoryID']; ?> name="categories[]" value=<?php echo $result['CategoryID']; ?>>
                <label for=<?php echo $result['CategoryID']; ?>><?php echo $result['Name']; ?></label>
              </td>
            </tr>
            <?php
                      }
                    }
                          ?>

          </table>
          <label for="budgets">Choose a budget:</label>
            <select name="budget" id="budgets">
              <?php 
                $sql = "SELECT * FROM BUDGET WHERE UserID = $session_user";
                $results = $db->query($sql);
                if ($results->num_rows > 0) {
                  foreach ($results as $result) {
                ?>

              <option value=<?php echo $result["BudgetID"];?>><?php echo $result["Budget_Name"];?></option>
              <?php
                      }
                    }
                          ?>

              
            </select>
          <div class="button-container" style="display: inline-flex; justify-content: center; width: 100%">
            <input type="submit" value="submit" style="font-size:25px; height: 60px; width: 75%; margin: auto">
          </div>
        </form>

                    <form action="home.php" method="post">
                      <input type="submit" value="DEB: Next month" name="addReport" />
                  </form>

          <form action="logout.php" method="post">
        <input type="submit", name="backButton" value="logout" class="button material-symbols-outlined" style="font-size: 70px; background-color: #0f4c5c; margin: 35px; transform: rotate(180deg);">
        </form>

        

      </div>


      <div style="width:60%; height: 100%">
        <div style="background-color: #5f0f40; height: 140px; width: 500px; position: absolute; top: 10%; left: 50%; transform: translate(-50%, -50%); display: inline-block; justify-content: center; border-radius: 20px; text-align: center;">
                    <!--fetch the users balance-->
                    <?php
                    $sql = "SELECT Balance FROM USER WHERE UserID = $session_user";
                    $userBalance = $db->query($sql)->fetch_assoc()["Balance"];
                    echo "<h1 style='color: white;'>Welcome $username</h1>";
                    echo "<h1 style='color: white;'>Balance: $$userBalance</h1>";
                    ?>
        </div>
                    <div style="width:100%; display: inline-flex; justify-content: center; margin-top: 170px;">
                    <image src="styles/tree.png" alt="tree" height="450">
                  </div>

        <table
          style="background-color: white; height: 300px; width: 500px; position: absolute; top: 80%; left: 50%; transform: translate(-50%, -50%); ">
          <tr>
            <th>Reports</th>
          </tr>
          <?php
                      $sql = "SELECT * FROM REPORT WHERE UserID = $session_user";

                      $results = $db->query($sql);
                      if ($results->num_rows > 0) {
                        foreach ($results as $result) {
                          $name = $result['FilePath'];
                      ?>
          <tr>
            <td><a href=<?php echo $name ?>>
                <?php echo $result['FilePath']; ?>
              </a></td>
          </tr>
          <?php
                        }
                      }
                          ?>
        </table>

      </div>
      <div class="right" style="flex-grow: 1; display: flex; flex-direction: column; background-color: #e36414;">
        <div class="button-container" style="height: 100%">
          <div><a href="budget.php?id=<?php echo $row['UserID']; ?>"><button>Budgets</button></a></div>
          <div><a href="goal.php?id=<?php echo $row['UserID']; ?>"><button>Goals</button></a></div>
          <div><a href="income.php?id=<?php echo $row['UserID']; ?>"><button>Income History</button></a></div>
          <div><a href="expense.php?id=<?php echo $row['UserID']; ?>"><button>Expense History</button></a></div>      
          <div><a href="documents.php"><button>Documents</button></a></div>
          <div><a href="resource.php"><button>Resources</button></a></div>
          <div><a href="reminder.php?id=<?php echo $row['UserID']; ?>"><button>Reminders</button></a></div>

        </div>
      </div>



    </div>
  </div>
</body>

</html>