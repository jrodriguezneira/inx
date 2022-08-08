<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="SELECT sku,`name`,day_sales_loy FROM product_sales where date_report=DATE_SUB(CURDATE(), INTERVAL 2 DAY);";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['day_sales']=$row['day_sales_loy'];

//   //Get sales from previous day
  $sql1="SELECT day_sales_loy FROM product_sales  where sku='".$row['sku']."' and date_report=DATE_SUB(CURDATE(), INTERVAL 3 DAY);";
  $result2=mysqli_query($con,$sql1);
    while($sales=mysqli_fetch_array($result2)) 
    { 
      $sale= $sales[0];
    }

  $posts['yesterday_sales']=$sale;

//   //Get sales from pre - previous day
  $sql2="SELECT day_sales_loy FROM product_sales  where sku='".$row['sku']."' and date_report=DATE_SUB(CURDATE(), INTERVAL 4 DAY);";
  $result3=mysqli_query($con,$sql2);
    while($presales=mysqli_fetch_array($result3)) 
    { 
      $presale= $presales[0];
    }

  $posts['pre_sales']=$presale;
// /*
    //Get price
    // $sql3="SELECT price FROM products_last  where sku='".$row['sku']."' and segment='LOYALTY_CON' limit 1";
    // $result4=mysqli_query($con,$sql3);
    //   while($prices=mysqli_fetch_array($result4)) 
    //   { 
    //     $price= $prices[0];
    //   }
  
    // $posts['price']=$price;


  array_push($response, $posts);

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>