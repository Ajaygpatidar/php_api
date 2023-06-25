<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');//featuring our website api to access every website & here star means to all
header('Access-Control-Allow-Methods: PUT');//the data im sending 
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');//for the security purpose which which headers im allowing to pass....ex:-line no 2,3,4


$data = json_decode(file_get_contents("php://input"), true);

$id   = $data['sid'];
$name   = $data['sname'];
$age    = $data['sage'];
$city   = $data['scity'];

include './config.php';

$sql = "UPDATE students SET student_name = '{$name}', age = {$age}, city = '{$city}' WHERE id = {$id}";

if(mysqli_query($conn, $sql)){
    echo json_encode(array('message' => 'Records Updated Successfully.', 'status' => 'true'));
}else{
    echo json_encode(array('message' => 'Records Updating Failed.', 'status' => 'False'));
}


?>