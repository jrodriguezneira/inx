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
    
        if($i==1){
        $sheetName = $worksheet['worksheetName']; 

        /**  Load $inputFileName to a Spreadsheet Object  **/
        $reader->setLoadSheetsOnly($sheetName);
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        //print_r($worksheet->toArray());
        $array= $worksheet->toArray();
        }
    $i++;
    }

return $array;
}


////////////////////Results table 

function build_table($array,$filenamex){
    include '/home2/stagierv/public_html/inx/loy/data/db_connection.php';
    $header=0;

    $sql2="truncate table products_last";
                    if(mysqli_query($con, $sql2)){
                        //echo "Records inserted successfully.";
                    } else{
                            echo "ERROR: Could not able to execute $sql2" . mysqli_error($con);
                    }

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
                $stock= $value2;
                break;
            case 3:
                $ro= $value2;
                break;
            case 4:
                $rrp= $value2;
                break;
            case 5:
                $price= $value2;
                break;
            case 6:
                $offer= $value2;
                break;
            case 7:
                $family= $value2;
                break;
            case 8:
                $category= $value2;
                break;
            case 9:
                $segment= $value2;
                break;
            case 10:
                $stock_notice= $value2;
                break;
                        

            }
        }

            //Skip table header values
            if($header>0){
            //Insert product details into products table products
            
            $stock_notice= str_replace('"',' ',$stock_notice);
                               
            $sql1="insert into products (sku,date_report,name,stock,ro,rrp,price,offer,family,category,segment,stock_notice,launch_date) 
             values ('$sku','$date','$name','$stock','$ro','$rrp',\"$price\",'$offer',\"$family\",\"$category\",'$segment',\"$stock_notice\",null)";
                
                    if(mysqli_query($con, $sql1)){
                        //echo "Records inserted successfully.";
                    } else{
                            echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
                    }

	    $sql3="insert into products_last (sku,date_report,name,stock,ro,rrp,price,offer,family,category,segment,stock_notice,launch_date)
             values ('$sku','$date','$name','$stock','$ro','$rrp',\"$price\",'$offer',\"$family\",\"$category\",'$segment',\"$stock_notice\",null)";

                    if(mysqli_query($con, $sql3)){
                        //echo "Records inserted successfully.";
                    } else{
                            echo "ERROR: Could not able to execute $sql3" . mysqli_error($con);
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

    $datex= explode(' ',$filenamex);
    foreach( $datex as $key => $datetime) {
        
        switch($key){
            case 1:
                $dates= $datetime;
                $newdate=explode('-',$dates);
                $datex=$newdate[2]."-".$newdate[1]."-".$newdate[0];
                break;
            case 2:
                $times= $datetime;
                $newtime=explode('_',$times);
                $seconds=explode('.',$newtime[2]);

                $timex=$newtime[0].":".$newtime[1].":".$seconds[0];
                break;
        }       
    }
    $date= $datex." ".$timex;

return $date;

}

function bulk_loader(){

    // set file pattern
    $dirpath = "/home2/stagierv/*.xlsx";
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
                $name=$name[3];
                //echo "name ".$name."/n";
                $currentfilepath = "/home2/stagierv/".$name;
                $excelfilepath="/home2/stagierv/excel/".$name;
                
                if(!is_file($excelfilepath)){  

                    $type = "sales";  

                        if(strpos($name, $type) !== false){

                            build_table_sales(build_excel_data($filenamex),"$filenamex");
                            echo "#".$key." File inserted". $filenamex;
                            
                            $fileMoved = rename($currentfilepath,$excelfilepath);
                            if($fileMoved){ 
                            echo "File moved to ".$excelfilepath."\n";

                        
                        }else{

                            build_table(build_excel_data($filenamex),"$filenamex");
                            echo "#".$key." File inserted". $filenamex;
                            
                            $fileMoved = rename($currentfilepath,$excelfilepath);
                            if($fileMoved){ 
                            echo "File moved to ".$excelfilepath."\n";

                        }


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
