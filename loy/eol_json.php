<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="SELECT  distinct sku,name,rrp,max(date_report) as last_date 
FROM stagierv_insights.products 
where sku not in (SELECT distinct sku from stagierv_insights.products_last) and rrp <> 0 
group by  sku,name,rrp 
order by last_date,name;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['rrp']=$row['rrp'];
  $posts['last_date']=$row['last_date'];
  array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>