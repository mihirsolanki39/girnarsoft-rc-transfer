<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$role_name=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
$mode=(!empty($CustomerInfo['idv'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url('insDocumentDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_id"]) :'';
?>
<div class="container-fluid">
               <div class="row">
                   <form name="premiumform" id="premiumform" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Premium Details</h2>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">IDV*</label>
                                    <input type="text" name="idv" onkeypress="return isNumberKey(event)"  id="idv" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'idv');" value="<?php echo (!empty($CustomerInfo['idv'])) ? $CustomerInfo['idv'] : '';?>" placeholder="IDV" maxlength="10">
                                    <div class="error" id="idv_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">OD Amount*</label>
                                    <input type="text" name="od_amt" onkeypress="return isNumberKey(event)"  id="od_amt" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'od_amt');"  value="<?php echo (!empty($CustomerInfo['od_amt'])) ? $CustomerInfo['od_amt'] : '';?>" placeholder="OD Amount" maxlength="10">
                                    <div class="error" id="od_amt_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">NCB Discount</label>
                                    <input type="text" name="ncb" onkeypress="return isNumberKey(event)" id="ncb" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'ncb');" value="<?php echo (!empty($CustomerInfo['ncb'])) ? $CustomerInfo['ncb'] : '';?>" placeholder="NCB" maxlength="6">
                                    <div class="error" id="ncb_error" ></div>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="" class="crm-label">Accessories</label>
                                 <input type="text" name="accessories"  id="accessories" onkeypress="return isNumberKey(event)" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'accessories');" value="<?php echo (!empty($CustomerInfo['accessories'])) ? $CustomerInfo['accessories'] : '';?>" placeholder="Accessories" maxlength="6">
                                 <div class="error" id="accessories_error" ></div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     <label for="" class="crm-label">Malus.</label>
                                     <input type="text" name="extra_charge" onkeypress="return isNumberKey(event)" id="extra_charge" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'extra_charge');" value="<?php echo (!empty($CustomerInfo['extra_charge'])) ? $CustomerInfo['extra_charge'] : '0';?>" onclick="if(this.value==0) this.value='';" placeholder="Malus" maxlength="10">
                                 </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">Special Discount</label>
                                    <input type="text" name="special_discount" onkeypress="return isNumberKey(event)" id="special_discount" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'special_discount');" value="<?php echo (!empty($CustomerInfo['special_discount'])) ? $CustomerInfo['special_discount'] : '0';?>" onclick="if(this.value==0) this.value='';" placeholder="Special Discount" maxlength="10">
                             </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">GST*</label>
                                    <input type="text" name="gst" onkeypress="return isNumberKey(event)" id="gst" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'gst');" value="<?php echo (!empty($CustomerInfo['gst'])) ? $CustomerInfo['gst'] : '';?>" placeholder="GST" maxlength="5">
                             </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="" class="crm-label">Premium Paid</label>
                                    <input type="text" name="premium" onkeypress="return isNumberKey(event)" id="premium" class="form-control crm-form rupee-icon" onpaste="return false;" onkeyup="addCommas(this.value, 'premium');" value="<?php echo (!empty($CustomerInfo['premium'])) ? $CustomerInfo['premium'] : '';?>" placeholder="Premium Paid" maxlength="10">
                                    <div class="error" id="premium_error" ></div>
                             </div>
                            </div>
                           
                         
                            
                            
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                   <input  style="text-align: center" type="button" class="btn-continue" name="btnform6" id="btnform6" value="SAVE AND CONTINUE">
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['idv']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                                  <input type="hidden" name="step6" value="true">
                                  <input type="hidden" name="insfrm6" id="insfrm6" value="">
                                  <input type="hidden" name="roleType" id="roleType" value="<?php echo $role_name;?>">
                                  <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                               </div>
                           </div>
                        </div>
                     </div>
                   
                      
                  </div>
                   </form>
               </div>
            </div>
         </div>
         <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
         <script src="<?php echo base_url(); ?>assets/js/insuranceValidation.js" type="text/javascript"></script>
         <script>
      $('#od_amt').keyup(function() {
           premiumPaid();
      });
      $('#ncb').keyup(function() {
          premiumPaid();
      });
      $('#accessories').keyup(function() {
          premiumPaid();
      });
      $('#extra_charge').keyup(function() {
          premiumPaid();
      });
      $('#special_discount').keyup(function() {
          premiumPaid();
      });
      $('#gst').keyup(function() {
         premiumPaid(); 
      });
       function premiumPaid()
       {
         var idv = $('#idv').val();
         idv=idv.replace(/,/g, '');
         var od_amt = $('#od_amt').val();
         od_amt=od_amt.replace(/,/g, '');
         var ncb = $('#ncb').val();
         ncb=ncb.replace(/,/g, '');
         var accessories = $('#accessories').val();
         accessories=accessories.replace(/,/g, '');
         var extra_charge = $('#extra_charge').val();
         extra_charge=extra_charge.replace(/,/g, '');
         var special_discount = $('#special_discount').val();
         special_discount=special_discount.replace(/,/g, '');
         var gst = $('#gst').val();
         gst=gst.replace(/,/g, '');
         if((od_amt>0) && (ncb>0) && (accessories>0) && (extra_charge!='') && (special_discount!='') && (gst!='')) {
         var totpremium=  parseInt(od_amt) + parseInt(gst)+ parseInt(accessories) + parseInt(extra_charge);
         var sum =  totpremium -  (parseInt(ncb) + parseInt(special_discount)) ;
         if (sum) { 
            //sum = sum.replace(/,/g, ''); 
            sum += ''; 
            x = sum.split('.'); 
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
            $('#premium').val(x1 +x3+x2);
        } 
            
         }
       }  
     </script>