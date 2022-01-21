<?php
   if ($type) {
       $type = $type;
   } else {
       $type = 'noaction';
   }
   $urlExplode=explode('/',current_url());
   $getendofurl = end($urlExplode);
   $valurl = '';
   $arr = explode('_', $getendofurl);
   if(strtolower($getendofurl)=='currleadadd')
   {
    $valurl = '1';
   }
   else if(strtolower($getendofurl)=='pending')
   {
    $valurl = '2';
   }
   else if(strtolower($arr[0])=='dashleads')
   {
    $valurl = '3';
    $keyword = $arr[1];
   }
   ?>
<style>
    #buyer-lead .cont-spc {
    padding: 0px 20px 20px 20px !important;
}
</style>
<link href="<?=base_url('assets/admin_assets/css/buyer-lead.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery-ui.js')?>"></script>
<link href="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.css')?>" rel="stylesheet">
<div class="container-fluid pad-T20 bg-container-new" id="maincontainer">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="pad-all-15" id="buyer-lead">
            <div class="row">
               <div class="col-md-12 pad-all-0">
                  <div class="cont-spc">
                     <form role="form" name="searchform" id="searchform">
                        <div class=" search-panel">
                           <input type="hidden" name="page" id="page" value="1">
                           <input type="hidden" name="sorting" id="lead_sort" value="1" />
                           <input type="hidden" name="type" id="type" value="<?=$type?>" />
                           <input type="hidden" name="export" id="export" value="all" />
                           <input type="hidden" name="viewlead" id="viewlead" value="<?=$viewlead?>" />
                           <input type="hidden" name="gaadi_id" id="gaadi_id" value="<?=$gaadi_id?>" />
                           <input type="hidden" name="pendingleads" id="pendingleads" value="<?=$pendingleads?>" />
                           <input type="hidden" name="lasturl" id="lasturl" value="<?=!empty($valurl)?$valurl:'0'?>">
                           <input type="hidden" name="searchtype" id="searchtype" value="wsearch"/>
                           <input type="hidden" name="recievedLeadFilter" id="recievedLeadFilter" value=""/>
                           <input type="hidden" name='filter_data_type' id='filter_data_type' value='<?php echo ($filter_data_type == 'todayworks') ? 'todayworks' : 'allleads'; ?>' />
                           <input type="hidden" name="filter" id="filter" value="<?php echo $filter;?>"/>
                           <input type="hidden" name="fstatus" id="fstatus" value="<?php echo $fstatus;?>"/>
                           <div class="row advnce">
                              <div class="col-md-2 width173 pad-R5">
                                 <label for="exampleInputPassword1" class="form-label">Search By</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">                        	
                                       <input type="text" class="form-control  pad-L10" placeholder="By Name, Mobile" name="keyword" id="keyword" value="<?php echo $keyword?>" >
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-1 width103 pad-L5 pad-R5">
                                 <label for="exampleInputPassword1" class="form-label">Source</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                       <?php
                                          $source = [
                                              'Gaadi',
                                              'Cardekho',
                                              'CARTRADE',
                                              'CARWALE',
                                              'OLX',
                                              'QUIKR',
                                              'website',
                                              'WALK-IN',
                                              'cardekho_knowlarity',
                                              'zigwheels',
                                              'DealerApp',
                                              'Facebook',
                                          ];
                                          ?>
                                       <select  class="form-control search-form-select-box testselect1" name="lead_source" id="lead_source">
                                          <option selected="selected" value="">Select</option>
                                          <?php foreach ($source as $s): ?>
                                          <option value="<?php echo $s; ?>" ><?php echo ucwords(strtolower(str_replace(['-', '_'], ' ', $s))); ?></option>
                                          <?php endforeach; ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-1 width128 pad-R5 pad-L5">
                                 <label for="exampleInputPassword1" class="form-label">Status</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                       <select class="form-control testselect1" name="status" id="status">
                                          <option value="">Status</option>
                                          <?php foreach($lead_status as $k => $vstatus){  ?>
                                          <option value="<?= $vstatus->id ?>"><?= $vstatus->status_name ?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 pad-L5 pad-R5">
                                 <label class="form-label">Lead Creation Date</label>
                                 <div class="row">
                                    <div class="col-md-6 pad-R2">
                                       <!-- <div class="date input-append demo" id="reservation" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="daterange" id="daterange" class="form-control customize-form add-on icon-cal1"  placeholder=""> 
                                          </div>-->
                                       <div class="date input-append demo" id="reservation_one" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="crateddate_from" id="crateddate_from" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                    <div class="col-md-6 pad-L2">
                                       <div class="date input-append demo" id="reservation_two" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="crateddate_to" id="crateddate_to" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="To" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 pad-L5 pad-R5">
                                 <label class="form-label">Updation Date</label>
                                 <!--<div class="date input-append demo" id="reservation" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                    <input type="text" name="updatedaterange" id="updatedaterange" class="form-control customize-form add-on icon-cal1"  placeholder=""> -->
                                 <div class="row">
                                    <div class="col-md-6 pad-R2">
                                       <div class="date input-append demo" id="reservation_three" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="updatedaterange_from" id="updatedaterange_from" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                    <div class="col-md-6 pad-L2">
                                       <div class="date input-append demo" id="reservation_four" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="updatedaterange_to" id="updatedaterange_to" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="To" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-2 pad-R5 pad-L10 mrg-T20">
                                 <span id="spnsearch" class="spnsearch"><button type="button" class="btn btn-primary mrg-Tmin5" id="search" >SEARCH</button></span>
                                 <a href="JavaScript:Void(0)" id="Reset" class="mrg-L10  used__car-reset-btn">RESET</a>
                                 <span class="used__car-advancesrch">Advance Search <i class="fa fa-angle-down down-i"></i></span>
                              </div>
                           </div>
                           <div class="row pad-L10 hidden">
                              <div class="col-md-1 width229 pad-L5 pad-R5 mrg-T20">
                                 <label class="form-label">Follow Up Date</label>
                                 <div class="row">
                                    <div class="col-md-6 pad-R2">
                                       <div class="date input-append demo" id="reservation_follow_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="updatedaterange_follow_from" id="updatedaterange_follow_from" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                    <div class="col-md-6 pad-L2">
                                       <div class="date input-append demo" id="reservation_follow_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="updatedaterange_follow_to" id="updatedaterange_follow_to" class="form-control customize-form add-on  icon-cal1 pad-L8" placeholder="To" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-1 width254 pad-R5 pad-L15 mrg-T20">                          
                                 <label class="form-label display-b  mrg-B15">Verified By</label>
                                 <input  name="verified" onclick="" type="checkbox" id="car-withoutPhotos" value="1"><label class="mrg-R10" for="car-withoutPhotos" ><span></span>
                                 Call Verified
                                 </label>
                                 <input  name="otp_verified" onclick="" type="checkbox" id="otp_verified" value="1"><label for="otp_verified"><span></span>
                                 OTP Verified
                                 </label>  
                              </div>
                              <div class="col-md-2 mrg-T20" onclick="$('#todayworks').attr('Checked','Checked');">
                                 <label id="lead_today_work" class="form-label display-b  mrg-B15">&nbsp;</label>
                                 <input  name="checkcar" type="checkbox" id="todayworks" value='todayworks' class="custom-checkbox typecheck" ><label for="todayworks" id="todayworks_label" class="text-bold"><span class="mrg-R10"></span>Today's Work</label> 
                              </div>
                              <!-- <div class="col-md-2 width178 pad-R0 pad-L0 mrg-T35">
                                 <label>&nbsp;</label>
                                 <input type="checkbox" id="upcoming-follow-ups" name="follow_from" value="<?php //echo date('d/m/Y', strtotime('+1 days')); ?>" class="custom-checkbox"><label for="upcoming-follow-ups"><span class="mrg-R10"></span>Upcoming Follow Ups</label> 
                                 </div> -->
                           </div>
                           <input type="hidden" value="no_action_taken" name="tab_value" id="tab_value" />
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /End Search Filter -->
   <div class="row">
      <div class="container-fluid mrg-all-15 pad-all-0">
         <div class="row">
            <div class="col-md-12">
               <div class="background-ef-tab" id="workdetails">
                  <div class="pad-all-30">
                     <div class="row" >
                        <div class="col-md-6">
                           <h4 class="col-black-o fw-B mrg-all-0"><strong>Buyer Leads</strong></h4>
                        </div>
                        <div class="col-md-6 pad-R0" id="class-btn">
                           <!--<a class="pull-right mrg-L15 border-L pad-L15 pad-R0" title="sort by" href="JavaScript:Void(0);" style="" id="sort_filter">
                              <select id="basic"  class="selectpicker show-tick form-control">
                                  <option value="1">SORT BY : DEFAULT</option>
                                  <option value="2">SORT BY : CREATED DATE</option>
                              </select></a>-->
                           <a class="pull-right mrg-L15  border-L pad-L15" id="idexportexcel" href="JavaScript:Void(0)">DOWNLOAD EXCEL</a>  <a class="pull-right mrg-L15" href="JavaScript:Void(0)" onclick="$('#search').trigger('click');">REFRESH</a> 
                        </div>
                     </div>
                  </div>
                  <?php
                     $todayfollow = '';
                      $pastfollow = '';
                      $futurefollow = '';
                      $noaction = '';
                      $all = '';
                      $closed = '';
                      $converted='';
                      $followfuturedate='';
                      
                      if ($type == 'todayfollow') {
                          $todayfollow = "active";
                      } else if ($type == 'pastfollow') {
                          $pastfollow = "active";
                      } else if ($type == 'noaction'  || $type == '') {
                          $noaction = "active";
                      } else if ($type == 'futurefollow') {
                          $futurefollow = "active";
                      } else if ($type == 'followfuturedate') {
                          $followfuturedate = "active";
                      } else if ($type == 'all') {
                          $all = "active";
                      } else if ($type == 'closed') {
                          $closed = "active";
                      } else if ($type == 'converted') {
                          $converted = "active";
                      }else{
                         $noaction = "active"; 
                      }
                     // echo $type."=".$noaction;
                      ?>
                  <div class="tabs border-T workingdetials" >
                     <ul class="nav nav-tabs nav-dashboard pad-R30 pad-L30 pad-T10 pad-B10" role="tablist" id="bucketss">
                        <li role="presentation" class="<?=$noaction; ?>"><a  aria-controls="new" role="tab" data-toggle="tab" id="noaction" class="typeq">New (<span  id="noactionnew">0</span>)</a></li>
                        <li role="presentation" class="<?=$todayfollow ?> "><a  aria-controls="followups" role="tab" data-toggle="tab" id="todayfollow" class="typeq">Follow Ups (<span  id="todayfollownew">0</span>)</a></li>
                        <li role="presentation" class="<?=$pastfollow ?> "><a  aria-controls="walkins" role="tab" data-toggle="tab" id="pastfollow" class="typeq">Walk-Ins (<span  id="pastfollownew">0</span>)</a> </li>
                        <li role="presentation" class="<?=$futurefollow ?> "><a  aria-controls="finalized" role="tab" data-toggle="tab" id="futurefollow" class="typeq">Booked & Cust Offer (<span id="futurefollownew">0</span>)</a> </li>
                        <li role="presentation" class="<?=$followfuturedate ?> "><a  aria-controls="followupfuturedate" role="tab" data-toggle="tab" id="followfuturedate" class="typeq">Future Follow Ups (<span  id="futuredatefollownew">0</span>)</a></li>
                        <li role="presentation" class="<?=$all ?> "><a aria-controls="all" role="tab" data-toggle="tab" id="all" class="typeq">All Leads (<span  id="allnew">0</span>)</a></li>
                        <?php if((empty($valurl)) || ($valurl!='2')){?>
                        <li role="presentation" class="<?=$converted ?> "><a aria-controls="converted" role="tab" data-toggle="tab" id="converted" class="typeq">Converted (<span  id="convertednew">0</span>)</a></li>
                        <li role="presentation" class="<?=$closed ?> "><a  aria-controls="closed" role="tab" data-toggle="tab" id="closed" class="typeq">Closed (<span  id="closednew">0</span>)</a></li>
                      <?php } ?>
                        <li class="pull-right"><a class="btn btn-success font-14" href="<?=base_url('addLead')?>">ADD LEAD</a></li>
                     </ul>
                     <div class="tab-content" id="buyerleads-new">
                        <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                 <thead>
                                    <tr>
                                       <th width="20%">Customer Details</th>
                                       <th width="20%">User Interested In</th>
                                       <th width="12%">Status</th>
                                       <th width="16%">Follow-up Date</th>
                                       <th width="22%">Comment</th>
                                       <th width="10%">Enquiry</th>
                                    </tr>
                                 </thead>
                                 <tbody  id="buyer_list">
                                    <?php //echo "<pre>"; print_r($query); ?>
                                    <span id="imageloder" style="display:none; position:absolute;left: 40%;border-radius: 50%;z-index:999; ">
                                    <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>
                                 </tbody>
                              </table>
                           </div>
                           <div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                              <img src="ajax/loading.gif" title="Click for more" />Click for more
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
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="update-details">
   <form name="customerDetailFrm" id="customerDetailFrm">
      <div class="modal-dialog clearfix" id="customerDetailCtr" style="display:none;">
         <div class="modal-content">
            <div class="modal-header bg-gray">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <h4 class="modal-title">Update Customer Details</h4>
            </div>
            <div class="modal-body pad-B0 pad-T25" id="editpopup">
               <div class="row">
                  <div class="col-md-12">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Name</label>
                              <input class="form-control search-form-select-box" name="name" id="name" type="text" placeholder="Enter Name">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Email</label>
                              <input class="form-control search-form-select-box" name="email" id="email_lead" type="text" placeholder="Enter Email" value="abc@gmail.com">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Mobile No.</label>
                              <input class="form-control search-form-select-box"  name="mobile" id="mobile" type="text" placeholder="Enter Phone No." disabled>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Alternate Mobile No.</label>
                              <input class="form-control search-form-select-box"  name="lead_alternate_mobile_number" id="lead_alternate_mobile_number" type="text" placeholder="Alternate Phone No." maxlength="10">
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label>Location</label>
                              <input type="hidden" id="cust_loc_city" value="<?php
                                 if (isset($locationRes['city_name'])) {
                                     echo $locationRes['city_name'];
                                 }
                                 ?>">
                              <select class="form-control search-form-select-box" name="locality_id" id="location">
                              <?php
                                 $optLoc = '<option value="">Select</option>';
                                 if (!empty($localityData['localities'])) {
                                     $locationData = $localityData['localities'];
                                     foreach ($locationData as $key => $val) {
                                         $optLoc .= "<option value='" . $val['locality_id'] . "'>" . $val['locality_name'] . "</option>";
                                     }
                                 }
                                 $optLoc .= '<option value="-1">Other</option>';
                                 echo $optLoc;
                                 ?>
                              </select> 
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer text-left pad-T0" id="editpopup1">
               <div class="alert alert-success" id="success-message" style="display:none;">
                  <strong>Success!</strong> Customer details saved successfully..
               </div>
               <!-- <button id="customerCancelModel" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
               <button type="button" class="btn btn-primary" id="saveCustomerBtn">UPDATE</button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
   </form>
</div>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<link href="<?=base_url('assets/admin_assets/css/bootstrap-multiselect.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/bootstrap-multiselect.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/buy_lead.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/processLead.js')?>"></script>