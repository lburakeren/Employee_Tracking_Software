<?php

//salary_report.php

    include "/var/www/html/GateBackend/dbconfig.php";
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    $headers = ['Çalışan ID', 'İsim', 'Soyisim','Giriş', 'Çıkış' , 'Mesai Saati' , 'Ek Mesai Saati'];

    $columnIndex = 1;
    foreach ($headers as $header) {
        $worksheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
        $columnIndex++;
    }

    $employeeId = 825569; 
    $endDate = date("Y-m-d");
    $startDate = date("Y-m-d", strtotime("-30 days", strtotime($endDate)));
    
    $query = "SELECT m.employee_id, e.first_name, e.last_name, 
                    CONCAT(m.date, ' ', m.time) AS Giriş, 
                    (
                        SELECT CONCAT(date, ' ', time) 
                        FROM movements 
                        WHERE employee_id = m.employee_id 
                            AND in_out = 'out' 
                            AND ((date = m.date AND time > m.time) OR date > m.date)
                        ORDER BY date ASC, time ASC
                        LIMIT 1
                    ) AS Çıkış
              FROM movements AS m
              INNER JOIN employees AS e ON m.employee_id = e.employee_id
              WHERE m.employee_id = ? 
                AND m.in_out = 'in' 
                AND m.date BETWEEN ? AND ?";
    
    $sql= $connection->prepare($query);
    $sql->bind_param("iss", $employeeId, $startDate, $endDate);
    
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $rowIndex = 2;
        
            while ($row = $result->fetch_assoc()) {
                if(!empty($row['Çıkış'])){
                    $columnIndex = 1;
                    foreach ($row as $value) {
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                        $columnIndex++;
                    }
                    
                    $giris = date("H:i:s", strtotime($row['Giriş']));
                    $cikis = date("H:i:s", strtotime($row['Çıkış']));

                    if ( strtotime($giris) >= strtotime("06:00:00")   &&  strtotime($cikis) <= strtotime("18:00:00") && strtotime($cikis) >= strtotime("06:00:00")  && strtotime($giris) <= strtotime("18:00:00") ){
                        
                        $to_time = strtotime($row['Giriş']);
                        $from_time = strtotime($row['Çıkış']);
                        $duration_minutes = round(abs($to_time - $from_time) / 60); 
                    
                        $duration_hours = floor($duration_minutes / 30) * 0.5 + (($duration_minutes % 30) >= 15 ? 0.5 : 0);
                    
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $duration_hours);
                        $columnIndex++ ;
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, 0);
                    
                    } else if ( strtotime($giris) >= strtotime("06:00:00")   && strtotime($giris) < strtotime("18:00:00") && (strtotime($cikis) > strtotime("18:00:00") || strtotime($cikis) <= strtotime("03:00:00") ) ) {
                    
                        

                        $to_time = strtotime($giris);
                    
                        $from_time = strtotime($row['Çıkış']);
                        
                        $duration_minutes = round(abs($to_time - strtotime("18:00:00") ) / 60); 
                    
                        $duration_hours = floor($duration_minutes / 30) * 0.5 + (($duration_minutes % 30) >= 15 ? 0.5 : 0);
                    
                        $to_time = strtotime($row['Giriş']);

                        $total_duration_minutes = round(abs($to_time - $from_time ) / 60);
                        
                        $total_duration_hours = floor($total_duration_minutes / 30) * 0.5 + (($total_duration_minutes % 30) >= 15 ? 0.5 : 0);

                        $extra_duration_hours = $total_duration_hours - $duration_hours ;

                    
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $duration_hours);
                        $columnIndex++ ;
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $extra_duration_hours);
                    
                    
                    } else if ( strtotime($giris) >= strtotime("18:00:00") && (strtotime($cikis) >= strtotime("18:00:00") || strtotime($cikis) <= strtotime("05:00:00") )){

                      
                        $to_time = strtotime($row['Giriş']);
                    
                        $from_time = strtotime($row['Çıkış']);

                        

        
                        $extra_duration_minutes = round(abs($to_time -  $from_time) / 60); 
                    
                        $extra_duration_hours = floor($extra_duration_minutes / 30) * 0.5 + (($extra_duration_minutes % 30) >= 15 ? 0.5 : 0);
                        
                        echo $extra_duration_hours;
                    
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, 0);
                        $columnIndex++ ;
                        $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $extra_duration_hours);
                    
                    }
                    
                    
                    $rowIndex++;       
                }    
            }        
    }

    foreach (range('A', $worksheet->getHighestDataColumn()) as $col) {
        $worksheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $excelDirectory = '/var/www/html/GateBackend/Reporting/Reports/';
    $excelFileName = $excelDirectory . '_employee_' . $employeeId . '.xlsx';
    $writer->save($excelFileName);



    $connection->close();
?>
