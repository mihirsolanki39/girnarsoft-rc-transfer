<?php  //echo '<pre>';print_r($usedCarInfo['id']);die;?>
<div class="container-fluid">
    <div class="row">
    <a href="#" id="top"></a>
        <div class="col-md-12 pad-LR-10 mrg-B40">
            <h2 class="page-title">Case Information</h2>
            <div class="white-section">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="sub-title first-title">Source</h2>
                    </div>
                    <input type="hidden" value='<?= empty($usedCarInfo['case_id']) && $_SESSION['userinfo']['is_admin']?'n':'y' ?>' id="need_validation" name="need_validation">
                    <form  enctype="multipart/form-data" method="post"  id="caseinfo" name="caseinfo">
                    <div class="loan_read_only">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Category*</label>
                             <select class="form-control crm-form lead_source" id="source_cat" name="source_cat">
                                <option value="">Select Category</option>
                                 <?php
                                if(!empty($category)){
                                     foreach($category as $ckey => $cval){?>
                                     <option value="<?=$cval['id']?>"  <?= !empty($usedCarInfo) && $usedCarInfo['cat_id']==$cval['id']?'selected=selected':''?>><?=$cval['cat_name']?></option>
                                   <?php } }?>
                            </select>
                            <div class="error" id="err_source_cat"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                         <label class="crm-label">Name*</label>
                             <select class="form-control crm-form lead_source" id="source_name" name="source_name">
                                <option value="0">Select Name</option>
                            </select>
                             <div class="error" id="err_source_name"></div>
                        </div>
                    </div>
                    <div id="eval_fields">
                        <div class="col-md-12">
                            <h2 class="sub-title">Evaluation</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Evaluation Date*</label>
                                <div class="input-group date" id="dp">
                                    <input type="text" class="form-control crm-form crm-form_1" id="dob" name="dob" autocomplete="off" value="<?php 
                                              if(!empty($usedCarInfo['evaluation_date']) && ($usedCarInfo['evaluation_date']>'0000-00-00'))
                                                {
                                                    $dob = date('d-m-Y',strtotime($usedCarInfo['evaluation_date'])) ;
                                                }
                                                else
                                                {
                                                    $dob = '';
                                                }
                                                echo trim($dob) ;
                                                ?>"  placeholder="Evaluation Date">
                                    <span class="input-group-addon">
                                        <span class="">
                                            <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                        </span>
                                    </span>
                                </div>
                                <div class="error" id="err_dp"></div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label" id="nameChange">Evaluated By*</label>
                                <select class="form-control crm-form lead_source" id="evaluated_by" name="evaluated_by">
                                    <option value="">Evaluated By</option>
                                    <?php
                                    if(!empty($evaluated_by)){
                                         foreach($evaluated_by as $key => $val){?>
                                         <option value="<?=$val['id']?>" <?= !empty($usedCarInfo) && $usedCarInfo['evaluated_by']==$val['id']?'selected=selected':''?>><?=$val['name']?></option>
                                       <?php } }?>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_evaluated_by"></div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Overall Condition*</label>
                                <select class="form-control crm-form source_name" id="overall_condition" name="overall_condition">
                                    <option value="">Select Condition</option>
                                    <option value="1" <?= !empty($usedCarInfo) && $usedCarInfo['overall_condition']=='1'?'selected=selected':''?>>Excellent</option>
                                    <option value="2" <?= !empty($usedCarInfo) && $usedCarInfo['overall_condition']=='2'?'selected=selected':''?>>Good</option>
                                    <option value="3" <?= !empty($usedCarInfo) && $usedCarInfo['overall_condition']=='3'?'selected=selected':''?>>Poor</option>
                                </select>
                                <div class="d-arrow"></div>
                                <div class="error" id="err_condition"></div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="crm-label">Evaluation Remarks*</label>
                                <input type="text" id="evaluation_remark" onkeypress="return blockSpecialChar(event)" name="evaluation_remark"  class="form-control crm-form" placeholder="Evaluation remarks" value="<?php echo !empty($usedCarInfo['evaluation_remark'])?ucwords($usedCarInfo['evaluation_remark']):'' ?>" max-length="20" >
                                <!--<div class="d-arrow"></div>-->
                                <div class="error" id="err_evaluation_remark"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="sub-title">Purchase Information*</h2>
                    </div>
                     <div class="col-sm-6"> 
                        <div class="form-group" id="errtradediv">
                         <label class="crm-label">Trade in type* </label> 
                          <span class="mrg-R20"> 
                              <input  id="parksell" class="tradetype" name="tradetype" onclick="toggleAmount('1')" type="radio" value="1" <?= (($usedCarInfo['tradetype'] == '1' || (!isset($usedCarInfo['tradetype']))) ? 'checked="checked"' : '') ?> ><label for="parksell"><span></span>Park & Sell</label> 
                          </span> 
                          <span class="mrg-R20"> 
                              <input id="offload"  class="tradetype" name="tradetype" onclick="toggleAmount('2')" type="radio" value="2" <?= (($usedCarInfo['tradetype'] == '2') ? 'checked="checked"' : '') ?> ><label for="offload"><span></span>Off-Load</label> 
                          </span> 
                           <label class="control-label" style="display:none;" id="errtrade"></label>                          
                        </div> 
                    </div>
                    <div class="col-md-6 purchase_amt">
                        <div class="form-group">
                            <label class="crm-label">Purchased By</label>
                            <select class="form-control crm-form lead_source" id="purchased_by" name="purchased_by">
                                <option value="">Purchased By</option>
                                 <?php
                                     if(!empty($purchased_by)){
                                     foreach($purchased_by as $key => $val){?>
                                     <option value="<?php echo $val['id']?>"  <?php echo !empty($usedCarInfo) && $usedCarInfo['purchased_by']==$val['id']?'selected=selected':''?>><?=$val['name']?></option>
                                   <?php } }?>
                            </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_purchased_by"></div>
                        </div>
                        
                    </div>
                        <div class="col-md-6 expected_amt">
                        <div class="form-group">
                            <label class="crm-label">Closed By</label>
                            <select class="form-control crm-form lead_source" id="closed_by" name="closed_by">
                                <option value="">Closed By</option>
                                 <?php
                                     if(!empty($purchased_by)){
                                     foreach($purchased_by as $key => $val){?>
                                     <option value="<?php echo $val['id']?>"  <?php echo !empty($usedCarInfo) && $usedCarInfo['closed_by']==$val['id']?'selected=selected':''?>><?=$val['name']?></option>
                                   <?php } }?>
                            </select>
                            <div class="d-arrow"></div>
                            <div class="error" id="err_closed_by"></div>
                        </div>
                        
                    </div>
                     <div class="col-md-6 purchase_amt" >
                        <div class="form-group">
                            <label class="crm-label">Purchase Date*</label>
                            <div class="input-group date" id="dp1">
                                <input type="text" class="form-control crm-form crm-form_1" id="pdate" name="pdate" autocomplete="off" value="<?php 
                                          if(!empty($usedCarInfo['purchase_date']) && ($usedCarInfo['purchase_date']>'0000-00-00'))
                                            {
                                                $pdob = date('d-m-Y',strtotime($usedCarInfo['purchase_date'])) ;
                                            }
                                            else
                                            {
                                                $pdob = '';
                                            }
                                            echo trim($pdob) ;
                                            ?>"  placeholder="Purchase Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                            <div class="error" id="err_pdp"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="crm-label">Delivery Date*</label>
                            <div class="input-group date" id="dp2">
                                <input type="text" class="form-control crm-form crm-form_1" id="ddate" name="ddate" autocomplete="off" value="<?php 
                                          if(!empty($usedCarInfo['delivery_date']) && ($usedCarInfo['delivery_date']>'0000-00-00'))
                                            {
                                                $ddob = date('d-m-Y',strtotime($usedCarInfo['delivery_date'])) ;
                                            }
                                            else
                                            {
                                                $ddob = '';
                                            }
                                            echo trim($ddob) ;
                                            ?>"  placeholder="Delivery Date">
                                <span class="input-group-addon">
                                    <span class="">
                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                    </span>
                                </span>
                            </div>
                            <div class="error" id="err_ddp"></div>
                        </div>
                    </div>
                   <div class="col-sm-6 purchase_amt"> 
                        <div class="form-group" id="errtradediv">
                         <label class="crm-label">Purchase Amount</label> 
                         <input maxlength="11" id="purchase_amt" placeholder="Purchase Amount" class="form-control rupee-icon" onkeyup="addCommasdd(this.value, 'purchase_amt');" onkeypress="return forceNumber(event);" name="purchase_amt" type="text" value="<?=!empty($usedCarInfo['tradetype'])?indian_currency_form($usedCarInfo['purchaseprice']):''?>"  >
                         <div class="error" id="err_puramt"></div>                  
                        </div> 
                    </div>
                    <div class="col-sm-6 expected_amt"> 
                        <div class="form-group" id="errtradediv">
                         <label class="crm-label">Expected Amount </label> 
                              <input maxlength="11" id="expected_amt" class="form-control rupee-icon" onkeyup="addCommasdd(this.value, 'expected_amt');" placeholder="Expected Amount" onkeypress="return forceNumber(event);"  name="expected_amt" type="text" value="<?=!empty($usedCarInfo['expected_price'])?indian_currency_form($usedCarInfo['expected_price']):''?>"  >

                          <div class="error" id="err_expamt"></div>    
                        </div> 
                    </div>
                    <div class="col-md-12">
                        <h2 class="sub-title">Liquidation Mode*</h2>
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group" id="errtradediv1">
                         <label class="crm-label">Trade in type* </label> 
                          <span class="mrg-R20"> 
                              <input  id="retail" class="" name="liquid_mode"  type="radio" value="1" <?= (($usedCarInfo['liquid_mode'] == '1' || (!isset($usedCarInfo['liquid_mode']))) ? 'checked="checked"' : '') ?> ><label for="retail"><span></span>Retail</label> 
                          </span> 
                          <span class="mrg-R20"> 
                              <input id="btb"  class="" name="liquid_mode"  type="radio" value="2" <?= (($usedCarInfo['liquid_mode'] == '2') ? 'checked="checked"' : '') ?> ><label for="btb"><span></span>B2B</label> 
                          </span> 
                           <label class="control-label" style="display:none;" id="err_liquid_mode"></label>                          
                        </div> 
                    </div>
                   
                </div>
                        <input type="hidden" name="carid" value="<?=!empty($usedCarInfo['car_id'])?$usedCarInfo['car_id']:''?>" id="stockId">
                        <input type="hidden" name="purchasecase" value="1" id="purchasecase">
                        <input type="hidden" name="caseinfo" value="<?= !empty($usedCarInfo['case_id'])?$usedCarInfo['case_id']:'' ?>" id="caseinfo">
                        <div class="col-md-12">
                            <div class="btn-sec-width">
                                <a href="javascript:void(0);" class="btn-continue"  id="saveContCaseInfo">SAVE AND CONTINUE</a>
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
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script src="<?php echo base_url(); ?>assets/js/inv_stock.js" type="text/javascript"></script>      
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>    
<script>
     
    $('.lead_source').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
    $(document).ready(function() {
        var cat_val = $('#source_cat').val();
        if(cat_val==1){
          $('#eval_fields').hide();
        }
        else{
            $('#eval_fields').show()
        }
        var trade_type=$('input[name=tradetype]:checked').val();
        toggleAmount(trade_type);
        
        $('#dob').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#pdate').datepicker({
                format: 'dd-mm-yyyy',
                //startDate: '-1000y',
                endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
        $('#ddate').datepicker({
                format: 'dd-mm-yyyy',
                startDate: 'd',
                //endDate:'d',
                autoclose: true,
                todayHighlight: true   
             });
       // $('#')
    });
    function toggleAmount(trade_type){
        if(trade_type==1){
            $('.purchase_amt').hide();
            $('.expected_amt').show()
        }
        else if(trade_type==2){
            $('.expected_amt').hide();
            $('.purchase_amt').show()
        }
    }
    function forceNumber(event){
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
        return false;
}
 

function addCommasdd(nStr,control)
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
    $('#source_cat').change(function() {
        
        var cat_id = $('#source_cat').val();
            if(cat_id==1){
              $('#eval_fields').hide();
            }
            else{
                $('#eval_fields').show()
            }
        var sel = "<?=(!empty($usedCarInfo['name_id']))?$usedCarInfo['name_id']:''?>"
        if(cat_id>0)
        {
            //alert("<?php echo base_url(); ?>" + "Finance/getCustomerDetails/");
            $.ajax({
            type: 'POST',
            url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getSubCatergory/",
            data:{cat_id:cat_id,sel:sel},
            dataType: "html",
            success: function(response) 
            {
                $('#source_name').html(response);
                 $('#source_name')[0].sumo.reload();
            }   
            });
        }
        else{
                $('#source_name').html('<option value="0">Select Name</option>');
        
        }
    });
     </script>
     
     <?php
     if(!empty($usedCarInfo))
     {?>
<script>
    $('#source_cat').trigger('change');
</script>

    <?php } ?>

