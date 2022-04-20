<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="select sku,name,category,rrp,stock,price from products_last where  segment='LOYALTY_CON' order by rrp,category;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['category']=$row['category'];
  $posts['rrp']=$row['rrp'];
  $posts['stock']=$row['stock'];
  $posts['price']=$row['price']; 
  array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}"; 
//$file = 'file.json';
//file_put_contents($file, $json);
?>