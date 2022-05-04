<?php 
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
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+1,$tier[9]);
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+2,$tier[9]);
        $sheet->getColumnDimension('B')->setWidth(50);
        //Set SKU
        $sheet->setCellValueByColumnAndRow(3,$tot_tiers+1,"Inventory ID");
        $sheet->setCellValueByColumnAndRow(3,$tot_tiers+2,$tier[0]);
        $sheet->getColumnDimension('C')->setWidth(15);
        //Set RRP
        $sheet->setCellValueByColumnAndRow(4,$tot_tiers+1,"RRP(Inc GST)");
        $sheet->setCellValueByColumnAndRow(4,$tot_tiers+2,$tier[1]);
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
        $ro= $tier[11];
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
            $rrp = $tier[10];
            }else{
            $rrp = $tier[1];
        }
      
          // Obtain points and tiers from current pricing array
          $tier1 = explode(',',$tier[8]);        
        foreach( $tier1 as $key=>$element) {     
              
            //Repeat Name
            $sheet->setCellValueByColumnAndRow(2,$tot_tiers+$key+2,$tier[9]);
            //Repeat SKU
            $sheet->setCellValueByColumnAndRow(3,$tot_tiers+$key+2,$tier[0]);
            //Repeat RRP
            $sheet->setCellValueByColumnAndRow(4,$tot_tiers+$key+2,$tier[10]);
            // Repeat Pricing Type
            $sheet->setCellValueByColumnAndRow(5,$tot_tiers+$key+2,"Persistant"); 
            //Set points and pay 
            $j=6; //Column start
            $tier_price = explode('-',$element);         
            $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+2,(int)$tier_price[0]);
            $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+2,(int)$tier_price[1]);
            //Set 12 months
            if($ro==1){
            $ro_12_mon=(int)$tier_price[1]/12;}
            $sheet->setCellValueByColumnAndRow(8,$tot_tiers+$key+2,$ro_12_mon);
            $cell_12= "H" . strval($tot_tiers+$key+2);
            $sheet->getStyle("$cell_12")->getAlignment()->setHorizontal('right');
            //repeat 24 months
            if($ro==1){
            $ro_24_mon=(int)$tier_price[1]/24;}
            $sheet->setCellValueByColumnAndRow(9,$tot_tiers+$key+2,"$ro_24_mon");
            $cell_24= "I" . strval($tot_tiers+$key+2);
            $sheet->getStyle("$cell_24")->getAlignment()->setHorizontal('right');
            // Repeat RO option
            $sheet->setCellValueByColumnAndRow(10,$tot_tiers+$key+2,$ro_des);
            $cell_ro= "J" . strval($tot_tiers+$key+2);
            if($ro==1){
            $header_color=$tablehead4;}
            else{$header_color=$tablehead3;}  
            $sheet->getStyle("$cell_ro")->applyFromArray($header_color);
            $sheet->getStyle("$cell_ro")->getAlignment()->setHorizontal('center');
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
        //Set New RRP
        $sheet->setCellValueByColumnAndRow(12,$tot_tiers+1,"RRP");
        $sheet->getColumnDimension('L')->setWidth(15);
        //Set New Pricing
        $sheet->setCellValueByColumnAndRow(13,$tot_tiers+1,"Points");
        $sheet->setCellValueByColumnAndRow(14,$tot_tiers+1,"Pay");
        // Obtain points and tiers from new pricing array
        $tier2 = explode(',',$tier[3]);
        foreach( $tier2 as $key=>$element) {

            //Repeat new or old RRP depending on checkbox selection
            $sheet->setCellValueByColumnAndRow(12,$tot_tiers+$key+2,$rrp);
            //Set points and pay
            $j=13; // Column Start
            $tier_price = explode('-',$element);
            $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+2,(int)$tier_price[0]);
            $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+2,(int)$tier_price[1]);
        }
        //Counter to set the starting point for new product $tier[2] needs to be divided by 2 to get the number of tiers   
        $tot_tiers =  $tot_tiers + 2 + $tier[2]/2;    
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
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+3,$tier[9]);
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
          $sheet->setCellValueByColumnAndRow(5,$tot_tiers+3,$dates[0]);
          $sheet->setCellValueByColumnAndRow(6,$tot_tiers+3,$dates[1]);
          //Set Current pricing 
              $tier2 = explode(',',$tier[8]);
              foreach( $tier2 as $key=>$element) {
              $j=7; //Column start
              $tier_price = explode('-',$element);
              $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+3,(int)$tier_price[0]);
              $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+3,(int)$tier_price[1]);
              }
        //Counter to set the starting point for new product $tier[2] needs to be divided by 2 to get the number of tiers   
        $tot_tiers =  $tot_tiers + $tier[2]/2;    
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
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+2,$tier[9]);
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
        $sheet->setCellValueByColumnAndRow(2,$tot_tiers+1,$tier[9]);
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
        //Get RO options
        $ro= $tier[7];
        if($ro=="false"){
          $ro_mon="-";
          $ro_des="No";
        }
      
                // Obtain points and tiers from new pricing array
                $tier1 = explode(',',$tier[3]);

                foreach( $tier1 as $key=>$element) {

                //Repeat Name
                $sheet->setCellValueByColumnAndRow(2,$tot_tiers+$key+2,$tier[9]);
                //Repeat SKU
                $sheet->setCellValueByColumnAndRow(3,$tot_tiers+$key+2,$tier[0]);
                //Set RRP
                $sheet->setCellValueByColumnAndRow(4,$tot_tiers+$key+2,$tier[1]);
                // Pricing Type
                $sheet->setCellValueByColumnAndRow(5,$tot_tiers+$key+2,"Persistant");
                //Repeat 12 months
                $sheet->setCellValueByColumnAndRow(8,$tot_tiers+$key+2,$ro_mon);
                $cell_12= "H" . strval($tot_tiers+$key+2);
                $sheet->getStyle("$cell_12")->getAlignment()->setHorizontal('center');
                //repeat 24 months
                $sheet->setCellValueByColumnAndRow(9,$tot_tiers+$key+2,"$ro_mon");
                $cell_24= "I" . strval($tot_tiers+$key+2);
                $sheet->getStyle("$cell_24")->getAlignment()->setHorizontal('center');
                // Repeat RO option
                $sheet->setCellValueByColumnAndRow(10,$tot_tiers+$key+2,$ro_des);
                $cell_ro= "J" . strval($tot_tiers+$key+2);
                $sheet->getStyle("$cell_ro")->applyFromArray($tablehead3);
                $sheet->getStyle("$cell_ro")->getAlignment()->setHorizontal('center');

                $j=6; // Column Start
                $tier_price = explode('-',$element);
                $sheet->setCellValueByColumnAndRow($j,$tot_tiers + $key+2,(int)$tier_price[0]);
                $sheet->setCellValueByColumnAndRow($j+1,$tot_tiers + $key+2,(int)$tier_price[1]);
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
          
          
        //Counter to set the starting point for new product $tier[2] needs to be divided by 2 to get the number of tiers   
        $tot_tiers =  $tot_tiers + 2 + $tier[2]/2;    
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