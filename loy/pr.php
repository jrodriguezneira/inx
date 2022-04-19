<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>T+ops</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800"><b>
                        <?php 
                        $sku= get_trend("sku",$_GET['text_sku_search']);
                        $name= get_trend("name",$sku);
                        echo $name;
                        ?> 
                        </b> </h1>
                        <a href="#" title="Last Update" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-check fa-sm text-white-50"></i> <?php 
                                echo $last_date;
                                ?></a>
                    </div>

                    <!-- Modal Search-->
                    <?php include 'searchmodal.php'; ?>
                    <!-- End Modal Search-->

                                      
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Loyalty RRP Price-->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Loyalty</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php echo "RRP $".get_trend("rrp",$sku,$last_date)?>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loyalty RO Option -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Loyalty RO</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <!-- Organise string for RO options   -->
                                            <?php echo ro_options(get_trend("ro_sku",$sku,$last_date));?>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RRP accessories -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Accessories
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    
                                                </div>
                                                <div class="col">
                                                   
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                    <?php echo "RRP $".get_trend("rrp_acc",$sku,$last_date)?>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RO Accessories -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Accessories RO</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                            <?php echo ro_options(get_trend("ro_acc_sku",$sku,$last_date));?>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Loyalty pricing -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Pricing - Segments available -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Loyalty Pricing
                                    <?php
                                        $hot_offer= get_trend('hot_offer',$sku,$last_date);
                                        if($hot_offer== "Hot Offer"){
                                        echo "<span class='price'> (Before Hot Offer)</span>";
                                    }
                                    ?>          
                                    
                                    
                                    <br><br>Consumer 
                                    <?php
                                    
                                    
                                    if(!empty(get_trend("prod_dv",$sku))){
                                    echo "| DaVinci ";
                                    }
                                    if(!empty(get_trend("prod_smb",$sku))){
                                    echo "| SMB";
                                    }
                                    ?>
                                    </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a class="dropdown-item" href="#">History</a>
                                            <a class="dropdown-item" href="#">Export</a>
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body - Pricing -->
                                <div class="card-body">
                                    
                                <?php 

                                if($hot_offer== "Hot Offer"){

                                multi_pricing(get_trend("old_price",$sku,$last_date));   

                                }else{
                                
                                multi_pricing(get_trend("loy_price",$sku,$last_date));
                                
                                }
                                
                                
                                ?>

                                </div>
                            </div>
                        </div>

                        <!-- Hot Offer -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Pricing - Segments available - Menu-->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Hot Offer
                                    <?php
                                        if($hot_offer== "Hot Offer"){
                                        echo "<span class='offer'> (Active)</span>";
                                    }else{

                                        echo "<span class='price'> (Not available)</span>";
                                    }
                                    ?>                                  
                                                                   
                                    <br><br> </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <?php 
                                            echo "<a class='dropdown-item' href=\"https://staging-sr9-loy-ing-awsserv.site/inx/loy/pr.php?text_sku_search=".$sku."&flag=loy_points_history\">History</a>";
                                            
                                            echo "<a class='dropdown-item' href=\"https://staging-sr9-loy-ing-awsserv.site/inx/loy/pr.php?text_sku_search=".$sku."&flag=close&history=enabled\">Export</a>";
                                            ?>
                                            
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body - Pricing -->
                                <div class="card-body">
                                    
                                <?php 
                                 if($hot_offer== "Hot Offer"){

                                multi_pricing(get_trend("loy_price",$sku,$last_date));
                                    
                                }

                                ?>
                                </div>
                            </div>
                        </div>

                        <!-- Stock category details -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Details -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Details</h6>
                                    <div class="dropdown no-arrow">
                                        
                                    </div>
                                </div>
                                <!-- Card Body - stock category details -->

                                 
                            <div class="row">

                                <!-- Blue Card - Stock -->
                                
                                <div class="col-lg-7 mb-4">
                                  <br>
                                    
                                    <div class="card bg-primary text-white shadow spacer">
                                        <div class="card-body">
                                            <?php
                                            
                                            $stock= get_trend("stock",$sku,$last_date);
                                            if($stock=="Out Of Stock"){
                                            echo "<span class='oos'>".$stock."</span>";
                                            }
                                           else{
                                            echo $stock;
                                           }
                                            echo "<a class='box_link' href=\"https://staging-sr9-loy-ing-awsserv.site/inx/loy/pr.php?text_sku_search=".$sku."&flag=stock\"> (History)</a>";
                                            ?> 
                                            
                                            <div class="text-black-50 small">
                                            Stock 
                                            
                                            
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>

                                <!-- Green Card - Category -->
                                
                                <div class="col-lg-7 mb-4">
                                
                                    <div class="card bg-success text-white shadow spacer">
                                        <div class="card-body">
                                        <?php echo get_trend("category",$sku);?>
                                            <div class="text-black-50 small">Category</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Light green Card - Family -->

                                <div class="col-lg-7 mb-4">
                                    <div class="card bg-info text-white shadow spacer">
                                        <div class="card-body">
                                        <?php $family= get_trend("family",$sku);
                                                echo $family;
                                        ?>
                                            <div class="text-black-50 small">Family</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Family products list -->

                                <div class="col-lg-12 mb-4">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                        <?php echo multi_products(get_trend("family_products",$sku,$family));?>
                                        <?php //echo multi_products(get_trend("results",$_GET['text_sku_search']));?>
                                            <div class="text-black-50 small">Family Products</div>
                                        </div>
                                    </div>
                                </div>
                                                          
                            </div>       

                                
                            </div>
                        </div> 
                    </div>


                    <!-- ------------------------Bottom boxes -->                         
                    <div class="row">

                        <!-- Stock Column -->
                        <div class="col-lg-12 mb-12">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-12">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Additional Details</h6>
                                </div>

                                <div class="card-body">

                                   <span><b>Launch date:</b>  <?php echo get_trend("launch_date",$sku);?> </span>
                                    
                                </div>
                            </div>

                            <!-- Color System -->
                            

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

    <!--libraries--------------------------------------------------------------------------------------------------->

   <!-- Jquery -->
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
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!--End libraries--------------------------------------------------------------------------------------------------->

    
</body>

  <!-- Search selection window -->
  <?php
    $num_results=num_results($_GET['text_sku_search'],$last_date);
    if( ($_GET['flag'] != "close" && $num_results >1)   || (($_GET['flag'] == "loy_points_history" || $_GET['flag'] == "stock") && $num_results >=1 )  ){
    ?>
        <script>
        $('#exampleModalLong').modal('show')
        </script>
    <?php } ?>
    <!-- End Search selection window -->

    
    <!-- Export pricing hstory as excel file -->
    <?php
    if($_GET['history'] == "enabled"){
        include 'extractors/db-to-file.php';
        $sku=$_GET['text_sku_search'];
        $loy_price=extract_pricing(get_trend("loy_price",$_GET['text_sku_search']));
        $old_loy_price= extract_pricing(get_trend("old_price",$_GET['text_sku_search']));   
        create_excel($sku,$name,$old_loy_price,$loy_price);
        }
    ?>
    <!-- End Export pricing hstory as excel file -->


</html>