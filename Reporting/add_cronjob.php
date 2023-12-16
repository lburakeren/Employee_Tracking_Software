<?php

    //include "/var/www/html/GateBackend/Login/login_authentication.php";


    $frequency_temp = $argv[1];
    $time = $argv[2];
    $report_type = $argv[3];
    $email = $argv[4];
  

    if(($frequency_temp) === "Her Gün"){
        $frequency = "* * *" ;
    }else if($frequency_temp === "Her Hafta içi"){
        $frequency = "* * 1,2,3,4,5" ;
    }else if($frequency_temp === "Her Cuma"){
        $frequency = "* * 5" ;
    }else if($frequency_temp === "Her Ay Sonu"){
        $frequency = "31 * *" ;
    }


    list($timehour, $timeminute, $timesecond) = explode(':', $time);


    $job = "{$timeminute} {$timehour} {$frequency} php /var/www/html/GateBackend/Reporting/{$report_type}.php {$email}";

 

    $result = exec('(crontab -l ; echo \''.$job.'\') 2>&1 | crontab -', $output, $returnCode);


    if ($result !== null) {
        $response = array('success' => true, 'message' => $job);
    } else {
        $response = array('success' => false, 'message' => 'Failed to add cronjob..');
    }


    header('Content-Type: application/json');
    echo json_encode($response);


?>
