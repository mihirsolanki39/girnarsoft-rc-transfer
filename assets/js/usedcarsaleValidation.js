function validateForm1(){
    error_flag=false;
    var btype=$('input[name=buyer_type]:checked').val();
    var customer_name=$('#customer_name').val();
    var customer_length=$('#customer_name').val().length;
    var customer_company_name=$('#customer_company_name').val();
    var customer_mobile=$('#customer_mobile').val();
    var customer_email=$('#customer_email').val();
    var customer_address=$('#customer_address').val();
    var driving_license_no=$('#driving_license_no').val();
    var reference_of=$('#reference_of').val();
    var lead_source=$('#lead_source').val();
    var customer_relation=$('#customer_relation').val();
    var relation_name=$('#relation_name').val();
    var relation_address=$('#relation_address').val();
    
    $('.error').html("");
    if(typeof btype=='undefined'){
        
        $('#buyer_type_error').html("Please Select Buyer Type");
            error_flag=true;
    }
    if(btype=='1'){
    if(customer_name==''){
        $('#customer_name_error').html("Please enter Customer Name");
            error_flag=true;
    }else if(customer_length < 3){
        $('#customer_name_error').html("Please enter Customer Name of minimum 3 Character");
            error_flag=true;
    }
    }
    if(btype=='2'){
        if(customer_company_name==''){
            $('#customer_company_name_error').html("Please enter Customer Company Name");
                error_flag=true;
        }
    }
    if(customer_mobile==''){
        $('#customer_mobile_error').html("Please enter Customer Mobile");
            error_flag=true;
    }else if(isNaN(customer_mobile)){
      $('#customer_mobile_error').html("Please enter valid Customer Mobile");
       error_flag=true;  
    }
    if(customer_mobile!=''){
        var IndNum = /^[0]?[6789]\d{9}$/;
        if(IndNum.test(customer_mobile)){
        //error_flag=false;
        }else{
        $('#customer_mobile_error').html("Please enter valid Customer Mobile");
       error_flag=true;
        }
    }   
    if(customer_email!=''){
        var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(emailReg.test(customer_email)){
        //error_flag=false;
        }else{
        $('#customer_email_error').html("Please enter Valid Customer Email");
       error_flag=true;
        }
    }   
    if(customer_email==''){
        $('#customer_email_error').html("Please enter customer Email");
            error_flag=true;
    }
    if(customer_address==''){
        $('#customer_address_error').html("Please enter customer Address");
            error_flag=true;
    }
    if(lead_source==''){
        $('#lead_source_error').html("Please Select Source");
            error_flag=true;
    }  
    return error_flag;
}
function validateUsedCarSalesFrom(form_id){
    var error=false;
    
    $('.error').hide();
    $('#'+form_id+' :input').each(function(){
        if($(this).prop('type')=='radio' && ( typeof $('input[name="'+this.name+'"]:checked').val()=='undefined' || $('input[name="'+this.name+'"]:checked').val()=='')){
             $('#'+this.name+'_error').show(); 
             error=true;
        }
            
        if($(this).prop('required')==true && ($(this).val()=='')){
            $('#'+this.name+'_error').show();
            error=true;
        }
    });
    
    
    
    if(error){
       snakbarAlert('Please Rectify Errors');
        //$('html, body').animate({scrollTop: 100}, 2000);
    }
    return error;
}

$('#booking_date').datepicker({
    format: 'dd-mm-yyyy',
    //startDate: 'd',
    endDate: 'd',
    autoclose: true,
    todayHighlight: true
});
$('#date_of_delivery').datepicker({
    format: 'dd-mm-yyyy',
    //startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#payment_date').datepicker({
    format: 'dd-mm-yyyy',
    //startDate: 'd',
    endDate: 'd',
    autoclose: true,
    todayHighlight: true
});
$('#instrument_date').datepicker({
    format: 'dd-mm-yyyy',
    startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#sold_on').datepicker({
    format: 'dd-mm-yyyy',
    startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#sold_invoice_date').datepicker({
    format: 'dd-mm-yyyy',
    //startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#insdates').datepicker({
    format: 'dd-mm-yyyy',
    startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#paydates').datepicker({
    format: 'dd-mm-yyyy',
    startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#delivery_date').datepicker({
    format: 'dd-mm-yyyy',
    //startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});
$('#sold_invoice_date').datepicker({
    format: 'dd-mm-yyyy',
    startDate: 'd',
    //endDate: '+2y',
    autoclose: true,
    todayHighlight: true
});


function forceNumber(event){
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
        return false;
}
 

function addCommasdd(nStr,control)
{

	nStr=nStr.replace(/,/g,'');  
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{2})/;
	var len;
	var x3="";
	len=x1.length;
	if(len>3){
		var par1=len-3;
		
		x3=","+x1.substring(par1,len);
		x1=x1.substring(0,par1);
		
		//alert(x3);
	}
	len=x1.length;
	if(len>=3 && x3!=""){
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	}

	
	document.getElementById(control).value=x1 +x3+x2;
}