<?php 
    $style = 'display:none';
    $styles = 'display:block';
    $stylesss  = 'display:none';
    if(!empty($paymentDe[0]['amountprice']))
    {
        $styles = 'display:none';
        $style = 'display:block'; 
        
    }
    if(!empty($paymentDe[0]['purchaseprice']))
    {
      $stylesss  = 'display:block';
    }

?>
<style>
  .new-d{ float: left;  width: 100%;  margin-bottom: 20px;}
  .tb-new-d{float: left;width: calc(97%);}

</style>
<div class="container-fluid">
    <div class="row">
    <!---->
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
                                 <p class="font-36 col-green"><span class="font-18"> ₹ </span> <span id="purchaseamt"><?= !empty($paymentDe[0]['purchaseprice'])?($paymentDe[0]['purchaseprice']):'0' ?></span></p>
                                 <p class="font-18 col-black-o">Purchase Amount</p>
                              </a>
                           </div>
                           <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                              <a href="javascript:void(0);">
                                 <p class="font-36 col-yellow"><span class="font-18"> ₹ </span>  <span id="amtPaid"><?= !empty($paymentDe[0]['amountprice'])?($paymentDe[0]['amountprice']):'0' ?></span></p>
                                 <p class="font-18 col-black-o">Amount Paid</p>
                              </a>
                           </div>
                           <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                              <a href="javascript:void(0);">
                                 <p class="font-36 col-red"><span class="font-18"> ₹ </span>   <span id="leftPaid"><?= !empty($paymentDe[0]['leftprice'])?($paymentDe[0]['leftprice']):'0' ?></span></p>
                                 <p class="font-18 col-black-o">Left Amount</p>
                              </a>
                           </div> 
                            


                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="container-fluid mrg-all-15 tb-new-d" style="<?=$style?>">
            <div class="row">
      <div class="">
         <div class="background-ef-tab" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                     <h5 class="cases pad-L0">Payment Details</h5>
                   </div> 
<?php if((empty($paymentDe[0]['leftprice'])) && !empty($paymentDe[0]['amountprice'])){ $styl = "display:none";$next_btn = "display:block";  } else { $styl = "display:block";$next_btn = "display:none";  }?>
                   <div id="edi" class="col-md-6" style="<?=$styl;?>">
                    <a class="btn btn-default pull-right"  onclick="editUPayments(0)">Add New Payment</a>
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
                                             <th>Date of Purchase</th>
                                             <th>Instrument No.</th>
                                            <!-- <th>Instrument Date</th>-->
                                             <th>Payment Mode</th>
                                             <th>Payment Date</th>
                                             <th>Bank Name</th>
                                             <th>Remarks</th>
                                             <th>Action</th>
                                             
                                          </tr>
                                       </thead>
                                       <tbody>
                                       <?php  if(!empty($paymentDe)){
                                        $j = 1;
                                          foreach($paymentDe as $key => $val){
                                              if(!empty($val['amount'])){?>
                                        <tr>
                                          <td><?=$j?></td>
                                          <td><span> ₹ </span><?=(!empty($val['amount'])?$val['amount']:'')?></td>
                                          <td><?=(!empty($val['purchasedate'])?date('d M, Y',strtotime($val['purchasedate'])):'')?></td>
                                          <td><?=(!empty($val['insno']) && $val['instrumenttype']!='1'?$val['insno']:'')?></td>
                                         <!-- <td><?=((!empty($val['insdate']) && $val['instrumenttype']!='1' && (date('d-m-Y',strtotime($val['insdate'])) != '01-01-1970'))?date('d-m-Y',strtotime($val['insdate'])):'')?></td>-->
                                          <td><?if(!empty($val['instrumenttype']) && ($val['instrumenttype']=='1')){ echo 'Cash'; } else if(!empty($val['instrumenttype']) && ($val['instrumenttype']=='2')) { echo 'Cheque'; }
                                          else if(!empty($val['instrumenttype']) && ($val['instrumenttype']=='4')) { echo 'DD'; }else if(!empty($val['instrumenttype']) && ($val['instrumenttype']=='3')) { echo 'Online'; }?></td>
                                          <td><?=(!empty($val['payment_date']) && $val['payment_date']!='1970-01-01')?date('d M, Y',strtotime($val['payment_date'])):''?></td>
                                          <td><?=(!empty($val['bank_name']) && $val['instrumenttype']!='1'?$val['bank_name']:'')?></td>
                                          <td><?=(!empty($val['remarks'])?$val['remarks']:'')?></td>
                                          <td><a  class="btn btn-default" onclick="editUPayments(<?=(!empty($val['id'])?$val['id']:'')?>)" >EDIT</a></td>
                                             
                                                  
                                                </tr>
                                              <?php $j++; } } } ?>
                                        </tbody>
                                    </table>
                                    <?php if((empty($paymentDe[0]['leftprice'])) && !empty($paymentDe[0]['amountprice'])){ $styl = "display:none";$next_btn = "display:block";  } else { $styl = "display:block";$next_btn = "display:none";  }?>
                                    
                                     <!--<div id="edi" class="mrg-L15 mrg-B10" style="<?=$styl;?>"><a class="btn btn-default"  onclick="editUPayments(0)">Add New Payment</a></div>-->
                                    
                                 </div>

                                      </div>
                                   </div>
                                       </div>
                             <div class="col-md-12 mrg-T10 mrg-B10" >
                            <div class="btn-sec-width">
                                <a href="<?=base_url().'inventoryListing'?>" class="btn-continue" style="<?=$stylesss?>" id="paydetailSave">SAVE AND CONTINUE</a>
                                <!--<a href="" class="btn-continue">SAVE AND CONTINUE</a>-->
                            </div>
                        </div>
<!--                           <div class="col-md-12">
                               <div class="btn-sec-width" style="margin-bottom: 15px !important;">
                                  <input style="<?=$next_btn;?>" onclick="getUcSalesDeliveryDetails()" style="text-align: center" type="button" class="btn-continue" value="SAVE AND CONTINUE">
                               </div>
                           </div>-->
                    
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
          </div>
            </div>
            
            <!---->
        <div class="col-md-12 pad-LR-10 mrg-B40 tb-new-d" style="<?=$styles?>">
            <h2 class="page-title mrg-L10">Payment Details</h2>
          <div class="white-section">
                <div class="row item-to-append">
                    <div class="col-md-12">
                    <div class="col-md-6 pad-L0">
                        <h2 class="sub-title first-title">First Payment</h2></div>
                   </div>
                    <form  enctype="multipart/form-data" method="post"  id="paymentinfo" name="paymentinfo">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Purchase Price*</label>
                            <input readonly type="text" id="purchaseprice" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'purchaseprice')" onchange="mainInfo(this.value);" name="purchaseprice"  class="form-control rupee-icon crm-form" placeholder="Purchase Price" value="<?= !empty($paymentDe[0]['purchaseprice'])?ucwords($paymentDe[0]['purchaseprice']):'' ?>" >
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_purchaseprice"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Purchase Date*</label>
                              <div class="input-group date" id="dp">
                                <input type="text" class="form-control crm-form crm-form_1" id="purchasedate" name="purchasedate" autocomplete="off" value="<?php 
                                          if(!empty($paymentDe[0]['purchasedate']) && ($paymentDe[0]['purchasedate']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($paymentDe[0]['purchasedate'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>"  placeholder="Purchase Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_purchasedate"></div>
                        </div>
                       
                    </div> 
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Instrument Type*</label>
                           <select name="instrumenttype" id="instrumenttype" onchange="instrumentType(this)" class="form-control crm-form">
                                <option value="">Select Instrument</option>
                                <option value="1" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'selected=selected':'')?>>Cash</option>
                                <option value="2"  <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='2')?'selected=selected':'')?>>Cheque</option>
                                <option value="3"  <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='3')?'selected=selected':'')?>>Online</option>
                                <option value="4"  <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='4')?'selected=selected':'')?>>DD</option>
                           </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_instrumenttype"></div>
                        </div>
                       
                    </div>
                                   <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Amount*</label>
                                <input type="text" maxlength="10" id="amount" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amount')"  onchange="mainInfo(this.value);" name="amount"  class="form-control crm-form rupee-icon" placeholder="Amount" value="<?= !empty($val['amount'])?ucwords($val['amount']):'' ?>" >
                                <div class="error" id="err_amount"></div>
                            </div>
                        </div>

                   
         
                         <div class="col-md-6" id="instrumentnos">
                            <div class="form-group">
                                <label class="crm-label">Instrument No.</label>
                                <input type="text" id="insno" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="<?= !empty($val['insno'])?ucwords($val['insno']):'' ?>" >
                               <div class="error" id="err_insno"></div>
                            </div>
                        </div>
  <div id="chequemethod">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Drawn on Bank</label>
                                 <select class="form-control testselect1 crm-form lead_source" id="payment_bank" name="payment_bank">
                                <option value="">Select</option>
                                 <?php
                                if(!empty($banklist)){
                                     foreach($banklist as $ckey => $cval){?>
                                     <option value="<?=$cval['bank_id']?>"  <?= !empty($val) && $val['payment_bank']==$cval['bank_id']?'selected=selected':''?>><?=$cval['bank_name']?></option>
                                   <? } }?>
                            </select>
                            <div class="d-arrow"></div>
                                <div class="error" id="err_bank_list"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Instrument Date</label>
                                     <div class="input-group date" id="dp1">
                                <input type="text" class="form-control crm-form insdate crm-form_1" id="insdate" name="insdate" autocomplete="off" value="<?php 
                                          if(!empty($val['insdate']) && ($val['insdate']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['insdate'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>"  placeholder="Instrument Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_insdate"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Favouring</label>
                                <input type="text" id="favouring"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="<?= !empty($val['favouring'])?ucwords($val['favouring']):'' ?>" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_favouring"></div>
                            </div>
                        </div>
                       
                    </div>
                     <div class="col-md-6">
                            <div class="form-group" id="cashmethod" style="display: none">
                                <label class="crm-label">Payment Date*</label>
                               <div class="input-group date" id="dp2">
                                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydate" name="paydate" autocomplete="off" value="<?php 
                                          if(!empty($val['payment_date']) && ($val['payment_date']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['payment_date'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>"  placeholder="Payment Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_paydate"></div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Remark</label>
                                <input type="text" id="remark"  onkeypress="return blockSpecialChar(event)" name="remark"  class="form-control crm-form" placeholder="Remark" value="<?= !empty($val['remark'])?ucwords($val['remark']):''?>">
                               <div class="error" id="err_remark"></div>
                            </div>
                        </div>
                        
                          <? // }?>
                         
                        <div class="col-md-12 wow">
                        </div>
                        <input type="hidden" name="payinfo" value="1" id="payinfo">
                        <input type="hidden" name="countTotalFiles" value="<?=!empty($total_count)?$total_count:'1'?>" id="countTotalFiles">
                         <input type="hidden" name="case_id" value="<?=!empty($case_id)?$case_id:''?>" id="case_id">
                         <input type="hidden" name="all_total_id" value="<?=!empty($all_ids)?$all_ids:''?>" id="total_id">
                        <input type="hidden" name="car_id" value="<?= !empty($carid)?$carid:'' ?>" id="car_id">
                        <input type="hidden" name="edit_id" value="<?= !empty($edit_id)?$edit_id:'' ?>" id="edit_id">
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                <a href="javascript:void(0);" class="btn-continue" style="<?=$stylesss?>" id="savePay">SAVE AND CONTINUE</a>
                                <!--<a href="" class="btn-continue">SAVE AND CONTINUE</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            </div>
            
    </div>
</div>
</div>

<div class="modal fade bs-example-modal-md" id="editpaymenteee" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-backdrop fade in" style="height:100%"></div>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-gray">
          <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png') ?>" onclick="closed()"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="payment_popup_head"></h4>
            </div>

            <form id="editids" name="editids">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-md-6" style="height: 84px">
                          <div class="form-group">
                            <label class="crm-label">Instrument Type*</label>
                           <select name="instrumenttype" id="instrumenttypes" onchange="instrumentType(this)" class="form-control crm-form">
                                <option value="">Select Instrument</option>
                                <option value="1">Cash</option>
                                <option value="2">Cheque</option>
                                <option value="3">Online</option>
                                <option value="4">DD</option>
                           </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_instrumenttypes"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Amount*</label>
                                <input maxlength="10" type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amounts')"   name="amount"  class="form-control crm-form rupee-icon" placeholder="Amount" value="" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_amounts"></div>
                            </div>
                        </div>
                    
                        

                         <div class="col-md-6" style="height: 84px" id="instrumentnum">
                            <div class="form-group">
                                <label class="crm-label">Instrument No.</label>
                                <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="">
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_insnos"></div>
                            </div>
                        </div>
                      <div id="chequemethods">
                        <div class="col-md-6" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Drawn on Bank</label>
                                 <select class="form-control testselect1 crm-form" id="payment_banks" name="payment_bank">
                                <option value="0">Select Bank</option>
                                 <?php
                                if(!empty($banklist)){
                                     foreach($banklist as $ckey => $cval){?>
                                     <option value="<?=$cval['bank_id']?>"><?=$cval['bank_name']?></option>
                                   <?php } }?>
                            </select>
                            <div class="d-arrow"></div>
                                <div class="error" id="err_bank_lists"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Favouring</label>
                                <input type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_favourings"></div>
                            </div>
                        </div>
                       
                    </div>
                     <div class="col-md-6" style="height: 84px">
                            <div class="form-group"  style="display: block">
                                <label class="crm-label">Payment Date*</label>
                               <!-- <input type="text" id="paydate"  name="paydate"  class="form-control crm-form" placeholder="Payment Date" value="<?= !empty($val['payment_date'])?$val['payment_date']:'' ?>" >-->
                               <div class="input-group date" id="dp2">
                                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydates" name="paydate" autocomplete="off" value="<?php 
                                            if(!empty($val['payment_date']) && ($val['payment_date']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['payment_date'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>"  placeholder="Payment Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_paydates"></div>
                            </div>
                        </div>
                         <div class="col-md-6" style="height: 84px">
                            <div class="form-group">
                                <label class="crm-label">Remark</label>
                                <input type="text" id="remarks"  onkeypress="return blockSpecialChar(event)" name="remark"  class="form-control crm-form" placeholder="Remark" value="" >
                               <div class="error" id="err_remark"></div>
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
<script src="<?php echo base_url(); ?>assets/js/inv_stock.js" type="text/javascript"></script>      
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>  
<script>
    $(document).ready(function() {
        $('#purchasedate').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#insdate').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
         $('#insdates').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#paydate').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: 'd',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#paydates').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: 'd',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
    var getval = $('#countTotalFiles').val();
    var x  = parseInt(getval); 
    getTotal(x);
       // $('#')
    });

    function getTotal(r)
    {
        var total_amount = 0;
        var purchasePrice = $('#purchaseprice').val().replace(/,/g,'');
        for(var j=1; j<=r;j++)
        {
           var ac =  $('#amount_'+j).val().replace(/,/g,'');
           total_amount = parseInt(total_amount)+parseInt(ac);
        }
        if(parseInt(total_amount)<=parseInt(purchasePrice))
        {
            // $('#remark').val(parseInt(purchasePrice)-(parseInt(total_amount)));
         // return 1; 
        }
        else if(parseInt(total_amount)==parseInt(purchasePrice))
        {
            //$('#addout').attr('style','display:none;');
            //return 2;
        }
        else
        {
            alert('Amount Total is more than Purchase Price.Please Check.');
            return false;
        }
       // return true;

    }
    function mainInfo(va)
    {
        //alert('we44r34  ');
        var getval = $('#countTotalFiles').val();
        var x  = parseInt(getval); 
        var total_amount = 0;
        var av = $('#amount').val().replace(/,/g,'');
        var purchasePrice = $('#purchaseprice').val().replace(/,/g,'');
        if(x>1)
        {
            var gettotalleft = getTotal(x);
        }
        if(purchasePrice=='')
        {
            alert('Please Enter Purchase Price');
            return false;
        }
        if(av=='')
        {
            //alert('Please Enter Amount');
            return false;
        }
       // alert(av+'ttttt'+purchasePrice);
        if(parseInt(av)<=parseInt(purchasePrice))
        {
           //$('#addout').attr('style','display:block'); 
           //$('#remark').val(parseInt(purchasePrice)-(parseInt(av)));
        }
        if(parseInt(av)==parseInt(purchasePrice))
        {
            alert('Amount Total is more than Purchase Price.Please Check.');
            return false;
        }
        else if(gettotalleft=='2')
        {
            $('#addout').attr('style','display:none;');
        }
        return true;
    }

    function instrumentType(e)
    {
        var id = $(e).attr('id');
        var insType = $('#'+id).val();
        var ids = id.split('_');
        if(insType=='1')
        {
            $('#chequemethod').attr('style','display:none;');
            $('#cashmethod').attr('style','display:block;');
            $('#chequemethods').attr('style','display:none;');
            $('#cashmethods').attr('style','display:block;');
            $("#instrumentnum").attr('style','display:none;');
            $("#instrumentnos").attr('style','display:none;');
        }
        if(insType=='2' || insType=='4')
        {
            $('#chequemethod').attr('style','display:block;');
            $('#cashmethod').attr('style','display:block;');
            $('#chequemethods').attr('style','display:block;');
            $('#cashmethods').attr('style','display:none;');
            $("#instrumentnum").attr('style','display:block;');
            $("#instrumentnos").attr('style','display:block;');
        }
        
        if(insType == '3')
        {
           $('#chequemethod').attr('style','display:none;');
           $('#cashmethod').attr('style','display:block;');
           $('#chequemethods').attr('style','display:none;');
           $('#cashmethods').attr('style','display:block;');
        }
    }


    
function showModelsss()
{
    $('#editpaymenteee').addClass(' in');
    $('#editpaymenteee').attr('style','display:block;');
}
function closed()
{
 // alert('gih');
   $('#editpaymenteee').removeClass(' in');
   $('#editpaymenteee').attr('style','display:none;'); 
}

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
    var paydates = $('#paydates').val();
    var case_id = $('#case_id').val();
    var car_id = $('#car_id').val();
   
    var error =false
    $('.error').html('')
    if(instrumenttype==''){
        $('#err_instrumenttypes').html('Please enter instrument type');
        error= true;
    }
    var amountInt = amount.replace(/\,/g,'');
    if(amountInt=='' || amountInt< 0 ){
        $('#err_amounts ').html('Please enter amount');
        error= true;
    }
    if(paydates==''){
        $('#err_paydates').html('Please enter payment date');
        error= true;
    }
    if(instrumenttype!=1){
         if(insno==''){
            // $('#err_insnos').html('Please enter instrument no');
            // error= true;
         }
         if(payment_bank==''){
          //   $('#err_bank_lists').html('Please select  bank');
          //   error= true;
         }
         if(favouring==''){
           //  $('#err_favourings').html('Please enter favouring');
          //   error= true;
         }
         if(insdate==''){
           //  $('#err_insdates').html('Please enter instrument date');
            // error= true;
         }
    }
    if(!error){
     $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/addUsedPurchased/",
            data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,remarks:remarks,edid:edid,paydates:paydates,case_id:case_id,car_id:car_id},
            dataType: "json",
            success: function(response) 
            {
               if(response.status=='True'){
                    setTimeout(function(){window.location.reload(true); }, 1500);
                   $('#amtPaid').html(response.amout);
                   $('#leftPaid').html(response.left);
                   closed();
               }
               else{
                   snakbarAlert(response.message);
               }
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
                $('#payment_banks')[0].sumo.reload();
                $('#favourings').val('');
                $('#remarks').val('');
                $('#edid').val('');
                $('#paydates').val('');
                $('#payment_popup_head').text('Add Payment');
    if(parseInt(editids)>=1)
    {
               $('#payment_popup_head').text('Edit Payment');
        $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getUsedPurchased/",
            data:{editids:editids},
            dataType: "json",
            success: function(response) 
            {

               // alert(response[0].instrumenttype);
                $('#instrumenttypes').val(response[0].instrumenttype);
                $('#instrumenttypes').trigger('change');
                $('#amounts').val(response[0].amount);
                $('#insnos').val(response[0].insno);
                $('#insdates').val(response[0].insdate);
                $('#payment_banks').val(response[0].payment_bank);
                $('#payment_banks')[0].sumo.reload();
                $('#favourings').val(response[0].favouring);
                $('#remarks').val(response[0].remarks);
                $('#edid').val(response[0].id);
                $('#paydates').val(response[0].payment_date);
                setTimeout(function(){ showModelsss(); }, 300); 
            }   
        });
    }
    else if(editids==0)
    {
        showModelsss();
    }
    
    $('#edid').val(editids);
}

    </script>  

    
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
</script>