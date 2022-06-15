<?php
header('Content-Type: application/json'); 
include('data/db_connection.php');



$column = array("orin", "solomon", "name", "invoice_ex_gst", "dbp_ex_gst", "std_rrp_inc_gst", "std_rrp_ex_gst", "rebate", "category");

$query = "SELECT orin,solomon,`name`,invoice_ex_gst,dbp_ex_gst,std_rrp_inc_gst,std_rrp_ex_gst,rebate,category FROM product_pricing "; 

//echo $query;


 $query .= '
 WHERE category <> "exported" and orin not in (select sku from products_last where segment="LOYALTY_CON")

 ';




$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query); 

$statement->execute();

$result = $statement->fetchAll();

$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['orin'];
 $sub_array[] = $row['solomon'];
 $sub_array[] = $row['name'];
 $sub_array[] = $row['invoice_ex_gst'];
 $sub_array[] = $row['dbp_ex_gst'];
 $sub_array[] = $row['std_rrp_inc_gst'];
 $sub_array[] = $row['std_rrp_ex_gst'];
 $sub_array[] = $row['rebate'];
 $sub_array[] = $row['category'];
 $data[] = $sub_array;
}

function count_all_data($connect)
{
 $query = "SELECT orin,solomon,`name`,invoice_ex_gst,dbp_ex_gst,std_rrp_inc_gst,std_rrp_ex_gst,rebate,category FROM product_pricing WHERE category <> 'temp'";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

$output = array(
 'draw'   => intval($_POST['draw']),
 'recordsTotal' => count_all_data($connect),
 'recordsFiltered' => $number_filter_row,
 'data'   => $data
);

echo json_encode($output);

?>
