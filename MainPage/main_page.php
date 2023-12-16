<?php include "/var/www/html/GateBackend/Login/login_authentication.php" ; ?>
<?php include "/var/www/html/GateBackend/dbconfig.php" ; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="../CSS/sidebar_header_table.css">

    <link rel="stylesheet" href="mainpage.css">

</head>

<body>
        
    <?php
    include('main_contents.php');
    ?>


    <script src="mainpage_script.js"></script>
    <script src="../CSS/sidebar_header_script.js"></script>

</body>
</html>