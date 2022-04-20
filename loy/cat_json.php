<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql=" select distinct category,name FROM products_last where name <> 'Delivery Fee' order by category;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
$category="";
$i=1;
while($row=mysqli_fetch_array($result)) 
{ 
  if($category==$row['category']){
    $names.= $row['name']."<br>";

    if($i == mysqli_num_rows($result)){
      $posts['name']=$names;
      array_push($response, $posts);
    }
  }

  if($category!=$row['category']){
  
    if($category!=""){ 
      $posts['name']=$names;
      array_push($response, $posts);
      $names="";
  }

  $category=$row['category'];
  $posts['category']=$row['category'];
  $names.= $row['name']."<br>";

  }
$i++;
} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>