
////////////////////// Populate dates across products ////////////////////////////

function Populate_Dates(){

    var dates = document.getElementsByClassName('date_pick');
    var start= dates[0].value;
    var end= dates[1].value;
   
    for (var i = 2; i < dates.length; i++) {

        if(i % 2 === 0){
            dates[i].value = start;
        }else{
            dates[i].value =end;
        }          
    }

}
////////////////////// End populate dates across products ////////////////////////////

////////////////////// Change Text ////////////////////////////

function Change_Text(){
    // Change text on button to add products or cancel the action
    var btntxt= document.getElementById("but_new").innerHTML;
    if(btntxt=="+"){
    document.getElementById("but_new").innerHTML= "Cancel";}
    else{
        document.getElementById("but_new").innerHTML= "+";  
    }
  

}
////////////////////// End Change Text ////////////////////////////



////////////////////// Add boxes to offer table ////////////////////////////
function Add_Boxes(sku){ 
    var tableid = sku + '_tab_offer';
    var tbodyRef= document.getElementById(tableid);
    var tiers= document.getElementById(sku + '_hid_tie').value;
        
    // Insert a row at the end of table
    var newRow = tbodyRef.insertRow();
    
    // Insert a cell at the end of the row
    var newCell = newRow.insertCell();
    var newCell1 = newRow.insertCell();
    var newCell2 = newRow.insertCell();
    var newCell3 = newRow.insertCell();
    var newCell4= newRow.insertCell();
    var newCell5 = newRow.insertCell();
    var newCell6= newRow.insertCell();
    var newCell7 = newRow.insertCell();

    newCell.className="cell_price";
    newCell1.className="cell_price";
    /*newCell2.className="cell_price";
    newCell3.className="cell_price";
    newCell4.className="cell_price";*/
    newCell5.className="cell_price";
    newCell6.className="cell_price";
    newCell7.className="cell_price";
    
    //Append text box for points  to table
    var newinputbox = document.createElement("input");
    newinputbox.setAttribute("type", "text");
    newinputbox.setAttribute("id", sku + "_txt_poi_" + tiers);
    newinputbox.setAttribute("class", sku + "_txt_pri");
    newinputbox.style.width='70px';
    newinputbox.style.height='22px';   
    
     //Append text box for pay  to table
     var newinputbox1 = document.createElement("input");
     newinputbox1.setAttribute("type", "text");
     newinputbox1.setAttribute("id", sku + "_txt_pay_" + tiers);
     newinputbox1.setAttribute("class", sku + "_txt_pri");
     newinputbox1.style.width='50px';
     newinputbox1.style.height='22px'; 

     //Append label for  price ratio
     var label1 = document.createElement("label");
     label1.setAttribute("type", "label");
     label1.setAttribute("id", sku + "_lab_pri_" + tiers);
     label1.style.height='12px'; 

     //Append label for  12 months
     var label2 = document.createElement("label");
     label2.setAttribute("id", sku + "_ro_12_" + tiers);
     label2.style.height='12px'; 

     //Append label for  24 months
     var label3 = document.createElement("label");
     label3.setAttribute("id", sku + "_ro_24_" + tiers);
     label3.style.height='12px'; 

     //Append text box for value  to table
     var newinputbox2 = document.createElement("input");
     newinputbox2.setAttribute("type", "text");
     newinputbox2.setAttribute("id", sku + "_txt_val_" + tiers);
     newinputbox2.style.width='70px';
     newinputbox2.style.height='22px'; 

     //Append text box for margin  to table
     var newinputbox3 = document.createElement("input");
     newinputbox3.setAttribute("type", "text");
     newinputbox3.setAttribute("id", sku + "_txt_mar_" + tiers);
     newinputbox3.style.width='70px';
     newinputbox3.style.height='22px'; 

     //Append text box for Pvpp  to table
     var newinputbox4 = document.createElement("input");
     newinputbox4.setAttribute("type", "text");
     newinputbox4.setAttribute("id", sku + "_txt_per_" + tiers);
     newinputbox4.style.width='80px';
     newinputbox4.style.height='22px'; 

    newCell.appendChild(newinputbox);
    newCell1.appendChild(newinputbox1);
    newCell2.appendChild(label1);
    newCell3.appendChild(label2);
    newCell4.appendChild(label3);
    newCell5.appendChild(newinputbox2);
    newCell6.appendChild(newinputbox3);
    newCell7.appendChild(newinputbox4);

    document.getElementById(sku + '_hid_tie').value= Number(tiers) + 1;
    //var tier_count= document.getElementById(sku + '_tier_counter').innerHTML;
    document.getElementById(sku + '_tier_counter').innerHTML = Number(tiers) + 1;

    // Verify boxes name array goes here
        
    }
////////////////////// End Add boxes to offer table////////////////////////////

function Jump_Cell(keycode,sku,key,type){ 


    if(keycode == "ArrowDown"){
        var txt_box= sku + '_txt_' + type + '_' + (Number(key) + 1);
        document.getElementById(txt_box).focus();

    }
    if(keycode == "ArrowUp"){
        var txt_box= sku + '_txt_' + type + '_' + (Number(key) - 1);
        document.getElementById(txt_box).focus();

    }


    
    
}

////////////////////// Remove boxes to offer table ////////////////////////////
function Remove_Boxes(sku){ 
    var tableid = sku + '_tab_offer';
    var table= document.getElementById(tableid);
    var rowCount = table.rows.length;
    table.deleteRow(rowCount -1);
    var tiers= document.getElementById(sku + '_hid_tie').value;
    document.getElementById(sku + '_hid_tie').value= Number(tiers) - 1;
    document.getElementById(sku + '_tier_counter').innerHTML = Number(tiers) - 1;
    }
////////////////////// End remove boxes to offer table////////////////////////////



////////////////////// Remove boxes to offer table ////////////////////////////
function Paste_Offer(sku){ 
      
        var txt= sku + '_txt_poi_0';
     
        var input= document.getElementById(txt);
            
        console.log(event.clipboardData.getData('text/plain'));
        var excel= event.clipboardData.getData('text/plain');
        var tiers = excel.split("\n");

            for (var i = 0; i < tiers.length-1; i++) {
                var points= sku + '_txt_poi_' + i;
                var pay= sku + '_txt_pay_' + i;
                var pointspay = tiers[i].split("\t");
                var stdpoints = pointspay[0].split(',').join('');
                var stdpay = pointspay[1].trim().substring(1);
                stdpay = stdpay.split(',').join('');
                console.log(stdpoints + " -" + stdpay);
                if(i===0){
                stdpay=0;
                } 
                document.getElementById(points).value=Number(stdpoints);
                document.getElementById(pay).value=Math.trunc(stdpay);
                Check_Price(sku,i);
            }

        event.preventDefault();

        input.oncut = input.oncopy = function(event) {
        alert(event.type + '-' + document.getSelection());
        event.preventDefault();
        };        
    var points= sku + '_txt_poi_' + i;
    var pay= sku + '_txt_pay_' + i;
    var pointspay = tiers[i].split("\t");
    var stdpoints = pointspay[0].split(',').join('');
    var stdpay = pointspay[1].trim().substring(1);
    stdpay = stdpay.split(',').join('');
    console.log(stdpoints + " -" + stdpay);
    if(i===0){
    stdpay=0;
    } 
    document.getElementById(points).value=Number(stdpoints);
    document.getElementById(pay).value=Math.trunc(stdpay);
    Check_Price(sku,i);
}
////////////////////// End remove boxes to offer table////////////////////////////


////////////////////// Fill price from offer match ////////////////////////////
function Fill_Price(sku,prices){ 

    var price = prices.split(",");
      
  
            for (var i = 0; i < price.length-1; i++) {
                var points= sku + '_txt_poi_' + i;
                var pay= sku + '_txt_pay_' + i;

                var pointspay = price[i].split('-');
                var stdpoints = pointspay[0];
                var stdpay = pointspay[1];
              
                document.getElementById(points).value=Number(stdpoints);
                document.getElementById(pay).value=Math.trunc(stdpay);
                Check_Price(sku,i);
                console.log(price[i]);

            }
    
        $('#offerModal').modal('hide');
}
////////////////////// End fill price from offer match////////////////////////////



////////////////////// Remove boxes to offer table ////////////////////////////
function Paste_Products(){        
    console.log(event.clipboardData.getData('text/plain'));
    var excel= event.clipboardData.getData('text/plain');
     
    var tiers = excel.split("\n");
    console.log("tiers lenght" + tiers.length);
    if (tiers.length > 1){
    //if(tiers){
      //  console.log(tiers.lenght);
        
        for (var i = 0; i < tiers.length-1; i++) {

            var orin= 'sku_' + i;
            var name= 'name_' + i;
            var rrpinc= 'rrpinc_' + i;      
            var vpp= 'vpp_' + i; 

            var fields = tiers[i].split("\t");
            var orin_val = fields[0];
            var name_val = fields[1];
            var rrpinc_val = fields[2];
            var vpp_val = fields[3];

            console.log("Orin val "+ fields[0]);
      
                 
            if(i>0){
            Add_Pricing_Boxes(i);
            }
                document.getElementById(orin).value=orin_val;
                document.getElementById(name).value=name_val;               
                document.getElementById(rrpinc).value=rrpinc_val;
                document.getElementById(vpp).value=vpp_val;
            }
            event.preventDefault();
            input.oncut = input.oncopy = function(event) {
            alert(event.type + '-' + document.getSelection());
            event.preventDefault();
        };

    }else{
    document.getElementById(orin_0).value=excel;    
    }
}
////////////////////// End remove boxes to offer table////////////////////////////



////////////////////// Add boxes to offer table ////////////////////////////
function Add_Pricing_Boxes(row){ 
    var tableid = 'insert_data';
    var tbodyRef= document.getElementById(tableid);
    // Insert a row at the end of table
    var newRow = tbodyRef.insertRow();
    var newCell=[];

    for (var i = 0; i < 4; i++) {
        newCell[i] = newRow.insertCell();
        newCell[i].className="cell_new_price";
    if(i==1)
    {newCell[i].className="cell_new_price_name";}
    }

    var newinputbox=[];
    
    var cells =["sku","name","rrpinc","vpp"];

    for (var i = 0; i < 4; i++) {
        //Append text box for points  to table
        newinputbox[i] = document.createElement("input");
        newinputbox[i].setAttribute("type", "text");
        newinputbox[i].setAttribute("id", cells[i] + "_" + row);
        if(i!=1){newinputbox[i].style.width='100px';}
        if(i==1){newinputbox[i].style.width='380px';}
        newinputbox[i].style.height='22px'; 
    }
    for (var i = 0; i < 4; i++) {
    newCell[i].appendChild(newinputbox[i]);
    }
    // Verify boxes name array goes here
}
////////////////////// End Add boxes to offer table////////////////////////////
