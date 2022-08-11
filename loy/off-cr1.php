<?php
 include 'business/trends.php'; 
 include 'business/read_trends.php'; 
 include 'data/db_connection.php'; 
 ?>
<div></div>
 <?php


$id_prom= $_GET['id'];
$target= $_GET['target'];

$sql="SELECT * FROM promotions where id= $id_prom";
$result= mysqli_query($con, $sql);
$row_cnt = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result)){

    $id= $row['id'];
    $prom_name= $row['prom_name'];
    $sku= $row['sku'];
    $prod_name= $row['prod_name'];
    $type= $row['type'];
    $rrp= $row['rrp'];
    $price= $row['price']; 
    $fwac= $row['rebate'];
    $chk_ro= $row['ro'];
    $start_date= $row['start_date'];

    $date_dmy=explode(" ",$start_date);
    $datex=explode("-",$date_dmy[0]);
    $start_date= trim($datex[2])."/".$datex[1]."/".$datex[0];
    $start_date .= " ".$date_dmy[1];

    $end_date= $row['end_date'];

    $date_dmy2=explode(" ",$end_date);
    $datex2=explode("-",$date_dmy2[0]);
    $end_date= $datex2[2]."/".$datex2[1]."/".$datex2[0];
    $end_date .= " ".$date_dmy2[1];

    //Get # tiers and dates & stock

    $chk_rrp="true";
    $tiers= explode(",",$price);
    $tot_tiers=count($tiers);
    $dates= $start_date.",".$end_date;
    $stock=1;

     // Array with sku details: sku(0),rrp(1), number of tiers(2),tiers pricing(3), dates(4), stock(5), check rrp(6), check_ro(7), fwac(8)
    $skux.= $sku.'*'.$rrp .'*'.$tot_tiers.'*'.$price.'*'.$dates.'*'.$stock.'*'.$chk_rrp.'*'.$chk_ro.'*'.$fwac;
    // Get initial pricing
    $hot_offer= get_trend("hot_offer",$sku);
    if($hot_offer== "Hot Offer"){
    $loy_price=extract_pricing(get_trend("old_price",trim($sku)));
    }else{
    $loy_price=extract_pricing(get_trend("loy_price",trim($sku)));  
    }
    //Get name
    $name= get_trend("name",trim($sku));
    // If the target is for new products change the query source
    if($target=="product")
    {$name= get_trend("name_new",trim($sku));}
    //Get name from name query
    $productname=explode('-',$name);
    //Get Current RRP when lfag is unchecked
    $rrp_old= get_trend("rrp_new",trim($sku));
    $ro= get_trend('ro_sku',trim($sku));
    if($ro== "[12, 24]"){
    $ini_ro= 1;    
    }else{$ini_ro= 0; }

     //Add current pricing (9) , name(10) , old RRP(11), initial RO(12) to sku array 
     $skux.= '*'.$loy_price.'*'.trim($productname[0]).'*'.$rrp_old.'*'.$ini_ro.'&';

}

$prod= $skux;
//echo $prod;

    include 'extractors/offer-to-file.php'; 
    switch ($target) {
        case "offer":
            create_offer_file($prod);
            break;
        case "shop":
            create_shop_file($prod);
            break;
        case "stock":
            create_stock_file($prod);
            break;
        case "product":
            create_product_file($prod);
            break;
    }

?>
<script>
window.close();
</script>
