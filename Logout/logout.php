
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;

session_start();

session_destroy();

header("Location: ../Login/login.php");

exit;

?>
