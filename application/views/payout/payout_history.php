<?php
$urlExplode = explode('/', current_url());
$url = !empty($urlExplode[5]) ? ($urlExplode[5]) : '';

if (!$is_search) {
    ?>
    <div class="cont-spc pad-all-20" id="buyer-lead">
        <form id="payout_search_form" name="payout_search_form" method="post">
            <input type="hidden" id="source" name="source" value="2" />
            <div class="row">
                <div class="col-md-2 pad-R0">
                    <label for="" class="crm-label" >Search By</label>
                    <div class="select-box cus-selec" style="width:80px">Select <span class="d-arrow"></span></div>
                    <ul class="drop-menu">
                        <li><a href="#" onclick="searchby(this)" id="searchserialno">Loan S.No.</a></li>
                        <li><a href="#" onclick="searchby(this)" id="searchdealer">Dealership Name</a></li>
                        <li><a href="#" onclick="searchby(this)" id="searchpayout">Payment Id</a></li>
                        <li><a href="#" onclick="searchby(this)" id="searchInstrument">Instrument No</a></li>
                    </ul>
                    <div id="dropD">
                        <input type="text"  name="searchbyval" id="searchbyval" class="form-control crm-form drop-form abc4" style="width:57%; display:block;" readonly="readonly">
                        <select name="searchbyvaldealer" id="searchbyvaldealer" class="form-control crm-form drop-form abc1" style="display: none; width:170px"><option value="">Select Dealership</option></select>
                        <select name="searchbyvalbank" id="searchbyvalbank" class="form-control crm-form drop-form abc3" style="display: none; width:170px"><option value="">Select Bank</option></select>
                    </div>
                    <input type="hidden" name="searchby" id="searchby" value="1">

                </div>
                <div class="col-md-3 pad-R10">
                    <label class="crm-label row">Date Of Payment</label>
                    <div class="row">                           
                        <div class="col-md-3 new_lead pad-all-0" style="width:33%">
                            <input type="hidden" name="searchdate" id="searchdate" value=""> 
                            <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From"> 
                            </div>
                        </div>
                        <div class="col-md-5 new_lead pad-all-0" style="width:33%">
                            <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                <input type="text" name="daterange_from" id="daterange_from" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 pad-R0">
                    <span id="spnsearch">
                        <input type="button" class="btn-save btn-save-new" value="Search" id="payouthistorysearch">
                        <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                        <input type="hidden" name="page" id="page" value="1">
                    </span>
                </div>
            </div>
        </form>
    </div>
<?php } ?>
<div class="container-fluid mrg-T20" >
    <div class="row">
        <div class="background-ef-tab" id="loandetails">
            <div class="row pad-all-20">
                <div class="col-md-6">
                    <h5 class="cases">Payout Cases <span id="total_count">(<?= $total_count ?>)</span></h5>
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
                                        <table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
                                            <thead>
                                                <tr>
                                                    <th width="5%"> Payment ID</th>
                                                    <th width="15%">Dealership Name</th>
                                                    <th width="15%">Amount</th>
                                                    <th width="15%" >Date Of Payment</th>
                                                    <th width="15%" >Payment Mode</th>
                                                    <th width="15%">Instrument Date</th>
                                                    <th width="8%" >Instrument Number</th>
                                                    <th width="8%" >Bank Name</th>
                                                    <th width="8%" >Remark</th>
                                                    <th width="8%" >Download</th>
                                                    <th width="8%" >Action</th>

                                                </tr>
                                            </thead>
                                            <?php //echo "<pre>";print_r($payout_history);die; ?>
                                            <tbody id="payouthistory">
                                                <?php
                                                if (!empty($payout_history)) {
                                                    $countArr = array_count_values($payout_history);
                                                    $dateLable = '';
                                                    foreach ($payout_history as $key => $value) {
                                                        ?>
                                                        <tr class="hover-section">
                                                            <td style="position:relative">
                                                                <div class="mrg-B5"><b><?= !empty($value['payment_id']) ? $value['payment_id'] : "" ?></b></div>
                                                            </td>
                                                            <td style="position:relative">
                                                                <div class="mrg-B5"><b><?= ucwords(strtolower($value['organization'])) ?></b></div>
                                                            </td>
                                                            <td style="position:relative">
                                                                <div class="mrg-B5 history_amount_commas" id="<?=$value['payment_id'] ?>"><b><i class="fa fa-rupee"></i> <span class="<?=$value['payment_id'] ?>"><?= !empty($value['amount']) ? $value['amount'] : "" ?></span></b></div>                                                                    
                                                            <?php if(!empty($value['tds_amount'])){?>
                                                                <div class="mrg-B5 history_amount_commas" id="tds_<?= $value['payment_id'] ?>">TDS - <i class="fa fa-rupee"></i> <span class="tds_<?= $value['payment_id'] ?>"><?= !empty($value['tds_amount']) ? $value['tds_amount'] : "" ?></span></div>                         
                                                            <?php } if(!empty($value['gst_amount'])){ ?>
                                                                <div class="mrg-B5 history_amount_commas" id="gst_<?= $value['payment_id'] ?>">GST - <i class="fa fa-rupee"></i> <span class="gst_<?= $value['payment_id'] ?>"><?= !empty($value['gst_amount']) ? $value['gst_amount'] : "" ?></span></div>                         
                                                            <?php } if (!empty($value['pdd_charge_total'])) { ?>
                                                                <div class="mrg-B5 history_amount_commas" id="pdd_<?= $value['payment_id'] ?>">PDD - <i class="fa fa-rupee"></i> <span class="pdd_<?= $value['payment_id'] ?>"><?= !empty($value['pdd_charge_total']) ? $value['pdd_charge_total'] : "" ?></span></div>                         
                                                            <?php } ?>
                                                            </td>
                                                            <td style="position:relative"> <?= !empty($value['date_time']) ?  date('d M, Y', strtotime($value['payment_date'])): "" ?></td>
                                                            <td style="position:relative"><?= !empty($value['payment_mode']) ? PAYMENT_MODE[$value['payment_mode']] : "" ?> </td>
                                                            <td style="position:relative">
                                                                <div class="mrg-B5"> 
                                                                  <?php if($value['payment_mode'] != 1 && $value['payment_mode'] != 4 && $value['instrument_date'] != "0000-00-00" ){ ?>
                                                                  <?= !empty($value['instrument_date']) ? date('d M, Y', strtotime($value['instrument_date'])): "" ?>
                                                                  <?php } ?>
                                                                </div>
                                                            </td>
                                                            <td style="position:relative">                                                                                                                                                                 
                                                                <div class="mrg-B5"><?= !empty($value['instrument_no']) ? $value['instrument_no'] : "" ?></div>                                                                        
                                                            </td>
                                                            <td style="position:relative">                                                                                                                                                                 
                                                                <div class="mrg-B5"><?= (!empty($value['bank_name']) &&  $value['payment_mode'] == 2) ? $value['bank_name'] : "" ?></div>                                                                        
                                                            </td>
                                                            <td style="position:relative">                                                                                                                                                                 
                                                                <div class="mrg-B5"><?= !empty($value['pay_remark']) ? $value['pay_remark'] : "" ?></div>                                                                        
                                                            </td>
                                                            <td style="position:relative">  
                                                                <a class="adownl" style="cursor: pointer;" onclick="downloadFile('<?php echo $value['payment_id']; ?>')" data-toggle="tooltip" data-placement="left" title="Download Payout"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
                                                            </td>
                                                            <td style="position:relative">  
                                                                <button class="btn btn-default" data-toggle="modal" data-target="#editPayout" onclick="editPayout(<?=$value['payment_id']?>)">Edit Payout</button>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
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
                                                <?php } if(empty($payout_history)){
                                           echo "<tr><td align='center' colspan='9'><div class='text-center pad-T30 pad-B30'><img src='".base_url()."assets/admin_assets/images/NoRecordFound.png'></div></td></tr>"; }?>
                                           <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                           <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>    
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
  <div class="modal fade" id="editPayout" role="dialog">

  <div class="modal-backdrop fade in" style="height:100%"></div>
      <div class="modal-dialog" style="width: 1170px; height:200px;">
        <div class="modal-content" >

          <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
            <h4 class="modal-title">Make Payout</h4>
          </div>
          <div id="edit_payout_modal"></div>
        </div>
    </div>
  </div>
<script src="<?=base_url('assets/admin_assets/js/payoutlisting.js')?>"></script>
<script>
    function addCommastoList(){
         $("#payouthistory").find(".history_amount_commas").each(function(){
                 var id = $(this).attr('id');
                var val = $("."+id).text();  
               var val_Comma = convertToIndianCurrency(val, id,'','1');
                $("."+id).html("");
                $("."+id).html(val_Comma);
            })
    }
       $(document).ready(function(){
           addCommastoList();
        });
    function editPayout(id)
    {
       $('#editPayout').addClass(' in');
       $('#editPayout').attr('style','display:block');
      var type = 'edit';
      var date = new Date();
      var d = new Date();        
      d.setDate(date.getDate());
      $.ajax({
        url: base_url+"Payout/editpayout",
        type: 'post',
        dataType: 'html',
        data: {paymentId:id},
        success: function(response)
        {           
          $("#edit_payout_modal").html(response);
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
          var dealer_id = $("#dealer").val();
           getPendingPayoutCases(dealer_id,'',id);
          
        }
      });
       getCheckedCasesCount();
    }
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
        $("#payouthistory").html('');
        $('#imageloder').show();
        var formDataSearch=$('#payout_search_form').serialize();
        var start = $('#page').val();
        start++;
        $.ajax({
            url: base_url+"Payout/ajax_PayoutList/1",
            type: 'post',
            dataType: 'html',
            data: formDataSearch,
            success: function (responseData, status, XMLHttpRequest) {
            var html = $.trim(responseData);
            $('#page').attr('value', start);
            if (parseInt(html) != 1) {
            $('#payouthistory').html(html);
            $(window).scrollTop(0);
            }
            else if (parseInt(html) == 1) {
            start--;
            $('#page').attr('value', start);
             $('#payouthistory').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
         
            $('#loadmoreajaxloader').text('No More Results');
            }
            $('.'+page).addClass('active');
            $('#imageloder').hide();
             addCommastoList();
            }
           
        });
    }
      function convertToIndianCurrency(nStr,control,flag='',flag1 ='')
  {
        if(flag==1){
            nStr=nStr.replace(/,/g,''); 
        }else
        {
            nStr=nStr; 
        }     
        x=nStr.toString();
        var afterPoint = '';
        if(x.indexOf('.') > 0)
           afterPoint = x.substring(x.indexOf('.'),x.length);
        x = Math.floor(x);
        x=x.toString();
        var lastThree = x.substring(x.length-3);
        var otherNumbers = x.substring(0,x.length-3);
        if(otherNumbers != '')
            lastThree = ',' + lastThree;
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
         if(flag1 == 1)
            return res;
        else
            document.getElementById(control).value=res;
  }
  function dealerList()
        {
           $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "Finance/getDealerList/",
           dataType: 'html',
           data:{status:'1'},
           success: function (response) 
           { 
              $('.abc4').attr('style','display:none;');
              $('.abc1').attr('style','display:block;');
              $('.abc1').html(response);

           }
           });
        }
        
</script>