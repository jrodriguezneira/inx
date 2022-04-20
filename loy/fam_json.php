<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="select family,name from products_last where segment ='LOYALTY_CON' order by family,name;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
$family="";
$i=1;
while($row=mysqli_fetch_array($result)) 
{ 
  if($family==$row['family']){
    $names.= $row['name']."<br>";

    if($i == mysqli_num_rows($result)){
      $posts['name']=$names;
      array_push($response, $posts);
    }
  }

  if($family!=$row['family']){
  
    if($family!=""){ 
      $prodsxfamily=explode('>',$names);
      if(count($prodsxfamily)>2){
      
      $posts['name']=$names;
      array_push($response, $posts);
      $names="";
      }else{
      $names="";  
      }
    }

    $family=$row['family'];
    $posts['family']=$row['family'];
    $names.= $row['name']."<br>";
  }
$i++;
} 
echo "{\"data\": ".json_encode($response)."}";
?>