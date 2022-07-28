<?php

include 'data/db_connection.php';
include 'business/trends.php';

//Variables
$sku = $_POST['sku'];
$rrp = $_POST['rrp'];
$tiers = $_POST['tiers'];
$date_sta_end = $_POST['dates'];
$chk_ro = $_POST['chk_ro'];
$fwac = $_POST['fwac'];
$name = $_POST['pri_name'];
$target = $_POST['target'];
$stat = $_POST['stat'];
$type = $_POST['type'];



if($stat){
$id=$stat;    
}    
else{    
    $id= get_trend("id_promo");    
    if(is_null($id)){    
    $id=1;    
    }else{    
    $id=$id+1;    
    }    
}

$dates=explode(",",$date_sta_end);

if($target=="offer"){
$date_dmy=explode(" ",$dates[0]);
$datex=explode("/",$date_dmy[0]);
$start_date= $datex[2]."-".$datex[1]."-".$datex[0];
$start_date .= " ".$date_dmy[2];

$date_dmy2=explode(" ",$dates[1]);
$datex2=explode("/",$date_dmy2[0]);
$end_date= $datex2[2]."-".$datex2[1]."-".$datex2[0];
$end_date .= " ".$date_dmy2[2];
}else{
$start_date = $dates[0];
$end_date = $dates[1];
}



if($type=="update"){
    $sku=trim($sku);
    $query="UPDATE promotions SET 
    `id` = $id,
    `prom_name` = '$name',
    `sku` = '$sku',
    `prod_name` =' ',
    `type` = '$target',
    `rrp` = $rrp,
    `price` = '$tiers',
    `rebate` = $fwac,
    `ro` = '$chk_ro',
    `start_date` = '$start_date',
    `end_date` = '$end_date' 
    WHERE sku='$sku' and id=$id";
}else{
$sku=trim($sku);
$query="INSERT INTO promotions (`id`,`prom_name`,`sku`,`prod_name`,`type`,`rrp`,`price`,`rebate`,`ro`,`start_date`,`end_date`) 
values($id,'$name','$sku',' ','$target',$rrp,'$tiers',$fwac,'$chk_ro','$start_date','$end_date')";
}
//echo $query . "<br>";
mysqli_query($con, $query);

echo $return = "$id";


?>