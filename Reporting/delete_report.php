
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (isset($data['id'])) {
        $id = $data['id'];
        
        $sql = $connection->prepare("DELETE FROM reports WHERE id = ? ");
        $sql->bind_param("i", $id);
        $sql->execute();

        if ($sql->affected_rows > 0) {
            $response = array('success' => true);
            
        } else {
            $response = array('success' => false, 'error' => 'No matching report found');
            
        }
        
        $sql->close();

    } else {
        $response = array('success' => false, 'error' => 'Invalid or missing id');
        
    }
    
} else {

    $response = array('success' => false, 'error' => 'Invalid request method');
   
}


$connection->close();


header('Content-Type: application/json');
echo json_encode($response);


?>