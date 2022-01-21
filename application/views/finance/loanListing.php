<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<style>
    .dot-sep { content: ""; height: 4px; width: 4px; background: rgba(0,0,0,0.3); border-radius: 15px; display: inline-block; margin: 3px 7px;}
</style>
<?php
//print_r($this->session->userdata['userinfo']);
$urlExplode = explode('/', current_url());
$url = !empty($urlExplode[5]) ? ($urlExplode[5]) : '';
?>
<div id="content">
    <div class="container-fluid mrg-all-20">
        <div class="row">
            <div class="">
                <div class="cont-spc pad-all-20" id="buyer-lead">
                    <form id="searchform">
                          <input type="hidden" id="ajax_type" name="ajax_type" value="1">
                        <div class="row">
                            <div class="col-md-2 pad-R0 border-R0">
                                <label for="" class="crm-label" >Search By</label>
                                <div class="select-box cus-selec" style="width:80px">Select <span class="d-arrow"></span></div>
                                <ul class="drop-menu">
                                    <li><a href="#" onclick="searchby(this)" id="searchcase">Loan Ref. Id</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchcaseloan">Loan LOS No.</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchserialno">Loan S.No.</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchcustname">Customer name</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchmobile">Mobile number</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchdealer">Dealership Name</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchbank">Bank Name</a></li>
                                    <li><a href="#" onclick="searchby(this)" id="searchreg">Reg no</a></li>
                                </ul>
                                <!-- /btn-group -->
                                <div id="dropD">
                                    <input type="text"  name="searchbyval" id="searchbyval" class="form-control crm-form drop-form abc4" style="width:57%; display:block;" readonly="readonly">
                                    <select name="searchbyvaldealer" id="searchbyvaldealer" class="form-control crm-form drop-form abc1" style="display: none; width:170px"><option value="">Select Dealership</option></select>

                                    <select name="searchbyvalbank" id="searchbyvalbank" class="form-control crm-form drop-form abc3" style="display: none; width:170px"><option value="">Select Bank</option></select>
                                </div>
                                <input type="hidden" name="searchby" id="searchby" value="">

                            </div>
                            <div class="col-md-1 pad-R0">
                                <label for="" class="crm-label">Source</label>
                                <select class="form-control crm-form testselect1" name="loan_source" id="loan_source">
                                    <option selected="selected" value="">Select</option>
                                    <option value="1">Dealer</option>
                                    <option value="2">Inhouse</option>

                                </select>
                            </div>
                            <div class="col-md-1 pad-R0">
                                <label for="" class="crm-label">Status</label>
                                <select class="form-control crm-form testselect1" name="loan_status" id="loan_status">
                                    <option value="">Status</option>
                                    <?php foreach ($fileTags as $ky => $vl) { ?>
                                        <option value="<?= $vl['id'] ?>"><?= $vl['file_tag'] ?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <div class="col-md-3 pad-R10">
                                    <label class="crm-label">Date</label>
                                    <div class="row">
                                        <div class="col-md-3 pad-R0" style="width:33%">
                                            <div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
                                            <ul class="drop-menu drop-menu-1">
                                                <li><a href="#" onclick="searchby('', this)" id="casedate">Case Added Date</a></li>
                                                <li><a href="#" onclick="searchby('', this)" id="fileddate">Filed Date</a></li>
                                                <li><a href="#" onclick="searchby('', this)" id="approvedate">Approved Date</a></li>
                                                <li><a href="#" onclick="searchby('', this)" id="rejectdate">Rejected Date</a></li>
                                                <li><a href="#" onclick="searchby('', this)" id="disdocdate">Disbursed Date</a></li>
                                                <!--<li><a href="#" onclick="searchby('',this)" id="closeddate">Closed Date</a></li>-->
                                            </ul>
                                        </div>
                                        <div class="col-md-3 new_lead pad-all-0" style="width:33%">
                                            <input type="hidden" name="searchdate" id="searchdate" value=""> 
                                            <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From" disabled="disabled"> 
                                            </div>
                                        </div>
                                        <div class="col-md-5 new_lead pad-all-0" style="width:33%">
                                            <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                                <input type="text" name="daterange_from" id="daterange_from" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To" disabled="disabled"> 
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
                                <?php if (($rolemgmt[0]['role_name'] == 'admin') || ($rolemgmt[0]['role_name'] == 'Loan Admin')) { ?>
                                    <div class="col-md-1 pad-R0 width135">
                                        <label for="" class="crm-label">Assigned To</label>

                                        <select class="form-control crm-form testselect1" name="assignedto" id="assignedto">

                                            <option value="">Assigned to</option>
                                            <?php foreach ($employeeList as $empkey => $empval) { ?>
                                                <option value="<?= $empval['id'] ?>"><?= $empval['name'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <?}?>
                                    <div class="col-md-2 pad-R0">
                                        <span id="spnsearch">
                                            <input type="button" class="btn-save btn-save-new" value="Search" id="search">
                                            <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                                            <input type="hidden" name="page" id="page" value="1">
                                            <input type="hidden" name="dashboard" id="dashboard" value="<?= (!empty($type) ? $type : '') ?>">
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
                                        <h5 class="cases">Loan Cases <span id="total_count">(<?= !empty($total_count) ? $total_count : '0'; ?>)</span></h5>
                                    </div>
                                    <?php if (($rolemgmt[0]['role_name'] == 'admin') || ($rolemgmt[0]['role_name'] == 'Loan Admin') || ($rolemgmt[0]['role_name'] == 'Prelogin')) { ?>
                                        <div class="col-md-6">
                                            <?php if($rolemgmt[0]['role_name'] == 'admin'){?>
                                            <a id="LoanExport" href="JavaScript:void(0)" class="pull-right mrg-L10 mrg-T10 pad-L15">DOWNLOAD EXCEL</a>  
                                        <?php } ?>
                                            <a href="<?= base_url() ?>leadDetails/add" target="_blank"> <button class="btn-success pull-right">ADD CASE</button></a>
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
                                                            <table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">S.No.</th>
                                                                        <th width="15%">Customer Details</th>
                                                                        <th width="15%">Car Details</th>
                                                                        <th width="15%" >Loan Details</th>
                                                                        <th width="15%" >Case Details</th>
                                                                        <th width="15%">Case Update</th>
                                                                        <th width="8%" >Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="loancases">
                                                                    <?php 
                                                                    if (!empty($loan_listing)) {
                                                                    $this->load->view('finance/loanCasesListing', $loan_listing); }?>

                                                                    <?php
                                                                    if (empty($loan_listing)) {
                                                                        echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
                                                                    }
                                                                    ?>
                                                                <span id="imageloder" style="display:none; position:absolute;left: 40%;border-radius: 50%;z-index:999; ">
                                                                    <img src="<?= base_url('assets/admin_assets/images/loader.gif') ?>"></span>    
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
                </div>
            </div>
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="hisfeedBack">
                <div class="modal-backdrop fade in" style="height:100%"></div>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gray">
                            <button type="button" onclick="closeHistory()" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Customer History</h4>
                        </div>
                        <div class="modal-body">
                            <div class="timeline_content">
                                <div class="row">
                                    <div class="col-sm-12 sidenav">
                                        <ul class="par-ul" id="showHisData">

                                            <!-- <li class="side_nav">
                                                <div class="col-sm-4"> <a href="#" class="sidenav-a "><span class="img-type"></span>Sep 03 <small>11.23 pm</small></a></div>
                                                <div class="col-sm-8 side_text">
                                                   <span class="active_text">
                                                      Payment Requested
                                                   </span>
                                                   <span class="Detail_text">
                                                      NA
                                                   </span>
                                                </div>
                                             </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-comment -->
                </div>
            </div>

        </div>

        <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
        <script src="<?= base_url('assets/admin_assets/js/loanlisting.js') ?>"></script>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
        <script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
        <script>
           $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
        </script>
        <script>
            function showHistory(loanid)
            {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>" + "Finance/getHistoryDetail/",
                    data: {caseId: loanid},
                    dataType: 'html',
                    success: function (response)
                    {
                        $('#hisfeedBack').addClass('in');
                        $('#hisfeedBack').attr('style', 'display:block');
                        $('#showHisData').html(response);
                    }
                });


            }
        </script>
        <script>
            var date = new Date();
            var d = new Date();
            d.setDate(date.getDate());
            $(document).ready(function () {
                var dates = $('#daterange_to').val();
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
                var type = "<?= $url ?>";
            });
            //loanlisting();
            function searchby(eve = '', e = '')
            {
                if (eve != '')
                {
                    var id = $(eve).attr('id');
                    $('#searchby').val(id);
                    if (id == 'searchdealer')
                    {

                        $('.abc4').attr('readonly', 'readonly');
                        $('.abc3').attr('style', 'display:none;');
                        $('.abc4').attr('style', 'display:none;');
                        dealerList();
                    }
                    if (id == 'searchbank')
                    {
                        $('.abc4').attr('style', 'display:none;');
                        $('.abc4').attr('readonly', 'readonly');
                        $('.abc1').attr('style', 'display:none;');
                        bankList();
                    }
                    if (id == 'searchcustname')
                    {
                        $('.abc4').removeAttr("readonly");
                        $('.abc4').attr('style', 'display:block;');
                        $('.abc4').val('');
                        $('.abc4').attr('onkeypress', 'return nameOnly(event)');
                        $('.abc1').attr('style', 'display:none;');
                        $('.abc3').attr('style', 'display:none;');
                    }
                    if (id == 'searchmobile')
                    {
                        $('.abc4').removeAttr("readonly");
                        $('.abc4').attr('style', 'display:block;');
                        $('.abc4').attr('maxlength', '10');
                        $('.abc4').val('');
                        $('.abc4').attr('onkeypress', 'return isNumberKey(event)');
                        $('.abc1').attr('style', 'display:none;');
                        $('.abc3').attr('style', 'display:none;');
                    }
                    if ((id == "searchcase") || (id == 'searchserialno') || (id == 'searchreg') || (id=='searchcaseloan'))
                    {
                        $('.abc4').removeAttr("readonly");
                        $('.abc4').val('');
                        $('.abc4').attr('style', 'display:block;');
                        $('.abc1').attr('style', 'display:none;');
                        $('.abc3').attr('style', 'display:none;');
                        $('.abc4').attr('onkeypress', '');
                    }
                } else
                {
                    $("#daterange_from").prop('disabled', false);
                    $("#daterange_to").prop('disabled', false);
                    var id = $(e).attr('id');
                    $('#searchdate').val(id);
                    $("#daterange_to").prop("disabled", false);
                    $("#daterange_from").prop("disabled", false);
            }
            }
            function dealerList()
            {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>" + "Finance/getDealerList/",
                    dataType: 'html',
                    data: {status: '1'},
                    success: function (response)
                    {
                        $('.abc4').attr('style', 'display:none;');
                        $('.abc1').attr('style', 'display:block;');
                        $('.abc1').html(response);

                    }
                });
            }
            function bankList()
            {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>" + "Finance/getBankList/",
                    dataType: 'html',
                    success: function (response)
                    {
                        $('.abc3').attr('style', 'display:block;');
                        $('.abc3').html(response);

                    }
                });
            }
            function loanlisting()
            {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url(); ?>" + "Finance/loanListing/",
                    dataType: 'html',
                    success: function (response)
                    {
                        $('#loancases').html(response);
                        footerBottom();
                    }
                });
            }


            function reset()
            {
                /*$('#searchbyval').val('');
                 $('#searchby').val('');
                 $('#loan_source').val('');
                 $('#loan_status').val('');
                 $('#searchdate').val('');
                 $('#daterange_to').val('');
                 $('#daterange_from').val('');
                 $('#status').val('');
                 $('#assignedto').val('');
                 loanlisting();*/
                location.reload(true);
            }
            function reopen(caseId, link) {
                {
                    // alert('hi');
                    var r = confirm("Do You Want to Reopen this Case?");
                    if (r == true)
                    {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url(); ?>" + "Finance/reopenCase/",
                            data: {caseId: caseId},
                            dataType: 'html',
                            success: function (response)
                            {
                                setTimeout(function () {
                                    window.location.href = link;
                                }, 300);
                            }
                        });
                    } else
                    {
                        alert('You Choose Cancel!');
                    }
                }
            }

            $(document).ready(function () {
                var team = "<?= $this->session->userdata['userinfo']['team_name'] ?>";
                var role = "<?= $this->session->userdata['userinfo']['role_name'] ?>";
                if ((team == 'All') && (role == 'Accountant'))
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
            });
            $(".abc1").change(function () {
                var va = $(".abc1").val();
                $('#searchbyval').val(va);
            });

            function closeHistory()
            {
                $('#hisfeedBack').removeClass('in');
                $('#hisfeedBack').attr('style', 'display:none');
            }

            function pagination(page) {
                $("#page").val(page);
                $("#loancases").html('');
                $('#imageloder').show();
                var formDataSearch = $('#searchform').serialize();
                var start = $('#page').val();
                start++;
                $.ajax({
                    url: base_url + "Finance/loanListing",
                    type: 'post',
                    dataType: 'html',
                    data: formDataSearch,
                    success: function (responseData, status, XMLHttpRequest) {
                        var html = $.trim(responseData);
                        $('#page').attr('value', start);
                        if (parseInt(html) != 1) {
                            $('#loancases').html(html);
                            $(window).scrollTop(0);
                        } else if (parseInt(html) == 1) {
                            start--;
                            $('#page').attr('value', start);
                            $('#loancases').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");

                            $('#loadmoreajaxloader').text('No More Results');
                        }
                        $('.' + page).addClass('active');
                        $('#imageloder').hide();
                        footerBottom();
                    }
                });
            }
            $('#total_count').text('(' + "<?= !empty($total_count)?$total_count:'0' ?>" + ')');
    $('#searchbyval').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $('#search').trigger('click');
        }
    });
    $('#LoanExport').click(function(){
    //alert('kkkk');
              var input = $("<input>").attr("type", "hidden").attr("name", "export").val("export");
              $('#searchform').append(input);
              $('#searchform').attr('method','post').submit();
      // window.location.href.reload();
    });
</script>
