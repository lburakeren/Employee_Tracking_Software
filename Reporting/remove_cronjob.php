<?php

include "/var/www/html/GateBackend/login_authentication.php";

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


$cronjobs = shell_exec('crontab -l');


$lines = explode("\n", $cronjobs);


$new_cronjobs = '';


foreach ($lines as $line) {
    if (strpos($line, $job) === false) {
        if (!empty($line)) {
            $new_cronjobs .= $line . "\n";
        }
    }
}


file_put_contents('/tmp/new_cronjobs.txt', $new_cronjobs); 
exec('crontab /tmp/new_cronjobs.txt');

unlink('/tmp/new_cronjobs.txt');


?>
