<?php 
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin:*');
header('Aceess-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers:Content-Type,Aceess-Control-Allow-Method,Aceess-Control-Allow-Method');

$data = json_decode(file_get_contents("php://input"), true);

$search_value = $data['searchName'];

// $search_value = isset($_GET['search']) ? $_GET['search'] : die();

include './config.php';

$sql = "SELECT * FROM students WHERE student_name LIKE '%{$search_value}%'";
$result = mysqli_query($conn, $sql) or die("SQL Query Failed.");

if(mysqli_num_rows($result) > 0){
    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($output);
    if($output == ""){
        echo "no records found";
    }
}else{
    echo json_encode(array('message' => 'No Record Found.', 'status' => 'False'));
}


?>