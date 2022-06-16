//Search function with enter key across al pages
window.addEventListener("DOMContentLoaded", function () {

    var form = document.getElementById("form_sku_search");

    document.getElementById("button_sku_search").addEventListener("click", function () {
      form.submit();
    });
});

// Global variable to store copied tier values
var copy_tiers='';


///////////////   Function to obtain previous offer
function Previous_Offer(pre,sku){
    var pointspay;
    var points;
    var pay;
        //Divide each price tier
        var prev = pre.split(",");
        //Loop through tiers to assign values 
        for (var i = 0; i < prev.length; i++) {
            //Get points pay text boxes
            var poi_nam= sku + '_txt_poi_' + i;
            var pay_nam= sku + '_txt_pay_' + i;
            // Divide price by points and pay
            pointspay=prev[i].split("-");
            // Set variables with points and pay 
            points=pointspay[0];
            pay=pointspay[1];
            //Assign points and pay to textfield boxes
            document.getElementById(poi_nam).value=parseInt(points);
            document.getElementById(pay_nam).value=parseInt(pay);
            Check_Price(sku,i);
        }
}
///////////////   End function to obtain previous offer


///////////////   Function to verify top and bottom tiers and top tier point value////////////
function Top_Bottom_Tiers(newrrp,tiers,sku,type){
    // Variables for top and bottom tiers 
    var bot_poi;
    var top_poi;
    var top_ppvv= 0.002750;
    //Make tier rounded to 500 to avoid decimals 
    var tier_rounder =500;
        // Set value for relative top point value ( based on previous data)
        switch(true){
            case 100 > newrrp: pv_top=0.002966666666667; break;
            case 200 > newrrp: pv_top=0.002929; break;
            case 300 > newrrp: pv_top=0.00312; break;
            case 400 > newrrp: pv_top=0.002828; break;
            case 1000 > newrrp: pv_top=0.002828; break;
            case 2500 > newrrp: pv_top=0.002828; break;
        } 
    //Get value from UI for Top tier  
    var top= sku + '_txt_poi_0';   
    top_poi= document.getElementById(top).value;
    //If top tier value is empty, then is calculated based on RRP and points value
    if(top_poi.length===0){
    
        
        //Set value for top tier
        top_poi = Math.round(newrrp/pv_top);
        if(type=="new"){
        top_poi=newrrp/(top_ppvv*1.1);   
        }
        // Apply ounder top tier value to avoid decimals    
        var res= top_poi/tier_rounder;
        // Get rounded value
        top_poi = Math.round(res)* tier_rounder;
        // Create array with top and bottom tiers
     

    }
    //Get value for bottom tier from UI
    var bot= sku + '_txt_poi_' + (tiers-1);
    bot_poi= document.getElementById(bot).value;
    //console.log("master bot_poi" + bot_poi);
    //If bottom tier value is empty, then is calculated based on RRP and points value(based on previous data)
   
    if(bot_poi.length===0 && type=="new"){
        switch(true){
            case 60 > newrrp: bot_poi=5000; break;
            case 300 > newrrp: bot_poi=5000;break;
            case 400 > newrrp: bot_poi=5000; break;
            case 1000 > newrrp: bot_poi=5000; break;
            case 1500 > newrrp: bot_poi=7500; break;
        } 
    }   
   
   
    if(bot_poi.length===0){
        switch(true){
            case 60 > newrrp: bot_poi=2000; break;
            case 300 > newrrp: bot_poi=2500;break;
            case 400 > newrrp: bot_poi=5000; break;
            case 1000 > newrrp: bot_poi=5000; break;
            case 2500 > newrrp: bot_poi=7500; break;
        } 
    }  
   
    var top_bottom= top_poi + "," + bot_poi;
console.log("initial Top-bottom: " + top_bottom);
return top_bottom;
}
///////////////    End function to verify top and bottom tiers and top tier point value////////////


///////////////   Function to calculate points increment per tier
function Tier_increment(top_tier,bottom_tier,tiers){
  //Average increment depending on tiers range to fill up / -3 to exclude top and bottom 2 tieres 
  if(tiers==3){tiers=5;}
  var inc = Math.round((top_tier- bottom_tier)/(tiers-3));
    //Set rounded increment depending on increment value
    switch(true){
    case inc > 1000 && inc <1500: inc=1000; break;
    case inc > 1500 && inc <2010: inc=2000; break;
    case inc > 2011 && inc <5000:  inc=2500; break;
    case inc > 5000 && inc <7500 && tiers <=5:  inc=2500; break;
    case inc > 5000 && inc <10000:  inc=5000; break;
    
    case inc > 10000 && inc <15000: inc=10000; break;
    case inc > 15000 && inc <20000: inc=15000; break;
    case inc > 20000 && inc <25000: inc=20000; break;
    case inc > 25000 && inc <30000: inc=25000; break;
    case inc > 30000 && inc <35000: inc=30000; break;
    case inc > 35000 && inc <40000: inc=35000; break;
    }
return inc;
}
///////////////  End function to calculate points increment per tier


///////////////   Function to calculate pay increment////////////
function Pay_Increment(rrp){
    //Set text field names for product
    var ini_pay;
    switch(true){
        case rrp > 550 && rrp <=700: ini_pay=120; inc=120; limit=2; break;

       // 120-2,(100-24)-1, 24-16

       case rrp > 700 && rrp <=900: ini_pay=120; inc=120; limit=4; break;

       // 120-3,(100-24) - 1 , 24-15

        case rrp > 900 && rrp <=980: ini_pay=240; inc=120; limit=3; break;

       // 120-3,(100-24) - 1 , 24-15

        case rrp > 980 && rrp <=1100: ini_pay=240; inc=120;limit=4; break;

       // 120-4/ 5, (100-24) - 1, 24-14

        case rrp > 1100 && rrp <=1200: ini_pay=240; inc=120; limit=6; break;

       // 120-5 /6, (100-24) - 1, /24-13
        
        case rrp > 1200 && rrp <=1250: ini_pay=240; inc=120; limit=7; break;

       // 120-6 /7/8, (100-24) - 1, /24-12
       case rrp > 1250 && rrp <=1600: ini_pay=240; inc=120; limit=9; break;

       case rrp > 1600 && rrp <=2000: ini_pay=240; inc=120; limit=10; break;


    }
    
return [ini_pay,inc,limit]
}
///////////////   Function to calculate pay increment////////////



///////////////   Function to calculate the pricing margin////////////
function Check_Price(sku,key,tiers,type){
    //Set text field names for product
    var poi_nam= sku + '_txt_poi_' + key;
    var pay_nam= sku + '_txt_pay_' + key;
    var valu_nam = sku + '_txt_val_' + key;
    var mar_nam = sku + '_txt_mar_' + key;
    var per_nam = sku + '_txt_per_' + key;
    //Top and bottom ppvv values
    var top_ppvv= 0.002750;
    var bot_ppvv= 0.002500;
    //Set PPVV decrement for number of tiers 
    var dec= ((top_ppvv - bot_ppvv)/(Number(tiers))).toFixed(6);
    //Variables for caculating new pricing 
    var last_pay;
    var ppvv;
    var tier_rounder=500;
    // Get pay,points,rrp and wac values
    var points= document.getElementById(poi_nam).value;
    var pay= document.getElementById(pay_nam).value;
    var rrp = document.getElementById(sku + '_rrp').innerHTML;
    var wac = document.getElementById(sku + '_fwac').value; 
    //Obtain new RRp from text box
    var newrrp = document.getElementById(sku + '_txt_new_rrp').value;
    var pv=0.003030;


        //If RO option is selected 
        var chk_ro = document.getElementById(sku + '_chk_ro').checked;
        if(chk_ro){
            
           // tier_rounder=500; 
            var ro_12= sku + '_ro_12_' + key;
            var ro_24= sku + '_ro_24_' + key;

            if(key!=0){
                //Validate if checking price comes from create offer(multi tiers) or for a single tier
                if(tiers){

                    payment= Pay_Increment(newrrp); 

                    pay_ini= payment[0];
                    pay_inc= payment[1];
                    limit= payment[2];

                    pv=0.002828;
                    
                    if( key <= limit){

                        //Set new pay/////////////
                        if(key==1){
                        document.getElementById(pay_nam).value = pay_ini; 
                        pay= pay_ini;
                        }else{
                        var pay_nam_bef= sku + '_txt_pay_' + (key-1);
                        last_pay= document.getElementById(pay_nam_bef).value;
                        pay = Number(last_pay) + Number(pay_inc);   
                        document.getElementById(pay_nam).value = pay; 
                        }
                        //Set new points//////////////
                        points = (((newrrp/1.1) - (pay/1.1) ).toFixed(2) )/0.0025;
                        var res= points/tier_rounder;
                        points = Math.round(res)* tier_rounder;
                        document.getElementById(poi_nam).value=points;
                        //Update 12/24 months payment
                        document.getElementById(ro_12).innerHTML = (pay)/12;
                        document.getElementById(ro_24).innerHTML = (pay)/24;

                    }else{
                        if(key == (limit + 1) ){
                            //Get last payment with initial increment $120
                            var pay_nam_ini= sku + '_txt_pay_1';
                            var pay_ini= document.getElementById(pay_nam_ini).value ;
                            //Temporary RO adjusters 
                            if(pay_ini==120){
                            last_pay= (120 * limit)+ 52;
                            }
                            if(pay_ini==120 && limit ==4){
                                last_pay= (120 * limit);
                            }
                            if(pay_ini==240){
                                last_pay= (120 * limit )+ 172;
                            }
                            if(pay_ini==240 && limit==7){
                                last_pay= (120 * limit ) + 120;
                            }
                            if(pay_ini==240 && limit ==3){
                                last_pay= (120 * limit) + 196;
                            }
                            if(pay_ini==240 && (limit ==9) || limit==10){
                                last_pay= (120 * limit) + 220;
                            }
                            //End temporary RO adjusters 
                        }else{
                        var pay_nam_bef= sku + '_txt_pay_' + (key-1);
                        last_pay= document.getElementById(pay_nam_bef).value;
                        //console.log(last_pay);
                        }

                        pay= (Math.round(Number(last_pay) + 24)).toFixed(0);

                        if(key == (limit + 2) && limit==3 && pay_ini==240){
                        pay = (Math.round(Number(last_pay) + 48)).toFixed(0); 
                        }

                        if(key == (limit + 1) && limit==6){
                        pay = (Math.round(Number(last_pay))).toFixed(0); 
                        }

                        if(key == (limit + 1) && limit==4){
                        pay = (Math.round(Number(last_pay) + 24)).toFixed(0); 
                        }
                        document.getElementById(pay_nam).value = pay;
                        //Update 12/24 pay component
                        document.getElementById(ro_12).innerHTML = pay/12;
                        document.getElementById(ro_24).innerHTML = pay/24;
                        
                       //Set new points
                       points = (((newrrp/1.1) - (pay/1.1) ).toFixed(2) )/0.0025;
                       var res= points/tier_rounder;
                       points = Math.round(res)* tier_rounder;
                       document.getElementById(poi_nam).value=points;

                    }     
                }
            }
        }
        
        if(type=="new" && !chk_ro){
                   // Calculate the ppvv according to tier(key)
            if(key==0){
            ppvv = top_ppvv.toFixed(6);
            //document.getElementById(per_nam).value=ppvv; 
            }else{
            ppvv = (top_ppvv -(key*dec)).toFixed(6);
            }
            //Recalculate pay component and update the value
            pay = rrp-(ppvv * 1.1 * points);
            if(key==0){
            pay=0;
            }
            pay = pay.toFixed(0);
            document.getElementById(pay_nam).value= pay;            
        }

        if(type=="new" && chk_ro){                        
            // Calculate the ppvv according to tier(key)
            if(key==0){
            ppvv = top_ppvv.toFixed(6);
            //document.getElementById(per_nam).value=ppvv; 
            }else{
            ppvv = (top_ppvv -(key*dec)).toFixed(6);
            }
            //Recalculate points component and update margins

            points = (rrp - pay) /(ppvv * 1.1 );
            res= points/tier_rounder;
            points = Math.round(res)* tier_rounder;
            document.getElementById(poi_nam).value=points;
        }

     // Calculate pricing margins
     var valu = ((points*0.0025) + (pay/1.1)).toFixed(2);
     var mar = (valu - wac).toFixed(2);
     var per =(((rrp-pay)/points)/(1.1)).toFixed(6);
     //Set pricing margin values
     document.getElementById(valu_nam).value= valu;
     document.getElementById(valu_nam).setAttribute("Title", valu*1.1.toFixed(2));
     document.getElementById(mar_nam).value= mar;
     document.getElementById(per_nam).value=per;  

     console.log(  points + " * 0.0025 = " + (points * 0.0025) + " " + pay + "/1.1 = " + pay/1.1 + " Total= "  + Number(Number(points*0.0025) + Number(pay/1.1)) );
    
     
}
///////////////   End function to calculate the pricing margin////////////


///////////////    Function to calculate tier changers ////////////
function Tiers_Change(tiers,inc,top_tier,bottom_tier){
    //Number of tiers without top , second last and last tier
     var tiersdiv= tiers-3;   
     var tier_change;
     var tier_gap;
     var tier_array=[];
     var tier_change=[];
     var tiers_arr="";
     var tiers_arr_1="";
     var fix=0;
     var inc_half;
     //for new products
     if(inc==10000){fix=5000;}
    //for offer
    if(inc==5000 && bottom_tier==2500){fix=2500;}
     console.log({fix});
      
      //Tier gap and filling for half increment ( low prices)
      tier_array[0] = top_tier- ((((inc/2)*tiersdiv) + Number(bottom_tier)));
      tier_change[0]= (inc/2) + "-" + (tiers-2);
      //Tier gap and filling for initial increment with no tier increment changes
      tier_array[1] = top_tier- (((inc*tiersdiv) + Number(bottom_tier)));
      tier_change[1]= inc + "-" + (tiers-2);

      // Calculate top gap and tier filling with different variations ( making the tier increment change on different positions)
      for (var w = 2; w < tiers; w++) {       
        tier_array[w] = top_tier- ((((inc*2) * w) + (inc* (tiersdiv-w))) + Number(bottom_tier) - fix);
        tier_change[w]= (inc*2) + "-" + w + "," + inc + "-" + (tiers-w);
        tiers_arr_1 += "Tier_gap_" + w + " = " + tier_array[w] + ", ";
        }

     //Tier gap and filling for low prices with long range tiers
     for (var z = 2; z < tiers; z++) {
        //Total array elements
         y=(tiers-2)+z;
         if(inc==2500){
         inc_half=1500;
         }else{
         inc_half= inc/2; 
         }

         tier_array[y] = top_tier- ((((inc) * z) + ((inc_half)* (tiersdiv-z))) + Number(bottom_tier) );
         tier_change[y]= (inc) + "-" + z + "," + inc_half + "-" + (tiers-z);
         tiers_arr += "Tier_gap_" + y + " = " + tier_array[y] + ", ";

        if(tier_array[y] == tier_array[1]){
            var tier_1_check = true;
        }

         }
        
 
    //Select base gap with initial increment to define 
        var tier_gap_0 = tier_array[0];
        var tier_gap_1 = tier_array[1];
    //Print gap variables to confirm results
    console.log("Tiers " + tiers);
    console.log("Tier_gap_0 = " + tier_array[0]);
    console.log("Tier_gap_1 = " + tier_array[1]);
    console.log(tiers_arr_1);
    console.log(tiers_arr);
   // console.log({top_tier},{bottom_tier});
    //Duplicate tier array to store original array order( Ascendent by gap)
    let new_tier_array = tier_array.slice();

   //Filter undefined and tier changes with less than 0 gap and select the lowest tier gap between top tier and second top tier ( Mostly aplicable to low prices )
   var filtered = tier_array.filter(function(x) {
   return x !== undefined;});
   tier_array = filtered.filter(item => !(item <= 0));
   tier_array = tier_array.sort(function (a, b) {  return a - b;  });
   var lower_tier = tier_array.slice(0,1).toString(); 
   var low= lower_tier.split(",").join('');
   console.log("Initial lowest tier gap(bysort) " + low);

    //If initial half increment is too small , we choose the closest gap to the highest increment ( Mostly aplicable for low prices with several tiers)
    if(tier_gap_0 > (inc)){
        //console.log("tier_gap_0 validation ");
        var counts = tier_array;
        goal = inc;
        var closest = counts.reduce(function(prev, curr) {
        return (Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev);
        });
        var tot = closest +  ((inc*tiersdiv) + Number(bottom_tier)) ;
        console.log({tot});
        // 
        // Validate tires for new products
        if (tot < top_tier ){
        low = closest;
        }
        if( (closest - inc) > 1000){
        low = closest;
        }
        //Avoid 
        if( tier_gap_1 < (inc/2) ){
            low = closest;
        }
        if(inc== 10000 && low < inc){
            low = closest;
        }
        // End Validate tires for new products
        console.log("tier_gap_0 closest " + closest);
        }

   //If initial increment is too small, instead of choosing the smallest gap we need to find the closest gap to highest increment (Mostly aplicable to products with price between 100 and 500 and higher)
   if(tier_gap_1 > (inc*2)){
        var counts = tier_array;
        goal = inc*2;
        var closest = counts.reduce(function(prev, curr) {
        return (Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev);
        });
        
        if ( top_tier > 20000){
        low = closest;
        }

        console.log("tier_gap_1 closest " + closest);
   }

  
   
    // Select the tier change with closest tier gap value to the highest increment or the tier change with the lowest tier gap ( Indicated above when to choose the closest or lowest tier gap)
    console.log({low});
    for (var i = 0; i <= y ; i++) {
       //tier = "tier_gap_" + i;   
        if(new_tier_array[i]== low){

            if(i==1 && tier_1_check){
            console.log("Tier 1 gap not taken");
            }else{
            tier_change= tier_change[i];
            tier_gap= new_tier_array[i];
            console.log(" Tier selected(i)= " + i);
            break;
            }

        }
    }
//Bottom tier to be added to tiers array ( not last tier)
bot_tier= inc + "-" + (tiers-1);
// Return the tier increment changes to fill the pricing points and tier gap to fulfill the difference 
return tier_change + "," + bot_tier + "," + tier_gap ;
}
///////////////   End Function to calculate tier changers ////////////


///////////////   Function to clear the offer////////////
function Clear_Offer(sku){
    var points;
    var pay;
    var tiers= document.getElementById(sku + '_hid_tie').value;
    for (var i = 0; i < tiers; i++) {

        var poi_nam= sku + '_txt_poi_' + i;
        var pay_nam= sku + '_txt_pay_' + i;
        var valu_nam = sku + '_txt_val_' + i;
        var mar_nam = sku + '_txt_mar_' + i;
        var per_nam = sku + '_txt_per_' + i;

        document.getElementById(poi_nam).value="";
        document.getElementById(pay_nam).value=""; 
        document.getElementById(valu_nam).value= "";
        document.getElementById(mar_nam).value= "";
        document.getElementById(per_nam).value="";     

    }

}
///////////////   Function to clear the offer////////////



///////////////   Function to create the offer////////////
function Create_Offer(sku,type){
  var points;
  var pay;
  // Var tiers to obtain tier number for the product
  var tiers= document.getElementById(sku + '_hid_tie').value;
  //pv = point value in $
  var pv=0.002828;
  //Obtain new RRp from text box
  var newrrp = document.getElementById(sku + '_txt_new_rrp').value;
  //Obtain top and bottom tiers
  var top_bottom= Top_Bottom_Tiers(newrrp,tiers,sku,type);
  top_bottom= top_bottom.split(",");
  var top_tier = top_bottom[0];
  var bottom_tier = top_bottom[1];
  //Obtain base increment 
  var inc = Tier_increment(top_tier,bottom_tier,tiers);
  console.log("Inc function: " + inc); 
  // Obtain the number of layers per increment to fulfill pricing points 
  var tier_changers= Tiers_Change(tiers,inc,top_tier,bottom_tier,sku);
  console.log("tier_changers: " + tier_changers); 
  // Split each layer by the increment and tier number to make the change
  var layers= tier_changers.split(",");
  // Get tier gap from last element on layers array
  var tier_start=0;
  var z= layers.length;
  if (z==4){
  var val_changers= z-2;
  }else{
    val_changers= z-1;   
  }
  var gap_tier= layers[z-1];
  points= gap_tier;
   //Loop through the number of layers per increment to fulfill pricing points 
    for (var i = 0; i < val_changers; i++) {
        // Split each layer by the increment and tier number to make the change
        var tier_inc= layers[i].split("-")[0];
        var tier_change= layers[i].split("-")[1];
        // Loop through each range of tiers and increment and set the value for text fields 
            //tier_change = tier_change + tier_start-2;
            if(tier_start!=0){
            tier_change= Number(tier_change) + Number(tier_start) - 2;
            }
            //console.log({tier_change});
            for (var x = tier_start; x <= (tier_change); x++) {
                //Get the name for each textbox 
                var poi_nam= sku + '_txt_poi_' + x;
                var pay_nam= sku + '_txt_pay_' + x;
                //Set the value for each textbox 
                points= points - tier_inc;
                if(x==0){ points = top_tier;}  
                if(x==1){ points = top_tier - gap_tier;}   
                if(x==(tiers-1)){ points = bottom_tier;}   
                //Calculate pay from RRP and points caculated 
                pay = newrrp-(pv*points); 
                if(x==0){ pay = 0;}
                // Set values on text fields  
                document.getElementById(poi_nam).value=points;
                document.getElementById(pay_nam).value=Math.round(pay); 
                //Obtain pricing margins 
                Check_Price(sku,x,tiers,type)
                tier_start++;           
            }
    }
}
/////////////// End Function to create the offer////////////


/////////////////////  Function to create URL containing product offer details
function Create_File(target){            
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
    //Get number of products
    var x = document.getElementsByClassName("sku_cel");
    var k =0;
    //Loop through number of products to create array
      for (var i = 0; i < x.length; i++) { 
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
        //Get Dates
        var start = document.getElementsByClassName("date_pick")[k].value;
        y= Format_Date(start);
        var end = document.getElementsByClassName("date_pick")[k+1].value;
        z= Format_Date(end);
        dates= y + ',' + z;
        k = k + 2;
        fwac = document.getElementsByClassName("txt_fwac")[i].value;
        // Create URL with information required to create the excel offer file
        // Array with sku details: sku(0),rrp(1), number of tiers(2),tiers pricing(3), dates(4), stock(5), check rrp(6), check_ro(7), fwac(8)
        prod += 'sku' + i + '=' + sku + '*' + rrp + '*' + tot_tiers + '*' + tiers + '*' + dates + '*' + stock + '*' + chk_rrp + '*' + chk_ro + '*' + fwac + '&';
      } 
    // Append number of skus to offer URL (skus array) and export file type(target)
    prod= 'i=' + i + '&' + prod;
    var url = 'off-cr1.php?' + prod + 'target=' + target;
    //console.log("Prod" + prod);
   // console.log("target" + target);
    window.open(url, '_blank'); 
  }
////////////////////// End Function to create URL containing product offer details for shop


/////////////////////  Function to copy tiers directly from UI
function Copy_Tiers(sku){
 //Get pricing tiers from product
 copy_tiers='';
 var w = document.getElementsByClassName(sku + '_txt_pri');
     for (var s = 0; s < w.length; s += 2) {
        copy_tiers += w[s].value + '-' + w[s+1].value + ',';
     }
     copy_tiers= copy_tiers.slice(0, -1);
}
/////////////////////  End function to copy tiers directly from UI


/////////////////////  Function to paste tiers from UI ( same number of tiers)
function Paste_Tiers(sku){
    //Get vaues from global variable copy_tiers
    var pointspay;
    var points;
    var pay;
        //Divide each price tier
        var prev = copy_tiers.split(",");
        //Loop through tiers to assign values 
        for (var i = 0; i < prev.length; i++) {
            //Get points pay text boxes
            var poi_nam= sku + '_txt_poi_' + i;
            var pay_nam= sku + '_txt_pay_' + i;
            // Divide price by points and pay
            pointspay=prev[i].split("-");
            // Set variables with points and pay 
            points=pointspay[0];
            pay=pointspay[1];
            //Assign points and pay to textfield boxes
            document.getElementById(poi_nam).value=parseInt(points);
            document.getElementById(pay_nam).value=parseInt(pay);
        }
}
/////////////////////  End function to paste tiers from UI ( same number of tiers)


/////////////////////  Function to update format date to Agora 
function Format_Date(offer_date){
var datetime= offer_date.split("T");
var date = datetime[0];
var dates=date.split("-");
var newdate= dates[2] + "/" + dates[1] + "/" + dates[0];
var offer_date = newdate + "  " + datetime[1];
return offer_date;
}
/////////////////////  End  function to update format date to Agora 


/////////////////////  Function to verify rebate value and update pricing details
function Check_Rebate(sku){
    // Get the rebate value from UI and update wac and fwac values
    var rebate= sku + '_txt_reb';
    var reb= document.getElementById(rebate).value;
    var newreb = (document.getElementById(sku + '_wac').innerHTML - reb).toFixed(2);
    document.getElementById(sku + '_wac').innerHTML= Number(newreb).toFixed(2);
    document.getElementById(sku + '_fwac').value=Number(newreb).toFixed(2);
}
///////////////////// End function to verify rebate value and update pricing details