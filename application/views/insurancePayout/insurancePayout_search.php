<style>
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus { color: #ed8156 !important; border: 0px solid #ed8156; border-bottom: 2px solid #ed8156 !important; /*! border-bottom-color: transparent; */ cursor: default;}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="">
            <div class="cont-spc pad-all-20" id="buyer-lead">
                <form role="form" name="searchform" id="searchform">
                        <input type="hidden" id="tab_source" name="source" value="<?= $source ?>">
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
                                 <option value="">Payout Status</option>                                 
                                 <option value="1">Pending</option>
                                 <option value="2">Paid</option>
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
                        <div class="col-md-3 pad-L10 pad-R10">
                            <label class="crm-label">Date</label>
                            <div class="row">
                                <div class="col-md-4 pad-R0 mrg-R0">
                                    <div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu drop-menu-1">
                                        <li><a href="#" onclick="searchby('', this)" id="createdate">Created Date</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="issuedate">Issue Date</a></li>
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

                                 <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                                <input type="hidden" name="page" id="page" value="1">
                                <input type="hidden" name="insdashId" id="insdashId" value="<?php echo (!empty($insId)) ? $insId : ''; ?>">

                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
