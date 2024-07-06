<?php

///////////////////Results table 

function obtain_VPP(){
    include '../data/db_connection.php';

    // $sql="select distinct T1.sku,T2.std_rrp_inc_gst,T1.price from products_last as T1 inner join product_pricing as T2 on T1.sku=T2.orin where T1.segment='LOYALTY_CON' 
    // and T2.category='Hot Offer' order by T2.orin desc";

      $sql="select orin,std_rrp_inc_gst,solomon from product_pricing where category='Hot Offer' and orin in (100250462,100250677,100252465,100252496,100252631,100250722,100155709,100250110,100250324,100252499,100248024,100252238,100250348,100248009,100248007,100248006,100250344,100252728,100252732,100252733,100252727,100252717,100252721,100252722,100252716,100252708,100253263,100253769,100253771,100250716,100250714,100250620,100250617,100250618,100252261,100252272,100251910,100247539,100247556,100250323,100250325,100250345,100250343,100250346,100252103,100250064,100248022,100252081,100250672,100250291,100250971,100250949,100250922,100250921,100252992,100252484,100248477,100252490,100252482,100252485,100252488,100252489,100252486,100252483,100250622,100252334,100252335,100252332,100252333,100252513,100251011,100252214,100252215,100250009,100245501,100252151,100253534,100252149) order by orin desc";

      $result= mysqli_query($con,$sql);
      $row_cnt = mysqli_num_rows($result);
       while($data = mysqli_fetch_array($result)){
        
                  $sku = $data[0]; 
                  $rrp = $data[1];
                  $points= $data[2];
          
        // $price = substr($points, 2, (stripos("$points","-0'")-2));
        // $len= (strlen($price) - strrpos($price,"'"));
        // $price2 = substr($price, -$len);
        // if(substr($price2,0,1)=="'"){
        // $price=substr($price2,1);
        // }
        $price=$points;

        $vpp= round((($rrp/1.1)/$price),10);
        
        //echo $sku." - ".$rrp." - ".$price." - ". $vpp."<br>";

         $sql1="insert into price_tiers(sku,rrp,top_tier,vpp,one_tier) 
        values ('$sku',$rrp,'$price',$vpp,2)";

       //$sql1= "update price_tiers set top_tier=\"$price\",vpp=$vpp,rrp=$rrp,one_tier=2 where sku='$sku'";
        echo $sql1;
        if(mysqli_query($con, $sql1)){
                   echo "Records inserted successfully<br>";
               } else{
                       echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
               }     
      }  

}

function validate_one_tier_price(){
  include '../data/db_connection.php';

  $sql="select distinct T1.sku,T2.std_rrp_inc_gst,T1.price,T1.name from products_last as T1 inner join product_pricing as T2 on T1.sku=T2.orin where T1.segment='LOYALTY_CON' order by T2.std_rrp_inc_gst desc;";
    $result= mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);
     while($data = mysqli_fetch_array($result)){
      
                $sku = $data[0]; 
                $rrp = $data[1];
                $points= $data[2];
                $name= $data[3];

        
      $price = explode(",",$points);
      $tiers=count($price);

        if($tiers<2){
        echo $sku." - ".$rrp." - ".$points." - ".$name."<br>";


        $sql1="update price_tiers set one_tier=1 where sku='$sku'";

               if(mysqli_query($con, $sql1)){
                   echo "Record updated successfully.";
               } else{
                       echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
               }


        }

      }

}

function delete_old_data(){

    include '../data/db_connection.php';

    for($x=0;$x<=1000;$x++){

        $sql1="delete from products where segment='accessories_con' or segment='accessories_con_dv' or segment='loyalty_con_dv' or segment='loyalty_smb' order by sku limit 10000";
        //echo $sql1;
               if(mysqli_query($con, $sql1)){
                   echo "Records deleted successfully:Rows".$x."<br>";
               } else{
                    echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
               }

    }
}

function create_new_pricing($skup=null){

    include '../data/db_connection.php';

    $sql="select distinct sku,rrp,vpp from price_tiers where one_tier=2 and sku in (100250462,100250677,100252465,100252496,100252631,100250722,100155709,100250110,100250324,100252499,100248024,100252238,100250348,100248009,100248007,100248006,100250344,100252728,100252732,100252733,100252727,100252717,100252721,100252722,100252716,100252708,100253263,100253769,100253771,100250716,100250714,100250620,100250617,100250618,100252261,100252272,100251910,100247539,100247556,100250323,100250325,100250345,100250343,100250346,100252103,100250064,100248022,100252081,100250672,100250291,100250971,100250949,100250922,100250921,100252992,100252484,100248477,100252490,100252482,100252485,100252488,100252489,100252486,100252483,100250622,100252334,100252335,100252332,100252333,100252513,100251011,100252214,100252215,100250009,100245501,100252151,100253534,100252149) ";
    

      $result= mysqli_query($con,$sql);
      $row_cnt = mysqli_num_rows($result);
       while($data = mysqli_fetch_array($result)){
        
                  $sku = $data[0]; 
                  $rrp = $data[1];
                  $vpp = $data[2];
        //echo $sku;   
       

        // $sql0="select price from products_last where sku='$sku' and segment ='LOYALTY_CON'";

        // $result0= mysqli_query($con,$sql0);
        // $row_cnt0 = mysqli_num_rows($result0);
        //  while($datax = mysqli_fetch_array($result0)){
          
        //             $price = $datax[0]; 
        //  }


        //$status="1";
        $date_report = date('Y-m-d H:i:s');

         $price=pricing_tiers($data[1],$vpp);
        $price = substr($price, 0, -1)."]";

          $sql1="update products_new_pricing set offer_price=\"$price\",offer_vpp=$vpp where sku='$sku'";
        
          //  $sql1="insert into products_new_pricing(sku,date_report,price,vpp) 
          //  values ('$sku','$date_report',\"$price\",$vpp)";

               if(mysqli_query($con, $sql1)){
                   echo "Records inserted successfully.";
               } else{
                       echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
               }
     }     

    //  $tiers= explode(",",$price);
    //  echo $rrp;
    //  foreach( $tiers as $key=>$element) {

    //   echo $element."<br>";

     //}
}

// function alter_rrp($skup=null){

//   //include '../data/db_connection.php';

//   if($skup){
//     $sql="select sku,rrp from price_changes where sku='$skup'";
//   }else{
//   //$sql="select distinct sku,rrp,vpp from price_tiers order by sku limit 200 offset 1600";
//   }
//   //echo $sql;
//     $result= mysqli_query($con,$sql);
//     $row_cnt = mysqli_num_rows($result);
//      while($data = mysqli_fetch_array($result)){
      
//                 $sku = $data[0]; 
//                 $rrp = $data[1];
//                 //$vpp = $data[2];
//       //echo $sku;   
//       // $price=pricing_tiers($data[1],$vpp);
//       // $price = substr($price, 0, -1)."]";
//       // //$status="1";
//       // $date_report = date('Y-m-d H:i:s');

//       if($skup){
//         $sql1="update price_tiers set rrp =$rrp where sku='$sku'";
//         echo $sql1;

//       }else{
      
//         // $sql1="insert into products_new_pricing(sku,date_report,price,vpp) 
//         // values ('$sku','$date_report',\"$price\",$vpp)";

//       }

//       //echo $sql1;
//              if(mysqli_query($con, $sql1)){
//                  echo "Records updated successfully.";
//              } else{
//                      echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
//              }
//    }     

//   //  $tiers= explode(",",$price);
//   //  echo $rrp;
//   //  foreach( $tiers as $key=>$element) {

//   //   echo $element."<br>";

//    //}
// }

function validate_new_pricing(){

    include '../data/db_connection.php';

    $sql="SELECT distinct T1.sku,T1.price,T2.name from products_new_pricing as T1 inner join products_last as T2 on T1.sku= T2.sku 
    where T2.name not like '%gift card%' and T2.name not like '%recharge%' order by T1.price desc;";

      $result= mysqli_query($con,$sql);
      $row_cnt = mysqli_num_rows($result);
       while($data = mysqli_fetch_array($result)){
        
                  $sku = $data[0]; 
                  $points = $data[1];
                  $name= $data[2];
        $price = substr($points, 2, (stripos("$points","-0'")-2));
        $len= (strlen($price) - strrpos($price,"'"));
        $price2 = substr($price, -$len);
        if(substr($price2,0,1)=="'"){
        $price=substr($price2,1);
        }
        $price2 = stripos("$points","$price");
        $price3 = strrpos("$points","$price");
        $price4=substr($points,1,($price3-3));
        $price4 = "[". $price4."]";
        if($price2 != $price3){

                    echo $sku." | ";   
                    echo $name." | ";   
                    echo $price." | ";
                    // echo $price2."- ".$price3." | ";
                  //  echo $points." | ";
                   //  echo $price4;
                    echo " Different ";
                    echo "<br>";

                        //   $sql1="select distinct sku,rrp from products_last where sku='$sku' and segment='LOYALTY_CON'";
                      
                        // //echo $sql;
                        //   $result1= mysqli_query($con,$sql1);
                        //   $row_cnt = mysqli_num_rows($result1);
                        //   while($data = mysqli_fetch_array($result1)){


                        //     $sku = $data[0]; 
                        //     $rrp = $data[1];

                        //     echo $rrp." | ";   


                        //     $sql2="update price_tiers set rrp =$rrp where sku='$sku'";
                        //     if(mysqli_query($con, $sql2)){
                        //         echo "Records updated successfully.";
                        //     } else{
                        //             echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
                        //     }
                        //   }

                      // $sql2="select sku,rrp from price_tiers  where sku='$sku'";
                  
                      // //echo $sql;
                      //   $result2= mysqli_query($con,$sql2);
                      //   $row_cnt = mysqli_num_rows($result2);
                      //   while($data = mysqli_fetch_array($result2)){
  
  
                      //     $sku = $data[0]; 
                      //     $rrp = $data[1];
  
                      //     echo $rrp."<br>";   
  
  
                          // $sql2="update price_tiers set rrp =$rrp where sku='$sku'";
                          // if(mysqli_query($con, $sql2)){
                          //     echo "Records updated successfully.";
                          // } else{
                          //         echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
                          // }
        //}
                    
                  //   $sql1="update products_new_pricing set price =\"$price4\" where sku='$sku'";
                  //  // echo $sql1;
                  //          if(mysqli_query($con, $sql1)){
                  //              echo "Records updated successfully.";
                  //          } else{
                  //                  echo "ERROR: Could not able to execute $sql1" . mysqli_error($con);
                  //          }


        }
       
     }     
	    
}

function pricing_tiers($rrp,$vpp){

    if($vpp==0){
    $vpp=1;
    }
    $points = $rrp/($vpp*1.1);

    switch ($points) {
        case $points > 0 && $points <6000: $tier_count=6; break;
        case $points > 6000 && $points <30000: $tier_count=18; break;
        case $points > 30000 && $points <50000: $tier_count=22; break;
        case $points > 50000 && $points <100000: $tier_count=27; break;
        case $points > 100000 && $points <200000: $tier_count=32; break;
        case $points > 200000 && $points <500000: $tier_count=38; break;
        case $points > 500000 && $points <2000000: $tier_count=53; break;
    }

    switch ($tier_count) {
        case $tier_count == 6:
            
            switch(true){
                case $points > 0 && $points <1000: $tier_count=1; break;
                case $points > 1000 && $points <2000: $tier_count=2; break;
                case $points > 2000 && $points <3000: $tier_count=3; break;
                case $points > 3000 && $points <4000: $tier_count=4; break;
                case $points > 4000 && $points <5000: $tier_count=5; break;
                case $points > 5000 && $points <6000: $tier_count=6; break;
                }
            break;

        case $tier_count == 18:
           
            switch ($points) {
                case $points > 6000 && $points <8000:$tier_count=7; break;
                case $points > 8000 && $points <10000: $tier_count=8; break;
                case $points > 10000 && $points <12000: $tier_count=9; break;
                case $points > 12000 && $points <14000: $tier_count=10; break;
                case $points > 14000 && $points <16000: $tier_count=11; break;
                case $points > 16000 && $points <18000: $tier_count=12; break;
                case $points > 18000 && $points <20000: $tier_count=13; break;
                case $points > 20000 && $points <22000: $tier_count=14; break;
                case $points > 22000 && $points <24000: $tier_count=15; break;
                case $points > 24000 && $points <26000: $tier_count=16; break;
                case $points > 26000 && $points <28000: $tier_count=17; break;
                case $points > 28000 && $points <30000: $tier_count=18; break;           
            }
            break;


        case $tier_count == 22:  
            switch(true){
            case $points > 30000 && $points <35000: $tier_count=19; break;
            case $points > 35000 && $points <40000: $tier_count=20; break;
            case $points > 40000 && $points <45000: $tier_count=21; break;
            case $points > 45000 && $points <50000: $tier_count=22; break;
            }
        break;

        case $tier_count == 27: 
            switch(true){
            case $points > 50000 && $points <60000: $tier_count=23; break;
            case $points > 60000 && $points <70000: $tier_count=24; break;
            case $points > 70000 && $points <80000: $tier_count=25; break;
            case $points > 80000 && $points <90000: $tier_count=26; break;
            case $points > 90000 && $points <100000: $tier_count=27; break;
            }
        
        break;
        case $tier_count == 32:  
        
            switch(true){
            case $points > 100000 && $points <120000: $tier_count=28; break;
            case $points > 120000 && $points <140000: $tier_count=29; break;
            case $points > 140000 && $points <160000: $tier_count=30; break;
            case $points > 160000 && $points <180000: $tier_count=31; break;
            case $points > 180000 && $points <200000: $tier_count=32; break;
            }
        
        break;

        case $tier_count == 38:  
        
            switch(true){
            case $points > 200000 && $points <250000: $tier_count=33; break;
            case $points > 250000 && $points <300000: $tier_count=34; break;
            case $points > 300000 && $points <350000: $tier_count=35; break;
            case $points > 350000 && $points <400000: $tier_count=36; break;
            case $points > 400000 && $points <450000: $tier_count=37; break;
            case $points > 450000 && $points <500000: $tier_count=38; break;

            }
        
        break;
        case $tier_count == 53:  
        
            switch(true){
            case $points > 500000 && $points <600000: $tier_count=39; break;
            case $points > 600000 && $points <700000: $tier_count=40; break;
            case $points > 700000 && $points <800000: $tier_count=41; break;
            case $points > 800000 && $points <900000: $tier_count=42; break;
            case $points > 900000 && $points <1000000: $tier_count=43; break;
            case $points > 1000000 && $points <1100000: $tier_count=44; break;
            case $points > 1100000 && $points <1200000: $tier_count=45; break;
            case $points > 1200000 && $points <1300000: $tier_count=46; break;
            case $points > 1300000 && $points <1400000: $tier_count=47; break;
            case $points > 1400000 && $points <1500000: $tier_count=48; break;
            case $points > 1500000 && $points <1600000: $tier_count=48; break;
            case $points > 1600000 && $points <1700000: $tier_count=49; break;
            case $points > 1700000 && $points <1800000: $tier_count=50; break;
            case $points > 1800000 && $points <1900000: $tier_count=51; break;
            case $points > 1900000 && $points <2000000: $tier_count=52; break;

            }
        
        break;
    }

    //echo $points;
    $points_digit = strlen((string)intval($points));
   //echo "Points digit ".$points_digit."<br>";


    switch(true){
        case $points_digit < 3: $rounder=1; break;
        case $points_digit < 4: $rounder=10; break;
        case $points_digit < 5: $rounder=100; break;
        case $points_digit < 6: $rounder=1000; break;
        case $points_digit < 8: $rounder=1000; break;
       // case $points_digit < 8: $rounder=100000; break;

    }
    //echo $rounder;

    $tier_pricing = "[";

    for ($x = 0; $x <= $tier_count; $x++) {
      //Get the name for each textbox 
        

      switch(true){
          case $x <= 6: $tierpoints=$x * 1000; break;
          case $x <=18: $tierpoints=$tierpoints + 2000; break; 
          case $x <=22: $tierpoints=$tierpoints + 5000; break;
          case $x <=27: $tierpoints=$tierpoints + 10000; break;
          case $x <=32: $tierpoints=$tierpoints + 20000; break;
          case $x <=38: $tierpoints=$tierpoints + 50000; break;
          case $x <=53: $tierpoints=$tierpoints + 100000; break;
      }


      $pay= round(($points-$tierpoints)*$vpp*1.1,2);

      if($x==$tier_count){
        // $points= round($points/$rounder)*$rounder;
        // $points = round ($points, -3);
         $tierpoints= round($points);
        $pay=0;
      }

      $tier_pricing .= "'".$tierpoints."-". $pay."',";
      
            
  }
    return $tier_pricing;
}

function Update_new_rrp_flow(){

build_table_sales(build_excel_data("master-data.xlsx"),"master-data.xlsx");


 }

create_new_pricing();
//delete_old_data();
//obtain_VPP();
//validate_one_tier_price();
//phpinfo();
//validate_new_pricing();
//Update_new_rrp_flow();

?>

<form method="POST" action="new-pricing.php" enctype="multipart/form-data">

    <div>

      <span>Upload a File:</span>

      <input type="file" name="uploadedFile" />

    </div>

    <input type="submit" name="uploadBtn" value="Upload the File" />

  </form>

</body>

</html>


<?php


$message = ''; 

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload the File')

{

  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)

  {

    // uploaded file details

    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];

    $fileName = $_FILES['uploadedFile']['name'];

    $fileSize = $_FILES['uploadedFile']['size'];

    $fileType = $_FILES['uploadedFile']['type'];

    $fileNameCmps = explode(".", $fileName);

    $fileExtension = strtolower(end($fileNameCmps));

    // removing extra spaces

    $newFileName = "master-file" . '.' . $fileExtension;

    // file extensions allowed

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xlsx', 'doc');

    if (in_array($fileExtension, $allowedfileExtensions))

    {

      // directory where file will be moved

      $uploadFileDir = "../files/"; //. $_FILES['uploadedFile']['name'];

      $dest_path = $uploadFileDir . $newFileName;

      echo $dest_path;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 

      {

        $message = 'File uploaded successfully.';

      }

      else 

      {

        $message = 'An error occurred while uploading the file to the destination directory. Ensure that the web server has access to write in the path directory.';

      }

    }

    else

    {

      $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);

    }

  }

  else

  {

    $message = 'Error occurred while uploading the file.<br>';

    $message .= 'Error:' . $_FILES['uploadedFile']['error'];

  }

}

echo $message;


//header("Location: index.php");


?>

<a href="new-pricing.php?x=update"> Update master RRP </a>

<?php
//Export productc to excel file
if(isset($_GET['x'])){           
// include 'file-master-to-db.php'; 
// build_table_sales(build_excel_data("../files/master-file.xlsx"),"../files/master-file.xlsx");
}
// obtain_VPP();
// echo "New VPP has been updated";
// create_new_pricing();
// echo "New pricing has been created";
?>



