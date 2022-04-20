<?php
$con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$connect = new PDO("mysql:host=localhost; dbname=stagierv_insights", "stagierv_insight", "Painkiller789*");

   
?>