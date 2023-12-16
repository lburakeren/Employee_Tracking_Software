<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$result = $connection->query("SELECT 
reports.id ,reports.frequency , reports.time , reports.report_type , reports.email
FROM reports ORDER BY reports.id");

$data = array();


while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$connection->close();

header("Content-Type: application/json");
echo json_encode($data);

?>