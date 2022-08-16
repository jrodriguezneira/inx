<?php
function Data_prod_JSON(){
include 'data/db_connection.php'; 
$sql="select sku,name,min(date(date_report)) as launch_date
from products
group by sku,name
having launch_date >'2022-06-01'
order by launch_date desc";
//$response = array();
//$posts = array();
$result=mysqli_query($con,$sql);
$launch_date="";
$campa="launch X";
$i=1;
  while($row=mysqli_fetch_array($result)) 
  { 
    if($launch_date==$row['launch_date']){
      $names.= $row['sku']. " " . $row['name']."<br>";

      if($i == mysqli_num_rows($result)){
        $posts['name']=$names;
        //array_push($response, $posts);
        $response.= "{stage: 'Launches',substage: 'Launch".$i."',dates: [".$dates."],complete:'$names'},";

      }
    }

    if($launch_date!=$row['launch_date']){
    
      if($launch_date!=""){ 
        //$posts['name']=$names;
        // array_push($response, $posts);
        $response.= "{stage: 'Launches',substage: 'Launch".$i."',dates: [".$dates."],complete:'$names'},";
        $names="";
        }
    
        $launch_date=$row['launch_date'];
        //$posts['launch_date']=$row['launch_date'];
        $names.= $row['sku']. " " . $row['name']."<br>";


      //////////
      
        //$row['end_date'] = date('m-d-Y', strtotime($row['end_date'] . " +1 day"));
        $end_date = explode("-",$row['launch_date']);
        $start_day=$end_date[1]."-".$end_date[2]."-".$end_date[0];
        $day= (int)$end_date[2] + 1;
        $end_day= $end_date[1]."-".$day."-".$end_date[0];
        //$row['end_date'] = $end_day;
        
        $dates="'".$start_day."','".$end_day."'";
      // $response.= "{stage: 'Offers',substage: '".$i."',dates: [".$dates."],complete:'$names'},";

    }
  $i++;
  }

  $response= substr($response,0,-1);
return $response;

}
//echo "{\"data\": ".json_encode($response)."}";
?>