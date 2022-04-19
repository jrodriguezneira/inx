<?php
header('Content-Type: application/javascript');
//php header to obtain data graph from the database
include '../data/db_connection.php'; 
$sql="select count(sku)as total,category from products_last where segment ='LOYALTY_CON' and category <> 'Miscellaneous' group by category order by total;";
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
$stats.=$row['total'].",";
}
$cat=substr($stats, 0, -1);
?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Gaming", "Home & Internet", "Ipads & Tablets", "Watches & Wearables", "Technology & IoT", "Headphones & Speakers", "Cases & Portection", "Mobiles"],
    datasets: [{
      data: [<?php echo $cat;?>],
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
