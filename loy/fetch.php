<?php
//header('Content-Type: application/json'); 
include('data/db_connection.php');

$column = array("orin", "solomon", "name", "invoice_ex_gst", "dbp_ex_gst", "std_rrp_inc_gst", "std_rrp_ex_gst", "rebate");

$query = "SELECT orin,solomon,`name`,invoice_ex_gst,dbp_ex_gst,std_rrp_inc_gst,std_rrp_ex_gst,rebate FROM product_pricing";

//echo $query;

if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE name LIKE "%'.$_POST["search"]["value"].'%" 
 OR orin LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= ' ORDER BY orin DESC ';
}
$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query . $query1); 

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
 $data[] = $sub_array;
}

function count_all_data($connect)
{
 $query = "SELECT orin,solomon,`name`,invoice_ex_gst,dbp_ex_gst,std_rrp_inc_gst,std_rrp_ex_gst,rebate FROM product_pricing";
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
