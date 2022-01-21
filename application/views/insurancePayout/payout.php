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
</style>
<?php $type = !empty($type) ? $type : 1; ?>
<div class="container-fluid mrg-all-20">
    <div class="row">
        <h5 class="cases mrg-B20">Insurance Payout</h5>
        <ul class="nav nav-tabs">
            <li id="insurance_cases" class="payoutoptions <?php if (intval($type) != 2) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Insurance Issued Cases</a></li>
            <li id="insurance_payout_history" class="payoutoptions <?php if (intval($type) == 2) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Payout History</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active">
                <div id="payout_case_div" class="">
                    <!-- search  -->

                    <!-- end search  -->   

                </div>
            </div>
        </div>
    </div>
</div>

<div class="loaderClas" style="display:none;">
    <img class="resultloader" src="/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        var ttype = "<?= $type ?>";
        var type_id = "<?= !empty($type_id)?$type_id:"" ?>";
        getListHtml(ttype,type_id);
        $('.payoutoptions').on('click', function () {
            $(".payoutoptions").removeClass('active');
            $(this).addClass('active');
            if ($(this).attr('id') == 'insurance_cases') {
                getListHtml(1,type_id);
            } else if ($(this).attr('id') == 'insurance_payout_history') {
                getListHtml(2,type_id);
            }
        });

    });
  
    function getListHtml(source,pay_id="") {
        //alert(source);
        $('#imageloder').show();
        $.ajax({
            url: base_url + "PayoutInsurance/ajax_PayoutList",
            type: 'post',
            dataType: 'html',
            data: {'source': source,keyword:pay_id,searchby:'searchpayout'},
            success: function (response)
            {
                $("#payout_case_div").html(response);
                $('#imageloder').hide();
                if (parseInt(source) == 1) {
                    $('#carStatus').SumoSelect();
                } else if (parseInt(source) == 2) {
                }
               if(pay_id != ""){
                    $("#search_by_text").val(pay_id);
                    $("#search_by_text").attr('readonly',false);
                    $("#payment_search").html("");
                    $("#payment_search").html("Payment Id");
                    $("#insurance_payout_history").addClass("active");
                    $("#insurance_cases").removeClass("active")
                }
            }
        });
    }
    function searchby(eve = '', e = '')
    {
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
                $('.abc4').attr('style', 'display:block;');
                $('.abc1').attr('style', 'display:none;');
                $('.abc2').attr('style', 'display:none;');
                $('.abc3').attr('style', 'display:none;');
            }
        } else
        {
            $("#createStartDate").prop('disabled', false);
            $("#createEndDate").prop('disabled', false);
            var id = $(e).attr('id');
            var date = new Date();
            var d = new Date();
            d.setDate(date.getDate());

            $('.icon-cal1').datepicker('destroy');
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
            $('#searchdate').val(id);
          }
    }
    function reset()
    {
        location.reload();
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