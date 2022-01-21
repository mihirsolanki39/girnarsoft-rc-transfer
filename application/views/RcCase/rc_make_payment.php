<div id="content">
<style>
    .process-step .btn:focus{outline:none}
    .process{display:table;width:70%;position:relative; margin-bottom: 20px}
    .process-row{display:table-row}
    .process-step button[disabled]{opacity:1 !important;filter: alpha(opacity=100) !important}
    .process-row:before{top: 21px;bottom: 0;position:absolute;content:" ";width:15%;height:2px;border-bottom: 2px dashed #a0a0a0;left: 28%;}
    .process-step{display:table-cell;text-align:left;position:relative; padding-left: 20px;}
    .process-step p{margin-top:4px}
    .btn-circle{width:30px;height:30px;text-align:center;font-size:14px;border-radius:50%}
    .process-step .btn:focus {border-radius:50%;background-color: #e86335 !important; border: none; padding:3px; text-align: center;color: #fff !important;}
    .process-step .text-heading{font-size: 16px;display: inline-block; vertical-align: sub; margin-left: 10px}
    .process-step .btn { padding: 3px;background-color: #ffffff;color: #ec6140; border: 1px solid #ec6140;}
    #payout-total .bg-box{background: #fff; margin-top: 50px;padding: 15px;}
    #payout-total .bg-box table{border:none;}
    #payout-total .bg-box .table-bordered>tbody>tr>td{border:none; padding: 10px 0px;}
    #payout-total .bg-box .table-bordered>tbody>tr>td .cases{font-size: 18px; color: #000000; opacity: 0.87; padding: 0px}
    #payout-total .bg-box .table-bordered>tbody>tr>td .cases1{font-size: 18px; color: #000000; opacity: 0.87; text-align: right}
    #payout-total .table-hover>tbody>tr:nth-child(even):hover, #payout-total .table-hover>tbody>tr:nth-child(odd):hover {background-color: #ffffff !important;}
    .mrg-B20 { margin-bottom: 20px !important;}
    .spacers-t{border-top:1px solid #ddd; padding: 10px 0px}
    .netpayout-t td{color:#000000;}
    #payoutTable .arrow-details{display:block;margin-bottom:10px;text-transform:none;padding:0px 7px 2px;}
    
    .select-color{color: #e46536;}
    .dot-sep { content: ""; height: 4px; width: 4px; background: rgba(0,0,0,0.3); border-radius: 15px; display: inline-block; margin: 3px 7px;}

       


    </style>
    <?php
    $rtoagent = '';
    if(!empty($rc_case_details))
    {
      $rtoagent = $rc_case_details[0]['rto_agent'];
      $totalcases = count($rc_case_details);
    }
    ?>
  <div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <div class="row">
      <div id="payment_stock_div" class="">
          <div class="col-md-9">
              <div class="row">
                <div class="process">
               <div class="process-row nav nav-tabs">
                <div class="process-step">
                 <button type="button" id="rtoag" class="btn btn-info btn-circle" data-toggle="tab" href="#menu1">1</button>
                 <p class="text-heading select-color">Select RC Case</p>
                </div>
                <div class="process-step">
                 <button type="button" class="btn btn-default btn-circle pay_Details" data-toggle="tab" href="#<?=!empty($rc_case_details)?'menu2':''?>">2</button>
                 <p class="text-heading">Payments Details</p>
                </div>
               </div>
              </div>
                <div class="tab-content">
                   <div id="menu1" class="tab-pane fade active in">
                       <div class="col-md-12">
                           <div class="cont-spc pad-all-20" id="buyer-lead">
                              
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Select RTO Agent</label>
                                         <select class="form-control crm-form testselect1" name="agentrto" id="agentrto">
                                             <option value="0">Select</option>
                                           <?php foreach ($rtoList as $key=>$value){ ?>
                                             <option value="<?=$value['id']?>" <?=(!empty($rtoagent) && ($value['id']==$rtoagent))?'selected="selected"':''?>><?=$value['name']?></option>
                                           <?php } ?>
                                         </select>
                                    </div>

                                    <div class="col-md-3 searchcases" style="display:none;">
                                        <label>Search</label>
                                        <input class="form-control" placeholder="Customer/Reg No." id="search" name="search" value="">
                                    </div> </div>
                       
                        </div>
                       
                            <div class="col-lg-12 col-md-12" id="payoutTable">
                             <form role="form" name="searchform1" id="searchform1">
                              <div class="row">
                                <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl border-T mrg-B20">
                                     <thead>
                                        <tr>
                                           <th width="5%">Select</th>
                                           <th width="21%">Customer Details</th>
                                           <th width="22%">Car Details</th>
                                           <th width="22%">RC Details</th>
                                           <th width="15%">RTO Charges</th>
                                        </tr>
                                     </thead>
                                     <tbody id="casedetails">
                                      </tbody>
                                  </table>
                                </div>
                               </div>
                            </div>
                       </div></form>
</div>


                   <div id="menu2" class="tab-pane fade">
                   <form role="form" name="searchform3" id="searchform3">
                   <?
                   if(!empty($rc_case_details))
                      {
                        $paymentDetails = $rc_case_details[0];
                        $totalamt = !empty($total_rc_amt)?$total_rc_amt:'';
                        foreach ($rc_case_details as $rkey => $rvalue) {
                          $all_rc_ids=$rvalue['rc_id'].',';
                        }
                        $all_rc_ids = substr(trim($all_rc_ids), 0, -1);
                      }
                   ?>
                    <div class="col-md-12 mrg-B40">
                         <div class="white-section">
                            <div class="row">
                               <div class="col-md-12">
                                 <h2 class="sub-title mrg-T0">Payment Details</h2>
                                </div>
                                <div class="col-md-6">
                                 <div class="form-group">
                              <label class="crm-label">Payment Mode *</label>
                                    <select class="form-control" name="payment_mode" id="payment_mode">
                                      <option value="0">Select</option>
                                      <option value="1" <?=(!empty($paymentDetails['rc_pay_mode']) && ($paymentDetails['rc_pay_mode']=='1'))?'selected="selected"':''?>> Cash</option>
                                      <option value="2" <?=(!empty($paymentDetails['rc_pay_mode']) && ($paymentDetails['rc_pay_mode']=='2'))?'selected="selected"':''?>> Cheque</option>
                                      <option value="3" <?=(!empty($paymentDetails['rc_pay_mode']) && ($paymentDetails['rc_pay_mode']=='3'))?'selected="selected"':''?>> DD</option>
                                      <option value="4" <?=(!empty($paymentDetails['rc_pay_mode']) && ($paymentDetails['rc_pay_mode']=='4'))?'selected="selected"':''?>> Online</option>
                                    </select>
                                </div>  
                                 <div class="error" id="paymode_error"></div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                     <label for="" class="crm-label">Amount</label>
                                     <input type="text" class="form-control crm-form rupee-icon " name="rc_amt" id="rc_amt" value="<?=(!empty($total_rc_amt))?$total_rc_amt:''?>" readonly="readonly">
                                     <div class="error" id="err_amt"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label for="" class="crm-label">Payment Date *</label>
                                      <div class="input-group date" id="dp2">
                                        <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydates" name="paydate" autocomplete="off" value="<?=((!empty($paymentDetails['paydates']) && ($paymentDetails['paydates']!='0000-00-00'))?date('d-m-Y',strtotime($paymentDetails['paydates'])):'')?>" readonly placeholder="Payment Date">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                            </span>
                                        </span>
                                    </div>
                                  </div>
                                   <div class="error" id="paydate_error"></div>
                               </div>
                                <div class="col-md-6" id="ins_show">
                                    <div class="form-group">
                                     <label for="" class="crm-label">Instrument Number</label>
                                     <input type="text" class="form-control crm-form" name="instrument_no" id="instrument_no" value="<?=(!empty($paymentDetails['instrument_no']))?$paymentDetails['instrument_no']:''?>" maxlength="9">
                                     <div class="error" id="err_instrument_no"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="insd_show">
                                   <div class="form-group">
                                      <label for="" class="crm-label">Instrument Date</label>
                                      <div class="input-group date" id="dp2">
                                        <input type="text" class="form-control payment_date crm-form crm-form_1" id="instrument_date" name="instrument_date" autocomplete="off" value="<?=((!empty($paymentDetails['instrument_date']) && ($paymentDetails['instrument_date']!='0000-00-00'))?date('d-m-Y',strtotime($paymentDetails['instrument_date'])):'')?>" readonly placeholder="Instrument Date">
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                            </span>
                                        </span>
                                    </div>
                                  </div>
                                   <div class="error" id="instdate_error"></div>
                               </div>
                                <div class="col-md-6" id="bnk_show">
                                    <div class="form-group">
                                     <label class="crm-label">Bank Name</label>
                                           <select class="form-control crm-form testselect1" id="payment_banks" name="payment_bank">
                                          <option value="">Select Bank</option>
                                           <?php
                                          if(!empty($cusbanklist)){
                                               foreach($cusbanklist as $ckey => $cval){ ?>
                                               <option value="<?=$cval['bank_id']?>" rel="<?=$cval['bank_name']?>" <?=((!empty($paymentDetails['paybnk']) && ($paymentDetails['paybnk']==$cval['bank_id']))?'selected="selected"':'')?>><?=$cval['bank_name']?></option>
                                             <?php } }?>
                                      </select>
                                     <div class="error" id="bnk_error"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="fav_show">
                                  <div class="form-group">
                                     <label for="" class="crm-label">Favouring</label>
                                     <input type="text" class="form-control crm-form" name="favouring" id="favouring" value="<?=(!empty($paymentDetails['favouring']))?$paymentDetails['favouring']:''?>">
                                  </div>
                               </div>
                                <div class="col-md-6" id="rem_show">
                                    <div class="form-group">
                                     <label for="" class="crm-label">Remark</label>
                                     <input type="text" class="form-control crm-form" name="remark" id="remark" value="<?=(!empty($paymentDetails['remark']))?$paymentDetails['remark']:''?>">
                                     <div class="error" id="err_remark"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="all_rc_ids" value="<?=(!empty($all_rc_ids)?$all_rc_ids:'')?>" id="all_rc_ids">
                                <input type="hidden" name="totalrccase" value="<?=(!empty($totalcases))?$totalcases:''?>" id="totalrccase">
                                <input type="hidden" name="totalrcamt" value="<?=(!empty($totalamt))?$totalamt:''?>" id="totalrcamt">
                                 <input type="hidden" name="pay_id" value="<?=!empty($rc_case_details[0]['payment_id'])?$rc_case_details[0]['payment_id']:'0'?>" id="pay_id">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">
                                            <button type="button" class="btn-continue width100" id="rcDetailspay" onclick="rcAmtSave();">SAVE DETAILS</button>
                                        </div>
                                    </div>
                                </div>
                             </div>
                            </div>
                        </div>
                   </div>
                </div>
              </div>
              </form>
          </div>
          
          <div class="col-md-3 pad-L5" id="payout-total">
              <div class="">
                  <div class="bg-box">
                    <table class="table table-bordered table-striped table-hover enquiry-table mytbl border-T font-13">
                         <tbody>
                            <tr>
                                <td style="width:60%"></td>
                                <td style="width:40%"><div class="cases1"></div></td>
                             </tr>
                             <tr class="netpayout-t font-16">
                                 <td colspan="2"><span id="totalcase"><?=$totalcases?></span> Cases Selected</td>
                             </tr>
                             <tr class="netpayout-t">
                                 <td>Payable Amount</td>
                                 <td><div class="text-right"><i class="fa fa-rupee"></i> &nbsp;<span id="totalpay"><?=$totalamt?></span></div></td>
                             </tr>
                             <tr>
                                 <td colspan="2"><button type="button" class="btn-continue" id="deliveryDetailsButton" data-toggle="tab" href="#<?=!empty($rc_case_details)?'menu2':''?>">PROCEED</button></td>
                             </tr>
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
        
            </div>
   </div>
   <!-- /End Search Filter -->
  </div>
</div>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  $('#agentrto').change(function() {
      
  var rto_agent = $('#agentrto').val();
  var pay_id = $('#pay_id').val();
  if((pay_id==undefined) || (pay_id==''))
    pay_id=0;
  if(rto_agent=='0')
  {
      $('#casedetails').html('');
      $("#search").val("");
       $(".searchcases").css("display","none");
  }
  else
  {
     $.ajax({
            url: base_url+"RcCase/ajax_getrtocaselist",
            type: 'post',
            dataType: 'html',
            data: {rtoagent:rto_agent,flag:pay_id},
            success: function (responseData, status, XMLHttpRequest) {
              $('#casedetails').html(responseData);
              $(".searchcases").css("display","block");
              if(pay_id=='')
              {
                $("#totalpay").html("0");
                $("#totalcase").html("0")
                $('#totalrcamt').val("0");
                $('#all_rc_ids').val('');
                $('#rc_amt').val("0");                 
              }
           }
        });
  }
});

    $('#payment_mode').change(function() {
      var payment_mode = $('#payment_mode').val();
          $('#instrument_no').val('');
          $('#instrument_date').val('');
          $('#payment_banks').val('');
          $('#payment_banks')[0].sumo.reload();;
          $('#favouring').val('');
      if(payment_mode=='1')
      {
          $('#ins_show').attr('style','display:none');
          $('#insd_show').attr('style','display:none');
          $('#bnk_show').attr('style','display:none');
          $('#fav_show').attr('style','display:none');
          $('#rem_show').attr('style','display:block');
      }
      if(payment_mode=='2')
      {
          $('#ins_show').attr('style','display:block');
          $('#insd_show').attr('style','display:block');
          $('#bnk_show').attr('style','display:block');
          $('#fav_show').attr('style','display:block');
          $('#rem_show').attr('style','display:block');
      }
      if(payment_mode=='3')
      {
          $('#ins_show').attr('style','display:block');
          $('#insd_show').attr('style','display:block');
          $('#bnk_show').attr('style','display:block');
          $('#fav_show').attr('style','display:block');
          $('#rem_show').attr('style','display:block');
      }
      if(payment_mode=='4')
      {
          $('#ins_show').attr('style','display:block');
          $('#insd_show').attr('style','display:none');
          $('#bnk_show').attr('style','display:none');
          $('#fav_show').attr('style','display:none');
          $('#rem_show').attr('style','display:block');
      }
    });

  /*function bankname(ths)
  {
     var bankid = $(ths).val();
     alert(bankid);
  }*/

function getSelectedCases(id)
{
  var all_rc_id = $('#all_rc_ids').val();
  //alert(all_rc_id);

  if(all_rc_id!=''){
    var arr=all_rc_id.split(',');
  }
  else
  {
    var arr = new Array();
  }
  var totalcase = $('#totalcase').text();
  var totalpay = $('#totalpay').text().replace(/,/g,'');
  var rtoamt = $('#rtoamt_'+id).val().replace(/,/g,'');
  if(totalcase=='')
    totalcase=0;
  if(totalpay=='')
    totalpay=0;
  if(rtoamt=='')
    rtoamt=0;
  var abe = $('input:checkbox[name=rtoid_'+id+']').is(':checked');
  if(abe==true)
  {
    $("#rto_"+id).val('1');
    totalcase = parseInt(totalcase)+1;
    
    totalpay = parseInt(totalpay)+parseInt(rtoamt);
    arr.push(id);
    $('#rtoamt_'+id).removeAttr('readonly');
  }
  else
  {
    $("#rto_"+id).val('0');
    totalcase = parseInt(totalcase)-1;

    //$('#rtoamt_'+id).val('');
    $('#rtoamt_'+id).attr('readonly','readonly');
    totalpay = parseInt(totalpay)-parseInt(rtoamt);
    arr = jQuery.grep(arr, function(value) {
      return value != id;

    });
  }
  if(totalcase>0)
 {
   $('#deliveryDetailsButton').attr('href','#menu2');
   $('.select-color').removeClass(' select-color');
   $('.pay_Details').addClass(' select-color');
 }
 else
 {
   $('#deliveryDetailsButton').attr('href','#');
   $('.pay_Details').removeClass(' select-color');
 }
  all_rc_id=arr.join(',');
  $('#totalcase').html(totalcase);
  var totalpay_com = indianform(totalpay);
 //$('#totalpay').html(totalpay);
  $('#totalrccase').val(totalcase);
  $('#totalrcamt').val(totalpay);
  $('#all_rc_ids').val(all_rc_id);
  $('#rc_amt').val(totalpay_com);
}
$('#deliveryDetailsButton').click(function(){
   $('.select-color').removeClass(' select-color');
  // alert('g');
   $('.pay_Details').next('.text-heading').addClass(' select-color');
});
function rcAmtSave()
{
  var payment_mode = $('#payment_mode').val();
  var rc_amt = $('#rc_amt').val();
  var paydates = $('#paydates').val();
  var instrument_no = $('#instrument_no').val();
  var instrument_date = $('#instrument_date').val();
  var payment_banks = $('#payment_banks').val();
  var favouring = $('#favouring').val();
  var remark = $('#remark').val();
  var all_rc_ids = $('#all_rc_ids').val();
  var totalrccase = $('#totalrccase').val();
  var totalrcamt = $('#totalrcamt').val();
  var newamt = '';
  var arr = all_rc_ids.split(',');
  var pay_id = $('#pay_id').val();

      var error               = 0;
      $(".error").html("");
      if(payment_mode == '0'){
        $("#paymode_error").html("Please select Payment Mode.");
        error++;
      }
      if(paydates == ''){
        $("#paydate_error").html("Please select payment date.");
        error++;
      }

      if(error>0)
      {
         return false;
      }
  if(arr[0]!='')
  {    
    jQuery.each( arr, function( i, val ) 
    {
      newamt +=val+':'+$("#rtoamt_"+val).val().replace(/,/g,'')+',';
    });
  } 
  $.ajax({
            url: base_url+"RcCase/save_rcpay_details",
            type: 'post',
            dataType: 'json',
            data: {payment_mode:payment_mode,rc_amt:rc_amt,paydates:paydates,instrument_no:instrument_no,instrument_date:instrument_date,payment_banks:payment_banks,favouring:favouring,remark:remark,all_rc_ids:all_rc_ids,totalrccase:totalrccase,totalrcamt:totalrcamt,newamt:newamt,pay_id:pay_id},
            success: function (responseData, status, XMLHttpRequest) 
            {
              if(responseData.status=='1')
              {
                  
                 window.location.href = base_url+"rcListing/4";

              }
              else
              {
                alert('Something is wrong! Please try again.  ');
              }
            }
        });
}

function addAmount(id)
{
  var all_rc_id = $('#all_rc_ids').val();
  var arr = all_rc_id.split(',');
  var amt = $('#rtoamt_'+id).val().replace(/,/g,'');
  totalpay=0;
  if((amt=='') || (amt==undefined))
  amt=0;
  if(arr[0]!='')
  {
    jQuery.each( arr, function( i, val ) 
    {
      newamt = $("#rtoamt_"+val).val().replace(/,/g,'');
      if(newamt=='')
      {
        
        newamt=0;
      }
        
      totalpay = parseInt(totalpay)+parseInt(newamt);
    });
  } 
  else
  {  
   totalpay = parseInt(amt);
  }
  var totalpay_com =  indianform(totalpay);
  $('#totalrcamt').val(totalpay);
  $('#rc_amt').val(totalpay_com);
}
var d = "<?=date('dd-mm-yyyy')?>";
          $('#paydates').datepicker({
              format: 'dd-mm-yyyy',
              endDate:'d',
              autoclose: true,
              todayHighlight: true   
          });
          $('#instrument_date').datepicker({
              format: 'dd-mm-yyyy',
              autoclose: true,
              todayHighlight: true   
          });

function searchRcDetails()
{
  var search = $('#search').val();
  var rto_agent = $('#agentrto').val();
  var pay_id = $('#pay_id').val();
    $("#totalpay").html("0");
    $("#totalcase").html("0")
    $('#totalrcamt').val("0");
    $('#all_rc_ids').val('');
    $('#rc_amt').val("0");
  if(rto_agent=='0')
  {
    alert('Please select RTO Agent');
    return false;
  }
  if(search=='')
  {
    alert('Please enter search');
    return false;
  }
  $.ajax({
            url: base_url+"RcCase/ajax_getrtocaselist",
            type: 'post',
            dataType: 'html',
            data: {rtoagent:rto_agent,search:search,flag:pay_id},
            success: function (responseData, status, XMLHttpRequest) {
              $('#casedetails').html(responseData);
           }
        });
}
//$('#search').keypress(function(event){
//    var keycode = (event.keyCode ? event.keyCode : event.which);
//    if(keycode == '13'){
//      searchRcDetails();
//    }
//});
function addCommastoList(){
         $("#casedetails").find(".rto_amount").each(function(){
                 var id = $(this).attr('id');
                var val = $("#"+id).val();  
               var val_Comma = convertToIndianCurrency(val, id,'','1','1');
                $("#"+id).val("");
                $("#"+id).val(val_Comma);
            })
    }
$( document ).ready(function() {
//    $(".pay_Details").click(function(){
//        $("#deliveryDetailsButton").css("display","none");
//    })

    $("#deliveryDetailsButton").click(function(){
      if($("#totalpay").text() != 0){
        $("#deliveryDetailsButton").css("display","none");
      }
    })
    $("#rtoag").click(function(){
        $("#deliveryDetailsButton").css("display","block");
    })
  addCommastoList();
    var abc = $('#totalpay').text().replace(/,/g,'');
    indianform(abc);
});
  function indianform(x)
            {
              x=x.toString();
              var lastThree = x.substring(x.length-3);
              var otherNumbers = x.substring(0,x.length-3);
              if(otherNumbers != '')
                  lastThree = ',' + lastThree;
              var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
              $('#totalpay').text(res);
              return res;
            }
  function convertToIndianCurrency(nStr,control,flag='',flag1 ='',flag2='')
  {
        if(flag==1){
            nStr=nStr.replace(/,/g,'');
        }else
        {
            nStr=nStr;
        }     
        x=nStr.toString();
        var afterPoint = '';
        if(x.indexOf('.') > 0)
           afterPoint = x.substring(x.indexOf('.'),x.length);
        x = Math.floor(x);
        x=x.toString();
        var lastThree = x.substring(x.length-2);
        var otherNumbers = x.substring(0,x.length-2);
        if(flag2!='')
        {
         //    alert('gg');
          var lastThree = x.substring(x.length-3);
          var otherNumbers = x.substring(0,x.length-3);
        }
        if(otherNumbers != '')
            lastThree = ',' + lastThree;
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
       // alert(nStr+'-'+control+'-'+res);
         if(flag1 == 1)
            return res;
        else
            document.getElementById(control).value=res;
  }
  
 $(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#casedetails tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<?if(!empty($rc_case_details))
    {?>
      <script>
         $('#agentrto').trigger('change');
      </script>
      
   <? }?>