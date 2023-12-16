<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;


$result = $connection->query("SELECT
e.employee_id,
e.first_name,
e.last_name,
d.text,
CASE
    WHEN m.in_out = 'in' THEN 'Giriş'
    WHEN m.in_out = 'out' THEN 'Çıkış'
    ELSE ''
END AS in_out,
g.gate_name,
g.gate_location,
m.date,
m.time
FROM
movements m
INNER JOIN
employees e ON m.employee_id = e.employee_id
INNER JOIN
departments d ON e.dept_id = d.id
INNER JOIN
gates g ON m.gate_id = g.gate_id
ORDER BY m.date DESC, m.time DESC
");

$data = array();


while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



$connection->close();

header("Content-Type: application/json");
echo json_encode($data);

?>