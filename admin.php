<?php
require 'db_conn.php';
session_start();

if (!isset($_SESSION['admin_ID'])) {
    header('location: login.php');
}
?>

<?php
    $sql_query = "SELECT * FROM user ORDER BY UserID ASC";
    $result = mysqli_query($con,$sql_query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-admin.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Admin</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket logout-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="user-title">Users</h1>
            </div>
        </header>

        <section class="user-library">
            <ul class="user-list">

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <a href="view-user.php?id=<?php echo $row['UserID']; ?>">
                        <div class="user-section">
                            <li class="list__item">
                                <p class="username">
                                    <?php echo $row['User_Name']?>
                                </p>
                                <p class="userID">
                                    User ID: <?php echo $row['UserID']?>
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