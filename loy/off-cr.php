<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>
<?php include 'business/create_trends.php'; 
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
error_reporting(0);
?>


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
                        if($_GET['a'] == "new"){
                        $title= "Product Pricing";}
                        else {
                        $title= "Create Offer";}
                       
                        echo "<label id='poi_val'>$title</label>";
                        

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
                
                // Display sku, name and pricing for products selected
                // q quantity of items
                $q= $_GET['q'];
                //a flag for new products
                $a=$_GET['a'];
                $z=0;
                for ($x = 0; $x < $q; $x++) {
                $skux= $_GET['sku'.$x];
                $skustock= explode("*",$skux);
                $sku=$skustock[0];
                $skus+= $sku.",";               
                ?>
                    
                    <!-- Row for products-->
                    <div class="row">

                        <!-- Loyalty pricing -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><div class="sku_cel">
                                        <?php echo get_trend("name",$sku); 
                                        if($a=="new"){
                                        echo get_trend("name_new",$sku);
                                        }
                                        
                                        ?></div>
                                    <?php
                                        $hot_offer= get_trend('hot_offer',$sku,$last_date);
                                        if($hot_offer== "Hot Offer"){
                                        echo "<span class='price'> (Before Hot Offer)</span>";
                                    }
                                    ?> 
                                    <?php
                                        $ro= get_trend('ro_sku',$sku,$last_date);
                                        if($ro== "[12, 24]"){
                                        echo "<span class='price'> (RO 12 and 24 months )</span>";                                       
                                        }
                                    ?>          
                                    <br><br></h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <a  class="dropdown-item" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Show/Hide</a>
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="collapse show multi-collapse" id="multiCollapseExample<?php echo $z+1?>">
                                <div class="card-body">
                                    <?php 

                                   if($a=="new"){
                                        //$detail = explode("_", $sku);
                                        $rrp = get_trend("rrp_new",$sku);
                                        //$pricing=get_trend("find_price",$sku,$last_date,$rrp);                                       
                                        $pricing=get_trend("closest_price",$sku,$last_date,$rrp);                                          
                                        $count_tiers= count(explode(",",$pricing));
                                      //  echo "<input type='hidden' class='hid_tie' id='".$sku."_hid_tie' value='$count_tiers'>";    

                                    }
                                                                
                                        //echo "<table><tr><td class='sku_cel'>". get_trend("name",$sku). "</td><td> RRP $".get_trend("rrp",$sku,$last_date)."</td><td>";
                                        
                                        if($hot_offer== "Hot Offer"){
                                        multi_pricing(get_trend("old_price",$sku,$last_date),$sku);   
                                        }else{                                        
                                        
                                            if($a=="new")  {
                                            multi_pricing($pricing,$sku,$a);
                                            }else{
                                            multi_pricing(get_trend("loy_price",$sku,$last_date),$sku);
                                            }                                  
                                        }                                        
                                        echo "</td></tr></table>";
                                        echo "<input type='hidden' class='hid_tie_stock' id='".$sku."_hid_tie_stock' value='$skustock[1]'>";
                                        $previous_offer= get_trend("previous_offer", $sku);
                                        
                                    
                                    ?>

                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- End Loyalty Pricing-->

                        

                        <!-- Create New Offer -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between"> 
                                    <div id="rrp_offer_chk">
                                        <h6 class="m-0 font-weight-bold text-primary offer_text">Offer </h6>
                                        
                                        <input id="<?php echo $sku;?>_txt_new_rrp" class="txt_new_rrp" type="text" size="10px" placeholder="New RRP">
                                        
                                        <div id="rrp_update">
                                        <input type="checkbox" class="chk_rrp" title="Update RRP for offer report" checked <?php if($ro== "[12, 24]"){ echo "checked ";}?> id="<?php echo $sku; ?>_chk_rrp" value="ro">
                                        </div>
                                        
                                        <div id="ro_offer">
                                        <input type="checkbox" class="chk_ro" title="Offer" <?php if($ro== "[12, 24]"){ echo "checked ";}?> id="<?php echo $sku; ?>_chk_ro" value="ro"><label for="ro"> &nbsp; RO </label>
                                        </div>
                                    </div>
                                    
                                   <br><br>
                                    
                                    
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <?php 
                                        
                                            echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Create_Offer(".$sku.")'>Create Offer</a>";
                                            if($previous_offer){
                                            $pre=extract_pricing($previous_offer);
                                            echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Previous_Offer(\"".$pre."\",".$sku.")'>Previous Offer</a>"; 
                                            }
                                            echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Clear_Offer(".$sku.")'>Clear Offer</a>";
                                            ?>
                                            
                                            </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="collapse show multi-collapse" id="multiCollapseExample<?php echo $z+2?>">
                                <div class="card-body">
                                    
                                    <?php 
                                    
                                    if($a=="new"){
                                    multi_boxes($pricing,$sku);
                                    echo "<a href= 'javascript:void(0)' onClick='javascript:Add_Boxes(".$sku.")' title='Add Tier'>+</a> &nbsp;&nbsp;";
                                    echo "<a href= 'javascript:void(0)' onClick='javascript:Remove_Boxes(".$sku.")' title='Remove Tier'>-</a>";

                                    }else{
                                    multi_boxes(get_trend("loy_price",$sku,$last_date),$sku);
                                    } 
                                    
                                    echo "<div class='copy_paste'>
                                    <a href= 'javascript:void(0)' onClick='javascript:Copy_Tiers(".$sku.")' class='tb_copy' title='Copy Tiers'></a>
                                    <a href= 'javascript:void(0)' onClick='javascript:Paste_Tiers(".$sku.")' class='tb_paste'  title='Paste Tiers'></a>
                                    </div>";
                                    ?>
                                
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Create New offer-->



                        <!-- Offer Dates -->
                        <div class="col-xl-3 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Dates</h6>
                                   
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header"></div>
                                            <?php 
                                            if($a=="new"){
                                            echo "<a class='dropdown-item' id='offer_file' href= 'javascript:void(0)' onClick='javascript:Create_File(\"product\")'>Export Product Pricing</a>"; 
                                            }else{                                           
                                             echo "<a class='dropdown-item' id='offer_file' href= 'javascript:void(0)' onClick='javascript:Create_File(\"offer\")'>Export Offer File</a>";                                             
                                             echo "<a class='dropdown-item' id='shop_file' href= 'javascript:void(0)' onClick='javascript:Create_File(\"shop\")'>Export Shop File</a>";
                                             echo "<a class='dropdown-item' id='shop_file' href= 'javascript:void(0)' onClick='javascript:Create_File(\"stock\")'>Export Stock File</a>";
                                             echo "<a class='dropdown-item' id='shop_file' href= 'javascript:void(0)' onClick='javascript:Populate_Dates()'>Same Dates</a>";
                                            }
                                            ?>
                                            
                                            </div>
                                    </div>

                                </div>
                                <!-- Card Body -->

                                 <!-- Dates -->
                                 <div class="collapse show multi-collapse" id="multiCollapseExample<?php $z = $z +3; echo $z; ?>">
                                <div class="row">
                                    
                                        <div class="col-lg-5 mb-4">
                                        <br>
                                        <table><tr>
                                        <td>
                                        <input type="datetime-local" class="date_pick"  id="<?php echo $sku; ?>_txt_sta" >  </td>
                                        <td>
                                        <input type="datetime-local" class="date_pick"  id="<?php echo $sku; ?>_txt_end" >  </td>
                                        </tr></table>

                                        </div>
                                    
                                
                                                            
                                </div>       
                                </div>  
                                
                            </div>
                        </div> 
                        <!-- End offer dates-->
                    </div>
                    <!-- End row -->

                <?php } ?>

                <!-- ////////////////////////End Create offer UI elements for products ///////////////////////////////////////////////////////////////////////-->

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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

   <!-- Business script-->
   <script type="text/javascript" src="business/business.js"></script>

    <!-- UI script-->
    <script type="text/javascript" src="ui/ui.js"></script>
  
</body>
</html>



    