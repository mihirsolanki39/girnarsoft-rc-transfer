<form id="editids" name="editids">
<div class="modal-body">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        
        <div class="col-md-6" style="height: 84px">
          <div class="form-group">
            <label class="crm-label">Instrument Type*</label>
           <select name="instrumenttype" id="instrumenttypes" onchange="instrumentType(this)" class="form-control crm-form">
                <option value="">Select Instrument</option>
                <option value="cash" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']=='cash'))?'selected="selected"':'')?>>Cash</option>
                <option value="cheque" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']=='cheque'))?'selected="selected"':'')?>>Cheque</option>
                <option value="dd" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']=='dd'))?'selected="selected"':'')?>>DD</option>
                <option value="online" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']=='online'))?'selected="selected"':'')?>>Online</option>
           </select>
            <div class="d-arrow"></div>
            <div class="error" id="err_instrumenttypes"></div>
          </div>
        </div>

        <div class="col-md-6" style="height: 84px">
            <div class="form-group">
                <label class="crm-label">Amount*</label>
                <input type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amounts')"  maxlength="8"   name="amount"  class="form-control crm-form rupee-icon" placeholder="Amount" value="<?=(!empty($paymentDetails['amount'])?$paymentDetails['amount']:'')?>" >
                <div class="error" id="err_amounts"></div>
            </div>
        </div>

        <div class="col-md-6" style="height: 84px">
            <div class="form-group" >
              <label class="crm-label">Payment Date*</label>
               <div class="input-group date" id="dp2">
                <input type="text" class="form-control payment_date crm-form crm-form_1" id="paydates" name="paydate" autocomplete="off" value="<?=(!empty($paymentDetails['payment_date'])?date('d-m-Y',strtotime($paymentDetails['payment_date'])):'')?>"  placeholder="Payment Date">
                <span class="input-group-addon">
                    <span class="">
                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                    </span>
                </span>
            </div>
                <div class="error" id="err_paydate"></div>
            </div>
        </div>

        <div class="col-md-6" id="ins_no" style="display: none; height: 84px">
            <div class="form-group">
                <label class="crm-label">Instrument No.*</label>
                <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="<?=(!empty($paymentDetails['instrument_no'])?$paymentDetails['instrument_no']:'')?>">
                <div class="error" id="err_insnos"></div>
            </div>
        </div>

        <div class="col-md-6"  style="height: 84px" id="ins_date" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']!='cash'))?'style="display: block;"':'style="display: none;"')?> >
            <div class="form-group">
                <label class="crm-label">Instrument Date*</label>
                 <div class="input-group date" id="dp1">
                <input type="text" class="form-control crm-form insdate crm-form_1" id="insdates" name="insdate" autocomplete="off" value="<?=(!empty($paymentDetails['instrument_date'])?date('d-m-Y',strtotime($paymentDetails['instrument_date'])):'')?>"  placeholder="Instrument Date">
                <span class="input-group-addon">
                    <span class="">
                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                    </span>
                </span>
            </div>
                <div class="error" id="err_insdates"></div>
            </div>
        </div>

        <div class="col-md-6"  style="height: 84px" id="bnk" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']!='cash'))?'style="display: block;"':'style="display: none;"')?>>
            <div class="form-group">
                <label class="crm-label">Bank Name*</label>
                 <select class="form-control crm-form lead_source" id="payment_banks" name="payment_bank">
                <option value="">Select Bank</option>
                 <?php
                if(!empty($banklist)){
                     foreach($banklist as $ckey => $cval){ ?>
                     <option value="<?=$cval['bank_id']?>" <?=((!empty($paymentDetails['bank_id']) && ($paymentDetails['bank_id']==$cval['bank_name']))?'selected="selected"':'')?>><?=$cval['bank_name']?></option>
                   <?php } }?>
            </select>
            <div class="d-arrow"></div>
                <div class="error" id="err_bank_lists"></div>
            </div>
        </div>

        <div class="col-md-6"  style="height: 84px" id="favo" <?=((!empty($paymentDetails['instrument_type']) && ($paymentDetails['instrument_type']!='cash'))?'style="display: block;"':'style="display: none;"')?>>
            <div class="form-group">
                <label class="crm-label">Favouring*</label>
                <input type="text" id="favourings"  onkeypress="return blockSpecialChar(event)" name="favouring"  class="form-control crm-form" placeholder="Favouring" value="<?=(!empty($paymentDetails['favouring'])?$paymentDetails['favouring']:'')?>" >
                <div class="error" id="err_favourings"></div>
            </div>
        </div>
         <div class="col-md-6"  style="height: 84px">
            <div class="form-group">
                <label class="crm-label">Remark</label>
                <input type="text" id="remarks" name="remark"  class="form-control crm-form" placeholder="Remark" value="<?=(!empty($paymentDetails['remark'])?$paymentDetails['remark']:'')?>">
                <div class="error" id="err_remark"></div>
            </div>
        </div>
        <input type="hidden" name="workshop_id" value="<?php echo $workshop_id; ?>" id="workshop_id">
        <input type="hidden" name="edit_id" value="<?=(!empty($paymentDetails['id'])?$paymentDetails['id']:'')?>" id="edit_id">
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" onclick="saveEditData()">SAVE</button>
</div>
</form>
