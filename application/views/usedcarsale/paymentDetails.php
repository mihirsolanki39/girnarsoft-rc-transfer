<div class="container-fluid">
<style>
    .tb-new-d {
    float: left;
    width: calc(97%) !important;}
</style>
 <div class="row">
      <div class="clearfix new-d">
     <div class="col-lg-12 col-md-12 mrgBatM clearfix pad-R15 pad-L15" id="topSection">
               <div class="background-efOne background-efTwo bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o">Payment Summary</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                               <a href="javascript:void(0);">
                                 <p class="font-36 col-green"><span class="font-18"> ₹ </span> <span id="purchaseamt"><?= !empty($total_sale_amount)?indian_currency_form($total_sale_amount):'0' ?></span></p>
                                 <p class="font-18 col-black-o">Sale Amount</p>
                              </a>
                           </div>
                           <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                              <a href="javascript:void(0);">
                                 <p class="font-36 col-yellow"><span class="font-18"> ₹ </span>  <span id="amtPaid"><?= !empty($amount_paid)?indian_currency_form($amount_paid):'0' ?></span></p>
                                 <p class="font-18 col-black-o">Amount Paid</p>
                              </a>
                           </div>
                           <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                              <a href="javascript:void(0);">
                                 <p class="font-36 col-red"><span class="font-18"> ₹ </span>   <span id="leftPaid"><?= !empty($balance_amount_left)?indian_currency_form($balance_amount_left):'0' ?></span></p>
                                 <p class="font-18 col-black-o">Left Amount</p>
                              </a>
                           </div> 
                            


                        </div>
                     </div>
                  </div>
               </div>
            </div>
      <div class="container-fluid mrg-all-15 tb-new-d" style="<?=!empty($amount_paid)?'display:block;':'display:none;'?>">
            <div class="row">
      <div class="">
         <div class="background-ef-tab" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                     <h5 class="cases pad-L0">Payment Details</h5>
                   </div> 
              </div>
               <!-- Tab panes -->
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                     <div class="container-fluid ">
                        <div class="row">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                                 <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover enquiry-table mytbl mrg-B10">
                                       <thead>
                                          <tr>
                                             <th>Sr. No</th>
                                             <th>Amt. Recvd.</th>
                                             <th>Payment Mode</th>
                                             <th>Date of Payment</th>
                                             <th>Instrument Date</th>
                                             <th>Instrument No.</th>
                                             <th>Bank Name</th>
                                             <th>Remarks</th>
                                             <th>Action</th>
                                             
                                          </tr>
                                       </thead>
                                       <tbody>
                                       <?php  if(!empty($paymentData)){
                                        $j = 1;
                                          foreach($paymentData as $key => $val){
                                              if(!empty($val['amount'])){?>
                                        <tr>
                                          <td><?=$j?></td>
                                          <td><?=(!empty($val['amount'])?'<span> ₹ </span> '.indian_currency_form($val['amount']):'')?></td>
                                          <td><?=(!empty($val['instrument_type']))?$val['instrument_type']:''?></td>
                                          <td><?=(!empty($val['payment_date'])?date('d M, Y',strtotime($val['payment_date'])):'')?></td>
                                          <td><?=(($val['instrument_type']!='cash' && !empty($val['instrument_date']) &&  $val['instrument_date']!='0000-00-00 00:00:00' && !in_array(date('d-m-Y',strtotime($val['instrument_date'])), ['01-01-1970']))?date('d M, Y',strtotime($val['instrument_date'])):'')?></td>
                                          <td><?=($val['instrument_type']!='cash' && !empty($val['instrument_no'])?$val['instrument_no']:'')?></td>
                                          <td><?=($val['instrument_type']!='cash' && !empty($val['bank_name'])?$val['bank_name']:'')?></td>
                                          <td><?=(!empty($val['remarks'])?$val['remarks']:'')?></td>
                                          <td><?php if($val['is_advance_payment']!=1){?><a  class="btn btn-default" onclick="editUPayments(<?=(!empty($val['id'])?$val['id']:'')?>)" >EDIT</a><?php }else{ echo 'NA';} ?></td>
                                        </tr>
                                          <?php $j++; } } } ?>
                                        </tbody>
                                    </table>
                                    <?php if(empty($balance_amount_left)){ $styl = "display:none";$next_btn = "display:block"; } else { $styl = "display:block";$next_btn = "display:none"; }?>
                                    <div id="edi" class="mrg-L15 mrg-B10 mrg-T15" style="<?=$styl;?>"><a class="btn btn-default"  onclick="editUPayments(0)">Add New Payment</a></div>
                                    
                                 </div>

                                      </div>
                                <div class="col-md-12">
                               <div class="btn-sec-width mrg-B15">
                                  <input style="<?=$next_btn;?>" onclick="getUcSalesDeliveryDetails()" style="text-align: center" type="button" class="btn-continue" value="SAVE AND CONTINUE">
                               </div>
                           </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
          </div>
      </div>
     
     <div style="<?=empty($amount_paid)?'display:block;':'display:none;'?>">
               <h2 class="page-title">Payment Details</h2>
                <form name="paymentForm" id="paymentForm" method="post" action="">
               <div class="col-md-12 pad-LR-10 mrg-B40">
                  <div class="white-section">
                   
                      <div class="row">
                          <h2 class="page-title">Payment Details</h2>
                         <div class="col-md-6">
                          <div class="form-group">
                              <label for="instrument_type" class="crm-label"> Payment Mode*</label>
                              <select required id="instrument_type" name="instrument_type" class="form-control crm-form instrument_name">

                                     <option  value="" >Select Payment Mode</option>
                                     <option  value="cash" >Cash</option>
                                     <option  value="cheque" >Cheque</option>
                                     <option  value="dd" >DD</option>
                                     <option  value="online" >Online Transaction</option>
                                 </select>
                              <div class="error" id="instrument_type_error" >Please Select Payment Mode</div>
                           </div>
                         </div>
                         <div class="col-md-6"  >
                           <div class="form-group">
                               <label for="amount" class="crm-label" >Amount*</label>
                               <input required type="text" name="amount" id="amount" class="form-control crm-form rupee-icon" value=""    placeholder="Amount">
                              <div class="error" id="amount_error" >Please Enter Amount</div>
                              </div>

                         </div>
                         <div class="col-md-6 instrument-not-cash "  >
                           <div class="form-group">
                               <label for="instrument_no" class="crm-label" >Instrument No.</label>
                              <input type="text" name="instrument_no" id="instrument_no" class="form-control crm-form not-cash" value=""    placeholder="Instrument No.">
                              <div class="error" id="instrument_no_error" >Please Select Instrument No.</div>
                              </div>

                         </div>
                         <div class="col-md-6 instrument-not-cash"  >
                          <div class="form-group">
                              <label for="" class="crm-label">Select Bank</label>
                                 <select id="bank_id" name="bank_id" class="form-control crm-form testselect1 not-cash">
                                      <option  value="" >Select Bank Name</option>
                                     <?php foreach($bankList as $bank){ ?>
                                     <option  value="<?=$bank['bank_id']?>" ><?=$bank['bank_name']?></option>
                                     <?php  } ?>
                                 </select>
                              <div class="error" id="bank_id_error" >Please Select Bank</div>
                           </div>

                         </div>
                         <div class="col-md-6 instrument-not-cash"  >
                           <div class="form-group">
                             <label for="" class="crm-label" >Instrument Date</label>
                             <div class="input-group date" id="dp4">
                                 <input type="text" class="form-control crm-form insdate crm-form_1 not-cash" id="instrument_date" name="instrument_date" autocomplete="off" value=""  placeholder="Instrument Date">
                                 <span class="input-group-addon">
                                     <span class="">
                                         <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                     </span>
                                 </span>
                             </div>
                              <div class="error" id="instrument_date_error" >Please Select Instrument Date</div>
                            </div>

                         </div>
                         <div class="col-md-6 instrument-not-cash" >
                           <div class="form-group">
                               <label for="favouring" class="crm-label" >Favouring</label>
                              <input type="text" name="favouring" id="favouring" class="form-control crm-form not-cash" value=""    placeholder="Favouring">
                              <div class="error" id="favouring_error" >Please Select Favouring</div>
                              </div>

                         </div>
                         <div class="col-md-6"  >
                            <div class="form-group">
                             <label for="payment_date" class="crm-label" >Payment Date*</label>
                             <div class="input-group date" id="dp3">
                                 <input required type="text" class="form-control crm-form insdate crm-form_1 " id="payment_date" name="payment_date" autocomplete="off" value=""  placeholder="Payment Date">
                                 <span class="input-group-addon">
                                     <span class="">
                                         <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                     </span>
                                 </span>
                             </div>
                              <div class="error" id="payment_date_error" >Please Select Payment Date</div>
                            </div>
                         </div>
                           <div class="col-md-6" >
                           <div class="form-group">
                               <label for="remark" class="crm-label" >Remarks*</label>
                               <input required type="text" name="remarks" id="remark" class="form-control crm-form" value=""    placeholder="Remarks">
                              <div class="error" id="remarks_error" >Please Enter Remarks</div>
                              </div>

                         </div>
                      </div>
                     <div class="row">
                         <div class="col-md-12">
                            <div class="btn-sec-width">
                               <input type="hidden" name="step6" value="true">
                               <input type="hidden" name="caseId" id="caseId" value="<?php echo isset($case_id) ? $case_id :0; ?>">
                               <input type="hidden" name="car_id" id="car_id" value="<?php echo isset($car_id) ? $car_id :0; ?>">
                               <input  style="text-align: center" type="button" name="savePaymentForm" id="savePaymentForm" class="btn-continue" value="SAVE AND CONTINUE">
                            </div>
                        </div>
                     </div>



                  </div>
               </div>
                </form>
     </div>
               </div>
            </div>


<div class="modal fade bs-example-modal-md" id="editpaymenteee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-backdrop fade in" style="height:100%"></div>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-gray">
          <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png') ?>" onclick="closed()"> <span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="more_payment_modal"></h4>
            </div>
            <form id="editids" name="editids">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-6" style="height: 84px">
                          <div class="form-group">
                            <label class="crm-label">Instrument Type*</label>
                            <select required name="instrumenttype" id="instrumenttypes"  class="form-control crm-form ins-type instrument_name">
                                     <option   value="" >Select Payment Mode</option>
                                     <option   value="cash" >Cash</option>
                                     <option  value="cheque" >Cheque</option>
                                     <option  value="dd" >DD</option>
                                     <option  value="online" >Online Transaction</option>
                           </select>
                            <div class="d-arrow"></div>
                           <div class="error" id="instrumenttype_error" >Please Select Payment Mode</div>
                        </div>
                       
                    </div>
                    <div class="col-md-6" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Amount*</label>
                                <input maxlength="12" required type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommasdd(this.value,'amounts')"   name="amounts"  class="form-control crm-form rupee-icon" placeholder="Amount" value="" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="amounts_error">Please Enter Amount</div>
                            </div>
                        </div>
                    <div id="chequemethods">
                        

                         <div class="col-md-6 instrument-not-cash showon" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Instrument No.</label>
                                <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="">
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="insno_error">Please Enter Instrument No.</div>
                            </div>
                        </div>

                        <div class="col-md-6 instrument-not-cash showhide" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Drawn on Bank</label>
                                <select  class="form-control removevalid crm-form testselect1 not-cash" id="payment_banks" name="payment_banks">
                                     <option  value="" >Select Bank Name</option>
                                     <?php foreach($bankList as $bank){ ?>
                                     <option  value="<?=$bank['bank_id']?>" ><?=$bank['bank_name']?></option>
                                     <?php  } ?>
                            </select>
                            <div class="d-arrow"></div>
                               <div class="error" id="payment_banks_error">Please Select Bank</div>
                            </div>
                        </div>
                        <div class="col-md-6 instrument-not-cash showhide " style="height:84px">
                            <div class="form-group">
                                <label class="crm-label">Instrument Date</label>
                                 <div class="input-group date" id="instrudate">
                                <input type="text" class="form-control removevalid crm-form insdate crm-form_1 not-cash" id="insdates" name="insdate" autocomplete="off" value=""  placeholder="Instrument Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="insdate_error">Please Enter Instrument Date</div>
                            </div>
                        </div>
                        <div class="col-md-6 instrument-not-cash showhide " style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Favouring</label>
                                <input  type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favourings"  class="form-control removevalid crm-form not-cash" placeholder="Favouring" value="" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="favourings_error">Please Enter Favouring</div>
                            </div>
                        </div>
                       
                    </div>
<!--                    <div class="col-md-6" style="height:84px">
                           <div class="form-group">
                               <label for="remarks" class="crm-label" >Remarks</label>
                               <input required type="text" name="remarks" id="remarks" class="form-control crm-form" value=""    placeholder="Remarks">
                              <div class="error" id="remarks_error">Please Enter Remarks</div>
                              </div>

                    </div>-->
                     <div class="col-md-6" style="height: 84px">
                            <div class="form-group" id="cashmethods" >
                                <label class="crm-label">Payment Date*</label>
                               <!-- <input type="text" id="paydate"  name="paydate"  class="form-control crm-form" placeholder="Payment Date" value="<?= !empty($val['payment_date'])?$val['payment_date']:'' ?>" >-->
                               <div class="input-group date" id="pay">
                                <input required type="text" class="form-control payment_date crm-form crm-form_1" id="paydatess" name="paydate" autocomplete="off" value=""  placeholder="Payment Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="paydate_error">Please Enter Payment Date</div>
                            </div>
                    </div>
                    <div class="col-md-6" style="height:84px">
                           <div class="form-group">
                               <label for="remarks" class="crm-label" >Remarks</label>
                               <input  type="text" name="remarks" id="remarks" class="form-control crm-form" value=""    placeholder="Remarks">
                              <div class="error" id="remarks_error">Please Enter Remarks</div>
                              </div>

                    </div>
                        
                        <input type="hidden" name="edid" value="" id="edid">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="saveEditData()">SAVE</button>
            </div>
            </form>
          </div>
        </div>
      </div>

<style>
  .error{display:none}
  .new-d{ float: left;  width: 100%;  margin-bottom: 20px;}
  .tb-new-d{float: left;width: calc(100%);}
</style>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>   
<script src="<?php echo base_url(); ?>assets/js/usedcarsale_process.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/usedcarsaleValidation.js" type="text/javascript"></script>
<script>

function showModal()
{
    $('.error').hide();
    $('#editpaymenteee').addClass(' in');
    $('#editpaymenteee').attr('style','display:block;');
}
function closed()
{
 // alert('gih');
   $('#editpaymenteee').removeClass(' in');
   $('#editpaymenteee').attr('style','display:none;'); 
}
//function instrumentType(e)
//    {
//        var id = $(e).attr('id');
//        var insType = $('#'+id).val();
//        var ids = id.split('_');
//        if(insType=='1')
//        {
//            $('#chequemethod').attr('style','display:none;');
//            $('#cashmethod').attr('style','display:block;');
//            $('#chequemethods').attr('style','display:none;');
//            $('#cashmethods').attr('style','display:block;');  
//        }
//        if(insType=='2')
//        {
//            $('#chequemethod').attr('style','display:block;');
//            $('#cashmethod').attr('style','display:none;');
//            $('#chequemethods').attr('style','display:block;');
//            $('#cashmethods').attr('style','display:none;');
//        }
//    }


function saveEditData()
{
    var instrumenttype = $('#instrumenttypes').val();
    var amount = $('#amounts').val();
    var insno = $('#insnos').val();
    var insdate = $('#insdates').val();
    var payment_bank = $('#payment_banks').val();
    var favouring = $('#favourings').val();
    var remarks = $('#remarks').val();
    var edid = $('#edid').val();
    var paydates = $('#paydatess').val();
    var case_id = $('#caseId').val();
    var car_id = $('#car_id').val();
    var error =validateUsedCarSalesFrom('editids');
    if(!error){
     $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "saveUpdateUsedCarsaleData",
            data:{instrument_type:instrumenttype,amount:amount,instrument_no:insno,instrument_date:insdate,bank_id:payment_bank,favouring:favouring,edid:edid,payment_date:paydates,caseId:case_id,car_id:car_id,remarks:remarks,step6:true},
            dataType: "json",
            success: function(response) 
            {
                var data =response;
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
              closed();
            }   
            });
    }

}
 function editUPayments(editids='')
{   
                $('#instrumenttypes').val('');
                $('#amounts').val('');
                $('#insnos').val('');
                $('#insdates').val('');
                $('#payment_banks').val('');
                $('#favourings').val('');
                $('#remarks').val('');
                $('#edid').val('');
                $('#paydatess').val('');
                $('#more_payment_modal').html('Add Payment');
    if(parseInt(editids)>=1)
    {
                $('#more_payment_modal').html('Edit Payment');
        $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedCarSale/getPaymentById/",
            data:{editids:editids},
            dataType: "json",
            success: function(response) 
            {
               
               // alert(response[0].instrumenttype);
               instrumentTypeValidation(response[0].instrument_type);
                $('#instrumenttypes').val(response[0].instrument_type);
                $('#instrumenttypes').trigger('change');
                $('#amounts').val(response[0].amount);
                $('#insnos').val(response[0].instrument_no);
                $('#insdates').val(response[0].instrument_date);
                $('#payment_banks').val(response[0].bank_id==0?'':response[0].bank_id);
                $('#favourings').val(response[0].favouring);
                $('#remarks').val(response[0].remarks);
                $('#edid').val(response[0].id);
                $('#paydatess').val(response[0].payment_date);
                //$('#payment_banks').val()
                $('#payment_banks')[0].sumo.reload();
                setTimeout(function(){ showModal(); }, 300); 
            }   
        });
    }
    else if(editids==0)
    {
        showModal();
    }
    
    $('#edid').val(editids);
}
    $('#paydatess').datepicker({
    format: 'dd-mm-yyyy',
    endDate: 'd',
    autoclose: true,
    todayHighlight: true
});
    var payment_mode =$('.instrument_name').val();
    //var payment_mode =$('#instrumenttypes').val();
    instrumentTypeValidation(payment_mode);

    $('.instrument_name').change(function(){
         var payment_mode = $(this).val();
         instrumentTypeValidation(payment_mode);
    });
    function instrumentTypeValidation(payment_mode){
       
        if(payment_mode=='cash' || payment_mode==''){
            $('.instrument-not-cash').hide();
            $('.not-cash').prop('required',false);
        }
        else if(payment_mode=='online' || payment_mode=='')
        {
            $('.instrument-not-cash').show();
            $('.not-cash').prop('required',true);
            $('.showon').show();
            $('.showhide').hide();
            $('.removevalid').prop('required',false);
        }
        else{
       //   alert('hhhh');
            $('.instrument-not-cash').show();
            $('.not-cash').prop('required',true);
            $('.removevalid').prop('required',false);
        }
    }

</script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
</script>