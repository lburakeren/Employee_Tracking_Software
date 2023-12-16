<?php
include "/var/www/html/GateBackend/dbconfig.php";

$employeeId = 825569; // Replace with your preferred method of getting employee ID
$endDate = date("Y-m-d");
$startDate = date("Y-m-d", strtotime("-30 days", strtotime($endDate)));

$query = "SELECT m.employee_id, e.first_name, e.last_name, 
                CONCAT(m.date, ' ', m.time) AS Giriş, 
                (
                    SELECT CONCAT(date, ' ', time) 
                    FROM movements 
                    WHERE employee_id = m.employee_id 
                        AND in_out = 'out' 
                        AND ((date = m.date AND time > m.time) OR date > m.date)
                    ORDER BY date ASC, time ASC
                    LIMIT 1
                ) AS Çıkış
          FROM movements AS m
          INNER JOIN employees AS e ON m.employee_id = e.employee_id
          WHERE m.employee_id = ? 
            AND m.in_out = 'in' 
            AND m.date BETWEEN ? AND ?";

$sql= $connection->prepare($query);
$sql->bind_param("iss", $employeeId, $startDate, $endDate);

$sql->execute();
$result = $sql->get_result();

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$connection->close();

header("Content-Type: application/json");
echo json_encode($data);
?>
