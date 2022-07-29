<?php
include 'data/db_connection.php'; 

if(isset($_POST['checking_viewbtn']))
{
    $rrp = $_POST['rrp'];
    $sku = $_POST['sku'];
    $tier = $_POST['tiers'];


    // echo $return = $s_id;

    $query = "select distinct price,rrp from price_tiers 
    where tiers = $tier  
    order by abs(rrp - $rrp),price desc limit 3";
    //echo $query;
    $query_run = mysqli_query($con, $query);


    if(mysqli_num_rows($query_run) > 0)
    {
        foreach($query_run as $id => $row)
        {
            
            $price= "{\"price\":".str_replace("'","\"",$row['price'])."}";
            $price_array = json_decode($price,true);
            $price2 = array_reverse($price_array["price"]);

            $tiers.= '<div id="tab" style="float:left;width:150px;"><table border=0><tr><td style="border-bottom: 1px solid #f1f1f1;padding:5px;" colspan="2"><b>RRP</b>: '.$row['rrp'].'</td></tr>';

            foreach($price2 as $key => $element)  {
                $prices[$id] .= $element.",";
                $points_pay=explode("-",$element);
                $points=intval($points_pay[0]);
                $pay=intval($points_pay[1]);

                $tiers.= "<tr><td>".$points."</td><td>".$pay."</td></tr>";

            }   
            
            $tiers .= '</table><br><button class="btn btn-link" onclick="javascript:Fill_Price('.$sku.',\''.$prices[$id].'\');">Use Price</button></div>';

            
        }
        echo $return = $tiers;
    }
    else
    {
        echo $return = "<h5>No Record Found</h5>";
    }

}
?>