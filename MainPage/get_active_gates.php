<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


session_start();

if (isset($_SESSION['authenticated_gates']) && !empty($_SESSION['authenticated_gates'])) {
    $authenticatedGates = $_SESSION['authenticated_gates'];

    $gateIdList = implode(",", $authenticatedGates);

    $sql = $connection->prepare("SELECT gate_id, gate_name, gate_location FROM gates WHERE gate_id IN ($gateIdList)");
    $sql->execute();
    $result = $sql->get_result();

    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $connection->close();

    header("Content-Type: application/json");
    echo json_encode($data);
} else {
    
    $errorResponse = array('error' => 'No gates authenticated');
    header('Content-type: application/json');
    echo json_encode($errorResponse);
}


?>