<?php
$con=mysqli_connect("192.254.236.136","stagierv_insight","Painkiller789*","stagierv_insights");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$connect = new PDO("mysql:host=192.254.236.136; dbname=stagierv_insights", "stagierv_insight", "Painkiller789*");

   
?>