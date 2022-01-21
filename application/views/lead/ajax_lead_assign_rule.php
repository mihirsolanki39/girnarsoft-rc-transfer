<div class="clearfix tabs workingdetials">
    <div class="" id="buyerleads-new">
        <div role="tabpanel" class="" id="sellerlead">
           
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="font-16 mrg-T15 mrg-B15 col-black">Lead Assignment Rule</h5>
                    </div>
                    <div class="col-md-12 mrg-T5">
                        <div class="row">
                            <div class="col-md-4">
                                <input name="z" onclick="" <?=$rule_type==1?'checked="checked"':''?>  type="radio" id="w">
                                <label class="mrg-R10 segement" for="w">
                                    <span></span>Car Segment Wise
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input name="z" onclick="" <?=$rule_type==2?'checked="checked"':''?> type="radio" id="z">
                                <label class="mrg-R10 lead-cre" for="z">
                                    <span></span>Lead creation Date wise
                                </label>
                            </div>
                        </div>
                    </div>
                    <form id="datewise_form">
                        <input type="hidden" value="2" name="rule_type">
                    <?php if(!empty($assignRuleResult) && $rule_type==2){ 
                          $i=1;
                          foreach($assignRuleResult as $assignResult){ ?>
                    <div class="col-md-12 mrg-T15 datewise"  id="datewise_<?=$i?>" style="<?=$rule_type==2?'display:block':'display:none'?>">
                        <div class="row">
                            <input type="hidden" value="<?=$assignResult['mapping_id']?>" name="data[<?=$i?>][mapping_id]" />
                            <div class="col-md-3 pad-R5">
                                <div class="form-group">
                                     <label>Select Date From</label>
                                     <select  class="form-control" name="data[<?=$i?>][from]">
                                        <?php foreach(range(1, 31) as $key){?>
                                        <option <?=$assignResult['rule_valid_from']==$key?'selected':''?> ><?=$key?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pad-L5 pad-R5">
                                <div class="form-group">
                                     <label>Select Date To</label>
                                    <select <?=$assignResult['rule_valid_to']==$price?'selected':''?> class="form-control" name="data[<?=$i?>][to]">
                                        <?php foreach(range(1, 31) as $key){?>
                                        <option <?=$assignResult['rule_valid_to']==$key?'selected':''?> ><?=$key?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pad-L5">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="data[<?=$i?>][user_id]">
                                        <?php foreach($executives as $executive){?>
                                        <option <?=$assignResult['user_id']==$executive['id']?'selected':''?> value="<?=$executive['id']?>"><?=$executive['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pad-L5 pad-R5">
                                <a href="javascript:void(0);" onclick="appendMore('datewise','datewise_1')" class="btn-add mrg-T20">+</a>
                                 <?php if($i>1){?> <a href="javascript:void(0);" onclick="removeAssignment('datewise_<?=$i?>')" class="btn-add mrg-T20">-</a><?php } ?>
                            </div>
                        </div>
                    </div>
                          <?php $i++; }}else{ ?>
                           <div class="col-md-12 mrg-T15 datewise"  id="datewise_1" style="<?=$rule_type==2?'display:block':'display:none'?>">
                        <div class="row">
                            <div class="col-md-3 pad-R5">
                                <div class="form-group">
                                     <label>Select Date From</label>
                                     <select class="form-control" name="data[1][from]">
                                        <?php foreach(range(1, 31) as $key){?>
                                        <option><?=$key?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pad-L5 pad-R5">
                                <div class="form-group">
                                     <label>Select Date To</label>
                                    <select class="form-control" name="data[1][to]">
                                        <?php foreach(range(1, 31) as $key){?>
                                        <option><?=$key?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pad-L5">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="data[1][user_id]">
                                        <?php foreach($executives as $executive){?>
                                        <option value="<?=$executive['id']?>"><?=$executive['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pad-L5 pad-R5">
                                <a href="javascript:void(0);" onclick="appendMore('datewise','datewise_1')" class="btn-add mrg-T20">+</a>
                            </div>
                        </div>
                    </div>
                    <?php  } ?>
                    <div class="col-lg-12 mrg-T15 text-center">
                        <button type="button" id="save_datewise_rule"  class="btn btn-save-new btn-pad-sm  datewise-btn" style="<?=$rule_type==2?'display:block':'display:none'?>"  >SAVE</button>
                    </div>
                    </form>
                    <form id="segmenwise_form">
                        <input type="hidden" value="1" name="rule_type">
                     <?php if(!empty($assignRuleResult) && $rule_type==1){
                         $i=1;
                         foreach($assignRuleResult as $assignResult){?>
                    <div class="col-md-12 mrg-T15 segmentwise" id="segmentwise_<?=$i?>"  style="<?=$rule_type==1?'display:block':'display:none'?>">
                        <div class="row">
                            <input type="hidden" value="<?=$assignResult['mapping_id']?>" name="data[<?=$i?>][mapping_id]" />
                            <div class="col-md-3 pad-R5">
                                <div class="form-group">
                                    <label>From</label>
                                    <select class="form-control" name="data[<?=$i?>][from]">
                                        <?php foreach ($min_price_segment as $price){?>
                                        <option <?=$assignResult['rule_valid_from']==$price?'selected':''?> value='<?=$price?>'><?=$price?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pad-L5 pad-R5">
                                <label>To</label>
                                <select class="form-control" name="data[<?=$i?>][to]">
                                    <?php foreach ($max_price_segment as $price){?>
                                        <option <?=$assignResult['rule_valid_to']==$price?'selected':''?> value='<?=$price?>'><?=$price?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 pad-L5">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="data[<?=$i?>][user_id]">
                                       <?php foreach($executives as $executive){?>
                                        <option <?=$assignResult['user_id']==$executive['id']?'selected':''?> value="<?=$executive['id']?>"><?=$executive['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pad-L5 pad-R5">
                                <a href="javascript:void(0);" onclick="appendMore('segmentwise','segmentwise_<?=$i?>')" class="btn-add mrg-T20">+</a>
                               <?php if($i>1){?> <a href="javascript:void(0);" onclick="removeAssignment('segmentwise_<?=$i?>')" class="btn-add mrg-T20">-</a><?php } ?>
                            </div>
                        </div>
                    </div>
                     <?php $i++; }}
                     else{ ?>
                         <div class="col-md-12 mrg-T15 segmentwise" id="segmentwise_1"  style="<?=$rule_type==1?'display:block':'display:none'?>">
                        <div class="row">
                            <div class="col-md-3 pad-R5">
                                <div class="form-group">
                                    <label>From</label>
                                    <select class="form-control" name="data[1][from]">
                                        <?php foreach ($min_price_segment as $price){?>
                                        <option value='<?=$price?>'><?=$price?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pad-L5 pad-R5">
                                <label>To</label>
                                <select class="form-control" name="data[1][to]">
                                    <?php foreach ($max_price_segment as $price){?>
                                        <option value='<?=$price?>'><?=$price?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 pad-L5">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="data[1][user_id]">
                                       <?php foreach($executives as $executive){?>
                                        <option value="<?=$executive['id']?>"><?=$executive['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pad-L5 pad-R5">
                                <a href="javascript:void(0);" onclick="appendMore('segmentwise','segmentwise_1')" class="btn-add mrg-T20">+</a>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <div class="col-lg-12 mrg-T15 text-center">
                        <button  type='button' id="save_segmentwise_rule"   class="btn btn-save-new btn-pad-sm  segmentwise-btn" style="<?=$rule_type==1?'display:block':'display:none'?>" >SAVE</button>
                    </div>
                    </form>
                   
                </div>
            
        </div>

    </div>
</div>

   
<script>
    

$(".segement").click(function(){
  $(".segmentwise").show();
  $(".segmentwise-btn").show();
  $(".datewise").hide();
  $(".datewise-btn").hide();
});

$(".lead-cre").click(function(){
  $(".datewise").show();
  $(".datewise-btn").show();
  $(".segmentwise").hide();
  $(".segmentwise-btn").hide();
});

jQuery(function(){
 jQuery('#lead_creation_date_from_1').datetimepicker({
  format:'Y/m/d',
  onShow:function( ct ){
   
   this.setOptions({
    maxDate:jQuery('#lead_creation_date_to_1').val()?jQuery('#lead_creation_date_to_1').val():'today',
   })
  },
 
  timepicker:false
 });
 jQuery('#lead_creation_date_to_1').datetimepicker({
  format:'Y/m/d',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#lead_creation_date_from_1').val()?jQuery('#lead_creation_date_from_1').val():false,
    maxDate:'today'
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});

function addCalenderScript(from_date,to_date){
    alert(from_date)
 jQuery('#'+from_date).datetimepicker({
  format:'Y/m/d',
  onShow:function( ct ){
   
   this.setOptions({
    maxDate:jQuery('#'+to_date).val()?jQuery('#'+to_date).val():'today',
   })
  },
 
  timepicker:false
 });
 jQuery('#'+to_date).datetimepicker({
  format:'Y/m/d',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#'+from_date).val()?jQuery('#'+from_date).val():false,
    maxDate:'today'
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });

}
function appendMore (rule_type,id){
   var no_of_elements=$('.'+rule_type).length;
   var id_of_next_element= no_of_elements+1;
   var cal_from_date_id= 'lead_creation_date_from_'+id_of_next_element;
   var cal_to_date_id= 'lead_creation_date_to_'+id_of_next_element;
   
   if($("#" +rule_type+'_'+id_of_next_element).length==1){
       id_of_next_element+=1;
       no_of_elements+=1;
        cal_from_date_id= 'lead_creation_date_from_'+id_of_next_element;
        cal_to_date_id= 'lead_creation_date_to_'+id_of_next_element;
       
   }
    if(rule_type=='datewise'){
        //addCalenderScript(cal_from_date_id,cal_to_date_id);
        $('#'+rule_type+'_'+no_of_elements).after(`
                 <div class="col-md-12 mrg-T15 ${rule_type} more-${rule_type}" id="${rule_type+'_'+id_of_next_element}"  style="display: block">
                        <div class="row">
                            <div class="col-md-3 pad-R5">
                                <div class="form-group daterange">
                                    <label>Select Date From</label>
                                    <select class="form-control" name="data[${id_of_next_element}][from]">
                                      <?php foreach(range(1, 31) as $key){?>
                                       <option><?=$key?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pad-L5 pad-R5">
                                <div class="form-group daterange">
                                    <label>Select Date From</label>
                                    <select class="form-control" name="data[${id_of_next_element}][to]">
                                      <?php foreach(range(1, 31) as $key){?>
                                       <option><?=$key?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 pad-L5">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="data[${id_of_next_element}][user_id]">
                                       <?php foreach($executives as $executive){?>
                                        <option value="<?=$executive['id']?>"><?=$executive['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pad-L5 pad-R5">
                                <a href="javascript:void(0);" onclick="appendMore('${rule_type}')" class="btn-add mrg-T20">+</a>
                                <a href="javascript:void(0);" onclick="removeAssignment('${rule_type+'_'+id_of_next_element}')" class="btn-add mrg-T20">-</a>
                            </div>
                        </div>
        </div>`);
    }
    else{
        $('#'+rule_type+'_'+no_of_elements).after(`
                  <div class="col-md-12 mrg-T15 ${rule_type} more-${rule_type}" id="${rule_type+'_'+id_of_next_element}"  style="display: block">
                        <div class="row">
                            <div class="col-md-3 pad-R5">
                                <div class="form-group">
                                    <label>From</label>
                                    <select class="form-control" name="data[${id_of_next_element}][from]">
                                         <?php foreach ($min_price_segment as $price){?>
                                        <option value='<?=$price?>'><?=$price?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pad-L5 pad-R5">
                                <label>To</label>
                                <select class="form-control" name="data[${id_of_next_element}][to]">
                                    <?php foreach ($max_price_segment as $price){?>
                                        <option value='<?=$price?>'><?=$price?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 pad-L5">
                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" name="data[${id_of_next_element}][user_id]">
                                       <?php foreach($executives as $executive){?>
                                        <option value="<?=$executive['id']?>"><?=$executive['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pad-L5 pad-R5">
                                <a href="javascript:void(0);" onclick="appendMore('${rule_type}')" class="btn-add mrg-T20">+</a>
                                <a href="javascript:void(0);" onclick="removeAssignment('${rule_type+'_'+id_of_next_element}')" class="btn-add mrg-T20">-</a>
                            </div>
                        </div>
                    </div>`);
    }
}
function removeAssignment(id){
    $('#'+id).remove();
}

$('#save_segmentwise_rule').click(function(){
    //console.log($('#segmenwise_form').serialize());
    submitRule($('#segmenwise_form').serialize());
});
$('#save_datewise_rule').click(function(){
    //console.log($('#datewise_form').serialize());
    submitRule($('#datewise_form').serialize());
});
function submitRule(formDataSearch){
     $.ajax({
            type: 'POST',
            url: base_url+"lead/save_assignment_rule",
            data: formDataSearch,
            dataType: 'json',
            success: function (responseData, status, XMLHttpRequest) {
               if (responseData.status == true) {
                snakbarAlert(responseData.message);
                //$('#createUser').modal('close');
                $('#close-lead_assign-modal').trigger('click');
                } else {
                    snakbarAlert(responseData.message);
                    return false;
                }
            }
    });
}
</script>