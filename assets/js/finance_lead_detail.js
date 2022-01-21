$('.lead_source').change(function () {
    var source = $('.lead_source').val();
    if(source=='1'){
      $('.sumo_meet_the_customer').attr('style','display:block;');
            $('.bbbb').attr('style','display:none;');
            $('.aaaa').attr('style','display:block;');
        $('.showDealerBox').show();
    }else{
        $('.sumo_meet_the_customer').attr('style','display:none;');
            $('.aaaa').attr('style','display:none;');
            $('.bbbb').attr('style','display:block;');
            $('.bbbb').val('1');
            $('#meet_the_customer').val('1');
            $('.showDealerBox').hide();
         }
});



$(document).ready(function (ev) {
  var leadsource = $('.lead_source').val();
    if(leadsource=='1'){
      $('.sumo_meet_the_customer').attr('style','display:block;');
            $('.bbbb').attr('style','display:none;');
            $('.aaaa').attr('style','display:block;');
        $('.showDealerBox').show();
    }else{
        $('.sumo_meet_the_customer').attr('style','display:none;');
            $('.aaaa').attr('style','display:none;');
            $('.bbbb').attr('style','display:block;');
            $('.bbbb').val('1');
            $('#meet_the_customer').val('1');
            $('.showDealerBox').hide();
         }
         
    $('#leadDetailsButton').click(function (ev) {
       // alert("Aa");
        $('#leadDetailsButton').attr("disabled",true);
        var formData=$('#leadDetails').serialize();
        var error = leadDetailErr();
        if(error)
        {
          $('#leadDetailsButton').attr("disabled",false);
          $('.error').attr('style','display:block');
          return error;

        }
        $.ajax({
            type: "POST",
            url: base_url+"saveUpdateFinanceData",
            data:formData,
            //dataType: 'json',
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.status == 'True') {  
                 // alert(data.customerId);
                snakbarAlert(data.message);
                 $('.loaderClas').attr('style','display:block;');
                setTimeout(function () {
                    window.location.href= base_url+"personalDetail/"+data.customerId;
                            }, 2500);
               
                return true;
                } else {
                    $('#leadDetailsButton').attr("disabled",false);
                    snakbarAlert(data.message);
                    return false;
                }
            }
        });
        ev.preventDefault();

    });
    
    
/*  addons adeed on edit DO START BY Masawwar Ali  */

    /* added addons on  Gross DO Amount start  */
        var sum  = 0;
        var price = [];
        var name = [];
        var inps = document.getElementsByName('discountprice1[]');
          for (var i = 0; i <inps.length; i++) {
          var inp=inps[i];    
          var str = 0;
          if(inp.value){
           str =  inp.value;
              str =  str.replace(',','');
              if(str != "")
                 price.push(str);
              sum = parseInt(sum) + parseInt(str);
          }
          }
          var inns = document.getElementsByName('discountname1[]');
          for (var i = 0; i <inns.length; i++) {
          var inn=inns[i];
            name.push(inn.value);
          }


          var disn1s = name;
          var disp1s = price;

        $('#disp_in').val(disp1s);
        $('#disn_in').val(disn1s);

        /* added addons on  Gross DO Amount end    */

        /* added additional discount in showroom dis popup start */
        var d_sum = 0;
        var d_price = [];
        var d_name = [];
        var d_inps = document.getElementsByName('discountprice2[]');
          for (var i = 0; i <d_inps.length; i++) {
              var d_inp=d_inps[i];
              var d_str =  d_inp.value;
              if(d_str != ""){
                    d_str =  d_str.replace(',','');
                    d_price.push(d_str);
                    d_sum = parseInt(d_sum) + parseInt(d_str);
              }
          }
          var d_inns = document.getElementsByName('discountname2[]');
          for (var i = 0; i <d_inns.length; i++) {
          var d_inn=d_inns[i];
            d_name.push(d_inn.value);
          }


          $('#disp_show').val(d_price);
          $('#disn_show').val(d_name);

        /* added additional discount in showroom dis popup end   */



        /* added additional discount in shared discount popup start*/
             var ds_sum = 0;
        var ds_price = [];
        var ds_name = [];
        var dsinps = document.getElementsByName('discountprice[]');
          for (var i = 0; i <dsinps.length; i++) {
          var dsinp=dsinps[i];
           var ds_str =  dsinp.value;
           if(ds_str !=""){
              ds_str =  ds_str.replace(',','');
              ds_price.push(ds_str);
              ds_sum = parseInt(ds_sum) + parseInt(ds_str);
           }
          }
          var dsinns = document.getElementsByName('discountname[]');
          for (var i = 0; i <dsinns.length; i++) {
          var dsinn=dsinns[i];
            ds_name.push(dsinn.value);
          }

          $('#disp_dis').val(ds_price);
          $('#disn_dis').val(ds_name);

        /* added additional discount in shared discount popup end  */


    /*  addons adeed on edit DO END BY Masawwar Ali  */
   
    });
   
   $('#rcdetailButton').click(function(){
        var formData=$('#rc_detail').serialize();
        var err = rcDetailErr();
        if(err)
        {
          $('.error').attr('style','display:block');
          return err;
        }
         saveRcInfoData(formData);
   });

   $('#advbookingButton').click(function(){
     
        $('#advbookingButton').attr("disabled",true);
        //  alert("aa");
        var formData=$('#adv_booking').serialize();
        var err = advbookingErr();
        if(err)
        {
          setTimeout(function(){  $("#advbookingButton").attr("disabled",false);  }, 3000);
          $('.error').attr('style','display:block');
          return err;
        }
         saveBookingInfoData(formData);
        
   });

    $('#personalDetails').click(function () {
      $("#personalDetails").attr("disabled", true);
        var formData=$('#CaseInfoForm').serialize();
        var err = personalDetailErr();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#personalDetails").attr("disabled", false);
          return err;
        }
        saveCaseInfoData(formData);
         $("#personalDetails").attr("disabled", false);

    });
    $('#financeAcedmicButton').click(function () {
       $("#financeAcedmicButton").attr("disabled", true);
        var formData=$('#financeAcedmic').serialize();
        var err = financeAcedmic();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#financeAcedmicButton").attr("disabled", false);
          return err;
        }
        saveCaseInfoData(formData);
        $("#financeAcedmicButton").attr("disabled", false);

    });
    $('#loanExpectedButton').click(function () {
       $("#loanExpectedButton").attr("disabled", true);
        var formData=$('#loanExForm').serialize();
        var err = loanExpectedErr();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#loanExpectedButton").attr("disabled", false);
          return err;
        }
         saveCaseInfoData(formData);
          $("#loanExpectedButton").attr("disabled", false);

    });
    $('#residenceButton').click(function () {
       $("#residenceButton").attr("disabled", true);
        var formData=$('#residenceForm').serialize();
        var err = residentialValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
            $("#residenceButton").attr("disabled", false);
          return err;
        }
         saveCaseInfoData(formData);
            $("#residenceButton").attr("disabled", false);

    });
    $('#refrenceButton').click(function () {
      $("#refrenceButton").attr("disabled", true);
        var formData=$('#refrenceForm').serialize();
        var err = refrenceDetailsValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#refrenceButton").attr("disabled", false);
          return err;
        }
         saveCaseInfoData(formData);
         $("#refrenceButton").attr("disabled", false);

    });
    function renderpdfs(caseId=''){
        if(caseId>='1'){
          window.top.location.href = base_url+"Finance/loanpdf/" + caseId; 
        }
        setTimeout(function(){ 
        var formData=$('#bankForm').serialize();
        var err = bnkInfoValidation();
        var admin = $('#rolemgmt').val();
        if((admin!='admin') && (admin!='Loan Admin')){
          $('#loanPop').addClass(' in');
          $('#loanPop').attr('style','display:block');
          $('#frmids').val('bankForm');
          //alert('hiii');
        // var r = confirm("You won't be able to make any changes after saving. Please preview all the details before saving");
       }
        else {
            saveCaseInfoData(formData);
        }
         }, 1000);
            xclose();  
     }  
    function showPopups()
    {
        $('#chooseRadio').addClass(' in');
        $('#chooseRadio').attr('style','display:block');
        //return false;
    }
    $('#bankInfoButton').click(function () {
        var formData=$('#bankForm').serialize();
        var err = bnkInfoValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
          return err;
        }
        var buyertype = $('#buyertype').val();
        if(buyertype=='2')
        {
          showPopups();
          return false;
        }
        var admin = $('#rolemgmt').val();
        if((admin!='admin') && (admin!='Loan Admin')){
          $('#loanPop').addClass(' in');
          $('#loanPop').attr('style','display:block');
          $('#frmids').val('bankForm');
          //alert('hiii');
        // var r = confirm("You won't be able to make any changes after saving. Please preview all the details before saving");
       }
        else {
            saveCaseInfoData(formData);
        }
        

    });

  

    $("#savefilelogin").click(function(){
        var countTotalFiles = $('#countTotalFiles').val();
        if(countTotalFiles=='0')
        {
          snakbarAlert('Please add atleast one case file');
          return false;
        }
        var i = $('#saveI').val();
        if(i<=1)
        {
            $('.loan_amt').attr('readonly','readonly');
            $('.tenor').attr('readonly','readonly');
            $('.roi').attr('readonly','readonly');
            $('.reff').attr('readonly','readonly');
            $('.add').attr('style','display:none');
            $('.edit').attr('style','display:block');
             var err = fileLoginValidation();
              if(err)
                {
                  $('.error').attr('style','display:block');
                  $('#savefilelogin').text('Preview');
                  return err;
                }else{
                    $('#saveI').val('2');
                    $('#savefilelogin').text('SAVE AND CONTINUE');
                }
          for(var j=1; j<= countTotalFiles ; j++ )
          {
            var fi = $("#fil_"+j).text();
            var fitrim = $.trim(fi);
            if(fitrim!='Open')
            {
                $("#fil_"+j).text(fitrim);
            }
            else
            {
              $('.opened').text('Filed');
            }
          }
        }
        else if(i>='2')
        {
            if(i=='2')
            {
                var formData = $('#formLogin').serialize();
                var err = fileLoginValidation();
                if(err)
                {
                  $('.error').attr('style','display:block');
                  return err;
                }
                 var admin = $('#rolemgmt').val();
                  var r = true;
                  if((admin!='admin') && (admin!='Loan Admin')){
                      $('#loanPop').addClass(' in');
                      $('#loanPop').attr('style','display:block');
                      $('#frmids').val('formLogin');
                   //var r = confirm("You won't be able to make any changes after saving. Please preview all the details before saving");
                 }else{
                      saveCaseInfoData(formData);
                  }
                //saveCaseInfoData(formData);
            }
            $('#saveI').val('1');
        }
               
    });

    $('#cpvfilelogin').click(function () {
      $("#cpvfilelogin").attr("disabled", true);
        var formData = $('#cpv_detail').serialize();
        var err = cpvDetailValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
           $("#cpvfilelogin").attr("disabled", false);
          return err;
        }
        saveCaseInfoData(formData);
         $("#cpvfilelogin").attr("disabled", false);
    });

     $('#decisionfile').click(function () {
       $("#decisionfile").attr("disabled", true);
        var formData = $('#decisionLogin').serialize();
        var err = decisionValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
            $("#decisionfile").attr("disabled", false);
          return err;
        }
        saveCaseInfoData(formData);
          $("#decisionfile").attr("disabled", false);

    });
    $('#disburseButton').click(function () {
        $("#disburseButton").attr("disabled", true);
        var formData=$('#disburseLogin').serialize();
        var err = disbursalValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#disburseButton").attr("disabled", false);
          return err;
        }
        var admin = $('#rolemgmt').val();
        var r = true;
        if((admin!='admin') && (admin!='Loan Admin')){
          $('#loanPop').addClass(' in');
          $('#loanPop').attr('style','display:block');
          $('#frmids').val('disburseLogin');
       } else{
          saveCaseInfoData(formData);
          $("#disburseButton").attr("disabled", false);
       }
    });

    $('#postDetailsButton').click(function () {
        var formData=$('#deliveryDetails').serialize();
        var err = postDetailValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
          return err;
        }
         saveCaseInfoData(formData);

    });
    $('#paymentDetailsButton').click(function () {
        var formData=$('#paymentDetails').serialize();
        var err = paymentDetailValidation();
        if(err)
        {
          $('.error').attr('style','display:block');
          return err;
        }
       saveCaseInfoData(formData);
        // saveCaseInfoData(formData);

    });
    
    function countinue(action)
      {
         window.location.href = action;
      }
    function saveCaseInfoData(formData,flag='') {
    $.ajax({
        type: "POST",
        url: base_url + "saveUpdateFinanceData",
        data: formData,
        async: false,
        //dataType: 'json',
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);            
            if (data.status == 'True') {
                if (flag != 1) {
                    snakbarAlert(data.message);
                    $('.loaderClas').attr('style', 'display:block;');
                    setTimeout(function () {
                        window.location.href = data.Action;
                    }, 2500);
                }
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

function saveRcInfoData(formData)
{
   $.ajax({
        type: "POST",
        url: base_url + "RcCase/saveUpdateRcData",
        data: formData,
        dataType: 'json',
        success: function (response) {
			console.log(response);
			return false;
           	// alert(response);
            var data = $.parseJSON(response);
            
            if (data.status == 'true') {
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
 
/*$('#make').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url+"finance/getModel",
        data: {make: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#model').html(responseData);
            $('#versionId').html('<option value="">Select Version</option>');

        }
    });
    });
    
    $('#model').on('change', function () {
    var selected = $(this).val();
    var make     = $('#make').val();
    $.ajax({
        type: 'POST',
        url: base_url+"finance/getVersion",
        data: {model: selected,make:make},
        dataType: "html",
        success: function (responseData)
        {
            $('#versionId').html(responseData);

        }
    });
    });*/
    
$('#state').on('change', function () {
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url +"finance/getcities",
        data: {stateId: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#residence_city').html(responseData);
            $('#residence_city')[0].sumo.reload();

        }
    });
});
$('#corres_state').on('change', function () {
  //alert('hi');
    var selected = $(this).val();
    $.ajax({
        type: 'POST',
        url: base_url +"finance/getcities",
        data: {stateId: selected},
        dataType: "html",
        success: function (responseData)
        {
            $('#corres_city').html(responseData);
            $('#corres_city')[0].sumo.reload();

        }
    });
});

$("#instrument_type").change(function () {
 // alert('ggggg');
    if($("#instrument_type").val()=='1'){
        $("#divfcheque").show();
        $("#divtcheque").show();
        $(".bat").show();
        $(".hidestar").attr('style','display:inline-block;');
        $(".nor").show();
        $("#normalEntry").addClass('mrg-T10');
        $('#normalEntry').show();
        $("#batch").prop("checked", true);
    }else if(($("#instrument_type").val()=='4') || ($("#instrument_type").val()=='5') ){
        $("#divfcheque").hide();
        $("#divtcheque").hide();
        $("#batch").prop("checked", false);
        $(".bat").hide();
        $(".nor").hide();
         $(".hidestar").attr('style','display:none;');
        $("#normalEntry").removeClass('mrg-T10');
        $('#normalEntry').hide();
    }
    else{
        $("#divfcheque").hide();
        $("#divtcheque").hide();
        $("#batch").prop("checked", false);
        $(".bat").hide();
        $(".nor").hide();
        $(".hidestar").attr('style','display:inline-block;');
        $("#normalEntry").removeClass('mrg-T10');
        $('#normalEntry').hide();
    }
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
function isRoiNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && (charCode!=46))
        return false;
    return true;
}

$('#Cmobile,#Cname,#loan_amt,#roi,#tenor,#ref_phone_one,#ref_phone_two,#ref_name_two,#ref_name_one,#length_of_stay,#residence_pincode,#residence_phone').bind("cut copy paste",function(e) {
     e.preventDefault();
 });
 function blockSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    //alert(k);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 44 && k <= 57) && (k != 44));
}
function alphaOnly(evt) {
       evt = (evt) ? evt : event;
       var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
          ((evt.which) ? evt.which : 0));
       if (charCode > 32 && (charCode < 65 || charCode > 90) &&
          (charCode < 97 || charCode > 122)) {
           return false;
       }
       return true;
     }
function emiCheck(ev,f='',g='')
{            
      var case_id = $('#caseid').val();
      if((f=='') && (g==''))
        {
              var lid = $(ev).attr('id');
              var res = lid.split("_");
              var loanAmount = $('#floanamount_'+res[1]).val().replace(/,/g, '');
              addCommas($('#floanamount_'+res[1]).val(),'floanamount_'+res[1]);
              var numberOfMonths = $('#ftenor_'+res[1]).val();
              var rateOfInterest = $('#froi_'+res[1]).val();
              var bank_id = $('#loanbnk_'+res[1]).val();
              if((loanAmount!='') && (bank_id!=''))
              {
                //loanLimitCheck(bank_id,loanAmount,case_id);
              }
        }
        else if(g!='')
        {
              var lon = $('#loan_dis_amt').val();
              var loanAmount = $('#loan_dis_amt').val().replace(/,/g, '');
               addCommas($('#loan_dis_amt').val(),'loan_dis_amt');
              var numberOfMonths =  $('#dis_ten').val();
              var rateOfInterest = $('#dis_roi').val();
              $('#gross_loan').val(lon);
              $('#net_disburse').val(lon);
              chngloanamt('1');
        }
        else
        {
              var loanAmount = $('#loanamount').val().replace(/,/g, '');
               addCommas($('#loanamount').val(),'loanamount');
              var numberOfMonths =  $('#tenoramount').val();
              var rateOfInterest = $('#roiamount').val();
               if((loanAmount!='')){
              //loanLimitCheck(bank_id,loanAmount,case_id);
            }

        }
             if(g!=''){
              var loanAmount = $('#gross_loan').val().replace(/,/g, '');
             // alert(loanAmount);
             $('#counter_emi').val('0');
              $('#total_emi').val(0);
             }
            var monthlyInterestRatio = (rateOfInterest/100)/12;
            if((loanAmount!='') && (numberOfMonths!='') && (rateOfInterest!=''))
            {   
               var coun = rateOfInterest.split(".").length - 1  ;
               //alert(coun);
               if(coun<='1') {        
              emis = PMT(monthlyInterestRatio, numberOfMonths, loanAmount, 0, 0);
            //  alert(parseInt(Math.abs(emis)));
              emis = parseInt(Math.abs(emis));
              if((f=='') && (g==''))
              {
                  //alert('femi_'+res[1]);
                  //addCommas(emis,'femi_'+res[1]);
                  $('#femi_'+res[1]).val(emis);
                  $('#femi_'+res[1]).trigger('onkeydown');
              } 
              else if(g!='')
              {


                var counter_emi = $('#counter_emi').val();
               // alert(counter_emi);
                emis = PMT(monthlyInterestRatio, numberOfMonths, loanAmount, 0, counter_emi);
                emis = parseInt(Math.abs(emis));
                var t_emi = emis;
                
                if(parseInt(counter_emi)!=0){
                 var ab = t_emi*counter_emi;
                  $('#total_emi').val(ab);
                  $('#total_emi').trigger('onkeyup');
                  $('#total_emi').trigger('onchange');
                }  
                $('#dis_emi').val(emis);
                //$('#counter_emi').val('');

              }
              else{
                 //addCommas(emis,'emiamount');
                 $('#emiamount').val(emis);
              }
             }
            }
}
function PMT(ir, np, pv, fv, type='0') {
    /*
     * ir   - interest rate per month
     * np   - number of periods (months)
     * pv   - present value
     * fv   - future value
     * type - when the payments are due:
     *        0: end of the period, e.g. end of month (default)
     *        1: beginning of period
     */
    var pmt, pvif;
//alert('emis');
    fv || (fv = 0);
    type || (type = 0);

    if (ir === 0)
        return -(pv + fv)/np;

    pvif = Math.pow(1 + ir, np);
    pmt = - ir * pv * (pvif + fv) / (pvif - 1);

    if (type === 1)
        pmt /= (1 + ir);
//alert(pmt);
   return Math.round(pmt);
}




$('input:radio[name="entry"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'normal' && $("#instrument_type").val()=='1') {
            $("#divfcheque").show();
            $("#divtcheque").hide();
            $('.ceckfrom').text('Cheque Number');
            $('#cheque_from').attr('placeholder','Cheque Number');
        }else if($(this).is(':checked') && $(this).val() == 'batch' && $("#instrument_type").val()=='1'){
            $("#divfcheque").show();
            $("#divtcheque").show();  
        }
    });
 $("#employment_type").change(function () {
     if($("#employment_type").val()=='1'){
        $("#divsalaried").show();
         $('#offcdetail').attr('style','display:none');
        $("#empType").val('1');
     }else{
        $("#divsalaried").hide();
     }
     if($("#employment_type").val()=='2'){
         $("#divbusiness").show();
         $("#empType").val('2');
          $('#offcdetail').attr('style','display:block');
     }else{
         $("#divbusiness").hide();
     }
     if($("#employment_type").val()=='3'){
         $("#divprofession").show();
         $("#empType").val('3');
          $('#offcdetail').attr('style','display:block');
     }else{
         $("#divprofession").hide();
         //$("#divsalaried").hide();
     }
     if($("#employment_type").val()=='4'){
         $("#divothers").show();
         $("#empType").val('4');
          $('#offcdetail').attr('style','display:none');
     }else{
         $("#divothers").hide();
         //$("#divsalaried").hide();
     }
     
     
     
 });   


 function loanLimitCheck(bank,loanval,case_id)
    {
      $.ajax({
            type: 'POST',
            url: "/finance/getLoanLimit",
            data: {loanAmt: loanval,case_id:case_id,bank:bank},
            dataType: "json",
            success: function (responseData)
            {
                if(responseData.status=='0')
                {
                    snakbarAlert(responseData.msg);
                    //$('#decisionfile').attr('disabled','disabled');
                }
                else
                {
                    snakbarAlert(responseData.msg);
                    //$('#decisionfile').removeAttr('disabled');
                }
            }
        });
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
$('#deliveryDetailsButton').click(function () {
  
        var formData = $('#deliveryDetails').serialize();

        var err = loanDoValidation();
        if(err)
        {
        $('.error').attr('style','display:block');
        return err;
        }else{
        deliveryDetailsButton.disabled = "disabled"; 
        }
        saveDeliveryData(formData);

    });
$('#receiptDetailsButton').click(function () {
        var formData = $('#receiptDetails').serialize();
        var err = loanReceiptValidation();
        if(err)
        {
        $('.error').attr('style','display:block');
        return err;
        }
        saveDeliveryData(formData);

    });    
function saveDeliveryData(formData) {
    $.ajax({
        type: "POST",
        url: base_url + "saveDeliveryOrderData",
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
                snakbarAlert(data.message);
                return false;
            }
        }
    });
}


function getDealerDetails(){
    var dealerId=$('#showroomName').val();
  //var optionSelected = $("option:selected", this);
  //alert(optionSelected);
    if(dealerId.length > 0){
    $.ajax({
        type: "POST",
        url: base_url + "DeliveryOrder/dealerDetails",
        data: {dealerId:dealerId},
        //dataType: 'json',
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == 'True') {
                $('#showroom_address').val(data.message.address);
                $('#showroom_address').attr('readonly','readonly');
                $('#showroom_address').addClass('cr-form-read');
                $('#kind_attn').val(data.message.owner);
                return true;
            } else {
                return false;
            }
        }
    });
    }  
}
$('#showroomName').on('change', function() {
  var dealerId=$('#showroomName').val();
  if(dealerId.length > 0){
    $.ajax({
        type: "POST",
        url: base_url + "DeliveryOrder/dealerDetails",
        data: {dealerId:dealerId},
        //dataType: 'json',
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == 'True') {
                $('#showroom_address').val(data.message.address);
                $('#showroom_address').attr('readonly','readonly');
                $('#kind_attn').val(data.message.owner);
                return true;
            } else {
                return false;
            }
        }
    });
    }  
});

$('input:radio[name="loan_taken"]').change(function(){
    DoLoanChange();
});

function DoLoanChange(flagd = ''){
   
  var lo = $("input[name='loan_taken_from']:checked").val(); 
  var loan_taken = $("input[name='loan_taken']:checked").val();

 // alert('lo '+lo+' loan taken '+ loan_taken);
   var loan_filled = $("input[name='loan_filled']:checked"). val();
   if ($("input[name='loan_taken']").is(':checked') && loan_taken == '2'){
    //  alert('gggg');
     var disablee=$("#deliveryDetailsButton").is(":disabled");
     if(disablee) $('#deliveryDetailsButton').attr('disabled',false);
     $('.divfillloan').attr('style','display:none;');
     $('.divloanamount').attr('style','display:none;');
     $('.deductfromloandiv').attr('style','display:none;');
     $("#loan_amt").val('');
     $("#dedu_loan").val('');
     $("#sameasloan").attr("checked",false);
     $('.divloan').attr('style','display:none!important;');
     $('.divfill').hide();
     $('#hp_inhouse').attr('style','display:none');
      $('#hp_other').attr('style','display:none');
      $('#err_hp_to').attr('style','display:none');
     calculateNetAmount()
    }else{
     // $('#hp_inhouse').attr('style','display:block');
     // $('#hp_other').attr('style','display:none');
      $('.divfillloan').attr('style','display:block;');
      $('.divloanamount').attr('style','display:block;');
      $('.deductfromloandiv').attr('style','display:block;');
      if((lo=='2') && (loan_taken == '1'))
      {
        $("#hp_inhouse").attr('style','display:none;');
        $('#hp_other').attr('style','display:block');
        $('#hp_tos').val('');
       $('#hp_tos')[0].sumo.reload();
       $("#sameasloan").attr("checked",false);
       if(flagd != 1 ){
         $("#loan_amt").val('');
         $("#dedu_loan").val('');
       }
       $('.divloan').hide();
       $('.divfill').hide();
        $('#hypoto').val('0'); 
    
      }else if((lo=='1') && (loan_taken == '1'))
      {
    //  alert('gg');
      $('.divloan').show();
      if(loan_filled=='2')
      {
      //  alert('hhhh');
                $('.divloan').attr('style','display:none !important');

        }
        $('.divfill').show();
       $("#hp_inhouse").attr('style','display:block;');
       $('#hp_other').attr('style','display:none');
       $('#hp_to').val('');
      $('#hp_to')[0].sumo.reload();
        $('#hypoto').val('1'); 
        if(flagd == ''){
            $('#application_no').val('');
            $('#hp_to').val('');
            $('#hp_to')[0].sumo.reload();
        }

      }  
    $('#divfinance').show(); 
  
    }
    
}

$('input:radio[name="loan_taken_from"]').change(function(){
   var lo = $("input[name='loan_filled']:checked"). val();
    if($(this).is(':checked') && $(this).val() == '1'){

      $('#hp_inhouse').attr('style','display:block');
      $('#hp_other').attr('style','display:none');
      $('#hp_to').val('');
      $('#hp_to')[0].sumo.reload();

      $('.divfill').show();
      if(lo=='2')
      {
       $('.divloan').hide();
        $('#hypoto').val('0'); 
      }else if(lo=='1')
      {
          //alert('fffff');
        $('.divloan').show();
        $('#application_no').val('');
        $('#hp_to').val('');
        $('#hp_to')[0].sumo.reload();
         $('#hypoto').val('1');   
      }  
     $('#divfinance').show();
     
    }
    else
    {
       // alert('gggg');
      $('#hp_inhouse').attr('style','display:none');
      $('#hp_other').attr('style','display:block');
     $('#application_no').val('');
     $('#err_application_no').html('');
     $('.divloan').hide();
     $('.divfill').hide();
     //$('#kind_attn').val('');
     $('#hp_tos').val('');
     $('#hp_tos')[0].sumo.reload();
     //$('#color').val('');
     //$('#color')[0].sumo.reload();
     $('#showroomName').val('');
     $('#showroomName')[0].sumo.reload();
     $('#showroom_address').val('');
     $('#kind_attn').val('');
     $('#customer_mobile_no').val('');
     $('#customer_name').val('');
     $('#customer_address').val('');
     $('#make').val('');
     $('#model').val('');
     $('#model')[0].sumo.reload();
     $('#versionId').val('');
     $('#versionId')[0].sumo.reload();
     $('#color').val('');
     $('#color')[0].sumo.reload();
     $('#divfinance').show();   
      $('#hypoto').val('1'); 
    }
});

$('input:radio[name="loan_filled"]').change(function(){
 // alert('hi')
    if ($(this).is(':checked') && $(this).val() == '1'){
     // alert('yes')
     var disablee=$("#deliveryDetailsButton").is(":disabled");
     if(disablee) $('#deliveryDetailsButton').attr('disabled',false);
     $('#application_no').val('');
     $('#err_application_no').html('');
     $('#hypoto').val('1'); 
     $('.divloan').show();
     $('#loan_amt').attr('readonly','readonly');
     $('#hp_tos').attr('disabled','disabled');
     $('#dedu_loan').attr('readonly','readonly');
     
    // $('#divfinance').show(); // added by masawwar ali for loanfilled yes 
    }else{
     //alert('not yet');
     //$('#divfinance').hide(); // // added by masawwar ali for loanfilled not yet
     $('.divloan').hide();   
     $('#hp_to').val('');
     $('#hp_to')[0].sumo.reload();
     $('#showroomName').val('');
     $('#showroomName')[0].sumo.reload();
     $('#showroom_address').val('');
     $('#kind_attn').val('');
     $('#customer_mobile_no').val('');
     $('#customer_name').val('');
     $('#customer_address').val('');
     $('#make').val('');
     $('#model').val('');
     $('#model')[0].sumo.reload();
     $('#versionId').val('');
     $('#versionId')[0].sumo.reload();
     $('#color').val('');
     $('#color')[0].sumo.reload();
     $('#hypoto').val('0'); 
     $('#loan_amt').removeAttr('readonly');
     $('#hp_tos').prop('disabled', false);
     $('.sumo_hp_tos').removeClass(' disabled');
     $('#dedu_loan').removeAttr('readonly');

    
      

      
     //$('#hp_to').val('');
    // $('#hp_to')[0].sumo.reload();
    }
});

function addCommas(nStr,control,flag='')
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

function isRoiKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 45 || charCode == 47 || charCode > 57))
        return false;
    return true;
}

function blockAllSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    //alert(k);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k >= 44 && k <= 57));
}
$("#instrumentType").change(function () {
    $("#instrument_no").val('');
    if($("#instrumentType").val()=='2'){
       // $("#divinstno").hide();
        $(".abb").hide();
    }else{
      $(".abb").show(); 
       // $("#divinstno").show();     
    }
});

function loanReceiptNoValidate(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    //alert(k);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || ((k > 44 && k <= 57)) && (k!=46));
}

$("#instrumentType").change(function () {
    if($("#instrumentType").val()=='2'){
      $(".abb").hide(); 
        //$("#divinstno").hide();     
    }else{
      $(".abb").show(); 
        $("#divinstno").show();     
    }
});

/*$('#deliverySource').on('change', function () {
      if($('#deliverySource').val()=='1'){
        $('#divdealerName').show();
    }else{
        $('#divdealerName').hide();
    }
  });*/

$('#paymentBy').on('change', function () {
      if($('#paymentBy').val()=='2'){
        $('#divpaymentshowroom').show();
        $('#divpaymentdealer').hide();
    }else{
        $('#divpaymentdealer').show();
        $('#divpaymentshowroom').hide();
    }
  });
  $('input:radio[name="booking_done"]').change(function(){
    if ($(this).is(':checked') && $(this).val() == '1'){
     var disablee=$("#deliveryDetailsButton").is(":disabled");
     if(disablee) $('#deliveryDetailsButton').attr('disabled',false);
    // alert('hhjjj');
     $('#application_no').val('');
     $('#err_application_no').html('');
     $('.divbooking').show();
    }else{
     $('.divbooking').hide();   
    }
});

function getbookingDetails(){
    if($('input:radio[name="booking_done"]').is(':checked')==false){
      alert("Please Select Advance Booking done before");
      return false;  
    }
    var booking_slip_no=$('#booking_slip_no').val();
    $('#err_booking_slip_no').html('');
    if(booking_slip_no.length > 0){
    $.ajax({
        type: "POST",
        url: base_url + "DeliveryOrder/bookingDetails",
        data: {booking_slip_no:booking_slip_no},
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == 'True') {
                 $('#showroomName').val(data.message.showroom_id);
                $('#showroomName')[0].sumo.reload();
                //$("#showroomName option:selected").text(data.message.showroomName);
                $("#kind_attn").val(data.message.kind_attn);
                //$("#color option:selected").text(data.message.colorName);
                $('#showroom_address').val(data.message.outlet_address);
                $('#customer_name').val(data.message.customer_name);
                $('#customer_mobile_no').val(data.message.customer_mobile_no);
                $('#customer_address').val(data.message.customer_address);
        $('#color').val(data.message.colorName);
                $('#color')[0].sumo.reload();
                $('#make').val(data.message.make);
                getModelJs(data.message.make,data.message.model,data.message.version);

        // alert(data.message.showroom_id);
                $('#deliverySource').val(data.message.source);
                $('#deliverySource')[0].sumo.reload();
                //$("#deliverySource option:selected").text(data.message.sourceName);
                $("#kind_attn").val(data.message.kind_attn);
                if(data.message.source=='1'){
                $('#divdealerName').show();    
                $('#dealerName').val(data.message.dealer_id);
                $('#dealerName')[0].sumo.reload();
                //$("#dealerName option:selected").text(data.message.dealerName);
                $('#deliveryTeam').val(data.message.emp_id);
                $('#deliveryTeam')[0].sumo.reload();
                }else if(data.message.source=='2'){
                $('#divdealerName').hide();  
                $('#deliveryTeam').val(data.message.emp_id);  
                 $('#deliveryTeam')[0].sumo.reload();
                $('#deliverySales').val(data.message.emp_id);
                 $('#deliverySales')[0].sumo.reload();
                //$("#deliverySales option:selected").text(data.message.execName);
                var disablee=$("#deliveryDetailsButton").is(":disabled");
                if(disablee) $('#deliveryDetailsButton').attr('disabled',false);
                if(data.message.financer > 0){
                $('#divfinance').hide();
                $('#hypoto').val('0');
                }else{
                 $('#divfinance').show();
                 $('#hypoto').val('1');
                }
                $('#err_application_no').html('');
                return true;
            } else {
                //$('#make').val('');
                //$("#make option:selected").text('Select Make');
                $('#model').val('');
                $('#model')[0].sumo.reload();
               // $("#model option:selected").text('Please Select');
                $('#versionId').val('');
                $('#versionId')[0].sumo.reload();
               // $("#versionId option:selected").text('Please Select');
                $('#deliveryDetailsButton').attr('disabled','disabled');
                $('#divfinance').show();
                $('#hypoto').val('0');
                $('#err_booking_slip_no').html('Booking Slip No not Exist');
                return false;
            }
        }
      }
    });
    }else{
        $('#err_booking_slip_no').html('');
    }
}
  
function getloanDetails(){
    var loanId=$('#application_no').val();
    $('#err_application_no').html('');
    if(loanId.length > 0){
    $.ajax({
        type: "POST",
        url: base_url + "DeliveryOrder/loanDetails",
        data: {loanId:loanId},
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == 'True') {
                $('#customer_name').val(data.message.customer_name);
                $('#customer_mobile_no').val(data.message.customer_mobile_no);
                $('#customer_address').val(data.message.customer_address);
                $('#make').val(data.message.make);
                $('#loan_amt').val(data.message.loan_amt);
                $('#dedu_loan').val(data.message.totalDeductions);
                getModelJs(data.message.make,data.message.model,data.message.version);
                //alert(data.message.showroom_id);
                var disablee=$("#deliveryDetailsButton").is(":disabled");
                if(disablee) $('#deliveryDetailsButton').attr('disabled',false);
                if(data.message.financer == 0){
                $('#divfinance').hide();
                $('#hypoto').val('0');

                }else{
                 $('#divfinance').show();
                 $('#hypoto').val('1');
                 //$('#hp_tos').prop('disabled', false);
                 $('#hp_tos_hidden').attr('style','display:block;');  
                 $('#hp_tos_hidden').val(data.message.financer);  
                 $('#hp_tos').val(data.message.financer);
                 $('#hp_tos')[0].sumo.reload();
                }
                $('#err_application_no').html('');
                return true;
            } else {
                $('#make').val('');
                $('#model').val('');
                $('#versionId').val('');
                $('#deliveryDetailsButton').attr('disabled','disabled');
                $('#divfinance').show();
                $('#hypoto').val('0');
                $('#err_application_no').html('Loan application No. not Exist');
                return false;
            }
        }
    });
    }else{
        $('#err_applicant').html('');
        $('#make').val('');
        $('#model').val('');
        $('#model')[0].sumo.reload();
        $('#versionId').val('');
        $('#versionId')[0].sumo.reload();
        $('#deliveryDetailsButton').attr('disabled','disabled');
        $('#divfinance').show();
        $('#hp_to').val('');
        $('#hp_to')[0].sumo.reload();
        $('#hypoto').val('0');
        $('#showroomName').val('');
        $('#showroomName')[0].sumo.reload();
        $('#showroom_address').val('');
        $('#customer_name').val('');
        $('#customer_mobile_no').val('');
        $('#customer_address').val('');
        $('#kind_attn').val('');
        $('#color').val('');
        $('#color')[0].sumo.reload();
    }
}

function saveBookingInfoData(formData)
{
    
   $.ajax({
        type: "POST",
        url: base_url + "DeliveryOrder/saveBookingInfoData",
        data: formData,
        //dataType: 'json',
        success: function (response) {
            var data = $.parseJSON(response);
            console.log(data);
            if (data.status == 'True') {
                snakbarAlert(data.message);
                $('.loaderClas').attr('style','display:block;');                 
                setTimeout(function () {
                    $('#advbookingButton').attr("disabled",false);
                    window.location.href =data.Action;
                }, 2500);

                return true;
            } else {
                 $('#advbookingButton').attr("disabled",false);
                snakbarAlert(data.message);
                return false;
            }
        }
    });
}

function confsaveloan(sav)
{
  if(sav=='1')
  { 
    var formId = $('#frmids').val();
    var formData = $('#'+formId).serialize();
    saveCaseInfoData(formData);
    $('#loanPop').removeClass('in');
    $('#loanPop').attr('style','display:none;');
  }
  else
  {
    $('#loanPop').removeClass('in');
    $('#loanPop').attr('style','display:none;');
  }
}

function xClose()
{
  $('#loanPop').removeClass('in');
  $('#loanPop').attr('style','display:none;');
}



  $('#refurbButton').click(function(){
        var formData=$('#refurb_work').serialize();
        var err = refurbWorkshopErr();
        if(err)
        {
          $('.error').attr('style','display:block');
          return err;
        }
         saveRefurbData(formData);
   });

  function saveRefurbData(formData)
{
   $.ajax({
        type: "POST",
        url: base_url + "DeliveryOrder/saveRefurbInfoData",
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
                snakbarAlert(data.message);
                return false;
            }
        }
    });
}

function getModelJs(make,model,version)
{
   $.ajax({
        type: 'POST',
        url: base_url +"finance/getMakeModelIdName",
        data: {make: make},
        dataType: "html",
        success: function (responseData)
        {
         // alert(responseData);
            $('#model').html(responseData);
            $('#versionId').html('<option value="">Select Version</option>');
            setTimeout(function () {
                   $('#model').val(model);
                   $('#model')[0].sumo.reload();
                }, 200);
            getVersionJs(make,model,version);
        }
    });
}

function getVersionJs(make,model,version)
{
   $.ajax({
        type: 'POST',
        url: base_url+"finance/getVersion",
        data: {model: model,make:make,flag:'1'},
        dataType: "html",
        success: function (responseData)
        {
         // alert(responseData);
            $('#versionId').html(responseData);
            setTimeout(function () {
                   $('#versionId').val(version);
                   $('#versionId')[0].sumo.reload();

                }, 200);

        }
    });
}

$('#coapplicantDetailButton').click(function () {
       $("#coapplicantDetailButton").attr("disabled", true);
        var formData=$('#coapplicantForm').serialize();
        var err = coapplicantForm();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#coapplicantDetailButton").attr("disabled", false);
          return err;
        }
        saveCaseInfoData(formData);
        $("#coapplicantDetailButton").attr("disabled", false);

    });

    $('#guarantorDetailButton').click(function () {
       $("#guarantorDetailButton").attr("disabled", true);
        var formData=$('#guarantorForm').serialize();
        var err = guarantorForm();
        if(err)
        {
          $('.error').attr('style','display:block');
          $("#guarantorDetailButton").attr("disabled", false);
          return err;
        }
        saveCaseInfoData(formData);
        $("#guarantorDetailButton").attr("disabled", false);

    });
