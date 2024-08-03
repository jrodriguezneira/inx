<?php 
//include '../data/db_connection.php';
include '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
//Crate URL for current directory

// Function to create sales format file ////////////////////////////////////
function create_offer_file($prod){ 
    
   
    // Creates New Spreadsheet  
    $spreadsheet = new Spreadsheet(); 
    
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 

    //Format for table headers ///////
    $tablehead= [
        'font' =>[
            'color'=>[
                'rgb'=>'000000'
            ],

        ],
        'fill'=>[
            'fillType' => Fill::FILL_SOLID,
            'startColor' =>[
                'rgb' => 'D9D9D9'
            ]

        ],

    ];
    $tablehead2= [
        'font' =>[
            'color'=>[
                'rgb'=>'FFFFFF'
            ],

        ],
        'fill'=>[
            'fillType' => Fill::FILL_SOLID,
            'startColor' =>[
                'rgb' => '00B0F0'
            ]

        ],

    ];
    $tablehead3= [
        'font' =>[
            'color'=>[
                'rgb'=>'000000'
            ],

        ],
        'fill'=>[
            'fillType' => Fill::FILL_SOLID,
            'startColor' =>[
                'rgb' => 'FFC7CE'
            ]

        ],

    ];
    $tablehead4= [
        'font' =>[
            'color'=>[
                'rgb'=>'000000'
            ],

        ],
        'fill'=>[
            'fillType' => Fill::FILL_SOLID,
            'startColor' =>[
                'rgb' => 'C6EFCE'
            ]

        ],

    ];
    //////Format fot table headers /////////////////////////////////////////
   
    //Divide received array to loop through each sku
    $skus=explode('&',$prod);
    // Count the skus
    $z= count($skus)-1;
    //Counter for row initial sku position on each iteration
    $tot_tiers=0;
    //Loop through skus
    for ($i = 0; $i < $z; $i++) {


        //Obtain details for each sku
        $tier = explode('*',$skus[$i]);

        //Set Name
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+1,$tier[10]);
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+2,$tier[10]);
        $sheet->getColumnDimension('B')->setWidth(35);
        //Set SKU
        $sheet->setCellValueByColumnAndRow(3,$tot_tiers+1,"Inventory ID");
        $sheet->setCellValueByColumnAndRow(3,$tot_tiers+2,$tier[0]);
        $sheet->getColumnDimension('C')->setWidth(12);
        //Set RRP
        $sheet->setCellValueByColumnAndRow(4,$tot_tiers+1,"RRP(Inc GST)");
        $sheet->setCellValueByColumnAndRow(4,$tot_tiers+2,$tier[1]);
        $sheet->getColumnDimension('D')->setWidth(10);
        // Pricing Type
        $sheet->setCellValueByColumnAndRow(5,$tot_tiers+1,"Pricing Type");
        $sheet->getColumnDimension('E')->setWidth(10);
        // Pricing 
        $sheet->setCellValueByColumnAndRow(6,$tot_tiers+1,"Points");
        $sheet->setCellValueByColumnAndRow(7,$tot_tiers+1,"Pay(inc GST)");
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        //Margin and values
        $sheet->setCellValueByColumnAndRow(8,$tot_tiers+1,"Value");
        $sheet->setCellValueByColumnAndRow(9,$tot_tiers+1,"Margin");
        $sheet->setCellValueByColumnAndRow(10,$tot_tiers+1,"PPVV");
        $sheet->getColumnDimension('J')->setWidth(12);


        //Apply format to header for each sku
        $header1="B" . strval($tot_tiers+1) . ':M' . strval($tot_tiers+1);
        $header2="O" . strval($tot_tiers+1) . ':T' . strval($tot_tiers+1);
        $sheet->getStyle("$header1")->applyFromArray($tablehead);
        $sheet->getStyle("$header2")->applyFromArray($tablehead2);
        //Get RO options
        $ro= $tier[12];
        if($ro==1){
            $ro_des="Yes";
        }else{
            $ro_12_mon="-";
            $ro_24_mon="-";
            $ro_des="No"; 
        }
        //Set RRP
        $rrp_old= $tier[6];
        if($rrp_old =="false"){
            $rrp = $tier[11];
            }else{
            $rrp = $tier[1];
        }
      
          // Obtain points and tiers from current pricing array
          $tier1 = explode(',',$tier[9]);    
          
        foreach( $tier1 as $key=>$element) {     
              
            //Repeat Name
            $sheet->setCellValueByColumnAndRow(2,$tot_tiers+$key+2,$tier[10]);
            //Repeat SKU
            $sheet->setCellValueByColumnAndRow(3,$tot_tiers+$key+2,$tier[0]);
            //Repeat RRP
            $sheet->setCellValueByColumnAndRow(4,$tot_tiers+$key+2,$tier[11]);
            // Repeat Pricing Type
            $sheet->setCellValueByColumnAndRow(5,$tot_tiers+$key+2,"Persistant"); 
            //Set points and pay 
            $j=6; //Column start
            $tier_price = explode('-',$element);         
            $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+2,(int)$tier_price[0]);
            $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+2,(int)$tier_price[1]);
            $fwac= $tier[8];
            //Set margin
            $valu = round((((int)$tier_price[0]*0.0025) + ((int)$tier_price[1]/1.1)),2);
            $mar = round(($valu - $fwac),2);
            $per = round(((((int)$tier[11]-((int)$tier_price[1]))/((int)$tier_price[0]) )/(1.1)),6);

            $sheet->setCellValueByColumnAndRow($j+2,$tot_tiers + $key+2,$valu);
            $sheet->setCellValueByColumnAndRow($j+3,$tot_tiers + $key+2,$mar);
            $sheet->setCellValueByColumnAndRow($j+4,$tot_tiers + $key+2,$per);

            //Set 12 months
            if($ro==1){
            $ro_12_mon=(int)$tier_price[1]/12;}
            $sheet->setCellValueByColumnAndRow(11,$tot_tiers+$key+2,$ro_12_mon);
            $cell_12= "K" . strval($tot_tiers+$key+2);
            $sheet->getStyle("$cell_12")->getAlignment()->setHorizontal('right');
            //repeat 24 months
            if($ro==1){
            $ro_24_mon=(int)$tier_price[1]/24;}
            $sheet->setCellValueByColumnAndRow(12,$tot_tiers+$key+2,"$ro_24_mon");
            $cell_24= "L" . strval($tot_tiers+$key+2);
            $sheet->getStyle("$cell_24")->getAlignment()->setHorizontal('right');
            // Repeat RO option
            $sheet->setCellValueByColumnAndRow(13,$tot_tiers+$key+2,$ro_des);
            $cell_ro= "M" . strval($tot_tiers+$key+2);
            if($ro==1){
            $header_color=$tablehead4;}
            else{$header_color=$tablehead3;}  
            $sheet->getStyle("$cell_ro")->applyFromArray($header_color);
            $sheet->getStyle("$cell_ro")->getAlignment()->setHorizontal('center');
        }
        //Set 12 and 24 months values
        $dates = explode(',',$tier[4]);
        $sheet->setCellValueByColumnAndRow(11,$tot_tiers+1,"12mth price");
        $sheet->getColumnDimension('K')->setWidth(11);
        $sheet->setCellValueByColumnAndRow(12,$tot_tiers+1,"24mth price");
        $sheet->getColumnDimension('L')->setWidth(11);
        //Set HRO
        $sheet->setCellValueByColumnAndRow(13,$tot_tiers+1,"HRO");
        $sheet->getColumnDimension('M')->setWidth(10);
        //Set New RRP
        $sheet->setCellValueByColumnAndRow(15,$tot_tiers+1,"RRP");
        $sheet->getColumnDimension('O')->setWidth(10);
        //Set New Pricing
        $sheet->setCellValueByColumnAndRow(16,$tot_tiers+1,"Points");
        $sheet->setCellValueByColumnAndRow(17,$tot_tiers+1,"Pay");
        $sheet->setCellValueByColumnAndRow(18,$tot_tiers+1,"Value");
        $sheet->setCellValueByColumnAndRow(19,$tot_tiers+1,"Margin");
        $sheet->setCellValueByColumnAndRow(20,$tot_tiers+1,"PPVV");
        $sheet->getColumnDimension('T')->setWidth(12);

        // Obtain points and tiers from new pricing array
        $tier2 = explode(',',$tier[3]);
        $fwac= $tier[8];
        foreach( $tier2 as $key=>$element) {

            //Repeat new or old RRP depending on checkbox selection
            $sheet->setCellValueByColumnAndRow(15,$tot_tiers+$key+2,$rrp);
            //Set points and pay
            $j=16; // Column Start
            $tier_price = explode('-',$element);
            // Calculate pricing margins
            $valu = round((((int)$tier_price[0]*0.0025) + ((int)$tier_price[1]/1.1)),2);
            $mar = round(($valu - $fwac),2);
            $per = round(((((int)$tier[11]-((int)$tier_price[1]))/((int)$tier_price[0]) )/(1.1)),6);

            $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+2,(int)$tier_price[0]);
            $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+2,(int)$tier_price[1]);
            $sheet->setCellValueByColumnAndRow($j+2,$tot_tiers + $key+2,$valu);
            $sheet->setCellValueByColumnAndRow($j+3,$tot_tiers + $key+2,$mar);
            $sheet->setCellValueByColumnAndRow($j+4,$tot_tiers + $key+2,$per);       

        }
        //Counter to set the starting point for new product $tier[2] needs to be divided by 2 to get the number of tiers   
        $tot_tiers =  $tot_tiers + 2 + $tier[2];    
    }

    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet); 
    // Save .xlsx file to the files directory 
    $filename="offer.xlsx";
    $writer->save($filename);  

    ?>
    <script>
    //Obtain filename
    var flname="<?php echo $filename;?>";
    //Set filepath
    var urlx= flname;
    console.log(urlx);
    //Function to download the file
    download(urlx , flname);
    </script>

<?php
//return $filename;
}
//End Function
 
// Function to create shop format file ////////////////////////////////////
function create_shop_file($prod){

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Current Price');
    $sheet->setCellValue('G1', 'Original Price');
    $sheet->setCellValue('k1', 'Repayment');
    $sheet->setCellValue('C2', 'Points');
    $sheet->setCellValue('D2', 'Pay');
    $sheet->setCellValue('E2', 'From Date');
    $sheet->setCellValue('F2', 'To Date');
    $sheet->setCellValue('G2', 'Points');
    $sheet->setCellValue('H2', 'Pay');
    $sheet->setCellValue('I2', 'From Date');
    $sheet->setCellValue('J2', 'To Date'); 
    
        //Divide received array to loop through each sku
        $skus=explode('&',$prod);
        // Count the skus
        $z= count($skus)-1;
        //Counter for row initial sku position on each iteration
        $tot_tiers=0;
        // Loop through skus
        for ($i = 0; $i < $z; $i++) {
            //Obtain details for each sku
        $tier = explode('*',$skus[$i]);
        //Set sku
        $sheet->setCellValueByColumnAndRow(1,$tot_tiers+3,$tier[0]);
        //Set name
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+3,$tier[10]);
        //Set new pricing 
              $tier1 = explode(',',$tier[3]);         
              foreach( $tier1 as $key=>$element) {
                $j=3; //Column start
                $tier_price = explode('-',$element); 
              $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+3,$tier_price[0]);
              $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+3,$tier_price[1]);
              }
          // Obtain staert and end date
          $dates = explode(',',$tier[4]);
          $sheet->setCellValueByColumnAndRow(5,$tot_tiers+3,trim($dates[0]));
          $sheet->setCellValueByColumnAndRow(6,$tot_tiers+3,trim($dates[1]));
          echo trim($dates[0]);
          //Set Current pricing 
              $tier2 = explode(',',$tier[9]);
              foreach( $tier2 as $key=>$element) {
              $j=7; //Column start
              $tier_price = explode('-',$element);
              $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+3,(int)$tier_price[0]);
              $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+3,(int)$tier_price[1]);
              }
        //Counter to set the starting point for new product $tier[2] needs to be divided by 2 to get the number of tiers   
        $tot_tiers =  $tot_tiers + $tier[2];    
        }
    
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="shop.xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        </script>
    <?php   
    }
//  End Function to create shop format file ////////////////////////////////////



// Function to create stock format file ////////////////////////////////////
function create_stock_file($prod){

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Stock');
       
        //Divide received array to loop through each sku
        $skus=explode('&',$prod);
        // Count the skus
        $z= count($skus)-1;
        //Counter for row initial sku position on each iteration
        $tot_tiers=0;
        // Loop through skus
        for ($i = 0; $i < $z; $i++) {
            //Obtain details for each sku
        $tier = explode('*',$skus[$i]);
        //Set sku
        $sheet->setCellValueByColumnAndRow(1,$tot_tiers+2,$tier[0]);
        $sheet->getColumnDimension('A')->setWidth(15);
        //Set name
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+2,$tier[10]);
        $sheet->getColumnDimension('B')->setWidth(50);
        //Set stock 
        $sheet->setCellValueByColumnAndRow(3,$tot_tiers+2,$tier[5]); 
        $sheet->getColumnDimension('C')->setWidth(15);
        $tot_tiers++;
        }
    
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="stock.xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        </script>
    <?php   
    }
//  End Function to create stock format file ////////////////////////////////////

// Function to export pricing ////////////////////////////////////
function create_current_new_pricing_file(){

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");

    $sql= "select distinct sku,name,rrp, substring_index(substring(SUBSTRING_INDEX(price,',', 1),3),'-',1) as Top_Points,
    substring_index((substring_index((substring(price,-10)),'-',-1)),\"'\",1) as Top_Pay,price,offer,ro
    from products_last;";

    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'RRP');
    $sheet->setCellValue('D1', 'Top Points');
    $sheet->setCellValue('E1', 'Top Pay');
    $sheet->setCellValue('F1', 'Points');
    $sheet->setCellValue('G1', 'Pay');
    $sheet->setCellValue('H1', 'Check');
    $sheet->setCellValue('I1', 'RO');

       
        $row=0;
        // Loop through skus
    while($data = mysqli_fetch_array($result)){
        
        //Obtain details for each sku       
        $sheet->setCellValueByColumnAndRow(1,$row+2,$data[0]);
        $sheet->getColumnDimension('A')->setWidth(15);
        //Set Name
        $sheet->setCellValueByColumnAndRow(2,$row+2,$data[1]);
        $sheet->getColumnDimension('B')->setWidth(50);
        //Set RRP 
        $sheet->setCellValueByColumnAndRow(3,$row+2,$data[2]); 
        $sheet->getColumnDimension('C')->setWidth(15);
        //Set Top Points 
        $sheet->setCellValueByColumnAndRow(4,$row+2,$data[3]);
        $sheet->getColumnDimension('D')->setWidth(15);
        //Set Top Pay
        $sheet->setCellValueByColumnAndRow(5,$row+2,$data[4]);
        $sheet->getColumnDimension('E')->setWidth(15);
        //Set Points & Tiers 6 -7 columns
        $sheet->setCellValueByColumnAndRow(6,$row+2,$data[5]); 
        $sheet->getColumnDimension('F')->setWidth(15);

        if(intval($data[2])==intval($data[4])){
            $check="Aligned";
            }else{
            $check="Difference";
            }
          if($data[6]=="Hot Offer"){
            $check="Hot Offer";
          }
          if($data[4]==0){
            $check="Points Only";
          }

        //Set Price Check 8 column
        $sheet->setCellValueByColumnAndRow(8,$row+2,$check); 
        $sheet->getColumnDimension('G')->setWidth(15);

         //Set RO column
         if($data[7]=="[12,24]"){
            $ro="RO";
          }
          if($data[7]=="[]"){
            $ro="Outright";
          }
         $sheet->setCellValueByColumnAndRow(9,$row+2,$ro); 
         $sheet->getColumnDimension('H')->setWidth(15);

        $tier1 = explode(',',$data[5]);
        $tiers= count($tier1);
        $key=0;     
        foreach( $tier1 as $key=>$element) {
            $j=6; //Column start
            $tier_price = explode('-',$element); 
            if($key==0){
            $points=substr($tier_price[0],2);
            }else{
            $points=substr($tier_price[0],1);
            }
            $pay=substr($tier_price[1],0,-1);
            if($key==$tiers-1){$pay=substr($tier_price[1],0,-2);}
                $sheet->setCellValueByColumnAndRow($j,$row + $key+2,$points);
                $sheet->setCellValueByColumnAndRow($j+1,$row + $key+2,$pay);
            $key++;
        }

        $row=$row+$key;
    }
    $currentDate = date("d_m_Y");
    //$currentDate->format('Y-m-d H:i:s');
    $sheet->setTitle("$currentDate");
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="Pricing_".$currentDate.".xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        
        </script>
    <?php   
}
//  End Function to export pricing ////////////////////////////////////


// Function to export pricing ////////////////////////////////////
function create_new_pricing_file(){

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
    //include '../data/db_connection.php';

    // $sql= "select distinct T1.sku,T2.name,T2.category,T3.rrp,T3.vpp,T1.price from products_new_pricing as T1 inner join products_last as 
    // T2 on T1.sku=T2.sku inner join price_tiers as T3 on T2.sku=T3.sku;";

    $sql= "select distinct T1.sku,T2.name,T2.category,T3.rrp,T3.vpp,T1.price,T1.offer_price from products_new_pricing as T1 inner join products_last as 
     T2 on T1.sku=T2.sku inner join price_tiers as T3 on T2.sku=T3.sku where T1.offer_price is not null";


    
    //echo $sql;

    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Category');
    $sheet->setCellValue('D1', 'RRP');
    $sheet->setCellValue('E1', 'VPP');
    $sheet->setCellValue('F1', 'Price');

       
        $row=0;
        // Loop through skus
    while($data = mysqli_fetch_array($result)){
        
        //Obtain details for each sku       
        $sheet->setCellValueByColumnAndRow(1,$row+2,$data[0]);
        $sheet->getColumnDimension('A')->setWidth(15);
        //Set solomon
        $sheet->setCellValueByColumnAndRow(2,$row+2,$data[1]);
        $sheet->getColumnDimension('B')->setWidth(15);
        //Set Name 
        $sheet->setCellValueByColumnAndRow(3,$row+2,$data[2]); 
        $sheet->getColumnDimension('C')->setWidth(50);
        //Set Inovice 
        $sheet->setCellValueByColumnAndRow(4,$row+2,$data[3]);
        $sheet->getColumnDimension('D')->setWidth(15);
        //Set DBP
        $sheet->setCellValueByColumnAndRow(5,$row+2,$data[4]);
        $sheet->getColumnDimension('E')->setWidth(15);
        //Set RRP_Inc 
        $sheet->setCellValueByColumnAndRow(6,$row+2,$data[5]); 
        $sheet->getColumnDimension('F')->setWidth(15);


        $tier1 = explode(',',$data[5]);
        $tiers= count($tier1);
        $key=0;     
        foreach( $tier1 as $key=>$element) {
            $j=6; //Column start
            $tier_price = explode('-',$element); 
            if($key==0){
            $points=substr($tier_price[0],2);
            }else{
            $points=substr($tier_price[0],1);
            }
            $pay=substr($tier_price[1],0,-1);
            if($key==$tiers-1){$pay=0;}
                $sheet->setCellValueByColumnAndRow($j,$row + $key+2,$points);
                $sheet->setCellValueByColumnAndRow($j+1,$row + $key+2,$pay);
            $key++;
        }

        $tier2= explode(',',$data[6]);
        $tiers2= count($tier2);
        $key=0;     
        foreach( $tier2 as $key=>$element) {
            $j=8; //Column start
            $tier_price = explode('-',$element); 
            if($key==0){
            $points=substr($tier_price[0],2);
            }else{
            $points=substr($tier_price[0],1);
            }
            $pay=substr($tier_price[1],0,-1);
            if($key==$tiers2-1){$pay=0;}
                $sheet->setCellValueByColumnAndRow($j,$row + $key+2,$points);
                $sheet->setCellValueByColumnAndRow($j+1,$row + $key+2,$pay);
            $key++;
        }



        $row=$row+$key;
    }
    $currentDate = date("d_m_Y");
    //$currentDate->format('Y-m-d H:i:s');
    $sheet->setTitle("$currentDate");
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="Pricing_".$currentDate.".xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        
        </script>
    <?php   
}
//  End Function to export pricing ////////////////////////////////////

// Function to export pricing ////////////////////////////////////
function create_current_offers_pricing_file(){

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
    //include '../data/db_connection.php';

    // $sql= "select distinct T1.sku,T2.name,T2.category,T3.rrp,T3.vpp,T1.price from products_new_pricing as T1 inner join products_last as 
    // T2 on T1.sku=T2.sku inner join price_tiers as T3 on T2.sku=T3.sku;";

    $sql= "select distinct T1.sku,T2.name,T2.category,T3.rrp,T3.vpp,T1.price,T1.offer_price from products_new_pricing as T1 inner join products_last as 
     T2 on T1.sku=T2.sku inner join price_tiers as T3 on T2.sku=T3.sku where T1.offer_price is not null";


    
    //echo $sql;

    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Category');
    $sheet->setCellValue('D1', 'RRP');
    $sheet->setCellValue('E1', 'VPP');
    $sheet->setCellValue('F1', 'Price');

       
        $row=0;
        // Loop through skus
    while($data = mysqli_fetch_array($result)){
        
        //Obtain details for each sku       
        $sheet->setCellValueByColumnAndRow(1,$row+2,$data[0]);
        $sheet->getColumnDimension('A')->setWidth(15);
        //Set solomon
        $sheet->setCellValueByColumnAndRow(2,$row+2,$data[1]);
        $sheet->getColumnDimension('B')->setWidth(15);
        //Set Name 
        $sheet->setCellValueByColumnAndRow(3,$row+2,$data[2]); 
        $sheet->getColumnDimension('C')->setWidth(50);
        //Set Inovice 
        $sheet->setCellValueByColumnAndRow(4,$row+2,$data[3]);
        $sheet->getColumnDimension('D')->setWidth(15);
        //Set DBP
        $sheet->setCellValueByColumnAndRow(5,$row+2,$data[4]);
        $sheet->getColumnDimension('E')->setWidth(15);
        //Set RRP_Inc 
        $sheet->setCellValueByColumnAndRow(6,$row+2,$data[5]); 
        $sheet->getColumnDimension('F')->setWidth(15);


        $tier1 = explode(',',$data[5]);
        $tiers= count($tier1);
        $key=0;     
        foreach( $tier1 as $key=>$element) {
            $j=6; //Column start
            $tier_price = explode('-',$element); 
            if($key==0){
            $points=substr($tier_price[0],2);
            }else{
            $points=substr($tier_price[0],1);
            }
            $pay=substr($tier_price[1],0,-1);
            if($key==$tiers-1){$pay=0;}
                $sheet->setCellValueByColumnAndRow($j,$row + $key+2,$points);
                $sheet->setCellValueByColumnAndRow($j+1,$row + $key+2,$pay);
            $key++;
        }

        $tier2= explode(',',$data[6]);
        $tiers2= count($tier2);
        $key=0;     
        foreach( $tier2 as $key=>$element) {
            $j=8; //Column start
            $tier_price = explode('-',$element); 
            if($key==0){
            $points=substr($tier_price[0],2);
            }else{
            $points=substr($tier_price[0],1);
            }
            $pay=substr($tier_price[1],0,-1);
            if($key==$tiers2-1){$pay=0;}
                $sheet->setCellValueByColumnAndRow($j,$row + $key+2,$points);
                $sheet->setCellValueByColumnAndRow($j+1,$row + $key+2,$pay);
            $key++;
        }



        $row=$row+$key;
    }
    $currentDate = date("d_m_Y");
    //$currentDate->format('Y-m-d H:i:s');
    $sheet->setTitle("$currentDate");
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="Pricing_".$currentDate.".xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        
        </script>
    <?php   
}
//  End Function to export pricing ////////////////////////////////////




function create_current_pricing_file(){

    $con=mysqli_connect("localhost","stagierv_insight","Painkiller789*","stagierv_insights");
    //include '../data/db_connection.php';

    $sql="SELECT sku,name, GROUP_CONCAT(price ORDER BY price separator '|') as price FROM products_last where segment='LOYALTY_CON' or 
    segment='LOYALTY_CON_DV' or segment='LOYALTY_SMB' group BY sku;";
    
    //echo $sql;

    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Points');
    $sheet->setCellValue('D1', 'Pay');
    $sheet->setCellValue('E1', 'Validate');

       
        $row=0;
        // Loop through skus
        while($data = mysqli_fetch_array($result)){
        
        $price= explode("|",$data[2]);
        
        $con= trim(substr($price[0],1),"]");
        $arrcon=explode(",",$con);
        $dv=trim(substr($price[1],1),"]");
        $arrdv=explode(",",$dv);
        $smb= trim(substr($price[2],1),"]");
        $arrsmb=explode(",",$smb);
        
        if($con==$dv && $dv==$smb){
        $dif="Aligned";
        }else{
        $dif="Different";

            if(sizeof($arrcon)==sizeof($arrdv) AND array_diff($arrcon,$arrdv)==array())
            {
            $dif="Aligned";
            }else{
            $dif="Different";
            }
            if(sizeof($arrcon)==sizeof($arrsmb) AND array_diff($arrcon,$arrsmb)==array())
            {
            $dif="Aligned";
            }else{
            $dif="Different";
            }


        }


        if($dif=="Different"){

        
            //Obtain details for each sku       
            $sheet->setCellValueByColumnAndRow(1,$row+2,$data[0]);
            $sheet->getColumnDimension('A')->setWidth(15);
            //Set Name
            $sheet->setCellValueByColumnAndRow(2,$row+2,$data[1]);
            $sheet->getColumnDimension('B')->setWidth(15);
            //Set segments 
        

            $tier1 = explode(',',$con);
            $tiers= count($tier1);
            $key=0;     
            foreach( $tier1 as $key=>$element) {
                $j=3; //Column start
                $tier_price = explode('-',$element); 
                $points=substr($tier_price[0],1);
                $pay=substr($tier_price[1],0,-1);
              
                    $sheet->setCellValueByColumnAndRow($j,$row + $key+2,$points);
                    $sheet->setCellValueByColumnAndRow($j+1,$row + $key+2,$pay);
                $key++;
            }
            //Set Validate
            $sheet->setCellValueByColumnAndRow(5,$row+2,$dif);
            $sheet->getColumnDimension('E')->setWidth(15);
            


            $row=$row+$key;
        }

    }
    $currentDate = date("d_m_Y");
    //$currentDate->format('Y-m-d H:i:s');
    $sheet->setTitle("$currentDate");
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="Current_Pricing".$currentDate.".xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        
        </script>
    <?php   
}
//  End Function to export pricing ////////////////////////////////////




// Function to export catalog ////////////////////////////////////
function create_catalog_file(){

    $con=mysqli_connect("192.254.236.136","stagierv_insight","Painkiller789*","stagierv_insights");

    $sql= "SELECT t1.sku as orin,t2.solomon, t1.`name` as namex,t2.invoice_ex_gst as invoice_ex_gst, t2.dbp_ex_gst as dbp_ex_gst,t1.rrp as std_rrp_inc_gst,
    t2.std_rrp_ex_gst as std_rrp_ex_gst,t2.rebate as rebate, t1.stock as stock
    FROM products_last AS t1 LEFT JOIN product_pricing AS t2 ON t1.sku = t2.orin WHERE t1.segment='LOYALTY_CON' ";
    //echo $sql;

    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    // Set headers for shop format 
    $sheet->setCellValue('A1', 'Sku');
    $sheet->setCellValue('B1', 'Solomon');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'invoice_ex_gst');
    $sheet->setCellValue('E1', 'dbp_ex_gst');
    $sheet->setCellValue('F1', 'std_rrp_inc_gst');
    $sheet->setCellValue('G1', 'Std RRP Ex GST');
    $sheet->setCellValue('H1', 'Rebate');
    $sheet->setCellValue('I1', 'Stock');
       
        $row=0;
        // Loop through skus
        while($data = mysqli_fetch_array($result)){
        
        //Obtain details for each sku       
        $sheet->setCellValueByColumnAndRow(1,$row+2,$data[0]);
        $sheet->getColumnDimension('A')->setWidth(15);
        //Set solomon
        $sheet->setCellValueByColumnAndRow(2,$row+2,$data[1]);
        $sheet->getColumnDimension('B')->setWidth(15);
        //Set Name 
        $sheet->setCellValueByColumnAndRow(3,$row+2,$data[2]); 
        $sheet->getColumnDimension('C')->setWidth(50);
        //Set Inovice 
        $sheet->setCellValueByColumnAndRow(4,$row+2,$data[3]);
        $sheet->getColumnDimension('D')->setWidth(15);
        //Set DBP
        $sheet->setCellValueByColumnAndRow(5,$row+2,$data[4]);
        $sheet->getColumnDimension('E')->setWidth(15);
        //Set RRP_Inc 
        $sheet->setCellValueByColumnAndRow(6,$row+2,$data[5]); 
        $sheet->getColumnDimension('F')->setWidth(15);
        //Set RRP_Ex 
        $sheet->setCellValueByColumnAndRow(7,$row+2,$data[6]);
        $sheet->getColumnDimension('G')->setWidth(15);
        //Set rebate
        $sheet->setCellValueByColumnAndRow(8,$row+2,$data[7]);
        $sheet->getColumnDimension('H')->setWidth(15);
        //Set stock 
        $sheet->setCellValueByColumnAndRow(9,$row+2,$data[8]); 
        $sheet->getColumnDimension('I')->setWidth(15);


        $row++;
        }
    $currentDate = date("d_m_Y");
    //$currentDate->format('Y-m-d H:i:s');
    $sheet->setTitle("$currentDate");
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet);      
    // Save .xlsx file to the files directory 
    $filename="catalog_".$currentDate.".xlsx";
    $writer->save($filename);  
    
    ?>
        <script>
        //Obtain filename
        var flname="<?php echo $filename;?>";
        //Set filepath
        var urlx= flname;
        //Function to download the file
        download(urlx , flname);
        
        </script>
    <?php   
}
//  End Function to export catalog ////////////////////////////////////


// Function to create new format file ////////////////////////////////////
function create_product_file($prod){ 

    // Creates New Spreadsheet 
    $spreadsheet = new Spreadsheet(); 
      
    // Retrieve the current active worksheet 
    $sheet = $spreadsheet->getActiveSheet(); 
    
        //Format for table headers ///////
        $tablehead= [
            'font' =>[
                'color'=>[
                    'rgb'=>'000000'
                ],
    
            ],
            'fill'=>[
                'fillType' => Fill::FILL_SOLID,
                'startColor' =>[
                    'rgb' => 'D9D9D9'
                ]
    
            ],
    
        ];
        $tablehead2= [
            'font' =>[
                'color'=>[
                    'rgb'=>'FFFFFF'
                ],
    
            ],
            'fill'=>[
                'fillType' => Fill::FILL_SOLID,
                'startColor' =>[
                    'rgb' => '00B0F0'
                ]
    
            ],
    
        ];
        $tablehead3= [
            'font' =>[
                'color'=>[
                    'rgb'=>'000000'
                ],
    
            ],
            'fill'=>[
                'fillType' => Fill::FILL_SOLID,
                'startColor' =>[
                    'rgb' => 'FFC7CE'
                ]
    
            ],
    
        ];
        $tablehead4= [
            'font' =>[
                'color'=>[
                    'rgb'=>'000000'
                ],

            ],
            'fill'=>[
                'fillType' => Fill::FILL_SOLID,
                'startColor' =>[
                    'rgb' => 'C6EFCE'
                ]

            ],

        ];
        //////Format fot table headers /////////////////////////////////////////
    
        //Divide received array to loop through each sku
        $skus=explode('&',$prod);
        // Count the skus
        $z= count($skus)-1;
        //Counter for row initial sku position on each iteration
        $tot_tiers=0;
        //Loop through skus
        for ($i = 0; $i < $z; $i++) {
    
        //Obtain details for each sku
        $tier = explode('*',$skus[$i]);
        
        //Set Name
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+1,$tier[10]);
        $sheet->getColumnDimension('B')->setWidth(50);
        
        //Set SKU
        $sheet->setCellValueByColumnAndRow(3,$tot_tiers+1,"Inventory ID");
        $sheet->getColumnDimension('C')->setWidth(15);
        //Set RRP
        $sheet->setCellValueByColumnAndRow(4,$tot_tiers+1,"RRP(Inc GST)");
        $sheet->getColumnDimension('D')->setWidth(15);
        // Pricing Type
        $sheet->setCellValueByColumnAndRow(5,$tot_tiers+1,"Pricing Type");
        $sheet->setCellValueByColumnAndRow(5,$tot_tiers+2,"Persistant");
        $sheet->getColumnDimension('E')->setWidth(15);
        // Pricing 
        $sheet->setCellValueByColumnAndRow(6,$tot_tiers+1,"Points");
        $sheet->setCellValueByColumnAndRow(7,$tot_tiers+1,"Pay(inc GST)");
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        //Apply format to header for each sku
        $header1="B" . strval($tot_tiers+1) . ':J' . strval($tot_tiers+1);
        $header2="L" . strval($tot_tiers+1) . ':N' . strval($tot_tiers+1);
        $sheet->getStyle("$header1")->applyFromArray($tablehead);
        $sheet->getStyle("$header2")->applyFromArray($tablehead2);
        //Get RO options
        $ro= $tier[7];
        /*
        if($ro=="false"){
          $ro_mon="-";
          $ro_des="No";
        }
        */
        if($ro=="true"){
            $ro_des="Yes";
        }else{
            $ro_12_mon="-";
            $ro_24_mon="-";
            $ro_des="No"; 
        }
      
                // Obtain points and tiers from new pricing array
                $tier1 = explode(',',$tier[3]);

                foreach( $tier1 as $key=>$element) {

                //Repeat Name
                $sheet->setCellValueByColumnAndRow(2,$tot_tiers+$key+2,$tier[10]);
                //Repeat SKU
                $sheet->setCellValueByColumnAndRow(3,$tot_tiers+$key+2,$tier[0]);
                //Set RRP
                $sheet->setCellValueByColumnAndRow(4,$tot_tiers+$key+2,$tier[1]);
                // Pricing Type
                $sheet->setCellValueByColumnAndRow(5,$tot_tiers+$key+2,"Persistant");
                //Split price
                $tier_price = explode('-',$element);
                //Repeat 12 months
                if($ro=="true"){
                $ro_12_mon=(int)$tier_price[1]/12;}
                $sheet->setCellValueByColumnAndRow(8,$tot_tiers+$key+2,$ro_12_mon);
                $cell_12= "H" . strval($tot_tiers+$key+2);
                $sheet->getStyle("$cell_12")->getAlignment()->setHorizontal('center');
                //repeat 24 months
                if($ro=="true"){
                    $ro_24_mon=(int)$tier_price[1]/24;}
                $sheet->setCellValueByColumnAndRow(9,$tot_tiers+$key+2,"$ro_24_mon");
                $cell_24= "I" . strval($tot_tiers+$key+2);
                $sheet->getStyle("$cell_24")->getAlignment()->setHorizontal('center');
                // Repeat RO option
                $sheet->setCellValueByColumnAndRow(10,$tot_tiers+$key+2,$ro_des);
                $cell_ro= "J" . strval($tot_tiers+$key+2);
                if($ro=="true"){
                $header_color=$tablehead4;}
                else{$header_color=$tablehead3;}  
                $sheet->getStyle("$cell_ro")->applyFromArray($header_color);
                $sheet->getStyle("$cell_ro")->getAlignment()->setHorizontal('center');
                

                $j=6; // Column Start
                
                $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+2,(int)$tier_price[0]);
                $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+2,(int)$tier_price[1]);
                $fwac= (int)$tier[8];
                $valu = round((((int)$tier_price[0]*0.0025) + ((int)$tier_price[1]/1.1)),2);
                $mar = round(($valu - $fwac),2);
               // $per = round(((((int)$tier[11]-((int)$tier_price[1]))/((int)$tier_price[0]) )/(1.1)),6);
            
                $sheet->setCellValueByColumnAndRow($j+6,$tot_tiers + $key+2,$valu);
                $sheet->setCellValueByColumnAndRow($j+7,$tot_tiers + $key+2,$mar);
                $sheet->setCellValueByColumnAndRow($j+8,$tot_tiers + $key+2,$per);  

                }


          //Set 12 and 24 months values
          $dates = explode(',',$tier[4]);
         
          $sheet->setCellValueByColumnAndRow(8,$tot_tiers+1,"12mth price");
          $sheet->getColumnDimension('H')->setWidth(15);
          $sheet->setCellValueByColumnAndRow(9,$tot_tiers+1,"24mth price");
          $sheet->getColumnDimension('I')->setWidth(15);
          //Set HRO
          $sheet->setCellValueByColumnAndRow(10,$tot_tiers+1,"HRO");
          $sheet->getColumnDimension('J')->setWidth(15);

          $sheet->setCellValueByColumnAndRow(12,$tot_tiers+1,"Value");
          $sheet->setCellValueByColumnAndRow(13,$tot_tiers+1,"Margin");
          $sheet->setCellValueByColumnAndRow(14,$tot_tiers+1,"PPVV");
          $sheet->getColumnDimension('L')->setWidth(15);
          $sheet->getColumnDimension('M')->setWidth(15);
          $sheet->getColumnDimension('N')->setWidth(15);
          
          
        //Counter to set the starting point for new product $tier[2] needs to be divided by 2 to get the number of tiers   
        $tot_tiers =  $tot_tiers + 2 + $tier[2];    
        }
    
    // Write an .xlsx file  
    $writer = new Xlsx($spreadsheet); 
    // Save .xlsx file to the files directory 
    $filename="offer.xlsx";
    $writer->save($filename);  
    
    ?>
    <script>
    //Obtain filename
    var flname="<?php echo $filename;?>";
    //Set filepath
    var urlx= flname;
    //Function to download the file 
    download(urlx , flname);
    </script>
    
    <?php
    }
    // End Function to create sales format file ////////////////////////////////////
?>
<script>
//Function to create a temporary link, click it download the file and remove the link //////////////////////
const download = (path, filename) => {
    // Create a new link
    const anchor = document.createElement('a');
    anchor.href = path;
    anchor.download = filename;
    // Append to the DOM
    document.body.appendChild(anchor);
    // Trigger `click` event
    anchor.click();
    // Remove element from DOM
    document.body.removeChild(anchor);
}; 
// End Function to create a temporary link, click it download the file and remove the link ////////////////////
</script>