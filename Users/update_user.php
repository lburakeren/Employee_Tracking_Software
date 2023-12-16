
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'] ;

$stmt = $connection->prepare("UPDATE users SET
    username = ?,
    password = ?,
    first_name = ?,
    last_name = ?,
    email = ?
    WHERE id = ?");


$stmt->bind_param("sssssi", $username, $password,  $first_name, $last_name, $email, $id);

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
