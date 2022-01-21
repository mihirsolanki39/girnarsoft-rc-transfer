$(document).ready(function(){
        $('.cstate').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.'  });
        $('.cstate')[0].sumo.reload();
        $('.scity').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
        $('.scity')[0].sumo.reload();
    
    
$('#state').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: "/dealer/getcities",
        data: {stateId: selected},
        dataType: "html",
        success: function (responseData)
        {
            //$('#city').html('');
            $('#city').html(responseData);
            $('#city')[0].sumo.reload();

        }
    });
});
});


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
var alliswell = false;
limit  = true;
function checkBank(form)
{
    //   $('.loaderClas').attr('style','display:block;');
    $("#submit").attr("disabled",true);
    setTimeout(function(){  }, 3000);      
    $('.error').html('');
    var bank_name       = $.trim($('#bank_name').val());
    var branch          = $.trim($('#branch').val());
    var city            = $("#city").val();
    var state           = $("#state").val();
    var ifsc_code       = $.trim($("#ifsc_code").val());
    var pincode         = $.trim($("#pincode").val());
    var address         = $.trim($("#address").val());
    var micr_code       = $.trim($("#micr_code").val());
    
    var amount_limit   = $.trim($('#amount_limit').val());
    var inneralliswell = true;
    if ((bank_name) == "" || (bank_name) == "Enter Name") {
        $('#name_error').text('Please Enter Bank Name');
        inneralliswell = false;
    } 
    else if (($('#bank_name').val()) != "" && !(/^[a-zA-Z ]{2,30}$/.test($('#bank_name').val())))
    {
        $('#name_error').text('Bank Name Must Only Contain Letters');
        inneralliswell = false;
    }
    else
    {
       $('#name_error').text(' ');
    }
    if(address!='')
    {
        if(!/^[a-zA-Z0-9&,-/ ( ) ]{2,200}$/.test(address)){
        //if(/^[a-zA-Z0-9-\)(._ ,- /@=]*$/.test(address) == false) {
            $('#address_error').text('Please Enter Valid Address');
            inneralliswell = false;
        }
        
    }
    
    if(branch=="")
    {
        $('#Branch_error').text('Please Enter Branch Name');
        inneralliswell = false;
    }
    else if(!/^[a-zA-Z0-9 &,-/ ( ) ]{2,200}$/.test(branch)){
        $('#Branch_error').text('Please Enter Valid Branch Name');
        inneralliswell = false;
    }
    else 
    {
        $('#Branch_error').text('');
    }
    
    if(pincode!='')
    {
        if(/^[0-9]*$/.test(pincode) == false) {
            $('#pincode_error').text('Please Enter Valid Pincode');
            inneralliswell = false;
        }
        if(pincode.length != 6){
            $('#pincode_error').text('Please Enter Valid Pincode');
            inneralliswell = false;
        }  
    } 
    
    if(state==""){
        $('#state_error').text('Please Enter State');
        inneralliswell = false;
    }else{
        $('#state_error').text('');
    }
    if(city==""){
        $('#city_error').text('Please Enter City');
        inneralliswell = false;
    }else{
        $('#city_error').text('');
    }
//    if(ifsc_code==""){
//       // alert('dddd');
//        $('#ifsc_error').text('Please Enter IFSC Code');
//        inneralliswell = false;
//    }
//    if((ifsc_code!="") && (ifsc_code.length!="11") && (/^[a-zA-Z0-9- ]*$/.test(ifsc_code) == false)){
//        $('#ifsc_error').text('Please Enter valid IFSC Code');
//        inneralliswell = false;
//    }
//    if(micr_code==""){
//       // alert('dddd');
//        $('#micr_error').text('Please Enter MICR Code');
//        inneralliswell = false;
//    }
    if(amount_limit=="")
    {
        $('#limit_error').text('Please Enter Amount Limit');
        inneralliswell = false;
    }
    if((amount_limit!='') && (amount_limit.replace(/,/g,'').length>=10))
    {
       // alert("sfs");
        $('#limit_error').text('Please Enter valid Amount Limit');

        inneralliswell = false;
    }
    validate_amount_limits(amount_limit);
       $('.loaderClas').attr('style','display:block;');
    var updateId = $("#updateId").val();
    if(updateId == undefined)
        updateId = "";
    $.ajax({
        type: "POST",
        url: "/bank/checkDuplicateBank",
        data: {bank_name: bank_name,updateId:updateId},
        async:false,
        success: function (response) {
            var data = $.parseJSON(response);
            if (data.status == 0) {
              $('.loaderClas').attr('style','display:none;');
              $('#name_error').text('Bank Name already exist');
              inneralliswell = false;
            } 
        }
    });
    if (inneralliswell && limit) 
    {
        $("#submit").attr("disabled",false)
        alliswell = true;
        snakbarAlert("Data saved Successfully");
        setTimeout(function () {
        return true;
        },3500);
    } else
    {
           $('.loaderClas').attr('style','display:none;');
        setTimeout(function(){  $("#submit").attr("disabled",false); }, 3000);      
        alliswell = false;
        return false;
    }
}
 function validate_amount_limits(amount_limits){
          // alert('hii');
        var amount_limit = amount_limits.replace(/,/g,'');

        var updateId = $('#updateId').val();
        var bankId = $('#bank_id').val();
        var definedLimit = $('#definedLimit').val();       
        $.ajax({
            type: "POST",
            url: "http://dealercrm.com/girnarsoft-dealer-crm/bank/ajax_validate_limit",
            data: {limit: amount_limit,definedLimit:definedLimit, updateId: updateId,bankId:bankId},
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.status == 'false') {
                     $('#limit_error').text('');
                    $('#limit_error').text(data.msg);
                    limit = false;
                    return false;
                } else {
                    limit = true;
                    return true;
                }
            }
        });
}
function blockSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    if(k == 32)
        return false;
    return (((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57)));
}
$('#micr_code,#ifsc_code,#amount_limit').bind("cut copy paste",function(e) {
     e.preventDefault();
 });


$(document).ready(function () {
    $("#bank_name").select2();
});

function addCommasBank(nStr,control,flag='')
{
 // alert(nStr);
 if(flag==''){
    nStr=nStr.replace(/,/g,''); 
}else
{
    nStr=nStr; 
}
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