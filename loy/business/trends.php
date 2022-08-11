<?php
 
///////////////////////// Get database values/////////////////////////////////////
function get_trend($parameter, $sku=null,$date=null,$rrp=null){
    include 'data/db_connection.php';

   //Queries depending on information required 
    $sql_products="select count(sku) from products_last where segment='LOYALTY_CON'";
    $sql_prod_dv="select sku from products_last where segment='LOYALTY_DV' and sku='$sku' limit 1";
    $sql_prod_smb="select sku from products_last where segment='LOYALTY_SMB' and sku='$sku' limit 1";
    $sql_offer_oos ="select count(sku) from products_last where segment = 'LOYALTY_CON' and offer ='Hot Offer' and stock ='Out Of Stock';";
    $sql_offers="select count(sku) from products_last where offer = 'Hot Offer' and segment='LOYALTY_CON';";
    $sql_ro="select count(sku) from products_last where ro <> '[]' and segment='LOYALTY_CON';";
    $sql_oos="select count(sku) from products_last where stock = 'Out of Stock' and segment='LOYALTY_CON';";
    $sql_rrp="select rrp from products_last where sku='$sku' and segment = 'LOYALTY_CON';";
    $sql_outright="select count(sku) from products_last where ro = '[]' and segment='LOYALTY_CON';"; 
    $sql_name="select name,sku from products_last where sku='$sku' limit 1;";
    $sql_name_new="select name,orin from product_pricing where orin='$sku' limit 1;";
    $sql_sku="select sku from products_last where sku='$sku' or name ='$sku' limit 1;";
    $sql_ro_sku="select ro from products_last where sku='$sku' and segment ='LOYALTY_CON';";
    $sql_rrp_acc="select rrp from products_last where sku='$sku' and segment ='ACCESSORIES_CON';";
    $sql_ro_acc_sku="select ro from products_last where sku='$sku' and segment ='ACCESSORIES_CON';";
    $sql_loy_price="select price from products_last where sku='$sku' and segment ='LOYALTY_CON';";
    $sql_category="select category from products_last where sku='$sku' limit 1;";
    $sql_family="select family from products_last where sku='$sku' limit 1;";
    $sql_family_products="select distinct sku,name from products_last where family='$date';";
    $sql_date_last="select date_report from products_last order by date_report desc limit 1";
    $sql_hot_offer="select offer from products_last where sku='$sku' and segment ='LOYALTY_CON';";
    $sql_old_price="select price from products where sku='$sku' and segment ='LOYALTY_CON' and offer<>'Hot Offer' order by date_report desc limit 1;";
    $sql_results="select distinct sku,name from products_last where sku='$sku' or name like '%".$sku."%';";
    $sql_loy_points_history="select distinct date(date_report),price from products where sku='$sku' and segment ='LOYALTY_CON' and offer='Hot Offer' order by date_report desc;";
    $sql_stocks="select distinct date(date_report),stock from products where sku='$sku' and segment ='LOYALTY_CON' order by date_report desc limit 60;";
    $sql_categories="select distinct category,category FROM products_last order by category;";
    $sql_stock="select stock from products_last where sku='$sku' limit 1;";
    $sql_launch_date="select date(date_report) from products where sku='$sku' order by date_report asc limit 1;";
    $sql_find_price="select price from products_last where RRP=$rrp and segment ='LOYALTY_CON' and sku not in (100154564) limit 1;";
    $sql_closest_price="select price from products_last where segment='LOYALTY_CON' and offer <> 'Hot Offer' and price NOT IN (\"['1000.0 - 0.0']\",\"['10000.0 - 0.0']\") order by abs(rrp - $rrp),price desc limit 1;";
    $sql_previous_offer="select price from products where sku='$sku' and offer='Hot Offer' and segment ='LOYALTY_CON' order by date_report desc limit 1;";
    $sql_product_pricing="select concat(invoice_ex_gst,'-',dbp_ex_gst,'-',std_rrp_inc_gst,'-',std_rrp_ex_gst,'-',rebate,'-',invoice_price,'-',internal,'-',external)
    from product_pricing where orin='$sku';";
    $sql_rrp_new="select std_rrp_inc_gst from product_pricing where orin=$sku;";
    $sql_last_launch="select count(launch_date),launch_date from (select sku,name,min(date(date_report)) as launch_date from products group by sku,name order by launch_date desc)  as t group by launch_date limit 1";
    $sql_id_promo="select max(id) from promotions";
    $sql_rrp_saved="SELECT rrp FROM promotions where sku='$sku' and id=$date;";
    $sql_ro_saved= "SELECT ro FROM promotions where sku='$sku' and id=$date;";
    $sql_promo_name="SELECT prom_name FROM promotions where id=$sku limit 1;";
    $sql_promo_dates="SELECT concat(start_date,',',end_date) FROM promotions where sku='$sku' and id=$date;";
    $sql_saved_price="select price from promotions where sku='$sku' and id=$date";
    $sql_cat_orders="SELECT t2.category,sum(t1.day_sales_loy) as tot_sales FROM product_sales t1 inner join (select distinct sku,category from products_last) t2 on  t1.sku = t2.sku where t1.date_report=DATE_SUB(CURDATE(), INTERVAL 3 DAY) and category <> 'Miscellaneous' group by t2.category order by tot_sales desc;";


    $query="sql_".$parameter;
    //echo  ${$query};
    //echo $parameter;
    $result= mysqli_query($con, ${$query});
    $row_cnt = mysqli_num_rows($result);
     while($data = mysqli_fetch_array($result)){
      
        switch(true){
            case ($row_cnt == 1):
                $trend = $data[0];  
                if (!empty($data[1])){
                $trend.= " - ".$data[1];       
                }

                break;
            case ($row_cnt > 1):
                $sku = $data[0]; 
                $name = $data[1];
                $trend.= $sku."*".$name."#";
                break; 
        }     
    }

 return $trend;
}
///////////////////////// End Get database values/////////////////////////////////////



///////////////////////// Check number of results from database/////////////////////////////////////
function num_results($sku,$date=null){
    include 'data/db_connection.php';
    $sql="select distinct sku,name from products_last where sku='$sku' or name like '%".$sku."%';";
    $result= mysqli_query($con, $sql);
    $num_results = mysqli_num_rows($result);

return $num_results;
}
///////////////////////// End Check number of results from database/////////////////////////////////////


function insert_trend($parameter, $row){
    include 'data/db_connection.php';

    $values= explode("*",$row);

    $query = "INSERT INTO product_pricing(solomon,orin,`name`,category,invoice_ex_gst,dbp_ex_gst,std_rrp_inc_gst,std_rrp_ex_gst,rebate,invoice_price,internal,`external`) 
    values($values[1],$values[0],'$values[2]','$values[8]',$values[3],$values[4],$values[5],$values[6],$values[7],0,0,0)";
   //echo $query;
    mysqli_query($con, $query);


}

function insert_price($row,$target,$name,$id,$crud){
    include 'data/db_connection.php';

    $values= explode("*",$row);
    $dates=explode(",",$values[3]);
    $date_dmy=explode(" ",$dates[0]);
    $datex=explode("/",$date_dmy[0]);
    $start_date= $datex[2]."-".$datex[1]."-".$datex[0];
    $start_date .= " ".$date_dmy[2];
    //echo $date_dmy[2];

    $date_dmy2=explode(" ",$dates[1]);
    $datex2=explode("/",$date_dmy2[0]);
    $end_date= $datex2[2]."-".$datex2[1]."-".$datex2[0];
    $end_date .= " ".$date_dmy2[2];

        //sku(0),rrp(1),tiers pricing(2), dates(3), check ro(4), fwac(5)

    if($crud=="update"){
        $sku=trim($values[0]);
       $query="UPDATE promotions SET 
        `id` = $id,
        `prom_name` = '$name',
        `sku` = '$sku',
        `prod_name` ='$name',
        `type` = '$target',
        `rrp` = $values[1],
        `price` = '$values[2]',
        `rebate` = $values[5],
        `ro` = '$values[4]',
        `start_date` = '$start_date',
        `end_date` = '$end_date' 
        WHERE sku='$sku' and id=$id";
    }else{
    $sku=trim($values[0]);
    $query="INSERT INTO promotions (`id`,`prom_name`,`sku`,`prod_name`,`type`,`rrp`,`price`,`rebate`,`ro`,`start_date`,`end_date`) 
    values($id,'$name','$sku',' ','$target',$values[1],'$values[2]',$values[5],'$values[4]','$start_date','$end_date')";
    }
    //echo $query . "<br>";
    mysqli_query($con, $query);


}




?>