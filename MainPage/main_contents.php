<?php

$sql = "SELECT COUNT(*) as total_employees FROM employees";
$result = $connection->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $total_employees = $row['total_employees'];
} else {
    $total_employees = 0 ;
}

$sql2 = "SELECT COUNT(*) as total_cards FROM cards";
$result2 = $connection->query($sql2);

if ($result2) {
    $row2 = $result2->fetch_assoc();
    $total_cards = $row2['total_cards'];
} else {
    $total_cards = 0 ;
}

$sql3 = "SELECT COUNT(*) as total_gates FROM gates";
$result3 = $connection->query($sql3);

if ($result3) {
    $row3 = $result3->fetch_assoc();
    $total_gates = $row3['total_gates'];
} else {
    $total_gates = 0 ;
}

$result->close();
$result2->close();
$result3->close();
$connection->close();

?>


<section id="sidebar">
        <a href="#" class="brand"> 
            <img src="/GateBackend/brand.jpg" alt="BrandImage" width="60px;">
            <span class="text">Personel Takip Sistemi</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="/GateBackend/MainPage/main_page.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Anasayfa</span>
                </a>
            </li>
            <li>
                <a href="/GateBackend/Users/users.php">
                    <i class='bx bxs-user-account'></i>
                    <span class="text">Kullanıcılar</span>
                </a>
            </li>
            <li>
                <a href="/GateBackend/Employees/employees.php">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Çalışanlar</span>
                </a>
            </li>
            <li>
                <a href="/GateBackend/Cards/cards.php">
                    <i class='bx bxs-id-card'></i>
                    <span class="text">Kartlar</span>
                </a>
            </li>
            <li>
                <a href="/GateBackend/Movements/movements.php">
                    <i class='bx bx-shape-circle'></i>
                    <span class="text">Giriş Çıkışlar</span>
                </a>
            </li>
            <li>
                <a href="/GateBackend/Gates/gates.php">
                    <i class='bx bxs-door-open'></i>
                    <span class="text">Kapılar</span>
                </a>
            </li>
            <li>
                <a href="/GateBackend/Reporting/reports.php">
                    <i class='bx bxs-report'></i>
                    <span class="text">Raporlar</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#" class="logout" onclick="confirmLogout()">
                    <i class='bx bxs-log-out'></i>
                    <span class="text">Çıkış</span>
                </a>
            </li>
        </ul>
    </section>


    <section id="content">
        
        <nav>
            <i class="bx bx-menu"></i>
            <a href="#" class="nav-link">Kategoriler</a>
        </nav>

        <main>
			
			<ul class="box-info">
				<li>
					<i class='bx bx-user-pin' ></i>
					<span class="text">
						<h3><?php echo $total_employees; ?></h3>
						<p>Çalışan</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-id-card' ></i>
					<span class="text">
						<h3><?php echo $total_cards; ?></h3>
						<p>Kart</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-door-open' ></i>
					<span class="text">
						<h3><?php echo $total_gates; ?></h3>
						<p>Kapı</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Aktif Kapılar</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Kapı ID</th>
								<th>Kapı Şube</th>
								<th>Kapı Adres</th>
							</tr>
						</thead>
						<tbody id="table-body">
						</tbody>
					</table>
				</div>
                
			</div>
		</main>


 
    </section>