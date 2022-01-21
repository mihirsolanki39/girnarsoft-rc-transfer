<div id="content">
  <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <h2 class="page-title">File Login</h2>
                     <form method="post" id="formLogin" action="">
                     <div class="white-section section-wh" style="position: relative;">
                     <div style="text-align: right">
                       <a href="#" class="abs-dl" onclick="renderpdfs(<?=$CustomerInfo["customer_loan_id"]?>)">DOWNLOAD QDE SHEET</a>
                     </div>
                        <div class="row item-to-append">
                        <?php
                          if(!empty($loanDetail)){
                          $i=0;
                          $bankIDs = '';
                          foreach ($loanDetail as $key => $value) { 
                          $logoLink = "";
                          $bankIDs .= $value['bank_id'].',';  
                          $i++;   
                          $styles = 'display:none;';
                          $style = 'display:block;';
                          $stN  = 'display:block;';
                          if(!empty($value['financer_logo']))
                          {
                            $finalogo = explode('-', $value['financer_logo']);
                            $logoLink = BANK_LOGO.$finalogo[0];
                          }
                         // echo $rolemgmt[0]['role_name']; exit;
                          if((!empty($CustomerInfo['ref_id'])) && ($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin'))
                          {
                            $stN  = 'display:none;';
                          }
                          if(($CustomerInfo['tag_flag']=='4') && ($value['tag_flag']!='5'))
                          {
                             $styles = 'display:block;';
                             $style = 'display:none;';
                          }                 
                            ?>
                            <div class="col-md-4" id="bankdiv_<?=$i?>">
                              <div class="bank-box">
                                <div class="t-head clearfix add" style="<?=$style?>">
                                  <div class="pull-left">
                                    <img style="height: 20px;" src="<?php echo $logoLink; ?>"  alt="<?=$value['bank_name']?>">  
                                  </div>

                                  <div class="pull-right">
                                    <ul class="icon-ul">
                                   <?php if(!empty($bank_list_count) && ($bank_list_count>1))
                    {?>
                                      <li><img src="<?=base_url()?>assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_<?=$i?>" style="<?=$stN?>" onclick="deleteForm(this)"></li>  
                                      <?php } 
                                          if($value['tag_flag']!='5')
                                          { ?>
                                           <li><span id="fil_<?=$i?>" class="<?php if(!empty($value['file_tag'])){  echo strtolower($value['file_tag']); }else { echo 'filed'; } ?>">
                                        <?php if(!empty($value['file_tag']) && ($value['file_tag']!='5')){ echo $value['file_tag']; } ?></span></li>  
                                        <?php } ?>
                                    </ul>  
                                  </div>
                                </div>
                                <div class="t-head clearfix edit" style="<?=$styles?>">
                                  <div class="pull-left">
                                    <img style="height: 20px" src="<?php echo $logoLink; ?>"  alt="<?=$value['bank_name']?>">  
                                  </div>
                                  <div class="pull-right">
                                    <ul class="icon-ul">
                                   <?php
                                     if($CustomerInfo['tag_flag']!='4')
                                  { ?>
                               <!-- <img src="<?=base_url()?>assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_<?=$i?>" onclick="deleteForm(this)">-->
                                     <li class="edit-filed"><img src="<?=base_url()?>assets/images/loanbox/edit.svg" alt="edit" id="editOne_<?=$i?>" style="<?=$stN?>" onclick="editFileId(this);"></li> 
                                  <?php } ?> 
                                  <?php
                                     if($value['tag_flag']!='5')
                                  { ?>
                                      <li><span id="fil_<?=$i?>" class="<?php if(!empty($value['file_tag'])){  echo strtolower($value['file_tag']); }else { echo 'filed'; } ?>">
                                        <?php if(!empty($value['file_tag']) && ($value['file_tag']!='5')){ echo $value['file_tag']; } ?></span></li>  
                                        <?php } else{?>
                                        <li><span class="filled opened">Filed</span></li>
                                        <?} ?>
                                    </ul>  
                                  </div>
                                </div>
                                <div class="t-body clearfix">
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Loan Amount</label> 

                                    <input type="text" class="form-control crm-form loan_amt rupee-icon" name="file_loan_amount[]" onpaste="return false;" onkeypress="return isNumberKey(event)" id="floanamount_<?=$i?>" placeholder="Enter Amount" value="<?=$value['file_loan_amount']?>" onkeydown="addCommas(this.value, 'floanamount_<?=$i?>');"  onkeyup="emiCheck(this);">
                                    <div class="error" id="errfloanamount_<?=$i?>"></div>
                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Tenure<span class="month-t">(In Month)</span></label> 
                                    <input type="text" onpaste="return false;" onkeypress="return isNumberKey(event)" class="form-control crm-form tenor" placeholder="Enter Tenure" value="<?=$value['file_tenure']?>" maxlength="2" name="file_tenor_amount[]" id="ftenor_<?=$i?>" onkeyup="emiCheck(this)">
                                    <div class="error" id="errftenor_<?=$i?>"></div>   
                                  </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">ROI<span class="month-t"> (%)</span></label> 
                                    <input type="text" onpaste="return false;" class="form-control roi crm-form roi-icon" placeholder="Enter ROI" value="<?=$value['file_roi']?>" maxlength="5" name="file_roi_amount[]" id="froi_<?=$i?>" autocomplete="off" onkeyup="emiCheck(this)" onkeypress="return isRoiKey(event,this)">
                                    <div class="error" id="errfroi_<?=$i?>"></div> 
                                  </div>

                                   <div class="col-50 form-group">
                                    <label class="crm-label">EMI</label> 
                                    <input type="text" class="form-control crm-form cr-form-read rupee-icon" id="femi_<?=$i?>" onkeydown="addCommas(this.value, 'femi_<?=$i?>');" placeholder="Enter EMI" value="<?=$value['emi']?> " readonly="readonly">
                                    
                                  </div>
                                  <div class="col-50 form-group" style="width:98%">
                                    <label class="crm-label">Application No<span class="month-t"></span></label> 
                                    <input type="text" class="form-control reff crm-form" placeholder="Enter Application No" value="<?=$value['ref_id']?>"   name="file_ref_id[]" id="fref_<?=$i?>" autocomplete="off" onkeyup="return checkRefnumber(this,<?=!empty($value['id'])?$value['id']:''?>)">
                                   <div class="error" id="errrefid_<?=$i?>"></div>
                                  </div> 
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Remark <span class="month-t"></span></label> 
                                    <input type="text" class="form-control rmk crm-form" placeholder="Enter Remark" value="<?=$value['file_remark']?>"   name="file_rmk[]" id="frmk_<?=$i?>" autocomplete="off">
                                   <div class="error" id="errrmk_<?=$i?>"></div>
                                  
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Filed Date <span class="month-t"></span></label> 
                                   <div class="input-group date" id="dp2_<?=$i?>">
                                <input type="text" class="form-control payment_date crm-form" id="paydates_<?=$i?>" name="file_login_date[]" autocomplete="off" value="<?=((!empty($value['file_login_date']) && ($value['file_login_date']!='0000-00-00 00:00:00'))?date('d-m-Y',strtotime($value['file_login_date'])):date('d-m-Y'))?>"  placeholder="Filed Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                   <div class="error" id="errpaydate_<?=$i?>"></div>
                                  </div>
                                  </div>

                                  <input type="hidden" name="abc[]" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="editid_<?=$i?>">
                                    <input type="hidden" name="edit_id" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="edit_<?=$i?>">
                                    <input type="hidden" name="loanbnk" value="<?php if(!empty($value['bank_id'])){ echo $value['bank_id']; } ?>" id="loanbnk_<?=$i?>">
                                </div>
                              </div>
                            </div>
                            <?php  } } ?>
                            
                            <?php if(!empty($bank_list_count) && ($bank_list_count>1) && ($CustomerInfo['tag_flag']!='4')) { ?>
                             <div class="col-md-4 wow">
                              <div class="bank-box">
                                 <div class="add-bank" id="add-bankk" onclick="add_bankk(this)">
                                    <div class="add-bank-d">
                                       <img src="<?=base_url()?>assets/images/loanbox/plus.svg" alt="plus">
                                     </div> 
                                     <div class="add-txt">Add bank</div>
                                 </div>
                              </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input type="hidden" name="bank_id" value="<?=(!empty($bankIDs))?trim($bankIDs,','):''?>" id="bankid">
                                    <input type="hidden" name="saveI" value="<?php if(!empty($tag_flag)){ echo $tag_flag; } else{'1';} ?>" id="saveI">
                                    <input type="hidden" name="disbrsal" value="<?=(!empty($disbural))?$disbural:''?>" id="disbrsal">
                                    <input type="hidden" name="case_id" value="<?=$case_id?>" id="caseid">
                                    <input type="hidden" value="1" name="LeadLoginForm">
                                    <input type="hidden" value="<?=(!empty($loanCount))?$loanCount:$loanCount;?>" name="countTotalFiles" id="countTotalFiles">
                                    <input type="hidden" value="<?=(!empty($bank_list_count)?$bank_list_count:'')?>" id="totlcnt" name="totlcnt">
                                    <input type="hidden" name="rolemgmt" value="<?=(!empty($rolemgmt[0]['role_name'])?$rolemgmt[0]['role_name']:'')?>" id="rolemgmt">
                                    <input type="hidden" value="<?=$CustomerInfo['customer_id']?>" name="customer_id">
                                    <input type="hidden" id="updatedbank" value="" name="updatedbank">
                                    <input type="hidden" id="loantype" value="<?=$CustomerInfo['loan_for']?>" name="loantype">
                                    <input type="hidden" id="bnkleft" value="1" name="bnkleft">
                                       <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                     // echo "<pre>";
                                      //print_r($rolemgmt);
                                      //echo "---";
                                      //print_r($CustomerInfo);
                                    //  exit;
                                    if(((!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4')) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0') || (($rolemgmt[0]['edit_permission']=='1') && (!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']!='5'))) && (($rolemgmt[0]['role_name']!='admin') && (trim($rolemgmt[0]['role_name'])!='Loan Admin') ))
                                      {
                                       // echo "gggggg";
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('cpvDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                                      }
//exit;
                                       if($CustomerInfo['cancel_id']=='0'){ ?>
                                  <a href="javascript:void(0);"  style="<?=$stylesss?>" class="btn-continue saveCont btn-next" id="savefilelogin">Preview</a>
                                   <a class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</a> <?php } ?>
                               </div>
                           </div>
                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
          </div>
            <div class="modal fade" id="addBank" role="dialog">
               <div class="modal-backdrop fade in" style="height: 100%"></div>
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header modal-header-custom">
                  <button type="button" class="close" data-dismiss="modal" onclick="closeBank()"><img src="<?=base_url()?>assets/images/loanbox/close-model.svg" alt=""></button>
                    <h4 class="modal-title">Add Bank</h4>
               </div>
               <div class="modal-body">
                  <form role="form">
                    <div class="row">
                        <div class="col-md-12">
                         <div class="form-group">
                            <label class="crm-label">Bank Name</label>
                            <select class="form-control testselect1 crm-form sele" id="bank_detail" name="bank_detail">
                              <option>Select Bank</option>
                            </select>
                           <!-- <div class="d-arrow"></div> -->  
                         </div>
                        </div>
                        <div class="col-md-12 clearfix  textcenter">
                           <a class="btn-continue btn-proceed" data-dismiss="modal" id="adnewbank">Proceed Now</a>
                        </div>
                    </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/js/loanLogin.js" type="text/javascript"></script>
       
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>
<script>
  $('.testselect1').SumoSelect({csvDispCount: 3, search: true, searchText:'Enter here.',triggerChangeCombined: true});  
                function checkRefnumber(refids,ids) {
                var refid = $(refids).attr('id');
                var id = refid.split("_");
                var refval = $('#'+refid).val();
                var sv = $.trim(refval);
                if(sv!=''){
                  checkRefId(sv,id[1],ids);
                 }
              }
           </script>
            <script>

          $(document).ready(function(){
             $('.edit-filed').click(function(){
                  $(this).parents('.t-head').next().find('.crm-form').removeAttr('disabled');
              });
            
 });
          
          var getval = $('#countTotalFiles').val();
          //if(parseInt(getval)>0){
          var x  = parseInt(getval); 

          $("#adnewbank").click(function(){
            var getval = $('#countTotalFiles').val();
          //if(parseInt(getval)>0){
            var x  = parseInt(getval); 
              x++;
              var bnkleft = $('#bnkleft').val();
              if(bnkleft=='1')
              {
                $('.wow').attr('style','display:none !important');
              }
              else
              {
                 $('.wow').attr('style','display:block !important');
              }
            var bank_id = $('#bank_detail').val();
            if(bank_id=='')
            {
              alert('No Bank is Selected');
              return False;
            }
            else{
             var bankSel =  $("#bank_detail option:selected").val();
             var bank_name = $("#bank_detail option:selected").text();
             var imgnames = bank_name.toLowerCase();
             var imgnamed = imgnames.split(' ');
             var imgname = imgnamed[0]+'.png';
             var updatedbank = $('#updatedbank').val();
             if(updatedbank=='undefined')
             {
                updatedbank = '';
             }
             var filed = '<li><span class="filled opened">Filed</span></li>';
             if(bankSel!='Select Bank'){
              var sdate = "<?=date('d-m-Y')?>";
              var semi = "addCommas(this.value,'femi_"+x+"')";
             var appendedItem ='<div class="col-md-4" id="bankdiv_'+x+'"><div class="bank-box"><div class="t-head clearfix add"><div class="pull-left"><img style="height:15px" id="bnklogo_'+x+'" src="<?=BANK_LOGO?>'+imgname+'" alt="'+bank_name+'" ></div><div class="pull-right"><ul class="icon-ul"><li><img src="<?=base_url()?>assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_'+x+'" onclick="deleteForm(this)"></li></ul></div></div><div class="t-head clearfix edit" style="display: none;"><div class="pull-left"><img id="bnkeditlogo_'+x+'" src="<?=BANK_LOGO?>'+imgname+'" alt="'+bank_name+'" ></div><div class="pull-right"><ul class="icon-ul"><li class="edit-filed"><img src="<?=base_url()?>assets/images/loanbox/edit.svg" alt="edit" id="editOne_'+x+'" onclick="editFileId(this);"></li>'+filed+'</ul></div></div><div class="t-body clearfix"><div class="col-50 form-group"><label class="crm-label">Loan Amount</label><input type="text" class="form-control crm-form rupee-icon loan_amt "  name="file_loan_amount[]" onpaste="return false;" autocomplete="Off" id="floanamount_'+x+'" placeholder="Enter Amount" value="" onkeypress="return isNumberKey(event)" onkeydown="addCommas(this.value, floanamount_'+x+');" onkeyup="emiCheck(this)"><div class="error" id="errfloanamount_'+x+'"></div></div><div class="col-50 form-group"><label class="crm-label tenor">Tenure(In Month)</label><input type="text" autocomplete="Off"  onkeypress="return isNumberKey(event)" class="form-control crm-form tenor" maxlength="2" placeholder="Enter Tenure" onpaste="return false;" value="" name="file_tenor_amount[]" id="ftenor_'+x+'" onkeyup="emiCheck(this)"><div class="error" id="errftenor_'+x+'"></div></div><div class="col-50 form-group"><label class="crm-label">ROI(%)</label><input type="text" class="form-control crm-form roi" autocomplete="Off" placeholder="Enter ROI" onpaste="return false;" autocomplete="off" onkeypress="return isRoiKey(event,this)" value="" maxlength="5" name="file_roi_amount[]" id="froi_'+x+'" onkeyup="emiCheck(this)"><div class="error" id="errfroi_'+x+'"></div></div><div class="col-50 form-group"><label class="crm-label">EMI</label><input type="text" class="form-control crm-form cr-form-read rupee-icon" onkeydown="'+semi+'" id="femi_'+x+'" placeholder="Enter EMI" value="" readonly="readonly"><input type="hidden" name="abc[]" value="" id="editid_'+x+'"><input type="hidden" name="loanbnk" value="'+updatedbank+'" id="loanbnk_'+x+'"></div><div class="col-50 form-group" style="width:98%"><label class="crm-label">Application No<span class="month-t"></span></label><input type="text" class="form-control reff crm-form" placeholder="Enter Application No"  value=""  name="file_ref_id[]" id="fref_'+x+'"autocomplete="off"onkeyup="return checkRefnumber(this)"><div class="error" id="errrefid_'+x+'"></div></div><div class="col-50 form-group" style="width:98%"><label class="crm-label">Remark<span class="month-t"></span></label><input type="text" class="form-control rmk crm-form" placeholder="Enter Remark"  value=""  name="file_rmk[]" id="frmk_'+x+'"autocomplete="off"><div class="error" id="errrmk_'+x+'"></div></div><div class="col-50 form-group" style="width:98%"><label class="crm-label">Filed Date <span class="month-t"></span></label><div class="input-group date" id="dp2_'+x+'"><input type="text" class="form-control payment_date crm-form" id="paydates_'+x+'" name="file_login_date[]" autocomplete="off" value="'+sdate+'"  placeholder="Filed Date"><span class="input-group-addon"><span class=""><img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span></span></div><div class="error" id="errpaydate_'+x+'"></div></div></div></div> </div>';
           }
              $('.item-to-append .wow').before(appendedItem);
              var getval = $('#countTotalFiles').val();
              var getValAdd = parseInt(getval)+1;
              $('#countTotalFiles').val(getValAdd);
            }
              $('#addBank').attr('style','display: none; padding-right: 15px;');
              $('#addBank').attr('class','modal fade');
              $('#paydates_'+x).datepicker({
                format: 'dd-mm-yyyy',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
          });

          $('#bank_detail').change(function(){
              var bank = $('#bankid').val();
              var new_bank = $('#bank_detail').val();
              if(bank==''){
              var vals = new_bank;
              }else
              {
                var vals = bank+','+new_bank;
              }
             // alert(new_bank);
             // $('#loanbnk_'+ab).val(new_bank);
              $('#updatedbank').val(new_bank);
              $('#bankid').val(vals);

          });
                   
          $('#savefilelogin').click(function(){
              $('.crm-form').addClass('cr-form-read');
          });
         
        </script>

<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>  
<script>
    $(document).ready(function() {
<? $u = 1;
  foreach ($loanDetail as $key => $value) {
  ?>  


         $('#paydates_<?=$u?>').datepicker({
                format: 'dd-mm-yyyy',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        
 
    
     <? $u++; } ?>
        });
      </script>