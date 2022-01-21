<?php $i = 1; //echo '<pre>';print_r($CustomerInfo['id']);die;?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Refurb Details</h2>
            <div class="white-section">
                <div class="row item-to-append">
                    <div class="col-md-12">
                    <div class="col-md-6 pad-L0">
                        <h2 class="sub-title first-title">First Refurb</h2></div>
                        <div class="col-md-6 ">
                    <button type="button" id="addout" style="display: none;" class="addouts btn btn-primary pad-LR-10 mrg-L100">Add Outstanding Price</button></div>

                    </div>
                    <form  enctype="multipart/form-data" method="post"  id="refurbinfo" name="refurbinfo">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Refurb Cost*</label>
                            <input type="text" id="refurb_cost" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'refurb_cost')" onchange="mainInfo(this.value);" name="refurb_cost"  class="form-control crm-form" placeholder="Refurb Cost" value="<?= !empty($paymentDe[0]['refurb_cost'])?ucwords($paymentDe[0]['refurb_cost']):'' ?>" >
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_refurb_cost"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Date Sent to Workshop*</label>
                              <div class="input-group date" id="dp">
                                <input type="text" class="form-control crm-form crm-form_1" id="workshop_date" name="workshop_date" autocomplete="off" value="<?php 
                                          if(!empty($paymentDe[0]['workshop_date']) && ($paymentDe[0]['workshop_date']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($paymentDe[0]['workshop_date'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>" readonly placeholder="Date Sent To Workshop">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                            <!--<div class="d-arrow"></div>-->
                            <div class="error" id="err_workshop_date"></div>
                        </div>
                       
                    </div> 
                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Sent to*</label>
                                 <select class="form-control crm-form lead_source" id="sent_to_<?=$i?>" name="sent_to">
                                <option value="">Select Workshop</option>
                                 <?php
                                if(!empty($workshop)){
                                     foreach($workshop as $ckey => $cval){?>
                                     <option value="<?=$cval['id']?>"  <?= !empty($paymentDe[0]['workshop_sent']) && $paymentDe[0]['workshop_sent']==$cval['id']?'selected=selected':''?>><?=$cval['name']?></option>
                                   <? } }?>
                            </select>
                            <div class="d-arrow"></div>
                                <div class="error" id="err_sent_to"></div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Date of Return After Refurb*</label>
                                 <div class="input-group date" id="dp4">
                                <input type="text" class="form-control crm-form  crm-form_1" id="refdate_<?=$i?>" name="refdate" autocomplete="off" value="<?php 
                                          if(!empty($paymentDe[0]['after_refurb_date']) && ($paymentDe[0]['after_refurb_date']>'0000-00-00'))
                                            {
                                                $dobs = date('d-m-Y',strtotime($paymentDe[0]['after_refurb_date'])) ;
                                            }
                                            else
                                            {
                                                $dobs = '';
                                            }
                                            echo trim($dobs) ;
                                            ?>" readonly placeholder="Date of Return After Refurb">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_after_refurb_date"></div>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Favouring*</label>
                                <input type="text" id="favouring_<?=$i?>"  onkeypress="return blockSpecialChar(event)" name="favouring[]"  class="form-control crm-form" placeholder="Favouring" value="<?= !empty($paymentDe[0]['favouring'])?ucwords($paymentDe[0]['favouring']):'' ?>" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_favouring"></div>
                            </div>
                        </div>
                     <?php 
                     if(!empty($paymentDe)){
                                          foreach($paymentDe as $key => $val){
                       // echo "dfvdff"; exit; ?>              
                    
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Instrument Type*</label>
                           <select name="instrumenttype[]" id="instrumenttype_<?=$i?>" onchange="instrumentType(this)" class="form-control crm-form">
                                <option value="">Select Instrument</option>
                                <option value="1" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'selected=selected':'')?>>Cash</option>
                                <option value="2"  <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='2')?'selected=selected':'')?>>Cheque</option>
                           </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_instrumenttype"></div>
                        </div>
                       
                    </div>
                    <div id="chequemethod_<?=$i?>" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'style="display:none;"':'style="display:block;"')?> >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Amount*</label>
                                <input type="text" id="amount_<?=$i?>" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amount_'+<?=$i?>)"  onchange="mainInfo(this.value);" name="amount[]"  class="form-control crm-form" placeholder="Amount" value="<?= !empty($val['amount'])?ucwords($val['amount']):'' ?>" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_amount"></div>
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Instrument No.*</label>
                                <input type="text" id="insno_<?=$i?>" onkeypress="return blockSpecialChar(event)"  name="insno[]"  class="form-control crm-form" placeholder="Instrument No." value="<?= !empty($val['insno'])?ucwords($val['insno']):'' ?>" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_insno"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Drawn on Bank*</label>
                                 <select class="form-control crm-form lead_source" id="payment_bank_<?=$i?>" name="payment_bank[]">
                                <option value="">Select Bank</option>
                                 <?php
                                if(!empty($banklist)){
                                     foreach($banklist as $ckey => $cval){?>
                                     <option value="<?=$cval['id']?>"  <?= !empty($val) && $val['payment_bank']==$cval['id']?'selected=selected':''?>><?=$cval['bank_name']?></option>
                                   <? } }?>
                            </select>
                            <div class="d-arrow"></div>
                                <div class="error" id="err_bank_list"></div>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Instrument Date*</label>
                                <!--<input type="text" id="insdate"  name="insdate"  class="form-control crm-form" placeholder="Instrument Date" value="<?= !empty($val['insdate'])?$val['insdate']:'' ?>" >-->
                                 <div class="input-group date" id="dp1">
                                <input type="text" class="form-control crm-form insdate crm-form_1" id="insdate_<?=$i?>" name="insdate[]" autocomplete="off" value="<?php 
                                          if(!empty($val['insdate']) && ($val['insdate']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['insdate'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>" readonly placeholder="Instrument Date">
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
                      
                       
                    </div>
                     <div class="col-md-6">
                            <div class="form-group" id="cashmethod_<?=$i?>" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'style="display:block;"':'style="display:none;"')?>>
                                <label class="crm-label">Payment Date*</label>
                               <!-- <input type="text" id="paydate"  name="paydate"  class="form-control crm-form" placeholder="Payment Date" value="<?= !empty($val['payment_date'])?$val['payment_date']:'' ?>" >-->
                               <div class="input-group date" id="dp2">
                                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydate_<?=$i?>" name="paydate[]" autocomplete="off" value="<?php 
                                          if(!empty($val['payment_date']) && ($val['payment_date']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['payment_date'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>" readonly placeholder="Payment Date">
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
                         <input type="hidden" name="ids[]" value="<?=(!empty($val['id']))?$val['id']:''?>" id="ids">
                        <? } 
                        }
                        else
                        { ?>
                        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Instrument Type*</label>
                           <select name="instrumenttype[]" id="instrumenttype_<?=$i?>" onchange="instrumentType(this)" class="form-control crm-form">
                                <option value="">Select Instrument</option>
                                <option value="1" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'selected=selected':'')?>>Cash</option>
                                <option value="2"  <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='2')?'selected=selected':'')?>>Cheque</option>
                           </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_instrumenttype"></div>
                        </div>
                       
                    </div>
                    <div id="chequemethod_<?=$i?>" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'style="display:none;"':'style="display:block;"')?> >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Amount*</label>
                                <input type="text" id="amount_<?=$i?>" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amount_'+<?=$i?>)"  onchange="mainInfo(this.value);" name="amount[]"  class="form-control crm-form" placeholder="Amount" value="<?= !empty($val['amount'])?ucwords($val['amount']):'' ?>" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_amount"></div>
                            </div>
                        </div>

                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Instrument No.*</label>
                                <input type="text" id="insno_<?=$i?>" onkeypress="return blockSpecialChar(event)"  name="insno[]"  class="form-control crm-form" placeholder="Instrument No." value="<?= !empty($val['insno'])?ucwords($val['insno']):'' ?>" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_insno"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Drawn on Bank*</label>
                                 <select class="form-control crm-form lead_source" id="payment_bank_<?=$i?>" name="payment_bank[]">
                                <option value="">Select Bank</option>
                                 <?php
                                if(!empty($banklist)){
                                     foreach($banklist as $ckey => $cval){?>
                                     <option value="<?=$cval['id']?>"  <?= !empty($val) && $val['payment_bank']==$cval['id']?'selected=selected':''?>><?=$cval['bank_name']?></option>
                                   <? } }?>
                            </select>
                            <div class="d-arrow"></div>
                                <div class="error" id="err_bank_list"></div>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Instrument Date*</label>
                                <!--<input type="text" id="insdate"  name="insdate"  class="form-control crm-form" placeholder="Instrument Date" value="<?= !empty($val['insdate'])?$val['insdate']:'' ?>" >-->
                                 <div class="input-group date" id="dp1">
                                <input type="text" class="form-control crm-form insdate crm-form_1" id="insdate_<?=$i?>" name="insdate[]" autocomplete="off" value="<?php 
                                          if(!empty($val['insdate']) && ($val['insdate']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['insdate'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>" readonly placeholder="Instrument Date">
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
                       <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Favouring*</label>
                                <input type="text" id="favouring_<?=$i?>"  onkeypress="return blockSpecialChar(event)" name="favouring[]"  class="form-control crm-form" placeholder="Favouring" value="<?= !empty($val['favouring'])?ucwords($val['favouring']):'' ?>" >
                               
                                <div class="error" id="err_favouring"></div>
                            </div>
                        </div>
                       
                    </div>-->
                     <div class="col-md-6">
                            <div class="form-group" id="cashmethod_<?=$i?>" <?=((!empty($val['instrumenttype']) && $val['instrumenttype']=='1')?'style="display:block;"':'style="display:none;"')?>>
                                <label class="crm-label">Payment Date*</label>
                               <!-- <input type="text" id="paydate"  name="paydate"  class="form-control crm-form" placeholder="Payment Date" value="<?= !empty($val['payment_date'])?$val['payment_date']:'' ?>" >-->
                               <div class="input-group date" id="dp2">
                                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydate_<?=$i?>" name="paydate[]" autocomplete="off" value="<?php 
                                          if(!empty($val['payment_date']) && ($val['payment_date']>'0000-00-00'))
                                            {
                                                $dob = date('d-m-Y',strtotime($val['payment_date'])) ;
                                            }
                                            else
                                            {
                                                $dob = '';
                                            }
                                            echo trim($dob) ;
                                            ?>" readonly placeholder="Payment Date">
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
                          <?  }?>
                          <!--<div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Remark*</label>
                                <input type="text" id="remark"  onkeypress="return blockSpecialChar(event)" name="remark"  class="form-control crm-form" placeholder="Remark" value="<?= !empty($val['remark'])?ucwords($val['remark']):''?>" readonly="readonly">
                               <div class="error" id="err_remark"></div>
                            </div>
                        </div>-->
                        <div class="col-md-12 wow">
                        </div>
                        <input type="hidden" name="refurbinfo" value="1" id="refurbinfo">
                        <input type="hidden" name="countTotalFiles" value="<?=!empty($total_count)?$total_count:'1'?>" id="countTotalFiles">
                         <input type="hidden" name="case_id" value="<?=!empty($case_id)?$case_id:''?>" id="case_id">
                         <input type="hidden" name="all_total_id" value="<?=!empty($all_ids)?$all_ids:''?>" id="total_id">
                        <input type="hidden" name="car_id" value="<?= !empty($carid)?$carid:'' ?>" id="car_id">
                        <input type="hidden" name="edit_id" value="<?= !empty($edit_id)?$edit_id:'' ?>" id="edit_id">
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                <a href="javascript:void(0);" class="btn-continue" style="<?=$stylesss?>" id="saveRefurb">SAVE AND CONTINUE</a>
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
<script src="<?php echo base_url(); ?>assets/js/inv_stock.js" type="text/javascript"></script>      
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>  
<script>
    $(document).ready(function() {
        $('#workshop_date').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
               //endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#insdate_1').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#paydate_1').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
                //endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
         $('#refdate_1').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
                //endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });

       // $('#')
    });

    function getTotal(r)
    {
        var total_amount = 0;
        var purchasePrice = $('#refurb_cost').val().replace(/,/g,'');
        for(var j=1; j<=r;j++)
        {
           var ac =  $('#amount_'+j).val().replace(/,/g,'');
           total_amount = parseInt(total_amount)+parseInt(ac);
        }
        if(parseInt(total_amount)<=parseInt(purchasePrice))
        {
            // $('#remark').val(parseInt(purchasePrice)-(parseInt(total_amount)));
          return 1; 
        }
        else if(parseInt(total_amount)==parseInt(purchasePrice))
        {
            $('#addout').attr('style','display:none;');
            return 2;
        }
        else
        {
            alert('Amount Total is more than Purchase Price.Please Check.');
        }
       // return true;

    }
    function mainInfo(va)
    {
        //alert('we44r34  ');
        var getval = $('#countTotalFiles').val();
        var x  = parseInt(getval); 
        var total_amount = 0;
        //alert(getval);
       // alert($('#amount_'+x).val());
        var av = $('#amount_'+x).val().replace(/,/g,'');
        var purchasePrice = $('#refurb_cost').val().replace(/,/g,'');
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
           $('#addout').attr('style','display:block'); 
           $('#remark').val(parseInt(purchasePrice)-(parseInt(av)));
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
            $('#chequemethod_'+ids[1]).attr('style','display:none;');
            $('#cashmethod_'+ids[1]).attr('style','display:block;');   
        }
        if(insType=='2')
        {
            $('#chequemethod_'+ids[1]).attr('style','display:block;');
            $('#cashmethod_'+ids[1]).attr('style','display:none;');
        }
    }


     $("#addout").click(function(){
       //alert('hiii');
            var getval = $('#countTotalFiles').val();
          //if(parseInt(getval)>0){
            var x  = parseInt(getval); 
            x++;

             var appendedItem = '<div class="col-md-6"><div class="form-group"><label class="crm-label">Instrument Type*</label><select name="instrumenttype[]" onchange="instrumentType(this)"  id="instrumenttype_'+x+'" class="form-control crm-form"><option value="">Select Instrument</option><option value="1">Cash</option><option value="2">Cheque</option></select><div class="d-arrow"></div><div class="error" id="err_instrumenttype_'+x+'"></div></div></div><div id="chequemethod_'+x+'"><div class="col-md-6"><div class="form-group"><label class="crm-label">Amount*</label><input type="text" id="amount_'+x+'" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,amount)"  onchange="mainInfo(this.value);" name="amount[]"  class="form-control crm-form" placeholder="Amount" value="" ><div class="error" id="err_amount_'+x+'"></div></div></div><div class="col-md-6"><div class="form-group"><label class="crm-label">Instrument No.*</label><input type="text" id="insno_'+x+'" onkeypress="return blockSpecialChar(event)"  name="insno[]"  class="form-control crm-form" placeholder="Instrument No." value="" ><div class="error" id="err_insno_'+x+'"></div></div></div><div class="col-md-6"><div class="form-group"><label class="crm-label">Drawn on Bank*</label><select class="form-control crm-form lead_source" id="paymentbank_'+x+'" name="payment_bank[]"><option value="">Select Bank</option><?php if(!empty($banklist)){ foreach($banklist as $ckey => $cval){?><option value="<?=$cval[id]?>"><?=$cval[bank_name]?></option><? } }?></select><div class="d-arrow"></div><div class="error" id="err_bank_list_'+x+'"></div></div></div><div class="col-md-6"><div class="form-group"><label class="crm-label">Instrument Date*</label><div class="input-group date" id="dp1_'+x+'"><input type="text" class="form-control insdate crm-form crm-form_1" id="insdate_'+x+'" name="insdate[]" autocomplete="off" value="" readonly placeholder="Instrument Date"><span class="input-group-addon"><span class=""><img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span></span></div><div class="error" id="err_insdate_'+x+'"></div></div></div></div><div id="cashmethod_'+x+'" style="display: none"><div class="col-md-6"><div class="form-group"><label class="crm-label">Payment Date*</label><div class="input-group date" id="dp2_'+x+'"><input type="text" class="form-control crm-form payment_date crm-form_1" id="paydate_'+x+'" name="paydate[]" autocomplete="off" value="" readonly placeholder="Payment Date"><span class="input-group-addon"><span class=""><img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg"></span></span></div><div class="error" id="err_paydate_'+x+'"></div></div></div></div>';

              $('.item-to-append .wow').before(appendedItem);
              $('#countTotalFiles').val(x);
                 for(var j=1; j<=x;j++)
                    {
                       if(j>=2)
                       {
                        //alert('dgtgtgt');
                            $('#insdate_'+j).datepicker({
                                format: 'dd-mm-yyyy',
                                //startDate: '-1000y',
                                endDate:'d',
                                autoclose: true,
                                todayHighlight: true   
                             });
                            $('#paydate_'+j).datepicker({
                                format: 'dd-mm-yyyy',
                                startDate: 'd',
                                //endDate:'d',
                                autoclose: true,
                                todayHighlight: true   
                             });
                        }
                    }
          });
    </script>  

    