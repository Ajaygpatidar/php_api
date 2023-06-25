<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');//the data im sending 
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');//for the security purpose which which headers im allowing to pass....ex:-line no 2,3,4

$data = json_decode(file_get_contents("php://input"), true);

$student_id = $data['sid'];

include './config.php';
$sqll = "select*FROM students WHERE id={$student_id}";
$res = mysqli_query($conn,$sqll);
if(mysqli_num_rows($res) > 0){
    $sql = "DELETE FROM students WHERE id={$student_id}";
    if(mysqli_query($conn, $sql)){
        echo json_encode(array('message' => 'Record Deleted Successfully.', 'status' => 'true'));
    }else{
        echo json_encode(array('message' => 'Record Deleting Failed.', 'status' => 'false'));
    }
}

else{
    echo json_encode(array('message' => 'Record Deleting Failed.', 'status' => 'false'));
}
