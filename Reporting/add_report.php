<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$frequency = $_POST['frequency'];
$time = $_POST['time'];
$report_type = $_POST['report_type'];
$email = $_POST['email'];


$sql = $connection->prepare("INSERT INTO reports (frequency, time, report_type, email) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $frequency, $time, $report_type,$email);

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