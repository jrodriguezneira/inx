<!-- Business script-->
<script type="text/javascript" src="business/business.js"></script>
<?php


////////////////////// Present price-points tiers as table for new offer////////////////////////////
function multi_boxes($price,$sku,$stat=null){ 
    
    if($stat){
    $tier_points = $price;
    //echo $tier_points;
    }else{
    $tier_points=extract_pricing($price);
    }
    //Divide string by comma to get points pay tiers
    $tier = explode(',',$tier_points);
     //Create table to insert price points tiers
     echo "<table id=".$sku."_tab_offer border=0 cellpadding=3 cellspacing=3>";
        //Loop through pricing tiers
        ?>
        <tr>
        <td class='mb_header'>Points</td>
        <td class='mb_header'>Pay</td>
        <td class='mb_header'></td>
        <td class='mb_header'></td>
        <td class='mb_header'></td>
        <td class='mb_header' title='(Points * 0.0025) + (Pay/1.1)'>Value</td>
        <td class='mb_header' title='(Value - fwac)'>Margin</td>
        <td class='mb_header' title='((RRP - Pay)/Points)/1.1'>Pvpp</td>
        </tr>
        <?php
        $type= "update";
        foreach( $tier as $key=>$element) {
        echo "<tr>";
        $tier_price = explode('-',$element);
        if(!$stat) {
            $tier_price ="";
        }
        //Cells for pricing and price calculation labels
        echo "<td class='cell_price'><input onkeydown='javascript:Jump_Cell(event.key,".$sku.",".$key.",\"poi\")' onchange='javascript:Check_Price(".$sku.",".$key.")' onpaste='javascript:Paste_Offer(".$sku.")' id='".$sku."_txt_poi_".$key."' style='width:70px;height:22px;' type='text' value='$tier_price[0]' class='".$sku."_txt_pri'></td>
        <td class='cell_price'><input onkeydown='javascript:Jump_Cell(event.key,".$sku.",".$key.",\"pay\")' onchange='javascript:Check_Price(".$sku.",".$key.")'  id='".$sku."_txt_pay_".$key."' style='width:50px;height:22px;' type='text' value='$tier_price[1]' class='".$sku."_txt_pri' ></td>
        <td class='cell_price'><label style='height:12px;' id='".$sku."_lab_pri_".$key."'></label></td>
        <td class='cell_price'><label style='height:12px;' id='".$sku."_ro_12_".$key."'></label></td>
        <td class='cell_price'><label style='height:12px;' id='".$sku."_ro_24_".$key."'></label></td>
        <td class='cell_price'><input readonly tabindex='-1' id='".$sku."_txt_val_".$key."' style='width:70px;height:22px;' type='text' class='".$sku."_txt_val'></td>
        <td class='cell_price'><input readonly tabindex='-1' id='".$sku."_txt_mar_".$key."' style='width:70px;height:22px;' type='text' class='".$sku."_txt_mar' ></td>
        <td class='cell_price'><input readonly tabindex='-1' id='".$sku."_txt_per_".$key."' style='width:80px;height:22px;' type='text' class='".$sku."_txt_per' ></td>" 
        ;
        echo "</tr>";
        if($stat){
        ?>
        <script>
        var sku = <?php echo $sku;?>;
        var key = <?php echo $key;?>;

        Check_Price(sku,key);
        </script>

        <?php
        }     
        }
    echo "</table>";
}
////////////////////// End Present price-points tiers as table////////////////////////////

?>

  