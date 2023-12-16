<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$result = $connection->query("SELECT users.id ,
users.username , users.password , users.first_name , 
users.last_name , users.email 
FROM users ORDER BY users.id");

$data = array();


while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$connection->close();

header("Content-Type: application/json");
echo json_encode($data);

?>