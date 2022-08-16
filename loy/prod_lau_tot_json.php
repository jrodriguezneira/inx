<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="select sku,name,min(date(date_report)) as launch_date
from products
group by sku,name
order by launch_date desc";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['launch_date']=$row['launch_date'];
   array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>