
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (isset($data['card_id'])) {
        $card_id = $data['card_id'];

        
        $sql = $connection->prepare("DELETE FROM cards WHERE card_id = ? ");
        $sql->bind_param("i", $card_id);
        $sql->execute();

        if ($sql->affected_rows > 0) {
            $response = array('success' => true);
            
        } else {
            $response = array('success' => false, 'error' => 'No matching card found');
            
        }
        
        $sql->close();

    } else {
        $response = array('success' => false, 'error' => 'Invalid or missing card_id');
        
    }
    
} else {

    $response = array('success' => false, 'error' => 'Invalid request method');
   
}


$connection->close();


header('Content-Type: application/json');
echo json_encode($response);


?>