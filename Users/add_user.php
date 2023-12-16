<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

$sql = $connection->prepare("INSERT INTO users (username, password , first_name , last_name , email) VALUES (?, ?, ?, ?,?)");
$sql->bind_param("sssss", $username, $password, $first_name,$last_name,$email);

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