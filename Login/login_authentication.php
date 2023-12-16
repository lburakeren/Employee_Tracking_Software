<?php

session_start();

if( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ){
    header("location: /GateBackend/Login/login.php");
    exit;
}


?>