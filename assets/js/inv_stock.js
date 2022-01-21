$('#saveContCaseInfo').click(function()
{
    var formData=$('#caseinfo').serialize();
    var err = usedCarCaseInfo();
    //return false;
    if(err)
    {
        $('.error').attr('style','display:block');
        return false;
    }
    saveUsedCarPurchase(formData);
});

$('#saveSeller').click(function()
{
    var formData=$('#sellinfo').serialize();
    var err = usedCarSellInfo();
    if(err)
    {
        $('.error').attr('style','display:block');
        return err;
    }
    saveUsedCarPurchase(formData);
});

$('#savePay').click(function()
{
    //alert('hiii');
    var formData=$('#paymentinfo').serialize();
    var err = usedCarPayInfo();
    if(err)
    {
        $('.error').attr('style','display:block');
        return err;
    }
    saveUsedCarPurchase(formData);
});

$('#saveRefurb').click(function()
{
    var formData=$('#refurbinfo').serialize();
    var err = usedCarRefurbInfo();
    if(err)
    {
        $('.error').attr('style','display:block');
        return err;
    }
    saveUsedCarPurchase(formData);
});
function saveUsedCarPurchase(formData)
{
	$.ajax({
        type: "POST",
        url: base_url + "UsedcarPurchase/saveUpdateStockData",
        data: formData,
        //dataType: 'json',
        success: function (response) {
           // alert(response);
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == 'True') {
                snakbarAlert(data.message);
                $('.loaderClas').attr('style','display:block;');                 
                setTimeout(function () {
                    window.location.href =data.Action;
                }, 2500);

                return true;
            } else {
                snakbarAlert(data.message);
                return false;
            }
        }
    });
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

$('#Cmobile,#Cname,#CEmail,#loan_amt,#roi,#tenor,#ref_phone_one,#ref_phone_two,#ref_name_two,#ref_name_one,#length_of_stay,#residence_pincode,#residence_phone').bind("cut copy paste",function(e) {
     e.preventDefault();
 });
 function blockSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    //alert(k);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 44 && k <= 57));
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
function blockAllSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    alert(k);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k >= 44 && k <= 57));
}
function addCommased(nStr,control,flag='')
{
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