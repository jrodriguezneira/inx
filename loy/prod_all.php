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
                                class="fas fa-download fa-sm text-white-50"></i> <?php echo get_trend('date_last',$_GET['text_sku_search']); ?></a>

                                
                    </div>

                    <!-- Content Row -->
                   
                    <?php
                      //Export productc to excel file
                      if(isset($_GET['rep'])){           
                        include 'extractors/offer-to-file.php'; 
                        create_catalog_file();
                      }
                    ?>

                    <!-- Content Row -->

                      <div class="row">

                        <!-- Products Table-->
                        <div class="col-xl-9 col-lg-9">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Master Pricing</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a id="export" class="dropdown-item" href="#">Create Offer</a>  
                                            <a id="excel" class="dropdown-item" href="prod_all.php?rep=excel">Export All products(xls)</a>  
                                            
                                            </div>
                                    </div>
                                </div>
                                <!-- Products table details-->
                                <div class="card-body">
                                
                                    <table id="sample_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                      <thead>
                                          <tr>
                                          <th></th>
                                          <th></th>
                                          <th>orin</th>
                                          <th>solomon</th>
                                          <th>Name</th>
                                          <th>Invoice(ex GST)</th>
                                          <th>DBP(ex GST)</th>
                                          <th>STD RRP(inc GST)</th>
                                          <th>STD RRP(ex GST)</th>
                                          <th>Rebate</th>    
                                          <th>Stock</th>                                                               
                                        
                                          </tr> 
                                      </thead>                                    
                                    </table>
                                 </div>
                                 <!-- End Products table details-->
                            </div>
                        </div>                       
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

    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>


<script>
/* Formatting function for row details - modify as you need */

var selected = [];

function format(d) {
  // `d` is the original data object for the row
  var d = '\'' + d ;
  var prices = '';
  var prev = d.split(",")[9];
  var pri_change= prev.split("#");
        //Loop through tiers to assign values 
          prices += '<table><tr><td>Price Change</td><td>Value</td><td>Date</td></tr>'
          for (var i = 0; i < pri_change.length; i++) {
          var pri_det= pri_change[i].split(" ");
            if(pri_change.length>=1){
              if(pri_det[1] == null ){pri_det[1] = ' ';pri_det[2] = ' ';}
            prices += '<tr><td>' + pri_det[0] + '</td><td>' + pri_det[1] + '</td><td>' + pri_det[2] + '</td></tr>' ;
            }
          }
          prices += '</table>';
        
    
  return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    '<tr>' +
    '<td>' + prices + '</td>' +
    '</tr>' +
    '</table>'; 
}

$(document).ready(function(){
  

  var dataTable = $('#sample_data').DataTable({
  "processing" : true,
  "serverSide" : true,
  "order" : [],
  "ajax" : {
    url:"fetch_all.php",
    type:"POST"
  },
  Id: '0',
  "rowCallback": function( row, data ) {
           var data = '\'' + data + '\'';
           var id= data.split(",")[0].substring(1);
            if ( $.inArray(id, selected) !== -1 ) {
                $(row).addClass('selected');
            }
  },

  'columns': [{
        'className': 'details-control',
        'orderable': false,
        'data': null,
        'defaultContent': ''
        },        
        {
          'className': 'select-checkbox',
          'orderable': false,
          'data': null,
          'defaultContent': ''
        },
        {
          'data': '0'
        },
        {
          'data': '1'
        },
        {
          'data': '2'
        },
        {
          'data': '3'
        },
        {
          'data': '4'
        },
        {
          'data': '5'
        },
        {
          'data': '6'
        },
        {
          'data': '7'
        },
        {
          'data': '8'
        }
      ],
      select: {
              style:    'os',
              selector: 'td:first-child'
              
          },
      'order': [
        [2, 'asc']
      ] 

  });

    $('#sample_data tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selected);
 
        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }
 
        $(this).toggleClass('selected');
        console.log(selected);
    } );


    $('#sample_data').on('draw.dt', function(){
    $('#sample_data').Tabledit({
      url:'action_all.php',
      dataType:'json',
      columns:{
      identifier : [2, 'orin'],
      editable:[[5, 'invoice_ex_gst'], [6, 'dbp_ex_gst'], [7, 'std_rrp_inc_gst'],[8, 'std_rrp_ex_gst'],[9, 'rebate']]
      },
      restoreButton:false,
      onSuccess:function(data, textStatus, jqXHR)
      {
      if(data.action == 'delete')
      {
        $('#' + data.id).remove();
        $('#sample_data').DataTable().ajax.reload();
      }
      }
    });
    });


    $('#export').click( function () {
        var skus='';
      for (var i = 0; i < selected.length; i++) { 
         skus += 'sku' + selected.indexOf(selected[i]) + '=' + selected[i] + '*' + 'In Stock' + '&';
      }    
      var url = 'off-cr.php?' + skus + 'q=' + selected.length;
      console.log( url ); 
      window.location.href = url;
    } );


    // Add event listener for opening and closing details
  $('#sample_data tbody').on('click', 'td.details-control', function() {
    var tr = $(this).closest('tr');
    var row = dataTable.row(tr);

    if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass('shown');
    } else {
      // Open this row
      row.child(format(row.data())).show();
      tr.addClass('shown');
    }
  });

  // Handle click on "Expand All" button
  $('#btn-show-all-children').on('click', function() {
    let containers, user_name;
    var count = 0;
    table.rows().every(function() {
    //get data from row this will return values in json object..
      var d = this.data();
      if (!this.child.isShown()) {
        containers = document.createElement('div');
        containers.setAttribute('id', `container_${d.name.replace(' ', '_')}`);
        containers.innerHTML = d.name;//add value in inside div crated
        this.child(containers).show();
        $(this.node()).addClass('shown'); 
      }
    });
  });

  // Handle click on "Collapse All" button
  $('#btn-hide-all-children').on('click', function() {
    // Enumerate all rows
    dataTable.rows().every(function() {
      // If row has details expanded
      if (this.child.isShown()) {
        // Collapse row details
        this.child.hide();
        $(this.node()).removeClass('shown');
      }
    });
  });

});

</script>
    
</body>

</html>