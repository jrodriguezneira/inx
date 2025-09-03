<?php
header('Content-Type: application/json');   
// Allow requests from React frontend (adjust domain/port as needed)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$allowed_origins = [
    "http://localhost:3000",
    "http://10.25.30.23:30080"
];

if (in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

include 'data/db_connection.php'; 
$sql="select
(select count(sku) from products_last where segment='LOYALTY_CON') as prod,
(select count(sku) from products_last where offer = 'Hot Offer' and segment='LOYALTY_CON') as off,
(select count(sku) from products_last where ro = '[]' and segment='LOYALTY_CON') as outright,
(select count(sku) from products_last where ro <> '[]' and segment='LOYALTY_CON') as ro";

$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['prod']=$row['prod'];
  $posts['off']=$row['off'];
  $posts['outright']=$row['outright'];
  $posts['ro']=$row['ro'];
  array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}"; 
//$file = 'file.json';
//file_put_contents($file, $json);
?>