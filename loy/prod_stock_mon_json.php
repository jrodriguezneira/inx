<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="SELECT stock_count as in_stock_days, COUNT(*) AS total_products
FROM sku_stock_counts
GROUP BY stock_count
ORDER BY stock_count ASC";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['in_stock_days']=$row['in_stock_days'];
  $posts['total_products']=$row['total_products'];
   array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>