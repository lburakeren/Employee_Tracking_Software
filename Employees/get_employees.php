
<?php

//include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;



$result = $connection->query("SELECT employees.id , employees.employee_id, employees.first_name, 
employees.last_name,  employees.picture_name, 
departments.text AS dept_text FROM employees INNER JOIN departments 
ON employees.dept_id = departments.id ORDER BY employees.id");



$data = array();


while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$connection->close();

header("Content-Type: application/json");
echo json_encode($data);

?>