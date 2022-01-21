<?php $accessName=$this->router->fetch_method();?>
<?php
if(!empty($CustomerInfo['policy_status']) && $CustomerInfo['policy_status']=='1'){
 $washout = 'Mark as Cancelled';
 $washoutid='Cancelled';   
}elseif($accessName=='insPremiumDetails' || $accessName=='insDocumentDetails' || $accessName=='inspaymentDetail')
{
 $washout = 'Mark as Not Interested';
 $washoutid='notinterested';
}
else if($accessName=='insFilelogin' || $accessName=='inspersonalDetail' || $accessName == 'insvehicalDetail' || $accessName == 'insPreviousDetails' || $accessName=='insInspection' || $accessName=='insPolicyDetails')
{
 $washout = 'Mark as Not Interested';
 $washoutid='notinterested';
}
// echo "<pre>"; print_r($CustomerInfo);die;
?>
 <section class="all_details sticky">
         <div class="container-fluid">
            <div class="row">
              <?php if(!empty($CustomerInfo['ins_category'])){?>
                <div class="col-dc col-dc-width-auto">
                  <h3 class="subheading">S No.</h3>
                  <div class="sub-value">
                     <?php if(!empty($CustomerInfo['sno'])){ 
                        echo $CustomerInfo['sno'];
                     }
                     ?>
                  </div>
               </div>
               <?php } ?>
               <?php if(!empty($CustomerInfo['ins_category'])){?>
                <div class="col-dc col-dc-width-auto">
                  <h3 class="subheading">Category</h3>
                  <div class="sub-value">
                     <?php if(!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']=='1'){ 
                        echo 'New Car';
                     }elseif(!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']=='2'){
                         echo 'Used Car Purchase';
                     }elseif(!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']=='3'){
                         echo 'Renewal';
                     }elseif(!empty($CustomerInfo['ins_category']) && $CustomerInfo['ins_category']=='4'){
                         echo 'Policy Already Expired';
                     }
                     ?>
                  </div>
               </div>
               <?php } ?> 
               <?php if(!empty($CustomerInfo['buyer_type']) && $CustomerInfo['buyer_type']=='1'){?> 
               <div class="col-dc <?php echo (!empty($CustomerInfo['customer_name'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Buyer Details</h3>
                  <div class="sub-value">
                      <ul class="sub-value-list">
                          <?php if(!empty($CustomerInfo['customer_name'])){ ?>
                          <li><?php echo  $CustomerInfo['customer_name'];?></li>
                          <li><?php echo $CustomerInfo['mobile'];?></li>
                          <?php } else{ ?>
                          <li>NA</li>
                          <?php } ?>
                      </ul>    
                  </div>
               </div>
               <?php } else if(!empty($CustomerInfo['buyer_type']) && $CustomerInfo['buyer_type']=='2'){?>
               <div class="col-dc <?php echo (!empty($CustomerInfo['customer_company_name'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Buyer Details</h3>
                  <div class="sub-value">
                     <ul class="sub-value-list">
                         <?php if(!empty($CustomerInfo['customer_company_name'])){?>
                          <li><?php echo  $CustomerInfo['customer_company_name'];?></li>
                          <li><?php echo $CustomerInfo['mobile'];?></li>
                         <?php } else { ?>
                          <li>NA</li>
                         <?php } ?> 
                      </ul> 
                  </div>
               </div>
               <?php }else{ ?>
                <div class="col-dc">
                  <h3 class="subheading">Buyer Details</h3>
                  <div class="sub-value">
                     <?php echo 'NA';?>
                  </div>
               </div>
               <?php } ?> 
               <div class="col-dc <?php echo (!empty($CustomerInfo['makeName'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Car Details</h3>
                  <div class="sub-value">
                  <ul class="sub-value-list">
                  <?php if(!empty($CustomerInfo['makeName'])) {?>
                   <li>    
                  <?php if(!empty($CustomerInfo['makeName'])) { echo $CustomerInfo['makeName']; }?>
                  <?php if(!empty($CustomerInfo['modelName'])) { echo $CustomerInfo['modelName']; }?>     
                   </li>
                   <!--<li>
                  <?php //if(!empty($CustomerInfo['versionName'])) { echo $CustomerInfo['versionName']; }?>
                   </li>-->
                   <?php if(!empty($CustomerInfo['regNo'])) {?>
                   <li>
                  <?php echo strtoupper($CustomerInfo['regNo']); ?>
                   </li>
                   <?php }?>
                <?php }else{ ?>
                      <li>NA</li>
                <?php      
                  }
                  ?>
                  </ul>          
                  </div> 
               </div>
               <?php
                 if(!empty($CustomerInfo['ins_category']) && (($CustomerInfo['ins_category']=='3') || ($CustomerInfo['ins_category']=='4' && !empty($CustomerInfo["isexpired"]) && $CustomerInfo["isexpired"]=='0'))) { ?>
               <div class="col-dc <?php echo (!empty($CustomerInfo['previous_insurance_company'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">PYP Details</h3>
                  <div class="sub-value">
                  <ul class="sub-value-list">    
                 <?php if(!empty($CustomerInfo['previous_insurance_company'])) { ?>
                      <li><?php if(!empty($CustomerInfo['short_name'])) { echo $CustomerInfo['short_name']; }?></li>
                      <li><?php if(!empty($CustomerInfo['previous_ncb_discount'])) { echo 'NCB : '.$CustomerInfo['previous_ncb_discount'].'%'; }else{ echo "NA"; }  ?></li>
                 <?php }else{ ?>
                     <li>NA</li>
                 <?php } ?>
                  </ul> 
                  </div>
               </div>
                 <?php } ?>
                <div class="col-dc <?php echo (!empty($CustomerInfo['current_insurance_company'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">New Policy Details</h3>
                  <div class="sub-value">
                     <ul class="sub-value-list">
                      <?php if(!empty($CustomerInfo['current_insurance_company'])) {?> 
                     <li><?php echo !empty($CustomerInfo['curr_short_name']) ? $CustomerInfo['curr_short_name'] : '';?></li>
                     <?php if(!empty($CustomerInfo['current_policy_type'])){?>
                     <li><?php echo INSURANCE_POLICY_TYPE[$CustomerInfo['current_policy_type']];?></li>
                     <?php }?>
                     <li id="premium" class="indirupee rupee-icon"><?php echo !empty($CustomerInfo['premium']) ? $CustomerInfo['premium'] : '';?></li>
                     <?php } else {?>
                     <li>NA</li>
                     <?php } ?>
                     </ul>    
                  </div>
                </div>
                <?php
                $is_admin=$this->session->userdata['userinfo']['is_admin'];
                if((isset($permission[0]['role_name']) && (($permission[0]['role_name']=='Lead')) || ($is_admin=='1'))){ ?>
             <div class="wash-out">
            <a href="javascript:void(0);" id="<?php echo $washoutid?>"><?php echo $washout?></a>
            </div>
                <?php } ?>
            </div>    
         </div>
      </section>
          <?php 
                $is_inspection_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['INSPECTION'])
                    $is_inspection_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["inspection_status"]))
                      $is_inspection_checked  = 1;
               ?>
            <?php 
                $is_previous_policy_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['PREVIOUS_POLICY'])
                    $is_previous_policy_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["previous_insurance_company"]))
                      $is_previous_policy_checked  = 1;
            ?>
 <div class="row mrg-all-0">
            <div class="col-crm-left sidenav sidebar-ins" id="sidebar">
            <ul class="par-ul">
                 <?php 
                  $is_case_detail_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['CASE_DETAILS'])
                    $is_case_detail_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["ins_category"]))
                      $is_case_detail_checked  = 1;
                 ?>
                
               <li class="side_nav"><a href="<?= (!empty($CustomerInfo["ins_category"]))? base_url('addInsurance/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>" class="sidenav-a <?=($is_case_detail_checked == 1)? 'completed':'active'?>">
                        <span class="img-type"></span>Case Details</a>
               </li>
                <?php 
                  $is_vehicle_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['VEHICLE_DETAILS'])
                    $is_vehicle_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["make"]) && !empty ($CustomerInfo['cc']))
                      $is_vehicle_checked  = 1;
                 ?>
               <li class="side_nav"><a href="<?=(!empty($CustomerInfo["ins_category"]))? base_url('insvehicalDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>" class="sidenav-a <?php echo ($is_vehicle_checked == 1) ? 'completed':((isset($accessName) && ($accessName=='insvehicalDetail'))?'active':'#');?>">
                  <span class="img-type"></span>Vehicle Details</a>
               </li>
               <?php 
                  $is_quotes_checked   = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['INSURANCE_QUOTES'])
                    $is_quotes_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["quote_add_date"]) && $CustomerInfo["quote_add_date"]!='0000-00-00 00:00:00')
                      $is_quotes_checked   = 1;
                 ?>
               <li class="side_nav"><a href="<?= (!empty($CustomerInfo["make"]))? base_url('insFileLogin/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>" class="sidenav-a <?php echo ($is_quotes_checked ==1)? 'completed':((isset($accessName) && ($accessName=='insFilelogin'))?'active':'#');?>"> 
                  <span class="img-type"></span>Insurance Quotes</a>
               </li>
               <?php 
               $is_previous_policy_exist = "";
               $is_inspection_exist = "";
               if(empty($CustomerInfo)){
               ?>    
                <li class="side_nav"><a href="#" class="sidenav-a"> 
                  <span class="img-type"></span>Previous Policy</a>
               </li>
               <li class="side_nav"><a href="#" class="sidenav-a"> 
                  <span class="img-type"></span>Inspection</a>
               </li>   
               <?php } else {
                   if (!empty($CustomerInfo["ins_category"])) {
                       ?>
                        <?php if (($CustomerInfo["isexpired"] == '0' && $CustomerInfo["ins_category"] == '4') || ($CustomerInfo["ins_category"] == '3')) {
                            $is_previous_policy_exist =1; 
                            ?>       
                           <li class="side_nav"><a href="<?= ($is_quotes_checked == 1) ? base_url('insPreviousDetails/') . base64_encode('CustomerId_' . $CustomerInfo["customer_id"]) : '#' ?>" class="sidenav-a <?php echo ($is_previous_policy_checked == 1) ? 'completed' : ((isset($accessName) && ($accessName == 'insPreviousDetails')) ? 'active' : '#'); ?>"> 
                                   <span class="img-type"></span>Previous Policy</a>
                           </li>
                        <?php } if ($CustomerInfo["ins_category"] == '2' || $CustomerInfo["ins_category"] == '4') { $is_inspection_exist = 1; ?>
                           <li class="side_nav"><a href="<?= ($is_quotes_checked == 1) ? base_url('insInspection/') . base64_encode('CustomerId_' . $CustomerInfo["customer_id"]) : '#' ?>" class="sidenav-a <?php echo ($is_inspection_checked == 1) ? 'completed' : ((isset($accessName) && ($accessName == 'insInspection')) ? 'active' : '#'); ?>"> 
                                   <span class="img-type"></span>Inspection</a>
                            </li>
                    <?php }
                    }
                } 
                $is_cus_details_checked  = 0;
                if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['CUSTOMER_DETAILS'])
                    $is_cus_details_checked  = 1;
                }
                else if(!empty($CustomerInfo["customer_address"]))
                    $is_cus_details_checked  = 1;
                ?>
               <li class="side_nav"><a href="<?= ($is_quotes_checked == 1 && ($is_previous_policy_checked == 1 || $is_previous_policy_exist =="" ) && ($is_inspection_checked == 1 || $is_inspection_exist =="" ))? base_url('inspersonalDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>" class="sidenav-a <?= ($is_cus_details_checked ==1)?'completed':((isset($accessName) && ($accessName=='inspersonalDetail'))?'active':'#')?>"> 
                  <span class="img-type"></span>Customer Details</a>
               </li>
               <?php  
               if(!empty($CustomerInfo["mi_funding"] && $CustomerInfo["mi_funding"]=='1'))
                  $condition = $is_payment_checked =  "1";
               else
                  $condition = "";               
               ?>
               <?php if(!empty($CustomerInfo["mi_funding"]) && $CustomerInfo["mi_funding"]=='2'){ 
               if(!empty($CustomerInfo['PartPaymentDetails'][0]['total_amount_paid']) && !empty($CustomerInfo['PartPaymentDetails'][0]['totalpremium'])){
                  $condition = ($CustomerInfo['PartPaymentDetails'][0]['total_amount_paid']==$CustomerInfo['PartPaymentDetails'][0]['totalpremium'])?"1":"";
               }
               ?>
                <?php 
                  $is_payment_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($condition && $CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['PAYMENT_DETAILS'])
                    $is_payment_checked  = 1;
                 }
                 else if(!empty($CustomerInfo['customerPartPayments']))
                    $is_payment_checked  = 1;
                 ?>
               <li class="side_nav"><a href="<?= (!empty($CustomerInfo["customer_address"]))  ? base_url('inspaymentDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>" class="sidenav-a <?php echo ($is_payment_checked ==1) ? 'completed':((isset($accessName) && ($accessName=='inspaymentDetail'))?'active':'#');?>"> 
                  <span class="img-type"></span>Payment Details</a>
               </li>
               <?php  }?>
               <?php 
                  $is_policy_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if(!empty($condition) && $CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['NEW_POLICY_DETAILS'])
                    $is_policy_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["current_insurance_company"]))
                    $is_policy_checked  = 1;
                 ?>
               <li class="side_nav">
                   <a href="<?= ((!empty($condition )) && $is_payment_checked == 1)? base_url('insPolicyDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>" class="sidenav-a <?php echo ($is_policy_checked ==1) ? 'completed':((isset($accessName) && ($accessName=='insPolicyDetails'))?'active':'#');?>"> 

                  <span class="img-type"></span>New Policy Details</a>
               </li>
               <?php 
                  $is_document_checked  = 0;
                 if(!empty($CustomerInfo["left_menu_status"]) && $CustomerInfo["left_menu_status"] > 0){
                  if($CustomerInfo["left_menu_status"] >= INSURANCE_LEFT_SIDE_MENU['UPLOAD_DOCS'])
                    $is_document_checked  = 1;
                 }
                 else if(!empty($CustomerInfo["upload_ins_doc_flag"]))
                    $is_document_checked  = 1;
                 ?>
               <li class="side_nav"><a href="<?= ($is_policy_checked ==1)? base_url('insDocumentDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]):'#'?>"  class="sidenav-a <?php echo ($is_document_checked ==1) ? 'completed':((isset($accessName) && ($accessName=='insDocumentDetails'))?'active':'#');?>"> 
                  <span class="img-type"></span>Documents</a>
               </li>
               
            </ul>
         </div>
       
         <div class="col-crm-right">
        <div class="modal fade" id="washout_model" role="dialog" style="display: none">
            <style>
                #washout_model .d-arrow:after{top:16px;}
            </style>
            <div class="modal-backdrop fade in" style="height:100%"></div>
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeModelNow()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">Close Lead</h4>
                    </div>
                    <div class="modal-body">
                     <div class="col-150 form-group">
                        <select class="form-control crm-form" name="washout_reason" id="washout_reason">
                            <option value="0">Select Reason For Closing The Lead</option>
                            <option value="1">Did not like provided quotes</option>
                            <option value="2">Bought policy from somewhere else</option>
                            <option value="3">Vehicle inspection failed</option>
                            <option value="4">Other</option>
                        </select>
                        <div class="error" id="washout_reason_error" ></div>
                         <span class="d-arrow"></span>
                      </div>
                        <div class="form-group" id="divcloseOther" style="display:none;">
                            <label for="" class="crm-label">Other</label>
                            <input type="text" name="close_other"  id="close_other" class="form-control crm-form" value="" placeholder="Other">
                            <div class="error" id="close_other_error" ></div>
                       </div>  
                      <input type="hidden" name="washcase_id" id="washcase_id" value="" >
                          <input type="hidden" name="case_id" id="model_case_id" value="<?= !empty($CustomerInfo['id'])?$CustomerInfo['id']:""; ?>">
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="washout_now" onclick="washNowins()" class="btn-save btn-re">Close Lead</button>
                    </div>
                  </div>
                </div>
              </div>

              <!---Cancel Model---->
<div class="modal fade" id="cancel_model" role="dialog" style="display: none">
            <style>
                #cancel_model .d-arrow:after{top:32px;}
            </style>
            <div class="modal-backdrop fade in" style="height:100%"></div>
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header modal-header-custom">
                      <button type="button" class="close" onclick="closeModelNow()" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                      <h4 class="modal-title">Cancel Insurance</h4>
                    </div>
                    <div class="modal-body">
                     <div class="col-150 form-group">
                        <label>Cancel Category</label>
                        <select class="form-control crm-form" name="cancel_type" id="cancel_type">
                            <?php foreach (CancelReasonInsurance as $key => $value) {?>
                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                        <div class="error" id="cancel_type_error" ></div>
                        <span class="d-arrow"></span>
                      </div>
                      <div class="form-group" id="divcancelOther" style="display:none;">
                            <label for="" class="crm-label">Other</label>
                            <input type="text" name="cancel_other"  id="cancel_other" class="form-control crm-form" value="" placeholder="Other">
                            <div class="error" id="cancel_other_error" ></div>
                      </div>  
                      <input type="hidden" name="cancelcase_id" id="cancelcase_id" value="" >
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="cancel_now" onclick="cancelNowins()" class="btn-save btn-re">Cancel Now</button>
                    </div>
                  </div>
                  
                </div>
              </div>
              
         <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
      <div class="loaderoverlay loaderClas"></div>
      <script>
          $('.loaderClas').attr('style','display:none;');
      </script>    
      <style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
         </style>
         <script>
           $('#Cancelled').click(function(){
              $('#cancel_model').attr('style','display:block;');
              $('#cancel_model').addClass(' in');
           });
           $('#notinterested').click(function(){
              $('#washout_model').attr('style','display:block;');
              $('#washout_model').addClass(' in');
           });
           $('#washout_reason').on('change', function () {
            if($('#washout_reason').val()=='4'){
              $('#divcloseOther').show();
              //$('#divfollowup').hide();
          }else{
              $('#divcloseOther').hide();
              //$('#divfollowup').show();
          }
          });
          $('#cancel_type').on('change', function () {
            if($('#cancel_type').val()=='3'){
              $('#divcancelOther').show();
              //$('#divfollowup').hide();
          }else{
              $('#divcancelOther').hide();
              //$('#divfollowup').show();
          }
          });

          function cancelNowins()
     {
        $('.error').html('');
        var cancel_type = $('#cancel_type').val();
            if(cancel_type > 0){
            var customer_id = $('#customer_id').val();
            if(cancel_type=='3'){
                var cancelOther=$('#cancel_other').val();
                if(cancelOther==''){
                    $('#cancel_other_error').html('Please Enter Other Reason');
                    return false;
                }
            }
            if(cancel_type=='3'){
            var cancel_text = $("#cancel_other").val();
            }else{
             var cancel_text = $("#cancel_type option:selected").text();   
            }
            if(customer_id>=1)
            {
                $.ajax({
                    type : 'POST',
                    url : base_url+"Insurance/cancelNow",
                    data : {type_id:cancel_type,type:'cancel',customer_id:customer_id,canceltxt:cancel_text},
                    dataType: 'html',
                    success: function (response) { 
                        $('#washout_category').html(response);
                        closeModelNow();
                        $('#Cancel').attr('style','display:none;');
                        $('.wash-out').html('<a href="#">Marked as Cancelled</a>');
                        setTimeout(function(){ window.location.href = base_url+"insListing"; }, 3000);
                    }
                });
            }
        }else{
            $('#cancel_type_error').html('Please select cancel Reason');
        }
     }
         </script>
          <?php if(!empty($CustomerInfo['premium'])) { ?>
        <script>
          var abc = $('.indirupee').text();
                var cc = abc.split(' ');
               // alert(cc);
                indianform(cc);
            function indianform(x)
            {
              //var x=123456524578;
              x=x.toString();
              var lastThree = x.substring(x.length-3);
              var otherNumbers = x.substring(0,x.length-3);
              if(otherNumbers != '')
                  lastThree = ',' + lastThree;
              var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
              $('.indirupee').text(res);
            }
       </script>
       <?php } ?>