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
<div class="container-fluid mrg-all-20">
    <div class="row">
        <h5 class="cases mrg-B20">Refurbishment Cases</h5>
        <ul class="nav nav-tabs">
            <li id="stock_list" class="options <?php if (intval($type) == 1) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Stock Listing</a></li>
            <li id="work_list" class="options <?php if (intval($type) == 2) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Workshop Listing</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active">
                <div id="refurb_case_div" class=""></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="refurbhistory" role="dialog">
    <div class="modal-backdrop fade in" style="height:100%"></div>
    <div class="modal-dialog" style="width: 580px; height:100vh; z-index: 9999;">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Refurb History Details</h4>
            </div>

            <div class="modal-body">
                <div class="timeline_content">
                    <div class="row">
                        <div id="commentInsHistory">
                            <div class="col-sm-12 sidenav">
                                <ul id="history_details_ul" class="par-ul">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="makePayment" role="dialog">
    <div class="modal-backdrop fade in" style="height:100%"></div>
    <div class="modal-dialog" style="width: 1024px; height:100vh; z-index: 9999;">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Make Payment</h4>
            </div>
            <div id="payment_modal"></div>
        </div>
    </div>
</div>

<!--<div class="modal fade" id="makePayment" role="dialog">
  <div class="modal-backdrop fade in" style="height:100%"></div>
  <div class="modal-dialog" style="width: 580px; height:100vh; z-index: 9999;">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
        <h4 class="modal-title">Make Payment</h4>
      </div>
      <div id="payment_modals"></div>
    </div>
  </div>
</div>-->

<div class="loaderClas" style="display:none;"><img class="resultloader" src="/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>

<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript">
<?php if ($type != '') { ?>
        var ttype = '<?php echo $type; ?>';
        getListHtml(ttype);
<?php } ?>

    $(document).ready(function () {
        $('.options').on('click', function () {
            $(".options").removeClass('active');
            $(this).addClass('active');

            if ($(this).attr('id') == 'stock_list') {
                getListHtml(1);
            } else if ($(this).attr('id') == 'work_list') {
                getListHtml(2);
            }
        });
    });
    
    
  $("[data-toggle=popover]").each(function(i, obj) {

    $(this).popover({
      html: true,
      content: function() {
        $('.popover').removeClass('in');
        $('.popover').attr('style','display:none');
        var id = $(this).attr('id')
        return $('#popover-content-' + id).html();
      }
    });

    });

    function getListHtml(source) {
        $('#imageloder').show();
        $.ajax({
            url: base_url + "refurb/ajax_getRefurb",
            type: 'post',
            dataType: 'html',
            data: {'source': source},
            success: function (response)
            {
                $("#refurb_case_div").html(response);
                $('#imageloder').hide();
                if (parseInt(source) == 1) {
                    /*$('#from_date').datepicker({
                     format: 'd-m-yyyy',
                     }).on('changeDate', function (selected) {
                     var minDate = new Date(selected.date.valueOf());
                     $('#to_date').datepicker('setStartDate', minDate);
                     });
                     
                     $('#to_date').datepicker({
                     format: 'd-m-yyyy'
                     }).on('changeDate', function (selected) {
                     var minDate = new Date(selected.date.valueOf());
                     $('#from_date').datepicker('setEndDate', minDate);
                     });*/
                    $('#carStatus').SumoSelect();
                } else if (parseInt(source) == 2) {
                    /*$('#city').SumoSelect({ csvDispCount: 3, search: true, searchText:'Select City' });
                     $('.select-box').SumoSelect(); */
                }
            }
        });
    }

    function searchList() {
        $("#page").val(1);
        $.ajax({
            url: base_url + "refurb/ajax_getRefurb",
            type: 'post',
            dataType: 'html',
            data: {'data': $("#search_form").serialize()},
            success: function (response)
            {
                $(".list_div").html(response);
            }
        });
    }

    function resetSearch() {
        var source = $("#source").val();
        if (source == 1) {
            $("#search_by").val("");
            $("#carStatus")[0].sumo.reload();
            getListHtml(source);
        } else {
            $("#search_bys").val("");
            $("#min_payment").val("");
            getListHtml(source);
        }


    }

    function pagination(page) {
        $("#page").val(page);
        $.ajax({
            url: base_url + "refurb/ajax_getRefurb",
            type: 'post',
            dataType: 'html',
            data: {'data': $("#search_form").serialize()},
            success: function (response)
            {
                $(".list_div").html(response);
                $(window).scrollTop(0);
            }
        });
    }

    function getHistory(car_id) {
        $.ajax({
            url: base_url + "refurb/get_history",
            type: 'post',
            dataType: 'html',
            data: {'car_id': car_id},
            success: function (response)
            {
                $("#history_details_ul").html(response);
            }
        });
    }

    function downloadFile(file) {
        if (file != '') {
            location.href = base_url + 'stock/downloadRefurbPdf?file=' + file;
        }
    }

    function makePayment(w_id='',workshop_id='',flag='',module_new=''){ 
    
    var type = 'edit';
    if(flag!='')
    {
      type = '';
    }
    
    $.ajax({
      url: base_url+"refurb/make_payment",
      type: 'post',
      dataType: 'html',
      data: {'w_id':w_id,type:type,'workshop_id':workshop_id,'module':module_new},
      success: function(response)
      {
        $("#payment_modal").html(response);
        $('#insdates').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          todayHighlight: true   
        });

        $('#paydates').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true   
        });
      }
    });
  }

    function workDetails(workshop_id) {
        location.href = base_url + "workdetails?w_id=" + workshop_id;
    }

    function saveEditData()
    {
        var instrumenttype = $.trim($('#instrumenttypes').val());
        var amount = $.trim($('#amounts').val());
        var paydates = $.trim($('#paydates').val());
        var insno = $.trim($('#insnos').val());
        var insdate = $.trim($('#insdates').val());
        var payment_bank = $.trim($('#payment_banks').val());
        var favouring = $.trim($('#favourings').val());
        var workshop_id = $.trim($('#workshop_id').val());

        var error = 0;
        $(".error").html("");
        if (instrumenttype == '') {
            $("#err_instrumenttypes").html("Please select instrument type.");
            error++;
        }

        if (amount == '') {
            $("#err_amounts").html("Please enter amount.");
            error++;
        }

        if (paydates == '') {
            $("#err_paydate").html("Please select payment date.");
            error++;
        }

//        if (instrumenttype == 'cheque')
//        {
//            if (insno == '') {
//                $("#err_insnos").html("Please enter instrument no.");
//                error++;
//            }
//
//            if (insdate == '') {
//                $("#err_insdates").html("Please select instrument date.");
//                error++;
//            }
//
//            if (payment_bank == '') {
//                $("#err_bank_lists").html("Please select bank name.");
//                error++;
//            }
//
//            if (favouring == '') {
//                $("#err_favourings").html("Please enter favouring.");
//                error++;
//            }
//        }

//        if (instrumenttype == 'dd')
//        {
//            if (insno == '') {
//                $("#err_insnos").html("Please enter instrument no.");
//                error++;
//            }
//
//            if (insdate == '') {
//                $("#err_insdates").html("Please select instrument date.");
//                error++;
//            }
//
//            if (favouring == '') {
//                $("#err_favourings").html("Please enter favouring.");
//                error++;
//            }
//        }
//
//        if (instrumenttype == 'online')
//        {
//            if (insno == '') {
//                $("#err_insnos").html("Please enter instrument no.");
//                error++;
//            }
//        }

        if (error > 0) {
            return false;
        } else {
            $(".loaderClas").show();
            /*$.ajax({
             url: base_url+"refurb/save_payment",
             type: 'post',
             dataType: 'json',
             data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,paydates:paydates,workshop_id:workshop_id},*/
            var formData = $('#editids').serialize();
            $.ajax({
                url: base_url + "refurb/save_payment",
                type: 'post',
                dataType: 'json',
                data: formData,
                success: function (response)
                {
                    $(".loaderClas").hide();
                    if (response.status == 1) {
                        snakbarAlert("Payment has been saved successfully.");
                        setTimeout(function () {
                            $(".close").click();
                        }, 1000);
                    }

                    setTimeout(function () {
                        location.href = base_url + "refurblist?type=2";
                    }, 3000);
                }
            });
        }
    }

    function instrumentType(e)
    {
        var id = $(e).attr('id');
        var insType = $('#' + id).val();
        var ids = id.split('_');

        if (insType == 'cash')
        {
            $('#ins_no').hide();
            $('#ins_date').hide();
            $('#bnk').hide();
            $('#favo').hide();
            $('#insnos').val('');
            $('#insdates').val('');
            $('#payment_banks').val('');
            $('#favourings').val('');
        }

        if (insType == 'cheque')
        {
            $('#ins_no').show();
            $('#ins_date').show();
            $('#bnk').show();
            $('#favo').show();
        }

        if (insType == 'dd')
        {
            $('#ins_no').show();
            $('#ins_date').show();
            $('#bnk').hide();
            $('#favo').show();
            $('#payment_banks').val('');
        }

        if (insType == 'online')
        {
            $('#ins_no').show();
            $('#ins_date').hide();
            $('#bnk').hide();
            $('#favo').hide();
            $('#insdates').val('');
            $('#payment_banks').val('');
            $('#favourings').val('');
        }
    }

    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
      }
      return true;
  } 
  


    function blockSpecialChar(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 44 && k <= 57));
    }

    function alphaOnly(evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
                ((evt.which) ? evt.which : 0));
        if (charCode > 31 && (charCode < 65 || charCode > 90) &&
                (charCode < 97 || charCode > 122)) {
            return false;
        }
        return true;
    }

    function nameOnly(event)
    {
        var inputValue = event.which;
        //alert(inputValue);
        if (!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) {
            event.preventDefault();
            return false;
        }
        // console.log(inputValue);
    }

    function blockAllSpecialChar(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        alert(k);
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || (k >= 44 && k <= 57));
    }
    

    function addCommased(nStr,control,flag='',flag1 ='')
  {
      if(flag==''){
          nStr=nStr.replace(/,/g,''); 
      }else
      {
          nStr=nStr; 
      }
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{2})/;
      var len;
      var x3="";
      len=x1.length;
      if(len>3){
          var par1=len-3;
          
          x3=","+x1.substring(par1,len);
          x1=x1.substring(0,par1);
          
          //alert(x3);
      }
      len=x1.length;
      if(len>=3 && x3!=""){
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      }
      if(flag1 == 1)
          return x1 +x3+x2;
      else
      document.getElementById(control).value=x1 +x3+x2;
  }

    
</script>