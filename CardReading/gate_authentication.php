<?php

    include "/var/www/html/GateBackend/dbconfig.php" ;
    
    // json to data converting
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if ($data === null) {
        $response = array('error' => 'Invalid JSON data');
    } else {
        
        $gateid = $data['gateid'];
        $gatepassword = $data['gatepassword'];

            
        $sql = $connection->prepare("SELECT * FROM gates WHERE gate_id = ? AND gatepassword = ?");
        $sql->bind_param("is", $gateid, $gatepassword);
        $sql->execute();
        $result = $sql->get_result();

            
        if ($result->num_rows > 0) {
            
            $response = array('authentication' => true);

            
            session_start();
            
            if (!isset($_SESSION['authenticated_gates'])) {
                $_SESSION['authenticated_gates'] = array();
            }
            $_SESSION['authenticated_gates'][] = $gateid;

        } else {

            $response = array('authentication' => false);

        }
        
    }

    $connection->close() ;

    header('Content-type: application/json');
    echo json_encode($response);
    
?>
