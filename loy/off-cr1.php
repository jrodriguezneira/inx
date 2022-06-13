<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>
<?php include 'business/create_trends.php'; ?>


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

                <!-- ////////////////////////Create offer UI elements for products ///////////////////////////////////////////////////////////////////////-->
                    
                <?php
                //Number of skus =1
                $i= $_GET['i'];
                //File format to export
                $target= $_GET['target'];
                for ($x = 0; $x < $i; $x++) {
                $skus= $_GET['sku'.$x];
                //Divide array to obtain sku and get sku pricing and name details from database
                $sku = explode('*',$skus);                
                //Get current pricing 
                $loy_price=extract_pricing(get_trend("loy_price",$sku[0]));                 
                //Query to get sku and name
                $name= get_trend("name",$sku[0]);
                // If the target is for new products change the query source
                if($target=="product")
                {$name= get_trend("name_new",trim($sku[0]));}
                //Get name from name query
                $productname=explode('-',$name);
                //Get Current RRP when lfag is unchecked
                $rrp_old= get_trend("rrp_new",$sku[0]);
                $ro= get_trend('ro_sku',$sku[0]);
                if($ro== "[12, 24]"){
                $ini_ro= 1;    
                }else{$ini_ro= 0; }
                //Add current pricing (9) , name(10) , old RRP(11), initial RO(12) to sku array 
                $skus .= '*'. $loy_price. '*'.$productname[0].'*'.$rrp_old.'*'.$ini_ro.'&';
                //Attach price and name to skus array
                $prod .= $skus;
                }
                //Temporary display the array 
              // echo '<br>Prod'. $prod. "<br><br><br>";
               


                include 'extractors/offer-to-file.php'; 
                switch ($target) {
                    case "offer":
                        create_offer_file($prod);
                        break;
                    case "shop":
                        create_shop_file($prod);
                        break;
                    case "stock":
                        create_stock_file($prod);
                        break;
                    case "product":
                        create_product_file($prod);
                        break;
                }

             
                ?>
      
                <!-- ////////////////////////End Create offer UI elements for products ////////////////////////////////////////////////////////////////////
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

   
    
</body>

    


</html>

    