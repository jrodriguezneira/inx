<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql=" select prod_name,start_date,date(end_date) 
from promotions 
group by sku,name
order by launch_date desc";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
$launch_date="";
$i=1;
while($row=mysqli_fetch_array($result)) 
{ 
  if($launch_date==$row['launch_date']){
    $names.= $row['sku']. " " . $row['name']."<br>";

    if($i == mysqli_num_rows($result)){
      $posts['name']=$names;
      array_push($response, $posts);
    }
  }

  if($launch_date!=$row['launch_date']){
  
    if($launch_date!=""){ 
      $posts['name']=$names;
      array_push($response, $posts);
      $names="";
  }

  $launch_date=$row['launch_date'];
  $posts['launch_date']=$row['launch_date'];
  $names.= $row['sku']. " " . $row['name']."<br>";

  }
$i++;
} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>