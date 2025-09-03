<?php
header('Content-Type: application/json');   
// Allow requests from React frontend (adjust domain/port as needed)
$allowed_origins = [
    "http://localhost:3000",
    "http://10.25.30.23:30080"
];

if (in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'data/db_connection.php'; 
$sql="select count(sku)as total,category from products_last where segment ='LOYALTY_CON' and category <> 'Miscellaneous' group by category order by total;";

$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  $posts['x']=$row['category'];
  $posts['y']=$row['total'];
  $posts['text']=$row['category'];


  array_push($response, $posts);
} 
echo "{\"data\": ".json_encode($response)."}"; 
//$file = 'file.json';
//file_put_contents($file, $json);
?>