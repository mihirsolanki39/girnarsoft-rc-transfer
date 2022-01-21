<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">RC Details</h2>
            <form  enctype="multipart/form-data" method="post"  id="rc_detail" name="rc_detail">
                <div id="rc_details" class="white-section">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="sub-title mrg-T0"></h2>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">RC Status*</label>
                                <select class="form-control crm-form testselect1" id="rc_status" name="rc_status">
                                    <option value="1" <?=  (!empty($getRcDetail['rc_status']) && $getRcDetail['rc_status']=='1'?'selected=selected':'')?>>Pending</option>
                                     <option value="2" <?=  (!empty($getRcDetail['rc_status']) && $getRcDetail['rc_status']=='2'?'selected=selected':'')?>>In-Process</option>
                                      <option value="3" <?=  (!empty($getRcDetail['rc_status']) && $getRcDetail['rc_status']=='3'?'selected=selected':'')?>>Transferred</option>
                                           </select>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_rc_status"></div>
                            </div>
                        </div>         

                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label ">RC to be transfered by*</label>
                                <select class="form-control crm-form testselect1" id="pndingfrm" name="rc_transfered">
                                    <option value="1" <?=  (!empty($getRcDetail['pending_from']) && $getRcDetail['pending_from']=='1'?'selected=selected':'')?>>Dealer</option>
                                     <option value="2" <?=  (!empty($getRcDetail['pending_from']) && $getRcDetail['pending_from']=='2'?'selected=selected':'')?>>In-house</option>
                                </select>
                               <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_rc_transfered"></div>
                            </div>
                        </div>
                          <div class="RTO_changes">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">RTO Works</label>
                                <select class="form-control crm-form testselect1" id="rto_work" name="rto_work[]" multiple="multiple">
                                    <?php foreach(RTO_WORK as $k => $rto) { ?>
                                    <option value="<?= $k ?>" <?=  (!empty($getRcDetail['rto_work']) && (in_array($k, explode(',', $getRcDetail['rto_work'])))?'selected=selected':'')?>><?=$rto?></option>
                                    <?php } ?>
                                </select>
                                <div class="error" id="err_rc_status"></div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="crm-label">RTO Charges</label>
                                 <input type="text" class="form-control rupee-icon" value="<?=!empty($getRcDetail['rto_charges'])?$getRcDetail['rto_charges']:''?>" onkeypress="return isNumberKey(event)" name="rto_charges" id="rto_charges" placeholder="RTO Charges" onkeyup="addCommas(this.value, 'rto_charges');" maxlength="8">
                                <div class="error" id="err_rc_status"></div>
                            </div>
                        </div>
                        </div>
                        <?php //if($getRcDetail['pending_from']=='2'){?>

                             <div class="col-md-6">
                            <div class="form-group trans">
                                <label for="" class="crm-label">Assigned to*</label>
                                <select class="form-control crm-form testselect1" id="assign_to" name="assign_to">
                                 <option value="">Assigned To</option>
                                     <?php foreach ($rtoTeam as $team => $rel){ ?>
                                    <option value="<?=$rel['id'];?>" <?=  (!empty($getRcDetail['rto_agent']) && $getRcDetail['rto_agent']==$rel['id']?'selected=selected':'')?>><?=$rel['name'];?></option>
                                    <?php  } ?>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_rc_assigned"></div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                                <div class="form-group trans">
                                    <label for="" class="crm-label">Assigned On</label>
                                    <div class="input-group date" id="dp">
                                        <input type="text" class="form-control crm-form crm-form_1" id="assigned_on" name="assigned_on" autocomplete="off" value="<?php 
                                                if(!empty($getRcDetail['assigned_on']) && ($getRcDetail['assigned_on']>'0000-00-00 00:00:00'))
                                                { 
                                                    $dob = date('d-m-Y',strtotime($getRcDetail['assigned_on'])) ;
                                                } 
                                               
                                                else 
                                                { 
                                                    $dob = date('d-m-Y') ;
                                                } 

                                            echo $dob ;
                                            ?>" >
                                        <span class="input-group-addon">
                                            <span class="">
                                                <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span>
                                        </span>
                                    </div>
                                    <div class="error" id="err_on"></div>
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group rcstatus xyz">
                                <label for="" class="crm-label">RTO Slip No</label>
                                <input onkeypress="return blockSpecialChar(event)" type="text" class="form-control crm-form" value="<?= !empty($getRcDetail['rto_slip_no'])?$getRcDetail['rto_slip_no']:''?>" placeholder="RTO Slip No" id="rto_slip_no" name="rto_slip_no" autocomplete="off">
                                 <div class="error" id="err_rto_slip_no"></div>
                            </div>
                        </div>

                        <input type="hidden" value="1" name="rc_details">
                            <input type="hidden" value="<?= !empty($getRcDetail['customer_id'])?$getRcDetail['customer_id']:'' ?>" name="customerId">
                            <input type="hidden" value="<?= !empty($getRcDetail['rcid'])?$getRcDetail['rcid']:'' ?>" name="rcid" id="rcid">
                            <!--<input type="hidden" value="<?= !empty($getRcDetail['pending_from'])?$getRcDetail['pending_from']:'' ?>" name="pndingfrm" id="pndingfrm">
                            -->
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                   /* if((($rolemgmt[0]['edit_permission']=='0') || ($rolemgmt[0]['add_permission']=='0'))  || ($rolemgmt[0]['role_name']!='admin'))
                                      {
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('uploadRcDocs/').base64_encode('RcId_'.$getRcDetail['rc_id']).'/transferred';

                                      }*/
                              ?>
                                <?php if(!empty($getRcDetail['rc_status']) && $getRcDetail['rc_status']!='3'){?>
                                <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="rcdetailButton">SAVE AND CONTINUE</button>
                                <?php }else{
                                    if(($getRcDetail['rc_status']!='1') && ($getRcDetail['pending_from']=='1')){
                                        $action= base_url('uploadRcDocs/').base64_encode('RcId_'.$getRcDetail['rc_id']).'/transferred';
                                    }
                                else{
                                        $action= base_url('uploadRcDocs/').base64_encode('RcId_'.$getRcDetail['rc_id']);
                                    }
                                    //$action = base_url('uploadRcDocs/').base64_encode('RcId_'.$getRcDetail['rc_id']).'/transferred';
                                    ?>
                                <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>"  id="rcdetailcontinue" onclick="countinue('<?=$action?>')">CONTINUE</button>
                                <?php } ?>
                                <a class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</a>
                             
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/loan_validation.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>


<script>
    $(document).ready(function() {
        var pendingfrom =  "<?=!empty($getRcDetail['pending_from'])?$getRcDetail['pending_from']:''?>";
        var rcstatus = $('#rc_status').val();
        if(pendingfrom=='2')
        {
            $('.trans').attr('style','display:block !important');
        }else if(pendingfrom=='1'){
            $('.trans').attr('style','display:none !important');
        }else{
            $('.trans').attr('style','display:block !important');
        } 
        if((rcstatus !='1') && (pendingfrom!='1')){
             $(".RTO_changes").attr('style','display:block !important');
        }else{
            $(".RTO_changes").attr('style','display:none !important');
        }
        if(rcstatus=='2')
        {
            $('.rcstatus').attr('style','display:block !important');
             $('.xyz').attr('style','display:block !important');
        }
        if(rcstatus=='1')
        {
            $(".RTO_changes").attr('style','display:none !important');
            $('.rcstatus').attr('style','display:none !important');
             $('.xyz').attr('style','display:none !important');
        }
        if(rcstatus=='3')
        {
            //$('.trans').attr('style','display:block !important');
            $('.xyz').attr('style','display:block !important');
        }
         $('#assigned_on').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true   
             });
        });
    $('#rc_status').change(function(){
        var rcstatus = $('#rc_status').val();
        var pndingfrm = $('#pndingfrm').val();
       
        if((rcstatus !='1') && (pndingfrm!='1'))
        {
             $(".RTO_changes").attr('style','display:block !important');
        }
        if((rcstatus=='2') && (pndingfrm=='2'))
        {
            $('.rcstatus').attr('style','display:block !important');
            $('.trans').attr('style','display:block !important');
        }
        if((rcstatus=='2') && (pndingfrm!='2'))
        {
            $('.rcstatus').attr('style','display:block !important');
            $('.trans').attr('style','display:none !important');
        }
        else if(rcstatus=='1')
        {
            $(".RTO_changes").attr('style','display:none !important');
            $('.rcstatus').attr('style','display:none !important');
            $('.trans').attr('style','display:none !important');
            $('.xyz').attr('style','display:none !important');
        }
        if(rcstatus=='3')
        {
            if(pndingfrm!='2'){
               $('.trans').attr('style','display:none !important');
            }
            $('.xyz').attr('style','display:block !important');
        }
    });
     $('#pndingfrm').change(function(){
        var pndingfrm = $('#pndingfrm').val();
         var rcstatus = $('#rc_status').val();
         if((rcstatus !='1') && (pndingfrm!='1')){
            $(".RTO_changes").attr('style','display:block !important');
        }else{
            $(".RTO_changes").attr('style','display:none !important');
        }
       if((pndingfrm=='2') && (rcstatus!='1'))
       {
            $('.trans').attr('style','display:block !important');
            // $('.abc').attr('style','display:block !important');
       }
       else
       {
        $('.trans').attr('style','display:none !important');
        // $('.abc').attr('style','display:block !important');
       }
     });
    $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
     </script>

