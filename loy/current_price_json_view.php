<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="select distinct sku,name,rrp, substring_index(substring(SUBSTRING_INDEX(price,',', 1),3),'-',1) as Top_Points,
substring_index((substring_index((substring(price,-10)),'-',-1)),\"'\",1) as Top_Pay,price
from products_last ;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['rrp']=$row['rrp'];
  $posts['top']=$row['Top_Points'];
  $posts['pay']=$row['Top_Pay'];
  if(intval($posts['rrp'])==intval($posts['pay'])){
    $check="Aligned";
    }else{
    $check="Difference";
    }
  $posts['check']=$check; 
  $posts['price']=$row['price']; 
  array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>