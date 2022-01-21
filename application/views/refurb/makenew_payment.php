
<form id="editids" name="editids">
      <div class="modal-body">
        <div class="clearfix">
          <div class="row">
            <div class="col-md-4">
            <div class="form-group">
              <input class="form-control" type="" name="" placeholder="search here" id="search_filter">
            </div></div>
          </div>
        </div>
        <div class="clearfix">
          <style>
            .table-of{height: 200px; overflow-y: scroll;}
            .text-right{text-align: right;}
          </style>
          <div class="table-of">
            <table class="table table-bordered table-striped table-hover enquiry-table mytbl mrg-B0">
                       <thead>
                           <tr>
                             <th width="5%">Select</th>
                             <th width="35%">Stock</th>
                             <th width="30%">Date of Refurb</th>
                             <th width="30%">Amount</th>
                          </tr>
                       </thead>
                       <tbody id="search_table">
                       <?php 
                       $i = 1;
                       foreach($caseList as $ky => $vl){
                        $checked = '';
                        if(in_array($vl['car_id'], $paymentDetails['car_ids'])){
                          $checked = "checked=checked";
                          } ?>
                        
                          <tr>
                            <td>
                              <input name="verified[]"  type="checkbox" id="car_<?=$i?>" value="<?=$vl['car_id'].'@'.$vl['refurb_id']?>" <?=$checked?>><label class="mrg-R10" for="car_<?=$i?>"><span></span>
                            </td>
                            <td>
                              <div class="mrg-B5"><b><?=$vl['make'].' '.$vl['model'].' '.$vl['version']."</b><br/>". $vl['regno'] ." | ".$vl['make_year']." Model" ?> </div>
                              
                            </td>
                            <td>
                              <?=date('d-m-Y',strtotime($vl['sent_to_refurb']))?>
                            </td>
                            <td>
                              <i class="fa fa-rupee"></i> <span id="est_amt_<?=$i?>"><?=$vl['actual_amt'];?> </span>
                            </td>
                            
                          </tr>      
                          <?php $i++; 
                          } ?>
                        </tbody>
            </table>

          </div>
          <div class="row mrg-T10 mrg-B20">
            <div class="col-md-6"><span id="stocksel"><?=count($paymentDetails['car_ids'])?></span> Stocks Selected</div>
            <div class="col-md-6 text-right">Total Amount : <span id="tot_amt" class="rupee-icon"><?=!empty($paymentDetails['total_amount'])?$paymentDetails['total_amount']:"0"?></span>/-</div>

          </div>
        <div id="err_counter" style="color:#900505;font-size:10px;"></div>
        </div>
        <div class="clearfix">
          <div class="row">
             <div class="col-md-12">
               <h2 class="sub-title mrg-T0">Payment Details</h2>
              </div>
              <input type="hidden" id="totamt" name="totamt" value="<?=$paymentDetails['total_amount']?>">
              <input type="hidden" id="counter" name="counter" value="<?=count($paymentDetails['car_ids'])?>">
              <input type="hidden" id="estimat_amt" name="estimat_amt[]" value="">
              

             <div class="col-md-4" style="height:84px">
                <div class="form-group">
                   <label for="" class="crm-label">Instument Type*</label>
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
             <div class="col-md-4" style="height:84px">
                <div class="form-group">
                   <label for="" class="crm-label">Amount*</label>
                   <input type="text" id="amounts" onkeypress="return isNumberKey(event)" onkeyup="addCommased(this.value,'amounts');setVal(this.value)"  maxlength="8"   name="amount" readonly  class="form-control crm-form rupee-icon" placeholder="Amount" value="<?=(!empty($paymentDetails['amount'])?$paymentDetails['amount']:'')?>" >
                <div class="error" id="err_amounts"></div>
                </div>
             </div>
             <div class="col-md-4" style="height:84px">
                <div class="form-group">
                   <label for="" class="crm-label">Payment Date*</label>
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

              <div class="col-md-4" id="ins_no" <?=((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type']!='cash')))?'style="height: 84px;display: block;"':'style="height: 84px;display: none;"')?>>
                <div class="form-group">
                   <label for="" class="crm-label">Instrument No</label>
                   <input type="text" id="insnos" onkeypress="return blockSpecialChar(event)"  name="insno"  class="form-control crm-form" placeholder="Instrument No." value="<?=(!empty($paymentDetails['instrument_no'])?$paymentDetails['instrument_no']:'')?>">
                <div class="error" id="err_insnos"></div>
                </div>
             </div>

            <div class="col-md-4" id="ins_date"  <?=((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type']!='cash')))?'style="height:84px;display: block;"':'style="height:84px;display: none;"')?> >
                <div class="form-group">
                   <label for="" class="crm-label">Instrument Date</label>
                   <div class="input-group date" id="dp">
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
</div>
             <div class="col-md-4"  id="bnk" <?=((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type']!='cash') && ($paymentDetails['instrument_type']!='online')))?'style="height: 84px;display: block;"':'style="height: 84px;display: none;"')?>>
            <div class="form-group">
                <label class="crm-label">Bank Name</label>
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


             <div class="col-md-6" id="favo" <?=((!empty($paymentDetails['instrument_type']) && (($paymentDetails['instrument_type']!='cash') && ($paymentDetails['instrument_type']!='online')))?'style="height: 84px;display: block;"':'style="height: 84px;display: none;"')?>>
            <div class="form-group">
                <label class="crm-label">Favouring</label>
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
          </div>
        </div>
      </div>
      <input type="hidden" name="workshop_id" value="<?php echo $workshop_id; ?>" id="workshop_id">
        <input type="hidden" name="edit_id" value="<?=(!empty($paymentDetails['id'])?$paymentDetails['id']:'')?>" id="edit_id">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveEditData()">Pay</button>
      </div>

 </form>

 <script>
   function addVal(carid,amount)
   {
   // alert(amount);
      var totalamt = $('#totamt').val().replace(/,/g,'');
      var count = $('#counter').val();
      var amounts = $('#amounts').val().replace(/,/g,'');
      count++;
      if(totalamt=='')
      {
          totalamt = 0;
      }
      var sum =  parseInt(totalamt)+parseInt(amount);
      if(amounts!='')
      {
          if(sum>amounts){
          var ss = parseInt(sum)-parseInt(amounts);
          $('#short_amount').val(ss);
          $('#short_amount').trigger('onkeyup');
          }
      }
      
      $('#totamt').val(sum);
      sum = addCommased(sum,'#tot_amt',1,1);
      $('#tot_amt').text(sum);
      $('#stocksel').text(count);
      $('#counter').val(count);
      $('#amounts').val(sum);
   }
   function subVal(carid,amount)
   {
      var totalamt = $('#totamt').val().replace(/,/g,'');
      var count = $('#counter').val();
      var amounts = $('#amounts').val().replace(/,/g,'');
      count--; 
      var sub =  parseInt(totalamt)-parseInt(amount);
      if(amounts!='')
     {
      if(sub>amounts){
        var ss = parseInt(sub)-parseInt(amounts);
        $('#short_amount').val(ss);
        $('#short_amount').trigger('onkeyup');
      }
        //alert(ss);
       // addCommased(ss,'short_amount');
     }
      $('#totamt').val(sub);
      sub = addCommased(sub,'#tot_amt',1,1);
      $('#tot_amt').text(sub);
      $('#stocksel').text(count);
      $('#counter').val(count);
      $('#amounts').val(sub);
   }
    $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
              var cdi = $(this).attr('id');
              var resId = cdi.split("_");
             // alert($('#est_amt_'+resId[1]).text());
              var est_amt = $('#est_amt_'+resId[1]).text().replace(/,/g,'');
              //alert(est_amt);
              var car_id = $(this).val();
              var res = car_id.split("@");
              addVal(res[0],est_amt);
            }
            else if($(this).prop("checked") == false){
                var cdi = $(this).attr('id');
                var resId = cdi.split("_");
                //alert($('#est_amt_'+resId).text());
                var est_amt = $('#est_amt_'+resId[1]).text().replace(/,/g,'');
                var car_id = $(this).val();
                var res = car_id.split("@");
                subVal(res[0],est_amt);
            }
        });


    function setVal(v)
    {
        var amt = v.replace(/,/g, '');
        var totalamt = $('#totamt').val().replace(/,/g, '');
        //alert(totalamt);
        if (totalamt == '' || totalamt == 0)
        {
            alert('Please select stock.');
            return false;
        }
        var ss = totalamt - amt;
        if (ss < 0) {
            alert('Short amount can-not be negative value');
            $('#amounts').val('');
            //$('#short_amount').val(addCommased(totalamt));
            return false;
        }

        $('#short_amount').val(ss);
        $('#short_amount').trigger('onkeyup');
    }
    
    
   $(document).ready(function(){
  $("#search_filter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#search_table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


 $("[data-toggle=popover]").each(function(i, obj) {

    $(this).popover({
      html: true,
      content: function() {
        $('.popover').removeClass('in');
        $('.popover').attr('style','display:none');
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });

    });
 </script>