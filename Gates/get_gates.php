<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$result = $connection->query("SELECT 
gates.gate_id , gates.gatepassword , gates.gate_name , 
gates.gate_location 
FROM gates ORDER BY gates.id");

$data = array();


while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$connection->close();

header("Content-Type: application/json");
echo json_encode($data);

?>