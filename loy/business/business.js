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
        }
}
///////////////   End function to obtain previous offer


///////////////   Function to verify top and bottom tiers and top tier point value////////////
function Top_Bottom_Tiers(newrrp,tiers,sku){
    // Variables for top and bottom tiers 
    var bot_poi;
    var top_poi;
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
    // Apply ounder top tier value to avoid decimals    
    var res= top_poi/tier_rounder;
    // Get rounded value
    top_poi = Math.round(res)* tier_rounder;
    // Create array with top and bottom tiers
    }
    //Get value for bottom tier from UI
    var bot= sku + '_txt_poi_' + (tiers-1);
    bot_poi= document.getElementById(bot).value;
    //If bottom tier value is empty, then is calculated based on RRP and points value(based on previous data)
    if(bot_poi.length===0){
        switch(true){
            case 60 > newrrp: bot_poi=2000; break;
            case 300 > newrrp: bot_poi=2500;break;
            case 400 > newrrp: bot_poi=5000; break;
            case 1000 > newrrp: bot_poi=6000; break;
            case 2500 > newrrp: bot_poi=7500; break;
        } 
    }   
    var top_bottom= top_poi + "," + bot_poi;
//console.log(top_bottom);
return top_bottom;
}
///////////////    End function to verify top and bottom tiers and top tier point value////////////


///////////////   Function to calculate points increment per tier
function Tier_increment(top_tier,bottom_tier,tiers){
  //Average increment depending on tiers range to fill up / -3 to exclude top and bottom 2 tieres 
  var inc = Math.round((top_tier- bottom_tier -2500)/(tiers-3));
    //Set rounded increment depending on increment value
    switch(true){
    case inc > 1000 && inc <1500: inc=1000; break;
    case inc > 1500 && inc <2010: inc=2000; break;
    case inc > 2011 && inc <5000:  inc=2500; break;
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


///////////////   Function to calculate the pricing margin////////////
function Check_Price(sku,key){
    //Set text field names for product
    var poi_nam= sku + '_txt_poi_' + key;
    var pay_nam= sku + '_txt_pay_' + key;
    var valu_nam = sku + '_txt_val_' + key;
    var mar_nam = sku + '_txt_mar_' + key;
    var per_nam = sku + '_txt_per_' + key;
    // Get pay,points,rrp and wac values
    var points= document.getElementById(poi_nam).value;
    var pay= document.getElementById(pay_nam).value;
    var newrrp = document.getElementById(sku + '_txt_new_rrp').value;
    var wac = document.getElementById(sku + '_fwac').innerHTML; 
    //If RO option is selected 
    var chk_ro = document.getElementById(sku + '_chk_ro').checked;
    if(chk_ro){
        var ro_12= sku + '_ro_12_' + key;
        var ro_24= sku + '_ro_24_' + key;

        var mon_24 = (Math.round(pay)/24).toFixed(2);
        mon_24 = Math.round(mon_24);
        document.getElementById(ro_12).innerHTML = mon_24*2;
        document.getElementById(ro_24).innerHTML = mon_24;
        //Update pay component to avoid decimals 
        document.getElementById(pay_nam).value = mon_24*24;
    }  
    // Calculate pricing margins
    var valu = ((points*0.0025) + (pay/1.1)).toFixed(2);
    var mar = (valu - wac).toFixed(2);
    var per =((((newrrp/1.1)-pay)/points)/(1.1)).toFixed(5);
    //Set pricing margin values
    document.getElementById(valu_nam).value= valu;
    document.getElementById(mar_nam).value= mar;
    document.getElementById(per_nam).value=per;      
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
      //Temporary fixer for increment of 2500 or even number of tiers?
      var fix=0;
      if(inc==2500){fix=inc;}
      //Tier gap and filling 
      tier_array[0] = top_tier- ((((inc/2)*tiersdiv) + (bottom_tier*2)));
      tier_change[0]= (inc/2) + "-" + (tiers-2);
      //Tier gap and filling for initial increment with no tier increment changes
      tier_array[1] = top_tier- (((inc*tiersdiv) + (bottom_tier*2)));
      tier_change[1]= inc + "-" + (tiers-2);
      // Calculate top gap and tier filling with different variations ( making the tier increment change on different positions)
      for (var w = 2; w < 11; w++) {
        tier_array[w] = top_tier- ((((inc*2) * w) + (inc* (tiersdiv-w))));
        tier_change[w]= (inc*2) + "-" + w + "," + inc + "-" + (tiers-w);
      } 
   //Select base gap with initial increment to define 
    var tier_gap_1 = tier_array[1];
   
   //Filter undefined and tier changes with less than 0 gap and select the lowest tier gap between top tier and second top tier ( Mostly aplicable to low prices )
   var filtered = tier_array.filter(function(x) {
   return x !== undefined;});
   tier_array = filtered.filter(item => !(item <= 0));
   tier_array = tier_array.sort(function (a, b) {  return a - b;  });
   var lower_tier = tier_array.slice(0,1).toString(); 
   var low= lower_tier.split(",").join('');

   //If initial increment is too small, instead of choosing the smallest gap we need to find the closest gap to highest increment (Mostly aplicable to products with price between 100 and 500 and higher)
   if(tier_gap_1 > (inc*2)){
        var counts = tier_array;
        goal = inc*2;
        var closest = counts.reduce(function(prev, curr) {
        return (Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev);
        });
        low = closest;
   }
    // Select the tier change with closest tier gap value to the highest increment or the tier change with the lowest tier gap ( Indicated above when to choose the closest or lowest tier gap)
    for (var i = 0; i < 11; i++) {
       //tier = "tier_gap_" + i;   
        if(tier_array[i]== low){
            tier_change= tier_array[i];
            tier_gap= tier_gap[i];
            break;
        }
    }
//Bottom tier to be added to tiers array asdasdasdasdasdasdasdasdasdas
bot_tier= inc + "-" + (tiers-1);
// Return the tier increment changes to fill the pricing points and tier gap to fulfill the difference 
return tier_change + "," + bot_tier + "," + tier_gap ;
}
///////////////   End Function to calculate tier changers ////////////


///////////////   Function to create the offer////////////
function Create_Offer(sku){
  var points;
  var pay;
  // Var tiers to obtain tier number for the product
  var tiers= document.getElementById(sku + '_hid_tie').value;
  //pv = point value in $
  var pv=0.002828;
  //Obtain new RRp from text box
  var newrrp = document.getElementById(sku + '_txt_new_rrp').value;
  //Obtain top and bottom tiers
  var top_bottom= Top_Bottom_Tiers(newrrp,tiers,sku);
  top_bottom= top_bottom.split(",");
  var top_tier = top_bottom[0];
  var bottom_tier = top_bottom[1];
  //Obtain base increment 
  var inc = Tier_increment(top_tier,bottom_tier,tiers);
  console.log("Inc function: " + inc); 
  // Obtain the number of layers per increment to fulfill pricing points 
  var tier_changers= Tiers_Change(tiers,inc,top_tier,bottom_tier);
  console.log("tier_changers: " + tier_changers); 
  // Split each layer by the increment and tier number to make the change
  var layers= tier_changers.split(",");
  // Get tier gap from last element on layers array
  var tier_start=0;
  var z= layers.length;
  var gap_tier= layers[z-1];
  points= gap_tier;
   //Loop through the number of layers per increment to fulfill pricing points 
    for (var i = 0; i < z-1; i++) {
        // Split each layer by the increment and tier number to make the change
        var tier_inc= layers[i].split("-")[0];
        var tier_change= layers[i].split("-")[1];
        // Loop through each range of tiers and increment and set the value for text fields      
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
                Check_Price(sku,x)
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
        // Create URL with information required to create the excel offer file
        // Array with sku details: sku(0),rrp(1), number of tiers(2),tiers pricing(3), dates(4), stock(5), check rrp(6), check_ro(7)
        prod += 'sku' + i + '=' + sku + '*' + rrp + '*' + tot_tiers + '*' + tiers + '*' + dates + '*' + stock + '*' + chk_rrp + '*' + chk_ro + '&';
      } 
    // Append number of skus to offer URL (skus array) and export file type(target)
    prod= 'i=' + i + '&' + prod;
    var url = 'off-cr1.php?' + prod + 'target=' + target;
    console.log("Prod" + prod);
    console.log("target" + target);
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
    var newreb = document.getElementById(sku + '_wac').innerHTML - reb;
    document.getElementById(sku + '_wac').innerHTML= newreb;
    document.getElementById(sku + '_fwac').innerHTML=newreb;  
}
///////////////////// End function to verify rebate value and update pricing details




  