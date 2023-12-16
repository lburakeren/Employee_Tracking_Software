
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;

$old_gateID = $_POST['old_gate_id'];
$gateId = $_POST['gate_id'];
$gatePassword = $_POST['gatepassword'];
$gateName = $_POST['gate_name'];
$gateLocation = $_POST['gate_location'];

$stmt = $connection->prepare("UPDATE gates SET
    gate_id = ?,
    gatepassword = ?,
    gate_name = ?,
    gate_location = ?
    WHERE gate_id = ?");


$stmt->bind_param("isssi", $gateId, $gatePassword,  $gateName, $gateLocation, $old_gateID);

if ($stmt->execute()) {
    $response = array('success' => true);
} else {
    $response = array('success' => false, 'error' => 'Database update failed');
}

$stmt->close();
$connection->close();

header('Content-Type: application/json');
echo json_encode($response);



?>
