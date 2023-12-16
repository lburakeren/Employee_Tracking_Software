<?php //include "/var/www/html/GateBackend/Login/login_authentication.php" ; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees Panel</title>

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
            <button onclick="goToPage(1)" id="pagination-button">İlk Sayfa</button>
            <button onclick="previousPage()" id="pagination-button">Önceki</button>
            <span id="page-info"></span>
            <button onclick="nextPage()" id="pagination-button">Sonraki</button>
            <button onclick="goToLastPage()" id="pagination-button">Son Sayfa</button>
        </div>
    </div>
    
    <div class="container"> 
        <table class="content-table">
            <thead>
            <tr>
                <th>Çalışan Id</th>
                <th>İsim</th>
                <th>Soyisim</th>
                <th>Departman</th>
                <th>Fotoğraf</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
        </table>
        
        
        <button id="addButton" onclick="addEmployee()">
            Yeni Çalışan Ekle
        </button>

        
        
    </div>

    </section>



    <script src="employee_script.js"></script>
    <script src="../CSS/sidebar_header_script.js"></script>



        
        

</body>

</html>


