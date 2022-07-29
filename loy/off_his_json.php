<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql=" select  t1.prom_name as promo_name,t1.sku as sku, t2.name as name, date(t1.start_date) as sta_date,date(t1.end_date) as end_date, t1.rrp as rrp
from promotions as t1 inner join (select distinct sku,name from products_last where segment='LOYALTY_CON') as t2 on t1.`sku` = t2.`sku`
order by t1.id desc";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
$promo_name="";
$i=1;
while($row=mysqli_fetch_array($result)) 
{ 
    //If promo name is the same as previous
    if($promo_name==$row['promo_name']){
      $names.= $row['sku']. " " . $row['name']. " " . $row['rrp']."<br>";

      if($i == mysqli_num_rows($result)){
        $posts['name']=$names;
        array_push($response, $posts);
      }
    }
    // If promo name is diffrent than previous 
    if($promo_name!=$row['promo_name']){
    
      if($promo_name!=""){ 
        $posts['name']=$names;
        array_push($response, $posts);
        $names="";
    }
  //For first time iterationfor each group
  $promo_name=$row['promo_name'];
  $posts['promo_name']=$row['promo_name'];
  $posts['sta_date']=$row['sta_date'];
  $posts['end_date']=$row['end_date'];
  $names.= $row['sku']. " " . $row['name']. " " . $row['rrp']."<br>";

  }
  $i++;
} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>