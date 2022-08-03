<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; 
      include 'off_his_char_json.php';
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Insights</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        
        <!-- Start of Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>Hot Offers</b> </h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> <?php echo get_trend('date_last',$_GET['text_sku_search']); ?></a>
                    </div>

                    <!-- Content Row -->
                   

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-9 col-lg-9">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown --> 
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Active Offers</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a class="dropdown-item" href="#"></a>
                                            <a class="dropdown-item" href="#"></a>
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body content goes here -->
                                <div class="card-body">

                                <div id="chartDiv" style="max-width: 940px; min-width:330px; height: 450px;margin: 0px auto">
                                </div>
                                    

                                </div>
                            </div>
                        </div>

                     

                        <!-- Pie Chart -->
                       
                    </div>                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include 'logout.php'; ?>
    <!-- End Logout Modal-->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>



    <!-- Business script-->
    <script type="text/javascript" src="business/business.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


     <!-- Page level plugins -->
     <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    
    <!-- Gantt Char scripts  scripts -->
    <script src="https://code.jscharting.com/latest/jscharting.js"></script> 


<script>

// function Clear_JSON(data){
//   console.log(data[0]);
//   let datax= [];

// //datax[0]= String(data[0]).split('"');
// datax[0] = toString(data[0]).replace(/"/g, "");
// //datax[0]= data[0].split(String(data[0]).fromCharCode(92)).join(String(data[0]).fromCharCode(92,92))
// //datax[0]=data[0];
// console.log(datax);

// return data;
// }


  
// Helper functions to create axisTick label template with two columns of text describing each task. 
var columnWidths = [150, 30]; 
var span = function(val, width) { 
  return ( 
    '<span style="width:' + 
    width + 
    'px;">' + 
    val + 
    '</span>'
  ); 
}; 
var mapLabels = function(labels) { 
  return labels 
    .map(function(v, i) { 
      return span(v, columnWidths[i]); 
    }) 
    .join(''); 
}; 
  
var tickTemplate = mapLabels([ 
  '%name', 
  '{days(%high-%low):n0}d'
]); 
// tickTemplate -> '<span style="width:150px;">%name</span><span style="width:30px;">{days(%high-%low):n0}d</span>'; 
  
// Raw data 

<?php //echo Data_JSON(); 
$dates= "'7-1-2022','8-30-2022'";
$dates2= "'7-1-2022','9-30-2022'";

?>

var data = [ {   
  stage: 'Offers', 
  substage: 'Offers', 
  dates: [<?php echo $dates; ?>],  
  complete: 'Hot Offers'
},
<?php echo Data_JSON(); ?>

// {
//     stage: 'Product Launches', 
//     substage: 'Product Launches', 
//     dates: [<?php echo $dates2; ?>],  
//     complete: 0
//   }
  // { 
  //   stage: 'Product Launches', 
  //   substage: 'Amazon ', 
  //   dates: ['4/15/2022', '5/5/2022'] 
  // }, 
  // { 
  //   stage: 'Product Launches', 
  //   substage: 
  //     'Pet Accessories', 
  //   dates: ['5/5/2022', '7/8/2022'] 
  // }, 
  // { 
  //   stage: 'Price Changes', 
  //   substage: 'Price Changes', 
  //   dates: ['7/8/2022', '9/28/2022'], 
  //   complete: 0 
  // }
]; 

// Process data into series. 
// Creates a series for each 'stage' and a point for each 'substage' 
var series = JSC.nest() 
  .key('stage') 
  .key('substage') 
  .pointRollup(function(key, val) { 
    var values = val[0]; 
    return { 
      name: values.substage, 
      y: values.dates, 
      complete_y: values.complete 
    }; 
  }) 
  // .series(jString3); 
  .series(data); 

  
var chart = JSC.chart('chartDiv', { 
  debug: true, 
  
  // Gantt type setup 
  type: 'horizontal column', 
  zAxis_scale_type: 'stacked', 
  
  title_label_text: 
    '',
    //'Film Product Launches from %min to %max', 
  
  palette: 'fiveColor32', 
  
  // Y Axis settings 
  yAxis: { 
    scale_type: 'time', 
    crosshair_enabled: true
  }, 
  
  legend: { 
    position: 'inside right top', 
    template: '%icon %name'
  }, 
  
  defaultSeries: { 
    // Settings for the first point of each series. 
    firstPoint: { 
      xAxisTick: { 
        fill: '#4e73df', 
        padding: 5, 
        label: { 
          text: tickTemplate, 
          style: { fontWeight: 'bold',color: '#FFFFFF',fontSize: '14  px' } 
        } 
      }, 
      outline: { color: 'darkenMore', width: 2 }, 
      complete: { 
        fill: 'rgba(255,255,255,.4)', 
        hatch: { style: 'none' } 
      }, 
      label: { text: '%complete' } 
    }, 
    // Settings for all points 
    defaultPoint: { 
      // Large radius to ensure bars are rounded. 
      radius: 100, 
      outline_width: 0, 
      label: { 
        placement: 'inside', 
        align: 'left'
      }, 
      xAxisTick_label_text: tickTemplate, 
      tooltip: 
        '<b>%name</b> <br/>%complete<br/>%low - %high<br/>{days(%high-%low)} days'
    } 
  }, 
  
  series: series 
}); 


</script>

    
</body>




</html>