<?php
   if (!empty($type)) {
       $type = $type;
   } else {
       $type = 'noaction';
   }
   ?>
<link href="<?=base_url('assets/admin_assets/css/buyer-lead.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.js')?>"></script>
<link href="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.css')?>" rel="stylesheet">
<div class="container-fluid pad-T20 bg-container-new" id="maincontainer">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="" id="buyer-lead">
            <div class="row">
               <div class="col-md-12 pad-all-0">
                  <div class="cont-spc">
                     <form role="form" name="searchform" id="searchform">
                        <div class=" search-panel">
                           <input type="hidden" name="page" id="page" value="1">
                           <input type="hidden" name="sorting" id="lead_sort" value="1" />
                           <input type="hidden" name="type" id="type" value="insurance" />
                           <input type="hidden" name="export" id="export" value="all" />
                           <input type="hidden" name="viewlead" id="viewlead" value="" />
                           <input type="hidden" name="gaadi_id" id="gaadi_id" value="" />
                           <input type="hidden" name="pendingleads" id="pendingleads" value="" />
                           <input type="hidden" name="searchtype" id="searchtype" value="wsearch"/>
                           <input type="hidden" name="recievedLeadFilter" id="recievedLeadFilter" value=""/>
                           <input type="hidden" name='filter_data_type' id='filter_data_type' value='' />
                           <!--<input type="hidden" name="filter_data_type" id="filter_data_type" value="todayworks">-->
                           <div class="row advnce">
                              <div class="col-md-2 width173 pad-R5">
                                 <label for="exampleInputPassword1" class="form-label">Search By</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">                        	
                                       <input type="text" class="form-control  pad-L10" placeholder="By Name, Mobile" name="keyword" id="keyword" value="" >
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-1 width103 pad-L5 pad-R5">
                                 <label for="exampleInputPassword1" class="form-label">Source</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                       <?php
                                          $source = [
                                              'dealer'=>'Dealer',
                                              'walkin'=>'Walk-In',
                                              'callcenter'=>'Call center'
                                          ];
                                          ?>
                                       <select  class="form-control search-form-select-box" name="lead_source" id="lead_source">
                                          <option selected="selected" value="">Select</option>
                                          <?php foreach ($source as $sk=>$s): ?>
                                          <option value="<?php echo $sk; ?>" ><?php echo ucwords(strtolower(str_replace(['-', '_'], ' ', $s))); ?></option>
                                          <?php endforeach; ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-1 width128 pad-R5 pad-L5">
                                 <label for="exampleInputPassword1" class="form-label">Status</label>
                                 <div class="row row-text-box">
                                    <div class="col-xs-12 mrg-all-0 sm-text-box pad-all-0">
                                       <select class="form-control" name="status" id="status">
                                          <option value="">Status</option>
                                          <?php foreach($lead_status as $k => $vstatus){  ?>
                                          <option value="<?= $vstatus->id ?>"><?= $vstatus->status_name ?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-1 width229 pad-L5 pad-R5">
                                 <label class="form-label">Lead Creation Date</label>
                                 <div class="row">
                                    <div class="col-md-6 pad-R2">
                                       <div class="date input-append demo" id="reservation_one" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="createStartDate" id="createStartDate" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                    <div class="col-md-6 pad-L2">
                                       <div class="date input-append demo" id="reservation_two" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                          <input type="text" name="createEndDate" id="createEndDate" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="To" data-date-format="dd/mm/yyyy"> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 pad-R5 mrg-T25">
                                 <span id="spnsearch" class="spnsearch"><button type="button" class="btn btn-primary mrg-Tmin5" id="search" >SEARCH</button></span>
                                 <a href="JavaScript:Void(0)" id="Reset" class="mrg-L10  used__car-reset-btn">RESET</a>
                              </div>
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
                           <h4 class="col-black-o fw-B mrg-all-0"><strong>Insurance Queries List</strong></h4>
                        </div>
                        <div class="col-md-6 pad-R0" id="class-btn">
                           <!--<a class="pull-right mrg-L15  border-L pad-L15" id="idexportexcel" href="JavaScript:Void(0)">DOWNLOAD EXCEL</a>  <a class="pull-right mrg-L15" href="JavaScript:Void(0)" onclick="$('#search').trigger('click');">REFRESH</a> -->
                        </div>
                     </div>
                  </div>
                  <?php
                     $noaction = '';
                      $interested = '';
                      $policypunched = '';
                      $closed = '';
                      if ($type == 'interested') {
                          $interested = "active";
                      } else if ($type == 'policypunched') {
                          $policypunched = "active";
                      } else if ($type == 'noaction'  || $type == '') {
                          $noaction = "active";
                      } else if ($type == 'closed') {
                          $closed = "active";
                      } else{
                         $noaction = "active"; 
                      }
                      
                      ?>
                  <div class="tabs border-T workingdetials" >
                     <ul class="nav nav-tabs nav-dashboard pad-R30 pad-L30 pad-T10 pad-B10" role="tablist" id="bucketss">
                        <li role="presentation" class="<?=$noaction; ?>"><a  aria-controls="new" role="tab" data-toggle="tab" id="noaction" class="typeq">Follow Ups (<span  id="noactionnew">0</span>)</a></li>
                        <li role="presentation" class="<?=$interested ?> "><a  aria-controls="followups" role="tab" data-toggle="tab" id="interested" class="typeq">Interested (<span  id="intrestednew">0</span>)</a></li>
                        <li role="presentation" class="<?=$policypunched ?> "><a  aria-controls="followupfuturedate" role="tab" data-toggle="tab" id="policypunched" class="typeq">Policy Punched (<span  id="policypunchednew">0</span>)</a></li>
                        <li role="presentation" class="<?=$closed ?> "><a  aria-controls="closed" role="tab" data-toggle="tab" id="closed" class="typeq">Closed (<span  id="closednew">0</span>)</a></li>
                        <li class="pull-right mrg-T5"><a class="btn btn-success font-14" href="<?=base_url('addInsurance')?>">ADD CASE</a></li>
                     </ul>
                     <div class="tab-content" id="buyerleads-new">
                        <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                 <thead>
                                    <tr>
                                       <th width="15%">Customer Details</th>
                                       <th width="20%">Car Details</th>
                                       <th width="15%">Policy Details</th>
                                       <th width="15%">Status</th>
                                       <th width="15%">Follow-up Date</th>
                                       <th width="15%">Comment</th>
                                       <th width="5%">Enquiry</th>
                                    </tr>
                                 </thead>
                                 <tbody  id="buyer_list">
                                    <?php //echo "<pre>"; print_r($query); ?>
                                    <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
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
<link href="<?=base_url('assets/admin_assets/css/bootstrap-multiselect.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/bootstrap-multiselect.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/insurance_lead.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/processInsurance.js')?>"></script>