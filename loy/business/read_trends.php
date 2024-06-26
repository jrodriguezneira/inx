<?php
////////////////////// Display text for RO option ////////////////////////////
function ro_options($ro){
    switch($ro){
        case "[]":
            $ro="Not available";
            break;
        case "[12]":
            $ro= "12 Months";
            break;
        case "[12, 24]":
            $ro= "12 and 24 months";
        break;
    }
return $ro;
}
////////////////////// End Display text for RO option ////////////////////////////


////////////////////// Ordered price-points tiers array separated by comma////////////////////////////
function extract_pricing($price){
//Create ordered array
$tier = explode(',',$price);
$tiers=count($tier);
$i=1;
    if($tiers>1){
        foreach( $tier as $key => $element) {
            if ($key === array_key_first($tier)){
                $element = substr($element, 2);
                $element = substr($element, 0, -1);                 
            }
            if ($key === array_key_last($tier)){
                $element = substr($element, 1);
                $element = substr($element, 0, -2);                   
            }
            if ( $key !== array_key_first($tier) && $key !== array_key_last($tier)){
                    $element = substr($element, 1);
                    $element = substr($element, 0, -1);
            }                                    
        $tierx.= $element.",";
        $i++;       
        }
    }
$tier_array=substr($tierx, 0, -1);

return $tier_array;
}
////////////////////// End Ordered price-points tiers array separated by comma////////////////////////////

////////////////////// Present price-points tiers as table////////////////////////////
function multi_pricing($price,$sku=null,$new=null){
   
    //echo $price;
    $tier_points=extract_pricing($price);
    //Divide string by ,
    $tier = explode(',',$tier_points);   
    //echo count($tier);
    $prod_pricing =  get_trend("product_pricing",$sku); 
   // echo $tier_points;
    $pricex = explode("-",$prod_pricing);
    $vpp =  get_trend("vpp",$sku); 
   

        foreach($pricex as $key=>$pri){
            switch ($key){
                case 0: $inv = $pri; break;
                case 1: $dbp = $pri; break;
                case 2: $rrp = $pri; break;
                case 3: $rrpex = $pri; break;
                case 4: $reb = $pri; break;
                case 5: $invp = $pri; break;
                case 6: $int = $pri; break;
                case 7: $ext = $pri; break;
            }
        }
        if($inv){
        $fwac= $inv +(($rrpex-$dbp)*$ext);
        }else{
        $inv=0;    
        }
        //echo "fwac= ". $fwac . " invp= " . $invp ." rrpex= ". $rrpex. " dbp=  " . $dbp . " ext= " . $ext;
    


    echo "<table width='100%'><tr><td>";
        echo "<table>";
                echo "<tr><td>Retail Price of Device(RRP)</td><td id='".$sku."_rrp'> $rrp  </td></tr>";
                echo "<tr><td>Retail Price (ex GST)</td><td title='(RRP/1.1)'> $rrpex </td></tr>";
                echo "<tr><td>Invoice Price (ex GST)</td><td>$inv </td></tr>";
                echo "<tr><td>Dealer Buy Price (ex GST)</td><td> $dbp </td></tr>";
                echo "<tr><td>Supplier Investment (ex GST)</td><td> <input onchange='javascript:Check_Rebate(".$sku.")' id='".$sku."_txt_reb' style='width:70px;height:22px;' type='text' value='".$reb."'></td></tr>";  
                echo "<tr><td>WAC</td><td id='".$sku."_wac'> $inv </td></tr>";
                echo "<tr><td>Fully Loaded WAC</td><td title='(Invoice Price(ex GST) + (RRPexGST-DBP)*Ext)'><input id='".$sku."_fwac' class='txt_fwac' style='width:70px;height:22px;' type='text' value='".$fwac."'> </td></tr>";                  
                echo "<tr><td>VPP</td><td> $vpp </td></tr>";
        echo "</table>";
    echo "</td><td>";
     
        echo "<table border=0 cellpadding=3 cellspacing=3>";



        if(!isset($new)){
        ?>

        <tr>
        <td class='mb_header'>Points</td>
        <td class='mb_header'>Pay</td>
        <td class='mb_header' title='(Points * 0.0025) + (Pay/1.1)'>Value</td>
        <td class='mb_header' title='(Value - fwac)'>Margin</td>
        <td class='mb_header' title='((RRP - Pay)/Points)/1.1'>Pvpp</td>
        </tr>

        <?php
        }
        $count_tiers=0;

            if(count($tier)==1){
                $tier_price = explode('-',$price);
                echo "<tr><td class='cell_price'>".(int)substr($tier_price[0], 2)."</td><td class='cell_price'>".(int)substr($tier_price[1], 0,-2)."</td></tr>"; 
            }else{
               // if($new=="new"){
                $tiers=count($tier);
                //for ($x = 0; $x <= $tiers; $x++) {
               // }else{
                //$tierx = explode(',',$tier);
                foreach( $tier as $key=>$element) {
               // }
                echo "<tr>";
    
                if($new=="new"){
                $points =".";  
                $pay =" ";
                $valu=" ";
                $mar=" ";
                $per=" ";
                }
                if(!isset($new)){
                   
                $pointspay=explode('-',$element); 
                $points=$pointspay[0]; 
                $pay=$pointspay[1]; 

               // $mar = round(($valu - $inv),2);

                }
                echo "<td class='cell_price'>".$points."</td><td class='cell_price'>".$pay."</td>
                    <td class='cell_price'>".$valu."</td><td class='cell_price'>".$mar."</td>
                    <td class='cell_price'>".$per."</td>";
                echo "</tr>"; 
                $count_tiers++;    
                }
            }
        echo "</table>";
    echo "</td></tr></table>";
    echo "<input type='hidden' class='hid_tie' id='".$sku."_hid_tie' value='$count_tiers'>";
    
}
////////////////////// End Present price-points tiers as table////////////////////////////



//////////////////////  Present products from search as table////////////////////////////
function multi_products($products,$type=null){
$tier_array=substr($products, 0, -1);
//Divide string by ,
$tier = explode('#',$tier_array);
echo "<table border=0 cellpadding=3 cellspacing=3>";
    foreach( $tier as $key=>$element) {
    echo "<tr>";
    $product = explode('*',$element);
        switch($type){
            case "results":
            echo "<td><a href='pr.php?text_sku_search=$product[0]&flag=close'>".$product[1]."</a></td>";
            break;
            case "loy_points_history":
            echo "<td><p><a href='#' class='tooltip-test' title=\"$product[1]\">$product[0]</a></td>";
            break;
            case "stocks":
            echo "<td><a href='pr.php?text_sku_search=$product[0]&flag=close'>".$product[0]." ".$product[1]."</a></td>";
            break;
            default:
            echo "<td><a href='pr.php?text_sku_search=$product[0]&flag=close'>".$product[1]."</a></td>";
            break;
        }      
    echo "</tr>";     
    }
    echo "</table>"; 
} 
//////////////////////  End Present products from search as table////////////////////////////



//////////////////////   Present products as table////////////////////////////
function multi_table($products,$type=null){
    
    $tier_array=substr($products, 0, -1);
    //Divide string by ,
    $tier = explode('#',$tier_array);
    //echo "<br>";
   // echo "<table border=0 cellpadding=3 cellspacing=3>";
        foreach( $tier as $key=>$element) {
        echo "<tr>";
        $product = explode('*',$element);
        echo "<td>".$product[0]."</td>";
        echo "<td>".$product[1]."</td>";  
        echo "</tr>";     
        } 
    } 
//////////////////////  End Present products as table////////////////////////////


?>