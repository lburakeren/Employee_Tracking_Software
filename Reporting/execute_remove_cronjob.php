
<?php

//include "/var/www/html/GateBackend/Login/login_authentication.php" ;
//include "/var/www/html/GateBackend/dbconfig.php" ;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (isset($data['id'])) {
        $id = $data['id'];
        
        $sql = $connection->prepare("SELECT * FROM reports WHERE id = ?");
        $sql->bind_param("i", $id);
        if (!$sql->execute()) {
            die("Error executing SQL query: " . $sql->error);
        }
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        $escaped_frequency = escapeshellarg($row['frequency']);
        $escaped_time = escapeshellarg($row['time']);
        $escaped_report_type = escapeshellarg($row['report_type']);
        $escaped_email = escapeshellarg($row['email']);
    
        $command = "php /var/www/html/GateBackend/Reporting/remove_cronjob.php $escaped_frequency $escaped_time $escaped_report_type $escaped_email";
    
        
        exec($command, $output, $returnCode);
    
        if ($returnCode === 0) {
            $response = array('success' => true, 'message' => $command );
        } else {
            $response = array('success' => false, 'message' => 'Failed to remove cronjob. Check the command for errors.');
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