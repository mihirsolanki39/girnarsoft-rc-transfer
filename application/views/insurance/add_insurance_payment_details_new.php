 <style>
  .btn-class {display: inline-block;margin: 0;}
</style>
<?php 
//echo "<pre>";print_r($CustomerInfo['customerPartPayments']);die;
$Clearance = !empty($CustomerInfo['customerPartPayments']['4'])? $CustomerInfo['customerPartPayments']['4'] : [] ;
$subamt  = $CustomerInfo['customerPartPayments'][2];
$sum = 0;
$sum1 = 0;
foreach($subamt as $k =>$v)
{
  if($v['payment_by']=='2')
  {
     $sum = (int)$sum + (int)$v['amount'];
  }
}
foreach($Clearance as $ck =>$cv)
{
  if($cv['entry_type']=='4')
  {
     $sum1 = (int)$sum1 + (int)$cv['amount'];
  }
}

$subVent = $sum - $sum1;
//echo $sum."++++++".$sum1;die;
  if(isset($CustomerInfo['customerPartPayments']['4']))
  unset($CustomerInfo['customerPartPayments']['4']);
  $customerPay = !empty($CustomerInfo['customerPartPayments'][1])?$CustomerInfo['customerPartPayments'][1]:[];
  $inhousePay = !empty($CustomerInfo['customerPartPayments'][2])?$CustomerInfo['customerPartPayments'][2]:[];
  $sisPay = !empty($CustomerInfo['customerPartPayments'][3])?$CustomerInfo['customerPartPayments'][3]:[];
  $InsurancePayments =  array_merge($customerPay,$inhousePay,$sisPay);
  $is_admin=$this->session->userdata['userinfo']['is_admin'];
  if(DEALER_ID!='49')
  {
     $is_admin = '1';
    
    }
  $addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
  $editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
  $viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
  $role_name=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
  $mode=(!empty($CustomerInfo['customerPartPayments'])) ? 'edit' : 'add';
  $stylec = 'display:none';
 //echo $CustomerInfo['totalpremium'].'-'.current($CustomerInfo['PartPaymentDetails'])['total_amount_paid'];

  if($CustomerInfo['totalpremium'] <= current($CustomerInfo['PartPaymentDetails'])['total_amount_paid'])
  {
    $stylec = 'display:block';
  }
  //echo $stylec; exit;
  $action = ($mode=='edit')? base_url().'insPolicyDetails/' . base64_encode('customerId_' . $customerId) : '';

  $tote = $CustomerInfo['PartPaymentDetails'][0]['totalpremium'];
  $leftam = $CustomerInfo['PartPaymentDetails'][0]['total_amount_paid']; 
  $savem = (int)$tote - (int)$leftam;
  
?>


    <?php if ((($savem == 0 && $subVent == 0) || (!empty($CustomerInfo['is_payment_completed']) && !empty($is_admin))) && $CustomerInfo['current_policy_no'] != "") { ?>
        <input type="hidden" name="is_flag_set" id="is_flag_set" value="3">
    <?php } else if ((($savem == 0) && ($subVent == 0)) && $CustomerInfo['current_policy_no'] == "") {
        ?>
        <input type="hidden" name="is_flag_set" id="is_flag_set" value="2">
    <?php } else if (((empty($CustomerInfo['is_payment_completed'])) ) && (($savem < 0) || ($subVent > 0) )) {
        ?>
        <input type="hidden" name="is_flag_set" id="is_flag_set" value="1">
    <?php } ?>
<link href="<?php echo base_url(); ?>assets/admin_assets/css/buyer-lead.css" rel="stylesheet">
<div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <div class="row">
      <div id="payment_stock_div" class="">


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
                             <p class="font-36 col-green"><span class="font-18"> ₹ </span> <span id="purchaseamt"><?php echo !empty($CustomerInfo['totalpremium'])? $CustomerInfo['totalpremium'] : 0 ; ?></span></p>
                             <p class="font-18 col-black-o">Premium Amount</p>
                          </a>
                       </div>
                       <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                          <a href="javascript:void(0);">
                             <p class="font-36 col-yellow"><span class="font-18"> ₹ </span>  <span id="amtPaid"><?php echo !empty(current($totalAmountPaid)['paid_amt_type'])? current($totalAmountPaid)['paid_amt_type'] : 0 ; ?></span></p>
                             <p class="font-18 col-black-o">Amount Received</p>
                          </a>
                       </div>
                       <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                          <a href="javascript:void(0);">
                             <p class="font-36 col-red"><span class="font-18"> ₹ </span>   <span id="leftPaid"><?php //echo !empty( current($CustomerInfo['PartPaymentDetails'])['total_subvention'])? current($CustomerInfo['PartPaymentDetails'])['total_subvention'] : 0 ;
                             echo $subVent;
                              //echo (int)$CustomerInfo['totalpremium']-(int)current($CustomerInfo['PartPaymentDetails'])['total_amount_paid'];
                              ?></span></p>
                             <p class="font-18 col-black-o">Subvention</p>
                          </a>
                       </div> 
                    </div>
                 </div>
              </div>
           </div>
        </div>
        <div class="list_div col-md-12 mrg-T20">
        <div class="background-ef-tab" id="loandetails">

        <div class="col-md-6 pad-T20">

          <h5 class="cases"> Payment To Insurance Company </h5>
        </div>
        <?php if(empty($CustomerInfo['customerPartPayments'] )) { ?>
        <div class="container-fluid">
               <div class="row">
                <?php echo $this->load->view('insurance/part_payment_form',['change_mode'=>'add']); ?>
               </div>
        </div>       
        <?php }?>
        <?php if(!empty($CustomerInfo['customerPartPayments'] )){ ?>
          <div class="tabs loandetails">
            <div class="row pad-all-20">

              <?php if(($is_admin || (!$is_admin && $addPerm )) && ( !$CustomerInfo['is_payment_completed'] || ($CustomerInfo['totalpremium'] != current($CustomerInfo['PartPaymentDetails'])['total_amount_paid'])) && ($savem>0)){ ?>
              <div class="col-md-6" style="text-align: right">
              <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="showPartPaymentForm('add','1')">Add Payment</button>
              </div>
            <?php } ?>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                <div class="container-fluid ">
                  <div class="row">
                    <div class="col-lg-12 col-md-12">
                      <div class="row">
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                             <thead>
                                <tr>
                                   <th>Sr. No</th>
                                   <th>Payment By</th>
                                   <th>Amt. Paid</th>
                                   <th>Date Of Payment</th>
                                   <th>Payment Mode</th>
                                   <th>Instrument Date</th>
                                   <th>Instrument Number</th>
                                   <th>Bank Name</th>
                                   <th>Payment Reason</th>
                                   <th>Remark</th>
                                   <th>Action</th>
                                   
                                </tr>
                             </thead>
                             <tbody id="paymentcases">
                              <?php
                                $row = 1; 
                                foreach ($InsurancePayments as $key => $customerPartPayment) { ?>
                                <tr>
                                  <td>
                                    
                                    <div class="font-13 text-gray-customer">
                                     <span class=""><?php echo $row; ?></span>
                                    </div>
                                  </td>
                                  <td>
                                      <div class="font-13 text-gray-customer">
                                       <?php echo (!empty($customerPartPayment['payment_by'])? ( $customerPartPayment['payment_by']==1? 'Customer' : ( $customerPartPayment['payment_by']==2? 'Inhouse' : ( $customerPartPayment['payment_by']==3? (!empty($dealer_info[0]['ins_sis_comp'])?$dealer_info[0]['ins_sis_comp']:'') : '' ) )  ) : ''); ?>
                                      </div>
                                    </td>
                                  <td>                                      
                                    <div class="font-13 text-gray-customer">
                                     <span class="pay_amount_commas" id="<?=$customerPartPayment['id'] ?>">
                                         <i class="fa fa-rupee"></i><span class="<?=$customerPartPayment['id'] ?>"> <?php echo $customerPartPayment['amount']; ?> </span>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php echo ( ($customerPartPayment['payment_date']!='0000-00-00') && (!empty($customerPartPayment['payment_date'])) ) ? date("d M, Y",strtotime($customerPartPayment['payment_date'])) : '--'; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo (!empty($customerPartPayment['payment_mode'])? ( $customerPartPayment['payment_mode']==1? 'Cheque' : ( $customerPartPayment['payment_mode']==2? 'Online' : ( 
                                          $customerPartPayment['payment_mode']==3? 'Cash'  : (
                                          $customerPartPayment['payment_mode']==4? 'DD'    : '--'
                                          ) ) )  ) : ''); ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php echo ( ($customerPartPayment['instrument_date']!='0000-00-00') && (!empty($customerPartPayment['instrument_date'])) ) ? date("d M, Y",strtotime($customerPartPayment['instrument_date'])) : '--'; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo $customerPartPayment['instrument_no']; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo $customerPartPayment['bankname']; ?>

                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo ucfirst($customerPartPayment['reason']); ?>
                                        
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo $customerPartPayment['pay_remark']; ?>
                                        
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                     <?php 
                                      $disb = "";
                                      if($savem == 0 && $CustomerInfo['current_policy_no'] !="" && empty($is_admin))
                                          $disb = "disabled=disabled";
                                    
                                      ?>
                                    <button class="btn btn-default"  <?=$disb ?> data-toggle="modal" data-target="#makePayment" onclick="showPartPaymentForm('edit', '<?php echo $customerPartPayment['entry_type']; ?>', '<?php echo $customerPartPayment['id']; ?>')">Edit Payment</button>
                                    
                                  </td>
                                </tr>
                                <?php $row++; } ?>

                                 
                              </tbody>
                          </table>
                        </div>
                       </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        </div>
        </div>
        <?php
      //  echo $is_inhouse."+++".$savem."___".$subVent;
        if(!empty($is_inhouse) && ($savem == 0)  ){ 
          ?>
        <div class="list_div col-md-12 mrg-T30">
            <div class="background-ef-tab" id="loandetails">
              <div class="tabs loandetails">
                <div class="row pad-all-20">
                  <div class="col-md-6">
                    <h5 class="cases"> Payment Clearance Details </h5>
                  </div>
                   <div class="col-md-6" style="text-align: right">
                  <?php if ((!empty($is_admin) && (empty($CustomerInfo['is_payment_completed'])) ) && (($savem < 0) || ($subVent > 0) )) { ?>
                         <button type="button" onclick="completePayment('<?php echo $customerId; ?>')" class="btn-continue btn-class saveCont" id="completePayment">Complete Payment </button>
                   <?php }
                        if ((!empty($CustomerInfo['is_payment_completed'])) && (($savem <= 0) && ($subVent > 0))) {?>
                          <button type="button" onclick="completePayment('<?php echo $customerId; ?>','1')" class="btn-continue btn-class saveCont"  id="modifyPayment">Modify Subvention </button>
                    <?php } ?><?php
                        if (!empty($is_admin) && ($is_admin || (!$is_admin && $addPerm )) && ( $subVent > 0 )) {
                          if ((empty($CustomerInfo['is_payment_completed']))) { ?>
                            <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="showPartPaymentForm('add','4')" style="height: 40px;">Add Payment</button>
                    <?php }
                    } ?>
                 </div>
                </div>
                <?php 
                 if( !empty($underclearance) ){ ?>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                    <div class="container-fluid ">
                      <div class="row">
                        <div class="col-lg-12 col-md-12">
                          <div class="row">
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                 <thead>
                                    <tr>
                                       <th>Sr. No</th>
                                       <th>Payment By</th>
                                       <th>Amt. Paid</th>
                                       <th>Date Of Payment</th>
                                       <th>Payment Mode</th>
                                       <th>Instrument Date</th>
                                       <th>Instrument Number</th>
                                       <th>Bank Name</th>
                                       <th>Payment Reason</th>
                                       <th>Remark</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody id="clearance_cases">
                                  <?php
                                $row = 1; 
                                foreach ($Clearance as $customerPartPayment) { ?>
                                    <tr>
                                  <td>
                                    
                                    <div class="font-13 text-gray-customer">
                                     <span class=""><?php echo $row; ?></span>
                                    </div>
                                  </td>
                                  <td>
                                      <div class="font-13 text-gray-customer">
                                       <?php echo (!empty($customerPartPayment['payment_by'])? ( $customerPartPayment['payment_by']==1? 'Customer' : ( $customerPartPayment['payment_by']==2? 'Inhouse' : ( $customerPartPayment['payment_by']==3? (!empty($dealer_info[0]['ins_sis_comp'])?$dealer_info[0]['ins_sis_comp']:'') : '' ) )  ) : ''); ?>
                                      </div>
                                    </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                        <span class="clear_amount_commas" id="<?=$customerPartPayment['id'] ?>">
                                            <i class="fa fa-rupee"></i> <span class="<?=$customerPartPayment['id'] ?>"><?php echo $customerPartPayment['amount']; ?> </span>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo ( ($customerPartPayment['payment_date']!='0000-00-00') && (!empty($customerPartPayment['payment_date'])) ) ? date("d M, Y",strtotime($customerPartPayment['payment_date'])) : '--'; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo (!empty($customerPartPayment['payment_mode'])? ( $customerPartPayment['payment_mode']==1? 'Cheque' : ( $customerPartPayment['payment_mode']==2? 'Online' : ( 
                                          $customerPartPayment['payment_mode']==3? 'Cash'  : (
                                          $customerPartPayment['payment_mode']==4? 'DD'    : '--'
                                          ) ) )  ) : ''); ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                      <?php echo ( ($customerPartPayment['instrument_date']!='0000-00-00') && (!empty($customerPartPayment['instrument_date'])) ) ? date("d M, Y",strtotime($customerPartPayment['instrument_date'])) : '--'; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo $customerPartPayment['instrument_no']; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo $customerPartPayment['bankname']; ?>

                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo ucfirst($customerPartPayment['reason']); ?>
                                        
                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?php echo $customerPartPayment['pay_remark']; ?>
                                        
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                     
                                    
                                    <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="showPartPaymentForm('edit', '<?php echo $customerPartPayment['entry_type']; ?>', '<?php echo $customerPartPayment['id']; ?>' )">Edit Payment</button>
                                    
                                  </td>
                                </tr>
                                <?php $row++; } ?>
                                    
                                     
                                  </tbody>
                              </table>
                            </div>
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               <?php } ?>
              </div>
            </div>
        </div>
        <?php } ?>
         <div class="col-md-12 mrg-B20">
            <div class="btn-sec-width">
            <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
            <button type="button" class="btn-continue" onclick="countinue('<?=$action?>',1)" style="<?=$stylec?>">CONTINUE</button>
        <?php// } ?>

            </div>
   </div>
   <!-- /End Search Filter -->
   
</div>
   </div>
</div>


<div class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="false" id="makePayment" style="display: none;">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png')?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="adpayment">Add Payment</h4>
            </div>

            <div class="modal-body pad-T15 pad-B15 pad-R15">

                <div id="commentHistory">
                  <div class="comment-wrap  mCustomScrollbar" data-mcs-theme="dark" id="add_Comment_buyerL" style="overflow-y:scroll; height:390px;"> 
                  <style>
                    .mCSB_inside {
                          height: 370px !important;
                          margin-top: 10px;
                      }
                  </style>


                    <div class="">
                            <div class="white-section pad-all-0">
                                
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


  <?php $currentdate=date('d/m/Y');?>

<script>
      
    $(document).ready(function() {
        
         $("#paymentcases").find(".pay_amount_commas").each(function(){
                 var id = $(this).attr('id');
                var val = $("."+id).text();  
               var val_Comma = convertToIndianCurrency(val, id,'','1');
                $("."+id).html("");
                $("."+id).html(val_Comma);
            })
            $("#clearance_cases").find(".clear_amount_commas").each(function(){
                 var id = $(this).attr('id');
                var val = $("."+id).text();  
               var val_Comma = convertToIndianCurrency(val, id,'','1');
                $("."+id).html("");
                $("."+id).html(val_Comma);
            })

        indianformat();
        $('.payment_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'y',
        autoclose: true,
        todayHighlight: true
    });
     
    $('#instrument_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'+100y',
        autoclose: true,
        todayHighlight: true
    });
    $('#receipt_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'y',
        autoclose: true,
        todayHighlight: true
    });
    $('.instrument_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'+100y',
        autoclose: true,
        todayHighlight: true
    });
    $('#in_instrument_date').datepicker({
        format:"dd-mm-yyyy",   
        startDate: '-1000y',
        endDate:'+100y',
        autoclose: true,
        todayHighlight: true
    });
    });
    function calAmtdrawn(id,totamt,val){
      var amtPaid = $('#amtPaid').val();

        totamt = totamt.replace( /,/g, "" );
        val = val.replace( /,/g, "" );
       // alert(totamt);
          if(totamt > 0){
//alert(parseInt(totamt)+'-'+(parseInt(val)+'-'+parseInt(amtPaid)));
                   var svamt=parseInt(totamt)-parseInt(val);
 //alert(svamt);
                   if((svamt<0)){
                    $('#'+id).val('');
                    alert('Amount is not Greater than Total Premium.');
                    return false;
                    }
                }    
        if(id=='policy_amt'){
           if(totamt > 0){
               var totprem=$('#totprem').val();
               totprem = totprem.replace( /,/g, "" );
               var svamt=parseInt(totprem)-parseInt(val);
               if(!isNaN(svamt)){
               //svamt=addCommas(svamt, 'policy_amt');
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
                $('#csubvention_amt').val(svamt);
                }
                }
         }
    }

    function showPartPaymentForm(mode,type,partpaymentid)
    {
      //alert('hiii');
      if(mode=='edit')
      {
      $('#adpayment').text('Edit Payment');
     }
     else
     {
        $('#adpayment').text('Add Payment');
       }
      var querystring = "mode="+mode+"&entrytype="+type+"&customerId="+'<?php echo isset($customerId) ? $customerId :''; ?>'+'&partpaymentid='+partpaymentid;
       $.ajax({
       type : 'POST',
       url : "<?php echo base_url(); ?>" + "Insurance/getPartPaymentForm/",
       dataType: 'html',
       data   : querystring,
       success: function (response) 
       { 
         

          $('.white-section').html(response);
           var pmode=$('#payment_mode').val();
           var payment_by = $('input[type="radio"]:checked').val();
           if(payment_by!='' && (pmode=='4' || pmode=='1') ){

            // alert("1--"+payment_by+"--"+pmode);
            $('.divbank').show();
           }
          if(payment_by!='' && (pmode=='3' || pmode=='2') ){
            if(payment_by=='2')
              $('.divinbank').hide();
            else $('.divbank').hide();
          }
          
          $('#payment_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'y',
              autoclose: true,
              todayHighlight: true
          });
          $('#s_payment_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'y',
              autoclose: true,
              todayHighlight: true
          });
          $('.payment_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'y',
              autoclose: true,
              todayHighlight: true
          });
          $('.instrument_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'+100y',
              autoclose: true,
              todayHighlight: true
          });
          $('#receipt_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'y',
              autoclose: true,
              todayHighlight: true
          });
          $('#instrument_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'+100y',
              autoclose: true,
              todayHighlight: true
          });$('#in_instrument_date').datepicker({
              format:"dd-mm-yyyy",   
              startDate: '-1000y',
              endDate:'+100y',
              autoclose: true,
              todayHighlight: true
          });
          

           $('#payment_mode').on('change', function(){
              var totprem=$('#totprem').val();
              if($('#payment_mode').val()=='1'){
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
                 $('.divbank').show();
                 $('.divdd').show();
              }
              });
                 
             }
             });

    }

    function completePayment(customerId,flag='')
    {

      var leftPaid = $('#leftPaid').text();

      if(flag==''){
      var r = confirm('Rs '+leftPaid+'  has been marked as subvention. Do you want to save and proceed further');
      if (r == true) {
    
      var querystring = "customerId="+customerId;
       $.ajax({
       type : 'POST',
       url : "<?php echo base_url(); ?>" + "Insurance/completePayment/",
       dataType: 'json',
       data   : querystring,
       success: function (response) 
       { 
          console.log(response); 
          window.location.reload();
       }
       });
       $('#completePayment').attr('style','display:none');
       $('#modifyPayment').attr('style','display:block');
      
  } else {
    
  }}else
  {
       var querystring = "customerId="+customerId+"&flag=1";
       $.ajax({
       type : 'POST',
       url : "<?php echo base_url(); ?>" + "Insurance/completePayment/",
       dataType: 'json',
       data   : querystring,
       success: function (response) 
       { 
          console.log(response); 
          window.location.reload();
       }
       });
       $('#completePayment').attr('style','display:block');
       $('#modifyPayment').attr('style','display:none');
  }

    }


    function countinue(action,flag="")
    {
        if(flag ==1){
                var customerId = '<?php echo isset($customerId) ? $customerId :''; ?>';
                 var querystring = "customerId="+customerId+"&flag="+$("#is_flag_set").val();
            $.ajax({
                type : 'POST',
                url : "<?php echo base_url(); ?>" + "Insurance/changesStatus/",
                dataType: 'json',
                data   : querystring,
                success: function (response) 
                { 
                   if($("#is_flag_set").val() == 2 || $("#is_flag_set").val() == 3); 
                   window.location.href = action;
                }
           }); 
        }else{
        window.location.href = action;
        }
    }

function indianformat()
{ 
  var x =$('#purchaseamt').html();
  //alert(x);
  x=x.toString();
  var lastThree = x.substring(x.length-3);
  var otherNumbers = x.substring(0,x.length-3);
  if(otherNumbers != '')
      lastThree = ',' + lastThree;
  var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
  $('#purchaseamt').html(res) ;

  var x = $('#amtPaid').html();
  x=x.toString();
  var lastThree = x.substring(x.length-3);
  var otherNumbers = x.substring(0,x.length-3);
  if(otherNumbers != '')
      lastThree = ',' + lastThree;
  var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
  $('#amtPaid').html(res) ;

  var x = $('#leftPaid').html();
  x=x.toString();
  var lastThree = x.substring(x.length-3);
  var otherNumbers = x.substring(0,x.length-3);
  if(otherNumbers != '')
      lastThree = ',' + lastThree;
  var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
  $('#leftPaid').html(res) ;
}
 function convertToIndianCurrency(nStr,control,flag='',flag1 ='')
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
        var lastThree = x.substring(x.length-3);
        var otherNumbers = x.substring(0,x.length-3);
        if(otherNumbers != '')
            lastThree = ',' + lastThree;
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
         if(flag1 == 1)
            return res;
        else
            document.getElementById(control).value=res;
  }
</script>
<script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>
