<?php
require_once 'config.php';
session_start();


$currentUser = $_SESSION['user_ID'];


$db = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
if ($conn === false) {
  die("ERROR: Could not connect. "
    . mysqli_connect_error());
}
?>

<!--form processing-->
<?php

if(isset($_POST['removeTax']))
{
  if (!empty($_POST["taxDocs"])) {
    foreach ($_POST["taxDocs"] as $value) {
      $sql = "DELETE FROM TAX_DOCUMENT WHERE DocumentID=$value";
      $db->query($sql);
    }
  }
}

if(isset($_POST['removeRec']))
{
  if (!empty($_POST["recDocs"])) {
    foreach ($_POST["recDocs"] as $value) {
      $sql = "DELETE FROM RECEIPT_DOCUMENT WHERE DocumentID=$value";
      $db->query($sql);
    }
  }
}
?>


<!DOCTYPE html>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="styles/documents-style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
</head>

<body>

<header class="header">
            <a href="home.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="budget-title">Documents</h1>
            </div>
        </header>


  <div class="container">
    <form action="uploadDocument.php" method="post" entype="multipart/form-data">
      <div>
        <input type="radio" id="receipt" name="type" value="R">
        <label for="receipt">Receipt</label>
      </div>
      <div>
        <input type="radio" id="tax" name="type" value="T" checked="checked">
        <label for="tax">Tax</label>
      </div>

      <label for="fileToUpload">file path</label>
      <input type="text" id="fileToUpload" name="fileToUpload">

      <label for="fileType">file type</label>
      <input type="text" name="fileType" id="fileType">
      <input type="submit" value="submit" name="Add document">
    </form>

    <div style="display: inline-flex; width: 100%; height: 100%; ">

      <div style="width:30%; height: 100%; margin: 20px;">
        <h1>Tax documents</h1>
        <form action="documents.php" method="post">
          <table style="background-color: white; width: 100%;">
            <tr>
              <th>Date</th>
              <th>Type</th>
              <th>Path</th>
            </tr>
            <?php
          $sql = "SELECT * FROM TAX_DOCUMENT WHERE UserID = $currentUser ORDER BY Date DESC";

          $results = $db->query($sql);
          if ($results->num_rows > 0) {
            foreach ($results as $result) {
              $date = $result['Date'];
              $type = $result['Tax_Type'];
              $path = $result['FilePath'];
          ?>
            <tr>
              <td><input type="checkbox" value=<?php echo $result['DocumentID']; ?> name="taxDocs[]"></td>
              <td>
                <?php echo $date; ?>
              </td>
              <td>
                <?php echo $type; ?>
              </td>
              <td>
                <?php echo $path; ?>
              </td>
            </tr>
            <?php
            }
          }
          ?>
          </table>
          <input type="submit" value="Remove selected Tax Documents" name="removeTax" />
        </form>

      </div>

      <div style="width: 30%; margin: 20px; height: 100%;">
        <h1>Receipt documents</h1>
        <form action="documents.php" method="post">
        <table style="background-color: white; width: 100%">
          <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Path</th>
          </tr>
          <?php
          $sql = "SELECT * FROM RECEIPT_DOCUMENT WHERE UserID = $currentUser ORDER BY Date DESC";

          $results = $db->query($sql);
          if ($results->num_rows > 0) {
            foreach ($results as $result) {
              $date = $result['Date'];
              $type = $result['Receipt_Type'];
              $path = $result['FilePath'];
          ?>
          <tr>
          <td><input type="checkbox" value=<?php echo $result['DocumentID']; ?> name="recDocs[]"></td>
            <td>
              <?php echo $date; ?>
            </td>
            <td>
              <?php echo $type; ?>
            </td>
            <td>
              <?php echo $path; ?>
            </td>
          </tr>
          <?php
            }
          }
          ?>
        </table>
        <input type="submit" value="Remove selected Receipt Documents" name="removeRec" />
        </form>
      </div>
    </div>

  </div>
</body>

</html>

<?php
$db->close();
?>