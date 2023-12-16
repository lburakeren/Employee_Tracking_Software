
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;



$result = $connection->query("SELECT 
c.card_id,c.employee_id,e.first_name,e.last_name
FROM 
    cards c 
INNER JOIN 
    employees e ON c.employee_id = e.employee_id 
ORDER BY c.id");



$data = array();


while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$connection->close();

header("Content-Type: application/json");
echo json_encode($data);

?>