<?php  
header('Content-type:Application/json');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Method,Content-type');
include 'config.php';
$sql="select*from students";
$res=mysqli_query($conn,$sql);
if(mysqli_num_rows($res)> 0)
{
    $output = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($output);
}
else
{
    // echo json_encode(array("message" => "data not found" , "status" => "false"));
}
?>