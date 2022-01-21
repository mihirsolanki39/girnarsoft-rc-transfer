
<style>
.modal-backdrop {
    z-index: 0 !important;
}
 .error{font-size:12;color:red;}
 .popcls{padding: 0 15px;}
</style>  
<!-- view images modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-uploadPhoto">
  <div class="modal-dialog modal-lg">
  <div id="image-list"></div>
  </div>
</div>
<!-- make premium modal-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="make-premium">
  <div class="modal-dialog modal-lg">
      
        <!-- Modal content-->
<div id="premium-modal-data">
</div>

  </div>
</div>
<!-- Issue Warranty modal -->
<div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-issuewarrenty">
    <div class="modal-body" id="inspection_report">

    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="cancel_booking">
    <div class="modal-dialog">
        <div class="modal-content"  > 
           <div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"></button>
                     <h4 class="modal-title">Cancel Booking</h4>
                 </div>
                 <div class="modal-body text-center pad-all-15" id="booking-modal-content" >
                 </div>
        </div>
    </div>
 </div>


 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="buyersmsEmail">
     <div class="modal-dialog">
         <form name="buyersms_form" id="buyersms_form">
             <div class="modal-content" >
                 <div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"></button>
                     <h4 class="modal-title">Share with Lead</h4>
                 </div>
                 <div class="modal-body text-center pad-all-15" >
                     <?php
                     $pageArrname = explode('/', $_SERVER['PHP_SELF']);
                     if (end($pageArrname) == 'getLeads') {
                         ?>
                         <ul class="nav nav-tabs active" id="navbar">
                             <li class='active' id="liwhatsup"><a  id='li_whatsup' data-toggle="tab" href="#whatsup" onclick="sendSmsNewVersion($('#custoMobile').val(),'','whatsup',$('#email_id').val())">WhatsApp</a></li> 
                             <li class="" id="liemail"><a id='li_email'  data-toggle="tab" href="#email" onclick="sendSmsNewVersion($('#custoMobile').val(),'','email',$('#email_id').val())">Email</a></li>
                             <li  class="" id="lisms"><a id='li_sms' data-toggle="tab" href="#sms" onclick="sendSmsNewVersion($('#custoMobile').val(),'','message',$('#email_id').val())">SMS</a></li>        
                             <input type="hidden" name="lead_id" value='' id='lead_id' />
                         </ul>

                     <?php } else { ?>

                         <ul class="nav nav-tabs" id="navbar">
                             <li class="active"><a id='li_email'  data-toggle="tab" href="#email" onclick="sendsms($('#custoMobile').val(),'','email',$('#email_id').val())">Email</a></li>
                             <li ><a id='li_sms'data-toggle="tab" href="#sms" onclick="sendsms($('#custoMobile').val(),'','message',$('#email_id').val())">SMS</a></li>        
                             <input type="hidden" name="lead_id" value='' id='lead_id' />
                         </ul>
                     <?php } ?>
                     <div class="tab-content" >
                         <div id="email" class="tab-pane fade">
                             <div class="input-group mrg-T15 mrg-B15">
                                 <div class="input-group-addon "><i class="fa envelope" data-unicode="f0e0"></i></div>
                                 <input name="txtEmail" type="email" onkeydown="" maxlength="100" placeholder="Enter Email" id="email_id" class="form-control search-form-select-box " value="<?php //echo (($sqlRoleDetail['email']) ? $sqlRoleDetail['email'] : '') ?>">
                             </div>
                             <div id="buyer_lead_cars">

                             </div> 
                         </div>  

                         <div id="whatsup" class="tab-pane fade active in">
                             <div class="modal-body pad-all-15 pad-B0 pad-R0 pad-L0" id="buyerwhatsup_return" style="text-align:center">

                                 <div class="form-group">

                                     <div class="form-group text-left">

                                         <input id="whatsupcustoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="whatsupcustoMobile" value="" placeholder="Enter Mobile Number" readonly='readonly'>
                                     </div>
                                     <div class="form-group text-left">
                                         <span class="mrg-R10 mob-xs">
                                             <input type="radio" onclick="sendSmsNewVersion(this.id, this.value,'whatsup');" value="1" name="whatsuptype" id="whatsuptype1" class="smstype">
                                             <label for="whatsuptype1"><span></span>Send Reminder</label>
                                         </span>
                                         <span class="mrg-R10 mob-xs">
                                             <input type="radio" onclick="sendSmsNewVersion(this.id, this.value,'whatsup');"  value="2" name="whatsuptype" id="whatsuptype2" class="smstype">
                                             <label for="whatsuptype2"><span></span>Car Details</label>
                                         </span>
                                         <span class="mrg-R10 mob-xs">
                                             <input type="radio" onclick="sendSmsNewVersion(this.id, this.value,'whatsup');" value="3" name="whatsuptype" id="whatsuptype3" class="smstype">
                                             <label for="whatsuptype3"><span></span> Dealer Location</label>
                                         </span>
                                     </div>
                                     <div class="form-group text-left">

                                         <textarea class="form-control search-form-select-box feedBack" name="buyerwhatsupn" id="buyerwhatsupn" placeholder="Type Here ..."></textarea>
                                     </div>
                                 </div>


                             </div>
                         </div>
                         <div id="sms" class="tab-pane fade">
                             <div class="modal-body pad-all-15 pad-B0 pad-R0 pad-L0" id="buyersms_return" style="text-align:center">

                                 <div class="form-group">

                                     <div class="form-group text-left">

                                         <input id="custoMobile" class="form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="" placeholder="Enter Mobile Number" readonly='readonly'>
                                     </div>
                                     <div class="form-group text-left">
                                         <span class="mrg-R10 mob-xs">
                                             <input type="radio" onclick="sendSmsNewVersion(this.id, this.value);" value="1" name="smstype" id="smstype1" class="smstype">
                                             <label for="smstype1"><span></span>Send Reminder</label>
                                         </span>
                                         <span class="mrg-R10 mob-xs">
                                             <input type="radio" onclick="sendSmsNewVersion(this.id, this.value);"  value="2" name="smstype" id="smstype2" class="smstype">
                                             <label for="smstype2"><span></span>Car Details</label>
                                         </span>
                                         <span class="mrg-R10 mob-xs">
                                             <input type="radio" onclick="sendSmsNewVersion(this.id, this.value);" value="3" name="smstype" id="smstype3" class="smstype">
                                             <label for="smstype3"><span></span> Dealer Location</label>
                                         </span>
                                     </div>
                                     <div class="form-group text-left">

                                         <textarea class="form-control search-form-select-box feedBack" name="buyersmsn" id="buyersmsn" placeholder="Type Here ..."></textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>    
                     <div class="modal-footer pad-B0 pad-T0 pad-L0 pad-R0">
                         <span  id="success_message" style="color:green;font-family:Arial;font-size:14px"></span>
                         <span  id="error_message" style="color:red;font-family:Arial;font-size:14px"></span>
                         <input type="hidden" name="send_type" id="send_type" value="email"/>
                         <a type="button" class="buyersms_cancel mrg-R15" data-dismiss="modal" id="buyersms_cancel">CANCEL</a>
                         <?php if (end($pageArrname) == 'getLeads') {
                             ?>
                             <button type="button" class="btn btn-primary" id="buyersms_sub_v2" name="buyersms_sub_v2">SEND</button>
                         <?php } else { ?>
                             <button type="button" class="btn btn-primary" id="buyersms_sub" name="buyersms_sub">SEND</button>
                         <?php } ?>

                     </div>
                 </div>
             </div><!-- /.modal-comment -->
         </form>
     </div>
 </div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="stockFeature">
    <div class="modal-body text-center"> 
    <div class="modal-dialog">
         <form name="stockfeature_form" id="stockfeature_form">
             <div class="modal-content" >
                 <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Featured</h4>
            </div>

            <i class="fa info-circle col-gray font-60" data-unicode="f05a"></i>
            <div id="featurediv">
            
            </div>
            
             </div><!-- /.modal-comment -->
         </form>
     </div>
    </div>
 </div>



<!-- Popups Start -->
<!-- Booking Done -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="booking-done">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" id="bookoffersalecar">
        </div><!-- /.modal-comment -->
    </div>
</div>
<!-- Booking done End -->

<!-- Walk in Popup -->
<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="feedbackFrm">
    <div class="modal-dialog">
        <div class="modal-content" id='walkinfeedback' style="width:570px; margin:0px auto;">
        </div><!-- /.modal-comment -->
    </div>
</div>

<!-- Closed Feedback Form A Popup -->
<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="closedFrmA">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Closed Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12 clearfix">
                    <div class="row pad-B10">
                        Select what happened during walk in:
                    </div>
                    <div class="row">
                        <div class="">
                            <div class="">
                                <span class="mrg-R20">
                                    <input type="checkbox" name="certifications[]" id="1" value="2"><label for="1"><span></span>Customer needs some time. Will visit again</label>
                                </span> 
                            </div>
                            <div class="">
                                <span class="mrg-R20">
                                    <input type="checkbox" name="certifications[]" id="2" value="2"><label for="2"><span></span>Price negotiation going on</label>
                                </span> 
                            </div>
                            <div class="">
                                <span class="mrg-R20">
                                    <input type="checkbox" name="certifications[]" id="3" value="2" ><label for="3"><span></span>Car wasn't available, customer will visit again</label>
                                </span> 
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="clearfix pad-T5">

                </div>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
        </div><!-- /.modal-comment -->
    </div>
</div>

<!-- Closed Form B Popup -->
<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="closedFrmB">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Closed Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12 clearfix">
                    <div class="row pad-B10">
                        Select what happened during walk in:
                    </div>
                    <div class="row">
                        <div class="">
                            <div class="">
                                <span class="mrg-R20">
                                    <input type="checkbox" name="certifications[]" id="1" value="2"><label for="1"><span></span>Customer needs some time. Will visit again</label>
                                </span> 
                            </div>
                            <div class="">
                                <span class="mrg-R20">
                                    <input type="checkbox" name="certifications[]" id="2" value="2"><label for="2"><span></span>Price negotiation going on</label>
                                </span> 
                            </div>
                            <div class="">
                                <span class="mrg-R20">
                                    <input type="checkbox" name="certifications[]" id="3" value="2" ><label for="3"><span></span>Car wasn't available, customer will visit again</label>
                                </span> 
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="clearfix pad-T5">

                </div>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
            </div>
        </div><!-- /.modal-comment -->
    </div>
</div>

<!-- get history modal -->
<!--New timeline-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="timeline-new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Customer History</h4>
            </div>

            <div class="modal-body text-center pad-T15 pad-B15 pad-R15">

                <div id="commentHistory">
                </div>

                <!--</div>--> 
            </div>

        </div> 
    </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="stocksmsEmail">
     <div class="modal-dialog">
         
             <div class="modal-content" >
                 <div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"></button>
                     <h4 class="modal-title">Send Car Details</h4>
                 </div>
                 <div class="modal-body  pad-all-15" >
                <ul class="nav nav-tabs active" id="car_details">
                             <li class="active" id="li_car_details"><a id=''  data-toggle="tab" href="#car_details_tab" onclick="">Car Details</a></li>
                             <li  class="" id="li_quotes"><a id='' data-toggle="tab" href="#quotes_tab" onclick="loadQuotesModal()">Quotes</a></li>        
                </ul>
                 <div class="tab-content" >
                    <div id="car_details_tab" class="tab-pane active in">
                   
                    <ul class="nav active mrg-T15" id="navbar">
                           <span class="mrg-R10 mrg-T10 mob-xs" id="liemail">
                                    <input id='stock_email' name="share_care_details" type="radio" onclick="sendSmsNewVersion($('#customer_Mobile').val(),'','email',$('#emailId').val())" >
                                    <label for="stock_email"><span></span>Email</label>
                           </span>
                           <span class="mrg-R10 mrg-T10 mob-xs" id="lisms">
                                    <input id='stock_sms' name="share_care_details" type="radio" onclick="sendSmsNewVersion($('#customer_Mobile').val(),'','message',$('#emailId').val())" >
                                    <label for="stock_sms"><span></span>Sms</label>
                           </span>                           
                    </ul>
                    <form name="stocksms_form" id="stocksms_form">
                        <input type="hidden" name="car_id" value='' id='car_id' />
                        <div class="tab-content" >
                            <div id="email" class="tab-pane active in">
                                <div class="input-group mrg-T15">
                                   <style>.bd{border:1px solid #ddd; border-right: 0px}</style>
                                    <div class="input-group-addon bd"><i class="fa envelope" data-unicode="f0e0"></i></div>
                                    <input name="txtEmail" type="email" onkeydown="" maxlength="100" placeholder="Enter Email" id="emailId" class="form-control search-form-select-box email-address" value="<?php //echo (($sqlRoleDetail['email']) ? $sqlRoleDetail['email'] : '') ?>">
                                </div>
                                <div id="stock_lead_cars">

                                </div> 
                            </div>  


                            <div id="sms" class="tab-pane fade">
                                <div class="modal-body pad-all-15 pad-B0 pad-R0 pad-L0" id="stocksms_return" style="text-align:center">

                                    <div class="form-group">

                                        <div class="form-group text-left">

                                            <input id="customer_Mobile" onkeypress="return isNumberKey(event)" class=" custoMobile form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="" placeholder="Enter Mobile Number">
                                        </div>

                                        <div class="form-group text-left">

                                            <textarea class="form-control search-form-select-box feedBack" name="stocksmsn" id="stocksmsn" placeholder="Type Here ..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="modal-footer pad-B0 pad-T0 pad-L15 pad-R0">
                            <span  id="success_stock" style="color:green;font-family:Arial;font-size:14px"></span>
                            <span  id="error_stock" style="color:red;font-family:Arial;font-size:14px"></span>
                            <input type="hidden" name="send_type" class="share_type" value="email"/>
                            <a type="button" class=" stocksms_cancel mrg-R10" data-dismiss="modal" id="stocksms_cancel">CANCEL</a>
                             <?php if (end($pageArrname) == 'inventoryListing') {
                                ?>
                                <button type="button" class="btn btn-primary" id="stocksms_sub_v2" name="stocksms_sub_v2" onclick="sendSmsEmail()">Send</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary" id="stocksms_sub" name="stocksms_sub">Send</button>
                            <?php } ?>
                            


                        </div>
                   </form>
                    </div>
                     <div id="quotes_tab" class="tab-pane mrg-T15 ">
                        
                     </div>
                 </div>
                 </div>
             </div><!-- /.modal-comment -->
        
     </div>
 </div>








<div class="modal fade" id="rej_model" role="dialog" style="display: none">
    <div class="modal-backdrop fade in" style="height:100%"></div>
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeModel()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">Rejection Reason</h4>
                    </div>
                    <div class="modal-body">
                     <div class="col-50 form-group">
                        <label>Rejection Category</label>
                        <select class="form-control crm-form" name="rejection_type" id="rejection_type" onchange="populateRejectionReason(this.value)">
                        <option value="0"> Select One </option>
                        <?php  if(!empty($reject_reason)){
                        foreach($reject_reason as $key => $val){ ?>
                              <option value="<?=$val['id']?>"><?=$val['reject_reason']?> </option>
                        <?php  }  } ?>
                                              
                        </select>
                         <span class="d-arrow"></span>
                      </div>
                                    
                      <div class="col-50 form-group">
                      <label>Rejection Reason</label>
                          <select class="form-control crm-form" name="rejection_category" id="rejection_category">
                            <option value="0"> Select One </option>               
                          </select>
                          <span class="d-arrow"></span>
                      </div>
                      <input type="hidden" name="rejcase_id" id="rejcase_id" value="" >
                      <input type="hidden" name="reji_id" id="reji_id" value="" >
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="rej_now" onclick="rejNow()" class="btn-save btn-re">Reject Now</button>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="modal fade" id="relogin_model" role="dialog" style="display: none">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeModel()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">File Relogin</h4>
                    </div>
                    <form name="relogin_now" id="relogin_now" method="post">
                    <div class="modal-body">
                     <div class="col-50 form-group">
                        <label class="crm-label">Loan Amount</label>
                        <input type="text" class="form-control crm-form rupee-icon" name="loan_amount" onkeyup="emiCheck(this,'relogin')" value="" id="loanamount" >
                    </div>
                    <div class="col-50 form-group">
                        <label class="crm-label">Tenure <span class="month-t">(In Month)</span></label>
                        <input type="text" class="form-control crm-form" name="tenor_amount" onkeyup="emiCheck(this,'relogin')" value="" id="tenoramount">
                    </div>
                    <div class="col-50 form-group">
                        <label class="crm-label">ROI <span class="month-t">(%)</span></label>
                        <input type="text" class="form-control crm-form" name="roi_amount" onkeyup="emiCheck(this,'relogin')" value="" id="roiamount">
                    </div>
                    <div class="col-50 form-group">
                        <label class="crm-label">EMI</label>
                        <input type="text" class="form-control crm-form rupee-icon cr-form-read" name="emi_amount" value="" id="emiamount" readonly="readonly">
                    </div>
                                    

                      <input type="hidden" name="relogincase_id" id="relogincase_id" value="" >
                      <input type="hidden" name="module" id="module" value="" >
                      <input type="hidden" name="banid" id="banid" value="" >
                      <input type="hidden" name="relogini_id" id="relogini_id" value="" >
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="relogin_now" onclick="reloginNow();" class="btn-save btn-re">Relogin Now</button>
                    </div>
                    </form>
                  </div>
                  
                </div>
              </div>

<div class="modal fade" id="washout_model" role="dialog" style="display: none">
    <div class="modal-backdrop fade in" style="height:100%"></div>
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeModelNow()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">Washout Loan</h4>
                    </div>
                    <div class="modal-body">
                     <div class="col-50 form-group">
                        <label>Washout Category</label>
                        <select class="form-control crm-form" name="washout_type" id="washout_type" onchange="populateWashoutReason(this.value)">
                            <option value="0">Select One</option>
                            <option value="1">Case Lost</option>
                            <option value="2">Customer Issues</option>
                            <option value="3">RTO Issues</option>
                            <option value="4">Asset Issues</option>
                            <option value="5">Documents Incomplete</option>
                        
                                              
                        </select>
                         <span class="d-arrow"></span>
                      </div>
                                    
                      <div class="col-50 form-group">
                      <label>Washout Reason</label>
                          <select class="form-control crm-form" name="washout_category" id="washout_category">
                            <option value="0"> Select One </option>               
                          </select>
                          <span class="d-arrow"></span>
                      </div>
                      <input type="hidden" name="washcase_id" id="washcase_id" value="" >
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="washout_now" onclick="washNow()" class="btn-save btn-re mrg-T15">Washout Now</button>
                    </div>
                  </div>
                  
                </div>
              </div>

<div class="modal fade" id="cancel_model" role="dialog" style="display: none">
    <div class="modal-backdrop fade in" style="height: 100%;"></div>
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeModelNow()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">Cancel Loan</h4>
                    </div>
                    <div class="modal-body">
                     <div class="form-group mrg-B0">
                        <label>Cancel Category</label>
                        <select class="form-control crm-form" name="cancel_type" id="cancel_type">
                            <?php foreach (CancelReasonLoan as $key => $value) {?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                        <span class="d-arrow"></span>
                      </div>
                      <input type="hidden" name="cancelcase_id" id="cancelcase_id" value="" >
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="cancel_now" onclick="cancelNow()" class="btn-save btn-re mrg-T0">Cancel Now</button>
                    </div>
                  </div>
                  
                </div>
              </div>

<!-- get insurance history modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="trackhistory">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Customer History</h4>
            </div>

            <div class="modal-body">
                <div class="timeline_content">
                  <div class="row">
                     
                <div id="commentInsHistory">
                </div>
                 </div>
                 </div>   
                <!--</div>--> 
            </div>

        </div> 
    </div>
</div>
<!-- get rc history modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="trackrc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">RC History</h4>
            </div>

            <div class="modal-body">
                <div class="timeline_content">
                  <div class="row">
                     
                <div id="rcHistory">
                </div>
                 </div>
                 </div>   
                <!--</div>--> 
            </div>

        </div> 
    </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" id="insconf" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog ">
                  <!-- Modal content-->
                  <div class="modal-content" >
                     <div class="modal-header bg-gray">
                        <button type="button" id="xClose" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" align="center">Confirm Details</h4>
                     </div>
                     <div class="modal-body">
                        <div class="modal-body text-center">
                           You won't be able to make any changes after saving. Please preview all the details before saving.
                           <span id="insMsg"></span>
                        </div>
                     </div>
                     <div class="modal-footer">
                         <input type="hidden" name="frmid" id="frmid" value="">
                         <button type="button" class="btn btn-default stocksms_cancel" data-dismiss="modal" onclick="return confsaveins('2');" id="ins_cancel">Cancel</button>
                         <button type="button" class="btn btn-primary" id="ins_ok" onclick="return confsaveins('1');" name="ins_ok">Ok</button>                
                     </div>
                  </div>
               </div>
            </div> 

<div class="modal fade bs-example-modal-sm" tabindex="-1" id="loanPop" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog ">
                  <!-- Modal content-->
                  <div class="modal-content" >
                     <div class="modal-header bg-gray">
                        <button type="button" id="xClose"  onclick="return xClose();" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" align="center">Confirm Details</h4>
                     </div>
                     <div class="modal-body">
                        <div class="modal-body text-center">
                           You won't be able to make any changes after saving. Please preview all the details before saving.
                           <span id="loanMsg"></span>
                        </div>
                     </div>
                     <div class="modal-footer">
                         <input type="hidden" name="frmids" id="frmids" value="">
                         <button type="button" class="btn btn-default" data-dismiss="modal" onclick="return confsaveloan('2');" id="loan_cancel">Cancel</button>
                         <button type="button" class="btn btn-primary" id="loan_ok" onclick="return confsaveloan('1');" name="loan_ok">Ok</button>                
                     </div>
                  </div>
               </div>
            </div>
<!-- get insurance history modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="quotesbreakup">
    <div class="modal-dialog">
        <div class="modal-content" id="InsQuotesHist">
          
        </div> 
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" id="insQuoteconf" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog ">
                  <!-- Modal content-->
                  <div class="modal-content" >
                     <div class="modal-header bg-gray">
                        <button type="button" id="xClose" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="headerdiv" align="center">Confirm Details</h4>
                     </div>
                     <div class="modal-body">
                        <div class="modal-body text-center" id="bodysdiv">
                           You won't be able to make any changes after saving. Please preview all the details before saving.
                           <span id="insMsg"></span>
                        </div>
                     </div>
                     <div class="modal-footer">
                         <input type="hidden" name="ffrmid" id="ffrmid" value="">
                         <input type="hidden" name="quoteid" id="quoteid" value="">
                         <button type="button" class="btn btn-default stocksms_cancel" data-dismiss="modal" onclick="return confAcceptins('2');" id="ins_cancel">Cancel</button>
                         <button type="button" class="btn btn-primary" id="ins_ok" onclick="return confAcceptins('1');" name="ins_ok">Ok</button>                
                     </div>
                  </div>
               </div>
 </div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" id="insQuotedeleteconf" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog ">
                  <!-- Modal content-->
                  <div class="modal-content" >
                     <div class="modal-header bg-gray">
                        <button type="button" id="xClose" class="close" data-dismiss="modal">
                            <img src="<?=base_url('assets/admin_assets/images/cancel.png');?>">
                            <span class="sr-only">Close</span></button>
                        <h4 class="modal-title" align="center">Confirm Details</h4>
                     </div>
                     <div class="modal-body">
                        <div class="modal-body text-center">
                           Do You Want to delete this Quote?
                           <span id="insMsg"></span>
                        </div>
                     </div>
                     <div class="modal-footer">
                         <input type="hidden" name="delquoteid" id="delquoteid" value="">
                         <button type="button" class="btn btn-default stocksms_cancel" data-dismiss="modal" onclick="return deleteQuoteForm('2');" id="ins_cancel">Cancel</button>
                         <button type="button" class="btn btn-primary" id="ins_ok" onclick="return deleteQuoteForm('1');" name="ins_ok">Ok</button>                
                     </div>
                  </div>
               </div>
 </div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" id="insquotealert" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
               <div class="modal-dialog ">
                  <!-- Modal content-->
                  <div class="modal-content" >
                     <div class="modal-header bg-gray">
                        <button type="button" id="xClose" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" align="center">Quote Alert</h4>
                     </div>
                     <div class="modal-body">
                        <div class="modal-body text-center">
                           Please Accept Quote Before Proceeding.
                           <span id="insMsg"></span>
                        </div>
                     </div>
                  </div>
               </div>
 </div>
<!-- make refurb-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true" id="make-refurb">
  <div class="modal-dialog modal-sm" role="document"  style="width: 400px; margin: 50px auto">
            <div class="modal-content" style="width: 480px; margin: auto; border-radius: 5px;">
                <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Refurbishment Details</h4>
               </div>
               <div class="modal-body">
                   <div id="refurb-modal-data">
                       
                   </div>    
               </div>   
            </div>
        

  </div>
</div>
<!-- make refurb-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true" id="valid-refurb">
  <div class="modal-dialog modal-sm" role="document"  style="width: 400px; margin: 50px auto">
            <div class="modal-content" style="width: 480px; margin: auto; border-radius: 5px;">
                <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Refurbishment Details</h4>
               </div>
               <div class="modal-body">
                   <div id="valid-refurb-modal-data">
                       
                   </div>    
               </div>   
            </div>
        

  </div>
</div>
<!--Cancel Do-->
<div class="modal fade" id="cancel_do" role="dialog" style="display: none">
    <div class="modal-backdrop fade in" style="height: 100%;"></div>
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeDoModel()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">Cancel Do</h4>
                    </div>
                    <div class="modal-body">
                     <div class="form-group">
                        <label>Are You Sure You Want to Cancel DO?</label>
                        <select class="form-control crm-form" name="canceldo_type" id="canceldo_type">
                        <option value="0"> Select One </option>
                        <?php  if(!empty($cancel_reason)){
                            
                        foreach($cancel_reason as $key => $val){ ?>
                              <option value="<?=$val['id']?>"><?=$val['reason']?> </option>
                        <?php  }  } ?>
                        <option value="1">Other</option>
                                              
                        </select>
                         <span class="d-arrow"></span>
                      </div>
                      <div id="other_reas_div" style="display: none;">
                              <div class="form-group">
                                 <label for="" class="crm-label">Other Reason</label>
                                  <input type="text" class="form-control crm-form" placeholder="Other Reason" id="other_rea" name="other_rea" value="">
                                   <div class="error" id="err_other_rea"></div>
                                 </div>
                            </div>
                      <input type="hidden" name="do_id" id="do_id" value="">
                      <input type="hidden" name="other_id" id="other_id" value="1">
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="cncl_do" onclick="doCancelNow()" class="btn-save btn-re">Cancel Now</button>
                    </div>
                  </div>
                  
                </div>
              </div>
<script>
     $("#li_sms").click(function(){
     $("#send_type").val('sms');
     
 });
 $("#li_email").click(function(){
     $("#send_type").val('email');   
 });
 $("#li_whatsup").click(function(){
     $("#send_type").val('whatsup');   
 });
 $("#stock_sms").click(function(){
    $(".share_type").val('sms');
});
        $("#stock_email").click(function(){
        $(".share_type").val('email');
        });
     $('#uploadImage').click(function () {
        $('#model-uploadPhoto').attr('style','display:none;');
        $('body').css('overflow','auto');
        return false;
    });
 
     function populateWashoutReason(id)
     {
          $.ajax({
            type : 'POST',
            url : "<?php echo base_url(); ?>" + "Finance/populateWashoutReason/",
            data : {id:id},
            dataType: 'html',
            success: function (response) { 
                $('#washout_category').html(response);
            }
        });
                   
     }
     function cancelNow()
     {
        var cancel_type = $('#cancel_type').val();
        var cases_id = $('#case_id').val(); 
        var casess_id = $('#caseId').val();
        var cased_id = $('#caseid').val(); //cases_id
        if(cancel_type=='')
        {
            alert('Please Select Cancel Type');
        }
        if(casess_id>=1)
        {
            var case_id = casess_id;
        }
        else if(cases_id>=1)
        {
            var case_id = cases_id;
        }
        else
        {
           var case_id = cased_id; 
        }
        if((case_id>=1) && (cancel_type>=1))
        {
            $.ajax({
                type : 'POST',
                beforeSend : function(){
                   $('.loaderClas').attr('style','display:block;'); 
                },
                url : "<?php echo base_url(); ?>" + "Finance/cancelNow/",
                data : {type_id:cancel_type,type:'cancel',case_id:case_id},
                dataType: 'html',
                success: function (response) { 
                    $('#washout_category').html(response);
                    closeModelNow();
                    $('#Cancel').attr('style','display:none;');
                    $('.wash-out').html('<a href="#">Marked as Cancelled</a>');
                    setTimeout(function(){ window.location.href = "<?php echo base_url(); ?>"+"loanListing"; }, 300);
                },
                complete: function(){
                   $('.loaderClas').attr('style','display:none;'); 
                }
            });
        }
     }
     function washNow()
     {
       // alert('hhh');
        var washout_type = $('#washout_category').val();
        var cases_id = $('#case_id').val();
        var casess_id = $('#caseId').val();
        var cased_id = $('#caseid').val();
       // alert(washout_type+'-'+cases_id+'-'+casess_id+'-'+cased_id);
        if(washout_type=='')
        {
            alert('Please Select Washout Category');
            //return False;   
        } 
        //alert(cased_id);
        if(casess_id>=1)
        {
            var case_id = casess_id;
        }
        else if(cases_id>=1)
        {
            var case_id = cases_id;
        }
        else
        {
           var case_id = cased_id; 
        }
        if((case_id>=1) && (washout_type>=1))
        {
            $.ajax({
                type : 'POST',
                url : "<?php echo base_url(); ?>" + "Finance/cancelNow/",
                data : {type_id:washout_type,type:'washout',case_id:case_id},
                dataType: 'html',
                success: function (response) { 
                    $('#washout_category').html(response);
                    closeModelNow();
                    $('#Washout').attr('style','display:none;');
                    $('.wash-out').html('<a href="#">Marked as Washout</a>');
                    setTimeout(function(){ window.location.href = "<?php echo base_url(); ?>"+"loanListing"; }, 300);
                }
            }); 
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
	nStr=nStr.replace(/,/g,'');  
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
	}
	len=x1.length;
	if(len>=3 && x3!=""){
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	}
	document.getElementById(control).value=x1 +x3+x2;
}
function forceNumber(event){
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
        return false;
}
$('#canceldo_type').change(function(){
   var canceldo_type = $('#canceldo_type').val();
   var otherrea = $('#other_id').val();
   if(canceldo_type=='1')
   {
        $('#other_reas_div').attr('style','display:block');
   }
   else
   {
      $('#other_reas_div').attr('style','display:none');
      $('#other_reas_div').val(''); 
   }
});

function doCancelNow()
     {
        var canceldo_type = $('#canceldo_type').val();
       // var otherrea = $('#other_id').val();
        var otherreatext = $('#other_rea').val();
        var do_id = $('#do_id').val();
        var washout_type = '';
        if(canceldo_type==0)
        {
            alert('Cancel reason can not be empty');
            return false;
        }
        if((canceldo_type=='1') && (otherreatext==''))
        {
            alert('Other reason can not be empty');
            return false;
        } 
        else
        {
           washout_type  = '1'; 
        }
        
        if((do_id>=1) && (washout_type==1))
        {
            $.ajax({
                type : 'POST',
                url : "<?php echo base_url(); ?>" + "DeliveryOrder/cancelDoNow/",
                data : {canceldo_type:canceldo_type,otherreatext:otherreatext,do_id:do_id},
                dataType: 'json',
                success: function (response) { 
                   // $('#washout_category').html(response);
                   // closeModelNow();
                    $('#cancel_do').attr('style','display:none;');
                    $('#cancel_do').removeClass(' in');
                    $('#canceldo').html('<a href="#">Marked as Cancelled</a>');
                    setTimeout(function(){ window.location.href = "<?php echo base_url(); ?>"+"orderListing"; }, 300);
                }
            }); 
        }
     }

 </script>


