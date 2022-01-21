<div id="refurb_case_div" class="">
    <div class="cont-spc pad-all-20" id="buyer-lead">
        <form id="search_form" name="search_form" method="post" class="" role="form">
            <input type="hidden" id="source" name="source" value="4">
            <input type="hidden" id="page" name="page" value="1">
            <div class="row">
                <div class="col-md-3 pad-R0">
                    <label for="" class="crm-label">Search By</label>
                    <div class="select-box" style="width:80px"><span id="payment_select">Select</span> <span class="d-arrow d-arrow-new"></span></div>
                    <ul class="drop-menu">
                        <li><a href="javascript:" onclick="searchby(this)" id="searchrto">RTO Slip No</a></li>
                        <li><a href="javascript:" onclick="searchby(this)" id="searchpayid">Payment ID</a></li> 
                        <li><a href="javascript:" onclick="searchby(this)" id="searchcustname">Customer Name</a></li>
                        <li><a href="javascript:" onclick="searchby(this)" id="searchinst">Instrument No</a></li>
                        <li><a href="javascript:" onclick="searchby(this)" id="searchreg">Reg No</a></li>
                    </ul>
                    <div id="dropD">
                        <input type="text"  name="keyword" id="keyword" style="display:block!important" class="form-control crm-form drop-form abc2" readonly="readonly">
                    </div>
                    <input type="hidden" name="searchby" id="searchby" value="">                                 
                </div>   
                <div class="col-md-2 pad-R0  form-group">
                    <label for="" class="crm-label">RTO Agent</label>
                    <select class="form-control crm-form" name="agentrto" id="agentrtopay">
                        <option value="0">Select</option>
                        <?php foreach ($rtoList as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="d-arrow"></span>
                </div>
                <div class="col-md-3 mrg-L15" style="padding-right:-20px !important;">
                    <label class="crm-label row">Date Of Payment</label>
                    <div class="row">                           
                        <div class="col-md-6 new_lead pad-all-0">
                            <input type="hidden" name="searchdate" id="searchdate" value=""> 
                            <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From"> 
                            </div>
                        </div>
                        <div class="col-md-6 new_lead pad-all-0">
                            <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                <input type="text" name="daterange_from" id="daterange_from" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To"> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 pad-R0">
                    <span>
                        <a class="btn-save btn-save-new" onclick="searchList();" id="searchb">SEARCH</a>
                        <a onclick="resetSearch();" class="mrg-L10 used__car-reset-btn">RESET</a>
                    </span>
                </div>

            </div>
        </form>
    </div>
    <div class="list_div">
        <div class="background-ef-tab mrg-T20" id="loandetails">
            <div class="tabs loandetails">
                <div class="row pad-all-20">
                    <div class="col-md-6">
                        <h5 class="cases font-20"> RC Payment <span id="total_count">(<?= $total_count; ?>)</span></h5>
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
                                            <table class="table table-bordered table-striped table-hover enquiry-table mytbl font-13">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Payment ID</th>
                                                        <th width="10%">RTO Agent</th>
                                                        <th width="10%">Amount</th>
                                                        <th width="10%">Date Of Payment</th>
                                                        <th width="10%">Payment Mode</th>
                                                        <th width="10%">Instrument Date</th>
                                                        <th width="10%">Instrument Number</th>
                                                        <th width="10%">Bank Name</th>
                                                        <th width="10%">Remarks</th>
                                                        <th width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="payment_listing">
                                                    <?php 
                                                    if(!empty($rcPayment)){ 
                                                      foreach ($rcPayment as $payment) { ?>
                                                        <tr class="hover-section">
                                                            <td><?= $payment['payment_rnd_id']; ?></td>
                                                            <td><?= $payment['rto_name'] ?></td>
                                                            <td>

                                                                <div class="" id="amount_<?= $payment['id']; ?>"><i class="fa fa-rupee"></i> <span class="amount_<?= $payment['id']; ?>"><?= indian_currency_form($payment['amount']); ?></span></div>
                                                            </td>
                                                            <td>
                                                                <?= !empty($payment['paydates']) ? date('d M, Y', strtotime($payment['paydates'])) : "" ?>
                                                            </td>
                                                            <td><?= PAYMENT_MODE[$payment['payment_mode']]; ?></td>
                                                            <td>
                                                                <?= !empty($payment['instrument_date']) && $payment['instrument_date'] != "0000-00-00" ? date('d M, Y', strtotime($payment['instrument_date'])) : "" ?>
                                                            </td>
                                                            <td><?= $payment['instrument_no']; ?></td>
                                                            <td><?= $payment['bank_name']; ?></td>
                                                            <td><?= $payment['remark']; ?></td>
                                                            <td>
                                                                <?php $link = base_url('rc_make_payment/') . base64_encode('rcpay_' . $payment['id']);
                                                                ?>
                                                                <a class="btn btn-default font-11" href="<?= $link ?>"> Edit Payment </a>                                               
                                                            </td>
                                                        </tr>

                                                    <?php } ?>
                                                    <tr><td colspan="11" style="text-align: center !important;">
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
                                                                                ?>
                                                                                <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>
                                                                                    <?php
                                                                                    for ($i = $page + 1; $i <= $total_pages; $i++) {
                                                                                        ?>
                                                                                    <li class="<?= $i ?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                                                                    <?php
                                                                                    if ($i >= $page + 3) {
                                                                                        break;
                                                                                    }
                                                                                }
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
                                                    <?php }?>     
                                                        </td></tr>
                                                    <?php }?>
                                                    <?php if (empty($rcPayment)) {
                                                        echo "<tr><td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='" . base_url() . "assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
                                                    }
                                                    ?>   
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
<script>
    var date = new Date();
    var d = new Date();
    d.setDate(date.getDate());
    function addCommastoList() {
        $("#payment_listing").find(".commastoamount").each(function () {
            var id = $(this).attr('id');
            var val = $("#" + id).text();
            var val_Comma = convertToIndianCurrency(val, id, '', '1');
            $("." + id).html("");
            $("." + id).html(val_Comma);
        })
    }
    function pagination(page) {
        $("#page").val(page);
        $("#payment_listing").html('');
        var start = $('#page').val();
        start++;
        $.ajax({
            url: base_url+"RcCase/ajax_getrc/3",
            type: 'post',
            dataType: 'html',
            data: $("#search_form").serialize(),
            success: function (responseData, status, XMLHttpRequest) {
            var html = $.trim(responseData);
            $('#page').attr('value', start);
            $('#payment_listing').html(html);
             footerBottom();
            $(window).scrollTop(0);
          }
        });
    }
    
    $(document).ready(function () {
        //alert('hiii');
        addCommastoList();
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
    });
    function resetSearch() {
       // window.location.href = base_url + "rcListing/2";
        getListHtml(4);
    }
    function convertToIndianCurrency(nStr, control, flag = '', flag1 = '')
    {
        if (flag == 1) {
            nStr = nStr.replace(/,/g, '');
        } else
        {
            nStr = nStr;
        }
        x = nStr.toString();
        var afterPoint = '';
        if (x.indexOf('.') > 0)
            afterPoint = x.substring(x.indexOf('.'), x.length);
        x = Math.floor(x);
        x = x.toString();
        var lastThree = x.substring(x.length - 3);
        var otherNumbers = x.substring(0, x.length - 3);
        if (otherNumbers != '')
            lastThree = ',' + lastThree;
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
        if (flag1 == 1)
            return res;
        else
            document.getElementById(control).value = res;
    }
    $('#keyword').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
       searchList();
    }
});
</script>