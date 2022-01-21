<?php //echo "<pre>"; print_r($query); die; ?>
<?php $teamn = !empty($this->session->userdata['userinfo']['team_name'])?$this->session->userdata['userinfo']['team_name']:'';?>
<div class="container-fluid mrg-all-20">
  <style>.dot-sep{content: ""; height: 4px; width: 4px; background: rgba(0,0,0,0.3); border-radius: 15px; display: inline-block; margin: 3px 7px;} </style>
  <div class="row">
    <div class="">
     <div class="cont-spc pad-all-20" id="buyer-lead">
       <form role="form" name="searchform" id="searchform">
        <div class="row">
         <div class="col-md-2 pad-R0">
          <label for="" class="crm-label">Search By</label>
          <div class="select-box" style="width:80px">Select <span class="d-arrow d-arrow-new"></span></div>
          <ul class="drop-menu">
           <li><a href="#" onclick="searchby(this)" id="searchcustname">Customer name</a></li>
           <li><a href="#" onclick="searchby(this)" id="searchmobile">Mobile number</a></li>
           <li><a href="#" onclick="searchby(this)" id="searchdealer">Dealership</a></li>
           <li><a href="#" onclick="searchby(this)" id="searchinsurance">Insurance Company</a></li>
           <li><a href="#" onclick="searchby(this)" id="searchreg">Reg no</a></li>
           <li><a href="#" onclick="searchby(this)" id="searchsl">Serial no</a></li>
         </ul>
         <!-- /btn-group -->
         <div id="dropD">
             <input type="text"  id="search_by_text" name="keyword" id="keyword" class="form-control crm-form drop-form abc4" style="display:block" readonly="readonly">
           <select name="keywordbyd" id="keyword" class="form-control crm-form drop-form abc1 " style="display: none;"><option value="">Select Dealer</option></select> 
           <select name="keywordbyIns" id="keyword" class="form-control crm-form drop-form abc2 " style="display: none;"><option value="">Select Company</option></select>
           <input type="text"  name="keywordsl" id="keyword" class="form-control crm-form drop-form abc3" style="display:none">
         </div>
         <input type="hidden" name="searchby" id="searchby" value="">
       </div>
       <div class="col-md-1 pad-L10 pad-R0">
        <label for="" class="crm-label">Source</label>
        <select class="form-control crm-form testselect1" name="ins_source" id="ins_source">
         <option selected="selected" value="">Select</option>
         <option value="walkin">Walkin</option>
         <option value="dealer">Dealer</option>
         <option value="callcenter">Call Center</option>
       </select>

     </div>
     <div class="col-md-1 pad-L10 pad-R0">
      <label for="" class="crm-label">Status</label>
      <select class="form-control crm-form testselect1" name="ins_status" id="ins_status">
       <option value="">Status</option>
       <?php       
       foreach (INSURANCE_STATUS as $key=>$ins_status){?>
         <option value="<?=$key?>" <?php if(!empty($type) && $type==$key){ echo "selected";} else{ echo ""; }?>><?php echo $ins_status; ?></option>
       <?php }?>
     </select>
   </div>
   <div class="col-md-1 pad-L10 pad-R0">
    <label for="" class="crm-label">Category</label>
    <select class="form-control crm-form testselect1" name="ins_category" id="ins_category">
     <option selected="selected" value="">Select</option>
     <option value="1">New Car</option>
     <option value="2">Used Car</option>
     <option value="3">Renewal</option>
     <option value="4">Policy Already Expired</option>
   </select>
 </div>
 <div class="col-md-1 pad-L10 pad-R0">
    <label for="" class="crm-label">Policy Type</label>
    <select class="form-control crm-form testselect1" name="ins_policy" id="ins_policy">
    <option value="">Select Policy Type</option>
    <?php foreach (INSURANCE_POLICY_TYPE as $key=>$policy_type) { ?>
       <option value="<?=$key?>"><?=$policy_type?></option>
    <?php } ?>
   </select>
 </div>
 <div class="col-md-1 pad-L10 pad-R0">
  <label for="" class="crm-label">Assign To</label>
  <select class="form-control crm-form testselect1" name="dealtby" id="dealtby">
   <option selected="selected" value="">Select</option>
   <?php foreach ($employeeList as $key=>$value){ ?>
    <option value="<?=$value['id']?>" <?php echo !empty($CustomerInfo) && $CustomerInfo['assign_to']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
  <?php } ?>
</select>
</div> 
<div class="col-md-3 pad-L10 pad-R10">
  <label class="crm-label">Date</label>
  <div class="row">
   <div class="col-md-4 pad-R0 mrg-R0">
     <div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
     <ul class="drop-menu drop-menu-1">
       <li><a href="#" onclick="searchby('',this)" id="createdate">Created Date</a></li>
       <li><a href="#" onclick="searchby('',this)" id="quoteshared">Quotes Shared</a></li>
       <li><a href="#" onclick="searchby('',this)" id="inspectiondate">Inspection Date</a></li>
       <li><a href="#" onclick="searchby('',this)" id="issuedate">Issue Date</a></li>
       <li><a href="#" onclick="searchby('',this)" id="canceldate">Cancelled Date</a></li>
       <li><a href="#" onclick="searchby('',this)" id="closeddate">Closed Date</a></li>
       <li><a href="#" onclick="searchby('',this)" id="inceptiondate">Inception Date</a></li>
     </ul>
   </div>
      <div class="col-md-4 new_lead pad-all-0">
    <input type="hidden" name="searchdate" id="searchdate" value=""> 
    <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
        <input type="text" name="createStartDate" id="createStartDate" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From" disabled="disabled"> 
   </div>
 </div>
 <div class="col-md-4 new_lead pad-all-0">
  <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
   <input type="text" name="createEndDate" id="createEndDate" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To" disabled="disabled"> 
 </div>
</div>
</div>
</div>
<div class="col-md-2 pad-R0">
  <span id="spnsearch">
    <input type="button" class="btn-save btn-save-new" value="Search" id="search">

    <a href="JavaScript:Void(0)" id="Reset" class="mrg-L10  used__car-reset-btn">RESET</a>
    <input type="hidden" name="page" id="page" value="1">
    <input type="hidden" name="insdashId" id="insdashId" value="<?php echo (!empty($insId)) ? $insId:'';?>">

  </span>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<div class="container-fluid mrg-all-20">
 <div class="row">
  <div class="">
   <div class="background-ef-tab" id="loandetails">
    <div class="tabs loandetails">
      <div class="row pad-all-20">
       <div class="col-md-6">
         <h5 class="cases">Insurance Cases (<span id="totcase"><?php echo (!empty($leadtabCount)) ? $leadtabCount : 0; ?></span>)</h5>
       </div>
       <?php if(!empty($teamn) && ($teamn!='Sales') || ($teamn=='')){?>
         <div class="col-md-6">
           <?php if($this->session->userdata['userinfo']['is_admin']=='1'){?>
            <a id="Export" href="JavaScript:void(0)" class="pull-right mrg-L10 mrg-T10 pad-L15">DOWNLOAD EXCEL</a>
          <?php } ?>
        </div> 
      <?php } ?>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active tabn" id="finalized">
       <div class="container-fluid ">
        <div class="row">
         <div class="col-lg-12 col-md-12">
          <div class="row">
           <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
             <thead>
              <tr>
                <th width="3%">Sno.</th>
                <th width="13%">Customer Details</th>
                <th width="18%">Car Details</th>
                <th width="14%">Previous Policy Details</th>
                <th width="13%">New Policy Details</th>
                <th width="13%">Case Details</th>
                <th width="13%">Case Update</th>
                <th width="6%">Actions</th>
              </tr>
            </thead>
            <tbody  id="ins_list">
              <?php //echo "<pre>"; print_r($query); ?>
              <span id="imageloder" style="display:none; position:absolute;left: 40%;border-radius: 50%;z-index:999; ">
                <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>
                <?php
                if(!empty($query['leads'])){
                        //echo "<PRE>";
                        //print_r($query['leads']);
                  foreach ($query['leads'] as $key=>$val){ 
                    $link=''; 

                    if(empty($link)){
                      $link=!empty($val["upload_ins_doc_flag"])? base_url('insDocumentDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    }
                    if(empty($link)){
                      $link=!empty($val["payment_by"])? base_url('insPolicyDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    }
                    if((empty($link)) && ($val['mi_funding']=='2')){     
                      $link=(!empty($val["customer_address"]) && $val["customer_address"]!='') ? base_url('inspaymentDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    }
                    if(empty($link) && (($val['ins_category']=='2') || ($val['ins_category']=='4'))){
                      $link=(!empty($val["inspection_add_date"]) && ($val["inspection_add_date"]!='0000-00-00 00:00:00')) ? base_url('inspersonalDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    //$link=!empty($val["customer_address"]) ? base_url('insPolicyDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    }

                    if(empty($link) && ($val["ins_category"]=='4' && $val["isexpired"]=='1')){
                      $link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00'))? base_url('insInspection/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                    }elseif(empty($link) && ($val["ins_category"]=='2')){
                     $link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00'))? base_url('insInspection/').base64_encode('CustomerId_'.$val["customer_id"]):'';   
                   }
                   if(empty($link) && ($val["ins_category"]=='4' && $val["isexpired"]=='0')){
                    $link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00')) ? base_url('insPreviousDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                  }elseif(empty($link) && ($val["ins_category"]=='3')){
                    $link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00')) ? base_url('insPreviousDetails/').base64_encode('CustomerId_'.$val["customer_id"]):'';    
                  }elseif(empty($link) && ($val["ins_category"]=='1')){
                    $link=!empty($val["quote_add_date"] && ($val["quote_add_date"]!='0000-00-00 00:00:00')) ? base_url('inspersonalDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';    
                  }
                  if(empty($link)){   
                    $link=!empty($val["make"])? base_url('insFileLogin/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                  }
                  if(empty($link)){
                    $link= !empty($val["ins_category"])? base_url('insvehicalDetail/').base64_encode('CustomerId_'.$val["customer_id"]):'';
                  }

                  if(empty($link)){
                    $link =base_url('addInsurance');    
                  }
                 // echo "<pre>";print_r($val);die;
                  ?>
                  <tr class="hover-section" >
                    <td style="position:relative"><?=$val['sno']?></td>
                    <td style="position:relative">
                      <?php if($val['buyer_type']=='1'){?>    
                        <div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower($val['customer_name'])) : 'NA'); ?></b></div>
                      <?php } elseif($val['buyer_type']=='2') {?>
                        <div class="mrg-B5"><b><?php echo (($val['customer_company_name'] != '') ? ucwords(strtolower($val['customer_company_name'])) : 'NA'); ?></b></div>
                      <?php } ?>
                      <div class="font-13 text-gray-customer"><span class="font-14"><?php echo $val['number']; ?></span><br><?php echo $val['emailID']; ?></div>
                      <div><span class="text-gray-customer font-14"><?php echo $val['city_name']; ?></span></div>
                         <?php if(!empty($val['customer_nominee_ref_name'])) { ?>
                           <div><span class="text-gray-customer font-14">Reference: <?php echo $val['customer_nominee_ref_name']; ?></span></div>
                         <?php } ?>
                         <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $val['leadCreatedDate']; ?></span></div>
                    </td>
                    <td style="position:relative">
                      <?php if(!empty($val['make'])){?>
                       <div class="mrg-B5">
                         <b><?php 
                         echo $val['make'].' '.$val['model'].' '.$val['version'];
                         ?>
                       </b>
                     </div>

                     <div class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['regNo']) ? strtoupper($val['regNo']).'<span class="dot-sep"></span>':'';?><?php echo ($val['make_year']) ? $val['make_year']: '';?> Model</span></div>
                     <?php if($val['ins_category']=='1'){
                       $tagname='New Car';
                     }else if($val['ins_category']=='2'){
                       $tagname='Used Car Purchase';
                     }else if($val['ins_category']=='3'){
                       $tagname='Renewal';
                     }else if($val['ins_category']=='4'){
                       $tagname='Policy Expired';
                     }
                     ?>
                     <a href="#" data-toggle="modal" >
                      <div class="arrow-details" >
                       <span class="font-10"><?php echo $tagname;?></span>
                     </div>
                   </a>
                 <?php } else {  ?>
                   <div class="mrg-B5"><b>
                     <?php echo "NA"; }?></b>
                   </div>
                 </td>
                 <td style="position:relative">
                  <?php if($val['previous_policy_no']) {?>  
                    <div class="mrg-B5"><b><?php echo (!empty($val['previous_policy_no'])) ? 'Policy No - '.$val['previous_policy_no']:'';?></b></div>  
                    <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['prev_company_short_name'])) ? $val['prev_company_short_name'] : '';?></span></div>
                    <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['previous_due_date'])) ? 'Due Date - '.$val['previous_due_date']: '';?></span></div>
                  <?php } else {?>
                    <div class="mrg-B5"><b>NA</b></div>
                  <?php } ?>
                </td>
                <?php                
                if(!empty($val['insurance_company'])){
                   $company = $val['insurance_company'];  
                }else {
                   $company = !empty($val['inspect_ins_name'])?$val['inspect_ins_name']:""; 
                }
                ?>
                <td style="position:relative">
                    <div class="mrg-B5">
                       <b><?php echo 'Policy No - ';?></b>
                       <b> <?php  echo (!empty($val['current_policy_no']) ) ? $val['current_policy_no'] : 'NA' ;?></b>
                    </div>
                    <div class="font-14 text-gray-customer">
                        <?php  echo (!empty($company) ) ? $company : 'NA' ;?>
                    </div>
                    <div class="font-14 text-gray-customer">
                        <?php echo 'IDV - ';?>
                        <span class="indirupee rupee-icon"> <?php  echo (!empty($val['idv']) ) ? $val['idv'] : 'NA' ;?> </span> 
                    </div>
                                        <div class="font-14 text-gray-customer">
                        <?php echo 'OD Amount - ';?>
                        <span class="indirupee rupee-icon"> <?php  echo (!empty($val['own_damage']) ) ? $val['own_damage'] : 'NA' ;?></span>
                    </div>
                                        <div class="font-14 text-gray-customer">
                        <?php echo 'Premium - ';?>
                        <span class="indirupee rupee-icon"> <?php  echo (!empty($val['totalpremium']) ) ? $val['totalpremium'] : 'NA' ;?> </span>
                    </div>
                    
                 </td>
                <td style="position:relative">
                  <div class="mrg-T5"><b>Source -<?php if($val['source']=='Dealer') echo ' Dealer'; else echo $val['source'];?></b></div>
                  <div class="font-14 text-gray-customer"><?php if($val['source']=='Dealer'){ echo 'Dealership Name - '.ucfirst($val['dealerName']); } ?></div>
                  <div class="font-14 text-gray-customer">
                    <?php echo (!empty($val['employeeName'])) ? 'Assigned To - '.ucfirst($val['employeeName']) : '';?> 
                  </div>
                </td>
                <td style="position:relative">
                 <?php
                 $updateStatusDate='Updated On';
                 if($val['updateStatus']=='New'){
                  $updateStatusDate='Created On'; 
                }elseif($val['updateStatus']=='Quotes shared'){
                  $updateStatusDate='Quotes Shared'; 
                }elseif($val['updateStatus']=='Inspection Pending'){
                  $updateStatusDate='Inspection Date'; 
                }elseif($val['updateStatus']=='Inspection Completed'){
                  $updateStatusDate='Inspection Date'; 
                }elseif($val['updateStatus']=='Issued'){
                  $updateStatusDate='Issue Date'; 
                }elseif($val['updateStatus']=='Policy Pending'){
                  $updateStatusDate='Pending On'; 
                }elseif($val['updateStatus']=='Payment Pending'){
                  $updateStatusDate='Pending On'; 
                }elseif($val['updateStatus']=='Cancelled'){
                  $updateStatusDate='Cancelled Date'; 
                }elseif($val['updateStatus']=='Not Interested'){
                  $updateStatusDate='Closed Date'; 
                }

                ?>  
                <div class="mrg-B5">
                 <b><?php echo 'Status - ';?></b>
                 <?php  
                 if(!empty($val['updateStatus']) && !empty($val['inspect_ins_name']) && $val['updateStatus']=='Inspection Completed'){
                   echo   '<b>'.$val['updateStatus'].'('.$val['inspect_ins_name'].')</b></br>';
                 }else{
                  echo   '<b>'.$val['updateStatus'].'</b></br>'; 
                }
                ?>
              </div>
              <div class="font-14 text-gray-customer"><?php echo (!empty($val['last_updated_date'])) ?  ( ($val['updateStatus']=='Issued' )? $updateStatusDate.' - '.$val['current_issue_date'] : $updateStatusDate.' - '.$val['last_updated_date']  ):'';?></div>
            </td>
            
            <td style="position:relative">
              <div class="width-save">
                    <?php if($val['ins_approval_status']=='6'){?>
                      <button data-target="#booking-done" data-toggle="tooltip" title="reopen" onclick="reopen(<?php echo $val['customer_id']?>,'<?php echo $link?>');" data-placement="top" class="btn btn-default">REOPEN</button>
                    <?php } else{?>
                      <a href="<?php echo $link;?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                    <?php } ?>
                  </br>
                  <div class="mrg-T5"><a href="Javascript:void(0);" class="text-link font-13" id="comment_history"><button class="btn btn-default history-more" data-target="#trackhistory" data-toggle="modal" data-id="<?php echo $val["customer_id"];?>" title="timeline">TIMELINE</button></a></div>
                  <input type="hidden" name="customer_id" id="customer_id" value="<?php echo (!empty($val['customer_id'])) ? $val['customer_id'] : '';?>">
                </div>
              </td>
        </tr>
        <?php
      } ?>
      <tr><td colspan="8" align='center'>
        <?php if (intval($leadtabCount) > 0) { ?>

          <div class="col-lg-12 col-md-6">
            <nav aria-label="Page navigation">
              <ul class="pagination" >
                <?php
                $total_pages = ceil($leadtabCount / $limit);
                $pagLink = "";

                if ($total_pages < 1) {
                  $total_pages = 1;
                }

                if ($total_pages != 1) {
                                                                                        //this is for previous button
                  if (intval($page) > 1) {
                    $prePage = intval($page) - 1;
                    $pagLink .= '<li onclick="pagination(' . $prePage . ');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>';
                                                                                            //this for loop will print pages which come before the current page
                    for ($i = $page - 6; $i < $page; $i++) {
                      if ($i > 0) {
                        $pagLink .= "<li onclick='pagination(" . $i . ");'><a href='#'>" . $i . "</a></li>";
                      }
                    }
                  }

                                                                                        //this is the current page
                  $pagLink .= "<li class='active' onclick='pagination(" . $i . ");'><a href='#'>" . $page . "</a></li>";
                                                                                        //this will print pages which will come after current page
                  for ($i = $page + 1; $i <= $total_pages; $i++) {

                                                                                            //$pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
                    $pagLink .= "<li onclick='pagination(" . $i . ");' ><a href='#'>" . $i . "</a></li>";
                    if ($i >= $page + 3) {
                      break;
                    }
                  }

                                                                                        // this is for next button
                  if ($page != $total_pages) {
                    $nextPage = intval($page) + 1;
                    $pagLink .= '<li onclick="pagination(' . $nextPage . ');"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
                  }
                }

                echo $pagLink;
                ?>
              </ul>
            </nav>
          </div>
        <?php } ?>     
      </td></tr>
    <?php }else{
      ?>
      <tr><td colspan="8" align='center'><div class='text-center pad-T30 pad-B30'><img src='<?=base_url()?>assets/admin_assets/images/NoRecordFound.png'></div></td></tr>
    <?php } ?>                                

  </tbody>
</table>
</div>
                                 <!--<div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                                    <img src="ajax/loading.gif" title="Click for more" />Click for more
                                  </div>-->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
            <!--<script src="<?=base_url('assets/admin_assets/js/insurance_lead.js')?>"></script>-->
            <script src="<?=base_url('assets/admin_assets/js/processInsurance.js')?>"></script>
            <script>
                 function reopen(customerId,links){
         var r = confirm("Do You Want to Reopen this Case?");
            if (r == true)
            {
                $.ajax({
                  type : 'POST',
                  url : base_url+"Insurance/reopenCase",
                  data : {customerId:customerId,links:links},
                  dataType: 'html',
                  success: function (response) 
                  { 
                     setTimeout(function(){ window.location.href = links; }, 3000);
                  }
               });
            } 
         }
             var date = new Date();
             var d = new Date();        
             d.setDate(date.getDate());        

             $(document).ready(function(){

              // $('.indirupee').each(function(i,val){
              //   var x = $(this).text().split(' ');
              //   x=x.toString();
              //   var lastThree = x.substring(x.length-3);
              //   var otherNumbers = x.substring(0,x.length-3);
              //   if(otherNumbers != '')
              //       lastThree = ',' + lastThree;
              //   var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
              //   res = res.replace(/^,+|,+$/, "");
              //   res = res.replace(/,\s*$/, "");
                
              //   $(this).text(res);
              // });  

              $('body').on('click',function(){
                $('.drop-menu').hide();
              });
              $('.select-box').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).next().show();
              });
              $('.drop-menu li a').click(function(){
                var getText = $(this).text();
                $(this).parents('.drop-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
              });
            });
             $( ".abc1" ).change(function() {
              var va = $(".abc1").val();
              $('#searchbyval').val(va);
            });

             $(".toggle-btn").click(function(){
              $(".novisit").toggle();
            });
             function pagination(page) {
              $("#page").val(page);
              $("#ins_list").html('');
              $('#imageloder').show();
              $.ajax({
                url: base_url + "insurance/ajax_getInsurance",
                type: 'post',
                dataType: 'html',
                data: {'data': $("#searchform").serialize()},
                success: function (response)
                {
                  var res = response.split("####@@@@@");
                  if (res[1] == '1') {
                    $("#totcase").text(res[0]);
                    $("#ins_list").html("<tr><td align='center' colspan='8'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
                  } else {
                    $("#totcase").text(res[0]);
                    $("#ins_list").html(res[1]);
                    $('#imageloder').hide();
                    $(window).scrollTop(0);
                  }
                }
              });
            }
            $("#search").click(function (event) {
             var is_search=1;
             $('#imageloder').show();
             $.ajax({
              url: base_url + "insurance/ajax_getInsurance",
              type: 'post',
              dataType: 'html',
              data: {'data': $("#searchform").serialize()+'&issearch='+is_search},
              success: function (response)
              {
                var res = response.split("####@@@@@");
                if (res[1] == '1') {
                  $("#totcase").text(res[0]);
                  $("#ins_list").html("<tr><td align='center' colspan='8'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
                  $('#imageloder').hide();
                } else {
                  $("#totcase").text(res[0]);
                  $("#ins_list").html(res[1]);
                  $('#imageloder').hide();
                  $(window).scrollTop(0);
                }
              }
            });
           });
            $('#Export').click(function(){
              var input = $("<input>").attr("type", "hidden").attr("name", "export").val("export");
              $('#searchform').append(input);
              $('#searchform').attr('method','post').submit();
      // window.location.href.reload();
    });
            $(document).on('click', '#Reset', function (ev) {
              location.reload(true);
            }); 
            function searchby(eve='',e='')
            {
              //  alert("sfsdf");
                $("#search_by_text").attr("readonly",false);
                if(eve!='')
                {
                 var id = $(eve).attr('id');
                 $('#searchby').val(id);
                 if(id=='searchdealer')
                 {
                  $('.abc4').attr('style','display:none;');
                  $('.abc2').attr('style','display:none;');
                  $('.abc3').attr('style','display:none;');
                  dealerList();
                }
                else if(id=='searchinsurance')
                {
                  $('.abc4').attr('style','display:none;');
                  $('.abc1').attr('style','display:none;');
                  $('.abc3').attr('style','display:none;');
                  insurerList();
                }
                else if(id=='searchsl')
                {
                  $('.abc3').attr('style','display:block;');
                  $('.abc4').attr('style','display:none;');
                  $('.abc1').attr('style','display:none;');
                  $('.abc2').attr('style','display:none;');
                }
                else
                {
                  $('.abc4').attr('style','display:block;');
                  $('.abc1').attr('style','display:none;');
                  $('.abc2').attr('style','display:none;');
                  $('.abc3').attr('style','display:none;');
                }
              }
              else
              {
               $("#createStartDate").prop('disabled',false);
               $("#createEndDate").prop('disabled',false);
                var id = $(e).attr('id');
                var date = new Date();
                var d = new Date();        
                d.setDate(date.getDate());
                  
                $('.icon-cal1').datepicker('destroy');
                if(id == "inceptiondate"){      
                   // alert("aa");
                    $("#createStartDate").datepicker({
                    format: 'dd/mm/yyyy',
                    minDate : 0,                       
                    maxDate : "+3Y",
                    autoclose: true,
                    }).on('changeDate', function (selected) {
                        var startDate = new Date(selected.date.valueOf()); 
                        $('#createEndDate').datepicker('setStartDate', startDate);
                    }).on('clearDate', function (selected) { 
                        $('#createEndDate').datepicker('setStartDate', null);
                    });
                    $("#createEndDate").datepicker({
                        format:"dd/mm/yyyy", 
                        minDate : 0,                       
                        maxDate : "+3Y",
                        autoclose: true,
                    });
                }else {
                    $("#createStartDate").datepicker({
                    format: 'dd/mm/yyyy',
                    endDate: d,
                    autoclose: true,
                    }).on('changeDate', function (selected) {
                        var startDate = new Date(selected.date.valueOf()); 
                        $('#createEndDate').datepicker('setStartDate', startDate);
                    }).on('clearDate', function (selected) { 
                        $('#createEndDate').datepicker('setStartDate', null);
                    });
                    $("#createEndDate").datepicker({
                        format:"dd/mm/yyyy", 
                        endDate: d
                    });

                }
               $('#searchdate').val(id);
             }
         }

         function dealerList()
         {
           $.ajax({
             type : 'POST',
             url : "<?php echo base_url(); ?>" + "Finance/getDealerList/",
             dataType: 'html',
             success: function (response) 
             { 
              $('.abc4').attr('style','display:none;');
              $('.abc2').attr('style','display:none;');
              $('.abc3').attr('style','display:none;');
              $('.abc1').attr('style','display:block;');
              $('.abc1').html(response);

            }
          });
         }

         function insurerList()
         {
          //alert('hiii');
          $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "Insurance/getInsuList/",
           dataType: 'html',
           success: function (response) 
           { 
            $('.abc4').attr('style','display:none;');
            $('.abc1').attr('style','display:none;');
            $('.abc3').attr('style','display:none;');
            $('.abc2').attr('style','display:block;');
            $('.abc2').html(response);

          }
        });
        }
      </script>
      <script>
          document.getElementById('searchform').addEventListener('keypress', function(event) {
              if (event.keyCode == 13) {
                  $("#search").click();
              }
          });
      </script>
