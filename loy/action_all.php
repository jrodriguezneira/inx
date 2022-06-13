<?php

//action.php

include('data/db_connection.php');

if($_POST['action'] == 'edit')
{

if( empty($_POST['invoice_ex_gst'])){ $_POST['invoice_ex_gst'] = 0; }
if( empty($_POST['dbp_ex_gst'])){ $_POST['dbp_ex_gst'] = 0; }
if( empty($_POST['std_rrp_inc_gst'])){ $_POST['std_rrp_inc_gst'] = 0; }
if( empty($_POST['std_rrp_ex_gst'])){ $_POST['std_rrp_ex_gst'] = 0; }
if( empty($_POST['rebate'])){ $_POST['rebate'] = 0; }


 $data = array(
  ':invoice_ex_gst'  => $_POST['invoice_ex_gst'],
  ':dbp_ex_gst'  => $_POST['dbp_ex_gst'],
  ':std_rrp_inc_gst'   => $_POST['std_rrp_inc_gst'],
  ':std_rrp_ex_gst'  => $_POST['std_rrp_ex_gst'],
  ':rebate'   => $_POST['rebate'],
  ':orin'    => $_POST['orin']
 );

 $query = "
 UPDATE product_pricing 
 SET invoice_ex_gst = :invoice_ex_gst,  
 dbp_ex_gst = :dbp_ex_gst, 
 std_rrp_inc_gst = :std_rrp_inc_gst,
 std_rrp_ex_gst = :std_rrp_ex_gst,  
 rebate = :rebate 
 WHERE orin = :orin
 ";
 
 //echo $query;
 $ori=$_POST['orin'];
 $que= "select * from product_pricing where orin='$ori'";

 $result= mysqli_query($con, $que);
 $row_cnt = mysqli_num_rows($result);

 while($datax = mysqli_fetch_array($result)){
    $invoice_ex_gst = $datax[4]; 
    $dbp_ex_gst = $datax[5];
    $std_rrp_inc_gst = $datax[6]; 
    $std_rrp_ex_gst = $datax[7]; 
    $rebate = $datax[8];   
    
}

 if($row_cnt<1){

        $quer = "INSERT INTO product_pricing(solomon,orin,`name`,category,invoice_ex_gst,dbp_ex_gst,std_rrp_inc_gst,std_rrp_ex_gst,rebate,invoice_price,internal,`external`) 
        values(0,'$ori','name','exported',0,0,0,0,0,0,0,0)";
        echo $quer;
        mysqli_query($con, $quer);

    }
    
   
    
    function insert_price($type,$price){
        
        global $ori;
        global $con;
        $datex= date("Y-m-d");
        $queryx = "INSERT INTO pricing_history(orin,price_type,price,price_date)  
        values ( '$ori','$type',$price,'$datex')";
        echo $queryx;
        // $query_log = "INSERT INTO logs() values ( $type = price update, $query) 

        mysqli_query($con, $queryx);
       // mysqli_query($con, $query_log);
       
    }
    
    if( $_POST['invoice_ex_gst'] != $invoice_ex_gst){ insert_price('invoice_ex_gst',$_POST['invoice_ex_gst']);}
    if( $_POST['dbp_ex_gst'] != $dbp_ex_gst){ insert_price('dbp_ex_gst',$_POST['dbp_ex_gst']);}
    if( $_POST['std_rrp_inc_gst'] != $std_rrp_inc_gst){ insert_price('std_rrp_inc_gst',$_POST['std_rrp_inc_gst']);}
    if( $_POST['std_rrp_ex_gst'] != $std_rrp_ex_gst){ insert_price('std_rrp_ex_gst',$_POST['std_rrp_ex_gst']);}
    if( $_POST['rebate'] != $rebate){ insert_price('rebate',$_POST['rebate']);}
    

 $statement = $connect->prepare($query);
 $statement->execute($data);
 echo json_encode($_POST);


}

if($_POST['action'] == 'delete')
{
 $query = "
 DELETE FROM product_pricing 
 WHERE orin = '".$_POST["orin"]."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 echo json_encode($_POST);
}


?>
