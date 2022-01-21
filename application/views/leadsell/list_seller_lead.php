<link href="<?= base_url('assets/admin_assets/css/buyer-lead.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/admin_assets/js/jquery-ui/jquery.js') ?>"></script>
<script src="<?= base_url('assets/admin_assets/js/jquery-ui/jquery-ui.js') ?>"></script>
<link href="<?= base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.css') ?>" rel="stylesheet">
<link href="http://sarojsahoo.gaadi.com/origin-assets/boot_origin_asset_new/css/font-awesome.css" rel="stylesheet">
<div class="container-fluid pad-T20 bg-container-new" id="maincontainer">
    <style>
        #buyer-lead .cont-spc {
            padding: 0px 30px !important;
        }

        .error {
            font-size: 14px;
            color: red;
            position: relative;
            top: 0;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="pad-all-15" id="buyer-lead">
                <div class="row">
                    <div style="min-height:100px;">
                        <div class="col-md-12 pad-all-0" id="">
                            <div class="cont-spc">
                                <form role="form" id="sell_search_form">
                                    <input type="hidden" name="page" id="page" value="1">
                                    <div class="row ">
                                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                                            <label for="exampleInputPassword1" class="form-label">Search By</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                    <input type="text" name="name_email_mobile" value="<?php //echo $_REQUEST['keyword'];   
                                                                                                        ?>" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                $('#search_button').click();
                                                            }" class="form-control pad-L10" placeholder="Name, Email, Mobile">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1  col-sm-6 pad-LR tabpading">
                                            <label for="exampleInputPassword1" class="form-label">Source</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                    <select class="form-control" name="source">
                                                        <option value="">Source</option>
                                                        <option>Gaadi</option>
                                                        <option>Cardekho</option>
                                                        <option>My Website</option>
                                                        <option>Walk-In</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                                            <label for="exampleInputPassword1" class="form-label">Select a Car</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <select class="form-control testselect1" name="make" id="make">
                                                        <option value="">Brand</option>
                                                        <?php if (!empty($make)) { ?>
                                                            <?php foreach ($make as $makeData) { ?>
                                                                <option value="<?php echo $makeData['make']; ?>"><?php echo $makeData['make']; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <select class="form-control" name="model" id="model" disabled="disabled">
                                                        <option selected="selected" value="">Model</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!--<div class="col-md-2  col-sm-6 pad-LR tabpading">
                                            <label for="exampleInputPassword1" class="form-label">Price Range</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                                    <select class="form-control" name="price_min" style="width:100px;">
                                                        <option value="">Price Min</option>
                                                        <?php
                                                        $minPriceArr = array('0' => '0', '50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh');
                                                        foreach ($minPriceArr as $minkey => $val) {
                                                        ?>
                                                            <option value="<?php echo $minkey; ?>"><?php echo $val; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <select class="form-control" name="price_max" style="width:100px;">
                                                        <option value="">Price Max</option>
                                                        <?php
                                                        $maxPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '6000000' => '60 Lakh', '7000000' => '70 Lakh', '8000000' => '80 Lakh', '9000000' => '90 Lakh', '10000000' => '1 Crore');
                                                        foreach ($maxPriceArr as $minkey => $val) {
                                                        ?>
                                                            <option value="<?php echo $minkey; ?>"><?php echo $val; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->


                                        <div class="col-md-2  col-sm-6 pad-LR tabpading">
                                            <label for="exampleInputPassword1" class="form-label">Status</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-12 mrg-all-0 sm-text-box ">
                                                    <select class="form-control" name="status">
                                                        <option value="">Status</option>
                                                        <option value="Hot">Hot</option>
                                                        <option value="Cold">Cold</option>
                                                        <option value="Warm">Warm</option>
                                                        <option value="Evaluation Scheduled">Evaluation Scheduled</option>
                                                        <option value="Walked-In">Evaluation Done</option>
                                                        <option value="Converted">Converted</option>
                                                        <option value="Closed">Closed</option>

                                                        Evaluation Done
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-1 col-sm-6 pad-LR tabpading display-n advance-search">
                                            <label for="exampleInputPassword1" class="form-label">Reg. Number</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	
                                                    <input type="text" class="form-control pad-L10" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                $('#search_button').click();
                                                            }" name="regno" placeholder="Enter Reg. No.">
                                                </div>

                                            </div>
                                        </div>-->
                                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                                            <label for="exampleInputPassword1" class="form-label">Enquiry Date</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <div>
                                                        <div class="input-append date input-group" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                            <input readonly="readonly" style="cursor:pointer;" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                        $('#search_button').click(); }" class="span2 form-control add-on enquiry_calender" size="16" type="text" value="" name="enquiry_date_from" placeholder="From" style="cursor:not-allowed;">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <div>
                                                        <div class="input-append date input-group" id="dp4" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                            <input readonly="readonly" style="cursor:pointer;" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                        $('#search_button').click();
                                                                    }" class="span2 form-control add-on enquiry_calender" size="16" type="text" value="" name="enquiry_date_to" placeholder="To" style="cursor:not-allowed;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search">
                                            <label for="exampleInputPassword1" class="form-label">Follow up date</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <div>
                                                        <div class="input-append date input-group" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                            <input readonly="readonly" style="cursor:pointer;" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                        $('#search_button').click();
                                                                    }" class="span2 form-control add-on follow_calender " name="follow_date_from" size="16" type="text" value="" placeholder="From">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <div>
                                                        <div class="input-append date input-group" id="dp4" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                            <input readonly="readonly" style="cursor:pointer;" onkeydown="Javascript: if (event.keyCode == 13) {
                                                                        $('#search_button').click();
                                                                    }" class="span2 form-control add-on follow_calender" size="16" name="follow_date_to" type="text" value="" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!--<div class="col-md-2 col-sm-6 pad-LR tabpading display-n advance-search mrg-T10">
                                            <label for="exampleInputPassword1" class="form-label">KM. Range</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        
                                                    <select class="form-control" name="km_from">
                                                        <option value="">From</option>
                                                        <?php
                                                        for ($i = 0; $i <= 100000; $i += 10000) {
                                                        ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option> 
                                                            <?php
                                                        }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <select class="form-control" name="km_to">
                                                        <option value="">To</option>
                                                        <?php
                                                        for ($i = 10000; $i <= 100000; $i += 10000) {
                                                        ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                            ?>  
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-md-2 col-sm-6 pad-LR tabpading display-n advance-search mrg-T10">
                                            <label for="exampleInputPassword1" class="form-label">Year Range</label>
                                            <div class="row row-text-box">
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        
                                                    <select class="form-control" name="year_from">
                                                        <option value="">From</option>
                                                        <?php for ($i = date("Y"); $i >= 1970; $i--) { ?>
                                                            <option value="<?= $i ?>"><?php echo $i; ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                                    <select class="form-control" name="year_to">
                                                        <option value="">To</option>
                                                        <?php for ($i = date("Y"); $i >= 1970; $i--) { ?>
                                                            <option value="<?= $i ?>"><?php echo $i; ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-md-2  col-sm-6 pad-LR tabpading display-n advance-search mrg-all-10">
                                            <div class="row row-text-box">
                                                <div class="col-xs-12 mrg-all-0 sm-text-box mrg-T10">                        	
                                                    <input  name="verified" onclick="" type="checkbox" id="car-withoutPhotos"><label name="label_verified" for="car-withoutPhotos"><span></span>
                                                        Verified</label><br>
                                                    <input name="non_verified"  onclick="" type="checkbox" id="car-withPhotos"><label name="label_non_verified" for="car-withPhotos"><span></span>
                                                        Non-verified</label>
                                                </div>
                                            </div>
                                        </div>-->

                                        <div class="col-md-3 pad-LR pull-right">
                                            <div class="row row-text-box">
                                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                    <label for="exampleInputPassword1" class="form-label"></label>
                                                    <button type="button" class="btn btn-primary mrg-T20" style="margin-top:25px !important" id="search_button" onclick="javascript:page = 1;
                                                            getResults();">Search</button>
                                                    <a type="reset" class="mrg-T20 sell_form_reset mrg-L15" onclick="var t = setTimeout(function () {
                                                                page = 1;
                                                                getResults();
                                                            }, 500);
                                                            $('select[name=price_min] option,select[name=price_max] option,select[name=km_from] option,select[name=km_to] option,select[name=year_from] option,select[name=year_to] option').show();
                                                            $('#model').attr('disabled', 'disabled');
                                                            $('input[name=enquiry_date_from]').attr('value', '');
                                                            $('input[name=enquiry_date_to]').attr('value', '');" style="    vertical-align: middle; display: inline-block; text-transform:uppercase">Reset</a><br>
                                                    <a class="btn-block advanced-search-btn pad-L10 mrg-T5 font-12" href="javascript:void(0);">
                                                        <i class="fa fa-plus-square-o down font-14 mrg-R5" data-unicode="f01a"></i><i class="fa fa-minus-square-o up font-14 mrg-R5" data-unicode="f01b" style="display:none;"></i>Advanced Search</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--no_action_taken-->
                                    <input type="hidden" value="no_action_taken" name="tab_value" id="tab_value" />
                                    <input type="hidden" value="0" name="export" id="export" />
                                </form>

                            </div>
                        </div>
                    </div><!-- /End Search Filter -->
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="container-fluid mrg-all-15 pad-all-0 white-section">
            <div class="row">
                <div class="col-md-12">
                    <div class="background-ef-tab" id="workdetails">
                        <div class="pad-all-30">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="col-black-o fw-B mrg-all-0"><strong>Seller Leads</strong></h4>
                                </div>
                                <div class="col-md-6 pad-R0" id="class-btn">
                                    <a class="pull-right mrg-L15  border-L pad-L15 export_to_excel" id="idexportexcel" href="JavaScript:Void(0)" onclick="$('#sell_search_form #export').val('1');window.location=base_url+'LeadSell/ajaxSellLead?exportdata=export&'+$('#sell_search_form').serialize();">DOWNLOAD EXCEL</a>
                                    <a class="pull-right mrg-L15" href="JavaScript:Void(0)" onclick="javascript:page=1;getResults();">REFRESH</a>
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
                        $converted = '';
                        $followfuturedate = '';

                        if ($type == 'todayfollow') {
                            $todayfollow = "active";
                        } else if ($type == 'pastfollow') {
                            $pastfollow = "active";
                        } else if ($type == 'noaction' || $type == '') {
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
                        } else {
                            $noaction = "active";
                        }
                        // echo $type."=".$noaction;
                        ?>
                        <div class="tabs border-T workingdetials">
                            <ul class="nav nav-tabs nav-dashboard pad-R30 pad-L30 pad-T10 pad-B10" role="tablist" id="bucketss">
                                <li role="presentation" class="<?= $noaction; ?>"><a aria-controls="new" role="tab" data-toggle="tab" id="noaction" class="noaction" onclick="javascript:$('#sell_search_form #tab_value').val('no_action_taken');
                                        page = 1;
                                        getResults();">No Action Taken (<span id="noactionnew">0</span>)</a></li>
                                <li role="presentation" class="<?= $todayfollow ?> "><a aria-controls="followups" role="tab" data-toggle="tab" id="todayfollow" class="todayfollowup" onclick="javascript:$('#sell_search_form #tab_value').val('today_follow_up');page = 1;getResults();">Today's Follow-Up (<span id="todayfollownew">0</span>)</a></li>
                                <li role="presentation" class="<?= $pastfollow ?> "><a aria-controls="walkins" role="tab" data-toggle="tab" id="pastfollow" class="pastfollowup" onclick="javascript:$('#sell_search_form #tab_value').val('past_follow_up');
                                        page = 1;
                                        getResults();">Past Follow-Up (<span id="pastfollownew">0</span>)</a> </li>
                                <li role="presentation" class="<?= $futurefollow ?> "><a aria-controls="finalized" role="tab" data-toggle="tab" id="futurefollow" class="" onclick="javascript:$('#sell_search_form #tab_value').val('all');page = 1;getResults();">All (<span id="allnew">0</span>)</a> </li>
                                <li role="presentation" class="<?= $followfuturedate ?> "><a aria-controls="followupfuturedate" role="tab" data-toggle="tab" id="" class="" onclick="javascript:$('#sell_search_form #tab_value').val('closed');
                                        page = 1;
                                        getResults();">Closed (<span id="closednew">0</span>)</a></li>
                                <li role="presentation" class="<?= $all ?> "><a aria-controls="all" role="tab" data-toggle="tab" id="" class="" onclick="javascript:$('#sell_search_form #tab_value').val('converted');page = 1;getResults();">Converted (<span id="convertednew">0</span>)</a></li>

                                <li class="pull-right"><a class="btn btn-success font-14" onclick="$('.othercolors').hide();$('.add_seller_fuel_type').html('');" data-toggle="modal" data-target="#model-add-seller">ADD LEAD</a></li>
                            </ul>
                            <div class="tab-content" id="buyerleads-new">
                                <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Customer Details</th>
                                                    <th width="33%">Car Details</th>
                                                    <th width="12%">Status</th>
                                                    <th width="10%">Follow-up Date</th>
                                                    <th width="20%">Comment</th>
                                                    <th width="5%">Enquiry</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sell_customer_ajax_result">
                                                <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                                    <img src="<?= base_url('assets/admin_assets/images/loader.gif') ?>"></span>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="loadmoreajaxloader" style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
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



<!-- More Cars modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="more-cars">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Car Details</h4>
            </div>
            <div class="comment-wrap  mCustomScrollbar scrolldivmorecars" data-mcs-theme="dark">
                <div class="modal-body" id="more_cars">


                </div>
            </div>
            <div class="modal-footer" style="border-top:none;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-comment -->
    </div>
</div>


<!-- Add Comment modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-comment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Comment</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="form-group text-left">
                        <label class="control-label search-form-label" for="inputSuccess2">Comment Here:</label>
                        <textarea onkeyup="if($.trim(this.value)!=''){$('.comment-submt').attr('disabled',false);}else{$('.comment-submt').attr('disabled',true);}" class="form-control search-form-select-box textarea_comment_popup" maxlength="200" placeholder="Write Comment"></textarea>
                    </div>
                </div>
                <hr>
                <div class="comment-wrap  mCustomScrollbar scrolldiv" data-mcs-theme="dark">
                    <div id="comment_popup">
                        <!--<img src="<?= ASSET_PATH ?>boot_origin_asset_new/images/loader.gif" />-->
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="border-top:none;">
                <button type="button" class="btn btn-default cmnt-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary comment-submt" onclick="$('.comment_'+comment_id+' textarea').val($('.textarea_comment_popup').val());save_popup=1;add_comment(comment_id,'.comment_save_'+comment_id+' .comment_save');getComments(comment_id);$('.textarea_comment_popup').val('');" disabled="true">Submit</button>
            </div>
        </div><!-- /.modal-comment -->
    </div>
</div>



<!--Make Model Variant images modal-->
<div id="imageShow" class="modal fade bs-example-modal-lg in" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">VIEW IMAGES</h4>
            </div>
            <div class="modal-body">
                <div id="show_mmv_images">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>


</div>
<!-- Popups Start -->
<!-- Add Seller Lead modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-add-seller">
    <form id="add_seller_lead_form">
        <div class="modal-dialog modal-lg modal-ku">
            <div class="modal-content">
                <div class="modal-header bg-gray">
                    <button type="button" class="close" onclick="$('#add_seller_reset').click();$('#add_seller_lead_msg').html('');" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add Seller Lead</h4>
                </div>

                <div class="modal-body">
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Customer Name *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="text" placeholder="Enter Customer Name" name="add_seller_name" class="form-control search-form-select-box">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Mobile Number *</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="text" placeholder="Enter Mobile Number" onkeypress="return numbersonly(event)" maxlength="10" name="add_seller_mobile" class="form-control search-form-select-box">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Email </label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <input type="text" placeholder="Enter Email" name="add_seller_email" class="form-control search-form-select-box">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Source</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <select id="status" class="form-control search-form-select-box" name="add_seller_source">
                                        <option>Walk-In</option>
                                        <option>Gaadi</option>
                                        <option>Cardekho</option>
                                        <option>My Website</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix mrg-T15"></div>
                    <div class="row mrg-all-0 mrg-B0 mrg-T0">
                        <div class="col-md-3  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Status</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <select class="form-control" name="add_seller_status">
                                        <option value="">Status</option>
                                        <option value="Hot">Hot</option>
                                        <option value="Cold">Cold</option>
                                        <option value="Warm">Warm</option>
                                        <option value="Evaluation_Scheduled">Evaluation Scheduled</option>
                                        <option value="Walked-In">Evaluation Done</option>
                                        <option value="Converted">Converted</option>
                                        <option value="Closed">Closed</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Follow-up Date</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <div>
                                        <div class="input-append date input-group" id="dp5" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                            <input style="cursor:pointer;" readonly="readonly" class="span2 form-control calender" size="16" type="text" value="" placeholder="" name="add_seller_follow_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="control-label search-form-label">Comment</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <textarea class="form-control add-c-textBox" name="add_seller_comment" placeholder="Comment"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="comment-wrap  mCustomScrollbar scrolldivaddsell" data-mcs-theme="dark">
                        <div id="add_seller_car_details">
                            <div class="clearfix mrg-T15"></div>
                            <div class="firstt">
                                <div class="row mrg-all-0 mrg-B0 mrg-T0 appended-div2" style="border-top:0px solid #fff;padding:20px;background-color: #eee; border-radius: 4px;">
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Make Year *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select class="form-control search-form-select-box add_seller_myear" name="add_seller_myear[]">
                                                    <option value="">Make Year</option>
                                                    <?php for ($i = date("Y"); $i >= 1970; $i--) { ?>
                                                        <option value="<?= $i ?>"><?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Month *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select class="form-control search-form-select-box add_seller_month" name="add_seller_mmonth[]">
                                                    <option value="">Month</option>
                                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                        <option name="<?= $i ?>"><?php echo date('M', strtotime('2009-' . $i . '-02')); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Make *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select class="form-control search-form-select-box add_seller_make" onchange="get_model_list(this)" name="add_seller_make[]">
                                                    <option value="">Make</option>

                                                </select>
                                            </div>
                                        </div>
                                        <input class="mkid" type="hidden" name="make_ids[]" value="">
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Model *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select class="form-control search-form-select-box add_seller_model" onchange="get_variant_list(this)" name="add_seller_model[]">
                                                    <option value="">Model</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input class="moid" type="hidden" name="model_ids[]" value="">
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Version *</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select class="form-control search-form-select-box add_seller_variant" onchange="get_fuel_list(this)" name="add_seller_variant[]">
                                                    <option value="">Version</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input class="vrid" type="hidden" name="version_ids[]" value="">
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Price</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="text" maxlength="9" placeholder="Price" onkeypress="return numbersonly(event)" name="add_seller_price[]" class="form-control search-form-select-box">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Reg No*</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="text" placeholder="Reg No" name="add_seller_regno[]" onkeyup="$(this).val(this.value.toUpperCase());" class="form-control search-form-select-box">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Kms</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="text" maxlength="7" onkeypress="return numbersonly(event)" placeholder="Kms" name="add_seller_km[]" class="form-control search-form-select-box">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label ">Fuel Type</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select name="add_seller_fuel_type[]" class="form-control add_seller_fuel_type">
                                                    <option value="">Select</option>
                                                    <option class="fuel" value="Petrol">Petrol</option>
                                                    <option class="fuel" value="Diesel">Diesel</option>
                                                    <option class="fuel" value="CNG">CNG</option>
                                                    <option class="fuel" value="LPG">LPG</option>
                                                    <option class="fuel" value="Hybrid">Hybrid</option>
                                                    <option class="fuel" value="Electric">Electric</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Colour</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <select name="add_seller_colour[]" class="form-control othercoloroption" onchange="get_other_color(this)">
                                                    <option value="">Select</option>
                                                    <?php
                                                    foreach ($color as $c => $cols) {
                                                        echo '<option>' . $cols[name] . '</option>';
                                                    }
                                                    ?>
                                                    <option class="col" value="Other">Other</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3  col-sm-6 pad-LR tabpading othercolors mrg-T10">
                                        <label for="exampleInputPassword1" class="control-label search-form-label">Please Enter Other Color</label>
                                        <div class="row row-text-box">
                                            <div class="col-xs-12 mrg-all-0 sm-text-box">
                                                <input type="text" autocomplete="off" name="other_color[]" class="form-control search-form-select-box">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <?php
                $pageArrkk = explode('/', $_SERVER['PHP_SELF']);
                $uriPageNamekk = $pageArrkk[count($pageArrkk) - 1];
                //if($uriPageNamekk!='kwl_datas.php'){   
                ?>
                <div class="row mrg-all-0 mrg-B0 mrg-T0">
                    <div class="col-md-12">
                        <div class="form-group text-right" style="margin-bottom:-5px;">
                            <input type="reset" id="add_seller_reset" style="display:none;" />
                            <label for="inputSuccess2" class="control-label search-form-label"></label>
                            <a style="display:none;" href="javascript:void(0);" onclick="if ($('.appended-div2').size() == 2) {
                                  $(this).hide();
                              }
                              " class="btn btn-default search-btn mrg-B10 mrg-R10 remove-append2" role="button"><i class="fa minus-circle" data-unicode="f056"></i> Remove</a>
                            <a href="javascript:void(0);" onclick="add_more();$(this).prev().show();" class="btn btn-default btn-sm search-btn mrg-B10 mrg-R10" role="button"><i data-unicode="f055" class="fa plus-circle font-16"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <?php //}  
                ?>
                <div class="modal-footer">
                    <span id="add_seller_lead_msg"></span>
                    <button type="button" class="btn btn-default add_lead_cancel" onclick="$('#add_seller_reset').click();
            $('#add_seller_lead_msg').html('');" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="add_seller_lead()">Submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div>

    </form>
</div>
<!-- end Popups Start -->
<!-- end Add Seller Lead modal -->

<script type="text/javascript">
    var dd = "<?php echo date('d-m-Y H:00', strtotime(date('Y-m-d H:00')) + (3600));  ?>";
    var ddd = "<?php echo date('d-m-Y');  ?>";
    var dy = "<?php echo date('Y');  ?>";
    var cm = "<?php echo date('m');  ?>";
    var dm = "<?php echo date('H', strtotime(date('Y-m-d H:00')) + (3600));  ?>";
    var md = "<?php echo date('d-m-Y H:00', strtotime(date('Y-m-d H:00')) + (3600 * 25));  ?>";
    var search_calender_open = 0;
    /*$(function () {
              $('[data-toggle="tooltip"]').tooltip();
      })*/
    jQuery(function() {
        jQuery('input[name=enquiry_date_from]').datetimepicker({
            format: 'd/m/Y',
            onShow: function(ct) {

                var mindate = jQuery('input[name=enquiry_date_to]').val().split('/');
                mdate = mindate[2] + '/' + mindate[1] + '/' + mindate[0];
                // var min_date = new Date(mdate);
                // min_date.setDate(min_date.getDate()-30);
                this.setOptions({
                    maxDate: $('input[name=enquiry_date_to]').val() ? mdate : false,
                    //minDate:$('input[name=enquiry_date_to]').val()?min_date:false
                });
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            timepicker: false
        });

        jQuery('input[name=enquiry_date_to]').datetimepicker({
            format: 'd/m/Y',
            onShow: function(ct) {

                var mindate = $('input[name=enquiry_date_from]').val().split('/');
                mdate = mindate[2] + '/' + mindate[1] + '/' + mindate[0];
                //  var max_date = new Date(mdate);
                //  max_date.setDate(max_date.getDate()+30);
                this.setOptions({

                    minDate: jQuery('input[name=enquiry_date_from]').val() ? mdate : false,
                    //maxDate:$('input[name=enquiry_date_from]').val()?max_date:false
                });
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            timepicker: false
        });
    });
    jQuery(function() {
        jQuery('input[name=follow_date_from]').datetimepicker({
            format: 'd/m/Y',
            onShow: function(ct) {
                var mindate = jQuery('input[name=follow_date_to]').val().split('/');
                mdate = mindate[2] + '/' + mindate[1] + '/' + mindate[0];
                this.setOptions({
                    maxDate: jQuery('input[name=follow_date_to]').val() ? mdate : false
                });
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            timepicker: false
        });

        jQuery('input[name=follow_date_to]').datetimepicker({
            format: 'd/m/Y',
            onShow: function(ct) {
                var mindate = jQuery('input[name=follow_date_from]').val().split('/');
                mdate = mindate[2] + '/' + mindate[1] + '/' + mindate[0];
                this.setOptions({
                    minDate: jQuery('input[name=follow_date_from]').val() ? mdate : false
                });
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            timepicker: false
        });

        jQuery('input[name=add_seller_follow_date]').datetimepicker({
            timepicker: true,
            format: 'd-m-Y H:i',
            minDate: dd ? dd : false,
            minTime: 0,
            onShow: function(ct) {
                search_calender_open = 1;
            },
            onClose: function(ct) {
                search_calender_open = 0;
            },
            onChangeDateTime: function() {
                var valArr = $('input[name=add_seller_follow_date]').val().split(' ');
                if (valArr[0] == ddd) {
                    this.setOptions({
                        minTime: dm + ':00'
                    });
                    $('input[name=add_seller_follow_date]').val(valArr[0] + ' ' + dm + ':00');

                } else {
                    this.setOptions({
                        minTime: '00:00'
                    });
                }
                var yArr = valArr[0].split('-');
                if (yArr[2] < dy || (yArr[1] < cm && yArr[2] == dy)) {
                    $('input[name=add_seller_follow_date]').val(ddd + ' ' + dm + ':00');
                }
            }
        });
    });


    var cryear = <?= date('Y') ?>;
    var crmonth = <?= date('m') ?>;
    $('.add_seller_myear').change(function() {
        $(this).parent().parent().parent().next().find('select option').eq(0).prop('selected', true);
        var min_val = parseInt($(this).val());
        $(this).parent().parent().parent().next().find('select option').each(function() {
            if (parseInt($(this).attr('name')) > crmonth && min_val == cryear) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/admin_assets/js/sellerlead.js" type="text/javascript"></script>