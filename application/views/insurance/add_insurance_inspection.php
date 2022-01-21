<?php
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$mode=(!empty($CustomerInfo['inspection_status']) && $CustomerInfo['inspection_status']=='1') ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url().'inspersonalDetail/' . base64_encode('customerId_' . $CustomerInfo['customer_id']) :'';
?>
<div class="container-fluid">
               <div class="row">
                 <h2 class="page-title mrg-L10">Inspection</h2>
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                    
                     <form method="post" id="formInspection" action="">
                     <div class="white-section section-wh">
                        <div class="row item-to-append">
                            <?php $x=0; if(!empty($quotes)){ ?>
                            <?php 
                            for($ii=0; $ii < count($quotes); $ii++) { ?>
                            <div class="col-md-4 clscnt" id="bankdiv_<?php echo $x;?>">
                              <div class="bank-box">
                                <div class="t-head clearfix add" style="">
                                  <div class="pull-left">
                                      <ul class="icon-ul">
                                          <li>
                                          <img style="height:30px;" src="<?=base_url()?>assets/images/insurerlogo/<?php echo $quotes[$ii]['logo'];?>">
                                          </li></ul>
                                  </div>
                                  <div class="pull-right">
                                    <ul class="icon-ul">
                                      <!--<li><img src="<?=base_url()?>assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_<?php //echo $x?>#<?php //echo !empty($inspection[$ii]['id']) ? $inspection[$ii]['id']:'';?>" onclick="deleteForm(this,'inspection')"></li>-->  
                                    </ul>  
                                  </div>
                                </div>
                                <div class="t-body clearfix">
                                  <div class="col-100 form-group clearfix Valuation-status">
                                 <label class="crm-label">Enter Inspection Status</label>
                                  <span class="radio-btn-sec">
                                      <input type="radio" name="ins_status_<?=$x?>" id="pending_<?=$x?>" value="0" <?php echo (!empty($inspection[$ii]['inspect_status']) && ($inspection[$ii]['inspect_status']== '0')) ? 'checked="checked"' : ''; ?> class="trigger" checked="">
                                     <label for="pending_<?=$x?>"><span class="dt-yes"></span> Pending</label>
                                     <div class="error" id="pending_no_error_<?php echo $x;?>" ></div>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="ins_status_<?=$x?>" id="complete_<?=$x?>" value="1" <?php echo !empty($inspection[$ii]['inspect_status']) && ($inspection[$ii]['inspect_status']=='1') ? 'checked="checked"' : ''; ?> class="trigger">
                                     <label for="complete_<?=$x?>"><span class="dt-yes"></span> Complete</label>
                                 </span>
                                 </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Reference No.*</label> 
                                    <input type="text" class="form-control roi crm-form roi-icon" placeholder="Reference No" onpaste="return false;" value="<?php echo (!empty($inspection[$ii]['inspect_reference_no'])) ? $inspection[$ii]['inspect_reference_no']:'';?>" maxlength="15" name="reference_no[]" id="reference_no_<?php echo $x;?>">
                                    <div class="error" id="reference_no_error_<?php echo $x;?>" ></div>
                                  </div>
                                    <?php // echo "<pre>";print_r($inspection[$ii]);die; ?>
                                   <div class="col-50 form-group">
                                    <label class="crm-label">Comment*</label>
                                    <input type="text" class="form-control roi crm-form roi-icon" placeholder="Comment" onpaste="return false;" value="<?php echo (!empty($inspection[$ii]['inspect_comment'])) ? $inspection[$ii]['inspect_comment']:'';?>" name="ins_comment[]" id="ins_comment_<?php echo $x;?>">
                                    <div class="error" id="ins_comment_error_<?php echo $x;?>" ></div>
                                    <input type="hidden" name="inscompelete[]" value="" id="inscompelete_<?php echo $x;?>">
                                    <input type="hidden" name="edit_id" value="<?php if(!empty($qss['id'])){ echo $qss['id']; } ?>" id="edit_0">
                                    <input type="hidden" name="insId[]" value="<?php if(!empty($qss['inspect_company'])){ echo $qss['inspect_company']; } ?>" id="insId_<?php echo $x;?>">
                                    <input type="hidden" name="inslogo[]" value="<?php if(!empty($qss['logo'])){ echo $qss['logo']; } ?>" id="inslogo_<?php echo $x;?>">
                                  </div>
                                    <div class="col-50 form-group" style="width:98%">
                                        <label class="crm-label">Inspection Date <span class="month-t"></span></label> 
                                        <div class="input-group date" id="dp2">
                                            <input type="text" class="form-control payment_date crm-form" id="inspection_date" name="inspection_date" autocomplete="off" value="<?= ((!empty($CustomerInfo['inspection_add_date']) && ($CustomerInfo['inspection_add_date'] != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($CustomerInfo['inspection_add_date'])) : date('d-m-Y')) ?>"  placeholder="Inspection Date">
                                            <span class="input-group-addon">
                                                <span class="">
                                                    <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                                </span>
                                            </span>
                                        </div>
                                        <div class="error" id="errinsp_date"></div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <?php $x++ ;}} else {
                           /* $isscomp='';
                            foreach($inspection as $iss) { ?>
                            <div class="col-md-4 clscnt" id="bankdiv_<?php echo $x;?>">
                              <div class="bank-box">
                                <div class="t-head clearfix add" style="">
                                  <div class="pull-left">
                                      <ul class="icon-ul">
                                          <li>
                                          <img style="height:30px;" src="<?=base_url()?>assets/images/insurerlogo/<?php echo $iss['logo'];?>">
                                          </li></ul>
                                  </div>
                                  <div class="pull-right">
                                    <ul class="icon-ul">
                                      <li><img src="<?=base_url()?>assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_<?php echo $x?>#<?php echo $iss['id']?>" onclick="deleteForm(this,'inspection')"></li>  
                                    </ul>  
                                  </div>
                                </div>
                                <div class="t-body clearfix">
                                  <div class="col-100 form-group clearfix Valuation-status">
                                 <label class="crm-label">Enter Inspection Status</label>
                                  <span class="radio-btn-sec">
                                      <input type="radio" name="ins_status_<?=$x?>" id="pending_<?=$x?>" value="0"  <?php echo ($iss['inspect_status'] == '0') ? 'checked="checked"' : ''; ?> onclick="setInspriorty('0',<?php echo $iss['inspect_company']?>,<?php echo $x;?>);"  class="trigger" checked="">
                                     <label for="pending_<?=$x?>"><span class="dt-yes"></span> Pending</label>
                                 </span>
                                 <span class="radio-btn-sec">
                                     <input type="radio" name="ins_status_<?=$x?>" id="complete_<?=$x?>" value="1" <?php echo ($iss['inspect_status'] == '1') ? 'checked="checked"' : ''; ?> onclick="setInspriorty('1',<?php echo $iss['inspect_company']?>,<?php echo $x;?>);"  class="trigger">
                                     <label for="complete_<?=$x?>"><span class="dt-yes"></span> Complete</label>
                                 </span>
                                 </div>
                                  <div class="col-50 form-group">
                                    <label class="crm-label">Reference No.*</label> 
                                    <input type="text" class="form-control roi crm-form roi-icon" placeholder="Reference No" onpaste="return false;" value="<?php echo (!empty($iss['inspect_reference_no'])) ? $iss['inspect_reference_no']:'';?>" maxlength="15" name="reference_no[]" id="reference_no_<?php echo $x;?>">
                                    <div class="error" id="reference_no_error_<?php echo $x;?>" ></div>
                                  </div>
                                   <div class="col-50 form-group">
                                    <label class="crm-label">Comment*</label>
                                    <input type="text" class="form-control roi crm-form roi-icon" placeholder="Comment" onpaste="return false;" value="<?php echo (!empty($iss['inspect_comment'])) ? $iss['inspect_comment']:'';?>" name="ins_comment[]" id="ins_comment_<?php echo $x;?>">
                                    <div class="error" id="ins_comment_error_<?php echo $x;?>" ></div>
                                    <input type="hidden" name="inscompelete[]" value="" id="inscompelete_<?php echo $x;?>">
                                    <input type="hidden" name="edit_id" value="<?php if(!empty($iss['id'])){ echo $iss['id']; } ?>" id="edit_0">
                                    <input type="hidden" name="insId[]" value="<?php if(!empty($iss['inspect_company'])){ echo $iss['inspect_company']; } ?>" id="insId_<?php echo $x;?>">
                                    <input type="hidden" name="inslogo[]" value="<?php if(!empty($iss['logo'])){ echo $iss['logo']; } ?>" id="inslogo_<?php echo $x;?>">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php if(!empty($iss['inspect_company'])){ $isscomp .=$iss['inspect_company'].","; } ?>
                            <?php $x++ ; } ?>
                            <?php $isscomp=rtrim($isscomp,",");*/ } ?>
                             <!--<div class="col-md-4 wow">
                              <div class="bank-box">
                                 <div class="add-bank">
                                     <div class="add-bank-d" id="" onclick="return addIns();">
                                       <img src="<?//=base_url()?>assets/images/loanbox/plus.svg" alt="plus">
                                     </div> 
                                     <div class="add-txt">Add More</div>
                                 </div>
                              </div>
                            </div>-->
                            
                            <div class="col-md-12">
                               <div class="btn-sec-width">
                                    <input type="hidden" name="ins_id" id="ins_id" value="<?php if(!empty($isscomp)) echo $isscomp;?>">
                                   <input type="hidden" name="step10" value="true">
                                   <input type="hidden" name="totcnt" value="<?php echo $x;?>" id="totcnt">
                                   <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                                   <input type="hidden" name="edit" id="edit" value="1">
                                   <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                                   <a href="javascript:void(0);" class="btn-continue" id="btnform10">SAVE AND CONTINUE</a>
                                  <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['idv']))){ ?>
                                  <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                  <?php } ?>
                               </div>
                           </div>
                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
<div class="modal fade" id="addInspection" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header modal-header-custom">
                  <button type="button" class="close" data-dismiss="modal" onclick="closeBank()"><img src="<?=base_url()?>assets/images/loanbox/close-model.svg" alt=""></button>
                  <div class="row">
                     <div class="col-md-6 clearfix">
                        <h4 class="modal-title">Add Company</h4>
                     </div>
                  </div>
               </div>
               <div class="modal-body">
                  <form role="form">
                    <div class="row">
                        <div class="col-md-12">
                         <div class="form-group">
                            <label class="crm-label">Insurance Company</label>
                            <select class="form-control crm-form sele" id="ins_detail" name="ins_detail">
                              <option>Select Company</option>
                            </select>
                            <div class="error" id="ins_detail_error"></div>
                            <div class="d-arrow"></div>   
                         </div>
                        </div>
                        <div class="col-md-12 clearfix  textcenter">
                           <a class="btn-continue btn-proceed" data-dismiss="modal" id="addnewInspection">Proceed Now</a>
                        </div>
                    </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
<script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
          $('#inspection_date').datepicker({
                format: 'dd-mm-yyyy',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
          });
        function addIns()
          {
                //var case_id = $('#caseid').val();
                //alert(case_id);
                $('#addInspection').attr('style','display: block; padding-right: 15px;');
                $('#addInspection').attr('class','modal fade in');
                var inss = $('#ins_id').val();
                jQuery.ajax({
                type: "POST",
                url: base_url+"insurance/getInsurerSearchList",
                data: {ins_id:inss},
                dataType: 'html',
                success: function(data){
                       $("#ins_detail").html(data);
                 }
              });
          }
        function closeBank(divid)
        {
          $('#addInspection').attr('style','display: none; padding-right: 15px;');
          $('#addInspection').attr('class','modal fade');
        }
        function closeMore(id)
        {
            $('#bankdiv_'+id).remove();
        }
         var y  = 0; 
          $("#addnewInspection").click(function(){
              
             var inss_id = $('#ins_detail').val();
             var edit = $('#edit').val();
             var numItems = $('.clscnt').length;
             var ins_ids= $('#ins_id').val();
             y=numItems;
             var insSel =  $("#ins_detail option:selected").val();
             //var ins_name = $("#ins_detail option:selected").text();
             //var imgnames = ins_name.toLowerCase();
             var imgnamed = inss_id.split('#');
             var insurerId = imgnamed[0];
             var imageName = imgnamed[1];
             if(ins_ids){
                 $('#ins_id').val(ins_ids+','+insurerId);
             }else{
                 $('#ins_id').val(insurerId);
             }
             $('#ins_detail_error').html("");
             if(insSel!=''){
             var addprior = "setInspriorty('1', '"+insurerId+"','"+y+"')";
             var addprior1 = "setInspriorty('0', '"+insurerId+"','"+y+"')";
             var appendedItem ='<div class="col-md-4 clscnt" id="bankdiv_'+y+'"><div class="bank-box"><div class="t-head clearfix add" style=""><div class="pull-left"><ul class="icon-ul"><img src="<?=base_url()?>assets/images/insurerlogo/'+imageName+'" style="height:20px;"></li></ul></div><div class="pull-right"><ul class="icon-ul"><li><img src="<?=base_url()?>assets/images/loanbox/delete.svg" class="del" alt="delete" id="delete_'+y+'" onclick="closeMore('+y+')"></li></ul></div></div>';
appendedItem +='<div class="t-body clearfix"><div class="col-100 form-group clearfix Valuation-status"><label class="crm-label">Enter Inspection Status</label><span class="radio-btn-sec">';
appendedItem +='<input type="radio" name="ins_status_'+y+'" id="pending_'+y+'" value="0" onclick="'+addprior1+'" class="trigger" checked="">';
appendedItem +='<label for="pending_'+y+'"><span class="dt-yes"></span> Pending</label></span><span class="radio-btn-sec">';
appendedItem +='<input type="radio" name="ins_status_'+y+'" id="complete_'+y+'" value="1" onclick="'+addprior+'" class="trigger">';
appendedItem +='<label for="complete_'+y+'"><span class="dt-yes"></span> Complete</label></span></div></div>';
appendedItem +='<div class="col-50 form-group"><label class="crm-label">Reference No.*</label><input type="text" class="form-control roi crm-form roi-icon" onpaste="return false;" placeholder="Reference No" value="" maxlength="15" name="reference_no[]" id="reference_no_'+y+'"><div class="error" id="reference_no_error_'+y+'" ></div></div>';
appendedItem +='<div class="col-50 form-group"><label class="crm-label">Comment*</label><input type="text" class="form-control roi crm-form roi-icon" onpaste="return false;" placeholder="Comment" value="" name="ins_comment[]" id="ins_comment_'+y+'"><div class="error" id="ins_comment_error_'+y+'" ></div><input type="hidden" name="edit_id" value="<?php if(!empty($value['id'])){ echo $value['id']; } ?>" id="edit_0">';
appendedItem +='<input type="hidden" name="inscompelete['+y+']" value="" id="inscompelete_'+y+'"><input type="hidden" name="insId['+y+']" value="'+insurerId+'" id="insId_'+y+'"><input type="hidden" name="inslogo['+y+']" value="'+imageName+'" id="inslogo_'+y+'"><input type="hidden" name="instype['+y+']" value="new" id="instype_'+y+'"></div></div></div></div>';
           
              $('.item-to-append .wow').before(appendedItem);
              $('#addInspection').attr('style','display: none; padding-right: 15px;');
              $('#addInspection').attr('class','modal fade');
              if(edit!=''){
               edit=parseInt($('#totcnt').val())+1;
              $('#totcnt').val(edit);    
              }else{    
              $('#totcnt').val(y);
               }
              y++;
          }else{
              $('#ins_detail_error').html("Please Add Company");
          }
          });
</script>
