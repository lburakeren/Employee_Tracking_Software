
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;



$old_card_id = $_POST['old_card_id'];
$cardId = $_POST['card_id'];
$employeeId = $_POST['employee_id'];


 

$stmt = $connection->prepare("UPDATE cards SET
    card_id = ?,
    employee_id = ?
    WHERE card_id = ?");


$stmt->bind_param("sis", $cardId , $employeeId, $old_card_id);

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
