<?php

$host = "localhost" ;
$username = "root" ;
$password = "root" ;
$db_name = "testDB" ;

$connection = new mysqli($host,$username,$password,$db_name) ;

if($connection->connect_errno){
    die("Failed to connect mariaDB" . $connection->connect_error);
}


?>