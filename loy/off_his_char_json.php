<?php
 function Data_JSON(){
 // header('Content-Type: application/json');   
  include 'data/db_connection.php'; 
  $sql="select distinct id,prom_name,DATE_FORMAT(start_date, '%m-%d-%Y') as sta_date,DATE_FORMAT(end_date, '%m-%d-%Y') as end_date from promotions order by sta_date desc limit 10";
  //$response = array();
  //$posts = array();
  $result=mysqli_query($con,$sql);
  $promo_name="";
  $i=0;
  while($row=mysqli_fetch_array($result)) 
  { 
      $skus='';
      $sql1="select  t1.sku, t2.name
      from promotions as t1 inner join (select distinct sku,name from products_last where segment='LOYALTY_CON') as t2 on t1.`sku` = t2.`sku` where t1.id=".$row['id']."
      order by t1.id desc";
      $result2=mysqli_query($con,$sql1);
      while($row1=mysqli_fetch_array($result2)) {
        $skus .= $row1['sku']." ".$row1['name']."<br>";
      }

    if($row['sta_date'] == $row['end_date']){
    //$row['end_date'] = date('m-d-Y', strtotime($row['end_date'] . " +1 day"));
    $end_date = explode("-",$row['end_date']);
    $day= (int)$end_date[1] + 1;
    $end_day= $end_date[0]."-".$day."-".$end_date[2];
    $row['end_date'] = $end_day;
    //date('d-m-Y',strtotime("-2 days")); it works
    }
    $dates="'".$row['sta_date']."','".$row['end_date']."'";
    $response.= "{stage: 'Offers',substage: '".$row['prom_name']."',dates: [".$dates."],complete:'$skus'},";


    
    $i++;
  } 
  // $serie= '[{stage:\'Offers\',substage:\'Offers\',dates:\"[\'7-1-2022\'],[\'9-30-2022\']\"}]'; 
  $response= substr($response,0,-1);
  // echo  $response;
  //echo $serie;
  return $response;

 }
?>