<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$cardID = $_POST['card_id'];
$employeeID = $_POST['employee_id'];



$sql = $connection->prepare("INSERT INTO cards (card_id, employee_id) VALUES (?,?)");
$sql->bind_param("si", $cardID, $employeeID);

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