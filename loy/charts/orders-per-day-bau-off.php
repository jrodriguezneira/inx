<?php
header('Content-Type: application/javascript');
include '../data/db_connection.php'; 
$sql="SELECT date_report, SUM(day_sales_loy) AS daily_total
FROM product_sales
GROUP BY date_report
order by date_report limit 7;";
$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)) 
{ 
$sales.=$row['daily_total'].",";
$dates.="\"".$row['date_report']."\",";

  $sql1="SELECT SUM(day_sales_loy) AS daily_total1 
  FROM product_sales
  where sku in (select distinct sku from products where offer = 'Hot Offer' and segment='LOYALTY_CON' and date(date_report)='".$row['date_report']."') 
  GROUP BY date_report
  having date_report='".$row['date_report']."';";
  $result1=mysqli_query($con,$sql1);
  while($row1=mysqli_fetch_array($result1)) 
  { 
    $sales1.=$row1['daily_total1'].",";
    $sales2.=(int)$row['daily_total'] - (int)$row1['daily_total1'].",";
  }


}
$sales=substr($sales, 0, -1); 
$sales1=substr($sales1, 0, -1); 
$sales2=substr($sales2, 0, -1); 
$dates=substr($dates, 0, -1); 
?>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

var ctx = document.getElementById('myBarChart5').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [<?php echo $dates;?>],
            datasets: [{ 
                data: [<?php echo $sales;?>],
                label: "Total",
                borderColor: "#3e95cd",
                backgroundColor: "#7bb6dd",
                fill: false
              }, { 
                data: [<?php echo $sales2;?>],
                label: "BAU",
                borderColor: "#3cba9f",
                backgroundColor: "#71d1bd",
                fill: false
              }, { 
                data: [<?php echo $sales1;?>],
                label: "Offers",
                borderColor: "#ffa500",
                backgroundColor:"#ffc04d",
                fill: false
              }
            ]
          },
        });
