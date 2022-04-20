<?php

//action.php

include('data/db_connection.php');

if($_POST['action'] == 'edit')
{
 $data = array(
  ':invoice_ex_gst'  => $_POST['invoice_ex_gst'],
  ':dbp_ex_gst'  => $_POST['dbp_ex_gst'],
  ':std_rrp_inc_gst'   => $_POST['std_rrp_inc_gst'],
  ':std_rrp_ex_gst'  => $_POST['std_rrp_ex_gst'],
  ':rebate'   => $_POST['rebate'],
  ':category'   => $_POST['category'],
  ':orin'    => $_POST['orin']
 );

 $query = "
 UPDATE product_pricing 
 SET invoice_ex_gst = :invoice_ex_gst,  
 dbp_ex_gst = :dbp_ex_gst, 
 std_rrp_inc_gst = :std_rrp_inc_gst,
 std_rrp_ex_gst = :std_rrp_ex_gst,  
 rebate = :rebate,
 category = :category
 WHERE orin = :orin
 ";
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
