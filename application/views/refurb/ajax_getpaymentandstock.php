<?php setlocale(LC_MONETARY, 'en_IN'); if(intval($source) == 1) {
 ?>
<style>
   #popover-content-logout > * {background-color:#ff0000 !important;}
                .popover{max-width: 400px}
</style>
<div class="col-lg-12 col-md-12 mrgBatM clearfix pad-R15 pad-L15" id="topSection">
   <div class="background-efOne background-efTwo bgImgN">
      <div class="row">
         <div class="col-md-12">
            <div class="total-lead-recieved clearfix">
               <ul class="mrg-all-0 pad-all-0">
                  <li class="pull-left font-16 col-black-o">Payment Summary</li>
               </ul>
            </div>
         </div>
         <div class=" col-md-12 total-lead-digit">
            <div class="row mrg-all-0">
               <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                   <a href="javascript:void(0);">
                     <p class="font-36 col-green"><span class="font-18"> ₹ </span> <span id="purchaseamt"><?= !empty($summary['total_amount'])?($summary['total_amount']):'0' ?></span></p>
                     <p class="font-18 col-black-o">Total Refurb Cost</p>
                  </a>
               </div>
               <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                  <a href="javascript:void(0);">
                     <p class="font-36 col-yellow"><span class="font-18"> ₹ </span>  <span id="amtPaid"><?= !empty($summary['total_pay'])?($summary['total_pay']):'0' ?></span></p>
                     <p class="font-18 col-black-o">Amount Paid</p>
                  </a>
               </div>
               <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                  <a href="javascript:void(0);">
                     <p class="font-36 col-red"><span class="font-18"> ₹ </span>   <span id="leftPaid"><?= !empty($summary['payment_due'])?($summary['payment_due']):'0' ?></span></p>
                     <p class="font-18 col-black-o">Left Amount</p>
                  </a>
               </div> 
            </div>
         </div>
      </div>
   </div>
</div>

<div class="list_div col-md-12">
<div class="background-ef-tab mrg-T20" id="loandetails">
  <div class="tabs loandetails">
   
<div class="cont-spc pad-all-20" id="buyer-lead">
    <form id="payment_search_form" name="payment_search_form" method="post">
      <input type="hidden" id="source" name="source" value="1" />
      <input type="hidden" id="page" name="page" value="1" />
      <input type="hidden" id="w_id" name="w_id" value="<?= !empty($workshop)?$workshop:""; ?>"/>
      <div class="row">
         
        <div class="col-md-3 pad-R5">
                                <label for="" class="crm-label">Search By</label>
                                    <div class="select-box" style="width:80px">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu">
                                       <li><a onclick="searchby('payment')" id="searchpaymentid">Payment ID</a></li>
                                       <li><a onclick="searchby('make')" id="searchmake">Make</a></li>
                                       <li><a onclick="searchby('model')" id="searchmobile">Model</a></li>
                                       <li><a onclick="searchby('instrument')" id="searchinstrument">Instrument No</a></li>
                                       <li><a onclick="searchby('regno')" id="searchreg">Reg no</a></li>
                                    </ul>
                                 <!-- /btn-group -->                                                  
                                 <div id="dropD">
                                     <input type="text" readonly="readonly" name="keyword" id="keyword" class="form-control crm-form drop-form abc4" style="display:block">
                                 </div>
                                 <input type="hidden" name="searchby" id="searchby" value="">
                              </div>
 
        
         <div class="col-md-6 pad-R0" id="caldate77">
                                 <label class="form-label">Payment Date</label>
                                 <div class="row">
                                    <div class="col-md-3 pad-R2">
                                       <div class="date input-append demo" id="reservation_follow_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                           <input type="text" name="startpaymentdate" id="payment_daterange_to" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd/mm/yyyy" readonly> 
                                       </div>
                                    </div>
                                    <div class="col-md-3 pad-L2">
                                       <div class="date input-append demo" id="reservation_follow_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                           <input type="text" name="endpaymentdate" id="payment_daterange_from" class="form-control customize-form add-on  icon-cal1 pad-L8" placeholder="To" data-date-format="dd/mm/yyyy" readonly> 
                                       </div>
                                    </div>
                                 </div>
                              </div>

        <div class="col-md-2 pad-R0">
          <span>
              <a class="btn-save btn-save-new" onclick="getPaymentDetail();" id="searchb">SEARCH</a>
              <a onclick="getResetPaymentFilter();" class="mrg-L10 used__car-reset-btn">RESET</a>
          </span>
        </div>

      </div>
    </form>
  </div>
       <div class="row pad-all-20">
      <div class="col-md-6">
        <h5 class="cases"> Payment History </h5>
      </div>
      <div class="col-md-6" style="text-align: right">
      <button class="btn btn-save btn-save-new" data-toggle="modal" data-target="#makePayment" onclick="makePayment('',<?=!empty($paymentDetails[0]['wc_id'])?$paymentDetails[0]['wc_id']:$workshop?>,'1','payment_details_1')" >Add Payment</button>
      </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active tabn" id="finalized">

      </div>
    </div>
  </div>
</div>
</div>
 
                                       
                                      
                                      </div>
<?php } else if(intval($source) == 2) { ?>
<?php if(!$is_search){ ?>
  <div class="cont-spc pad-all-20" id="buyer-lead">
    <form id="search_form" name="search_form" method="post" class="" role="form">
      <input type="hidden" id="source" name="source" value="2" />
      <input type="hidden" id="page" name="page" value="1" />
      <div class="row">
         
        <div class="col-md-2 pad-R0">
            <label for="" class="crm-label">Search By Workshop/Mobile</label>
            <input type="text" class="form-control" name="search_by" id="search_by" value="">
        </div>

        <div class="col-md-2 pad-R0">
          <label for="" class="crm-label">Min Payment Due</label>
          <input type="text" class="form-control" name="min_payment" id="min_payment" value="">
        </div>

        <div class="col-md-2 pad-R0">
          <span>
              <a class="btn-save btn-save-new" onclick="searchList();">SEARCH</a>
              <a onclick="resetSearch();" class="mrg-L10 used__car-reset-btn">RESET</a>
          </span>
        </div>

      </div>
    </form>
  </div>
<?php } ?>
<div class="list_div">
<div class="background-ef-tab mrg-T20" id="loandetails">
  <div class="tabs loandetails">
    <div class="row pad-all-20">
      <div class="col-md-6">
        <h5 class="cases"> Workshop Cases (<span><?php echo $totalCount; ?></span>)</h5>
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
                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                     <thead>
                        <tr>
                           <th width="30%">Workshop Details</th>
                           <th width="20%">Stock In Workshop</th>
                           <th width="30%">Payment Due</th>
                           <th width="20%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($caseList) > 0) { ?>
                        <?php foreach($caseList as $index => $indexItem){ ?>
                        <tr>
                          <td>
                            <div class="mrg-B5"><b><?php echo $indexItem['name'];?></b>  </div>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14"><?php echo !empty($indexItem['mobile']) ? $indexItem['mobile'] :'';?></span>
                            </div>
                          </td>
                          <td>
                            
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               Currently <?php echo $indexItem['pending']; ?> cars in workshop<br/>
                               ( Total <?php echo $indexItem['total']; ?> cars till date )
                              </span>
                            </div>
                          </td>
                          <td>
                            <?php echo $indexItem['payment_due'];//(intval($indexItem['total_amount']) - intval($indexItem['total_pay']));?>
                          </td>
                          <td>
                            <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment(<?php echo $indexItem['id'];?>)" >Make Payment</button>
                            <button class="btn btn-default" onclick="workDetails(<?php echo $indexItem['id'];?>)">Workshop Details</button>
                            
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                          <tr>
                            <td align='center' colspan='4'><div class='text-center pad-T30 pad-B30'><img src='<?php echo base_url('assets/admin_assets/images/NoRecordFound.png'); ?>'></div>
                            </td>
                          </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                </div>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if(intval($totalCount) > 0){ ?>
      <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
           <nav aria-label="Page navigation">
              <ul class="pagination customePagination" >
                <?php
                  $total_pages  = ceil($totalCount / $limit);  
                  $pagLink      = "";

                  if ($total_pages < 1)
                  {
                      $total_pages = 1;
                  }

                  if ($total_pages != 1)
                  {
                    //this is for previous button
                    if (intval($page) > 1)
                    {
                        $prePage = intval($page) - 1;
                        $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="pagination('.$prePage.');"><a class="page-link" aria-label="Previou"><span aria-hidden="true"><img src="'.base_url().'assets/admin_assets/images/pagination-left.png" ></span>
                          <span class="sr-only">Previous</span></a></li>';
                        //this for loop will print pages which come before the current page
                        for ($i = $page - 6; $i < $page; $i++)
                        {
                            if ($i > 0)
                            {
                                $pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
                            }
                        }
                    }

                    //this is the current page
                    $pagLink .= "<li class='page-item active'><a class='page-link' >".$page."</a></li>";  

                    //this will print pages which will come after current page
                    for ($i = $page + 1; $i <= $total_pages; $i++)
                    {
                        $pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 

                        if ($i >= $page + 3)
                        {
                            break;
                        }
                    }

                    // this is for next button
                    if ($page != $total_pages)
                    {
                        $nextPage = intval($page) + 1;
                        $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="pagination('.$nextPage.');"><a class="page-link" aria-label="Next"><span aria-hidden="true"><img src="'.base_url().'assets/admin_assets/images/pagination-right.png" ></span>
                          <span class="sr-only">Next</span></a></li>';
                    }
                  }
                  
                  echo $pagLink; 
                ?>
              </ul>
           </nav>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
</div>
<?php } ?>               
              
<script src="<?=base_url('assets/js/bootstrap-datepicker.js')?>"></script> 
<script type="text/javascript">
$(document).ready(function(){
   $('body').on('click',function(){
                $('.drop-menu').hide();
            });
            $('.select-box').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).next().show();
            });
            $('.drop-menu li a').click(function(){
                var getText = $(this).text();
                $(this).parents('.drop-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
            });
              
  getPaymentDetail();  
});


function getPaymentDetail(){
    $('.loaderClas').show();
    $("#finalized").html("");
    var searchby = $("#searchby").val();
    var keyword = $.trim($("#keyword").val());
    if(searchby != "" && keyword == ""){
      alert("Keyword should not be blank");
      return false;
    }
    var data = $("#payment_search_form").serialize();
    $.ajax({
      url: base_url+"refurb/ajax_paymentDetails",
      type: 'post',
      dataType: 'html',
      data: data,
      success: function(response)
      {
        $("#finalized").html(response);
        $('.loaderClas').hide();
}

    });
    }
    
    function searchby(searchByValue = '')
{
    $('#keyword').attr('readonly', false);
    if (searchByValue != '')
    {
        $('#searchby').val(searchByValue);
        if (searchByValue == 'payment')
        {
            $('#keyword').attr('onkeypress', 'return isNumberKey(event)');
            $('#keyword').attr('maxlength', '10');
        } else if (searchByValue == 'regno')
        {
            $('#keyword').attr('onkeypress', '');
            $('#keyword').attr('maxlength', '10');
        }
        $('#keyword').removeAttr('disabled');
}
}
    
    function getResetPaymentFilter(){
       $("#searchby").val("");
       $("#keyword").val("");
       $("#keyword").attr('readonly', true);
       $("#payment_daterange_to").val("");
       $("payment_daterange_from").val("");
       if ($(".select-box").length > 0){
       $(".select-box").html('Select <span class="d-arrow d-arrow-new"></span>');
       }
       getPaymentDetail(); 
    }
        
          var date = new Date();
var d = new Date();        
d.setDate(date.getDate());
          var dates =  $('#payment_daterange_to').val();      
            $("#payment_daterange_to").datepicker({
                format: 'dd-mm-yyyy',
                endDate: d,
                autoclose: true
           }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('#payment_daterange_from').datepicker('setStartDate', startDate);
           }).on('clearDate', function (selected) {
               $('#payment_daterange_from').datepicker('setStartDate', null);
           });
           $("#payment_daterange_from").datepicker({
                format: 'dd-mm-yyyy',
                endDate: d
           });
           
      
</script>


    