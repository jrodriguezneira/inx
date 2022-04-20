<?php include 'login/ses.php'; ?>
<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>T+OPS</title>

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
    <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">


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
                        <h1 class="h3 mb-0 text-gray-800"><b>Products</b> </h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> <?php echo get_trend('date_last'); ?></a>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Active Products</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a id="export" class="dropdown-item" href="#">Create Offer</a>
                                            
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body content goes here -->
                                <div class="card-body">
                                
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th>Sku</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>RRP</th>
                                        <th>Stock</th>

                                        
                                        </tr> 
                                    </thead>
                                    
                                    </table>
                                    

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

   


<!-- Modal Search-->
<?php //include 'searchmodal.php'; ?>
<!-- End Modal Search-->

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

    <!-- Page level select custom scripts -->
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>


<script>
/* Formatting function for row details - modify as you need */
function format(d) {
  // `d` is the original data object for the row
  return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    '<tr>' +
    '<td>Points Pay:</td>' +
    '<td>' + d.price.slice(1,-1).replaceAll("'"," ").replaceAll(",","<br>") + '</td>' + 
    '</tr>' +
    '</table>';
}

$(document).ready(function() {
  var table = $('#example').DataTable({
    'ajax': 'pro_json.php',
    'columns': [{
        'className': 'select-checkbox',
        'orderable': false,
        'data': null,
        'defaultContent': ''
      },
      {
        'data': 'sku'
      },
      {
        'data': 'name'
      },
      {
        'data': 'category'
      },
      {
        'data': 'rrp'
      },
      {
        'data': 'stock'
      }
    ],
    select: {
            style:    'os',
            selector: 'td:first-child'
        },
    'order': [
      [1, 'asc']
    ]
  });

  // Add event listener for opening and closing details
  $(document).ready(function () {
    var table = $('#example').DataTable();
    var order_array=[];

    $('#example tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
        //Append text box for pay  to table
        order_array.push(table.row(this).data().sku);
    });

    $('#export').click( function () {
      var skus='';
    for (var i = 0; i < table.rows('.selected').data().length; i++) { 
       console.log( table.rows('.selected').data()[i].sku)
       skus += 'sku' + order_array.indexOf(table.rows('.selected').data()[i].sku) + '=' + table.rows('.selected').data()[i].sku + '*' + table.rows('.selected').data()[i].stock + '&';
    }
    
    var url = 'off-cr.php?' + skus + 'q=' + table.rows('.selected').data().length;
    console.log( url ); 
    window.location.href = url;
  } );

});


});
</script>

    
</body>




</html>