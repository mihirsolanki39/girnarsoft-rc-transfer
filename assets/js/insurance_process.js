$(document).ready(function (ev) {
    showpolicyexpired();
     $('#btnform1').click(function () {
        $("#btnform1").attr("disabled",true);
        var formData=$('#caseform').serialize();
        var flag=validateForm1();
         if(flag==false){
             saveCaseInfoData(formData);
         }        
       setTimeout(function () {
         $("#btnform1").attr("disabled",false);
       }, 2500);
    });
    $('#btnform2').click(function () {
         $("#btnform2").attr("disabled", true);
        var formData=$('#personalform').serialize();
        var flag=validateForm2();
         if(flag==false){
        saveCaseInfoData(formData);
         }
        setTimeout(function () {
            $("#btnform2").attr("disabled", false);
        }, 2500);

    });
    $('#btnform3').click(function () {
        $("#btnform3").attr("disabled", true);
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
        setTimeout(function () {
            $("#btnform3").attr("disabled", false);
        }, 2500);

    });
    $('#btnform4').click(function () {
        $("#btnform4").attr("disabled", true);
        var formData=$('#previousform').serialize();
        var flag=validateForm4();
         if(flag==false){
         saveCaseInfoData(formData);
         
         }
        setTimeout(function () {
            $("#btnform4").attr("disabled", false);
        }, 2500);
    });

    function fillForm()
    {
        $('#saveCardetail').addClass(' in');
        $('#saveCardetail').attr('style','display:block;');
    }

    $('.close').click(function (){
       $('#saveCardetail').removeClass(' in');
      $('#saveCardetail').attr('style','display:none;');
    });
    $('#saveCarDetails').click(function (){
     // alert('sdsd');
        var formData=$('#policyform').serialize();
        var engineno = $('#engineno').val();
        var chassisno = $('#chassisno').val();
        var customer_id = $('#customer_id').val();
        if(engineno=='')
        {
          $('#engineno_err').html('Please Enter Engine No.');
          return false;
        }
        if(chassisno=='')
        {
          $('#chassisno_err').html('Please Enter Chassis No.');
          return false
        }
        if((engineno!='') && ((engineno.length < 6) || (engineno.length > 17))){
        $('#engineno_err').html("Please enter valid Engine No ");
            error_flag=true; 
        }
        if((chassisno!='') && ((chassisno.length < 6) || (chassisno.length > 17))){
            $('#chassisno_err').html("Please enter valid Chassis");
                error_flag=true; 
        }
          if((engineno!='') && (chassisno!='')){
           $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/updateCarDetails",
                  data : {engineno:engineno,chassisno:chassisno,customer_id:customer_id},
                  dataType: 'html',
                  success: function (responseData) 
                  { 
                    //alert(responseData);
                    if (responseData) {
                        saveCaseInfoData(formData);
                        return true;
                    } else {

                       snakbarAlert('Please Complete Car details.');
                    } 
                  }
            });
       }

    });

    $('#btnform5').click(function () {
        $("#btnform5").attr("disabled","true");
        var formData=$('#policyform').serialize();
        var carDet = $('#carDet').val();
        var flag=validateForm5();
       if(flag==false){
       if(carDet=='0'){
          var eng = fillForm(); 
        }else{
          saveCaseInfoData(formData);
          }     
        }
       setTimeout(function () {
            $("#btnform5").attr("disabled",false); 
       }, 2500);

    });
    $('#btnform6').click(function () {
        $("#btnform6").attr("disabled","true");
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
       setTimeout(function () {
           $("#btnform6").attr("disabled",false);
       }, 2500);

    });
    $('#btnform7').click(function () {
         //var formData=$('#documentform').serialize();
        savelogindoc();

    });
    $('#btnform8').click(function () {
        $("#btnform8").attr('disabled','disabled');
        $('.loaderClas').attr('style','display:block;');         
        var formData=$('#paymentform').serialize();
        var flag=validateForm8();
         if(flag==false){
        var rtype = $('#roleType').val();
        var insfrm8= $('#insfrm8').val();
        if(rtype!='admin' && insfrm8==''){
          $('.loaderClas').attr('style','display:none;');
          confirmSave('8');
        } 
        if(insfrm8=='true' || rtype=='admin'){
         saveCaseInfoData(formData);
        }
       }
       
        setTimeout(function () {
          $('.loaderClas').attr('style','display:none;');
          $("#btnform8").attr("disabled",false);
         }, 2500);
         

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
    


    $('#payment_mode').on('change', function(){
        var totprem=$('#totprem').val();
        var pmode =$('#payment_mode').val();
        var pby=$('input[name=payment_by]:checked').val();
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('.divreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').show();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('#divreason').hide();
        $('.divpayment').show();
        if(pby=='3')
        {
            $('#divreason').show();
            $('.divreceipt').hide();

        }
        if(pmode=='1') //cheque
        {         
            $('.divbank').show();
            $('.divcheque').show();
             $('.divinstrumentno').show();
             $('.divinstrumentdate').show();
        }
        if(pmode=='2') //online
        {
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $("#instrument_date").val("");
           $("#bank_name").val("");
           $('#bank_name')[0].sumo.reload();
           $('.divinstrumentdate').hide();
        }
        if(pmode=='3') //cash
        {
          $('.divbank').hide();
          $('.divcheque').hide();
           $('.divinstrumentno').hide();
             $('.divinstrumentdate').hide();
        }
        if(pmode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
           $('.divinstrumentno').show();
             $('.divinstrumentdate').show();
        }
        /*if($('#payment_mode').val()=='1'){
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
            $('.divIninstrumentno').hide();
            $('.divIninstrumentdate').hide(); 
            $('.divcheque').show(); 
            $('#payment_date').val('');
            $('#receipt_no').val('');
            $('#policy_amt').val(totprem);
            $('#subvention_amt').val(0);
            $('.divcheque').show();
            $('.divbank').show();
            $('.divonline').hide();
            $('.divinonline').hide();
            $('.divincheque').hide();
            $('.divdd').hide();
        }else if($('#payment_mode').val()=='2'){
            $('.divinstrumentno').show();
            $('.divinstrumentdate').hide();
            $('.divcheque').hide(); 
            $('#payment_date').val('');
            $('#receipt_no').val('');
            $('#policy_amt').val(totprem);
            $('#subvention_amt').val(0);
            $('.divcheque').hide();
            $('.divonline').show();
            $('.divinonline').hide();
            $('.divdd').hide();
            $('.divbank').hide();
        }else if($('#payment_mode').val()=='3'){
           $('.divinstrumentno').hide();
            $('.divinstrumentdate').hide(); 
           $('.divcheque').hide(); 
           $('#payment_date').val('');
            $('#receipt_no').val('');
            $('#policy_amt').val(totprem);
            $('#subvention_amt').val(0); 
           $('.divcheque').hide();
           $('.divonline').hide();
           $('.divinonline').hide();
           $('.divinbank').hide();
           $('.divbank').hide();
        }else if($('#payment_mode').val()=='4'){
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
            $('.divcheque').show();
            $('#payment_date').val('');
            $('#receipt_no').val('');
            $('#policy_amt').val(totprem);
            $('#subvention_amt').val(0); 
            $('.divonline').hide();
           $('.divinonline').hide();
           $('.divinbank').hide();
           $('.divbank').hide();
           $('.divdd').show();
        }*/
    });
    
    $('#in_payment_mode').on('change', function(){
        var totprem=$('#totprem').val();
        var paymode = $('#in_payment_mode').val();
        $('#divreason').show();
        $('.divreceipt').hide();
        $('.divremark').hide();
        $('.divpayments').hide();
        $('.divpayment').hide();
        $('.divinhouse').show();
        $('.divinpayment').show();
        $('.divinremark').show();
        $('.divinstrumentno').hide();
        $('.divinstrumentdate').hide();
         $('#divbank').hide();
         if(paymode=='1' || paymode=='4') //cheque//DD
        {
            $('.divinbank').show();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').show();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').show();
        }
        if(paymode=='2' || paymode=='3') //online
        {           
            $('.divinbank').hide();  
            $('.divcheque').hide();
            $('.divincheque').hide();
            $(".in_instrument_date").val("");
            $("#in_bank_name").val("");
            $('#in_bank_name')[0].sumo.reload();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').hide();

        }
    });
    
    $('#cpayment_mode').on('change', function(){
        var totprem=$('#totprem').val(); 
        var pmode =$('#cpayment_mode').val();
        var pby=$('input[name=cpayment_by]:checked').val();
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('.divreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').hide();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('#divreason').hide();
        $('.divpayment').show();
        if(pby=='3')
        {
            $('#divreason').show();
            $('.divreceipt').hide();
        }
        if(pmode=='1') //cheque
        {         
            $('.divbank').show();
            $('.divcheque').show();
             $('.divinstrumentno').show();
             $('.divinstrumentdate').show();
        }
        if(pmode=='2') //online
        {
           $('.divbank').hide();
           $('.divcheque').hide();
           $("#nstrument_date").val("");
           $("#bank_name").val("");
           $('#bank_name')[0].sumo.reload();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(pmode=='3') //cash
        {
          $('.divbank').hide();
          $('.divcheque').hide();
          $("#instrument_date").val("");
          $("#bank_name").val("");
          $('#bank_name')[0].sumo.reload();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(pmode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
           $('.divinstrumentno').show();
             $('.divinstrumentdate').show();
        }
    });
    
    //$('#accessories').on('keyup paste',totPremium);
});
function showreason(id,flag=''){
    var pmode=$('#payment_mode').val();
    var pimode=$('#in_payment_mode').val();
    var fhse = $('#fhse').val();
      if(id=='1'){
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('#divreason').hide();
        $('#divsisreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').show();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('.divreason').hide();
        $('.divpayment').show();
        if(pmode=='1') //cheque
        {
           
            $('.divbank').show();
            $('.divcheque').show();
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
        }
        if(pmode=='2') //online
        {
           
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(pmode=='3') //cash
        {
        
          $('.divbank').hide();
          $('.divcheque').hide();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(pmode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
          $('.divinstrumentno').show();
          $('.divinstrumentdate').show();
        }

   }
   if(id=='2'){
       $('#divreason').show();
        $('.divreceipt').hide();
        $('.divremark').hide();
        $('.divpayments').hide();
        $('.divpayment').hide();
        $('.divinhouse').show();
        $('.divinpayment').show();
        $('.divinremark').show();
        $('.divinstrumentno').hide();
        $('.divinstrumentdate').hide();
        $('#divbank').hide();
        if(pimode=='1') //cheque
        {
            $('.divinbank').show();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').show();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').show();
        }
        if(pimode=='2') //online
        {
           
            $('.divinbank').hide();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').hide();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').hide();

        }
        
   }
   if(id=='3'){
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('#divreason').show();
        $('#divsisreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').hide();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('.divreason').hide();
        $('.divpayment').show();
        if(pmode=='1') //cheque
        {
           
            $('.divbank').show();
            $('.divcheque').show();
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
        }
        if(pmode=='2') //online
        {
           
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(pmode=='3') //cash
        {
        
          $('.divbank').hide();
          $('.divcheque').hide();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(pmode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
          $('.divinstrumentno').show();
          $('.divinstrumentdate').show();
        }
    }
}

function cshowreason(id){
    var pmode=$('#cpayment_mode').val();
    //alert(pmode);
    var pimode=$('#in_payment_mode').val();
      if(id=='1'){
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('#divreason').hide();
        $('#divsisreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').show();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('.divreason').hide();
        $('.divpayment').show();
        if(pmode=='1') //cheque
        {
           
            $('.divbank').show();
            $('.divcheque').show();
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
        }
        if(pmode=='2') //online
        {
           
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(pmode=='3') //cash
        {
        
          $('.divbank').hide();
          $('.divcheque').hide();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(pmode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
          $('.divinstrumentno').show();
          $('.divinstrumentdate').show();
        }

   }
   if(id=='2'){
       $('#divreason').show();
        $('.divreceipt').hide();
        $('.divremark').hide();
        $('.divpayments').hide();
        $('.divpayment').hide();
        $('.divinhouse').show();
        $('.divinpayment').show();
        $('.divinremark').show();
        $('.divinstrumentno').hide();
        $('.divinstrumentdate').hide();
        $('#divbank').hide();
        if(pimode=='1') //cheque
        {
            $('.divinbank').show();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').show();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').show();
        }
        if(pimode=='2') //online
        {
           
            $('.divinbank').hide();
            $('.divbank').hide();
            $('.divcheque').hide();
            $('.divincheque').hide();
            $('.divIninstrumentno').show();
            $('.divIninstrumentdate').hide();

        }
        
   }
   if(id=='3'){
        $('.divinhouse').hide(); 
        $('.divinremark').hide(); 
        $('.divIninstrumentno').hide();
        $('.divIninstrumentdate').hide();
        $('.divincheque').hide();
        $('#divreason').show();
        $('#divsisreason').hide();
        $('.divsisreason').hide();
        $('.divinpayment').hide();
        $('.divinbank').hide();
        $('.divreceipt').hide();
        $('.divremark').show();
        $('.divinremark').hide();
        $('.divpayments').hide();
        $('.divpayment').show();
        $('.divreason').hide();
        $('.divpayment').show();
        if(pmode=='1') //cheque
        {
           
            $('.divbank').show();
            $('.divcheque').show();
            $('.divinstrumentno').show();
            $('.divinstrumentdate').show();
        }
        if(pmode=='2') //online
        {
           
           $('.divbank').hide();
           $('.divcheque').hide();
           $('.divinstrumentno').show();
           $('.divinstrumentdate').hide();
        }
        if(pmode=='3') //cash
        {
        
          $('.divbank').hide();
          $('.divcheque').hide();
          $('.divinstrumentno').hide();
          $('.divinstrumentdate').hide();
        }
        if(pmode=='4') //dd
        {
          $('.divbank').show();
          $('.divcheque').show();
          $('.divinstrumentno').show();
          $('.divinstrumentdate').show();
        }
    }
}
function validateQuotes(){
    error_flag=false;
    var totQuote=$('#totcnt').val();
    for(var i=0; i<=totQuote; i++){
        $('#ins_company_error_'+i).html("");
        $('#idv_amt_error_'+i).html("");
         $('#premium_amt_error_'+i).html("");
         $('#idv_duration_error_'+i).html("");
        if($('#ins_company_'+i).val()==''){
            $('#ins_company_error_'+i).html("Select Company");
            error_flag=true;
        }
        if($('#idv_amt_'+i).val()==''){
           $('#idv_amt_error_'+i).html("Add IDV");
           error_flag=true;
        }
        if($('#premium_amt_'+i).val()==''){
            $('#premium_amt_error_'+i).html("Add Premium");
            error_flag=true;
        }
        if($('#idv_duration_'+i).val()==''){
            $('#idv_duration_error_'+i).html("Select Duration");
            error_flag=true;
        }
    }
    return error_flag;
}

function confsaveins(flag){
        var iflag=flag;
        var frmId=$('#frmid').val();
        if(iflag=='1'){
            jQuery('#insconf').modal('hide');
            $('#insfrm'+frmId).val('true');
            $('#btnform'+frmId).trigger('click');
            return true;
        }else{
           jQuery('#insconf').modal('hide'); 
           return false; 
        }
    }

function validateInspect(){
    $('.error').html('');
    error_flag=false;
         $('#reference_no_error_0').html("");
         $('#ins_comment_error_0').html("");
         if($("input[name='ins_status_0']:checked").val()=='0'){
          $('#pending_no_error_0').html("Complete Inspection");
            error_flag=true;   
         }
        if($('#reference_no_0').val()==''){
            $('#reference_no_error_0').html("Add Reference No");
            error_flag=true;
        }
        if($('#ins_comment_0').val()==''){
            $('#ins_comment_error_0').html("Add comment");
            error_flag=true;
        }
    
    return error_flag;
}
function savelogindoc()
        {
          var customer_id = $("#customer_id").val();
          var case_id = $("#case_id").val();
           $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/saveLoginDocs/",
                  data : {customer_id:customer_id,case_id:case_id,doctype:'1'},
                  //dataType: 'json',
                  success: function (response) 
                  { 
                    var data = $.parseJSON(response);
                    console.log(data);
                    if (data.status == 'True') {
                        snakbarAlert(data.message);
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
function saveUploadData(){
    var insType=$('#insType').val();
    var rcCopy=$('#doc_rc_copy').val();
    var rcCopy2=$('#doc_rc_copy_2').val();
    var form29=$('#doc_form_29').val();
    var form30image1=$('#doc_form_30_image1').val();
    var form30image2=$('#doc_form_30_image2').val();
    var prevpolicyimage1=$('#doc_prev_policy_copy_image1').val();
    if(rcCopy==''){
      snakbarAlert('RC Copy Required');
      return false;  
    }else if(rcCopy2==''){
      snakbarAlert('RC Copy2 Required');
      return false;   
    }else if(form29=='' && insType=='1'){
      snakbarAlert('form 29 Required');
      return false;   
    }else if(form30image1=='' && insType=='1'){
      snakbarAlert('form 30 image 1 Required');
      return false;  
    }else if(form30image2=='' && insType=='1'){
       snakbarAlert('form 30 Image 2 Required');
      return false; 
    }else if(prevpolicyimage1=='' && insType=='2'){
       snakbarAlert('Previous Policy Copy Image1 Required');
      return false; 
    }else{
    
        var fileInputs = $('.file_input');
        var formData = new FormData();
        $.each(fileInputs, function(i,fileInput){
            if( fileInput.files.length > 0 ){
                $.each(fileInput.files, function(k,file){
                    formData.append('docimg[]', file);
                });
            }
        });
        
        $.ajax({
            method: 'POST',
            url: base_url +"uploadDocument",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                console.log(response);
                var data = $.parseJSON(response);
                if (data.status == 'True') {
                snakbarAlert(data.message);
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

}

function saveCaseInfoData(formData) {
    $.ajax({
        type: "POST",
        url: base_url + "saveUpdateInsuranceData",
        data: formData,
        //dataType: 'json',
        success: function (response) {
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
                if(typeof data.errortype !== 'undefined' && data.errortype ==2){
                  var model = $('#cancel_model');
                  model.find('.modal-title').html(data.titlehead);
                  $('.duplicatecheck').remove();
                  model.find('.modal-body').prepend(data.message);
                  model.find('.modal-footer').html(data.footer);
                  $('#cancel_model').attr('style','display:block;');
                  $('#cancel_model').addClass(' in');
                }else {
                  snakbarAlert(data.message);
                  return false;
                }
            }
        }
    });
}

/*$('#myear').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getmakemodelversionlist",
        data: {type:'make',year: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#make').html(responseData);
            $('#model').prop('disabled', false);
            $('#model').html('<option value="">Select Model</option>');
            $('#variant').html('<option value="">Select Version</option>');

        }
    });
    });*/
     
/*$('#make').on('change', function () {
  //alert('hiu');
    var selected = $(this).val();
    var myear=$('#myear').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getmakemodelversionlist",
        data: {type:'model',make:selected,year: myear},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#model').prop('disabled', false);
            $('#variant').html('<option value="">Select Version</option>');

        }
    });
    });
$('#model').on('change', function () {
    var model_id = $('#model').val();
    var make=$('#make').val();
    var myear=$('#myear').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getmakemodelversionlist",
        data: {type:'version',make:make,model_id: model_id,year: myear},
        dataType: "html",
        success: function (responseData)
        {
            $('#variant').html(responseData);
            $('#variant').prop('disabled', false);

        }
    });
    });  */

    function getModel(make_id,model_id)
    {
        var selected = make_id;
        var myear=$('#myear').val();
        $.ajax({
            type: 'POST',
            url: base_url+"Insurance/getmakemodelversionlist",
            data: {type:'model',make:selected,year: myear},
            dataType: "html",
            success: function (responseData)
            {
                $('#model').html(responseData);
                if(model_id>='1')
                {
                    $('#model').val(model_id);
                }
                $('#model').prop('disabled', false);
                $('#variant').html('<option value="">Select Version</option>');

            }
        });
    }

    function getVersion(model_id,version_id)
    {
        var model_id = $('#model').val();
        if(version_id>='1')
                {
                  var model_id = model_id;
                }
               // alert(model_id);
        var make=$('#make').val();
        var myear=$('#myear').val();
        $.ajax({
            type: 'POST',
            url: base_url+"Insurance/getmakemodelversionlist",
            data: {type:'version',make:make,model_id: model_id,year: myear},
            dataType: "html",
            success: function (responseData)
            {
                $('#variant').html(responseData);
                $('#variant').prop('disabled', false);
                if(version_id>='1')
                {
                  $('#variant').val(version_id);
                }
            }
        });
    }  
$('#model11').on('change', function () {
    var selected = $(this).val();
    var make=$('#make').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getmakemodelversionlist",
        data: {type:'model',make:make,year: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#model').prop('disabled', false);
            $('#variant').html('<option value="">Select Version</option>');

        }
    });
    });    

$('#model122').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#model').prop('disabled', false);
            $('#variant').html('<option value="">Select Version</option>');

        }
    });
    });
    
 $('#model1113').on('change', function () {
    var selected = $(this).val();
    var make = $('#make').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getVariant",
        data: {make:make,model: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#variant').html(responseData);
            $('#variant').prop('disabled', false);

        }
    });
    }); 
    
  $('#source').on('change', function () {
      var source=$('#source').val();
      if(source=='dealer'){
        $('#divdealerName').show();
        $('#divsales').show();
    }else{
        $('#divdealerName').hide();
        $('#divsales').hide();
    }
  });
  $('#dealerName').on('change', function () {
    var selected = $('#dealerName').val();
    $.ajax({
        type: 'POST',
        url: base_url+"Insurance/getSalesDetails",
        data: {dealerId: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#sales_exec').html(responseData);
        
        }
    });
    });
  
  
  $('#case_status').on('change', function () {
      if($(case_status).val()=='1'){
        $('#divassign').show();
    }else{
        $('#divassign').hide();
    }
  });
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
  
  function showAddress(){
    if(isaddress.checked) {
        $('#divnomAdd').hide();
    } else {
        $('#divnomAdd').show();
    }
  }  

  function totPremium(){
      var accessories=$('#accessories').val();
      var extra_charge=$('#extra_charge').val();
      var special_discount=$('#special_discount').val();
      var gst=$('#gst').val();
      var totpremium=+accessories + +extra_charge + +special_discount + +gst;
      $('#premium').val(totpremium);
      //alert(totpremium);
    
  }
  
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
function alpha1only(event){
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    if($("input:focused").is(".classname"))
    {
        regex = new RegExp(regex.source + "|\/");
    }
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
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
function deleteForm(event,type)
    {
      var did = $(event).attr('id');
      var d = did.split("#");
      var insId = $('#ins_id').val();
      var id = d[1];
      var divid=d[0].split("_");
      $.ajax({
          type : 'POST',
          url : base_url+ "Insurance/deleteFormLogin/",
          data : {id:id,type:type},
      });
      /*var seperator=",";
      var insIdd=removeValue(insId,did,seperator);
      alert(insIdd);
      $('#ins_id').val(insIdd);*/
      $('#bankdiv_'+divid[1]).attr('style','display:none;');
      location.reload();
    }
function showpolicyIssue(id){
    if(id=='1'){
       $('#divpolicyno').show();
       $('#divcovernoteno').hide();
       if($('#policy_no').val()!=''){
       $('#covernote_no').val('');
        }
    }else if(id=='2'){
      $('#divcovernoteno').show();
      $('#divpolicyno').hide();
      if($('#covernote_no').val()!=''){
      $('#policy_no').val('');
     }
    }
} 

function populateWashoutReason(id)
     {
          $.ajax({
            type : 'POST',
            url : base_url+"Insurance/populateWashoutReason/",
            data : {id:id},
            dataType: 'html',
            success: function (response) { 
                $('#washout_category').html(response);
            }
        });
                   
     }
     
     function washNowins()
     {
        $('.error').html('');
        var washout_reason = $('#washout_reason').val();
        if(washout_reason > 0){
               if(washout_reason=='4'){
                var closeOther=$('#close_other').val();
                if(closeOther==''){
                    $('#close_other_error').html('Please Enter Other Reason');
                    return false;
                }
            }
         if(washout_reason=='4'){
            var close_text = $("#close_other").val();
            }else{
             var close_text = $("#washout_reason option:selected").text();   
            }   
        var customer_id = $('#customer_id').val();
        var case_id = $("#model_case_id").val();
        
        if(customer_id>=1)
        {
            $.ajax({
                type : 'POST',
                url : base_url+"Insurance/cancelNow",
                data : {type_id:washout_reason,type:'washout',customer_id:customer_id,closetxt:close_text,case_id:case_id},
                dataType: 'html',
                success: function (response) { 
                    $('#washout_category').html(response);
                    closeModelNow();
                    $('#Washout').attr('style','display:none;');
                    $('.wash-out').html('<a href="#"></a>');
                    setTimeout(function(){ window.location.href = base_url+"insListing"; }, 1000);
                }
            }); 
        }
        }else{
            $('#washout_reason_error').html('Please select Reason');
        }
     }
     
    function closeModelNow()
    {
        $("#cancel_model").attr('style','display:none');
        $("#cancel_model").attr('class','modal fade');
        $("#washout_model").attr('style','display:none');
        $("#washout_model").attr('class','modal fade');
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
    function addCommas1(str,control){
      var nStr=str;
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
    function showpolicyexpired() {
        if ($('#ins_category').val() == '4') {
            $('#divexpired').show();
        } else {
            $('#divexpired').hide();
        }
        if ($('#ins_category').val() == '1') {
            $('#ncb_div').attr('style', 'display:block !important');
        } else {
            $('#ncb_div').attr('style', 'display:none !important');
        }
    }
  
  function setInspriorty(flag,insId,id){
      var totinspect=$('#totcnt').val();
      if(flag=='1'){
      var insflag=insId+'_'+flag;
      //alert(totinspect);
      for(var i=0; i<=totinspect; i++){
          if(id==i){
            $('#inscompelete_'+id).val(insflag);
          }else{
            $('#inscompelete_'+i).val('');  
          }
       }
      }else{
        for(var i=0; i<=totinspect; i++){
            var insureId=$('#insId_'+i).val();
            var insflag=insureId+'_1';
        if($('#complete_'+i+':checked').length > 0){    
          $('#inscompelete_'+i).val(insflag);  
        }else{    
        $('#inscompelete_'+id).val('');
        }
        }
      }
      
  }
  function countinue(action)
    {
       window.location.href = action;
    }
  var removeValue = function(list, value, separator) {
  //separator = separator || ",";
  var values = list.split(separator);
  for(var i = 0 ; i < values.length ; i++) {
    if(values[i] == value) {
      values.splice(i, 1);
      return values.join(separator);
    }
  }
  return list;
}
$('#filtersubmit').on('click', function () {
   $('#err_dur').html('');

   var formData=$('#searchqform').serialize();
   var searchinsCat = $('#srcinscat').val();

    var duration = $('#duration').val();
      //    alert(duration);
   if((searchinsCat=='1') && (duration=='0'))
   {
     $('#err_dur').html('Please Select Duration');
     return false;
   }
   var hidden_policy_type = $("#hidden_policy_type").val();
   var policy_type = $("#policy_type").val();
   var is_quote_added = $("#is_quote_added").val();
   var res= true;
   if(searchinsCat=='2' ||  searchinsCat=='3' || searchinsCat=='4'){
   if(hidden_policy_type != "" && hidden_policy_type != policy_type && is_quote_added == 1){
      var res=  confirm("Are you sure to change policy type?\n\
         Policy Type change will delete all quotes.");
   }
   }
   if(res == true){
   $.ajax({
        type: "POST",
        url: base_url + "Insurance/saveUpdatefilterQuotesData",
        data: formData,
        dataType: 'html',
        success: function (response) {
            var data = $.parseJSON(response);
            if (data.status == 'True') {
                window.location.href =data.Action;
                return true;
            } else {
                //snakbarAlert(data.message);
                return false;
            }
        }
    });
   }
});
$('#claimtaken').on('change', function () {
var ctaken=$('#claimtaken').val();
    if(ctaken=='2'){
        $('#divncb').show();
        $('#divncbprev').show();
    }else{
        $('#divncb').hide();
        $('#divncbprev').hide();
    }
});
$('#InsQuotesHistory').on('click', function (ev) {
    var ths = ev.currentTarget;
    var quote_id = $(ths).attr('data-id');
    console.log(quote_id);
    var customer_id = $('#customer_id').val();
    var inscat = $('#inscat').val();
    $.ajax({
        type: "POST",
        url: base_url + "insurance/get_quotespop",
        data: {quote_id:quote_id,customer_id:customer_id},
        //dataType: 'json',
        success: function (data) {
            $('#InsQuotesHist').empty();
            $('#InsQuotesHist').append(data);
        }
    });
});
$('body').on('click', '.check-quotes', function (event) {
var quote_id = $(this).data('id');
var customer_id = $('#customer_id').val();
var inscat = $('#inscatt').val();
$.post(base_url +'insurance/get_quotespop',{'quote_id':quote_id,customer_id:customer_id,inscat:inscat}, function (response) {
    $('#quote-details-content').html(response);
    $('#quote-details').modal('show');
 });
});
function addnewQuotes(ftype){
    $(".addnewQuotes_class").attr("disabled",true);
    
    error_flag=false;
    $('.error').html('');
    if(ftype==1){
    var ins_company=$('#ins_detail').val();
    var idv=$('#idv').val();
    var addOn=$('#add_on_txt').val();
    if(ins_company==''){
      $('#ins_detail_error').html("Please Select Insurance Company");
      error_flag=true;  
    }else if(idv==''){
       $('#idv_error').html("Please enter IDV");
       error_flag=true; 
    }else if($("add_on_perc").is(":visible")){
        if(addOn >= 100){
       $('#add_on_txt_error').html("Please enter less than 100");
       error_flag=true;
        }
    }
    }else if(ftype==2){
      var regex = /,/gi;  
      var midv=$('#midv').val();
      var mins_detail=$('#mins_detail').val();
      var mbasic_od_amt=$('#mbasic_od_amt').val();
      if(mbasic_od_amt != "" && mbasic_od_amt != undefined){
          mbasic_od_amt=mbasic_od_amt.replace(regex, '');
      }
      var mncb_discount=$('#mncb_discount').val();
      if(mncb_discount != "" && mncb_discount != undefined){
          mncb_discount=mncb_discount.replace(regex, '');
      }
      var mod_discount=$('#mod_discount').val();
      if(mod_discount != "" && mod_discount != undefined){
         mod_discount=mod_discount.replace(regex, '');
      }
      var mbasic_third_party=$('#mbasic_third_party').val();
      var mper_acc_cover=$('#mper_acc_cover').val();
      var mpaid_driver=$('#mpaid_driver').val();
      if(midv==''){
      $('#midv_error').html("Please enter IDV");
      error_flag=true;  
        }else if(mins_detail==''){
           $('#mins_detail_error').html("Please Select Insurance Company");
           error_flag=true; 
        }else if(mbasic_od_amt==''){
            mbasic_od_amt = 0;
           $('#mbasic_od_amt_error').html("Please enter Basic Od Amt");
           error_flag=true; 
        }else if((mncb_discount!='') && (parseInt(mncb_discount) > parseInt(mbasic_od_amt))){
            $('#mncb_discount_error').html("NCB Discount can not greater than Basic Od Amt");
           error_flag=true; 
        }else if(mod_discount==''){
            mod_discount = 0;
           $('#mod_discount_error').html("Please enter OD Discount");
           error_flag=true; 
        }else if(mbasic_third_party==''){
           $('#mbasic_third_party_error').html("Please enter Basic Third Party");
           error_flag=true; 
        }else if(mper_acc_cover==''){
           $('#mper_acc_cover_error').html("Please enter Per Acc Cover");
           error_flag=true; 
        }else if(mpaid_driver==''){
           $('#mpaid_driver_error').html("Please enter Paid Driver");
           error_flag=true; 
        }
        if(mncb_discount == '')
            mncb_discount = 0;
        var NCB_OD_discount = parseInt(mod_discount) + parseInt(mncb_discount);
        if(parseInt(mbasic_od_amt) <  parseInt(NCB_OD_discount))
        {
           $('#mbasic_od_amt_error').html("Od Amt can not less than NCB & OD Discount");
           error_flag=true; 
        }
    }
    
    if(error_flag==false){
        $(".addnewQuotes_class").attr("disabled",true);
               if(ftype==1){
                var formdata=$('#frmadd').serialize();
                }else if(ftype==2){
                 var formdata=$('#mfrmadd').serialize();   
                }
                
                jQuery.ajax({
                type: "POST",
                url: base_url+"insurance/getInsuranceQuotes",
                data: formdata,
                dataType: 'html',
                success: function(response){
                       //$("#divquotes").append(data);
                       $('#addQuotes').attr('style','display: none; padding-right: 15px;');
                       $('#addQuotes').attr('class','modal fade in');
                       var data = $.parseJSON(response);
                        console.log(data);
                        if (data.status == 'True') {
                            $('.loaderClas').attr('style','display:block;');
                            snakbarAlert(data.message);
                            setTimeout(function () {
                                window.location.href =data.Action;
                            }, 2500);

                            return true;
                        } else {
                             $(".addnewQuotes_class").attr("disabled",false);
                            snakbarAlert(data.message);
                            return false;
                        }
                 }
              });
           }else{
               $(".addnewQuotes_class").attr("disabled",false);
           }
          }
$("#addcatnewQuotes").click(function(){
    var ins_company=$('#ins_detail_new').val();
    var idv=$('#idv_new').val();
    var addOn=$('#add_on_txt').val();
    if(ins_company==''){
      $('#ins_detail_new_error').html("Please Select Insurance Company");
      error_flag=true;  
    }else if(idv==''){
       $('#idv_new_error').html("Please enter IDV");
       error_flag=true; 
    }else if($("add_on_perc").is(":visible")){
        if(addOn >= 100){
       $('#add_on_txt_error').html("Please enter less than 100");
       error_flag=true;
        }
    }else{
               var formdata=$('#frmnewadd').serialize();
               //var idv=$('#idv').val();
                jQuery.ajax({
                type: "POST",
                url: base_url+"insurance/getInsuranceQuotes",
                data: formdata,
                dataType: 'html',
                success: function(response){
                       //$("#divquotes").append(data);
                       $('#addcnewQuotes').attr('style','display: none; padding-right: 15px;');
                       $('#addcnewQuotes').attr('class','modal fade in');
                       var data = $.parseJSON(response);
                        console.log(data);
                        if (data.status == 'True') {
                            snakbarAlert(data.message);
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
          });

function confirmQuoteSave(frmid)
    {
    var quote_id=$('#quot_id_'+frmid).val();
    var cusId   = $('#customer_idd').val();
  /*  alert(cusId);
    return false;*/

    $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/confirmQuotesave",
                  data : {frmId:frmid,quote_id:quote_id},
                  dataType: 'json',
                  success: function (responseData) 
                  { 
                     $('#headerdiv').html('');
                        $('#bodysdiv').html('');
                   // alert(responseData[0]);
                    if (responseData) {
                        $('#ffrmid').val(frmid);
                        $('#quoteid').val(quote_id);
                        $('#headerdiv').html(responseData[0].head);
                        $('#bodysdiv').html(responseData[0].body);
                        jQuery('#insQuoteconf').modal('show');
                        $('.modal-footer').show();
                        return true;
                    } else {
                        return false;
                    } 
                  }
            });
    }
  function confAcceptins(flag){
        var iflag=flag;
        var frmId=$('#ffrmid').val();
        var quoteId=$('#quoteid').val();
        if(iflag=='1'){
            $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/confirmUpdateQuotesave",
                  data : {quote_id:quoteId},
                  dataType: 'html',
                  success: function (responseData) 
                  {
                      var data = $.parseJSON(responseData);
                        console.log(data);
                    if (data.status == 'True') {
                            window.location.href =data.Action;
                            return true;
                        } else {
                            return false;
                        } 
                  }
            });
        }else{
           jQuery('#insconf').modal('hide'); 
           return false; 
        }
    }
 function deleteQForm(qid)
    {
    $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/confirmdeleteQuote",
                  data : {quote_id:qid},
                  dataType: 'html',
                  success: function (responseData) 
                  { 
                    if (responseData) {
                        $('#delquoteid').val(qid);
                        jQuery('#insQuotedeleteconf').modal('show');
                        return true;
                    } else {
                        return false;
                    } 
                  }
            });
        
    }   
 function deleteQuoteForm(flag){
     if(flag=='1'){
     var quoteId=$('#delquoteid').val();
     $.ajax({
                  type : 'POST',
                  url : base_url + "Insurance/confirmDeleteQuotesave",
                  data : {quote_id:quoteId},
                  dataType: 'html',
                  success: function (responseData) 
                  { 
                    var data = $.parseJSON(responseData);
                        console.log(data);
                        if (data.status == 'True') {
                            snakbarAlert(data.message);
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
        }else{
           jQuery('#insQuotedeleteconf').modal('hide'); 
        }    
 }
 $('#car_city').on('change', function () {
 var ctaken=$('#claimtaken').val();
    if(ctaken=='1'){
        $('#divncb').show();
        $('#divncbprev').show();
    }else{
        $('#divncb').hide();
        $('#divncbprev').hide();
    }
});
 function validatecountinue(action)
    {
     var acflag=$('#acflag').val();
     if(acflag==''){
       jQuery('#insquotealert').modal('show');  
     }else{
         window.location.href = action;
     }
    }

      $('.tclaim').on('click', function (ev) {
      var tclaim=$(ev.currentTarget).val();
      if(tclaim=='1'){
          $('#divncb').hide();
          $('#divncbprev').hide();
      }else if(tclaim=='2'){
          $('#divncbprev').show();
          $('#divncb').show();
    } 
  });
$('input:radio[name="loan_taken"]').change(function(){
    if ($(this).is(':checked') && $(this).val() == '2'){
     $('#divfinance').hide();   
    }else{
     $('#divfinance').show();   
    }
});

function calAmtdrawn(id,totamt,val){
 // alert(id+'-'+totamt+'-'+val);
  var leftPaid = $('#leftPaid').val();
    totamt = totamt.replace( /,/g, "" );
    currentamt = $('#'+id).val();
    val = val.replace( /,/g, "" );
    if(id=='policy_amt'){
       if(totamt > 0){
           var totprem=$('#totprem').val();
           totprem = totprem.replace( /,/g, "" );
           var svamt=parseInt(totprem)-parseInt(val);
           if(!isNaN(svamt)){
           //svamt=addCommas(svamt, 'policy_amt');
            // $('input[name='+id+']').val(currentamt);
            $('#subvention_amt').val(svamt);
            }
        }
     }else if(id=='in_policy_amt'){
         if(totamt >0){
           var totprem=$('#totinprem').val();
           totprem = totprem.replace( /,/g, "" );
           var svamt=parseInt(totprem)-parseInt(val);
           if(!isNaN(svamt)){
           //svamt=addCommas(svamt, 'in_policy_amt');
            // $('input[name='+id+']').val(currentamt);
            $('#subvention_amt').val(svamt);
            }
            }
     }else if(id=='cpolicy_amt'){
         if(totamt >0){
           var totprem=$('#totprem').val();
           totprem = totprem.replace( /,/g, "" );
           var svamt=parseInt(totprem)-parseInt(val);
           if(!isNaN(svamt)){
           //svamt=addCommas(svamt, 'cpolicy_amt');
            // $('input[name='+id+']').val(currentamt);
            $('#csubvention_amt').val(svamt);
            }
            }
     }
     // console.log('input[name='+id+']');
    $('input[name='+id+']').attr('value',currentamt);

}

$("#ncbdiscountprev").change(function(){ 
   setNCBOption(1)
});

function setNCBOption(flag=""){
     var ncbdiscountprev = $('#ncbdiscountprev option:selected').val();
   if($('#ncbdiscountprev option:selected').next().val() === undefined || (ncbdiscountprev >= 50) ){
     var next = ncbdiscountprev;
   }else{
     var next = $('#ncbdiscountprev option:selected').next().val();
   }
   if($("#hidden_ncb").val() == "" || flag == 1){
    $("#ncbdiscount option").each(function()
    {
        var opt =$(this).val();      
        if(opt == next){
            setTimeout(function(){ $('#ncbdiscount').val(opt); }, 300);
        }
    });
   }
}

function showClaim(flag){
    var policy_type = $("#policy_type").val();
    if(policy_type == 1 || policy_type == 3 || flag==1){
        $("#claim_Div").css("display","block");
    }else{
        $("#claim_Div").css("display","none"); 
    }
}
