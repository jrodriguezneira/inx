<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="select distinct T1.sku,T2.name,T2.category,T2.rrp,T1.vpp,T1.price from products_new_pricing as T1 left join products_last as T2 on T1.sku=T2.sku;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['category']=$row['category'];
  $posts['rrp']=$row['rrp'];
  $posts['vpp']=$row['vpp'];
  $posts['price']=$row['price']; 
  array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>