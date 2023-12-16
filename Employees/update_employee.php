
<?php

include "/var/www/html/GateBackend/Login/login_authentication.php" ;
include "/var/www/html/GateBackend/dbconfig.php" ;

if (isset($_FILES['employee_photo'])) {
    $uploadedFileName = $_FILES['employee_photo']['name'];
    $tempFilePath = $_FILES['employee_photo']['tmp_name'];

    $uploadDirectory = 'EmployeePics/' . $uploadedFileName;

    if (move_uploaded_file($tempFilePath, $uploadDirectory)) {
        
        $resizedImage = resize_image($uploadDirectory, 100, 100, $crop = FALSE);
        imagejpeg($resizedImage, $uploadDirectory); 
        imagedestroy($resizedImage);

    } else {
        $response = array('success' => false, 'error' => 'File upload failed');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

}else{
    $uploadedFileName = "defaultemployeephoto.png" ;
}

$old_employee_id = $_POST['old_employee_id'];
$employeeId = $_POST['employee_id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$deptId = $_POST['dept_id'];

$stmt = $connection->prepare("UPDATE employees SET
    employee_id = ?,
    first_name = ?,
    last_name = ?,
    dept_id = ?,
    picture_name = ?
    WHERE employee_id = ?");


$stmt->bind_param("issisi", $employeeId , $firstName, $lastName,  $deptId, $uploadedFileName, $old_employee_id);

if ($stmt->execute()) {
    $response = array('success' => true);
} else {
    $response = array('success' => false, 'error' => 'Database update failed');
}

$stmt->close();
$connection->close();

header('Content-Type: application/json');
echo json_encode($response);

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}


?>
