$(document).ready(function (ev) {
     $('#btnform1').click(function () {
        var formData=$('#caseform').serialize();
        var flag=validateForm1();
         if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#saveTrnsForm').click(function () {
        
        var formData=$('#trnxForm').serialize();
        var flag=validateUsedCarSalesFrom('trnxForm');
       
        //var flag=false;
         if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#saveBookingForm').click(function () {
        
        var formData=$('#bookingForm').serialize();
         var flag=validateUsedCarSalesFrom('bookingForm');
         
        //var flag=validateTranxFrom();
         if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#savePaymentForm').click(function () {
        var formData=$('#paymentForm').serialize();
        var flag=validateUsedCarSalesFrom('paymentForm');
         if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#saveDeliveryForm').click(function () {
       
        var formData=$('#deliveryForm').serialize();
        var flag=validateUsedCarSalesFrom('deliveryForm');
        //var flag=validateTranxFrom();
         if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#btnform3').click(function () {
        var formData=$('#vehicleform').serialize();
        var flag=validateForm3();
         if(flag==false){
        var rtype = $('#roleType').val();
        var insfrm3= $('#insfrm3').val();
        if(rtype!='admin' && insfrm3==''){
         confirmSave('3');
        } 
        if(insfrm3=='true' || rtype=='admin'){
        saveCaseInfoData(formData);
        }
         }

    });
    $('#btnform4').click(function () {
        var formData=$('#previousform').serialize();
        var flag=validateForm4();
         if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#btnform5').click(function () {
        var formData=$('#policyform').serialize();
        var flag=validateForm5();
       if(flag==false){
        saveCaseInfoData(formData);
         }

    });
    $('#btnform6').click(function () {
        var formData=$('#premiumform').serialize();
        var flag=validateForm6();
         if(flag==false){
         var rtype = $('#roleType').val();
        var insfrm6= $('#insfrm6').val();
        if(rtype!='admin' && insfrm6==''){
         confirmSave('6');
        } 
        if(insfrm6=='true' || rtype=='admin'){
        saveCaseInfoData(formData);
        }
         }

    });
    $('#btnform7').click(function () {
         //var formData=$('#documentform').serialize();
        savelogindoc();

    });
    $('#btnform8').click(function () {
        var formData=$('#paymentform').serialize();
        var flag=validateForm8();
         if(flag==false){
        var rtype = $('#roleType').val();
        var insfrm8= $('#insfrm8').val();
        if(rtype!='admin' && insfrm8==''){
         confirmSave('8');
        } 
        if(insfrm8=='true' || rtype=='admin'){
        saveCaseInfoData(formData);
        }
         }

    });
    
    $('#savefilelogin').click(function () {
        var formData=$('#formQuotes').serialize();
         var flag=validateQuotes();
         if(flag==false){
         saveCaseInfoData(formData);
        }

    });
    $('#btnform10').click(function () {
         var formData=$('#formInspection').serialize();
         var flag=validateInspect();
         if(flag==false){
         saveCaseInfoData(formData);
        }

    });
    function confirmSave(frmid)
    {
    $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/confirmsave",
                  data : {frmId:frmid},
                  dataType: 'html',
                  success: function (responseData) 
                  { 
                    if (responseData) {
                        $('#frmid').val(frmid);
                        jQuery('#insconf').modal('show');
                        return true;
                    } else {
                        return false;
                    } 
                  }
            });
    }
    
    //$('#accessories').on('keyup paste',totPremium);
});


function saveCaseInfoData(formData) {
    $.ajax({
        type: "POST",
        url: base_url + "saveUpdateUsedCarsaleData",
        data: formData,
        //dataType: 'json',
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == true) {
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


  $('.btype').on('click', function (ev) {
      var buyerType=$(ev.currentTarget).val();
      $('#customer_name').val('');
      $('#company_name').val('');
      if(buyerType=='1'){
          $('#divcustomername').show();
          $('#divcompanyname').hide();
        //$('#namechange').text('Name*');
        //$('#customer_name').attr('onkeypress','return nameOnly(event)');
      }else if(buyerType=='2'){
          $('#divcompanyname').show();
          $('#divcustomername').hide();
        //$('#namechange').text('Company Name*');
        //$('#customer_name').attr('onkeypress','return blockSpecialChar(event)');
    } 
  });
  
function validmobileNumber(obj){
     var Number = obj.value;
     if(Number.length==10){
     var IndNum = /^[0]?[6789]\d{9}$/;
     if(IndNum.test(Number)){
        return;
        }else{
        snakbarAlert('please enter valid mobile number');
        return false;
        }
     }

}
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

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
function nameOnly(event){
           var inputValue = event.which;
           //alert(inputValue);
            if(!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) { 
                event.preventDefault(); 
                 return false;
            }
           // console.log(inputValue);
   }     

    function addCommas(nStr,control) 
    { 
        if (nStr) { 
            nStr = nStr.replace(/,/g, ''); 
            nStr += ''; 
            x = nStr.split('.'); 
            x1 = x[0]; 
            x2 = x.length > 1 ? '.' + x[1] : ''; 
            var rgx = /(\d+)(\d{2})/; 
            var len; 
            var x3 = ""; 
            len = x1.length; 
            if (len > 3) { 
                var par1 = len - 3; 

                x3 = "," + x1.substring(par1, len); 
                x1 = x1.substring(0, par1); 

                //alert(x3); 
            } 
            len = x1.length; 
            if (len >= 3 && x3 != "") { 
                while (rgx.test(x1)) { 
                    x1 = x1.replace(rgx, '$1' + ',' + '$2'); 
                } 
            }
            document.getElementById(control).value=x1 +x3+x2;
        } 
    } 
    
    function getUpper(nStr,control){
     var str=nStr.toUpperCase();
     document.getElementById(control).value=str;
    }
    function showpolicyexpired(){
    if($('#ins_category').val()=='4') {
        $('#divexpired').show();
    } else {
        $('#divexpired').hide();
    }
  }
  
  function instrumentTypeValidation(ins_type){
    //alert(ins_type);
   if(ins_type=='cash' || ins_type==''){
       $('.showhide').attr('style','display:none !important');
        $('.shhow').attr('style','display:none !important');
   }
   else if(ins_type=='online')
   {
   //  alert('gggg');
        $('.showhide').attr('style','display:none');
        $('.shhow').attr('style','display:block');
   }
   else{
   // alert('hffff');
       $('.ins-type-woc').show();
       $('.ins-type-woc').find(':input').prop('required',true);
        $('.showhide').attr('style','display:block');
          $('.shhow').attr('style','display:block');
   }
  }
  $('.ins-type').change(function(){
      var val = $(this).val();
      instrumentTypeValidation(val);
  });
  
  instrumentTypeValidation($('.ins-type').val());
  
  
   
  
