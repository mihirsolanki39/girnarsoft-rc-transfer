<?php
function getclassifiedHtml($car_id,$featuremsg,$uploadPermission,$totalClassifiedInv,$totalAllowedInv,$type,$case_id){
   
   $finalHtml = '<style>
    .error{font-size:12;color:red;}
     </style>	

          <div class="modal-dialog">
           <form id="blukpremium" name="bluk">

        <div class="modal-content">
            
<div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="'.base_url('/assets/admin_assets/images/cancel.png').'"></button>
                
                
                <h4 class="modal-title">'. $type.' Featured</h4> </div>
          <div class="modal-body">  
            <p class="edit-text font-14 mrg-T15 col-black">';
    $finalHtml .= $featuremsg;
    $finalHtml .= '</p>';
    $finalHtml .= '<div class="modal-footer pad-R0">';
    $finalHtml .= '<img class="premiumloader" style="display:none;width:30px;" src="'.base_url().'"assets/images/loader.gif" >
    <span style="color:green;" class="success"></span>';

    $finalHtml .= '<a type="button" class="mrg-R10 makepremiumcancel" data-dismiss="modal">CANCEL</a>';
    if (($totalClassifiedInv < $totalAllowedInv) || $type == 'Remove')
    { 
    $finalHtml .= '<input type="Button" value="SUBMIT" class="btn btn-primary" onclick="make_premium()" name="submit" id="submitbluk">';
    }
    if($uploadPermission > 0){
        $flag = "'1'";
        $finalHtml .= '<a name="3" href="'.base_url('uploadcardocs/'.base64_encode(DEALER_ID .'_'.$case_id)).'" id="img_3" href="javascript:void(0);"><input type="Button" value="UPLOAD NOW" class="btn btn-primary" id="imageuploadFeature"></a>';
    }
    $finalHtml .= '<input type="hidden" name="carId" id="carId" value="'.$car_id.'">
             <input type="hidden" name="type" id="type" value="'.$type.'">';
    $finalHtml .= '</form></div>';
    return $finalHtml;
}

function getclassifiedHtmlfromRemove($car_id,$featuremsg,$uploadPermission,$totalClassifiedInv,$totalAllowedInv,$type){
   
   $finalHtml = '<p class="edit-text font-14 pad-L20 pad-R20">';
    $finalHtml .= $featuremsg;
    $finalHtml .= '</p>';
    $finalHtml .= '</div>';
    $finalHtml .= '<div class="modal-footer">';
    $finalHtml .= '<img class="premiumloader" style="display:none;width:30px;" src="'.base_url().'"assets/images/loader.gif" >
    <span style="color:green;" class="success"></span>';

    $finalHtml .= '<a type="button" class="mrg-R10 makepremiumcancel" data-dismiss="modal">Cancel</a>';
    if (($totalClassifiedInv < $totalAllowedInv) || $type == 'Remove')
    { 
    $finalHtml .= '<input type="Button" value="SUBMIT" class="btn btn-primary" onclick="addStock()" name="submit" id="submitbluk">';
    }
    $finalHtml .= '<input type="hidden" value='.$car_id.' name="carId" id="carId">';
    $finalHtml .= '</div>';
    return $finalHtml;
}
function getmarkRefurb($carId,$wclist,$emplist){
$finalHtml ='';
$onclick  = "addCommas(this.value, 'estimatedAmt');";
$onclickkm = "addCommas(this.value, 'km');";
   $finalHtml .='<style>
           #refurbishment-details .modal-body {padding: 20px 20px;}
           #refurbishment-details .form-control{height: 40px; }
       </style>';
    $finalHtml .='<div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Workshop Name</label>
                               <select class="form-control" name="wcName" id="wcName">';
                                if(!empty($wclist)){
                                     foreach($wclist as $kw=>$vw){ 
                                         $finalHtml .='<option value='.$vw['id'].'>'.$vw['name'].'</option>';
                                }}
                               $finalHtml .='</select>
                           </div>
                       </div>
                       
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Office Corodinator</label>
                               <select class="form-control" name="empName" id="empName">';
                                if(!empty($emplist)){
                                     foreach($emplist as $ke=>$ve){ 
                                         $finalHtml .='<option value='.$ve['id'].'>'.$ve['name'].'</option>';
                                }}
                               $finalHtml .='</select>
                           </div>
                       </div>
                       
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Required Refurb Details</label>
                               <textarea name="txtrefurb" id="txtrefurb" class="form-control" onkeypress="processrefurb(event, this)" style="height: 100px">1. </textarea>
                                  
                           </div>
                        <div class="error" style="margin-top:60px!important" id="txtrefurb_error"></div>
                       </div>
                       
                       <div class="col-md-12">
                           <div class="row">
                               <div class="form-group col-md-6">
                                <label>Sent to Refurb Date</label>
                                   <input type="text" name="refurbsentOn" id="refurbsentOn" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From"> 
                               <div class="error" id="refurbsentOn_error"></div>
</div>
                               
                               <div class="form-group col-md-6">
                                   <label>Expected Return Date</label>
                                   <input type="text" name="refurbestimated" id="refurbestimated" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From"> 
                                <div class="error" id="refurbestimated_error"></div>    
                               </div>
                               
                           </div>
                       </div>
                       
                       <div class="col-md-12">
                       <div class="row">
                              <div class="form-group col-md-6">
                      <label class="crm-label">Kilometers Driven </label> 
                      <input type="text" autocomplete="off" name="sent_km" value="" maxlength="8" id="km" placeholder="Kilometers" class="jNumberonly form-control" onkeyup="'.$onclickkm.'" onkeypress="return forceNumber(event);" value="" > 
                  </div>                       

                           <div class="form-group col-md-6"> 
                               <label>Estimated Amount</label>
                               <input name="estimatedAmt" id="estimatedAmt" maxlength="12" onkeypress="return isNumberKey(event)" onkeyup="'.$onclick.'" type="text" class="form-control rupee-icon">
                                <div class="error" id="estimatedAmt_error"></div>
                             </div>
                           
                        </div>
                       </div>
                       
                       <div class="col-md-12 info-n-count">
                            <span>
                                <input name="checkprint" type="checkbox" id="checkprint" value="todayworks" class="custom-checkbox typecheck" checked="checked"><label for="checkprint" id="todayworks_label" class="text-bold"><span class="mrg-R10"></span>Print Refurb Workorder </label>
                                
                            </span>
                        </div>
                   </div>';
                   $finalHtml .='<input type="hidden" name="carId" id="carId" value="'.$carId.'">';            
                   $finalHtml .='<div class="modal-footer text-left">
                   <a id="addrefurbCancle" href="javasript:void(0);" class="mrg-R10"  data-dismiss="modal">CANCEL</a>
                  <button type="button" class="btn btn-primary" name="addrefurbDetails" id="addrefurbDetails" onclick="addrefurb()">SAVE</button>
               </div><script type="text/javascript">
$(document).ready(function() {

  $("#refurbsentOn").datetimepicker({
    format: "d-m-Y H:i:s"
  }).on("changeDate", function(ev){
     let minDate = new Date(ev.date.valueOf());
     $("#refurbestimated").datetimepicker("setStartDate", minDate);
  });

  $("#refurbestimated").datetimepicker({
    format: "d-m-Y H:i:s"
  }).on("changeDate", function(ev){
     let minDate = new Date(ev.date.valueOf());
     $("#refurbsentOn").datetimepicker("setEndDate", minDate);
  });

  $("#refurbsentOn").datetimepicker("setStartDate", "01/01/1997");
});
</script>';
      return $finalHtml;         
} 

function getvalidmarkRefurb($carid,$data){
    //echo "<pre>";print_r($data);die;
    if(!empty($data)){
        $caseId=(!empty($data[0]['id'])) ?$data[0]['id'] : '';
        $carId=(!empty($data[0]['car_id'])) ?$data[0]['car_id'] : '';
        $refurb_details=(!empty($data[0]['refurb_details'])) ?$data[0]['refurb_details'] : '';
        $estimated_amt=(!empty($data[0]['estimated_amt'])) ?indian_currency_form($data[0]['estimated_amt']) : '';
        $estimated_date=(!empty($data[0]['estimated_date'])) ?$data[0]['estimated_date'] : '';
        $workshopname = (!empty($data[0]['name'])) ?$data[0]['name'] : '';
        $km = (!empty($data[0]['sent_km'])) ?indian_currency_form($data[0]['sent_km']) : '';
    }
    $onclick  = "addCommas(this.value, 'tot_amt');";
    $onclickkm = "addCommas(this.value, 'km');";
    $finalHtml='';
    $finalHtml.='<div class="row">
                       <div class="col-md-6">
                         <div class="form-group">
                               <label>Workshop Name</label>
                                <input name="workshop_name" id="workshop_name" type="text" value="'.$workshopname.'" class="form-control" readonly>
                         </div>      
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">
                               <label>KM Driven</label>
                                <input type="text" autocomplete="off" name="return_km" maxlength="8" id="km" placeholder="Kilometers" class="jNumberonly form-control" onkeyup="'.$onclickkm.'" onkeypress="return forceNumber(event);" value="'.$km.'" > 
                         </div>     
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label>Refurb Done Details</label>
                               <textarea class="form-control" name="refurb_details" id="refurb_details" style="height: 100px" onkeypress="processrefurbNew(event, this)">'.$refurb_details.'</textarea>
                               <div class="error" style="margin-top:60px!important" id="refurb_details_error"></div>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Return Date</label>
                                <input type="text" name="return_date" id="return_date" data-date-end-date="0d" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" value="'.$estimated_date.'"> 
                                <div class="error" id="returndate_error"></div>     
                        </div>
                       </div>
                       
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Total Amount</label>
                               <input name="tot_amt" id="tot_amt" maxlength="12" onkeypress="return isNumberKey(event)" type="text" value="'.$estimated_amt.'" class="form-control rupee-icon" onkeyup="'.$onclick.'">
                               <div class="error" id="totalamount_error"></div>
                            </div>
                       </div>
                       
                   </div>
                   <div class="col-md-12 info-n-count">
                   <div class="row">
                            <span>
                                <input name="checkprint" type="checkbox" id="checkprint" value="todayworks" class="custom-checkbox typecheck" checked="checked"><label for="checkprint" id="todayworks_label" class="text-bold"><span class="mrg-R10"></span>Print Refurb Workorder </label>
                                
                            </span>
                        </div>
                        </div>
               </div>';
    $finalHtml .='<input type="hidden" name="caseId" id="caseId" value="'.$caseId.'">';
    $finalHtml .='<input type="hidden" name="carId" id="carId" value="'.$carId.'">';
    $finalHtml.='<div class="modal-footer text-left">
                   <a id="refub_up_cancle" href="javasript:void(0);" class="mrg-R10" data-dismiss="modal">CANCEL</a>
                  <button id="refub_up_button" type="button" class="btn btn-primary" onclick="updaterefurb()">SAVE</button>
               </div>';
    
    return $finalHtml;
}
?>
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<script>
$('#return_date').datetimepicker({
   format: 'd-m-Y H:i:s',
   maxDate:'0d',
   autoclose: true,
   todayHighlight: true
});

</script>