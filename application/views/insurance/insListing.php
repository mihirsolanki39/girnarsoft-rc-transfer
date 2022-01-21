<?php $teamn = !empty($this->session->userdata['userinfo']['team_name']) ? $this->session->userdata['userinfo']['team_name'] : ''; ?>
<div class="container-fluid mrg-all-20">
    <style>.dot-sep{content: ""; height: 4px; width: 4px; background: rgba(0,0,0,0.3); border-radius: 15px; display: inline-block; margin: 3px 7px;} </style>
    <div class="row">
        <div class="">
            <div class="cont-spc pad-all-20" id="buyer-lead">
                <form role="form" name="searchform" id="searchform">
                    <div class="row">
                          <input type="hidden" id="ajax_type" name="ajax_type" value="1">
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
                                <input  type="text"  id="search_by_text" name="keyword" id="keyword" class="form-control crm-form drop-form abc4" style="display:block" readonly="readonly">
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
                                <?php foreach (INSURANCE_STATUS as $key => $ins_status) { ?>
                                    <option value="<?= $key ?>" <?php if (!empty($type) && $type == $key) {
                                    echo "selected";
                                } else {
                                    echo "";
                                } ?>><?php echo $ins_status; ?></option>
<?php } ?>
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
                                        <li><a href="#" onclick="searchby('', this)" id="quoteshared">Quotes Shared</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="inspectiondate">Inspection Date</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="issuedate">Issue Date</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="canceldate">Cancelled Date</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="closeddate">Closed Date</a></li>
                                        <li><a href="#" onclick="searchby('', this)" id="inceptiondate">Inception Date</a></li>
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
                                <input type="hidden" name="insdashId" id="insdashId" value="<?php echo (!empty($insId)) ? $insId : ''; ?>">

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
                            <?php if (!empty($teamn) && ($teamn != 'Sales') || ($teamn == '')) { ?>
                            <div class="col-md-6">
    <?php if ($this->session->userdata['userinfo']['is_admin'] == '1') { ?>
                                    <a id="Export" href="JavaScript:void(0)" class="pull-right mrg-L10 mrg-T10 pad-L15">DOWNLOAD EXCEL</a>
                            <?php } ?>
                                <a href="<?php echo base_url('addInsurance') ?>" target="_blank"> <button class="btn-success pull-right">ADD CASE</button></a>
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
                                                       <?php $this->load->view('insurance/ajax_getInsurance',$data);?>
                                                   <?php
                                                        if (empty($query)){
                                                            echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
                                                        }
                                                        ?>
                                                    <span id="imageloder" style="display:none; position:absolute;left: 40%;border-radius: 50%;z-index:999; ">
                                                        <img src="<?= base_url('assets/admin_assets/images/loader.gif') ?>"></span>    
                                                </tbody>
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

<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/admin_assets/js/processInsurance.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
<script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
<script>
    $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<script>
function reopen(customerId, links) {
    var r = confirm("Do You Want to Reopen this Case?");
    if (r == true)
    {
        $.ajax({
            type: 'POST',
            url: base_url + "Insurance/reopenCase",
            data: {customerId: customerId, links: links},
            dataType: 'html',
            success: function (response)
            {
                setTimeout(function () {
                    window.location.href = links;
                }, 3000);
            }
        });
    }
}
var date = new Date();
var d = new Date();
d.setDate(date.getDate());

$(document).ready(function () {
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
});
$(".abc1").change(function () {
    var va = $(".abc1").val();
    $('#searchbyval').val(va);
});

$(".toggle-btn").click(function () {
    $(".novisit").toggle();
});
function pagination(page) {
    $("#page").val(page);
    $("#ins_list").html('');
    $('#imageloder').show();
    $.ajax({
        url: base_url + "insurance/insListing",
        type: 'post',
        dataType: 'html',
        data: {'data': $("#searchform").serialize()},
        success: function (response)
        {
                $("#ins_list").html(response);
                $('#imageloder').hide();
                $(window).scrollTop(0);
        }
    });
}
$("#search").click(function (event) {
    var is_search = 1;
    $('#page').val('1');
    $('#imageloder').show();
    $.ajax({
        url: base_url + "insurance/insListing",
        type: 'post',
        dataType: 'html',
        data: {'data': $("#searchform").serialize() + '&issearch=' + is_search},
        success: function (response)
        {
                $("#ins_list").html(response);
                $('#imageloder').hide();
                $(window).scrollTop(0);
                footerBottom();
        }
    });
});
$('#Export').click(function () {
    var input = $("<input>").attr("type", "hidden").attr("name", "export").val("export");
    $('#searchform').append(input);
    $('#searchform').attr('method', 'post').submit();
});
$(document).on('click', '#Reset', function (ev) {
    location.reload(true);
});
function searchby(eve = '', e = '')
{
    //  alert("sfsdf");
    $("#search_by_text").attr("readonly", false);
    if (eve != '')
    {
        var id = $(eve).attr('id');
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
            $("#search_by_text").val("");
         if(id == "searchcustname"){   
            $('#search_by_text').attr('onkeypress','return blockSpecialChar(event)');
         }else if(id == "searchmobile"){ 
            $('#search_by_text').attr('onkeypress','return isNumberKey(event)'); 
            $('#search_by_text').attr('maxlength','10');
         }
         else { 
            $('#search_by_text').attr('onkeypress','return blockSpecialChar(event)'); 
            $('#search_by_text').attr('maxlength','50');
         }        
            $('.abc4').attr('style', 'display:block;');
            $('.abc1').attr('style', 'display:none;');
            $('.abc2').attr('style', 'display:none;');
            $('.abc3').attr('style', 'display:none;');
        }
    } else
    {     
        $("#createStartDate").val("");
        $("#createEndDate").val("");
        $("#createStartDate").prop('disabled', false);
        $("#createEndDate").prop('disabled', false);
        var id = $(e).attr('id');
        var date = new Date();
        var d = new Date();
        d.setDate(date.getDate());

        $('.icon-cal1').datepicker('destroy');
        if (id == "inceptiondate") {
            // alert("aa");
            $("#createStartDate").datepicker({
                format: 'dd/mm/yyyy',
                minDate: 0,
                maxDate: "+3Y",
                autoclose: true,
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('#createEndDate').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('#createEndDate').datepicker('setStartDate', null);
            });
            $("#createEndDate").datepicker({
                format: "dd/mm/yyyy",
                minDate: 0,
                maxDate: "+3Y",
                autoclose: true,
            });
        } else {
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
                format: "dd/mm/yyyy",
                endDate: d
            });

        }
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
    document.getElementById('searchform').addEventListener('keypress', function (event) {
        if (event.keyCode == 13) {
            $("#search").click();
        }
    });
</script>
