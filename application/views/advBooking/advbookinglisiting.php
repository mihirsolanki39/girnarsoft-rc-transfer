<?php
  $urlExplode=explode('/',current_url());
  $url = !empty($urlExplode[5])? ($urlExplode[5]):'';
?>
<div id="content">
<div class="container-fluid mrg-all-20">
   <div class="row">
      <div class="">
         <div class="cont-spc pad-all-20" id="buyer-lead">
               <form id="searchform">
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label" >Search By</label>
                                    <div class="select-box" style="width:80px">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu">
                                       <li><a href="#" onclick="searchby(this)" id="searchcustname">Customer Name</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchmobile">Mobile Number</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchslip">Booking Slip No</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchbooking">Showroom Booking No</a></li>
                                    </ul>
                                 <!-- /btn-group -->
                                 <div id="dropD">
                                 <input type="text"  name="searchbyval" id="searchbyval" class="form-control crm-form drop-form abcd" style="width:57%; display:block;" readonly="readonly" >
                                </div>
                                 <input type="hidden" name="searchby" id="searchby" value="">
                                 
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Showroom</label>
                              <select class="form-control crm-form testselect12" name="showroom" id="showroom">
                                  <option value="">Select</option>
                                 <?php foreach($dealerList as $dky => $dvl){?>
                                 <option value="<?=$dvl['id']?>"><?=ucwords($dvl['organization'])?></option>
                                 <?}?>
                              </select>
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Sales Executive</label>
                              <select class="form-control crm-form testselect1" name="sale_emp" id="sale_emp">
                                 <option value="">Status</option>
                                 <?php foreach($employeeList as $ky => $vl){?>
                                 <option value="<?=$vl['id']?>"><?=ucwords($vl['name'])?></option>
                                 <?}?>
                              </select>
                     </div>
                     <div class="col-md-3 pad-R0">
                        <label class="crm-label">Booking Date</label>
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
                     <div class="col-md-2 pad-R0">
                        <span id="spnsearch">
                            <input type="button" class="btn-save btn-save-new" value="Search" id="search">
                            <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                            <input type="hidden" name="page" id="page" value="1">
                            <input type="hidden" name="dashboard" id="dashboard" value="<?=(!empty($url)?$url:'')?>">
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
                        <h5 class="cases">Advance Booking Cases <span id="total_count">(<?=$total_count?>)</span></h5>
                   </div>
                   <div class="col-md-6">
                     <a href="<?=base_url()?>addadvbooking" target="_blank"> <button class="btn-success pull-right">ADD CASE</button></a>
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
                                            <!-- <th>Loan ID </th>-->
                                             <th width="20%">Customer Details</th>
                                             <th width="20%">Car Details</th>
                                             <th width="25%" >Booking Details</th>
                                             <th width="25%" >Case Details</th>
                                               <th width="10%" >Actions</th>
                                          </tr>
                                       </thead>
                                       <tbody id="loancases">
                                       <? if(!empty($loan_listing))
                                           {
                                               $countArr = array_count_values($loan_list_id);
                                               $dateLable = '';
                                               foreach($loan_listing as $key => $value)
                                               {
                                                  $linkk =$value['link'];
                                                  $datetime = '';
                                                  if (!empty($value['loanid'])) 
                                                  {
                                                     $countmore = (int)$countArr[$value['loanid']]-1;
                                                  }
                                                  
                                                ?>
                                             <tr>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=$value['customer_name']?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['customer_mobile']?></span><br><?=$value['customer_email']?></div>
                                                      <div><span class="text-gray-customer font-13">Added On : <?=$value['created_on']?></span></div>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>
                                                      <?php 
                                                         if(!empty($value['make'])){
                                                         echo (!empty($value['color'])?$value['color'].', ':''). $value['make'].' '.$value['model'].' '.$value['version'];
                                                         }
                                                         else
                                                         {  
                                                            echo "NA";

                                                            }?></b></div>
                                                     <!-- <div class="font-10 text-gray-customer"><span class="font-10">
                                                      <?if(!empty($value['color'])) { echo $value['color']; } ?> </span></div>-->

                                                      <a href="#" data-toggle="modal">
                                                         <div class="arrow-details" >
                                                            <span class="font-10"><?=$value['registration']?></span>
                                                         </div>
                                                      </a>
                                                   </td>
                                                   <td style="position:relative">
                                                   <?php if(!empty($value['showroom'])){?>
                                                      <div class="mrg-B5"><b>Showroom - <?=(!empty($value['showroom'])?$value['showroom']:'NA');?></b></div>
                                                      <div class="font-13 text-gray-customer">Booking Amount  <i class="fa fa-rupee"></i><?=$value['booking_amount']?></div>
                                                      <div ><span class="text-gray-customer font-13">Paid To - <?=$value['amount_paid_to']?></span></div>
                                                      <div><span class="text-gray-customer font-13">Showroom Booking No - <?=(!empty($value['showroom_booking_no'])?$value['showroom_booking_no']:'NA')?></span></div>
                                                       <div><span class="text-gray-customer font-13">Booking Slip No - <?=(!empty($value['booking_slip_no'])?$value['booking_slip_no']:'NA')?></span></div>
                                                      <div><span class="text-gray-customer font-13">Booking Date- <?=(!empty($value['booking_date'])?$value['booking_date']:'NA');?> </span></div><br>
                                                      <?php } else{
                                                         echo "NA";
                                                         }?>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>Source - <?=$value['source']?></b></div>
                                                      <?php if($value['source']=='Dealer'){?>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">Dealer Organization - <?=(!empty($value['dealer_name'])?$value['dealer_name']:'NA');?></span></div><?php } ?>
                                                      <div><span class="text-gray-customer font-13">Sales Executive - <?=$value['emp_name']?></span></div>
                                                   </td>
                                                   <td>
                                                      <div >
                                                        <a href="<?=$linkk?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <?php } ?>
                                          <tr><td colspan="7" style="text-align: center !important;">
    <?php if ((int)$total_count > 0) { ?>

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
                                //this is for previous button
                                if ((int)$page > 1) {

                                    $prePage = (int)$page - 1;
                                    ?>
                                    <li class="<?=$i?>" onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = (int)$page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                          //echo $i; exit;
                                            ?>   
                                            <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                  //  exit;
                                }

                                //this is the current page
                                ?>
                             <!--   <?php echo $page ?></a></li>  -->

                             <li class="active" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>

                                <?php
                                //this will print pages which will come after current page
                                for ($i = (int)$page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li class="<?=$i?>"  onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                    <?php
                                    if ($i >= $page + 3) {
                                        break;
                                    }
                                }
                    
                                // this is for next button
                                if ($page != $total_pages) {
                                    $nextPage = (int)$page + 1;
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
<?php }else{

echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='".base_url()."assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";

 }?>
                                         
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

<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url('assets/js/bookinglisting.js')?>"></script>

<!--add sumo select start -->
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
    $('.testselect1').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<script>
    $('.testselect12').SumoSelect({triggerChangeCombined: true, search: true, searchText: 'Search here.'});
</script>
<!--add sumo select end   -->

<script>
   var date = new Date();
    var d = new Date();        
      d.setDate(date.getDate());
        $(document).ready(function(){
           $('.icon-cal1').datepicker({
         format:'dd-mm-yyyy',
                  endDate: d     
             });
           var type = "<?=$url?>";
           if(type!='')
           {
              //searchLoanCase();
           }
       });
        //loanlisting();
        function searchby(eve='',e='')
        {
            $('#searchbyval').val('');
            if(eve!='')
            {
               var id = $(eve).attr('id');
               $('#searchby').val(id);
               //alert(id);
               if(id=='searchdealer')
               {
                  $('.abcd').removeAttr("readonly");
                  $('.abcd').attr('style','display:block;');
                  dealerList();
               }
               else if(id=='searchcustname')
               {
                  $('#searchbyval').attr('onkeypress','return nameOnly(event)');
                  $('#searchbyval').attr('maxlength','50');
                  $('.abcd').removeAttr("readonly");
                  $('.abcd').attr('style','display:block;');
               }
               else
               {
                  $('#searchbyval').attr('onkeypress','return isNumberKey(event)');
                  $('#searchbyval').attr('maxlength','10');
                 $('.abcd').removeAttr("readonly");
                  $('.abcd').attr('style','display:block;');
                }
            }
            else
            {
               var id = $(e).attr('id');
               $('#searchdate').val(id);
            }
        }
        function loanlisting()
        {
          $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "DeliveryOrder/bookingListingCase/",
           dataType: 'html',
           success: function (response) 
           { 
              $('#loancases').html(response);
            }
           });
        }
   
        
        function reset()
        {
             location. reload(true);
        }
        
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
        });
        $( ".abc1" ).change(function() {
          var va = $(".abc1").val();
          $('#searchbyval').val(va);
        });


        function pagination(page) {
        $("#page").val(page);
        $("#dlist").html('');
        var start = $('#page').val();
        start++;
       // alert(page);
        
        $.ajax({
            url: base_url+"DeliveryOrder/bookingListingCase",
            type: 'post',
            dataType: 'html',
            data: {'data': $("#searchform").serialize()},
            success: function (responseData, status, XMLHttpRequest) {
             // alert(responseData);
            var html = $.trim(responseData);
            var resr = html.split('####@@@@@');
            $('#page').attr('value', start);
            if (parseInt(resr[1]) != 1) {
             $('#loancases').html(''); 
            $('#loancases').html(resr[1]);
            $(window).scrollTop(0);
            }
            else if (parseInt(resr[1]) == 1) {
            start--;
            $('#page').attr('value', start);
             $('#loancases').html(''); 
             $('#loancases').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
         
            //$('#loadmoreajaxloader').text('No More Results');
            }
            $('.'+page).addClass('active');
            }
        });
    }

    $('#searchbyval').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('#search').click();
    //return false;  
  }
}); 
</script>
<script type="text/javascript">
   $('#total_count').text('('+"<?=$total_count?>"+')');
</script>
