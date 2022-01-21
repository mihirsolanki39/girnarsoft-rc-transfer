<style>
  .nav-tabs>li a{font-size: 16px;}
  .nav-tabs>li a:hover{background: none;}
  .nav-tabs>li.active>a:hover{background: none;}
  .nav-tabs>li.active>a:focus{background: none;}
  .nav-tabs>li.active>a{background: none; font-size: 16px}
  .assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px;margin-top: 10px; display: inline-block;}

  .label-t{padding: 5px 10px;text-transform: uppercase;display: inline-block;float: right;}
  .availabe{background: #2196F3; color: #fff;border-radius: 3px;font-size: 11px;}
  .sold{background: #00B028;color: #fff;border-radius: 3px;font-size: 11px;}
  .refurb{ background: #6A6A6A;color: #fff;border-radius: 3px;font-size: 11px;}
  .booked{background: #F0B967;color: #fff;border-radius: 3px;font-size: 11px;}
  .removed{ background: #FF0000;color: #fff;border-radius: 3px;font-size: 11px;} 
   #refurbhistory .modal-dialog {width: 500px;}
  #refurbhistory .modal-body { padding: 0 0 30px 0; height: auto;}
  #refurbhistory .timeline_content {height: 355px;overflow-y: auto;overflow-x: hidden;}
  #refurbhistory .sidenav {background-color: #fff;overflow-x: hidden;padding-left: 0;}
  #refurbhistory .sidenav ul {list-style-type: none; padding-left: 55px; overflow: hidden;padding-right: 20px; height: 100vh}
   #refurbhistory .side_nav{padding-left: 25px; clear: both;}
   #refurbhistory .side_nav .side_text {padding-top: 10px;padding-bottom: 12.5px; border-bottom: 0px solid #f1f1f1;}
  #refurbhistory .sidenav a.sidenav-a { padding: 0px; text-decoration: none; border-bottom: 0px solid #f1f1f1; font-size: 14px; color: rgba(0, 0, 0, 0.87); line-height: 40px; font-weight: normal; display: block; margin-left: -15px;}
  #refurbhistory .active_text {font-size: 14px;color: rgba(0, 0, 0, .87);}
  #refurbhistory .Detail_text { font-size: 12.5px; color: rgba(0, 0, 0, .54); display: block;}
  #refurbhistory .sidenav-a small { display: block;margin-top: -20px;margin-left: 0;font-size: 12.5px; color: rgba(0, 0, 0, .54);}
  #refurbhistory .side_nav a.sidenav-a .img-type {height: 16px;width: 16px;margin-top: -5px;margin-left: -50px;margin-right: 35px;vertical-align: top;display: inline-block;position: relative;}
  #refurbhistory .side_nav .col-sm-4 { padding-right: 0px;}
  #refurbhistory .modal-title {font-size: 20px;font-weight: 500; color: rgba(0, 0, 0, 0.87);}
  #refurbhistory  .sidenav-a .img-type:after { content: ""; border-left: 1px dashed #ddd;left: 8px; position: absolute;top: 18px;height: 104px;}
  #refurbhistory .adownl{position: absolute; right: 0px}
  .bfd-dropfield-inner{padding-top: 0px !important}
  .bfd-dropfield-inner img{display: inline-block;}
</style>
<style>
    .errorMsg{
        color: #FF6600;
    }
    .successMsg{
        color: #009b00;
    }
</style>
<?php //echo dateStart;die();?>
<div id="content"> 
  <div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <div class="content">
      <div class="container-fluid">
    <div class="row">
        <div id="payment_stock_div" class="row">

            <div class="col-md-12 mrg-B20">
              <div class="white-section pad-all-20">
              <form role="form" name="searchform" id="searchform">
                        <input type="hidden" id="tab_source" name="source" value="1">
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
                       <div class="col-md-1 pad-R0">
                        <label for="" class="crm-label">PayoutStatus</label>
                              <select class="form-control crm-form testselect1" name="payout_status" id="payout_status">  
                                <option value="">Select</option>
                                 <option value="1">Pending</option>
                                 <option value="3">Paid</option>
                                 <option value="2">Mismatch</option>
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
                                <?php foreach (INSURANCE_POLICY_TYPE as $key => $policy_type) { ?>
                                <option value="<?= $key ?>"><?= $policy_type ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-1 pad-L10 pad-R0">
                            <label for="" class="crm-label">Assign To</label>
                            <select class="form-control crm-form testselect1" name="dealtby" id="dealtby">
                                <option selected="selected" value="">Select</option>
                                    <?php foreach ($employeeList as $key => $value) { ?>
                                    <option value="<?= $value['id'] ?>" <?php echo!empty($CustomerInfo) && $CustomerInfo['assign_to'] == $value['id'] ? 'selected=selected' : ''; ?>><?= $value['name'] ?></option>
                                    <?php } ?>
                            </select>
                        </div> 
                        <div class="col-md-4 pad-L10 pad-R10 ">
                            <label class="crm-label">Date</label>
                            <div class="row">
                                <div class="col-md-4 pad-R0 mrg-R0">
                                    <div class="select-box">Issue Date <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu drop-menu-1">
                                        <li class="active"><a href="#" onclick="searchby('', this)" id="createdate" >Created Date</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="issuedate">Issue Date</a></li>
                                     </ul>
                                </div>
                                <div class="col-md-4 new_lead pad-all-0">
                                    <input type="hidden" name="searchdate" id="searchdate" value="issuedate"> 
                                    <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                        <input type="text" name="createStartDate" id="createStartDate" class="form-control crm-form add-on icon-cal1 new_input" value="<?= $createStartDate ?>" placeholder="From"> 
                                    </div>
                                </div>
                                <div class="col-md-4 new_lead pad-all-0">
                                    <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                        <input type="text" name="createEndDate" id="createEndDate" class="form-control crm-form add-on icon-cal1 new_input" value="<?= $createEndDate ?>" placeholder="To" > 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 pad-R0">
                            <span id="spnsearch">
                                <input type="button" class="btn-save btn-save-new" value="Search" id="search">

                                 <a href="JavaScript:Void(0)" onclick="window.location.reload();" id="Reset" class="btn-reset">RESET</a>
                                <input type="hidden" name="page" id="page" value="1">
                                <input type="hidden" name="insdashId" id="insdashId" value="<?php echo (!empty($insId)) ? $insId : ''; ?>">

                            </span>
                        </div>
                    </div>
                </form>
              </div>
          </div>
            
            <div class="list_div col-md-12">
            <div class="background-ef-tab" id="loandetails">
              <div class="tabs loandetails">
                <div class="row pad-all-20">
                  <div class="col-md-6">
                    <h5 class="cases">Insurance Company Payout Cases<span id="total_count">(<?php echo $total_count; ?>)</span> </h5>
                  </div>
                  <div class="col-md-6">

                      <button id="uploadPayout" class="btn btn-default pull-right" data-toggle="modal" data-target="#"> Import Payout</button>
                      <button class="btn btn-default pull-right mrg-R10" data-toggle="modal" data-target="#downloadpayoutDiff">Download Payout Diff.</button>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover enquiry-table mytbl border-T mrg-B20 font-13">
                           <thead>
                              <tr>
                                 <th width="2%">S.N.</th>
                                 <th width="10%">Customer Details</th>
                                 <th width="12%">Car Details</th>
                                 <th width="10%">Policy Details</th>
                                 <th width="10%">Case Update</th>
                                 <th width="10%">Calculated Payout</th>
                                 <th width="10%">Actual Payout</th>
                                 <th width="8%">Difference</th>
                                <!--  <th width="5%">Comment</th> -->
                                 <th width="5%">Actions</th>
                              </tr>
                           </thead>
                           <tbody id="inspayothers">

                            <?php if(!empty($insurance_listing)){
                              $i=1;
                              foreach($insurance_listing as $values){
                              ?>
                              <tr>
                                <td>
                                  
                                  <div class="font-13 text-gray-customer">
                                   <span class=""><?php echo $values['sno'];?></span>
                                  </div>
                                </td>
                                <td>
                                    <div class="mrg-B5"><b><?php echo !empty($values['customer_name'])?$values['customer_name']:$values['customer_company_name'];?></b></div>
                                    <div class="font-13 text-gray-customer"><span class=""><?php echo !empty($values['mobile'])?$values['mobile']:"";?></span><br></div>
                                    <div><span class="text-gray-customer"><?php echo $values['customer_city_name']?$values['customer_city_name']:"";?></span></div>
                                    <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $values['created_date']!='0000-00-00' ? date("d M, Y",strtotime($values['created_date'])) : '00-00-0000'; ?></span></div>
                                  </td>
                                <td>
                                   <?php if (!empty($values['makeName']))
                          { ?>
                  <div class="mrg-B5">
                      <b><?php echo $values['makeName'] . ' ' . $values['modelName'] . ' ' . $values['versionName']; ?> 
                     </b>
                 </div>
                <?php } ?>
                                     <div class="font-13 text-gray-customer"><span class=""><?php echo $values['regNo'] ? strtoupper($values['regNo']) : 'Un-registered'; ?><span class="dot-sep"></span><?php echo $values['make_year'] ? $values['make_year'] : 'NA'; ?> Model</span></div>

                                       <?php if($values["ins_category"]!=''){ 
                                          $tagname = "";
                                          if($values['ins_category']=='1'){
                                                 $tagname='New Car';
                                               }else if($values['ins_category']=='2'){
                                                 $tagname='Used Car Purchase';
                                               }else if($values['ins_category']=='3'){
                                                 $tagname='Renewal';
                                               }else if($values['ins_category']=='4'){
                                                 $tagname='Policy Expired';
                                               }?>
                                    <div class="arrow-details">
                                    <span class="font-10"><?php echo $tagname;?></span>
                                    </div>
                                  <?php } ?>
                                </td>
                                <td>
                                  <div class="mrg-B5">
                                     <b>Policy No - </b>
                                      <b> <?php echo $values['current_policy_no'] ? $values['current_policy_no'] : 'NA'; echo"<br>";?>
                                        
                                      </b>
                                  <!--  <b>Policy Amt - </b>
                                   <b> <span class="indirupee rupee-icon"></span>1233</b> -->
                                </div>
                                <?php
                                  if (!empty($values['short_name']))
                                  {
                                      $company = $values['short_name'];
                                  }
                                  else
                                  {
                                      $company = !empty($values['prev_policy_insurer_name']) ? $values['prev_policy_insurer_name'] : "";
                                  }
                                  ?>
                                <div class="text-gray-customer"><?php echo $company ? $company : 'NA' ?></div>
                                <div class="text-gray-customer">
                                    IDV - <span class="indirupee rupee-icon"><?php echo !empty($values['idv'])?indian_currency_form($values['idv']):"NA"; ?></span> </span> 
                                </div>
                                <div class="text-gray-customer">
                                    OD Amount -<span class="indirupee rupee-icon"> <?php echo !empty($values['own_damage'])? indian_currency_form($values['own_damage']):"NA";?></span>
                                </div>

                                <div class="text-gray-customer">
                                    Add-On -<span class="indirupee rupee-icon"> <?php echo !empty($values['addOns'])?indian_currency_form($values['addOns']):"NA";?></span>
                                </div>


                                 <div class="text-gray-customer">
                                    Premium - <span class="indirupee rupee-icon"><?php echo !empty($values['totalpremium'])?indian_currency_form($values['totalpremium']):"NA";?></span>
                                </div>

                                
                                </td>
                                <td>
                                  <div class="mrg-T5"><b><?php echo $values['policy_status'] ? $values['policy_status'] : 'Issued';?></b></div>
                                    <div class="text-gray-customer">Added on :<?php echo date("d M, Y",strtotime($values['last_updated_date']));  ?></div>
                                      <!-- <?php
                                          if ($values["ins_category"] != '') {
                                              $tagname = "";
                                              if ($values['ins_category'] == '1') {
                                                  $tagname = 'New Car';
                                              } else if ($values['ins_category'] == '2') {
                                                  $tagname = 'Used Car Purchase';
                                              } else if ($values['ins_category'] == '3') {
                                                  $tagname = 'Renewal';
                                              } else if ($values['ins_category'] == '4') {
                                                  $tagname = 'Policy Expired';
                                              }
                                              ?>

                                       <div class="arrow-details alert-btn">

                                        <span class="font-10"><?php echo $tagname;?></span>
                                        </div>
                                      <?php } ?> -->
                                </td>
                                <td>

                                  <?php  if (isset($values['payout_percentage']) && !empty($values['payout_percentage'])){
                                   if ($values['source_id'] != 1) { 
                                    $payoutpercentage = $source_percentage[$values['source_id']]; ?>
                                  <div class="mrg-B5">
                                   <b>Percentage -</b>
                                   <b><input  disabled type="text" value="<?php echo !empty($payoutpercentage)?$payoutpercentage."%":""; ?>" class="form-control" style="width: 50px;
                                    display: inline-block;""></b><br>
                                   <?php }else{

                                    $payoutpercentage = $values['payout_percentage'];
                                    ?>
                                    <b>Percentage - </b>
                                  
                                   <b>
                                   <input  type="text"  disabled value="<?php echo !empty($payoutpercentage)?$payoutpercentage."%":""; ?>" class="form-control" style="width: 50px;
                                    display: inline-block;""></b><br>              </div> <?php

                                     } 
                                 
                                  $payoutTotal = !empty($values['actual_payout_amount'])?$values['actual_payout_amount']:"0";
                                    ?>
                                  <div class="text-gray-customer mrg-T5">Payout - <span class="indirupee rupee-icon"> </span><?php echo !empty($payoutTotal)?indian_currency_form($payoutTotal)."/-":""; ?></div>

                               <?php  }?>
                                
                                </td>

                                <td>
                                    <div class="mrg-B5">
                                     <b>Percentage - </b>
                                     <b><input disabled value="<?php echo !empty($values['payout_perc_from_company'])?$values['payout_perc_from_company']."%":"NA" ?>" type="text" class="form-control" style="width: 50px;
                                      display: inline-block;""></b><br>              
                                      </div>

                                      <?php 
                                      $payout_company = 0;
                                      if(!empty($values['payout_from_company'])) {
                                       $settlediffrence = !empty($values['settlediffrence'])?$values['settlediffrence']:0;
                                       $payout_company = $values['payout_from_company'] + $settlediffrence;
                                      }?>
                                    <div class="text-gray-customer mrg-T5">Payout -<span class="indirupee rupee-icon"> </span>
                                      <?php echo !empty($payout_company)?indian_currency_form($payout_company)."/-":"NA"?></div>
                                </td>


                                <td>
                                  <?php 
                                  if($values['payout_from_company']){

                                      $totalActualPayout    = !empty($payoutTotal)?$payoutTotal:0;
                                      $totalPaidfromCompany = !empty($payout_company)?$payout_company:0;
                                      $differencePayout = round(($totalActualPayout - $totalPaidfromCompany));
                                  }else{
                                    $differencePayout  = 0;
                                  }

                                      ?>
                                  <div class="red" >
                                    <input type="hidden" name="diffPayId" id="diffPayId_<?php echo $values['current_policy_no'];?>" value="<?php echo !empty($differencePayout)?$differencePayout:0;?>">
                                      <span class="indirupee rupee-icon" ></span> <?php echo !empty($differencePayout)?indian_currency_form($differencePayout)."/-":0;?>
                                  </div>
                                </td>

                                 <!-- <td>
                                   <div class="red">
                                    <?php $comment = !empty($values['settleComment'])?$values['settleComment']:"NA";?>
                                      <span class="" ><?php echo $comment;?></span>
                                  </div> 

                                  </td> -->

                                <td>
                                    <div class="red">
                                      <?php if($values['insStatus']=='2') { ?>
                                      <textarea class="form-control" id="comment_<?= $values['current_policy_no']?>" onblur="clearError('<?= $values['current_policy_no']; ?>')"></textarea>
                                      <div class="error_<?= $values['current_policy_no']?>"></div>
                                      <button class="btn btn-default" data-toggle="modal" data-target="#editPayout" onclick="editPayout('<?php echo !empty($values['current_policy_no'])?$values['current_policy_no']:0;?>')">Settle Difference </button>
                                    <?php } else if($values['insStatus']=='3'){ ?>
                                      <div class="red">
                                   
                                  </div>
                                   <div class="red">
                                     Status- <?php echo "Paid<br>";?>
                                   </div>

                                 <?php if(!empty($values['settleComment']) && !empty($values['comment_create_date'])){?>
                                  <div class="red">
                                     Comment- <span class="" ><?php echo $values['settleComment']."<br>";?></span>
                                   </div>

                                    <div class="red">
                                     Settled Date- <?php echo  !empty($values['comment_create_date'])?date("d M, Y",strtotime($values['comment_create_date'])):"NA";?>
                                  </div> 


                               <?php  } }else{ ?>
                                <div class="red">
                                    Status- <?php echo "Pending<br>";?>
                                </div>

                                  <?php if(!empty($values['settleComment']) && !empty($values['comment_create_date'])){?>
                                  <div class="red">
                                    Comment-
                                      <span class="" ><?php echo $values['settleComment']."<br>";?></span>
                                  </div>
                                 
                                  <div class="red">
                                     Settled Date- <?php echo  !empty($values['comment_create_date'])?date("d M, Y",strtotime($values['comment_create_date'])):"NA";?>
                                  </div>


                                      <?php } } ?>
                                    </div>
                                  </td>
                                 

                                </tr>
                       <?php
                            }
                          }?>
                        <tr><td colspan="10" style="text-align: center !important;">
                        <?php
                        if ((int) $total_count > 0) {

                        ?>
                         <div class="col-lg-12 col-md-6">
                         <nav aria-label="Page navigation">
                        <ul class="pagination" >                                             <?php
                            $total_pages = ceil($total_count / $limit);
                           // echo $limit."666"+$total_count;die;
                            $pagLink     = "";
                            
                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }
                            if ($total_pages != 1) {
                                if ((int) $page > 1) {
                                    $prePage = (int) $page - 1;
                        ?>                                                                     <li onclick="pagination('<?= $prePage;?>');">
                           <a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a>
                       </li>
                       <?php
            //this for loop will print pages which come before the current page
            for ($i = (int) $page - 6; $i < $page; $i++) {
             if ($i > 0) {
             ?>
            <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);'>
              <a href='#'><?php echo $i; ?>
              </a>
              </li>
              <?php
                }
             }
        }
        //this is the current page
        // if($i > $page){ ?>
          <li class="active"  onclick='pagination(<?php  echo $i; ?>);'>
            <a href='#'><?php echo $page; ?></a>
            </li>
            <?php  // }
        //this will print pages which will come after current page
        for ($i = $page + 1; $i <= $total_pages; $i++) {  ?> 
          <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);' >
            <a href='#'><?php echo $i; ?></a>
            </li> 
            <?php if ($i >= $page + 3) {
                break;
            }
        } 
        // this is for next button
        if ($page != $total_pages) {
          $nextPage = (int) $page + 1;  ?> 
          <li onclick="pagination('<?php echo $nextPage; ?>')">
            <a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a>
          </li> <?php } }   ?> 
        </ul> 
           </nav> 
         </div> <?php  }   ?>    
         </td>

       </tr>
       <?php if (empty($insurance_listing)) {
    echo "<tr><td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
}
?>
        <?php // }?> 
      </tbody>
      </table>
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

</div>
    
    
  <!-- Edit User Modal -->
  <div class="modal fade" id="downloadpayoutDiff" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content" id="createUser" style="width:480">
        <div class="modal-header modal-header-custom">
          <button type="button" class="close" data-dismiss="modal"><img src="images/close-model.svg" alt=""></button>
          <div class="row">
                <div class="col-md-9 clearfix">
                    <h4 class="modal-title">Download Payout Difference</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label>Select Bank</label>
                      <select class="form-control">
                        <option>Select</option>
                        <option>HDFC Bank</option>
                      </select>
                    </div>
                </div>
                <div class="col-md-6 form-group">
                  <label>Disbursal Date From</label>
                  <input type="date" class="form-control date">
                </div>
                <div class="col-md-6 form-group">
                    <label>Disbursal Date To</label>
                    <input type="date" class="form-control date">
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn-continue saveCont" style="width:100%; margin-top:5px;">DOWNLOAD PDF</button>
                </div>
            </div>
          </div>
        </div>
      </div>
      </div>

<div class="loaderClas" style="display:none;">
    <img class="resultloader" src="/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>


  <div class="modal fade bs-example-modal-sm" id="confirmSave" tabindex="-1" role="dialog" aria-labelledby="forgotPassword">
    <div class="modal-dialog" role="document">
        <div class="modal-content content-MN" style="height:200px;">

          <div class="modal-header modal-header-custom">
          <button type="button" class="close" data-dismiss="modal" onclick="closePopup()"><img src="./assets/images/close-model.svg" alt=""></button>
          <div class="row">
                <div class="col-md-7 clearfix">
                    <h4 class="modal-title">Confirmation</h4>
                </div>
            </div>
        </div>

            <div class="modal-body pad-B25 text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePopup()"><span aria-hidden="true">&times;</span></button>                
                <div id='error_msg'></div>
                <div class="pad-T30"><a href="" id="filepathid">Click Here</a> to view the updates</div>
            </div>  

            
        </div>
    </div>
</div>


<script type="text/javascript">
 // $.noConflict();
    $(document).ready(function () {
        $("#uploadPayout").click(function () {
            $.FileDialog({accept: ".xls,.csv,.xlsx,", multiple: false, title: 'Upload Payout from Companies File'}).on('files.bs.filedialog', function (ev) {
                var files = ev.files;
                var data = new FormData();
                
                for (var i = 0; i < files.length; i++) {
                    data.append(files[i].name, files[i]);
                }

                if (files.length > 0) {
                    $.ajax({
                        url: "<?php echo base_url();?>PayoutInsurance/import_dealers/",
                        type: "POST",
                        data: data,
                        contentType: false,
                        dataType: 'json',
                        processData: false,
                        success: function (result) {
                             //alert(result.status);          
                            if (result.status!= 1) {
                               if(result.status=='error'){
                               alert(result.message);
                               }else{
                                    /*$('#error_msg').addClass('errorMsg');
                                    $('#confirmSave').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    })

                                    $('#confirmSave').modal('show');
                                    $('#uploadFileModal').modal('hide');*/
                                  }
                                } else {
                                    $('#error_msg').addClass('successMsg');
                                    $('#error_msg').text(result.success_msg);   
                                    $("#filepathid").attr("href", result.download_path);
                                    $('#confirmSave').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                    })
                                    $('#confirmSave').modal('show');
                                    //$('#error_msg').val('successMsg');
                                     $('#error_msg').val(result.success_count);
                        
                                }
                          
                        $('#uploadFileModal').modal('hide');    
                        },
                        error: function (err) {
                            alert(err.statusText)
                        }
                    });
                }
                var text = "";
                files.forEach(function (f) {
                    text += f.name + "<br/>";
                });

                $("#output").html(text);
            }).on('cancel.bs.filedialog', function (ev) {
                $("#output").html("Cancelled!");
            });
        });

/* date picker call on page load */

//var cSDate = $('#createStartDate').val();
//alert(cSDate);
            var date = new Date();
            var d = new Date();
            d.setDate(date.getDate());
           

            $('.icon-cal1').datepicker('destroy');
                $("#createStartDate").datepicker({
                    format: 'dd/mm/yyyy',
                    startDate: "<?php echo $createStartDate ?>",
                    endDate: d,
                    autoclose: true,
                }).on('changeDate', function (selected) {
                    var startDate = new Date(selected.date.valueOf());
                    $('#createEndDate').datepicker('setStartDate', startDate);
                }).on('clearDate', function (selected) {
                    $('#createEndDate').datepicker('setStartDate', null);
                });
                $("#createEndDate").datepicker({
                    format: "dd/mm/yyyy",
                    endDate: d
                });
/* date picker call on page load */



    });

</script>


<script type="text/javascript">
 function searchby(eve = '', e = '')
    {
        if (eve != '')
        {
          $("#search_by_text").attr("readonly", false);
          //alert('ggggg');
            var id = $(eve).attr('id');

           // alert(id);

            $('#searchby').val(id);
            if (id == 'searchdealer')
            {
                $('.abc4').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
                dealerList();
            } else if (id == 'searchinsurance')
            {
                $('.abc4').attr('style', 'display:none;');
                $('.abc1').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
                insurerList();
            } else if (id == 'searchsl')
            {
                $('.abc3').attr('style', 'display:block;');
                $('.abc4').attr('style', 'display:none;');
                $('.abc1').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
            } else
            {
               //alert(id);
               if(id=='searchcustname'){
                $('.abc4').attr('style', 'display:block;');
                $('.abc4').removeAttr("maxlength");
                $('.abc4').val('');
                $('.abc4').attr('onkeypress','return nameOnly(event)');
                $('.abc1').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
               }else if(id=='searchmobile'){
                $('.abc4').attr('style', 'display:block;');
                $('.abc4').val('');
                $('.abc4').attr('maxlength','10');
                $('.abc4').attr('onkeypress','return isNumberKey(event)');
                $('.abc1').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
               }else if(id=='searchreg'){
                //alert('kkkkk');
                $('.abc4').attr('style', 'display:block;');
                $('.abc4').removeAttr("onkeypress");
                $('.abc4').removeAttr("maxlength");
                $('.abc4').val('');
                $('.abc1').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
               }else{
                $('.abc4').attr('style', 'display:block;');
                $('.abc4').val('');
                $('.abc1').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
               }
                
            }
        } else
        {
      //alert('JHHIU');
            //$("#createStartDate").prop('disabled', false);
            //$("#createEndDate").prop('disabled', false);
            var id = $(e).attr('id');
            var date = new Date();
            var d = new Date();
            d.setDate(date.getDate());
            $('#createStartDate').val('');
            $('#createEndDate').val('');
            $('.icon-cal1').datepicker('destroy');
                $("#createStartDate").datepicker({
                    format: 'dd/mm/yyyy',
                    startDate: "<?php echo $createStartDate ?>",
                    endDate: d,
                    autoclose: true,
                }).on('changeDate', function (selected) {
                    var startDate = new Date(selected.date.valueOf());
                    $('#createEndDate').datepicker('setStartDate', startDate);
                }).on('clearDate', function (selected) {
                    $('#createEndDate').datepicker('setStartDate', null);
                });
                $("#createEndDate").datepicker({
                    format: "dd/mm/yyyy",
                    endDate: d
                });
            $('#searchdate').val(id);
          }
    }

  function dealerList()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>" + "Finance/getDealerList/",
            dataType: 'html',
            success: function (response)
            {
                $('.abc4').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
                $('.abc1').attr('style', 'display:block;');
                $('.abc1').html(response);

            }
        });
    }

     function insurerList()
    {
        //alert('hiii');
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>" + "Insurance/getInsuList/",
            dataType: 'html',
            success: function (response)
            {
                $('.abc4').attr('style', 'display:none;');
                $('.abc1').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:block;');
                $('.abc2').html(response);

            }
        });
    }

</script>

<script>
function clearError(insId){
   $(".error_"+insId).html("");  
}
  function editPayout(insId){
   $(".error_"+insId).html("");      
    //alert(insId);
     var comment = $.trim($("#comment_"+insId).val());
     if(comment!=""){
     var differenceAmount = $('#diffPayId_'+insId).val();
                        
                        $.ajax({
                                  url: base_url+"PayoutInsurance/insuranceSaveComment",
                                  type: 'post',
                                  dataType: 'html',
                                  data: {'comment':comment,'differenceAmount':differenceAmount,'policyno':insId},
                                  success: function(response)
                                  {
                                     //alert(response);
                                   // console.log();
                                    location.reload();
                                  }
                                });

      
     }else{
     $(".error_"+insId).html("<p class='errorMsg'>Comment Field is required</p>");
      return false;
     }
     


  }

  // $("#search").click(function(){
  // // alert("The paragraph was clicked.");
  //   //data: $("#registerSubmit").serialize();
  //  $.ajax({
  //     type: "POST",
  //     url: base_url+"PayoutInsurance/insurancePayoutOthers",
  //     data: $("#searchform").serialize(),
  //     success: function() {
  //           if (responseData == 1) {
  //                $('#total_count').text('('+"0"+')');
  //           $('#imageloder').hide();
  //           $('#payoutcases').html("<tr><td align='center' colspan='6'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
  //           } else {
  //           $('#imageloder').hide();
  //           $('#inspayothers').html(responseData);
  //           }
  //           addCommasToListing();
  //     }
    
  //  })
   
  // }); 

  $('#search').click(function (event) {
        var formData=$('#searchform').serialize();
        $('#page').val('1');
        $('#imageloder').show();
        var start = $('#daterange_to').val();
        var end = $('#daterange_from').val();
        var formDataSearch=$('#searchform').serialize();
        var srchdate=$('#searchdate').val(); 
        if(srchdate!=''){
           // alert('dfdf');
         var createDate= $('#createStartDate').val();
         var endDate= $('#createEndDate').val();
          if(createDate==''){
              $('#imageloder').hide();
              alert("Please Select From Date");
              return true;
          }
          if(endDate==''){
              $('#imageloder').hide();
              alert("Please Select End Date");
              return true;
          }
          var d=createDate.split("/");
          var newcreateDate=d[2]+"/"+d[1]+"/"+d[0];
          var d1=endDate.split("/");
          var newendDate=d1[2]+"/"+d1[1]+"/"+d1[0];
//          console.log(newcreateDate +' > '+ newendDate);
//          if(newcreateDate > newendDate){
//              alert("Please Select Valid Date");
//              return true;
//          }
        }
        $.ajax({
            type: 'POST',
            url: base_url+"PayoutInsurance/insurancePayoutOthers/1",
            data: formDataSearch,
            dataType: 'html',
            success: function (responseData, status, XMLHttpRequest) {
            if (responseData == 1) {
                 $('#total_count').text('('+"0"+')');
            $('#imageloder').hide();
            $('#inspayothers').html("<tr><td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
            } else {
            $('#imageloder').hide();
            $('#inspayothers').html(responseData);
            }
            }
        });
    });

 
</script>

<script>
   $(document).ready(function () {
        var team = "<?= $this->session->userdata['userinfo']['team_name'] ?>";
        var role = "<?= $this->session->userdata['userinfo']['role_name'] ?>";
        if ((team == 'Loan') && (role == 'Accountant'))
        {
            $('#loan_status').val('4');
            $('#loan_status')[0].sumo.reload();
            $('#search').trigger('click');
        }

        $('body').on('click', function () {
            $('.drop-menu').hide();
        });
        $('.select-box').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).next().show();
        });
        $('.drop-menu li a').click(function () {
            var getText = $(this).text();
            $(this).parents('.drop-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
        });   

      var date = new Date();
      var d = new Date();        
      d.setDate(date.getDate());
          var dates =  $('#daterange_to').val();      
            $("#daterange_to").datepicker({
                format: 'dd-mm-yyyy',
                endDate: d,
                autoclose: true,
           }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf()); 
                $('#daterange_from').datepicker('setStartDate', startDate);
           }).on('clearDate', function (selected) { 
               $('#daterange_from').datepicker('setStartDate', null);
           });
           $("#daterange_from ").datepicker({
                format: 'dd-mm-yyyy',
                endDate: d
           });
       
    });

   function pagination(page) {
        $("#page").val(page);
        $("#inspayothers").html('');
        $('#imageloder').show();
        var formDataSearch = $('#searchform').serialize();
        var start = $('#page').val();
        start++;
        $.ajax({
            url: base_url + "PayoutInsurance/insurancePayoutOthers/1",
            type: 'post',
            dataType: 'html',
            data: formDataSearch,
            success: function (responseData, status, XMLHttpRequest) {
                var html = $.trim(responseData);
                $('#page').attr('value', start);
                if (parseInt(html) != 1) {
                    $('#inspayothers').html(html);
                    $(window).scrollTop(0);
                } else if (parseInt(html) == 1) {
                    start--;
                    $('#page').attr('value', start);
                    $('#inspayothers').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");

                    $('#loadmoreajaxloader').text('No More Results');
                }
                $('.' + page).addClass('active');
                $('#imageloder').hide();
                addCommasToListing();
            }
        });
    }


     document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        if(keyCode == 13)
        {
            document.getElementById("search").click();
        }
    }






</script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
$('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});

function nameOnly(event)
         {
           var inputValue = event.which;
           //alert(inputValue);
            if(!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) { 
                event.preventDefault(); 
                 return false;
            }
          }

           function isNumberKey(evt){
                                var charCode = (evt.which) ? evt.which : event.keyCode
                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                    return false;
                                return true;
                            }


      function closePopup(){
          location.reload(); 
        }
</script>


