<?php
header('Content-Type: application/json');   
include 'data/db_connection.php'; 
$sql="SELECT sku,name, GROUP_CONCAT(price ORDER BY price separator '|') as price FROM products_last where segment='LOYALTY_CON' or 
segment='LOYALTY_CON_DV' or segment='LOYALTY_SMB' group BY sku;";
$response = array();
$posts = array();
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 

  $price= explode("|",$row['price']);

  $con= trim(substr($price[0],1),"]");
  $arrcon=explode(",",$con);
  $dv=trim(substr($price[1],1),"]");
  $arrdv=explode(",",$dv);
  $smb= trim(substr($price[2],1),"]");
  $arrsmb=explode(",",$smb);


  if($con==$dv && $dv==$smb){
  $dif="Aligned";
  }else{
  $dif="Different";

    if(sizeof($arrcon)==sizeof($arrdv) AND array_diff($arrcon,$arrdv)==array())
    {
    $dif="Aligned";
    }else{
    $dif="Different";
    }
    if(sizeof($arrcon)==sizeof($arrsmb) AND array_diff($arrcon,$arrsmb)==array())
    {
    $dif="Aligned";
    }else{
    $dif="Different";
    }

    }



  
  $posts['sku']=$row['sku'];
  $posts['name']=$row['name'];
  $posts['con']=$con;
  $posts['dv']=$dv;
  $posts['smb']=$smb;
  $posts['dif']=$dif;

  array_push($response, $posts);

  

} 
echo "{\"data\": ".json_encode($response)."}";
//$file = 'file.json';
//file_put_contents($file, $json);
?>