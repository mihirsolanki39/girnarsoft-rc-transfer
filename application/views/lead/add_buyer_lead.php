<link href="<?= base_url('/assets/css/car_box.css') ?>" rel="stylesheet">
<!--<link href="<?= base_url('/assets/css/select2.min.css') ?>" rel="stylesheet">-->
<div class="container-fluid" >
   
    <div class="col-md-12 pad-LR-10 mrg-B40">
    <h2 class="page-title">Lead Details</h2>
      <div class="white-section1">
    <div class="col-md-4">
        <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if ($error) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>                    
            </div>
        <?php } ?>
        <?php
        $success = $this->session->flashdata('success');
        if ($success) {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
    </div>
    <h2 class="main-heading clearfix tophead "></h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover enquiry-table">
            <thead>
                <tr>
                    <th width="20%">Customer Details</th>
                    <th  width="11%">Source</th>
                    <th  width="19%">Budget</th>
                    <th  width="11%">Status</th>
                    <th  width="11%">Follow-up Date</th>
                    <th  width="25%">Comment</th>
                    <!--<th  width="14%">Action</th>-->
                </tr>
            </thead>
            <form name="editcustomer" id="editcustomer" method="post">
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <input type="text" name="txtname" autocomplete="off" id="txtname" placeholder="Enter Customer Name*" class="form-control" value="" maxlength="50" >
                            </div>
                            <div class="form-group">
                                <input type="email" name="txtemail" id="txtemail" placeholder="Enter Email" class="form-control" value="" maxlength="50" >
                            </div>


                            <div class="form-group">
                                <input type="text" name="txtmobile" id="txtmobile"  onkeypress="return isNumberKey(event)" class="form-control" value="" placeholder="Enter Primary Mobile No.*" maxlength="10" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="text" name="cd_alternate_mobile"  onkeypress="return isNumberKey(event)" id="cd_alternate_mobile" placeholder="Enter Alternate Mobile No." class="form-control" value="" maxlength="10" >
                            </div>
                            <select class="form-control search-form-select-box" name="locality_id" id="location">
                                <?php
                                $optLoc = '<option value="">Select Location</option>';
                                if (!empty($localityData['localities'])) {
                                    $locationData = $localityData['localities'];
                                    foreach ($locationData as $key => $val) {
                                        $optLoc .= "<option value='" . $val['locality_id'] . "'>" . $val['locality_name'] . "</option>";
                                    }
                                }
                                echo $optLoc;
                                ?>
                            </select>
                        </td>
                        <td>
                            <div class="row form-group">
                                <div class="col-sm-10"> 
                                    <select id="lead_source" name="lead_source" class="form-control search-form-select-box">
                                        <option selected="selected" value="WALK-IN">Walk-In</option>
                                        <option value="Gaadi">Gaadi</option>
                                        <option value="Cardekho">Cardekho</option>
                                        <option value="CARTRADE">Cartrade</option>
                                        <option value="CARWALE">Carwale</option>
                                        <option value="OLX">OLX</option>
                                        <option value="QUIKR">Quikr</option>
                                        <option value="website">Website</option>
                                        <option value="Facebook">Facebook</option>
                                    </select>

                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row form-group">
                                <div class="col-sm-10">
                                    <select class="form-control" name="price_max" id="price_max" style="width:120px; float:left; ">
                                        <option value="">Select Budget</option>
                                        <?php
                                        ksort($maxPriceArr);
                                        foreach ($maxPriceArr as $minkey => $val) {
                                            ?>
                                            <?php if ($val != '' && $val != 0) { ?>
                                                <option value="<?php echo $minkey; ?>">
                                                    <?php echo $val; ?></option>
                                            <?php } ?>
                                        <?php }
                                        ?>
                                    </select>	
                                </div>
                            </div>
                        </td>
                        <td>
                            <select class="form-control" name="cusstatus" id="cusstatus">
                                <option value="">Status</option>
                                <?php
                                $optLoc = '';
                                if (!empty($statusData)) {
                                    foreach ($statusData as $key => $val) {
                                        $optLoc .= "<option value='" . $val->status_name . "'>" . $val->status_name . "</option>";
                                    }
                                }
                                echo $optLoc;
                                ?>
                            </select>
                        </td>
                        <td>
                            <div class="input-append date input-group" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                <input type="text" name="followdate" id="follow-uo-date"  value="" class="followdate form-control search-form-select-box font-12"  style="width:140px; cursor:pointer;" />
                                <input type="hidden" name="dfollowdate" id="dfollow-uo-date"  value="" />
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <textarea class="form-control comment-box" rows="1" placeholder="Comment here" name="txtcomment" id="txtcomment"  onclick="$(this).next().html((200 - this.value.length) + ' characters remaining (200 maximum)').show();" onkeyup="$(this).next().html((200 - this.value.length) + ' characters remaining (200 maximum)');"></textarea>
                            </div>
                            <div class="comment-wrap  mCustomScrollbar"  data-mcs-theme="dark" id="commentwraper" style="width:330px;word-break:break-all;">

                                <ul class="list-unstyled" id="ulcomment">
                                </ul>
                            </div>
                            <input type="hidden" name="lognew" id="action" value="add" />
                        </td>
                    </tr>
                </tbody>
            </form>
        </table>
    </div>


    <!-- End Edit Table -->

    <span id='searchboxcar'> 
        <!-- End Edit Table -->
        <h4 class="mrg-B15 mrg-T20">Assign Car</h4>
        <div class="clearfix">
            <div class="well well-filter">
                <form id="searchform" name="searchform" role="form">

                    <div class="row ">
                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                            <label class="form-label" for="exampleInputPassword1">Search By</label>
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">                        	

                                    <input type="text" value="" id="keyword" name="keyword" placeholder="Search by Reg No." class="form-control  pad-L10">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                            <label class="form-label" for="exampleInputPassword1">Select a Car</label>
                            <div class="row row-text-box">
                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        

                                    <select  class="form-control search-form-select-box" name="make" id="make"  >
                                        <option selected="selected" value="">--Select Make--</option>
                                        <?php 
                                        $sel_make = !empty($_POST['make'])?$_POST['make']:'';
                                        foreach($makeList as $res)
                                        {
                                        if($res['make']==$sel_make){
                                        $selected_make = 'selected="selected"';
                                        }else{
                                        $selected_make='';
                                        }
                                        ?>
                                        <option value="<?= $res['make']; ?>" <?php echo $selected_make; ?>>
                                            <?= $res['make']; ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        
                                    <select  name="model"  class="form-control search-form-select-box" id="model">
                                        <option selected="selected" value="" >--Select Model--</option>
                                    </select>
                                    <select name="version" id="version"  class="form-control search-form-select-box" disabled style="display:none;">
                                        <option selected="selected" value="" >--Select Version--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="form-label">KM. Range</label>
                            <div class="row row-text-box">
                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        
                                    <select class="form-control" name="km_from" id="km_from" onclick="_gaq.push(['_trackEvent', 'Buyer Enquiry', 'Km From','<?= $event_type ?>'])">
                                        <option value="">From</option>
                                        <option value="0">0</option> 
                                        <?php
                                            for ($i = 10000; $i <= 100000; $i+=10000) {
                                        ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option> 
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                    <select class="form-control" name="km_to" id="km_to" onclick="_gaq.push(['_trackEvent', 'Buyer Enquiry', 'Km To','<?= $event_type ?>'])">
                                        <option value="">To</option>
                                        <?php
                                        for ($i = 10000; $i <= 100000; $i+=10000) {
                                            ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php
                                        }
                                        ?>  
                                    </select>
                                </div>
                            </div>
                        </div> 

                        <div class="col-md-1 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="form-label">Transmission</label>

                            <div class="row row-text-box">
                                <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                    <select id="transmission_type" name="transmission_type" class="form-control search-form-select-box">
                                        <option  value="">Transmission</option>
                                        <option  value="Automatic">Automatic</option>
                                        <option  value="Manual">Manual</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="form-label">Price Range</label>
                            <div class="row row-text-box">
                                <div class="col-xs-6 mrg-all-0 sm-text-box">                        	
                                    <select class="form-control" name="price_min" id="price_min" onclick="_gaq.push(['_trackEvent', 'Buyer Enquiry', 'Price From','<?= $event_type ?>'])">
                                        <option value="">Price Min</option>
                                        <?php
                                        $minPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh');
                                        foreach ($minPriceArr as $minkey => $val) {
                                            ?>
                                            <option value="<?php echo $minkey; ?>"><?php echo $val; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-6 mrg-all-0 sm-text-box">
                                    <select class="form-control" name="price_max" id="price_maxn" onclick="_gaq.push(['_trackEvent', 'Buyer Enquiry', 'Price To','<?= $event_type ?>'])">
                                        <option value="">Price Max</option>
                                        <?php
                                        $maxPriceArr = array('50000' => '50,000', '100000' => '1 Lakh', '200000' => '2 Lakh', '300000' => '3 Lakh', '400000' => '4 Lakh', '500000' => '5 Lakh', '600000' => '6 Lakh', '700000' => '7 Lakh', '800000' => '8 Lakh', '900000' => '9 Lakh', '1000000' => '10 Lakh', '1500000' => '15 Lakh', '2000000' => '20 Lakh', '2500000' => '25 Lakh', '3000000' => '30 Lakh', '4000000' => '40 Lakh', '5000000' => '50 Lakh', '6000000' => '60 Lakh', '7000000' => '70 Lakh', '8000000' => '80 Lakh', '9000000' => '90 Lakh', '10000000' => '1 Crore');
                                        foreach ($minPriceArr as $minkey => $val) {
                                            ?>
                                            <option value="<?php echo $minkey; ?>"><?php echo $val; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-6 pad-LR tabpading">
                            <label for="exampleInputPassword1" class="form-label">Fuel Type</label>

                            <div class="row row-text-box">
                                <div class="col-xs-12 pad-all-0 mrg-B0 form-group">
                                    <select id="fuel_type" name="fuel_type" class="form-control search-form-select-box">
                                        <option  value="">Fuel Type</option>
                                        <?php foreach ($getDeatCarFuelArr as $key => $val) { ?>
                                            <option  value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 pad-LR pull-right">
                            <div class="row row-text-box">
                                <div class="col-xs-12 mrg-all-0 sm-text-box">
                                    <label for="exampleInputPassword1" class="form-label"></label>
                                    <span id="spnsearch">
                                    <button type="button" class="btn btn-primary mrg-T20 type" id="search"  >Search</button></span>
                                    <button type="button" class="btn btn-default mrg-T20"  id="Reset">Reset</button>
                                    <br><br>

                                </div>

                            </div>
                        </div>


                    </div>


                </form> 

            </div>
        </div>
    </span> 

    <form name="buyerenquiry_form" id="buyerenquiry_form" action="" method="get">
        <input type="hidden" name="type" id="type" value="" />
        <input type="hidden" name="id" id="id" value="" />
        <input type="hidden" name="action" id="action" value="add" />
        <input type="hidden" name="followuodate2" id="followuodate2" value="<?php echo date('j M Y g:i a',strtotime(date('Y-m-d H:i:s')))  ?>">



        <div role="tabpanel">
            <ul class="nav nav-tabs similartabs" role="tablist">
                <li class="active"><a href="#similarTab" aria-controls="allTab" role="tab" data-toggle="tab" id="all" class="type" onclick="$('#searchboxcar').show();">From Stock  <span class="badge" id="spnalldealer_cars">  0</span></a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="similarTab">
                    <span id="imageloder" style="display:none;position: absolute;left: 40%;border-radius: 50%;">
                    <img src="http://sarojsahoo.gaadi.com/origin-assets/boot_origin_asset_new/images/loader.gif"></span>
                    <div class="clearfix pad-T15" id="cartype">

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="clearfix text-center actionbar" id="actionbar">
            <button type="button" name="save_Enquiries" id="save_Enquiries" class="btn btn-primary btn-lg savebtn" style="background-color: #cf3500 !important; color:white !important;">Save</button>
            <button type="reset" name="reset" id="reset" class="btn btn-default  btn-lg mrg-L10" onclick="window.top.location.href = '/lead/getLeads'">Cancel</button>
        </div>
    </form>
</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lead.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>

$('#txtmobile').change(function(){
    var pincodePattern = /^[6-9][0-9]{9}$/;
    var txtmobile =  $('#txtmobile').val();
    if((txtmobile.length=='10') && (txtmobile.match(pincodePattern)))
    {
        $.ajax({
        type: 'POST',
        url: "lead/ajax_alreadyExistsCustomer",
        data:{mobile:txtmobile},
        dataType: 'json',
        success: function (responseData) {
            if(responseData.status=='0'){
           
            snakbarAlert('Lead Already Exists.');
            setTimeout(function(){  var txtmobile =  $('#txtmobile').val(''); }, 3000);
           }
        }
        });
    }
});
    $(function () {
        //var  followuodate2='<?php echo date('j M Y g:i a',strtotime(date('Y-m-d H:i:s')))  ?>';
        $('#txtcomment').maxlength();
        $('#follow-uo-date').datetimepicker({
            timepicker: true,
            format: 'j M Y g:i a',
            constrainInput: true,
            maxDate: new Date('<?= date('Y-m-d', strtotime('30 days')) ?>'),
            scrollMonth:true,
            scrollTime:true
        
        });
    });
    $(document).ready(function() {
      $("#location").select2();
      //$('#location').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
    });

    
        
    
    $(document).ready(function () {
    $('#searchboxcar').show();
    $('#actionbar').show();
    $('#imageloder').show();
    <?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'all') { ?>
                $('#type').attr('value', '<?= $_REQUEST['type'] ?>');
        $('#typef').attr('value', '<?= $_REQUEST['type'] ?>');
    <?php } else { ?>
                $('#type').attr('value', 'similar_cars');
        $('#typef').attr('value', 'similar_cars');
    <?php } ?>
           $.ajax({
        type: 'POST',
        url: "lead/ajax_edit_buyer_similar_car",
        data:$('#buyerenquiry_form').serialize() + "&" + $('#searchform').serialize(),
        dataType: 'html',
        success: function (responseData, status, XMLHttpRequest) {
            var res = responseData.split('@@###$$');
            var countcar = res[1].split('@==========@');
            if (parseInt(res[0]) == 1) {
                $('#imageloder').hide();
                $('#cartype').html('No Record Found');
                $('#spnsimilar_cars').html(countcar[0]);
                $('#spnalldealer_cars').html(countcar[1]);
            } else {
                $('#imageloder').hide();
                $('#cartype').html(res[0]);



                $('#spnsimilar_cars').html(countcar[0]);
                $('#spnalldealer_cars').html(countcar[1]);

            }


        }
    });
});
</script>