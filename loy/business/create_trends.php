<!-- Business script-->
<script type="text/javascript" src="business/business.js"></script>
<?php

////////////////////////////////////////////////////Determine boxes number for new pricing //////////////////

function Price_Flat_Vpp($rrp){

    
    $points = $rrp/(0.00245*1.1);



    switch ($points) {
        case $points > 0 && $points <6000: $tier_count=6; break;
        case $points > 6000 && $points <30000: $tier_count=18; break;
        case $points > 30000 && $points <50000: $tier_count=22; break;
        case $points > 50000 && $points <100000: $tier_count=27; break;
        case $points > 100000 && $points <200000: $tier_count=32; break;
        case $points > 200000 && $points <500000: $tier_count=38; break;
        case $points > 500000 && $points <2000000: $tier_count=53; break;
    }


    switch ($tier_count) {
        case $tier_count == 6:
            
            switch(true){
                case $points > 0 && $points <1000: $tier_count=1; break;
                case $points > 1000 && $points <2000: $tier_count=2; break;
                case $points > 2000 && $points <3000: $tier_count=3; break;
                case $points > 3000 && $points <4000: $tier_count=4; break;
                case $points > 4000 && $points <5000: $tier_count=5; break;
                case $points > 5000 && $points <6000: $tier_count=6; break;
                }
            break;

        case $tier_count == 18:
           
            switch ($points) {
                case $points > 6000 && $points <8000:$tier_count=7; break;
                case $points > 8000 && $points <10000: $tier_count=8; break;
                case $points > 10000 && $points <12000: $tier_count=9; break;
                case $points > 12000 && $points <14000: $tier_count=10; break;
                case $points > 14000 && $points <16000: $tier_count=11; break;
                case $points > 16000 && $points <18000: $tier_count=12; break;
                case $points > 18000 && $points <20000: $tier_count=13; break;
                case $points > 20000 && $points <22000: $tier_count=14; break;
                case $points > 22000 && $points <24000: $tier_count=15; break;
                case $points > 24000 && $points <26000: $tier_count=16; break;
                case $points > 26000 && $points <28000: $tier_count=17; break;
                case $points > 28000 && $points <30000: $tier_count=18; break;           
            }
            break;


        case $tier_count == 22:  
            switch(true){
            case $points > 30000 && $points <35000: $tier_count=19; break;
            case $points > 35000 && $points <40000: $tier_count=20; break;
            case $points > 40000 && $points <45000: $tier_count=21; break;
            case $points > 45000 && $points <50000: $tier_count=22; break;
            }
        break;

        case $tier_count == 27: 
            switch(true){
            case $points > 50000 && $points <60000: $tier_count=23; break;
            case $points > 60000 && $points <70000: $tier_count=24; break;
            case $points > 70000 && $points <80000: $tier_count=25; break;
            case $points > 80000 && $points <90000: $tier_count=26; break;
            case $points > 90000 && $points <100000: $tier_count=27; break;
            }
        
        break;
        case $tier_count == 32:  
        
            switch(true){
            case $points > 100000 && $points <120000: $tier_count=28; break;
            case $points > 120000 && $points <140000: $tier_count=29; break;
            case $points > 140000 && $points <160000: $tier_count=30; break;
            case $points > 160000 && $points <180000: $tier_count=31; break;
            case $points > 180000 && $points <200000: $tier_count=32; break;
            }
        
        break;

        case $tier_count == 38:  
        
            switch(true){
            case $points > 200000 && $points <250000: $tier_count=33; break;
            case $points > 250000 && $points <300000: $tier_count=34; break;
            case $points > 300000 && $points <350000: $tier_count=35; break;
            case $points > 350000 && $points <400000: $tier_count=36; break;
            case $points > 400000 && $points <450000: $tier_count=37; break;
            case $points > 450000 && $points <500000: $tier_count=38; break;

            }
        
        break;
        case $tier_count == 53:  
        
            switch(true){
            case $points > 500000 && $points <600000: $tier_count=39; break;
            case $points > 600000 && $points <700000: $tier_count=40; break;
            case $points > 700000 && $points <800000: $tier_count=41; break;
            case $points > 800000 && $points <900000: $tier_count=42; break;
            case $points > 900000 && $points <1000000: $tier_count=43; break;
            case $points > 1000000 && $points <1100000: $tier_count=44; break;
            case $points > 1100000 && $points <1200000: $tier_count=45; break;
            case $points > 1200000 && $points <1300000: $tier_count=46; break;
            case $points > 1300000 && $points <1400000: $tier_count=47; break;
            case $points > 1400000 && $points <1500000: $tier_count=48; break;
            case $points > 1500000 && $points <1600000: $tier_count=48; break;
            case $points > 1600000 && $points <1700000: $tier_count=49; break;
            case $points > 1700000 && $points <1800000: $tier_count=50; break;
            case $points > 1800000 && $points <1900000: $tier_count=51; break;
            case $points > 1900000 && $points <2000000: $tier_count=52; break;

            }
        
        break;
    }





return $tier_count;

}
////////////////////////////////////////////////////////////////


////////////////////// Present price-points tiers as table for new offer////////////////////////////
function multi_boxes($price,$sku,$stat=null){ 
   // echo $price;
    
    if($stat){
    $tier_points = $price;
    //echo $tier_points;
    }else{
    $tier_points=extract_pricing($price);
    }
  //  echo $tier_points;
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
        //if($stat){
        //foreach( $tier as $key=>$element){
        //echo $price;
        $tiers=Price_Flat_Vpp($price);
        //echo $tiers;
        //}//else{
        for ($x = 0; $x <= $tiers; $x++){
        echo "<tr>";
        $key=$x;
        //Cells for pricing and price calculation labels
        echo "<td class='cell_price'><input onkeydown='javascript:Jump_Cell(event.key,".$sku.",".$key.",\"poi\")' 
        onchange='javascript:Check_Price(".$sku.",".$key.")' onpaste='javascript:Paste_Offer(".$sku.")' id='".$sku."_txt_poi_".$key."' 
        style='width:70px;height:22px;' type='text' value='$tier_price[0]' class='".$sku."_txt_pri'></td>
        <td class='cell_price'><input onkeydown='javascript:Jump_Cell(event.key,".$sku.",".$key.",\"pay\")' onchange='javascript:Check_Price(".$sku.",".$key.")'  id='".$sku."_txt_pay_".$key."' style='width:50px;height:22px;' type='text' value='$tier_price[1]' class='".$sku."_txt_pri' ></td>
        <td class='cell_price'><label style='height:12px;' id='".$sku."_lab_pri_".$key."'></label></td>
        <td class='cell_price'><label style='height:12px;' id='".$sku."_ro_12_".$key."'></label></td>
        <td class='cell_price'><label style='height:12px;' id='".$sku."_ro_24_".$key."'></label></td>
        <td class='cell_price'><input readonly tabindex='-1' id='".$sku."_txt_val_".$key."' style='width:70px;height:22px;' type='text' class='".$sku."_txt_val'></td>
        <td class='cell_price'><input readonly tabindex='-1' id='".$sku."_txt_mar_".$key."' style='width:70px;height:22px;' type='text' class='".$sku."_txt_mar' ></td>
        <td class='cell_price'><input tabindex='-1' id='".$sku."_txt_per_".$key."' style='width:80px;height:22px;' type='text' class='".$sku."_txt_per' ></td>" 
        ;
        echo "</tr>";
        if($stat){
        ?>
        <script>
        var sku = <?php echo $sku;?>;
        var key = <?php echo $key;?>;

        Check_Price(sku,key);
        //echo "<input type='hidden' class='hid_tie' id='".$sku."_hid_tie' value='$count_tiers'>";
        </script>

        <?php
        }     
        ?>
        <input id='tiers_count' type='hidden' class='new_price'  value="<?php echo $tiers; ?>">
        <?php
        }
        ?>
        <script>
        var sku = <?php echo $sku;?>;
        var hid_tiex = sku + "_hid_tie";
        document.getElementById(hid_tiex).value = <?php echo $tiers;?>; 
        </script>

        <?php
    echo "</table>";
}
////////////////////// End Present price-points tiers as table////////////////////////////

?>

  