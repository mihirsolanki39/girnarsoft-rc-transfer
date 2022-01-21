  <?php $i = 1; ?>
  <div class="container-fluid bg-container-new mrg-T70" id="maincontainer" style="display: grid;">
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
                             <p class="font-36 col-green"><span class="font-18"> ₹ </span> <span id="purchaseamt"><?=(!empty($netpayamtcheck) && ($netpayamtcheck>0))?$CustomerInfo['loan_amount']:0?></span></p>
                             <p class="font-18 col-black-o">Net Payable Amount</p>
                          </a>
                       </div>
                       <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                          <a href="javascript:void(0);">
                             <p class="font-36 col-yellow"><span class="font-18"> ₹ </span>  <span id="amtPaid"><?=$total_clearance_amount?>
                                 </span></p>

                             <p class="font-18 col-black-o"><span style="color: #000 !important; opacity: .87;">Amount Paid</span></p>


                          </a>
                       </div>                                  
                       <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                          <a href="javascript:void(0);">
                             <p class="font-36 col-red"><span class="font-18"> ₹ </span>   <span id="leftPaid">
                                 <?php                                  
                                 echo    $out_amount;
                             ?></span>
                             </p>
                             <p class="font-18 col-black-o">Outstanding Payment</p>
                          </a>
                       </div> 
                    </div>
                 </div>
              </div>
           </div>
        </div>

</div>
        <style type="text/css">
          .panel-heading {
            background:#ffffff !important; padding: 5px 7px !important;
                    }
          .panel-title>a, .panel-title>a:active{
            display:block;
            padding:15px;
            color:#555;
            font-size:16px;
            letter-spacing:1px;
            word-spacing:3px;
            text-decoration:none;
          }
          .panel-heading  a:before {
             font-family: 'Glyphicons Halflings';
             content: "\e114";
             float: right;
             transition: all 0.5s;
          }
          .panel-heading.active a:before {
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            transform: rotate(180deg);
          } 
        </style>

  <?php //$this->load->view('/finance/loandisbursal'); ?>        

        <script type="text/javascript">
           $('.panel-collapse').on('show.bs.collapse', function () {
            $(this).siblings('.panel-heading').addClass('active');
          });

          $('.panel-collapse').on('hide.bs.collapse', function () {
            $(this).siblings('.panel-heading').removeClass('active');
          });
        </script>
        
        <?php $this->load->view('/finance/loandisbursal'); ?>        
        </div>
       
        
        <div class="row">
        <div class="list_div col-md-12 mrg-T10">
        <div class="background-ef-tab" id="loandetails">
          <div class="tabs loandetails">
            <div class="row pad-all-20">
              <div class="col-md-6">
                <h5 class="cases font-20"> Payment From Bank </h5>
              </div>
              <? if($totalamt!=0){?>
              <div class="col-md-6" style="text-align: right">
              <button class="btn btn-default" id="addpay"  onclick="makePayment('','','1')">Add Payment</button>
              </div>
              <? } ?>
            </div>
            <!-- Tab panes -->
            <?php if(!empty($payment)){?>
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
                                 
                                  <th>Amt. Paid To</th>
                                   <th>Amt. Paid</th>
                                   <th>Date Of Payment</th>
                                   <th>Payment Mode</th>
                                   <th>Instrument Date</th>
                                   <th>Instrument Number</th>
                                   <th>Bank Name</th>
                                   <th>Remark</th>
                                   <th>Action</th>
                                   
                                </tr>
                             </thead>
                             <tbody>
                             <?php 
                             $i=1;
                             $clr = '0';
                            foreach($payment as $ky => $vl){
                               if($vl['payment_by']=='2')
                               {
                                 $clr = '1';
                               }
                             $i=$i++; ?>
                                <tr>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_by']=='1')
                                       {
                                          echo "Customer";
                                        }else if($vl['payment_by']=='2')
                                        {
                                            echo "Inhouse";
                                        }
                                        else if($vl['payment_by']=='3')
                                        {
                                            echo "Showroom";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <i class="fa fa-rupee"></i> <?=$vl['amount']?> 
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=date('d M, Y',strtotime($vl['payment_date']))?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_mode']=='1')
                                       {
                                          echo "Cash";
                                        }else if($vl['payment_mode']=='2')
                                        {
                                            echo "Cheque";
                                        }
                                        else if($vl['payment_mode']=='3')
                                        {
                                            echo "DD";
                                        }
                                        else if($vl['payment_mode']=='4')
                                        {
                                            echo "Online";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <? if((($vl['payment_mode']=='2') ||($vl['payment_mode']=='3') ) && ($vl['instrument_date']!='0000-00-00')){ echo date('d M, Y',strtotime($vl['instrument_date'])) ;} else{ echo ""; }?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <?=$vl['instrument_no']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <? if(($vl['payment_mode']=='2') ||($vl['payment_mode']=='3') ){ echo $vl['bank_name']; } else{ echo ""; }?>
                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=$vl['pay_remark']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <?php  $id=$vl['id'];?>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment('1',<?=$id?>,'1')">Edit Payment</button>
                                    
                                  </td>
                                </tr>
                                <?php } ?>
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
      </div>
<?php // echo "<pre>";print_r($CustomerInfo);die; ?>
      <div class="row inhousesh" <?=!empty($clr)?'style="display:block;"':'style="display:none;"'?>>
        <div class="wrapper col-md-12 mrg-T30">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <h5 class="cases font-20"> Net Payable Amount : <span id="net_pay"> </span></h5>
                </a>
              </h4>
            </div>
              <?php //echo "<pre>";print_r($CustomerInfo);
              if(empty($CustomerInfo['disbursed_amount'])){
                $disbur = (empty($CustomerInfo['approved_loan_amt'])? $CustomerInfo['file_loan_amount']:$CustomerInfo['approved_loan_amt']);
               }else{
                 $disbur = $CustomerInfo['disbursed_amount'];
               }
              // echo $disbur;die;
              ?>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <form  enctype="multipart/form-data" method="post"  id="net_payment_form" name="net_payment_form">
                 <input type="hidden" name="net_case_id" id="case_id" value="<?=$CustomerInfo['customer_loan_id']?>">
                 <input type="hidden" name="update_id" id="update_id" value="<?=$paymentDetails['id']?>">
                 <input type="hidden" name="loan_sno" id="loan_sno" value="<?=$CustomerInfo['loan_srno']?>">
		 <input type="hidden" name="net_amount" id="net_amount" value="<?=$CustomerInfo['net_amount']?>">                 
	         <div class="row">                   
                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Loan Amount</label>
                            <input type="text" name="net_laon_amount" id="net_laon_amount"  class="rupee-icon form-control crm-form"  value="<?= !empty($CustomerInfo['loan_amount'])?$CustomerInfo['loan_amount']:$disbur ?>" readonly="true">
                           
                            <!--<div class="d-arrow"></div>-->
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Loan Short Amount</label>
                            <input type="text" name="net_payment_short" onblur="calculateNetPayment()" onkeypress="return isNumberKey(event)" maxlength="7" id="net_payment_short" class="form-control rupee-icon crm-form" value="<?= (!empty($paymentDetails['loan_short']) || ($paymentDetails['loan_short']=='0'))? $paymentDetails['loan_short']:$CustomerInfo['loan_short'] ?>" onkeyup="addCommas(this.value, 'net_payment_short');" placeholder="0">
                             <span class="error" id="err_net_payment_short"></span>
                        </div>
                  </div>
                </div>

                  <div class="row">
                    <div class="col-md-12"><h2 class="sub-title mrg-T0">Deductions</h2></div>
                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Processing Fee</label>
                            <input type="text" onblur="calculateNetPayment()" onkeypress="return isNumberKey(event);" name="net_processing_fee" maxlength="7" id="net_processing_fee" class="rupee-icon form-control crm-form" value="<?= (!empty($paymentDetails['processing_fee']) || ($paymentDetails['processing_fee']=='0') ) ? $paymentDetails['processing_fee']: $CustomerInfo['fee_disburse']?>" placeholder="0" onkeyup="addCommas(this.value, 'net_processing_fee');">
                            <span class="error" id="err_net_processing_fee"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Advance EMI</label>
                             <select class="form-control crm-form emi-drop" name="net_counter_emi" id="net_counter_emi" readonly="true">
                                 <option value="<?=$CustomerInfo['counter_emi'] ?>" <?= ((isset($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '0')) ? 'selected' : '') ?>><?=$CustomerInfo['counter_emi']?> </option>
<!--                                    <option value="0" <?= ((isset($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '0')) ? 'selected' : '') ?>>0</option>
                                    <option value="1" <?= (!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '1')) ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= (!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '2')) ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= (!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '3')) ? 'selected' : '' ?>>3</option>
                                    <option value="4" <?= (!empty($CustomerInfo['counter_emi']) && ($CustomerInfo['counter_emi'] == '4')) ? 'selected' : '' ?>>4</option>-->
                             </select>
                            <input type="text" name="net_total_emi" onkeypress="return isNumberKey(event);"  maxlength="7" id="net_total_emi" class="rupee-icon form-control crm-form emi-value" value="<?= !empty($CustomerInfo['total_emi']) ? $CustomerInfo['total_emi'] : 0 ?>" placeholder="0" onkeyup="addCommas(this.value, 'net_total_emi');" readonly="true">
                             <span class="error" id="err_net_total_emi"></span>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Insurance</label>
                            <input type="text" onblur="calculateNetPayment()" name="net_insurance" id="net_insurance" onkeypress="return isNumberKey(event);" class="rupee-icon form-control crm-form"  value="<?= (!empty($paymentDetails['insuranace']) || ($paymentDetails['insuranace']=='0') )?$paymentDetails['insuranace']:(!empty($premiumInt)?$premiumInt:0) ?>" onkeyup="addCommas(this.value, 'net_insurance');">
                           <span class="error" id="err_net_insurance"></span>
                        </div>
                    </div>
  
<?php if(($customerDetail[0]['loan_for']=='2') && (strtolower($customerDetail[0]['loan_type'])!='topup')){?>

                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">RC Tranferred By</label>
                            <span class="radio-btn-sec">
                                <input type="radio" name="rc_transfered" id="dealer_rc" value="1" class="trigger btype" <?= ((!empty($paymentDetails)  && $paymentDetails['rc_trans_by']=='1') || empty($paymentDetails))?'checked=checked':''?>>
                                <label for="dealer_rc"><span class="dt-yes"></span> Dealer</label>
                            </span>
                            <span class="radio-btn-sec">
                                <input type="radio" name="rc_transfered" id="inhouse_rc" value="2" class="trigger btype" <?= !empty($paymentDetails) && $paymentDetails['rc_trans_by']=='2'?'checked=checked':''?>>
                                <label for="inhouse_rc"><span class="dt-yes"></span> Inhouse</label>
                            </span>
                            <div class="error" id="err_rc_transfered"></div>
                       </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">RC Transfer Charges</label>
                            <input type="text" onblur="calculateNetPayment()" name="rc_trans_price" id="rc_trans_price" onkeypress="return isNumberKey(event);"  class="rupee-icon form-control crm-form"  value="<?= !empty($paymentDetails['rc_trans_price']) ? $paymentDetails['rc_trans_price'] : 0 ?>" onkeyup="addCommas(this.value, 'rc_trans_price');">
                           <span class="error" id="err_rc_trans_price"></span>
                        </div>
                    </div>

                    <?php } else{ ?>
                    <input type="hidden" name="rc_transfered" value="1" class="">
                    <?php } ?>
<?php //echo "<pre>";print_r($paymentDetails);die;?>

                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Other Adjustment</label>
                            <input type="text" onblur="calculateNetPayment()" name="other_adjustment" id="other_adjustment" onkeypress="return isNumberKey(event);" class="rupee-icon form-control crm-form"  value="<?= !empty($paymentDetails['other_adjustment']) ? $paymentDetails['other_adjustment'] : 0 ?>" onkeyup="addCommas(this.value, 'other_adjustment');" >
                           <span class="error" id="err_other_adjustment"></span>
                        </div>
                    </div>                  
                  </div>


                  <div class="row">
                    <div class="col-md-12"><h2 class="sub-title mrg-T0">Additional Details</h2></div>

                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Payout(%)</label>
                            <input type="text" name="net_payout" maxlength="5" id="net_payout"  class="form-control crm-form" onkeypress="return isRoiNumberKey(event);" value="<?= (!empty($paymentDetails['payout']) || ($paymentDetails['payout']=='0') )? $paymentDetails['payout']:$CustomerInfo['payout'] ?>" onkeyup="addCommas(this.value, 'net_payout');" >
                            <span class="error" id="err_net_payout"></span>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group mrg-B0" style="height:85px">
                            <label class="crm-label">Remarks</label>
                            <input type="text" name="net_remark" id="net_remark"  class="form-control crm-form"  value="<?= (!empty($paymentDetails['remark']) || ($paymentDetails['remark']=='')) ? $paymentDetails['remark']: '' ?>" >
                            <span class="error" id="err_net_remark"></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="btn-sec-width">
                            <button type="button" class="btn-continue saveCont  mrg-T0" style="display:block" onclick="saveEditNetPayment()" id="netpaydetails">SAVE</button>
                            
                        </div>
                    </div>
                  </div>
                </form>
                </div>
            </div>
          </div>
        </div>
        </div>
      </div>
        
      <div class="row">
        <div class="list_div col-md-12 mrg-T10">
            <div class="background-ef-tab inhousesh" id="loandetails" <?=!empty($clr)?'style="display:block;"':'style="display:none;"'?>>
              <div class="tabs loandetails">
                <div class="row pad-all-20">
                  <div class="col-md-6">
                    <h5 class="cases font-20"> Payment From Inhouse</h5>
                  </div>
                    <? if($out_amount>0){?>
            
                  <div class="col-md-6" style="text-align: right">
                  <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment('','','2')">Add Payment</button>
                  </div>
                  <?php } ?>
                </div>
                <!-- Tab panes -->
                <?php if(!empty($Clearance)){?>
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
                                      
                                       <th>Amt. Paid To</th>
                                       <th>Amt. Paid</th>
                                       <th>Date Of Payment</th>
                                       <th>Payment Mode</th>
                                       <th>Instrument Date</th>
                                       <th>Instrument Number</th>
                                       <th>Bank Name</th>
                                       <th>Remark</th>
                                       <th>Action</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php
                                    $i=1;
                             foreach($Clearance as $ky => $vl){

                             $i=$i++; ?>
                                <tr>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php 
                                       echo PAYMENT_BY_INHOUSE[$vl['payment_by']];
//                                       if($vl['payment_by']=='1')
//                                       {
//                                          echo "Customer";
//                                        }else if($vl['payment_by']=='2')
//                                        {
//                                            echo "Dealer";
//                                        }
//                                        else if($vl['payment_by']=='3')
//                                        {
//                                            echo "Showroom";
//                                        }
//                                         else if($vl['payment_by']=='4')
//                                        {
//                                            echo "Showroom";
//                                        }
//                                         else if($vl['payment_by']=='5')
//                                        {
//                                            echo "Showroom";
//                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <i class="fa fa-rupee"></i> <?=$vl['amount']?> 
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=date('d M, Y',strtotime($vl['payment_date']))?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_mode']=='1')
                                       {
                                          echo "Cash";
                                        }else if($vl['payment_mode']=='2')
                                        {
                                            echo "Cheque";
                                        }
                                        else if($vl['payment_mode']=='3')
                                        {
                                            echo "DD";
                                        }
                                        else if($vl['payment_mode']=='4')
                                        {
                                            echo "Online";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <? if((($vl['payment_mode']=='2') ||($vl['payment_mode']=='3') ) && ($vl['instrument_date']!='0000-00-00')){ echo date('d M, Y',strtotime($vl['instrument_date'])) ;} else{ echo ""; }?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <?=$vl['instrument_no']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <? if(($vl['payment_mode']=='2') ||($vl['payment_mode']=='3') ){ echo $vl['bank_name'] ;} else{ echo ""; }?>
                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=$vl['pay_remark']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <?php  $id=$vl['id'];?>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment('1',<?=$id?>,'2')">Edit Payment</button>
                                    
                                  </td>
                                </tr>
                                <?php } ?>
                                  </tbody>
                              </table>
                            </div>
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php  } ?>
            </div></div>
            <div class="col-md-12 mrg-B15">
                <div class="row btn-sec-width">
                    <input type="hidden" name="case_id" id="case_id" value="<?=$CustomerInfo['customer_loan_id']?>">
                     <input type="hidden" name="customer_id" id="customer_id" value="<?=$CustomerInfo['customer_id']?>">
                    <button type="button" class="btn-continue saveCont" style="display:block" id="paydetails">SAVE AND CONTINUE</button>
                </div>
            </div>

      </div>
    </div>
  <div class="modal fade" id="makePayment" role="dialog">

  <div class="modal-backdrop fade in" style="height:100%"></div>
      <div class="modal-dialog" style="width: 580px; height:100px;">
        <div class="modal-content" >

          <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
            <h4 class="modal-title">Make Payment</h4>
          </div>
          <div id="payment_modal"></div>
        </div>
    </div>
  </div>
  <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
    <script>
    $("#paydetails").click(function(){
        window.location.href =  base_url+"loanListing";
    });
        $(document).ready(function(){
            calculateNetPayment();
        })
    function makePayment(flag='',id='',tp="")
    {
       $('#makePayment').addClass(' in');
       $('#makePayment').attr('style','display:block');
       var gnat = $('.gnat').text();
      var type = 'add';
      if(flag!='')
      {
        type='edit';
      }
      var case_id = $('#case_id').val();
      var customer_id = $('#customer_id').val();
      $.ajax({
        url: base_url+"Finance/makepayment",
        type: 'post',
        dataType: 'html',
        data: {'case_id':case_id,type:type,'customer_id':customer_id,id:id},
        success: function(response)
        {
          $("#payment_modal").html(response);
          $('#type').val(type);
          $('#edit_id').val(id);
          $('#tp').val(tp);
              if(tp=='1')
              {
                $('.bank').attr('style','display:block;');
                $('.inhouse').attr('style','display:none;');
                if(id=='')
                $('#amount').val(gnat);
              }
              else
              {
                $('.bank').attr('style','display:none;');
                $('.inhouse').attr('style','display:block;');

              } 
           var date = new Date();
           var d = new Date();        
           d.setDate(date.getDate());
          $('#receiptdate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true   
          });

          $('#paydates').datepicker({
              format: 'dd-mm-yyyy',
              autoclose: true,
              endDate:d,
              todayHighlight: true   
          });
          $('#instrument_date').datepicker({
              format: 'dd-mm-yyyy',
              autoclose: true,
              todayHighlight: true   
          });
        }
      });
    }
    $('.close').click(function() {
      $('#makePayment').removeClass(' in');
       $('#makePayment').attr('style','display:none');
    })

    function saveEditData()
    {

        $("#paymentdetails").attr("disabled",true);
       // alert("SAfsdf");
      var  tp =  $('#tp').val();
        // alert(tp);
        // return false;
      var payment_by      = $.trim($('#payment_by').val());
      var inpayment_by      = $.trim($('#inpayment_by').val());
      var instrumenttype      = $.trim($('#payment_mode').val());
      var amount              = $.trim($('#amount').val());
      var paydates            = $.trim($('#paydates').val());
      var insno               = $.trim($('#instrument_no').val());
      var insdate             = $.trim($('#instrument_date').val());
      var payment_bank        = $.trim($('#payment_banks').val());
      var favouring           = $.trim($('#favourings').val());
      var workshop_id         = $.trim($('#workshop_id').val());
      var edit_id             = $.trim($('#edit_id').val());
      var remark             = $.trim($('#remark').val());
      var cust             = $.trim($('#cust').val());
//alert(cust);
      var case_id = $.trim($('#case_id').val());
    
      var error               = 0;
      $(".error").html("");
      if(tp=='1'){
      if(payment_by == '0'){    
        $("#err_payment_by").html("Please select Payment by.");   
        error++;    
      }
    }else
    {
      if(inpayment_by == '0'){    
        $("#err_inpayment_by").html("Please select Payment by.");   
        error++;  
      }
    }
      if(instrumenttype == '0'){
                  $("#err_instrumenttypes").html("Please select Payment mode.");
        error++;
      }

      if(amount == ''){
        $("#err_amounts").html("Please enter amount.");
        error++;
      }else{
         var loan_amount = amount.replace(/,/g, '');
          if(loan_amount.length > 8)
               {
                    $('#err_amounts').html("Please Enter valid Amount");
                    error++;
               }
           
        var aaa = amt_schk(case_id,loan_amount,edit_id,tp);
       
        var purchaseamt = $('.gnat').text().replace(/,/g, '');
        var net_pay = $('#net_pay').text().replace(/,/g, '');
       // alert(loan_amount+'-'+aaa);
        var newsum = parseInt(aaa)+parseInt(loan_amount);
         var newnetpaysum = parseInt(aaa)+parseInt(loan_amount);
         // alert(newsum+'-'+purchaseamt);
        if((newsum>purchaseamt) && (tp=='1') ||(newsum==NaN))
        {
          $('#err_amounts').html("Amt should not exceed Net Disb Amt.");
          error++;
        }
        // alert(newnetpaysum+'-'+net_pay);
        if((newnetpaysum>net_pay) && (tp=='2') || (newnetpaysum==NaN))
        {
          $('#err_amounts').html("Amt should not exceed Net Payable Amt.");
          error++;
        }

      }
      if(paydates == ''){
        $("#err_paydate").html("Please select payment date.");
        error++;
      }
     
      if(instrumenttype=='2')
      {

         /* if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }*/

          if(insdate == ''){
           // $("#err_insdates").html("Please select instrument date.");
           // error++;
          }

          if(payment_bank == ''){
           // $("#err_bank_lists").html("Please select bank name.");
           // error++;
          }

          if(favouring == ''){
         //   $("#err_favourings").html("Please enter favouring.");
         //   error++;
          }
      }

      if(instrumenttype=='3')
      {
          if(insno == ''){

          }

          if(insdate == ''){
          //  $("#err_insdates").html("Please select instrument date.");
           // error++;
          }

          if(favouring == ''){
          // $("#err_favourings").html("Please enter favouring.");
           // error++;
          }
      }

      if(instrumenttype=='4')
      {
          if(insno == ''){

          }
      }
      if(payment_by=='2')
      {
       // $('.inhousesh').attr('style','display:block !important');
      }
      if(error > 0){
        $("#paymentdetails").attr("disabled",false);
        return false;
      } else{
        $(".loaderClas").show();
         var formData=$('#CaseInfoForm').serialize();
        $.ajax({
          url: base_url+"Finance/save_payment",
          type: 'post',
          dataType: 'json',
          data:formData,
          //data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,paydates:paydates,workshop_id:workshop_id,edit_id:edit_id,remark:remark},
          success: function(response) 
          {
            $(".loaderClas").hide();
            if(newsum==purchaseamt)
            {
              $('#addpay').attr('style','display:none !important');
            }
            else
            {
              $('#addpay').attr('style','display:block !important');
            }
            setTimeout(function(){ location.href = base_url+"loanpayment/"+cust; }, 300);
          }   
        });
      }

    }

      function amt_schk(case_id,amount,edit_id='',type)
    {
      var ss = 0;
        $.ajax({
          url: base_url+"Finance/checkamout",
          type: 'post',
          dataType: 'json',
          async : false,
          data:{case_id:case_id,amount:amount,edit_id:edit_id,type:type},
          success: function(response) 
          {
           //alert(response+'d');
             ss = parseInt(response);
             if(response==0)
             {
                  ss='a';
             }
          }
        });  
        if((ss>0)&&(ss!='a'))
        return ss;
        else
          return 0;
    }

    function addCommased(nStr,control,flag='')
  {
      //alert("sdf");
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
     function addCommased1(nStr,control,flag='')
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
      var netpay = x1 +x3+x2;
      return netpay;
  }
/*$('#payment_mode').change(function(){
  var inst = $('#payment_mode').val();
  if(inst=='1')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:none;');
  }
  if(inst=='2')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
  }
  if(inst=='3')
  {
      $('#div_insdate').attr('style','display:block;');
      $('#bnk').attr('style','display:block;');
      $('#favo').attr('style','display:block;');
      $('#div_ins').attr('style','display:block;');
  }
  if(inst=='4')
  {
      $('#div_insdate').attr('style','display:none;');
      $('#bnk').attr('style','display:none;');
      $('#favo').attr('style','display:none;');
      $('#div_ins').attr('style','display:block;');
  }
});
*/
function showInfoBox()    
{   
  $('#infoBox').attr('style','display:block');    
}
$('.close').click(function(){
  $('#infoBox').attr('style','display:none'); 
})
 function saveEditNetPayment()
 {      
      var rc_transfered = $('input[name=rc_transfered]:checked').val(); 
      var cust             = "<?=base64_encode('CustomerId_'.$customerDetail[0]["customer_loan_id"])?>"
      var error               = 0;
//      if(rc_transfered == undefined)
//      {
//            $("#err_rc_transfered").html("Please select RC Tranferred By.");
//            error++;
//      }
      if(error > 0){
        return false;
      } else{
        $(".loaderClas").show();
        var formData=$('#net_payment_form').serialize();
        $.ajax({
          url: base_url+"Finance/save_net_payment",
          type: 'post',
          dataType: 'json',
          data:formData,
          success: function(response) 
          {
            $(".loaderClas").hide();
            setTimeout(function(){ location.href = base_url+"loanpayment/"+cust; }, 300);
          }   
        });
      }

    }
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    function calculateNetPayment(){
        var laon_amount = $("#net_laon_amount").val().replace(/,/g, '');
        var net_payment_short =  $("#net_payment_short").val().replace(/,/g, '');
        if(net_payment_short == "")
             net_payment_short = 0;
        var net_processing_fee =  $("#net_processing_fee").val().replace(/,/g, '');
        if(net_processing_fee == "")
             net_processing_fee = 0;
        var net_total_emi =  $("#net_total_emi").val().replace(/,/g, '');
        if(net_total_emi == "")
             net_total_emi = 0;
        var net_insurance =  $("#net_insurance").val().replace(/,/g, '');
        if(net_insurance == "")
             net_insurance = 0;
        if($("#rc_trans_price").val()!=undefined){
            var rc_trans_price =  $("#rc_trans_price").val().replace(/,/g, '');
        }
        if((rc_trans_price == "") || (rc_trans_price == undefined))
             rc_trans_price = 0;
        var other_adjustment =  $("#other_adjustment").val().replace(/,/g, '');
        if(other_adjustment == "")
             other_adjustment = 0;
        var total_loan = parseInt(laon_amount) + parseInt(net_payment_short);
        var total_deduction = parseInt(net_processing_fee) + parseInt(net_total_emi) + parseInt(net_insurance) + parseInt(rc_trans_price) + parseInt(other_adjustment);
        var net_payable_amount = parseInt(total_loan) - parseInt(total_deduction);
        $("#net_amount").val(net_payable_amount);
        var total_clearance_amount = "<?=$total_clearance_amount?>";
          var netpayamtcheck = "<?=$netpayamtcheck?>";
        total_clearance_amount = total_clearance_amount.replace(/,/g, '');
         var outstanding_amount = 0;
        if(netpayamtcheck>0){
          var outstanding_amount = parseInt(net_payable_amount) - parseInt(total_clearance_amount);
        }
        outstanding_amount =  addCommased1(outstanding_amount, 'leftPaid',1);
        var val_net = addCommased1(net_payable_amount, 'net_pay',1);
       $("#net_pay").html('<i class="fa fa-rupee"></i>'+val_net);
       if(netpayamtcheck>0)
       {
               $("#purchaseamt").html(val_net);
       }
       else
       {
               $("#purchaseamt").html('0');
       }
       $("#leftPaid").html(outstanding_amount);
       
    }
    function isRoiNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && (charCode!=46))
        return false;
    return true;
}
</script>
  