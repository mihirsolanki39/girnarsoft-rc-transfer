<div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">CPV Details</h2>
                     <div class="white-section section-wh">
                     <form id="cpv_detail" method="post" action="">
                        <div class="row">
                        <?php if(!empty($loanDetail)){
                          $i=0;
                          $bankIDs = '';
                          $cont = count($loanDetail);
                          foreach ($loanDetail as $key => $value) { 
                          $bankIDs .= $value['bank_id'].','; 
                          $logoLink = '';
                          if(!empty($value['financer_logo']))
                          {
                            $finalogo = explode('-', $value['financer_logo']);
                            $logoLink = BANK_LOGO.$finalogo[0];
                          } 
                          $i++;    
                          $case_id = $value['case_id'];                 
                            ?>
                           <div class="col-md-4">
                              <div class="bank-box">
                                <div class="t-head clearfix">
                                  <div class="pull-left">
                                     <img src="<?php  echo $logoLink; ?>"  alt="<?=$value['bank_name']?>">  
                                  </div>
                                  <div class="pull-right">
                                    <ul class="icon-ul">  
                                      <li><span class="<?php echo (!empty($value['file_tag'])?strtolower($value['file_tag']):'filed') ?>"><?php if(!empty($value['file_tag'])){ echo $value['file_tag']; } ?></span></li>  
                                    </ul>  
                                  </div>
                                </div>
                                  
                                 <div class="t-body clearfix">
                                 
                                   <div class="col-100 form-group clearfix Valuation-status">
                                 <label class="crm-label">Enter Valuation Status</label>
                                  <span class="radio-btn-sec">
                                     <input type="radio" name="CPV_<?=$i?>" id="pending_<?=$i?>" value="0"  <?php echo ($value['valuation_status'] == '0') ? 'checked="checked"' : ''; ?>  class="trigger" checked="">
                                     <label for="pending_<?=$i?>"><span class="dt-yes"></span> Pending</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="CPV_<?=$i?>" id="complete_<?=$i?>" value="1" <?php echo ($value['valuation_status'] == '1') ? 'checked="checked"' : ''; ?> class="trigger">
                                     <label for="complete_<?=$i?>"><span class="dt-yes"></span> Complete</label>
                                 </span>
                                 <div class="error" id="errCPV_<?=$i?>"></div>
                              </div>
                                     
                                 <div class="col-100 form-group">
                                    <label class="crm-label">Enter CPV Status</label> 
                                      <select class="form-control cpvs crm-form" id="cpvstatus_<?=$i?>" name="cpvstatus_<?=$i?>"  onchange="remarkCpv(this);">
                                        <option value="0" <?php echo ($value['cpv_status'] == '0') ? 'selected="selected"' : ''; ?>>Select</option>
                                        <option value="1" <?php echo ($value['cpv_status'] == '1') ? 'selected="selected"' : ''; ?>>Positive</option>
                                        <option value="2" <?php echo ($value['cpv_status'] == '2') ? 'selected="selected"' : ''; ?>>Negative</option>
                                        <option value="3" <?php echo ($value['cpv_status'] == '3') ? 'selected="selected"' : ''; ?>>Neutral</option>
                                      </select>
                                      <div class="d-arrow"></div>
                                      <div class="error" id="errcpvstatus_<?=$i?>"></div>
                                  </div>
                                     <div class="col-100 form-group clearfix" id="cpvrm_<?=$i?>">
                                         <label class="crm-label">Bank User Remarks</label> 
                                          <input class="form-control crm-form" name="cpvremark_<?=$i?>" id="cpvremark_<?=$i?>" placeholder="Remark" value="<?php echo (!empty($value['bank_remark'])?trim($value['bank_remark']):''); ?>">
                                          <div class="error mrg-T20" id="errcpvremark_<?=$i?>"></div>
                                     </div>
                                      
                                          <input type="hidden" name="mappid_<?=$i?>" value="<?=$value['id']?>" id="mappid_<?=$i?>" >
                                          <input type="hidden" name="mapp_id[]" value="<?=$value['id']?>">
                                          <input type="hidden" id="case_id" name="case_id" value="<?=$value['case_id']?>" >
                                     
                                </div>
                              </div>
                            </div>
                            <?php } } ?>

                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input type="hidden" id="caseId" name="caseId" value="<?=$case_id?>" >
                                  <input type="hidden" value="1" name="LeadCPVForm">
                                  <input type="hidden" value="<?=trim($bankIDs,',')?>" name="bank_id">
                                  <input type="hidden" value="<?=$CustomerInfo['customer_id']?>" name="customer_id">
                                  <input type="hidden" name="disbrsal" value="<?=(!empty($disbural))?$disbural:''?>" id="disbrsal">
                                   <input type="hidden" id="countTotal" name="countTotal" value="<?=!empty($cont)?$cont:''?>" >

                                   <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                     if(((!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4')) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0') || (($rolemgmt[0]['edit_permission']=='1') && (!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))) && (($rolemgmt[0]['role_name']!='admin')))
                                      {
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('decisionDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                                      }
                                   if($CustomerInfo['cancel_id']=='0'){ ?>
                                    <a class="btn-continue saveCont" style="<?=$stylesss?>"  id="cpvfilelogin">SAVE AND CONTINUE</a>
                                     <a class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</a>
                                    <?php } ?>
                               </div>
                           </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
             <script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
             <script>
               function remarkCpv(sel)
               {
                  var va = sel.value;
                  var ids =sel.id;
                  var gs = ids.split('_');
                  //alert(va);
                 /* if(va == '2')
                  {
                    $('#cpvrm_'+gs[1]).attr('style','display:block');
                  }
                  else
                  {
                    $('#cpvrm_'+gs[1]).attr('style','display:none');
                  }

                  */
               }
               $(document).ready(function() {
                  $('.cpvs').trigger('change');
                });
             </script>
