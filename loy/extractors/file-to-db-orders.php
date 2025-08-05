<?php
/////////This file is placed in the root directory to be scheduled with CRON/////////////////
include '/home2/stagierv/public_html/inx/vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


//////////////Load excel file 

function build_excel_data($filenamex){

$spreadsheet = new Spreadsheet();
$inputFileType = 'Xlsx';
//$filenamex=get_file_name();
//echo $filenamex;
$inputFileName = $filenamex;
/**  Create a new Reader of the type defined in $inputFileType  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
/**  Advise the Reader that we only want to load cell data  **/
$reader->setReadDataOnly(true);
$worksheetData = $reader->listWorksheetInfo($inputFileName);

//counter for loyalty datasheet
$i=0;
    foreach ($worksheetData as $worksheet) {
    
        //if($i==1){
        $sheetName = $worksheet['worksheetName']; 

        /**  Load $inputFileName to a Spreadsheet Object  **/
        $reader->setLoadSheetsOnly($sheetName);
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        //print_r($worksheet->toArray());
        $array= $worksheet->toArray();
        //}
    $i++;
    }

return $array;
}


////////////////////Results table 

function build_table_sales($array,$filenamex){
    include '/home2/stagierv/public_html/inx/loy/data/db_connection.php';
    $header=0;

    $date= get_file_date($filenamex);
    foreach( $array as $key=>$value){
     
        foreach($value as $key2=>$value2){
           
            switch($key2){
            case 0:
                $sku= $value2;
                break;
            case 1:
                $name= $value2;
                break;
            case 2:
                $day_sales= $value2;
                break;
            case 3:
                $day_sales_loy= $value2;
                break;           

            }
        }

            //Skip table header values
            if($header>0){
            //Insert product details into products table products
            
            // $stock_notice= str_replace('"',' ',$stock_notice);
                               
            $sql1="insert into product_sales (sku,name,day_sales,day_sales_loy,date_report) 
             values ('$sku','$name',$day_sales,$day_sales_loy,'$date')";
                
                    if(mysqli_query($con, $sql1)){
                        //echo "Records inserted successfully.";
                    } else{
                            echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
                    }



	    }

            $header++;
        
    }
}

//Get last file name
function get_file_name(){

    $files = scandir('../excel/', SCANDIR_SORT_DESCENDING);
    foreach($files as $file){
        if (strpos($file, 'xlsx') !== false) {
            $filenamex= $file;
            break;
        }

    }
return $filenamex;
}


//Get last file date
function get_file_date($filenamex){

    $datex= explode('_',$filenamex);
    $year= explode(".",$datex[4]);
    $date = "20".$year[0]."-".$datex[2]."-".$datex[3];
    
return $date;

}

function bulk_loader(){

    // set file pattern
    $dirpath = "/home2/stagierv/sales/*.xlsx";
     // copy filenames to array
    $files = array();
    $files = glob($dirpath);

    // sort files by last modified date
    usort($files, function($x, $y) {
        return filemtime($x) < filemtime($y);
    });
    
    $count= count($files);
    //echo $count."\n";
    foreach($files as $key=>$file){

        if($key>=0 and $key <=$count){

            if (strpos($file, 'xlsx') !== false) {
                $filenamex= $file;
                $name=explode("/",$filenamex);
                $name=$name[4];
                //echo "name ".$name."/n";
                $currentfilepath = "/home2/stagierv/sales/".$name;
                $excelfilepath="/home2/stagierv/sales/sales_bk/".$name;
                
                if(!is_file($excelfilepath)){  

                                
                            build_table_sales(build_excel_data($filenamex),"$filenamex");
                            echo "#".$key." File inserted". $filenamex;
                            
                            $fileMoved = rename($currentfilepath,$excelfilepath);
                            if($fileMoved){ 
                            echo "File moved to ".$excelfilepath."\n";                 
                            }
                }else{
                echo "File".$filenamex."already exists"."\n";   
                
                }

                
            }
        }
    }
}

//build_excel_data();
bulk_loader();

?> 
