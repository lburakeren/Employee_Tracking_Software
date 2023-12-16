<?php include "/var/www/html/GateBackend/Login/login_authentication.php" ; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movements Panel</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="stylesheet" href="../CSS/sidebar_header_table.css">

</head>


<body>
        
    

    <?php
    include('../CSS/sidebar_header.php');
    ?>

    <section id="main">

    <div class="table-controls">
        <!-- Search input and label -->
        <div class="search-container">
            <i class='bx bx-search-alt-2'></i>
            <input type="text" id="search" onkeyup="searchTable()" placeholder="Aramak için yazın..." class="search-input">
        </div>


        <!-- Pagination buttons -->
        <div class="pagination-buttons">
            <button onclick="goToPage(1)" id="pagination-button"><<</button>
            <button onclick="previousPage()" id="pagination-button"><</button>
            <span id="page-info"></span>
            <button onclick="nextPage()" id="pagination-button">></button>
            <button onclick="goToLastPage()" id="pagination-button">>></button>
        </div>
    </div>


    <div class="container">
        
        <table class="content-table">
            <thead>
            <tr>
                <th>Çalışan ID</th>
                <th>İsim</th>
                <th>Soyisim</th>
                <th>Departman</th>
                <th>Şube</th>
                <th>Adres</th>
                <th>Giriş-Çıkış</th>
                <th>Tarih</th>
                <th>Zaman</th>
            </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
        </table>   
    </div>

    </section>



    
    <script src="movements_script.js"></script>
    <script src="../CSS/sidebar_header_script.js"></script>

</body>
</html>

