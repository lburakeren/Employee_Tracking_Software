<?php

$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';


if (empty($frequency) || empty($time) || empty($report_type) || empty($email)) {
    $response = array('success' => false, 'message' => 'Missing input data.');
} else {
   
    $escaped_frequency = escapeshellarg($frequency);
    $escaped_time = escapeshellarg($time);
    $escaped_report_type = escapeshellarg($report_type);
    $escaped_email = escapeshellarg($email);

    $command = "php /var/www/html/GateBackend/Reporting/add_cronjob.php $escaped_frequency $escaped_time $escaped_report_type $escaped_email";

    
    exec($command, $output, $returnCode);

    if ($returnCode === 0) {
        $response = array('success' => true, 'message' => $command);
    } else {
        $response = array('success' => false, 'message' => 'Failed to add cronjob. Check the command for errors.');
    }
}


header('Content-Type: application/json');
echo json_encode($response);

?>
