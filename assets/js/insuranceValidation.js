function validateForm1(){
    error_flag=false;
    var btype=$('input[name=buyer_type]:checked').val();
    var customer_name=$('#customer_name').val();
    var customer_company_name=$('#customer_company_name').val();
    var customer_length=$('#customer_name').val().length;
    var customer_company_length=$('#customer_company_name').val().length;
    var customer_mobile=$('#customer_mobile').val();
    var reference_customer_mobile=$('#reference_customer_mobile').val();
    var customer_email=$('#customer_email').val();
    var ins_category=$('#ins_category').val();
    var source=$('#source').val();
    var dealerName=$('#dealer_Name').val();
    var salesName=$('#sales_exec').val();
    var assign_to=$('#assign_to').val();
    $('.error').html("");
    if(btype==undefined){
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
        }else if(customer_company_length < 3){
          $('#customer_company_name_error').html("Please enter Customer Company Name of minimum 3 Character");
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
    if(customer_email==''){
        $('#customer_email_error').html("Please enter Customer Email");
            error_flag=true;
    }else if(customer_email!=''){
        var emailFlag=isEmail(customer_email);
        if(emailFlag==false){
        $('#customer_email_error').html("Please enter Valid Customer Email");
        error_flag=true;
        }
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
    if (reference_customer_mobile != '') {
        var IndNum = /^[0]?[6789]\d{9}$/;
        if (IndNum.test(reference_customer_mobile)) {
            //error_flag=false;
        } else {
            $('#reference_customer_mobile_error').html("Please enter valid Reference Customer Mobile");
            error_flag = true;
        }
    }
    if(ins_category==''){
        $('#ins_category_error').html("Please Select Category");
            error_flag=true;
    }
    if(source==''){
        $('#source_error').html("Please Select Source");
            error_flag=true;
    }
    if(source=='dealer'){
        if(dealerName==''){
            $('#dealerName_error').html("Please Select Dealer");
                error_flag=true;
        }
        if(salesName==''){
            $('#sales_exec_error').html("Please Select Sales Executive");
                error_flag=true;
        }
    }
    if(assign_to==''){
        $('#assign_to_error').html("Please Select Assign to");
            error_flag=true;
    }
    return error_flag;
}

function validateForm2(){
    error_flag=false;
    var customer_address=$('#customer_address').val();
    var customer_city=$('#customer_city').val();
    var customer_pincode=$('#customer_pincode').val();
    var customer_dob=$('#customer_dob').val();
    var customer_occupation=$('#customer_occupation').val();
    //var customer_annual_income=$('#customer_annual_income').val();
    //var customer_aadhar=$('#customer_aadhar').val();
    var customer_pan=$('#customer_pan').val();
    var customer_gst=$('#customer_gst').val();
    var nominee_customer_name=$('#nominee_customer_name').val();
    var nominee_customer_age=$('#nominee_customer_age').val();
    var nominee_customer_address=$('#nominee_customer_address').val();
    var nominee_customer_pincode=$('#nominee_customer_pincode').val();
    var nominee_customer_city=$('#nominee_customer_city').val();
    var nominee_customer_relation=$('#nominee_customer_relation').val();
    var btype=$('#btype').val();
    $('.error').html("");
    if(customer_address==''){
        $('#customer_address_error').html("Please enter Customer Address");
            error_flag=true;
    }
    if(customer_city==''){
        $('#customer_city_error').html("Please Select Customer City");
            error_flag=true;
    }
    if(customer_pincode==''){
        $('#customer_pincode_error').html("Please enter Pincode");
            error_flag=true;
    }else if(('#customer_pincode').length < 6){
        $('#customer_pincode_error').html("Please enter valid Pincode");
            error_flag=true;
    }
   /* if(customer_dob==''){
        $('#customer_dob_error').html("Please enter Customer DOB");
            error_flag=true;
    }
    if(customer_occupation==''){
        $('#customer_occupation_error').html("Please Select Customer Occupation");
            error_flag=true;
    }
    //alert(error_flag);
    if((customer_aadhar!='') && (('#customer_aadhar').length < 12)){
        $('#customer_aadhar_error').html("Please enter valid Aadhar No");
            error_flag=true;
    }*/
    if(customer_pan!=''){
        if(customer_pan.length==10){
        var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/;
        if( !customer_pan.match(regExp) ){ 
             $('#customer_pan_error').html("Please enter Valid Customer Pan No.");
             error_flag=true; 
            } 
        }else{
            $('#customer_pan_error').html("Please enter 10 digits Customer Pan No.");
             error_flag=true;
        }
    }
    
    // if(btype=='2'){
    //     if(customer_gst==''){
    //         $('#customer_gst_error').html("Please enter Customer GST");
    //             error_flag=true;
    //     }
        
    // }
    if(btype=='1'){
    if(nominee_customer_name==''){
        $('#nominee_customer_name_error').html("Please enter Nominee Customer Name");
            error_flag=true;
    }
    if(nominee_customer_age==''){
        $('#nominee_customer_age_error').html("Please Select Nominee Customer Age");
            error_flag=true;
    }
//    if(reference_customer_mobile!=''){
//        var IndNum = /^[0]?[6789]\d{9}$/;
//        if(IndNum.test(reference_customer_mobile)){
//        //error_flag=false;
//        }else{
//        $('#reference_customer_mobile_error').html("Please enter valid Reference Customer Mobile");
//       error_flag=true;
//        }
//    }
    if($('#isaddress').prop("checked") ==false){
    if(nominee_customer_address==''){
        $('#nominee_customer_address_error').html("Please enter Reference Customer Address");
            error_flag=true;
    }
    if(nominee_customer_pincode==''){
        $('#nominee_customer_pincode_error').html("Please enter Nominee Customer Pincode");
            error_flag=true;
    }
    if(nominee_customer_city==''){
        $('#nominee_customer_city_error').html("Please Select Nominee Customer City");
            error_flag=true;
    }
   }
    if(nominee_customer_relation==''){
        $('#nominee_customer_relation_error').html("Please Select Nominee Customer Relation");
            error_flag=true;
    }
    }
    return error_flag;
    }
    function validateForm3(){
      error_flag=false;
    var regNo=$('#regNo').val();
    var make=$('#make').val();
    var model=$('#model').val();
    var variant=$('#variant').val();
    var engine_no=$('#engine_no').val();
    var chassis_no=$('#chassis_no').val();
    var makemonth=$('#makemonth').val();
    var myear=$('#myear').val();
    //var regmonth=$('#regmonth').val();
    //var regyear=$('#regyear').val();
    var reg_date=$('#reg_date').val();
    var car_city = $("#car_city").val();
    var inscat=$('#inscat').val();
    $('.error').html("");
    
    if(regNo==''){
        $('#regNo_error').html("Please enter Reg No");
            error_flag=true;
    }
    if(regNo!='' && (inscat=='2' || inscat=='3' || inscat=='4'))
    { 
        var car_reg_no = regNo.replace(/\s/g, ''); 
        var regEX=/^[A-Za-z]{2}[0-9]{1,2}[A-Za-z]{1,3}[0-9]{1,4}$/;
        if(!car_reg_no.match(regEX)) 
        { 
          $('#regNo_error').html("Please enter Valid Reg No"); 
          error_flag=true; 
        } 
    }
    if(car_city==''){
        $('#car_city_error').html("Please Select City");
            error_flag=true;
    }
    if(make==''){
        $('#make_error').html("Please Select Make");
            error_flag=true;
    }
    if(model==''){
        $('#model_error').html("Please Select Model");
            error_flag=true;
    }
    if(variant==''){
        $('#variant_error').html("Please Select Variant");
            error_flag=true;
    }
    if((engine_no!='') && ((engine_no.length < '6') || (engine_no.length > '17'))){
        $('#engine_no_error').html("Please enter valid Engine No");
            error_flag=true; 
    }
    if((chassis_no!='') && ((chassis_no.length < '6') || (chassis_no.length > '17'))){
        $('#chassis_no_error').html("Please enter valid Chassis No");
            error_flag=true; 
    }
    if(makemonth==''){
        $('#makemonth_error').html("Please Select Make Month");
            error_flag=true;
    }
    if(myear==''){
        $('#myear_error').html("Please Select Make Year");
            error_flag=true;
    }
    if(inscat=='2' || inscat=='3' || inscat=='4'){
    if(regmonth==''){
        $('#regmonth_error').html("Please Select Reg Month");
            error_flag=true;
    }
    if(regyear==''){
        $('#regyear_error').html("Please Reg Year");
            error_flag=true;
    }
    if(reg_date==''){
        $('#reg_date_error').html("Please Select Registration Date");
            error_flag=true;
    }
    var arrReg=reg_date.split("-");
    var regmonth=arrReg[1];
    var regyear=arrReg[2];
    var dt = new Date();
    var cmonth=dt.getMonth()+1;
    var cyear = dt.getFullYear();
    if((cyear==regyear) && (parseInt(regmonth) > cmonth)){
     $('#regmonth_error').html("Please Select valid Reg Month");
            error_flag=true;
    }
    if((cyear==myear) && (parseInt(makemonth) > cmonth)){
     $('#makemonth_error').html("Please Select valid Make Month");
            error_flag=true;
    }
    if(regyear < myear){
      $('#reg_date_error').html("Reg Year should be greater than Make Year");
            error_flag=true;  
    }else if(regyear == myear){
       if(parseInt(regmonth) < parseInt(makemonth)){
       $('#reg_date_error').html("Reg Month should be greater than Make Month");
            error_flag=true; 
        }    
    }
    }else if(inscat=='1'){
        var dt = new Date();
        var cmonth=dt.getMonth()+1;
        var cyear = dt.getFullYear();
        if((cyear==myear) && (parseInt(makemonth) > cmonth)){
         $('#makemonth_error').html("Please Select valid Make Month");
                error_flag=true;
        }
    }
    return error_flag;
    }
    function validateForm4(){
      error_flag=false;
    var ins_company=$('#ins_company').val();
    var previous_policy_no=$('#previous_policy_no').val();
    var previous_issue_date=$('#previous_issue_date').val();
    var previous_due_date=$('#previous_due_date').val();
    var previous_ncb_discount=$('#previous_ncb_discount').val();
    var claim_taken=$('input[name=previous_claim_taken]:checked').length;
    $('.error').html("");
    if(ins_company==''){
        $('#ins_company_error').html("Please Select Insurance Company");
            error_flag=true;
    }
    if($.trim(previous_policy_no)==''){
        $('#previous_policy_no_error').html("Please enter Policy No.");
            error_flag=true;
    }
    if(previous_issue_date==''){
        $('#previous_issue_date_error').html("Please Select Inception Date");
            error_flag=true;
    }
    if(previous_due_date==''){
        $('#previous_due_date_error').html("Please Select Due Date");
            error_flag=true;
    }
    
    if(claim_taken<=0){
        $('#previous_claim_taken_error').html("Please Select Claim Taken");
            error_flag=true;
    }
    if((previous_ncb_discount=='') && (claim_taken=='2')){
        $('#previous_ncb_discount_error').html("Please enter NCB Discount");
            error_flag=true;
    }
    var d=new Date(previous_issue_date.split("-").reverse().join("-"));
    var d1=new Date(previous_due_date.split("-").reverse().join("-"));
    if(previous_due_date!=''){
     var dtdue=previous_due_date.split("-");
        var fdtdueDate=dtdue[2]+'/'+dtdue[1]+'/'+dtdue[0];
    }
    if(previous_issue_date!=''){
     var dtissue=previous_issue_date.split("-");
        var fdtissueDate=dtissue[2]+'/'+dtissue[1]+'/'+dtissue[0];
    }
    if((previous_due_date!='' && previous_issue_date!='') && (fdtdueDate!='' && fdtissueDate!='') && (fdtdueDate < fdtissueDate))
    {
      $('#previous_issue_date_error').html("Please Select Issue Date less than Due Date");
            error_flag=true;  
    }
    if((previous_due_date!='' && previous_issue_date!='') && (fdtdueDate!='' && fdtissueDate!='') && (fdtdueDate == fdtissueDate))
    {
      $('#previous_issue_date_error').html("Issue Date and Due Date cannot be same");
            error_flag=true;  
    }
    return error_flag;
    }
    
   function validateForm5(){
      error_flag=false;
    var ins_company=$('#ins_company').val();
    var policy_no=$('#policy_no').val();
    var issue_date=$('#issue_date').val();
    var inception_date=$('#inception_date').val();
    var policy_type=$('input[name=policy_type] option:selected').val();
    var due_date=$('#due_date').val();
    var ncb_discount=$('#ncb_discount').val();
    var ins_duration=$('#ins_duration').val();
    //var policy_issued=$('input[name=policy_issued]:checked').val;
    var policy_issued=$("input[name='policy_issued']:checked").val();
    var covernote_no=$('#covernote_no').val();
    var loan_taken = $("input[name='loan_taken']:checked"). val();
    var idv=$('#idv').val();
    var hp_to=$('#hp_to').val();
    var premium=$('input[name="premium"]').val();
    $('.error').html("");
    if(ins_company==''){
        $('#ins_company_error').html("Please Select Insurance Company");
            error_flag=true;
    }
    if(policy_type <= 0){
        $('#policy_type_error').html("Please Select Policy Type");
            error_flag=true;
    }
    
    if(issue_date==''){
        $('#issue_date_error').html("Please Select Issue Date");
            error_flag=true;
    }
    if(inception_date==''){
        $('#inception_date_error').html("Please Select Inception Date");
            error_flag=true;
    }
    if(due_date==''){
        $('#due_date_error').html("Please Select Due Date");
            error_flag=true;
    }
    
    /*if(ncb_discount==''){
        $('#ncb_discount_error').html("Please enter NCB Discount");
            error_flag=true;
    }*/
    if(ncb_discount!=''){
        ncb_discount=ncb_discount.replace(/%/g, '');
        if(ncb_discount > 100){
        $('#ncb_discount_error').html("Please enter Valid NCB Discount");
            error_flag=true;
        }
    }
    if(ins_duration==''){
        $('#ins_duration_error').html("Please Select Insurance Duration");
            error_flag=true;
    }
    if(issue_date!=''){
        var dtissue=issue_date.split("-");
        var fissueDate=dtissue[2]+'/'+dtissue[1]+'/'+dtissue[0];
    }
    if(due_date!=''){
        var dtdue=due_date.split("-");
        var fdtdueDate=dtdue[2]+'/'+dtdue[1]+'/'+dtdue[0];
    }
   
    if(fissueDate > fdtdueDate){
       $('#issue_date_error').html("Please enter Issue Date less than Due Date");
       error_flag=true; 
    }
    if(policy_issued=='1'){
       if(policy_no==''){
        $('#policy_no_error').html("Please enter Policy No.");
            error_flag=true;
        } 
    }
    if(policy_issued=='2'){
       if($.trim(covernote_no)==''){
        $('#covernote_no_error').html("Please enter Covernote No.");
            error_flag=true;
        } 
    }
    if(policy_type != 2){
    if(idv==''){
        $('#idv_error').html("Please enter IDV");
            error_flag=true;
        }
    }
    if(premium==''){
        $('#premium_error').html("Please enter Total Premium");
            error_flag=true;
        }    
    if(loan_taken=='1'){
        if(hp_to==''){
          $('#err_hp_to').html("Please select HP To");
            error_flag=true;  
        }
    }
    return error_flag;
    }
    
    function validateForm6(){
      error_flag=false;
    var idv=$('#idv').val();
    var od_amt=$('#od_amt').val();
    var ncb=$('#ncb').val();
    var premium=$('input[name="premium"]').val();
    var accessories=$('#accessories').val();
    $('.error').html("");
    if(idv==''){
        $('#idv_error').html("Please enter IDV");
            error_flag=true;
    }
    if(od_amt==''){
        $('#od_amt_error').html("Please enter OD Amt");
            error_flag=true;
    }
    if(ncb ==''){
        $('#ncb_error').html("Please enter NCB Amt");
            error_flag=true;
    }
    if(premium==''){
        $('#premium_error').html("Please enter Premium");
            error_flag=true;
    }
    if(premium!=''){
        var premiumnew=premium.replace(",","");
        if(premiumnew <=0){
        $('#premium_error').html("Please enter valid Premium");
            error_flag=true;
        }    
    }
    if(accessories==''){
        $('#accessories_error').html("Please enter Accessories");
            error_flag=true;
    }
    
    if(ncb==''){
        $('#ncb_error').html("Please enter NCB Discount");
            error_flag=true;
    }
    
    return error_flag;
    }
    
    function validateForm8(){
        // alert(1);
      error_flag=false;
    var payment_mode=$('#payment_mode').val(); 
    var in_payment_mode=$('#in_payment_mode').val();
    var payment_by=$('input[name=payment_by]:checked').length;
    var payment_by_val=$('input[name=payment_by]:checked').val();
    var pay_reason=$('#pay_reason').val();
    var payment_date=$('#payment_date').val();
    var policy_amt=$('#policy_amt').val();
    var in_policy_amt=$('#in_policy_amt').val();
    var cheque_favour=$('#cheque_favour').val();
    var cheque_no=$('#cheque_no').val();
    var bank_name=$('#bank_name').val();
    var transaction_no=$('#transaction_no').val();
    var in_payment_date=$('#in_payment_date').val();
    var in_payment_mode=$('#in_payment_mode').val();
    var in_cheque_favour=$('#in_cheque_favour').val();
    var in_cheque_no=$('#in_cheque_no').val();
    var in_bank_name=$('#in_bank_name').val();
    var in_transaction_no=$('#in_transaction_no').val();
    var cpayment_by_val=$('input[name=cpayment_by]:checked').val();
    var cpayment_mode=$('#cpayment_mode').val();
    $('.error').html("");
    if(cpayment_by_val ==null && payment_by <= 0){
       $('#payment_by_error').html("Please Select Payment By");
       error_flag=true;
    }
    purchaseamt = parseInt($('#purchaseamt').text().replace(/,/g, ''));
    amtPaid = parseInt($('#amtPaid').text().replace(/,/g, ''));
    leftPaid = parseInt($('#leftPaid').text().replace(/,/g, ''));
    amtleft = purchaseamt - (amtPaid+leftPaid);
    partpaymentid = $('#partpaymentid').val();
    var subclear = $('#subclear').val();
    var customer_id = $('#customer_id').val();
    var pricepay = 0;
    var pricespay = 0;
     if(cpayment_by_val ==null && payment_by_val > 0){
     if(partpaymentid > 0){
       // alert(pricepay);
         $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/getTotalPay",
                  data : {id:partpaymentid,customer_id:customer_id},
                  dataType: 'json',
                  async: false,
                  success: function (responseData) 
                  { 
                    //alert(responseData);
                     pricepay = responseData;
                  }
            });
     }
     }
    
     else if(cpayment_by_val>=1)
     {
        if(partpaymentid > 0){
         $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/getTotalPay",
                  data : {id:partpaymentid,customer_id:customer_id,flag:1},
                  dataType: 'json',
                  async: false,
                  success: function (responseData) 
                  { 
                    //alert(responseData);
                     pricespay = responseData;
                  }
            });
     }

     }
     //error_flag=true;
    if(partpaymentid == '' || partpaymentid == null || partpaymentid == 'undefined'){
        if(payment_by_val==1){
            if(payment_mode == 0 || payment_mode == '' || payment_mode == null || payment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            var payment_date = $("#payment_date").val();
            if (payment_date == '') {
                $('#payment_date_error').html("Please Select Payment Date");
                error_flag = true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
            
            if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
               
            policy_amt = policy_amt.replace(/,/g, '');
            if( amtleft < policy_amt ){
                $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
             
        }
        // alert(payment_by_val+"--"+payment_mode);
        if(payment_by_val==2){
            if(in_payment_mode == 0 || in_payment_mode == '' || in_payment_mode == null || in_payment_mode == 'undefined'){
               $('#in_payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            var payment_date = $("#in_payment_date").val();
            if (payment_date == '') {
                $('#in_payment_date_error').html("Please Select Payment Date");
                error_flag = true;
            }
            policy_amt = ($('#in_policy_amt').val() != '' || $('#in_policy_amt').val() != null || $('#in_policy_amt').val() != 'undefined' )? $('#in_policy_amt').val() : ''  ;            
           if(policy_amt=='')
            {
                 $('#in_policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt = policy_amt.replace(/,/g, '');
            if( amtleft < policy_amt ){
               $('#in_policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
        }
        if(payment_by_val==3){
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            var payment_date = $("#payment_date").val();
            if (payment_date == '') {
                $('#payment_date_error').html("Please Select Payment Date");
                error_flag = true;
            }
            if(payment_mode == 0 || payment_mode == '' || payment_mode == null || payment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
            if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
            }
            policy_amt = policy_amt.replace(/,/g, '');
            if( amtleft < policy_amt ){
               $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
             
        }
    }
    if(partpaymentid == '' || partpaymentid == null || partpaymentid == 'undefined'){
         //policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;

           //  alert(cpayment_by_val);return false;
        if(cpayment_by_val==1){
            if(cpayment_mode == 0 || cpayment_mode == '' || cpayment_mode == null || cpayment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
          if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt = policy_amt.replace(/,/g, '');
    // console.log(policy_amt);
            if( parseInt(subclear) < parseInt(policy_amt) ){
                $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
             
        }
        // alert(payment_by_val+"--"+payment_mode);
 
        if(cpayment_by_val==3){
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            if(cpayment_mode == 0 || cpayment_mode == '' || cpayment_mode == null || cpayment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
           if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt = policy_amt.replace(/,/g, '');
             policy_amt_h = ($('#policy_amt_h').val() != '' || $('#policy_amt_h').val() != null || $('#policy_amt_h').val() != 'undefined' )? $('#policy_amt_h').val() : '' ;
            policy_amt_h = policy_amt.replace(/,/g, '');
            var amtleftn = parseInt(subclear)+parseInt(policy_amt_h);
            if( parseInt(subclear) < parseInt(policy_amt) ){
                $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
        }
    }
    else
    {
        if(payment_by_val==1){
            if(payment_mode == 0 || payment_mode == '' || payment_mode == null || payment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
           if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt_h = ($('#policy_amt_h').val() != '' || $('#policy_amt_h').val() != null || $('#policy_amt_h').val() != 'undefined' )? $('#policy_amt_h').val() : '' ;
            policy_amt = policy_amt.replace(/,/g, '');
            policy_amt_h = policy_amt.replace(/,/g, '');
            var amtleftn = parseInt(purchaseamt)-parseInt(pricepay);
            if(amtleftn < policy_amt){
                $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
             
        }
        // alert(payment_by_val+"--"+payment_mode);
        if(payment_by_val==2){
            if(in_payment_mode == 0 || in_payment_mode == '' || in_payment_mode == null || in_payment_mode == 'undefined'){
               $('#in_payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            policy_amt = ($('#in_policy_amt').val() != '' || $('#in_policy_amt').val() != null || $('#in_policy_amt').val() != 'undefined' )? $('#in_policy_amt').val() : ''  ;            
            if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt = policy_amt.replace(/,/g, '');
            in_policy_amt_h = ($('#in_policy_amt_h').val() != '' || $('#in_policy_amt_h').val() != null || $('#in_policy_amt_h').val() != 'undefined' )? $('#in_policy_amt_h').val() : '' ;
            //var amtleftn = parseInt(amtleft)+parseInt(in_policy_amt_h);
            //alert(amtleftn);
            var amtleftn = parseInt(purchaseamt)-parseInt(pricepay);
            if(amtleftn < policy_amt){
            //if( amtleft < policy_amt ){
               $('#in_policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
        }
        if(payment_by_val==3){
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            if(payment_mode == 0 || payment_mode == '' || payment_mode == null || payment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
           if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt_h = ($('#policy_amt_h').val() != '' || $('#policy_amt_h').val() != null || $('#policy_amt_h').val() != 'undefined' )? $('#policy_amt_h').val() : '' ;
            policy_amt = policy_amt.replace(/,/g, '');
            policy_amt_h = policy_amt.replace(/,/g, '');
            var amtleftn = parseInt(purchaseamt)-parseInt(pricepay);
            //var amtleftn = parseInt(amtleft)+parseInt(policy_amt_h);
            if(amtleftn < policy_amt){
               $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
             
        }
        if(cpayment_by_val==1){
            if(cpayment_mode == 0 || cpayment_mode == '' || cpayment_mode == null || cpayment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
           if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt = policy_amt.replace(/,/g, '');
             policy_amt_h = ($('#policy_amt_h').val() != '' || $('#policy_amt_h').val() != null || $('#policy_amt_h').val() != 'undefined' )? $('#policy_amt_h').val() : '' ;
           //policy_amt = policy_amt.replace(/,/g, '');
            policy_amt_h = policy_amt.replace(/,/g, '');
           // var amtleftn = parseInt(purchaseamt)-parseInt(pricepay);
            var amtleftn = parseInt(subclear)+parseInt(policy_amt_h);
    // console.log(policy_amt);
            if( pricespay < policy_amt ){
                $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
             
        }
        // alert(payment_by_val+"--"+payment_mode);
 
        if(cpayment_by_val==3){
            if (pay_reason == '') {
                $('#pay_reason_error').html("Please Select Payment Reason");
                error_flag = true;
            }
            if(cpayment_mode == 0 || cpayment_mode == '' || cpayment_mode == null || cpayment_mode == 'undefined'){
               $('#payment_mode_error').html('Payment mode is required');
               error_flag=true;
            }
            policy_amt = ($('#policy_amt').val() != '' || $('#policy_amt').val() != null || $('#policy_amt').val() != 'undefined' )? $('#policy_amt').val() : '' ;
            if(policy_amt=='')
            {
                 $('#policy_amt_error').html('Amount is required');
                  error_flag=true;
                }
            policy_amt = policy_amt.replace(/,/g, '');
             policy_amt_h = ($('#policy_amt_h').val() != '' || $('#policy_amt_h').val() != null || $('#policy_amt_h').val() != 'undefined' )? $('#policy_amt_h').val() : '' ;
            policy_amt_h = policy_amt.replace(/,/g, '');
            var amtleftn = parseInt(subclear)+parseInt(policy_amt_h);
            //var amtleftn = parseInt(purchaseamt)-parseInt(pricepay);
            if( pricespay < policy_amt ){
                $('#policy_amt_error').html('Amount exceeds against the required amount');
               error_flag=true;
            }
        }
    }
  


    if((in_payment_mode==1) && (payment_by_val=='2')){
        if(pay_reason==''){
          $('#pay_reason_error').html("Please Select Payment Reason");
            error_flag=true;  
        }
        if(in_payment_date==''){
        $('#in_payment_date_error').html("Please Select Payment Date");
            error_flag=true;
        }
        if(in_policy_amt==''){
          $('#in_policy_amt_error').html("Please enter Amount Drawn");
            error_flag=true;  
        }
    }
    if((in_payment_mode==2) && (payment_by_val=='2')){
       if(pay_reason==''){
          $('#pay_reason_error').html("Please Select Payment Reason");
            error_flag=true;  
        } 
       if(in_payment_date==''){
        $('#in_payment_date_error').html("Please Select Payment Date");
            error_flag=true;
        }
        if(in_policy_amt==''){
          $('#in_policy_amt_error').html("Please enter Amount Drawn");
            error_flag=true;  
        }
    }
    
    if((payment_mode==1) && ((payment_by_val=='1') || (payment_by_val=='3'))){
             if(payment_mode==''){
         $('#payment_mode_error').html("Please Select Payment Mode");
            error_flag=true;   
        }
        if(payment_date==''){
        $('#payment_date_error').html("Please Select Payment Date");
            error_flag=true;
        }
        if(policy_amt==''){
          $('#policy_amt_error').html("Please enter Amount Drawn");
            error_flag=true;  
        }
        
    }
    if((payment_mode==2) && ((payment_by_val=='1') || (payment_by_val=='3'))){
       if(payment_mode==''){
         $('#payment_mode_error').html("Please Select Payment Mode");
            error_flag=true;   
        } 
       if(payment_date==''){
        $('#payment_date_error').html("Please Select Payment Date");
            error_flag=true;
        }
        if(policy_amt==''){
          $('#policy_amt_error').html("Please enter Amount Drawn");
            error_flag=true;  
        }
        
    }
    if((payment_mode==3) && ((payment_by_val=='1') || (payment_by_val=='3'))){
        if(payment_mode==''){
         $('#payment_mode_error').html("Please Select Payment Mode");
            error_flag=true;   
        }
       if(payment_date==''){
        $('#payment_date_error').html("Please Select Payment Date");
            error_flag=true;
        }
        if(policy_amt==''){
          $('#policy_amt_error').html("Please enter Amount Drawn");
            error_flag=true;  
        }
               
    }

    if((cpayment_by_val=='1') || (cpayment_by_val=='3')){
        if(cpayment_mode==''){
         $('#payment_mode_error').html("Please Select Payment Mode");
            error_flag=true;   
        }
        if(payment_date==''){
        $('#cpayment_date_error').html("Please Select Payment Date");
            error_flag=true;
        }
        if(policy_amt==''){
          $('#cpolicy_amt_error').html("Please enter Amount Drawn");
            error_flag=true;  
        }
        
    }
    
    return error_flag;
    }


function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
