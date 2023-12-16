<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$gateId = $_POST['gate_id'];
$gatePassword = $_POST['gatepassword'];
$gateName = $_POST['gate_name'];
$gateLocation = $_POST['gate_location'];


$sql = $connection->prepare("INSERT INTO gates (gate_id, gatepassword, gate_name, gate_location) VALUES (?, ?, ?, ?)");
$sql->bind_param("isss", $gateId, $gatePassword, $gateName,$gateLocation);

if ($sql->execute()) {
    $response = array('success' => true, 'message' => 'Data saved successfully');
} else {
    $response = array('success' => false, 'message' => 'Failed to save data');
}

$sql->close();
$connection->close();


header('Content-Type: application/json');
echo json_encode($response);


?>