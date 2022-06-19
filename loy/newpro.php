<?php include 'login/ses.php'; ?>
<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>
<?php include 'business/create_trends.php'; ?>
 <!-- UI script-->
 <script type="text/javascript" src="ui/ui.js"></script>

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

     <!-- Appzi: Capture Insightful Feedback -->

<script async src="https://w.appzi.io/w.js?token=uPz3X"></script>

<!-- End Appzi -->


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
                        <h1 class="h3 mb-0 text-gray-800"><b>New Products</b> </h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> <?php echo get_trend('date_last',$_GET['text_sku_search']); ?></a>
                    </div>

                    <!-- Content Row -->


                    <!-------------------------- If new products need to be added  --------------------->
                    <?php
                        if(isset($_GET['i'])) {
                            for ($x = 0; $x < $_GET['i']; $x++) {
                                $row= $_GET['row'.$x];
                                insert_trend("new_product", $row);
                            }
                        }                   
                    ?>
                    
                    <!-------------------------- If new products need to be added  --------------------->
                   

                    <!-- Content Row -->
                    <p>
 <!-- <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>-->
  <button id="but_new" class="btn btn-primary" type="button" onclick='javascript:Change_Text();' data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">+</button>
</p>
        

                    <div class="row">

      

                       

                        <!-- Area Chart -->
                        <div class="collapse show multi-collapse" id="multiCollapseExample1">
                        <div class="col-xl-12 col-lg-9">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">New Products</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a id="export2" class="dropdown-item" href="#">Create Pricing</a>
                                            
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body content goes here -->
                                <div class="card-body">
                                
                                <table id="sample_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th>orin</th>
                                        <th>solomon</th>
                                        <th>Name</th>
                                        <th>Invoice(ex GST)</th>
                                        <th>DBP(ex GST)</th>
                                        <th>STD RRP(inc GST)</th>
                                        <th>STD RRP(ex GST)</th>
                                        <th>Rebate</th>     
                                        <th>Launch Date</th>                                                               
                                       
                                        </tr> 
                                    </thead>
                                    
                                    </table>
                                    

                                </div>
                            </div>
                        </div>
                        </div>
                        

                     

                        <!-- Pie Chart -->

                         <!-- Area Chart -->
                         <div class="collapse multi-collapse" id="multiCollapseExample2">
                         <div class="col-xl-12 col-lg-9">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Products</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a id="export" class="dropdown-item" href="#">Save Products</a>
                                            
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body content goes here -->
                                <div class="card-body">
                                
                               <!-- <textarea  class="form-control" id="txa_skus" name="txa_skus" rows="10" cols="100"> </textarea> -->

                                    <table id="insert_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                   
                                        <th title="Required">Orin *</th>
                                        <th>Solomon</th>
                                        <th title="Required">Name *</th>
                                        <th title="Required">Invoice(ex GST) *</th>
                                        <th>DBP(ex GST)</th>
                                        <th title="Required">STD RRP(inc GST) *</th>
                                        <th>STD RRP(ex GST)</th>
                                        <th>Rebate</th>     
                                        <th>Launch Date</th>                                                               
                                       
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td><input type="text" id="orin_0" class="cell_new_price"  onpaste='javascript:Paste_Products()'>   </td>
                                        <td><input type="text" id="solomon_0" class="cell_new_price">   </td>
                                        <td><input type="text" id="name_0" class="cell_new_price_name">   </td>
                                        <td><input type="text" id="invoice_0" class="cell_new_price">   </td>
                                        <td><input type="text" id="dbp_0" class="cell_new_price">   </td>
                                        <td><input type="text" id="rrpinc_0" class="cell_new_price">   </td>
                                        <td><input type="text" id="rrpex_0" class="cell_new_price">   </td>
                                        <td><input type="text" id="rebate_0" class="cell_new_price">   </td>
                                        <td><input type="text" id="launch_0" class="cell_new_price">   </td>
                                        </tr>
                                    
                                
                                
                                    </tbody>

                                  

                                    <?php ?>

                                    
                                    </table>
                                    Paste from excel with columns order as above table.
                                    

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
    

  // Add event listener for opening and closing details
  //$(document).ready(function () {
    
    $('#export').click( function () {
  
  
   var row='';
   var x = document.getElementsByClassName("cell_new_price_name");

   for (var i = 0; i < x.length; i++) { 
        //Get SKU
        var cells =["orin","solomon","name","invoice","dbp","rrpinc","rrpex","rebate","launch"];

            var orin= 'orin_' + i;
            var solomon= 'solomon_' + i;
            var name= 'name_' + i;
            var invoice= 'invoice_' + i;
            var dbp= 'dbp_' + i;
            var rrpinc= 'rrpinc_' + i;
            var rrpex= 'rrpex_' + i;
            var rebate= 'rebate_' + i;
            var launch= 'launch_' + i;

            var orin_val = document.getElementById(orin).value;
            var solomon_val = document.getElementById(solomon).value;
            if(solomon_val=="" || solomon_val=="undefined"){solomon_val=0;}
            var name_val = document.getElementById(name).value;
            var invoice_val = document.getElementById(invoice).value;
            var dbp_val = document.getElementById(dbp).value;
            if(dbp_val=="" || dbp_val=="undefined"){dbp_val=0;}
            var rrpinc_val = document.getElementById(rrpinc).value;
            var rrpex_val = document.getElementById(rrpex).value;
            if(rrpex_val=="" || rrpex_val=="undefined"){rrpex_val=0;}
            var rebate_val = document.getElementById(rebate).value;
            if(rebate_val=="" || rebate_val=="undefined"){rebate_val=0;}
            var launch_val = document.getElementById(launch).value;

        // Create URL with information required to create the excel offer file
        // Array with sku details: sku(0),rrp(1), number of tiers(2),tiers pricing(3), dates(4)
        row += 'row' + i + '=' + orin_val + '*' + solomon_val + '*' + name_val + '*' + invoice_val + '*' + dbp_val + '*' + rrpinc_val + '*' + rrpex_val + '*' + rebate_val + '*' + launch_val +'&';
      } 
    // Append number of skus to offer URL (skus array) and export file type(target)
    row= 'i=' + i + '&' + row;
    var url = 'newpro.php?' + row;
    console.log("row" + row);
    window.open(url, '_self'); 

  } );


/* Formatting function for row details - modify as you need */

$(document).ready(function(){


var dataTable = $('#sample_data').DataTable({
 "processing" : true,
 "serverSide" : true,
 "order" : [],
 "ajax" : {
  url:"fetch_new.php",
  type:"POST"
 },
 'columns': [{
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
      [1, 'asc']
    ]
  


});

$('#sample_data tbody').on('click', 'tr', function () {
    $(this).toggleClass('selected');
});

$('#export2').click( function () {
      var skus='';
    for (var i = 0; i < dataTable.rows('.selected').data().length; i++) { 
       console.log( dataTable.rows('.selected').data()[i][0])
       //array_sku.push(table.rows('.selected').data()[i].sku);
       skus += 'sku' + i + '=' + dataTable.rows('.selected').data()[i][0] + '&';

       //alert( table.rows('.selected').data()[i].sku);
    }
    
    var url = 'off-cr.php?' + skus + 'q=' + dataTable.rows('.selected').data().length + '&a=new';
    console.log( url ); 
    window.location.href = url;
  } );


$('#sample_data').on('draw.dt', function(){
 $('#sample_data').Tabledit({
  url:'action_new.php',
  dataType:'json',
  columns:{
   identifier : [1, 'orin'],
   editable:[[2, 'solomon'],[3, 'name'],[4, 'invoice_ex_gst'], [5, 'dbp_ex_gst'], [6, 'std_rrp_inc_gst'],[7, 'std_rrp_ex_gst'],[8, 'rebate'],[9, 'category']] 
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
 
}); 



</script>

    
</body>




</html>