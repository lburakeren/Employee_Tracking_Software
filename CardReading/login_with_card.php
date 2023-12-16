<?php

include "/var/www/html/GateBackend/dbconfig.php" ;

// json to data converting
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data === null) {
    $response = array('error' => 'Invalid JSON data');
} else {
    

    session_start();

    $gateid =$data['gateid'];

    if (isset($_SESSION['authenticated_gates']) && in_array($gateid, $_SESSION['authenticated_gates'])) {
        $cardid = $data['cardid'];

        $sql = $connection->prepare("SELECT * FROM cards WHERE card_id = ?");
        $sql->bind_param("s", $cardid);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $employee_id = $row["employee_id"];

            $sql2 = $connection->prepare("SELECT * FROM employees WHERE employee_id = ?");
            $sql2->bind_param("i", $employee_id);
            $sql2->execute();
            $result2 = $sql2->get_result();

            if ($result2->num_rows > 0) {
                
                $current_time = date("H:i:s");
                $date = date("Y-m-d");   

                $sql5 = $connection->prepare("SELECT gate_name,gate_location FROM gates WHERE gate_id = ?" );
                $sql5->bind_param("i", $gateid);
                $sql5->execute();
                $result5 = $sql5->get_result();
                $row3 = $result5->fetch_assoc();

                
                $sql3 = $connection->prepare("SELECT * FROM movements WHERE employee_id = ? ORDER BY id DESC LIMIT 1");
                $sql3->bind_param("i", $employee_id);
                $sql3->execute();
                $result3 = $sql3->get_result();


                if ($result3->num_rows > 0) {
                    $row2 = $result3->fetch_assoc();
                    $last_movement = $row2["in_out"];

                    $next_movement = ($last_movement === "in") ? "out" : "in";

                    $sql4 = $connection->prepare("INSERT INTO movements (employee_id, gate_id, date, time, in_out) VALUES (?, ?, ?, ?, ?)");
                    $sql4->bind_param("iisss", $employee_id, $gateid, $date, $current_time, $next_movement);
                    $sql4->execute();


                    $row = $result2->fetch_assoc();
                    $response = array(
                        "login_with_card" => true,
                        "first_name" => $row["first_name"],
                        "last_name" => $row["last_name"],
                        "picture_name" => $row["picture_name"],
                        "gate_name" => $row3["gate_name"],
                        "gate_location" => $row3["gate_location"],
                        "in_out" => $next_movement  
                    );

                    $sql4->close();


                } else {
                    
                    $sql4 = $connection->prepare("INSERT INTO movements (employee_id, gate_id, date, time, in_out) VALUES (?, ?, ?, ?, ?)");
                    $next_movement = "in";
                    $sql4->bind_param("iisss", $employee_id, $_SESSION["gateid"], $date, $current_time, $next_movement);
                    $sql4->execute();


                    $row = $result2->fetch_assoc();
                    $response = array(
                        "login_with_card" => true,
                        "first_name" => $row["first_name"],
                        "last_name" => $row["last_name"],
                        "picture_name" => $row["picture_name"],
                        "in_out" => $next_movement  
                    );

                    $sql4->close();

                }

                $sql3->close();
                $sql5->close();

            } else {
                $response = array("login_with_card" => false);
            }

            $sql2->close();

        } else {
            $response = array("login_with_card" => false);
        }

        $sql->close();

    } else {
        $response = array("login_with_card" => false);
    }

    
}

$connection->close();

header('Content-type: application/json');
echo json_encode($response);

?>
