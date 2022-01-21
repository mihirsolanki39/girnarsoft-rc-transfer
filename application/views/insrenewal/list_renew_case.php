<?php
 if (!empty($type)) {
       $type = $type;
   } else {
       $type = 'all';
       if($ptype == "listing"){
       $type = 'allfollow';    
       }
       
   }
   //print_r($query['emplist']);
   ?>
<link href="<?=base_url('assets/admin_assets/css/common.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/admin_assets/css/buyer-lead.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/admin_assets/css/font-awesome.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery-ui.js')?>"></script>
<link href="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/admin_assets/css/sumoselect.min.css')?>" rel="stylesheet">
<div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <div class="row">
      <div class="col-md-12">
         <div class="" id="buyer-lead">
            <div class="row">
               <div class="col-md-12 pad-all-0">
                  <div class="cont-spc">
                      <form role="form" name="searchform" id="searchform" method="post">
                        <div class=" search-panel">
                            <input type="hidden" name="page" id="page" value="1">
                            <input type="hidden" name="currenturl" id="currenturl" value="<?php echo $this->router->fetch_method();?>">
                            <input type="hidden" name="type" id="type" value="<?php echo $type?>" />
                            <input type="hidden" name="tabtype" id="tabtype" value="<?php echo $tabtype?>" />
                            <input type="hidden" name="ptype" id="ptype" value="<?php echo $ptype?>" />
                            <input type="hidden" name="assigncaseId" id="assigncaseId" value="">                           
                           <div class="row advnce">
                              <div class="col-md-3 pad-R5">
                                <label for="" class="crm-label">Search By</label>
                                    <div class="select-box" style="width:80px">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu">
                                       <li><a onclick="searchby('name')" id="searchcustname">Customer name</a></li>
                                       <li><a  onclick="searchby('mobile')" id="searchmobile">Mobile number</a></li>
                                       <li><a  onclick="searchby('regno')" id="searchreg">Reg no</a></li>
                                    </ul>
                                 <!-- /btn-group -->                                                  
                                 <div id="dropD">
                                     <input type="text" readonly="readonly"  name="keyword" id="keyword" class="form-control crm-form drop-form abc4" style="display:block">
                                 </div>
                                 <input type="hidden" name="searchby" id="searchby" value="">
                              </div> 

                              <div class="col-md-3">
                                 <div class="row">
                                    <div class="col-md-6 pad-L5 pad-R5">
                                    <label for="exampleInputPassword1" class="form-label">Policy Status</label>
                                    <div class="row row-text-box">
                                       <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                       <select class="form-control search-form-select-box" name="policy_status" id="policy_status">
                                             <option selected="selected" value="">Select</option>
                                             <option value="1">Not Expired</option>
                                             <option value="2">Already Expired</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <?php if($ptype=='assign'){?> 
                                 <div class="col-md-6 pad-R5 pad-L5">
                                    <label for="exampleInputPassword1" class="form-label">OD Range</label>
                                    <div class="row row-text-box">
                                       <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                          <select class="form-control" name="odAmt" id="odAmt">
                                             <option value="">Range</option>
                                             <option value="1">< 10K</option>
                                             <option value="2">10K-20K</option>
                                             <option value="3">>20K</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              <?php if($is_admin=='1' || $role_id == 2){?>  
                                 <div class="col-md-6 pad-R5 pad-L5">
                                    <label for="exampleInputPassword1" class="form-label">Assigned To</label>
                                    <div class="row row-text-box">
                                       <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                          <select class="form-control" name="assign_to" id="assign_to">
                                             <option value="">Please Select</option>
                                             <?php if(!empty($data['execList'])){?>
                                             <?php foreach ($data['execList'] as $key=>$value){ ?>
                                                <option value="<?=$value['id']?>"><?=ucfirst($value['name'])?></option>
                                             <?php } }?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <?php }} ?>
                                 <?php if($ptype=='listing'){?> 
                                 <div class="col-md-6 pad-R5 pad-L5">
                                    <label for="leadStatus" class="form-label">Lead Status</label>
                                    <div class="row row-text-box">
                                       <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                          <select class="form-control" name="lead_status" id="lead_status">
                                             <option value="">Please Select</option>
                                             <?php if(!empty($lead_status)){?>
                                             <?php foreach ($lead_status as $k=>$vstatus){ ?>
                                                <option value="<?=$vstatus->statusId?>"><?=$vstatus->status?></option>
                                             <?php } }?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 </div>
                              </div>
                              
                              <div class="col-md-4 pad-L5 pad-R5" id="caldate77">
                                 <style>
                                    .form-control{border: 1px solid #dddddd;}
                                    #buyer-lead .customize-form {border: 1px solid #dddddd;}
                                 </style>
                                 <div class="row">
                                 <div class="col-md-12"><label for="" class="crm-label">Date</label></div>
                                 <div class="col-md-4 pad-R0">
                                    <div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu">
                                       <li><a onclick="searchby('followupdate')" id="followupdate">Follow Up Date</a></li>
                                       <li><a  onclick="searchby('duedate')" id="duedate">Due Date</a></li>
                                    </ul>
                                 <!-- /btn-group -->                                                  
                                 <input type="hidden" name="searchdateby" id="searchdateby" value="">
                              </div> 
                                    <div class="col-md-4 pad-L0 pad-R0">
                                       <div class="date input-append demo" id="reservation_follow_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                           <input type="text" name="startfollowdate" id="startfollowdate" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd/mm/yyyy" disabled="disabled"> 
                                       </div>
                                    </div>
                                    <div class="col-md-4 pad-L0">
                                       <div class="date input-append demo" id="reservation_follow_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                           <input type="text" name="endfollowdate" id="endfollowdate" class="form-control customize-form add-on  icon-cal1 pad-L8" placeholder="To" data-date-format="dd/mm/yyyy" disabled="disabled"> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="col-md-2 pad-L5 pad-R5 mrg-T20">
                                 <span id="spnsearch" class="spnsearch">
                                     <button type="button" class="btn btn-primary" id="search">SEARCH</button>
                                 </span>
                                 <a href="javascript:void(0);" id="Reset" class="mrg-L10">RESET</a>
                              </div>
                           </div>
                           <input type="hidden" value="no_action_taken" name="tab_value" id="tab_value">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /End Search Filter -->
   
</div>
    
    
    
<div class="container-fluid mrg-all-15 pad-all-0" style="width: auto !important">
         <div class="row">
            <div class="col-md-12">
               <div class="background-ef-tab" id="workdetails">
                  <div class="pad-all-30 pad-B0">
                 <div class="row pad-B30 border-B">
                    <div class="col-md-6">
                       <h4 class="col-black-o fw-B mrg-all-0"><strong>Renew Cases (<span id="totcase">0</span>)</strong></h4>
                    </div>
                 </div>
                    </div>
                    <div class="tabs workingdetials">                        
                        <?php 
                        $active1 = $active2 = $active3 ="";
                        if($type == "allcount")
                              $active1 ="active";
                        else if($type == "allfollow")
                            $active2 ="active";
                        else if($type == "policyexpired")
                             $active3 ="active";
                        ?>
                    <?php if($ptype=='assign'){?>    
                     <ul class="nav nav-tabs nav-dashboard pad-R30 pad-L30 pad-T10 pad-B10" role="tablist" id="bucketss">
                        <li role="presentation" class="<?= $active1 ?>"><a aria-controls="new" role="tab" data-toggle="tab" id="all" class="typeq">All (<span  id="noactionnew">0</span>)</a></li>
                        <?php if($is_admin=='1' || $role_id == 2){?>
                        <li role="presentation" class=" "><a aria-controls="followups" role="tab" data-toggle="tab" id="assigned" class="typeq">Assigned (<span id="assignednew">0</span>)</a></li>
                        <li role="presentation" class=" "><a aria-controls="walkins" role="tab" data-toggle="tab" id="notassigned" class="typeq">Not Assigned (<span id="notassignednew">0</span>)</a> </li>
                        <li id="all_checked_header"  style="display: none;margin-top: 16px;margin-left: 50px;">
                            <div class="col-md-12" >
                            <h6 class="col-black-o fw-B mrg-all-0">
                                <p class="after_container" style="display: none;">All <span id="total_selected_records"></span> records are selected. <a onclick="clear_selection()" href="javascript:void(0);" id="clear_selection">Clear Selection</a></p>
                                <p class="before_container">All <span id="total_page_recods">0</span> records on this page are selected. 
                                    <a href="javascript:void(0)" id="select_all_records" onclick="select_all_records()">Select All</a> <span id="total_records">0</span> records</p>
                            </h6>
                            </div></li>
                         <li class="pull-right">
                             <a data-toggle="modal" class="font-14" style="color: #e26531; opacity: 1;" data-target="#update-details1" onclick="getCustomerPopupnew();">ASSIGN TASK</a>
                         </li>
                         <?php } ?>
                     </ul>
                    <?php }else{ ?>
                        
                          <ul class="nav nav-tabs nav-dashboard pad-R30 pad-L30 pad-T10 pad-B10" role="tablist" id="bucketss">

                          

                        <li role="presentation" class="<?= $active2 ?>"><a aria-controls="new" role="tab" data-toggle="tab" id="allfollow" class="typeq">Today Follow Ups (<span  id="allfollownew">0</span>)</a></li>
                        <li role="presentation" class=""><a aria-controls="followups" role="tab" data-toggle="tab" id="pastfollow" class="typeq">Past Follow Ups (<span id="pastfollownew">0</span>)</a></li>
                        <li role="presentation" class=" "><a aria-controls="walkins" role="tab" data-toggle="tab" id="upcomingfollow" class="typeq">Upcoming Follow Ups (<span id="upcomingfollownew">0</span>)</a> </li>

                        <li role="presentation"><a aria-controls="new" role="tab" data-toggle="tab" id="breakin" class="typeq">Break In (<span  id="breakinnew">0</span>)</a></li>
                        <li role="presentation"><a aria-controls="followups" role="tab" data-toggle="tab" id="lost" class="typeq">Lost (<span id="lostnew">0</span>)</a></li>
                        <li role="presentation" class="<?= $active3 ?>"><a aria-controls="new" role="tab" data-toggle="tab" id="policyexpired" class="typeq">Policy Already Expired (<span  id="policyexpirednew">0</span>)</a></li>

                        <li role="presentation" class="<?= $active1 ?>"><a aria-controls="new" role="tab" data-toggle="tab" id="allcount" class="typeq">All (<span  id="allnew">0</span>)</a></li>




<!--                         <li class="pull-right">
                             <a data-toggle="modal" class="font-14" style="color: #e26531; opacity: 1;" data-target="#update-details1" onclick="getCustomerPopupnew();">ASSIGN TASK</a>
                         </li>-->
                     </ul>
                    <?php  } ?>
                        
                     <div class="tab-content" id="buyerleads-new">
                        <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                           <div class="table-responsive" id="">
                              <table class="table table-bordered table-striped table-hover enquiry-table border-T mytbl">
                                 <thead>
                                    <tr>
                                        <?php if($ptype=='assign'){?>
                                        <?php if($is_admin=='1' || $role_id == 2){?>
                                        <th width="2%">
                                            <input name="allcheck" onclick="checkAll();" type="checkbox" id="allcheck" value="1">
                                            <label for="allcheck">
                                                <span></span>
                                             </label>
                                        </th>
                                        <?php }} ?>
                                       <th width="15%">Customer Details</th>
                                       <th width="15%">Car Details</th>
                                       <th width="15%">Previous Policy Details</th>
                                       <th width="15%">Status</th>
                                       <th width="15%">Follow-up Date</th>
                                       <th width="20%">Comment</th>
                                       <th width="5%">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody  id="buyer_list">
                                    <?php //echo "<pre>"; print_r($query); ?>
                                    <span id="imageloder" style="display:none; position:absolute;left: 40%;border-radius: 50%;z-index:999; ">
                                    <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>
                                 </tbody>
                                 
                              </table>
                           </div>
                           <div id="loadmoreajaxloader" style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                              <img src="ajax/loading.gif" title="Click for more">Click for more
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<div class="modal fade" id="displayalertfu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-backdrop fade in" style="height: 100%"></div>  
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
      </div>
      <div class="modal-body">
       <p>Are you sure you want to FollowUp this case after it expired?</p>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="saveupdate" id="savecase_id" value="">
        <button type="button" class="btn btn-secondary closee updateleadno" data-dismiss="modal">No</button>
        <button type="button" id="updateleadyes" class="btn btn-primary updateleadyes">Yes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="update-details1">
    <div class="modal-dialog clearfix" id="customerDetailCtralert" style="display:none;">
         <div class="modal-content" id="createUser" style="width: 480px">
                 <div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                     <h4 class="modal-title">Assign Task</h4>
                 </div>
                 <div class="modal-body text-center pad-all-15" >
                     <div class="tab-content" id="insmsg">
                       Please select at least 1 case.    
                     </div>    
                 </div>
         </div>
    </div>  
    <form name="customerDetailFrm" id="customerDetailFrm" method="post">
      <div class="modal-dialog clearfix" id="customerDetailCtr" style="display:none;">
         <div class="modal-content" id="createUser" style="width: 480px">
        <div class="modal-header modal-header-custom">
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/close-model.svg')?>" alt=""></button>
          <div class="row">
                <div class="col-md-8 clearfix">
                    <h4 class="modal-title clstask">Assign Tasks (<span id='cnttask'></span> Tasks)</h4>
                </div>
                
            </div>
          
        </div>
         <span class="errors" id="assign_error"></span>    
        <div class="modal-body scrollonpopup" id="buyer-lead">
            
            <input type="text" placeholder="search" name="srchassign" id="srchassign" class="form-control">
            <div class="list-group mrg-T10" id="divassign">
             <?php 
             if(!empty($data['execList'])){
                 $i=0;
                 foreach($data['execList'] as $ekey=>$eval){
              ?>   
              <div class="list-group-item">
                  <div class="col-md-12 pad-L0 pad-R0">
                      <input name="verified" class="mrg-T10" onclick="" type="radio" name="exe[]" id="exe_<?php echo $i;?>" value="1">
                        <label class="w100" for="car-6">
                            <p class="ws mrg-B0" style="display: inline-block"><?php echo $eval['name']?><br><i class="oi"><?php echo $eval['email']?></i></p> <span class="mrg-R0"></span>

                        </label>
                  </div>
                </div>
                 <?php $i++;}} ?>  
                </div>
            
        </div>
         <div class="modal-footer">
            <button class="btn btn-primary clsassign" style="width: 100%">UPDATE</button>
          </div>
 
      </div>
         <!-- /.modal-content -->
      </div>
   </form>
</div>
<input type="hidden" id="page_limit_renew_case" value="<?php echo PAGE_LIMIT_RENEW_CASE;?>"/>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<link href="<?=base_url('assets/admin_assets/css/bootstrap-multiselect.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/bootstrap-multiselect.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/ins_renew.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/processRenew.js')?>"></script>
<script>
$(document).ready(function(){
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
        $('.closee').click(function(){
           var lead_id = $('#savecase_id').val();
           $('#savecase_id').val(lead_id);
           $('#clickfolow_'+lead_id).val('0');
           $("#displayalertfu").attr('style','display:none');
           $("#displayalertfu").removeClass(' in');
        });   
</script> 
