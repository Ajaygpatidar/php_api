<?php

header('Content-Type:Application/json');
header('Access-Control-Allow-Origin:*');
header('Aceess-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers:Content-Type,Aceess-Control-Allow-Method,Aceess-Control-Allow-Method');
$data= json_decode(file_get_contents("php://input"),true);
$name   = $data['sname'];
$age    = $data['sage'];
$city   = $data['scity'];
include 'config.php';
$sql="INSERT INTO students (student_name, age, city) values ('$name','$age','$city')";

if(mysqli_query($conn,$sql)== true)
{
    echo json_encode(array('message' => 'data insert','status' => 'success'));
}
else{
    echo json_encode(array('message' => 'not inserted', 'status' => 'false'));
}
?>