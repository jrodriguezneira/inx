<?php
header('Content-Type: application/json'); 
include('data/db_connection.php');

$column = array("orin", "solomon", "namex", "invoice_ex_gst", "dbp_ex_gst", "std_rrp_inc_gst", "std_rrp_ex_gst", "rebate","stock");

$query = "SELECT t1.sku as orin,t2.solomon, t1.`name` as namex,t2.invoice_ex_gst as invoice_ex_gst, t2.dbp_ex_gst as dbp_ex_gst,t2.std_rrp_inc_gst as std_rrp_inc_gst,
t2.std_rrp_ex_gst as std_rrp_ex_gst,t2.rebate as rebate, t1.stock as stock
FROM products_last AS t1 LEFT JOIN product_pricing AS t2 ON t1.sku = t2.orin ";

//echo $query;

if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE (t1.name LIKE "%'.$_POST["search"]["value"].'%" 
 OR orin LIKE "%'.$_POST["search"]["value"].'%") and t1.segment = "LOYALTY_CON"
 ' ;
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
 $sub_array[] = $row['namex'];
 $sub_array[] = $row['invoice_ex_gst'];
 $sub_array[] = $row['dbp_ex_gst'];
 $sub_array[] = $row['std_rrp_inc_gst'];
 $sub_array[] = $row['std_rrp_ex_gst'];
 $sub_array[] = $row['rebate'];
 $sub_array[] = $row['stock'];

 $trend ="";
 $or=$row['orin'];
 $que= "SELECT concat(price_type,' $',price,' ',date(price_date)) FROM pricing_history WHERE orin='$or'";
 $res= mysqli_query($con, $que);
 $row_cnt = mysqli_num_rows($res);
 while($datax = mysqli_fetch_array($res)){  
    $trend.= $datax[0]."#";  
 }

 $trend= substr($trend,0,-1);

$sub_array[] = $trend;

 $data[] = $sub_array;
}

function count_all_data($connect)
{
 $query = "SELECT t1.sku as orin,t2.solomon, t1.`name` as namex,t2.invoice_ex_gst as invoice_ex_gst, t2.dbp_ex_gst as dbp_ex_gst,t2.std_rrp_inc_gst as std_rrp_inc_gst,
 t2.std_rrp_ex_gst as std_rrp_ex_gst,t2.rebate as rebate, t1.stock as stock 
 FROM products_last AS t1 LEFT JOIN product_pricing AS t2 ON t1.sku = t2.orin
 WHERE t1.segment='LOYALTY_CON'";
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
