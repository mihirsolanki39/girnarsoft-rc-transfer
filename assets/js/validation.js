var alliswell = false;
dealerMobile  = true;
ownerMobile   = true;
dealerEmail   = true;

function checkDealer(form)
{
    $("#submit").attr("disabled",true);
    $('.error').html('');
    var err = 0;
    var name_field = $.trim($('#organization').val());
    //alert(name_field);
    var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var services=$("#services").val();
    var outlet_address=$("#outlet_address").val();
    var city=$("#city").val();
    var state=$("#state").val();
    var owner_name=$("#owner_name").val();
    var owner_contact_number=$("#owner_contact_number").val();
    var payment_favoring=$("#payment_favoring").val();
    var gst_number=$("#gst_number").val();
    var assignUser = $('#assignUser').val();
    var inneralliswell = true;
    var dealer_type = $.trim($('#dealer_type').val());
    var account_number = $.trim($('#account_number').val());
    var dealer_banks   = $.trim($('#dealer_banks').val());
    var ifsc_code      = $.trim($('#ifsc_code').val());
    
   /* if(ifsc_code==''){

        if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000);}
        $('#ifsc_code_error').text('Please Enter Ifsc Code');
        inneralliswell = false;
        err++;
    } else if (ifsc_code != "" && !(/[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/.test(ifsc_code))) {
         if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000);}
        $('#ifsc_code_error').text('Ifsc code should be in proper');
        inneralliswell = false;
        err++;
    }
    if(dealer_banks==''){
         if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000);}
        $('#dealer_banks_error').text('Please Select Bank');
        inneralliswell = false;
        err++;
    }
    if(account_number==''){
         if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000); }
        $('#account_number_error').text('Please Enter Account Number');
        inneralliswell = false;
        err++;
    }*/
    if ((name_field) == "" || (name_field) == "Enter Name") {
        $('#name_error').text('Please Enter Dealership Name');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    } else if (($('#organization').val()) != "" && !(/^[a-zA-Z0-9 &-/() ]*$/.test($('#organization').val())) ) {
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        $('#name_error').text('Dealership Name Must Only Contain Letters');
        inneralliswell = false;
    } else if (name_field.length < 3) {
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        $('#name_error').text('Dealership Name must contain atleast 3 characters');
        inneralliswell = false;
    } else
    {
       $('#email_error').text('');
    }
    
    if ($('#dealership_email').val() == "" || $('#dealership_email').val() == "Enter Email") {
        $('#email_error').text('Please Enter Your Email Address');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    } else if (($('#dealership_email').val()) != "" && (!(regEmail.test($('#dealership_email').val())))) {
        $('#email_error').text('Please Enter A Valid Email Address');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    }
    else
    {
      //   $('#email_error').text('');
    }

    if ($('#dealership_contact_number').val() == "" || $('#dealership_contact_number').val() == "Enter Mobile No.") {
        $('#phone_error').text('Please Enter  Mobile Number');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    } else if ($('#dealership_contact_number').val() != "" && !(/^[6-9]{1}[0-9]{9}$/.test($('#dealership_contact_number').val()))) {
        $('#phone_error').text('Please Enter Valid Mobile Number');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    } 
//    else
//    {
//        $('#phone_error').text('');
//    }

    if((services=="" || services == null) && (dealer_type!='1')){
        $('#services_error').text('Please Select Services');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    }else{
        $('#services_error').text('');
    }
    if(outlet_address==""){
        $('#outlet_address_error').text('Please Enter Outlet Address');
        if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
        }
        inneralliswell = false;
        err++;
    }else if (outlet_address != "" && !(/^[a-zA-Z0-9 &-/() ]*$/.test(outlet_address))) {
        $('#outlet_address_error').text('Please Enter Valid Outlet Address');
        $('html, body').animate({scrollTop: $("#gototop").offset().top}, 2000);
        inneralliswell = false;
    }
    else{
        $('#outlet_address_error').text('');
    }
    if(state==""){
        $('#state_error').text('Please Enter State');
        if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
     err++;
        inneralliswell = false;
    }else{
        $('#state_error').text('');
    }
    if(city==""){
        $('#city_error').text('Please Enter City');
        if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
     err++;
        inneralliswell = false;
    }else{
        $('#city_error').text('');
    }
   
    if ((owner_name) == "" || (owner_name) == "Enter Name") {
        $('#owner_name_error').text('Please Enter Owner Name');
        if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
     err++;
        inneralliswell = false;
    } else if ((owner_name) != "" && !(/^[a-zA-Z ]{2,30}$/.test(owner_name))) {
        $('#owner_name_error').text('Owner Name Must Only Contain Letters');
         if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
     err++;
        inneralliswell = false;
    } else if (owner_name.length < 3) {
        $('#owner_name_error').text('Owner Name must contain atleast 3 characters');
        if(inneralliswell!=false){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
        inneralliswell = false;
    } else
    {
        $('#owner_name_error').text('');
    }
    
    if ($('#owner_contact_number').val() == "" || $('#owner_contact_number').val() == "Enter Mobile No.") {
        $('#owner_mobile_error').text('Please Enter Owner  Mobile Number');
         if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
     err++;
        inneralliswell = false;
    } else if ($('#owner_contact_number').val() != "" && !(/^[6-9]{1}[0-9]{9}$/.test($('#owner_contact_number').val()))) {
        $('#owner_mobile_error').text('Please Enter Valid Mobile Number');
         if(err==0){
         $('html, body').animate({scrollTop: $("#outlettop").offset().top}, 2000);
     }
     err++;
        inneralliswell = false;
    }
    else
    {
        
    }
    if((assignUser=="") && (dealer_type!='1')){
        $('#assign_error').text('Please Assign User');
         if(err==0){
        $('html, body').animate({scrollTop: $("#salestop").offset().top}, 2000);
    }
    err++;
        inneralliswell = false;
    }else{
        $('#assign_error').text('');
    }
   /* if(payment_favoring==""){
        if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000);
         }
         err++;
        $('#payment_favoring_error').text('Please Enter Payment Favouring');
        inneralliswell = false;
    }else{
        $('#payment_favoring_error').text('');
    }
    if(gst_number==""){
         if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000);}
        $('#gst_number_error').text('Please Enter GST Number');
        inneralliswell = false;
        err++;
    }
     if(gst_number.length!=15){
        if(err==0){
         $('html, body').animate({scrollTop: $("#paymenttop").offset().top}, 2000);}
        $('#gst_number_error').text('Please Enter Valid GST Number');
        err++;
        inneralliswell = false;
    }else{
        $('#gst_number_error').text('');
    } */
   // alert(err);
//    console.log(inneralliswell);
//    console.log(dealerMobile);
    if (inneralliswell && dealerMobile && ownerMobile && dealerEmail)
    {
           $("#submit").attr("disabled",false);
        alliswell = true;
        return true;
        
        
    } else
    {
         setTimeout(function(){  $("#submit").attr("disabled",false);  }, 3000);    
     
        alliswell = false;
        return false;
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function nameOnly(event)
         {
           var inputValue = event.which;
           //alert(inputValue);
            if(!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) { 
                event.preventDefault(); 
                 return false;
            }
           // console.log(inputValue);
         }


$(function () {
    $('.multiselect-ui').multiselect({
        includeSelectAllOption: true
    });
});
$("#dealership_contact_number").keyup(function () {
    if ($('#dealership_contact_number').val().length == '10') {
        var mobile = $('#dealership_contact_number').val();
        var updateId = $('#updateId').val();
        $('#phone_error').text('');
        $.ajax({
            type: "POST",
            url: base_url+"Dealer/checkMobile",
            data: {mobile: mobile, updateId: updateId},
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.status == 'false') {
                    $('#phone_error').text('');
                    dealerMobile = true;
                    return true;
                } else {
                    $('#phone_error').text('Mobile Number Already Taken');
                    dealerMobile = false;
                    return false;
                }
            }
        });
    }
});
$("#owner_contact_number").keyup(function () {
if ($('#owner_contact_number').val().length == '10') {
var mobile = $('#owner_contact_number').val();
        $('#owner_mobile_error').text('');
        var updateId = $('#updateId').val();
        $.ajax({
            type: "POST",
            url: base_url+"Dealer/checkOwnerMobile",
            data: {mobile: mobile,updateId:updateId},
            success: function (response) {
                var data = $.parseJSON(response);
                 if (data.status == 'false') {
                    $('#owner_mobile_error').text('');
                    ownerMobile = true;
                    return true;
                } else {
                 $('#owner_mobile_error').text('Number Already Taken');
                 ownerMobile = false;
                 return false;
                }
            }
        });
            }
        });
        
$('#dealership_email').blur(function () {
    var updateId = $('#updateId').val();
    var email = $('#dealership_email').val();
    $('#email_error').text('');
    $.ajax({
        type: "POST",
        async: true,
        url: base_url+"Dealer/checkEmail",
        data: {email: email, updateId: updateId},
        success: function (response) {
            var data = $.parseJSON(response);
            if (data.status == 'false') {
                dealerEmail = true;
                $('#email_error').text('');
                return true;
            } else {
                $('#email_error').text('Email Already Taken');
                dealerEmail = false;
                return false;
            }
        }
    });
});

function ValidateRole(form){
    errorflag = true;
    var team=$("#teamName").val();
    var role = $.trim($('#role_name').val());
    if(team==""){
        $('#teamName_error').text('Please Enter Team Name');
        errorflag = false;
    }else{
        $('#teamName_error').text('');
    }
    
    if(role==""){
        $('#roleName_error').text('Please Enter Role Name');
        errorflag = false;
    }else{
        $('#roleName_error').text('');
    }
    if (errorflag)
    {
        errorflag = true;
        return true;
    } else
    {
        errorflag = false;
        return false;
    }
}

function validateTeam(form){
    errorflag = true;
    var team=$("#team_name").val();
    if(team==""){
        $('#teamName_error').text('Please Enter Team Name');
        errorflag = false;
    }else{
        $('#teamName_error').text('');
    }
    
    
    if (errorflag)
    {
        errorflag = true;
        return true;
    } else
    {
        errorflag = false;
        return false;
    }
}

function ValidateDocument(form){
    errorflag = true;
    var doc_rc_copy=$("#doc_rc_copy").val();
    var doc_rc_copy_2 = $.trim($('#doc_rc_copy_2').val());
    var doc_form_29 = $.trim($('#doc_form_29').val());
    var doc_form_30_image1 = $.trim($('#doc_form_30_image1').val());
    var doc_form_30_image2 = $.trim($('#doc_form_30_image2').val());
    if(doc_rc_copy==""){
        $('#doc_rc_copy_error').text('Please Upload RC Copy');
        errorflag = false;
    }else{
        $('#doc_rc_copy_error').text('');
    }
    
    if(doc_rc_copy_2==""){
        $('#doc_rc_copy_2_error').text('Please Upload RC Copy 2');
        errorflag = false;
    }else{
        $('#doc_rc_copy_2_error').text('');
    }
    
    if(doc_form_29==""){
        $('#doc_form_29_error').text('Please Upload Form 29');
        errorflag = false;
    }else{
        $('#doc_form_29_error').text('');
    }
    
    if(doc_form_30_image1==""){
        $('#doc_form_30_image1_error').text('Please Upload Form 30');
        errorflag = false;
    }else{
        $('#doc_form_30_image1_error').text('');
    }
    
    if(doc_form_30_image2==""){
        $('#doc_form_30_image2_error').text('Please Upload Form 30 Image 2');
        errorflag = false;
    }else{
        $('#doc_form_30_image2_error').text('');
    }
    
    
    if (errorflag)
    {
        errorflag = true;
        return true;
    } else
    {
        errorflag = false;
        return false;
    }
}

$(document).ready(function () {
    // $("#assignUser").select2();
    
    $('#account_number').keypress(function (event) {
        var keyCode = event.keyCode ? event.keyCode : event.charCode;
        if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
            return false;
    });
});
function blockSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
function alphaOnly(evt) {
       evt = (evt) ? evt : event;
       var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
          ((evt.which) ? evt.which : 0));
       if (charCode > 31 && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122)) {
           return false;
       }
       return true;
     }
 