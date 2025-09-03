<?php
header('Content-Type: application/json');   
// Allow requests from React frontend (adjust domain/port as needed)
header("Access-Control-Allow-Origin: http://10.25.30.23:30080");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'data/db_connection.php'; 
$sql="select 
(select count(sku) as oos from products_last where stock = 'Out of Stock' and segment='LOYALTY_CON') as oos, 
(select count(sku) as ins from products_last where stock = 'In Stock' and segment='LOYALTY_CON') as ins";

$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['oos']=$row['oos'];
  $posts['ins']=$row['ins'];
  array_push($response, $posts);

} 
echo "{\"data\": ".json_encode($response)."}"; 
//$file = 'file.json';
//file_put_contents($file, $json);
?>