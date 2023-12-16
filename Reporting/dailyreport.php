<?php

    include "/var/www/html/GateBackend/dbconfig.php" ;
    require 'vendor/autoload.php'; 

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    $headers = ['Çalışan ID', 'İsim', 'Soyisim','Departman' , 'Giriş-Çıkış','Şube' , 'Adres', 'Tarih','Zaman'];

    $columnIndex = 1;
    foreach ($headers as $header) {
        $worksheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
        $columnIndex++;
    }


    $date = date("Y-m-d");

    $sql = $connection->prepare("SELECT
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
    WHERE m.date = ?;
    ");

    $sql->bind_param("s" , $date) ;

    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $rowIndex = 2;
        while ($row = $result->fetch_assoc()) {
            $columnIndex = 1;
            foreach ($row as $value) {
                $worksheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $value);
                $columnIndex++;
            }
            $rowIndex++;
        }
    }

    foreach(range('A', $worksheet->getHighestDataColumn()) as $col) {
        $worksheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $excelDirectory = '/var/www/html/GateBackend/Reporting/Reports/'; 
    $excelFileName = $excelDirectory . $date . '.xlsx';
    $writer->save($excelFileName);

    $to = $argv[1] ;  
    $subject = 'Günlük Rapor';       
    $message = 'Günlük giriş çıkış raporunuz ektedir.';

    
    $command = "echo '$message' | mail -s '$subject' -a 'From: LinuxSystem'-A '$excelFileName' '$to'";

    exec($command);


    $connection->close();
?>
