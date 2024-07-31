<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');


////////////Format date 
function get_file_date($filenamex){

    $datex= explode('T',$filenamex);
    foreach( $datex as $key => $datetime) {
        
        switch($key){
            case 0:
                $datex= $datetime;
                break;
            case 1:
                $times= $datetime;
                $newtime=explode('.',$times);
                $timex=$newtime[0];
                break;
        }       
    }
    $date= $datex." ".$timex;

return $date;

}

////////////Insert data into DB

function update_data($sku,$price){

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
    
    $sql1="update products_last set price=\"$price\" where sku='$sku'";

          if(mysqli_query($con, $sql1)){
              echo "Records updated successfully.";
           } else{
                   echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
           }
    
    // $sql3="insert into products (sku,date_report,name,stock,ro,rrp,price,offer,family,category,segment,stock_notice,launch_date)
    // values ('$sku','$date','$prod_name','$stock','$ro','$rrp',\"$price\",'$offer','$family',\"$category\",'$segment',\"$stock_notice\",null)";

    //        if(mysqli_query($con, $sql3)){
    //          //  echo "Records inserted successfully.";
    //        } else{
    //                echo "ERROR: Could not able to execute $sql3" . mysqli_error($con);
    
    //         }
            
}

//Read data from website
function crawl_data($sku){

            $price="["; 

            $url2 = "https://tapi.telstra.com/presentation/v1/ecommerce-products/products/loyalty_con/$sku";

            $json1 = file_get_contents($url2);
            $assoc1 = json_decode($json1, true);

            foreach ($assoc1 as $key01 => $value1) {
                
                
                if($key01=="data"){  
                
                    $key02= $assoc1['data']['currentPrice']['priceOptions'];  
                    foreach ($key02 as $key03 => $value2) {     
                    
                        $key04= $assoc1['data']['currentPrice']['priceOptions']["$key03"];  
                        foreach ($key04 as $key05 => $value) {

                            if($key05=="upfrontPrice"){
                                $points=$value;
                            }
                            if($key05=="ongoingPrice"){
                                $pay=$value;
                                $price.= "'".$points."-".$pay."',";
                            }  

                        }                                       
                    }
                }

            }

            $price= substr_replace($price,"]",-1);    
            
            update_data($sku,$price);
}

     

function obtain_catalogue(){

    sleep(2);

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
 
    $sql="select sku from products_last 
    where (LENGTH(price) - LENGTH(REPLACE(price, ',', '')) <2) or price='[1,0]'";
    
    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);
    while($data = mysqli_fetch_array($result)){
    
        $sku = $data[0]; 

        crawl_data($sku);
    }
}


obtain_catalogue();
obtain_catalogue();
obtain_catalogue();
obtain_catalogue();
obtain_catalogue();
obtain_catalogue();
















?>