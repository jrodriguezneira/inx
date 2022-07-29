<?php include 'business/trends.php'; ?>



                <!-- ////////////////////////Create offer UI elements for products ///////////////////////////////////////////////////////////////////////-->
                    
                <?php
                //Number of skus =1
                $i= $_GET['i'];
                //File format to export
                $target= $_GET['target'];
                $name= $_GET['name'];
                $id= get_trend("id_promo");
                $stat=$_GET['stat'];
                if(is_null($id)){$id=1;}
                if(!is_null($id)){$id=$id+1;}
                
                //echo $id;
                    for ($x = 0; $x < $i; $x++) {
                    $skus= $_GET['sku'.$x];
                    if($stat){
                        $crud="update";
                        $id=$stat;
                    }
                    
                    insert_price($skus,$target,$name,$id,$crud);                      
                    
                    $sku = explode('*',$skus);   
                    $url.="sku".$x."=".trim($sku[0])."*Stock&";                
                    }

                $url=$url ."&q=$i&stat=$id";                
                header("Location: off-cr.php?$url");
                exit();
              
             
                ?>