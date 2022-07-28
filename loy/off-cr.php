<?php include 'business/trends.php'; ?>
<?php include 'business/read_trends.php'; ?>
<?php include 'business/create_trends.php'; 
//error_reporting(E_ERROR | E_WARNING | E_PARSE); 
//error_reporting(0);
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

                <!-- Hide SKU search form  -->
                <script>
                    document.getElementById('form_sku_search').style.visibility='hidden';
                </script>

            <!-- Begin Page Content -->
            <div class="container-fluid">


                <!-- -------------------Modal for Offer Match-->
                <div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Closest Offers</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="offer-data">
                        </div>
                    </div>                  
                    </div>
                </div>
                </div>
                 <!-------------------- Modal for Offer Match-->


                <!-- Page Heading ---------------------------->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    <!-- Obtain promo name -->
                    <?php 
                    //Promo id when available
                    $stat=$_GET['stat'];
                    if($stat){$prom_name=get_trend("promo_name",$stat);}
                    //Type for new product or offer
                    if($_GET['a'] == "new"){
                    //a flag for new products
                    $a=$_GET['a'];
                    $title= "Product Launch Name";
                    $type="new";
                    }else {
                    $title= "Offer Name";
                    $type="offer";}                    
                    ?>

                    <!-- Promo ID when available -->
                    <input id='hid_prom' type='hidden' class='hid_promos'  value="<?php echo $stat; ?>">
                    <!-- Insert or Update offer  -->
                    <input id='hid_type' type='hidden' class='hid_types'  value=''>
                    <!-- New product or offer type -->
                    <input id='hid_prod' type='hidden' class='hid_prods'  value="<?php echo $a;?>">
                    <!-- Input to insert name, save offer and export file -->
                    <div class="head_buttons">
                        <h2 class="h3 mb-0 text-gray-800 lft"><input id='name' type='text' placeholder="<?php echo $title; ?>" value="<?php echo $prom_name; ?>"></h2>
                        <button id='sav_off' class='btn btn-primary lft' onclick="javascript:Save_Price('<?php echo $type; ?>');" type='button' >Save</button>                                            
                        <div class="dropdown lft">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php
                                if($a=="new"){
                                echo "<a class='dropdown-item' href='#' onclick='javascript:Export_File(\"product\");'>Product File</a>";
                                }else{
                                echo "<a class='dropdown-item' href='#' onclick='javascript:Export_File(\"offer\");'>Offer File</a>";
                                echo "<a class='dropdown-item' href='#' onclick='javascript:Export_File(\"shop\");'>Shop File</a>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Show Latest Data Update -->
                    <a href="#" title="Last Update" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-check fa-sm text-white-50"></i> <?php echo $last_date;?>
                    </a>
                </div>
            
                <!-- Modal Search-->
                <?php include 'searchmodal.php'; ?>
                <!-- End Modal Search-->

                <!-- ////////////////////////Create offer UI elements for products ///////////////////////////////////////////////////////////////////////-->
                     
                <?php
                
                // Display sku, name and pricing for products selected
                // q quantity of items
                $q= $_GET['q'];                
                $z=0;
                for ($x = 0; $x < $q; $x++) {
                $skux= $_GET['sku'.$x];
                $skustock= explode("*",$skux);
                $sku=$skustock[0];
                ?>
                    
                    <!-- Row for products-->
                    <div class="row">

                        <!-- Loyalty pricing -->
                        <?php  
                        // Change containers width depending on product launch or offer                                  
                        if($a=="new"){$col =4;}
                        else{$col=5;}
                        ?>


                        <div class="col-xl-<?php echo $col; ?> col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header  -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <div class="sku_cel">
                                        <?php echo get_trend("name",$sku); 
                                        if($a=="new"){
                                        echo get_trend("name_new",$sku);
                                        }                                        
                                        ?>
                                        </div>
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
                                        <br><br>
                                    </h6>
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
                                            $rrp = get_trend("rrp_new",$sku);
                                            $pricing=get_trend("closest_price",$sku,$last_date,$rrp);                                          
                                            $count_tiers= count(explode(",",$pricing));
                                        }
                                                                
                                       
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
                                        <?php 
                                        if($a=="new")
                                        {$text="RRP";}
                                        else{
                                        {$text="Offer";}
                                        }
                                        
                                        ?>
                                        <h6 class="m-0 font-weight-bold text-primary offer_text"><?php echo $text; ?> </h6>
                                        
                                        <input id="<?php echo $sku;?>_txt_new_rrp" class="txt_new_rrp" type="text" size="10px" placeholder=" RRP" value="<?php 
                                        if($a=="new"){echo $rrp;} 
                                        if($stat){
                                        $rrp_saved= get_trend("rrp_saved",$sku,$stat);
                                        echo $rrp_saved;
                                        }
                                        
                                        
                                        
                                        ?>">
                                        
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
                                            if($a=="new"){
                                            echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Create_Offer(".$sku.",\"".$a."\")'>Create Pricing</a>";
                                            }else{
                                            echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Create_Offer(".$sku.",\"".$a."\")'>Create Offer</a>";                                                    
                                            }
                                            if($previous_offer){
                                            //$pre=extract_pricing($previous_offer);
                                            //echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Previous_Offer(\"".$pre."\",".$sku.")'>Previous Offer</a>"; 
                                            }
                                            if($a!="new"){

                                                echo "<a class='dropdown-item' href='javascript:void(0)' onClick='javascript:Closest_Offers(".$sku.")'>Closest Offer</a>"; 
                                                }

                                            if($pricing){
                                                $pre=extract_pricing($pricing);
                                                echo "<a class='dropdown-item' href= 'javascript:void(0)' onClick='javascript:Previous_Offer(\"".$pre."\",".$sku.")'>Closest Pricing</a>"; 
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
                                    echo "<span title='# tiers' id ='".$sku."_tier_counter' class='span_count'>$count_tiers</span>";
                                    echo "<a href= 'javascript:void(0)' onClick='javascript:Remove_Boxes(".$sku.")' title='Remove Tier'> -</a>";
                                    
             

                                    }else{
                                        if($stat){
                                            multi_boxes(get_trend("saved_price",$sku,$stat),$sku,$stat);
                                        }else{
                                            multi_boxes(get_trend("loy_price",$sku,$last_date),$sku);
                                        }
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

                        <?php
                        if($a!="new"){
                        ?>
                        <!-- Offer Dates -->
                        <div class="col-xl-3 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        
                                    <?php
                                    if($a=="new"){
                                    echo "Export";    
                                    }else {
                                    echo "Dates";
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
                                            <?php 
                                            if($a!="new"){                                          
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
                                        <?php 
                                        if($stat){
                                        $dates= get_trend("promo_dates",$sku,$stat);
                                        $datetime=explode(",",$dates);
                                        $start_date= date('Y-m-d\TH:i', strtotime($datetime[0]));   
                                        $end_date= date('Y-m-d\TH:i', strtotime($datetime[1]));    
                                        }                                  
                                        ?>
                                        <table><tr>
                                        <td>
                                        <input type="datetime-local" class="date_pick"  id="<?php echo $sku; ?>_txt_sta" value="<?php echo $start_date; ?>" >  </td>                                        
                                        <td>
                                        <input type="datetime-local" class="date_pick"  id="<?php echo $sku; ?>_txt_end" value="<?php echo $end_date; ?>">  </td>
                                        </tr></table>
                                        
                                    
                                        </div>
                                    
                                
                                                            
                                </div>       
                                </div>  
                                
                            </div>
                        </div> 
                        <?php } ?>


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


    <script>
        //$(document).ready(function () {
        function Closest_Offers(sku){
            var div_id='#offer_match';
            // $(div_id).click(function (e) { 
            //     e.preventDefault();
                //var sku = $(this).attr('title');
                var txt_rrp= sku + "_txt_new_rrp";
                var txt_tie= sku + "_hid_tie";
                var rrp = document.getElementById(txt_rrp).value;
                var tiers= document.getElementById(txt_tie).value;
                console.log(sku);
                console.log(tiers);
                
                $.ajax({
                    type: "POST",
                    url: "off-cr_json.php",
                    data: {
                        'checking_viewbtn': true,
                        'sku':sku,
                        'tiers':tiers,
                        'rrp': rrp,
                    },
                    success: function (response) {
                        // console.log(response);
                        $('.offer-data').html(response);
                        $('#offerModal').modal('show');
                    }
                });
            //});
        }
            // });



        /////////////////////  Function to save pricing
function Save_Price(target){            
    var sku='';
    var rrp;
    var chk_rrp;
    var chk_ro;
    var prod='';
    var tot_tiers;
    var tiers='';
    var dates;
    var stock;
    var fwac;
    var stat;
    //Get number of products
    var x = document.getElementsByClassName("sku_cel");
    var k =0;
    //Loop through number of products to create array
      for (var i = 0; i < x.length; i++) { 
        console.log(i);
        //Get SKU
        sku = x[i].innerText.split('-').pop();
        //Get RRP
        rrp = document.getElementsByClassName("txt_new_rrp")[i].value;
        //Get RO update for report
        chk_rrp = document.getElementsByClassName("chk_rrp")[i].checked;
        //Get RO options
        chk_ro = document.getElementsByClassName("chk_ro")[i].checked;
        //Get pricing tiers
        tot_tiers = (document.getElementsByClassName("hid_tie")[i].value) * 2;
        //Get Stock
        stock = document.getElementsByClassName("hid_tie_stock")[i].value;
        //Get Pricing
        var w = document.getElementsByClassName(sku + '_txt_pri');
        var tiers='';
            //Loop through points/pay tiers cells
            for (var s = 0; s < tot_tiers; s += 2) {
                tiers += w[s].value + '-' + w[s+1].value + ',';
            }
            tiers= tiers.slice(0, -1);
        var new_prod= document.getElementById('hid_prod').value;   
            if(!new_prod){     
            //Get Dates
            var start = document.getElementsByClassName("date_pick")[k].value;
            y= Format_Date(start);
            var end = document.getElementsByClassName("date_pick")[k+1].value;
            z= Format_Date(end);
            dates= y + ',' + z;
            k = k + 2;
            }else{
            var date = getDateTime();
            dates= date + ',' + date;
            }
        fwac = document.getElementsByClassName("txt_fwac")[i].value;
        
        var pri_name = document.getElementById('name').value;
        stat = document.getElementById('hid_prom').value;
        var type = document.getElementById('hid_type').value;
        console.log({stat});

                $.ajax({
                    type: "POST",
                    url: "off-cr2_json.php",
                    data: {
                        'checking_viewbtn': true,
                        'sku':sku,
                        'rrp':rrp,
                        'tiers':tiers,
                        'dates': dates,
                        'chk_ro':chk_ro,
                        'fwac':fwac,
                        'pri_name':pri_name,
                        'target':target,
                        'stat':stat,
                        'type': type,
                    },
                    success: function (response) {
                         console.log( i + " - " + response);
                         //if( !$('.hid_promos').val() ) {
                         $('#hid_prom').val(response);    
                        // }
                    },
                    async: false
                });
    }
  document.getElementById('hid_type').value = "update";
  console.log({type});

  }

  function getDateTime() {
        var now     = new Date(); 
        var year    = now.getFullYear();
        var month   = now.getMonth()+1; 
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        var second  = now.getSeconds(); 
        if(month.toString().length == 1) {
             month = '0'+month;
        }
        if(day.toString().length == 1) {
             day = '0'+day;
        }   
        if(hour.toString().length == 1) {
             hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
             minute = '0'+minute;
        }
        if(second.toString().length == 1) {
             second = '0'+second;
        }   
        var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;   
         return dateTime;
    }

  function Export_File(target){            
   // prod= 'i=' + i + '&' + prod;
   var id = document.getElementById('hid_prom').value;
    var url = 'off-cr1.php?id=' + id + '&target=' + target;
    //console.log("Prod" + prod);
   // console.log("target" + target);
    window.open(url, '_blank'); 
  }
////////////////////// End Function to save pricing
</script>

  
</body>
</html>



    