<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="select * from sku_stock_counts";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['year']=$row['year'];
  $posts['month']=$row['month'];
  $posts['stock']=$row['stock_count'];
   array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>