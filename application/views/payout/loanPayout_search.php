<?php
  $urlExplode=explode('/',current_url());
  $url = !empty($urlExplode[5])? ($urlExplode[5]):'';
?>
<style>
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus { color: #ed8156 !important; border: 0px solid #ed8156; border-bottom: 2px solid #ed8156 !important; /*! border-bottom-color: transparent; */ cursor: default;}
</style>
<div class="container-fluid">
   <div class="row">
      <div class="">
         <div class="cont-spc pad-all-20" id="buyer-lead">
               <form id="searchform">
                   <input type="hidden" id="tab_source" name="source" value="<?= $type?>">
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label" >Search By</label>
                                    <div class="select-box cus-selec" style="width:80px">Select <span class="d-arrow"></span></div>
                                    <ul class="drop-menu">
                                       <li><a href="#" onclick="searchby(this)" id="searchcase">Loan Ref. Id</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchserialno">Loan S.No.</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchcustname">Customer name</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchmobile">Mobile number</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchdealer">Dealership Name</a></li>
                                        <li><a href="#" onclick="searchby(this)" id="searchbank">Bank Name</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchreg">Reg no</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchpayout">Payment Id</a></li>
                                    </ul>
                                 <!-- /btn-group -->
                                 <div id="dropD">
                                 <input type="text"  name="searchbyval" id="searchbyval" class="form-control crm-form drop-form abc4" style="width:57%; display:block;" readonly="readonly">
                                 <select name="searchbyvaldealer" id="searchbyvaldealer" class="form-control crm-form drop-form abc1" style="display: none; width:170px"><option value="">Select Dealership</option></select>
                                
                                 <select name="searchbyvalbank" id="searchbyvalbank" class="form-control crm-form drop-form abc3" style="display: none; width:170px"><option value="">Select Bank</option></select>
                                 </div>
                                 <input type="hidden" name="searchby" id="searchby" value="1">
                                 
                     </div>
                     <div class="col-md-1 pad-R0">
                        <label for="" class="crm-label">Status</label>
                              <select class="form-control crm-form testselect1" name="loan_status" id="loan_status">
                                 <option value="">Status</option>
                                 <?php foreach($fileTags as $ky => $vl){
                                  if($vl['id'] == 4 || $vl['id'] == 8){?>
                                 <option value="<?=$vl['id']?>"><?=$vl['file_tag']?></option>
                                 <?}}?>
                              </select>
                     </div>
                     <div class="col-md-1 pad-R0">
                        <label for="" class="crm-label">PayoutStatus</label>
                              <select class="form-control crm-form testselect1" name="payout_status" id="payout_status">
                                 <option value="">Payout Status</option>                                 
                                 <option value="1">Pending</option>
                                 <option value="2">Paid</option>
                              </select>
                     </div>
                     <div class="col-md-3 pad-R10">
                        <label class="crm-label">Lead Creation Date</label>
                        <div class="row">
                           <div class="col-md-3 pad-R0" style="width:33%">
                                 <div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu drop-menu-1">
                                       <li><a href="#" onclick="searchby('',this)" id="casedate">Case Added Date</a></li>
                                       <li><a href="#" onclick="searchby('',this)" id="fileddate">Filed Date</a></li>
                                       <li><a href="#" onclick="searchby('',this)" id="approvedate">Approved Date</a></li>
                                       <li><a href="#" onclick="searchby('',this)" id="disdocdate">Disbursed Date</a></li>
                                       <!--<li><a href="#" onclick="searchby('',this)" id="closeddate">Closed Date</a></li>-->
                                    </ul>
                           </div>
                           <div class="col-md-3 new_lead pad-all-0" style="width:33%">
                              <input type="hidden" name="searchdate" id="searchdate" value=""> 
                              <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                 <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From"> 
                              </div>
                           </div>
                           <div class="col-md-5 new_lead pad-all-0" style="width:33%">
                              <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                 <input type="text" name="daterange_from" id="daterange_from" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To"> 
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-1 pad-R0 width155">
                        <label for="" class="crm-label">Case Type</label>
                              <select class="form-control crm-form testselect1" name="status" id="status">
                                 <option value="">Select case type</option>
                                 <option value="1_Purchase">New Car Purchase</option>
                                 <option value="2_Purchase">Used Car Purchase</option>
                                 <option value="2_refinance">Used Car Refinance</option>
                                 <option value="2_topup">Used Car Internal top up</option>
                              </select>
                     </div>
                     <?php
                     if(($rolemgmt[0]['role_name']=='admin') || ($rolemgmt[0]['role_name']=='Loan Admin')){ ?>
                     <div class="col-md-1 pad-R0 width135">
                        <label for="" class="crm-label">Assigned To</label>

                              <select class="form-control crm-form testselect1" name="assignedto" id="assignedto">

                                 <option value="">Assigned to</option>
                                 <?php foreach($employeeList as $empkey => $empval){ ?>
                                 <option value="<?=$empval['id']?>"><?=$empval['name']?></option>
                                 <?php }?>
                              </select>
                              
                     </div>
                     <?php } ?>
                     <div class="col-md-2 pad-R0">
                        <span id="spnsearch">
                            <input type="button" class="btn-save btn-save-new" value="Search" id="search">
                            <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                            <input type="hidden" name="page" id="page" value="1">
                            <input type="hidden" name="dashboard" id="dashboard" value="<?=(!empty($type)?$type:'')?>">
                        </span>
                     </div>
                  </div>
               </form>
            </div>
      </div>
   </div>
</div>
