<?php echo $this->load->view('insurancePayout/insurancePayout_search', $insurance_listing); ?>
<div class="container-fluid mrg-T20" >
    <div class="row">
        <div class="">
            <div class="background-ef-tab" id="loandetails">
                <div class="tabs loandetails">
                    <div class="background-ef-tab" id="loandetails">
                        <div class="tabs loandetails">
                            <div class="row pad-all-20">
                                <div class="col-md-6">
                                    <h5 class="cases">Insurance Cases<span id="total_count">(<?php echo $total_count; ?>)</span></h5>
                                </div>
                                <div class="col-md-6">
                                    <a  href="<?php echo base_url(); ?>makePayout"class="btn btn-default pull-right">Make Payout</a>
                                </div>  
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                                    <div class="container-fluid ">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover enquiry-table mytbl border-T mrg-B20 font-13">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sr. No</th>
                                                                    <th>Customer Details</th>
                                                                    <th>Car Details</th>
                                                                    <th>New Policy Details</th>
                                                                    <th>Case Details</th>
                                                                    <th>Case Update</th>
                                                                    <th>Payout Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="payoutcases">
                                                                <?php
                                                                $i = 1;
                                                                foreach ($insurance_listing as $key => $value) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="font-13 text-gray-customer">
                                                                                <span class=""><?php echo $value['sno']; ?></span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($value['buyer_type']=='1'){?>    
                                                                                <div class="mrg-B5"><b><?php echo (($value['customer_name'] != '') ? ucwords(strtolower($value['customer_name'])) : 'NA'); ?></b></div>
                                                                            <?php } elseif ($value['buyer_type'] == '2') { ?>
                                                                                    <div class="mrg-B5"><b><?php echo (($value['customer_company_name'] != '') ? ucwords(strtolower($value['customer_company_name'])) : 'NA'); ?></b></div>
                                                                           <?php } ?>
                                                                            <div class="font-13 text-gray-customer"><span class=""><?php echo $value['mobile']; ?></span><br></div>

                                                                            <div><span class="text-gray-customer"><?php echo $value['customer_city_name']; ?></span></div>

                                                                            <?php if (!empty($value['customer_nominee_ref_name'])) { ?>
                                                                                <div><span class="text-gray-customer font-14">Reference: <?php echo $value['customer_nominee_ref_name']; ?></span></div>
    <?php } ?>

                                                                            <div class="mrg-T10"><span class="text-gray-customer text-gray-date font-13"><?php echo $value['created_date'] != '0000-00-00' ? date("d M, Y", strtotime($value['created_date'])) : '00-00-0000'; ?></span></div>
                                                                        </td>
                                                                        <td>
                                                                            <?php if (!empty($value['makeName'])) {
                                                                                ?>
                                                                                <div class="mrg-B5">
                                                                                    <b><?php echo $value['makeName'] . ' ' . $value['modelName'] . ' ' . $value['versionName']; ?> 
                                                                                    </b>
                                                                                </div><?php } ?>
                                                                            <div class="font-13 text-gray-customer"><span class=""><?php echo $value['regNo'] ? strtoupper($value['regNo']) : 'NA'; ?><span class="dot-sep"></span><?php echo $value['make_year'] ? $value['make_year'] : 'NA'; ?> Model</span></div>
                                                                            <a href="#" data-toggle="modal">
                                                                                <?php
                                                                                if ($value["ins_category"] != '') {
                                                                                    $tagname = "";
                                                                                    if ($value['ins_category'] == '1') {
                                                                                        $tagname = 'New Car';
                                                                                    } else if ($value['ins_category'] == '2') {
                                                                                        $tagname = 'Used Car Purchase';
                                                                                    } else if ($value['ins_category'] == '3') {
                                                                                        $tagname = 'Renewal';
                                                                                    } else if ($value['ins_category'] == '4') {
                                                                                        $tagname = 'Policy Expired';
                                                                                    }
                                                                                    ?>

                                                                                    <div class="arrow-details">
                                                                                        <span class="font-10"><?php echo $tagname; ?></span>
                                                                                    </div>
    <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mrg-B5">
                                                                                <b>Policy No - </b>
                                                                                <b> <?php echo $value['current_policy_no'] ? $value['current_policy_no'] : 'NA'; ?></b>
                                                                            </div>
                                                                            <?php
                                                                            if (!empty($value['short_name'])) {
                                                                                $company = $value['short_name'];
                                                                            } else {
                                                                                $company = !empty($value['prev_policy_insurer_name']) ? $value['prev_policy_insurer_name'] : "";
                                                                            }
                                                                            ?>

                                                                            <div class="text-gray-customer"><?php echo $company ? $company : 'NA' ?></div>
                                                                            <div class="text-gray-customer">
                                                                                IDV - <span class="indirupee rupee-icon"><?php echo $value['idv'] ? indian_currency_form($value['idv']) : '0' ?></span> 
                                                                            </div>
                                                                            <div class="text-gray-customer">
                                                                                OD Amount - <span class="indirupee rupee-icon"> <?php echo $value['own_damage'] ? indian_currency_form($value['own_damage']) : '0'; ?></span>
                                                                            </div>
                                                                            <?php
                                                                                $addOn = 0;
                                                                                if ($value['road_side_assistance'] == '1') {
                                                                                    $addOn = (int) $value['road_side_assistance_txt'];
                                                                                }
                                                                                if ($value['loss_of_personal_belonging'] == '1') {
                                                                                    $addOn += (int) $value['loss_of_personal_belonging_txt'];
                                                                                }
                                                                                if ($value['emergency_transport_hotel_premium'] == '1') {
                                                                                    $addOn += (int) $value['emergency_transport_hotel_premium_txt'];
                                                                                }

                                                                                if ($value['driver_cover'] == '1') {
                                                                                    $driver_cover = (int) $value['paid_driver'];
                                                                                }
                                                                                if ($value['personal_acc_cover'] == '1') {
                                                                                    $personal_acc_cover = (int) $value['personal_acc_cover'];
                                                                                }
                                                                                if ($value['passenger_cover'] == '1') {
                                                                                    $passenger_cover = $value['pass_cover'];
                                                                                }
                                                                                if ($value['anti_theft'] == '1') {
                                                                                    $addOn -= $value['anti_theft_txt'];
                                                                                }
                                                                                if ($value['add_on']) {
                                                                                    $addOn += $value['add_on'];
                                                                                }
                                                                                ?>    
                                                                                <div class="text-gray-customer">
                                                                                    <?php echo 'AddOns - '; ?>
                                                                                    <span class="indirupee rupee-icon"> <?php echo (!empty($addOn) ) ? indian_currency_form($addOn) : '0'; ?></span>
                                                                                </div>
                                                                            <div class="text-gray-customer">
                                                                                Premium - <span class="indirupee rupee-icon"> <?php echo indian_currency_form($value['totalpremium']) ? indian_currency_form($value['totalpremium']) : '0'; ?> </span>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="mrg-T5"><b>Source -<?php if ($value['source'] == 'dealer') echo ' Dealer';
                                                                        else echo $value['source']; ?></b></div>
                                                                            <div class="font-14 text-gray-customer"><?php if ($value['source'] == 'dealer') {
                                                                            echo 'Dealership Name - ' . ucfirst($value['dealerName']);
                                                                        } ?></div>
                                                                            <div class="font-14 text-gray-customer">
    <?php echo (!empty($value['employeeName'])) ? 'Assigned To - ' . ucfirst($value['employeeName']) : ''; ?> 
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mrg-B5">
                                                                                <b>Status - </b>
                                                                                <b><?php echo !empty($value['updateStatus']) ? $value['updateStatus'] : 'Issued'; ?></b><br></div>
                                                                            <div class="text-gray-customer">Issue Date - <?php echo date("d M, Y", strtotime($value['current_issue_date'])); ?></div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="font-13 text-gray-customer">
                                                                                    <?php
                                                                                    $payout_status = "Pending";
                                                                                    $dateLable = $datetime = "";
                                                                                    if (!empty($value['payout_id'])) {
                                                                                        $payout_status = "Paid";
                                                                                        $dateLable = "Payout On";
                                                                                        $Payout_datetime = date('d M, Y', strtotime($value['payout_date']));
                                                                                    }
                                                                                    ?>                                                                                              
                                                                                    <div class="mrg-B5"><b>Status - <?= $payout_status ?></b></div>
                                                                                    <?php if (!empty($value['payout_id'])) { ?>
                                                                                        <div class="font-13 text-gray-customer"><span class="font-13"><?= $dateLable ?> - <?= $Payout_datetime ?></span></div>
                                                                                        <div class="font-13 text-gray-customer"><span class="font-13" style="cursor: pointer;" onclick='getPaymentHistory("<?=$value['payout_id']?>")'>Payment ID - <?= $value['payout_id'] ?></span></div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>


                                                                <tr><td colspan="7" style="text-align: center !important;">
<?php if ((int) $total_count > 0) { ?>

                                                                            <div class="col-lg-12 col-md-6">
                                                                                <nav aria-label="Page navigation">
                                                                                    <ul class="pagination" >
                                                                                        <?php
                                                                                        $total_pages = ceil($total_count / $limit);
                                                                                        $pagLink = "";

                                                                                        if ($total_pages < 1) {
                                                                                            $total_pages = 1;
                                                                                        }
                                                                                        if ($total_pages != 1) {
                                                                                            if ((int) $page > 1) {
                                                                                                $prePage = (int) $page - 1;
                                                                                                ?>
                                                                                                <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                                                                                <?php
                                                                                                //this for loop will print pages which come before the current page
                                                                                                for ($i = (int) $page - 6; $i < $page; $i++) {
                                                                                                    if ($i > 0) {
                                                                                                        ?>   
                                                                                                        <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                            }

                                                                                            //this is the current page
                                                                                            // if($i > $page){ 
                                                                                            ?>
                                                                                            <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>

                                                                                            <?php
                                                                                            // }
                                                                                            //this will print pages which will come after current page
                                                                                            for ($i = $page + 1; $i <= $total_pages; $i++) {
                                                                                                ?>
                                                                                                <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                                                                                <?php
                                                                                                if ($i >= $page + 3) {
                                                                                                    break;
                                                                                                }
                                                                                            }

                                                                                            // this is for next button
                                                                                            if ($page != $total_pages) {
                                                                                                $nextPage = (int) $page + 1;
                                                                                                ?> 
                                                                                                <li onclick="pagination('<?php echo $nextPage; ?>')"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>
            <?php
        }
    }
    ?>
                                                                                    </ul>
                                                                                </nav>
                                                                            </div>
<?php } ?>     
                                                                    </td></tr>
<?php if (empty($insurance_listing)) {
    echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
}
?>
                                                            <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                                                <img src="<?= base_url('assets/admin_assets/images/loader.gif') ?>"></span>    
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                                                        <img src="ajax/loading.gif" title="Click for more" />Click for more
                                                    </div>

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
</div>
</div>
<div class="modal fade" id="makePayout" role="dialog">

    <div class="modal-backdrop fade in" style="height:100%"></div>
    <div class="modal-dialog" style="width: 1170px; height:200px;">
        <div class="modal-content" >

            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Make Payout</h4>
            </div>
            <div id="payout_modal"></div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/admin_assets/js/insurancepayoutlisting.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sumoselect.css">
<script src="<?= base_url() ?>assets/js/sumoselect.js"></script>
<script>
                                                                                        $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<script>
  function getPaymentHistory(pay_id){
        getListHtml('2',pay_id);
    }
    function makePayout()
    {
        $('#makePayout').addClass(' in');
        $('#makePayout').attr('style', 'display:block');
        var type = 'add';
        var date = new Date();
        var d = new Date();
        d.setDate(date.getDate());
        $.ajax({
            url: base_url + "Payout/makepayout",
            type: 'post',
            dataType: 'html',
            data: '',
            success: function (response)
            {
                $("#payout_modal").html(response);
                $('#paydates').datepicker({
                    format: 'dd-mm-yyyy',
                    endDate: d,
                    autoclose: true,
                    todayHighlight: true
                });

                $('#insdates').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
                });

            }
        });
    }
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

    function reset()
    {
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
        addCommasToListing();
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
        $("#payoutcases").html('');
        $('#imageloder').show();
        var formDataSearch = $('#searchform').serialize();
        var start = $('#page').val();
        start++;
        $.ajax({
            url: base_url + "PayoutInsurance/ajax_PayoutList/1",
            type: 'post',
            dataType: 'html',
            data: formDataSearch,
            success: function (responseData, status, XMLHttpRequest) {
                var html = $.trim(responseData);
                $('#page').attr('value', start);
                if (parseInt(html) != 1) {
                    $('#payoutcases').html(html);
                    $(window).scrollTop(0);
                } else if (parseInt(html) == 1) {
                    start--;
                    $('#page').attr('value', start);
                    $('#payoutcases').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='" + base_url + "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");

                    $('#loadmoreajaxloader').text('No More Results');
                }
                $('.' + page).addClass('active');
                $('#imageloder').hide();
                addCommasToListing();
            }
        });
    }
    $('#total_count').text('(' + "<?= $total_count ?>" + ')');
    $('#searchbyval').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $('#search').trigger('click');
        }
    });
    function addCommasToListing() {
        $("#payoutcases").find(".payout_amount_commas").each(function () {
            var id = $(this).attr('id');
            var val = $("." + id).text();
            var val_Comma = addCommased(val, id, '', '1');
            $("." + id).html("");
            $("." + id).html(val_Comma);
        })
    }
      document.getElementById('searchform').addEventListener('keypress', function(event) {
              if (event.keyCode == 13) {
                  $("#search").click();
              }
          });
</script>
