<?php 
include '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function create_excel($sku,$name,$oldprice,$newprice){

  
// Creates New Spreadsheet 
$spreadsheet = new Spreadsheet(); 
  
// Retrieve the current active worksheet 
$sheet = $spreadsheet->getActiveSheet(); 

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


$productname=explode('-',$name);

$tier = explode(',',$newprice);
//Row start
$i=0;

    foreach( $tier as $key=>$element) {
    //Column start
    $j=3;
    $tier_price = explode('-',$element);
    if ($i==0){
      $sheet->setCellValueByColumnAndRow(1,$i+3,$sku);
      $sheet->setCellValueByColumnAndRow(2,$i+3,$productname[0]);
    }
    $sheet->setCellValueByColumnAndRow($j,$i+3,(int)$tier_price[0]);
    $sheet->setCellValueByColumnAndRow($j+1,$i+3,(int)$tier_price[1]);
    $i++;
    }

    $tier2 = explode(',',$oldprice);
     $i=0;
        foreach( $tier2 as $key=>$element) {
        $j=7;
        $tier_price = explode('-',$element);
        $sheet->setCellValueByColumnAndRow($j,$i+3,(int)$tier_price[0]);
        $sheet->setCellValueByColumnAndRow($j+1,$i+3,(int)$tier_price[1]);
        $i++;
        }
   

// Write an .xlsx file  
$writer = new Xlsx($spreadsheet); 
  
// Save .xlsx file to the files directory 
$filename="demo2.xlsx";
$writer->save('demo2.xlsx');  

?>
<script>

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

download('https://staging-sr9-loy-ing-awsserv.site/inx/loy/demo2.xlsx', 'demo2.xlsx');
</script>

<?php

}
?>







