<?php
header('Content-Type: application/javascript');
//php header to obtain data graph from the database
include '../data/db_connection.php'; 
$sql="SELECT t2.category as cat,sum(t1.day_sales_loy) as tot_sales
FROM product_sales t1 inner join (select distinct sku,category from products_last) t2 on  t1.sku = t2.sku
where t1.date_report=DATE_SUB(CURDATE(), INTERVAL 3 DAY) and category <> 'Miscellaneous'
group by t2.category
order by tot_sales asc;";
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
  $sales.=$row['tot_sales'].",";
  $cats.="\"".$row['cat']."\",";
  }
  $sales=substr($sales, 0, -1); 
  $cats=substr($cats, 0, -1); 
?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
// Pie Chart Example
var ctx = document.getElementById("myPieChart2");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: [<?php echo $cats;?>],
    datasets: [{
      data: [<?php echo $sales;?>],
      backgroundColor: ['lime', '#1cc88a', '#3634cc','#4763df', '#1cc12a', '#36b76c','#4993df', '#f6c23e'],
      hoverBackgroundColor: ['lime', '#17a673', '#2c9faf', '#2e59d9', '#17a673', '#2c9faf', '#2e59d9', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)", 
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
