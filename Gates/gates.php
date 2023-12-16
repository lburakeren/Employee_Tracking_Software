<?php include "/var/www/html/GateBackend/Login/login_authentication.php" ; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gates Panel</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="../CSS/sidebar_header_table.css">

</head>


<body>
        
    

    <?php
    include('../CSS/sidebar_header.php');
    ?>

    <section id="main">
    <div class="container">
        
        <table class="content-table">
            <thead>
            <tr>
                <th>Kapı Id</th>
                <th>Kapı Şifre</th>
                <th>Şube</th>
                <th>Adres</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
        </table>
        
        
        <button id="addButton" onclick="addGate()">
            Yeni Kapı Ekle
        </button>
        
    </div>

    </section>


    <script src="gate_script.js"></script>
    <script src="../CSS/sidebar_header_script.js"></script>

</body>
</html>