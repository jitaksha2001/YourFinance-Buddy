<?php
    require 'db_conn.php';
    session_start();

    if (!isset($_SESSION['user_ID'])) {
        header('location: login.php');
    }
?>

<?php
    $sql_query = "SELECT * FROM help_resource";
    $result = mysqli_query($con,$sql_query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-resource.css">
    <script src="https://kit.fontawesome.com/a9102329df.js" crossorigin="anonymous"></script>
    <title>Resources</title>
</head>
<body>

    <div class="container">

        <header class="header">
            <a href="home.php">
                <i class="fa-regular fa-circle-left back-btn"></i>
            </a>

            <div class="header-info">
                <h1 class="resource-title">Resources</h1>
            </div>
        </header>

        <section class="resource-library">
            <ul class="resource-list">

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <a href="<?php echo $row['Link']; ?>">
                        <div class="resource-section">
                            <li class="list__item">
                                <p class="resource-name"><?php echo $row['Name']; ?></p>
                                <p class="resource-description"><?php echo $row['Description']; ?></p>
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