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

function insert_data($sku,$date,$prod_name,$stock,$ro,$rrp,$price,$offer,$family,$category,$segment,$stock_notice){

    $date= get_file_date($date);                                   

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
    
    if(strlen($rrp) == 0){
        $rrp=0;
    }

   // $stock_notice= str_replace('"',' ',$stock_notice);
    $sql1="insert into products_last (sku,date_report,name,stock,ro,rrp,price,offer,family,category,segment,stock_notice,launch_date) 
    values ('$sku','$date','$prod_name','$stock','$ro','$rrp',\"$price\",'$offer','$family',\"$category\",'$segment',\"$stock_notice\",null)";
    //echo $sql1;
           if(mysqli_query($con, $sql1)){
              echo "Records inserted successfully.";
           } else{
                   echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
           }
    
    $sql3="insert into products (sku,date_report,name,stock,ro,rrp,price,offer,family,category,segment,stock_notice,launch_date)
    values ('$sku','$date','$prod_name','$stock','$ro','$rrp',\"$price\",'$offer','$family',\"$category\",'$segment',\"$stock_notice\",null)";

           if(mysqli_query($con, $sql3)){
             //  echo "Records inserted successfully.";
           } else{
                   echo "ERROR: Could not able to execute $sql3" . mysqli_error($con);
    
            }
            
}

//Read data from website
function crawl_data($url){

    $json = file_get_contents($url);
    $assoc = json_decode($json, true);
    foreach ($assoc as $key => $value) {
        if($key=="time"){
            $date= $value;   
        }
        
        if($key=="data"){     
            $key2= $assoc['data'];        
            foreach ($key2 as $key3 => $value) {

                if($key3=="segment"){
                    $key0= $assoc['data']['segment'];        
                    foreach ($key0 as $key01 => $value) {
                        if($key01=="code"){
                            $segment=$value;
                        }
                    }

                }

                if($key3=="productFamilies"){
                    $key4= $assoc['data']['productFamilies'];        
                    foreach ($key4 as $key4 => $value) {

                        $key5= $assoc['data']['productFamilies']["$key4"];        
                        foreach ($key5 as $key6 => $value) {
                            if($key6=="name"){
                                $family=$value;

                                    $key7= $assoc['data']['productFamilies']["$key4"]['products'];        
                                    foreach ($key7 as $key8 => $value) {
                                
                                        $key9= $assoc['data']['productFamilies']["$key4"]['products']["$key8"];        
                                        foreach ($key9 as $key10 => $value) {
                                        
                                            if($key10=="sku"){
                                                $sku=$value;
                                            }
                                            if($key10=="name"){
                                                $prod_name=$value;
                                            }
                                            if($key10=="categoryName"){
                                                $category=$value;
                                            }
                                            if($key10=="rrp"){
                                                $rrp=$value;
                                            }
                                            
                                            if($key10=="currentPrice"){                                            
                                            //    $price="["; 

                                            //     $url2 = "https://tapi.telstra.com/presentation/v1/ecommerce-products/products/loyalty_con/$sku";

                                            //     $json1 = file_get_contents($url2);
                                            //     $assoc1 = json_decode($json1, true);
                                            //     foreach ($assoc1 as $key01 => $value1) {
                                                    
                                                    
                                            //         if($key01=="data"){  
                                                    
                                            //             $key02= $assoc1['data']['currentPrice']['priceOptions'];  
                                            //             foreach ($key02 as $key03 => $value2) {     
                                                        
                                            //                 $key04= $assoc1['data']['currentPrice']['priceOptions']["$key03"];  
                                            //                 foreach ($key04 as $key05 => $value) {

                                            //                     if($key05=="upfrontPrice"){
                                            //                         $points=$value;
                                            //                     }
                                            //                     if($key05=="ongoingPrice"){
                                            //                         $pay=$value;
                                            //                         $price.= "'".$points."-".$pay."',";
                                            //                     }  

                                            //                 }                                       
                                            //             }
                                            //         }

                                            //     }

                                            //      $price= substr_replace($price,"]",-1);
                                                 $price="[1,0]";

                                            }

                                            if($key10=="originalPrice"){
                                                if(!empty($value)){
                                                    $offer="Hot Offer";                                           
                                                }else{
                                                    $offer="None";    
                                                }

                                            }

                                            if($key10=="repaymentOptions"){
                                                $ro="[";
                                                $key15= $assoc['data']['productFamilies']["$key4"]['products']["$key8"]['repaymentOptions'];  
                                                foreach ($key15 as $key16 => $value) {
                                                    $ro.= $value.",";
                                                }
                                                if($ro=="["){
                                                $ro="[]";
                                                }else{
                                                $ro= substr_replace($ro,"]",-1);
                                                }
                                            }

                                            if($key10=="outOfStock"){
                                                    if($value==1){
                                                    $stk_message="Out Of Stock";
                                                    }else{
                                                    $stk_message="In Stock";
                                                    }
                                                
                                                $stock=$stk_message;
                                            }

                                            if($key10=="stockNotice"){
                                                $stock_notice=" ";
                                            }

                                        }             
                                        
                                        insert_data($sku,$date,$prod_name,$stock,$ro,"$rrp",$price,$offer,"$family","$category",$segment,$stock_notice);
                                       // echo $sku." ".$date." ".$prod_name." ".$stock." ".$ro." ".$rrp." ".$price." ".$offer." ".$family." ".$category." ".$segment." ".$stock_notice."<br>";


                                    }


                            }

                        }
                    }

                }
            
            }  

        }

    } 

}

//$url = 'https://tapi.telstra.com/presentation/v1/ecommerce-products/products?segments=';

//$segments=["loyalty_con"];

$con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");

$sql2="truncate table products_last";
        if(mysqli_query($con, $sql2)){
            //echo "Records inserted successfully.";
        } else{
                echo "ERROR: Could not able to execute $sql2" . mysqli_error($con);
        }

$url = 'https://tapi.telstra.com/presentation/v1/ecommerce-products/products?segments=loyalty_con';

crawl_data($url);

// foreach($segments as $key => $seg){

//     $urlx= $url . $seg;
//    // echo $urlx;
//     crawl_data($urlx);
//     $urlx="";
// }












?>