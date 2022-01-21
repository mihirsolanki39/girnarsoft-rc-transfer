<?php //echo APPPATH."third_party/dompdf/dompdf_config.inc.php";?>
<?php $teamn = !empty($this->session->userdata['userinfo']['team_name'])?$this->session->userdata['userinfo']['team_name']:'';?>
<div id="content">
<div class="container-fluid mrg-all-20">
   <div class="row">
      <div class="">
         <div class="cont-spc pad-all-20" id="buyer-lead">
             <form role="form" name="searchform" id="searchform" url="<?= base_url('DeliveryOrder/ajax_getdelivery')?>" method="post">
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Search By</label>
                                    <div class="select-box" style="width:80px">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu">
                                       <li><a href="#" onclick="searchby(this)" id="searchcustname">Customer Name</a></li>
                                        <li><a href="#" onclick="searchby(this)" id="searchdealername"> Dealer</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="searchmobile">Mobile Number</a></li>
                                       <li><a href="#" onclick="searchby(this)" id="doid">DO Id</a></li>
                                    </ul>
                                 <!-- /btn-group -->
                                 <div id="dropD">
                                     <input type="text"  name="keyword" id="keyword" class="form-control crm-form drop-form abcs" readonly="readonly">
                                 <select name="keywordbyd" id="keyword" class="form-control crm-form drop-form abc1" style="display: none;"><option value="">Select Dealer</option></select>
                                 <select name="keywordbyIns" id="keyword" class="form-control crm-form drop-form abc2" style="display: none;"><option value="">Select Company</option></select>
                                 </div>
                                 <input type="hidden" name="searchby" id="searchby" value="">
                     </div>
                     <div class="col-md-1 pad-R0">
                        <label for="" class="crm-label">Showroom</label>
                              <select class="form-control crm-form testselect1" name="showroom" id="showroom">
                                 <option value="">Select</option>
                                            <?php foreach ($showroomList as $key=>$value){ ?>
                                            <option value="<?=$value['id']?>"  <?php echo !empty($orderinfo) && $orderinfo['showroomName']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['organization']?></option>
                                        <?php } ?>
                              </select>
                               <!--<span class="d-arrow"></span>-->
                     </div>
                     <div class="col-md-1 pad-R0">
                        <label for="" class="crm-label">Sales Exec.</label>
                              <select class="form-control crm-form testselect1" name="salesex" id="salesex">
                                 <option value="">Select</option>
                                 <?php foreach ($employeeList as $key=>$value){ ?>
                                <option value="<?=$value['id']?>" <?php echo !empty($orderinfo) && $orderinfo['deliverySales']==$value['id'] ? 'selected=selected' : ''; ?>><?=$value['name']?></option>
                                <?php } ?>
                              </select>
                              <!--<span class="d-arrow"></span>-->
                     </div>
                     <div class="col-md-1 pad-R0">
                        <label for="" class="crm-label">Status</label>
                              <select class="form-control crm-form" name="doStatus" id="doStatus">
                                 <option selected="selected" value="">Select</option>
                                 <option value="1" >DO generated</option>
                                 <option value="2" >Payment Completed</option>
                                  <!--<option value="2" >Payment Received</option>
                                 <option value="3" >Cancelled DO</option> -->
                              </select>
                               <span class="d-arrow"></span>
                     </div>
                     <div class="col-md-4 pad-R0">
                        <label class="crm-label">Date Type</label>
                        <div class="row">
                           <div class="col-md-3 pad-R0 mrg-R12">
                                 <div class="select-box">Select <span class="d-arrow d-arrow-new"></span></div>
                                    <ul class="drop-menu drop-menu-1">
                                       <li><a href="#" onclick="searchby('',this)" id="deliverydate">Delivery date</a></li>
                                       <li><a href="#" onclick="searchby('',this)" id="dodate">DO date</a></li>
                                      <!--  <li><a href="#" onclick="searchby('',this)" id="receiptdate">Receipt Date</a></li> -->
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
                            <input type="hidden" name="dodashId" id="dodashId" value="<?php echo (!empty($doId)) ? $doId:'';?>">
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
                     <h5 class="cases">Delivery Order Cases<span id="total_count"> (<?=$total_count?>)</span></h5>
                   </div>
                  <?php if(!empty($teamn) && ($teamn!='Sales') || ($teamn=='')){?>
                   <div class="col-md-6">
                     <a id="DOExport" href="JavaScript:void(0)" class="pull-right mrg-L10 mrg-T10 pad-L15">DOWNLOAD EXCEL</a>  
                     <a href="<?php echo base_url('loanDoInfo')?>" target="_blank"> <button class="btn-success pull-right">ADD CASE</button></a>
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
                                             <th width="5%">DO ID</th>
                                             <th width="15%">Customer Details</th>
                                             <th width="20%">Car Details</th>
                                             <th width="15%">Source Details</th>
                                             <th width="25%">Showroom Details</th>
                                             <th width="15%">Case Update</th>
                                             <th width="15%">Downloads</th>
                                             <th width="15%">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody  id="buyer_list">
                                    <?php
//echo "####@@@@@"; 
if(!empty($query['leads'])){
   // echo "<PRE>";
//print_r($query['leads']); exit;
    foreach ($query['leads'] as $key=>$val){
$link='';        
 if(empty($link)){
$link=!empty($val["paymentType"])? base_url('loanDoInfo/').base64_encode('OrderId_'.$val["orderId"]):'';
}
if(empty($link)){
$link = !empty($val["deliverySource"])? base_url('loanDoInfo/').base64_encode('OrderId_'.$val["orderId"]) :'';
}
if(empty($link)){
$link =base_url('loanDoInfo');    
}
?>
<tr class="hover-section" >
<td style="position:relative">
<div class="mrg-B5"><span class=""><?php echo (!empty($val['orderId'])) ?$val['orderId']: '';?></span></div>
</td>
            <td style="position:relative">
            <div class="mrg-B5"><b><?php echo (($val['customer_name'] != '') ? ucwords(strtolower($val['customer_name'])) : 'NA'); ?></b></div>
            <div class="font-13 text-gray-customer"><span class="font-14"><?php echo $val['customer_mobile_no']; ?></span></div>
        </td>
        <td style="position:relative">
            
            <?php $make  = !empty($val['parent_makeName'])?$val['parent_makeName']:$val['makeName'];
            $model = !empty($val['parent_modelName'])?$val['parent_modelName']:$val['modelName'];
          // echo "<pre>";print_r($val);die;
             if(!empty($make)){?>
                <div class="mrg-B5"><b><?php echo (!empty($val['color'])) ? $val['color'].'  '.$make.'  '.$model.' '.$val['versionName'] :''?></b></div> 
                <div class="font-13 text-gray-customer"><span class="font-14"><?php echo ($val['financer_name']) ? 'HP - '.strtoupper($val['financer_name']):'';?></span></div>
               <div class="font-13 text-gray-customer"><span class="font-14"><?php //echo ($val['booking_date']) ? 'Booking Date: '.$val['booking_date']:'--';?></span></div>
            <?php } ?>
        </td>

        <td style="position:relative">
          <?php if(!empty($val['source'])) {?> 
          <div class="mrg-B5"><b><?php echo (!empty($val['source'])) ? 'Source - '.$val['source']:'';?></b></div>   
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['dealer_name']) && ($val['source']=='Dealer')) ? 'Dealer Name - '.$val['dealer_name']:'';?></span></div>  
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['sales_exe'])) ? 'Sales Executive - '.$val['sales_exe'] : '';?></span></div>
          <?php } else {?>
          <div class="mrg-B5"><b>NA</b></div>
          <?php } ?>
        </td>


        <td style="position:relative">
          <?php if($val['dealerName']) {?>  
          <div class="mrg-B5"><b><?php echo (!empty($val['dealerName'])) ? 'Showroom - '.$val['dealerName']:'';?></b></div>  
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['do_amt'])) ? 'DO Amt - <i class="fa fa-rupee"></i> '.$val['do_amt'] : '';?></span></div>
          <div class="font-13 text-gray-customer"><span class="font-14"><?php echo (!empty($val['delivery_date'])) ? 'Delivery date : '. $val['delivery_date']: '';?></span></div>
          <?php } else {?>
          <div class="mrg-B5"><b>NA</b></div>
          <?php } ?>
        </td>
       <td style="position:relative">
         <?php
         $doStatus='';
         $doDate='';
          $dosStatus = '';
          $cancelReason =  '';
         // echo "<pre>";
         // print_r($val);
         // exit;
          if(($val['do_updated_status']=='1') && ($val['cancel_id']==0)){
            $doStatus ='DO generated'; 
          }else if($val['do_updated_status']=='2' && $val['cancel_id']==0){
            $doStatus = 'Payment Completed ';
          }else if($val['cancel_id']!=0){
            $doStatus = 'Cancelled';
          }
         if($val['last_updated_status']=='1'){
             if($val['loan_taken_from']=='1' && $val['loan_filled']=='2'){
              $dosStatus='Loan Pending';
             //$doStatus='DO generated';   
             }else{
            // $doStatus='DO generated';
             }
             //$doDate=$val['last_updated_date'];
             $doDate=$val['do_date'];
         }elseif($val['last_updated_status']=='2'){
             if($val['loan_taken_from']=='1' && $val['loan_filled']=='2'){
              $dosStatus='Loan Pending';
              //$doStatus='Payment Received';   
             }else{
             //$doStatus='Payment Received';
             }
            
             if($val['loan_taken']=='1' && $val['loan_filled']=='2'){
              //$dosStatus='Loan Pending';
              //$doStatus='Pending';   
             }
             $doDate=$val['do_date'];
         }
         if(!empty($val['cancel_id']))
         {
            //$doStatus='Cancelled';
            $dosStatus ='';
            $cancelReason = $val['reason'];
            if($val['cancel_id']=='1')
            {
              $cancelReason = ucwords(strtolower($val['other_reason']));
            }
            $doDate ='';
         }
         //echo $doStatus; exit;
        ?>  
         <div class="mrg-B5"><b><?php echo (!empty($doStatus)) ? 'Status - '.$doStatus : '';?></b></div>
         <div class="font-14 text-gray-customer"><?php echo (!empty($doDate)) ? 'DO Date- '.$doDate:'';?></div>
          <div class="font-14 text-gray-customer"><?php echo (!empty($cancelReason)) ? 'Cancel Reason - '.$cancelReason:'';?></div>
         <?php if(!empty($dosStatus)){ ?>
          
          <div class="arrow-details alert-btn">
                                                            <span class="font-10"><?=$dosStatus?></span>
                                                         </div>
        <?php  } ?>
       </td>

     
       <td style="position:relative">  
        <a class="adownl" style="cursor: pointer;" onclick="downloadFile('<?php echo $val['orderId']; ?>')" data-toggle="tooltip" data-placement="left" title="Download Delivery Order Detailed PDF"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
       </td>
      
       
        <td class="td-action" style="position:relative">
            <a href="<?php echo $link;?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                </br>
               <?  if(empty($val['cancel_id']))
         { ?>
            <button data-target="#booking-done" data-toggle="tooltip" title="generate do" onclick="renderpdfdo(<?php echo $val['orderId']?>,<?php echo DEALER_ID?>);" data-placement="top" class="btn btn-default">GENERATE DO</button> 
            <? } ?>  
            <input type="hidden" name="orderId" id="orderId" value="<?php echo (!empty($val['orderId'])) ? $val['orderId'] : '';?>">
       </td>
       
</tr>

<?php
}?>
<td colspan="7" style="text-align: center !important;">
          <?php if (($total_count) > 0) { ?>
              <div class="col-lg-12 col-md-6">
                  <nav aria-label="Page navigation">
                    <ul class="pagination" >
                      <?php
                        $total_pages = ceil($total_count / $limit);
                        $pagLink = "";
                        if ($total_pages < 1) {
                          $total_pages = 1;
                        }

                        if ($total_pages != 1) {                                                                         //this is for previous button
                          if (intval($page) > 1) {
                            $prePage = intval($page) - 1;
                            $pagLink .= '<li onclick="pagination(' . $prePage . ');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>';
                                              //this for loop will print pages which come before the current page
                             for ($i = $page - 6; $i < $page; $i++) {
                                if ($i > 0) {
                                    $pagLink .= "<li onclick='pagination(" . $i . ");'><a href='#'>" . $i . "</a></li>";
                                }
                            }
                              }
          //this is the current page
                          //  if($i >= $page){
                              //echo ''.$page; exit;
                     $pagLink .= "<li class='active' onclick='pagination(" . $i . ");'><a href='#'>" . $page . "</a></li>";
                  // }
                        //this will print pages which will come after current page
                       for ($i = intval($page) + 1; $i <= $total_pages; $i++) {
                       //$pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='pagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
                       $pagLink .= "<li onclick='pagination(" . $i . ");' ><a href='#'>" . $i . "</a></li>";
                         if ($i >= $page + 3) {
                            break;
                          }
                        }

                          // this is for next button
                         if ($page != $total_pages) {
                        $nextPage = (int)$page + 1;
                         $pagLink .= '<li onclick="pagination(' . $nextPage . ');"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
                        }
                     }
              echo $pagLink;
         ?>                                                                               </ul>
      </nav>
    </div>
    <?php } ?>     
  </td>
<?}else{

echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='".base_url()."assets/admin_assets/images/NoRecordFound.png'></div></td></tr>";
 }
?>
                                    <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                    <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>
                                        </tbody>
                                    </table>
                                 </div>
                                 <div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                                    
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
<script src="<?=base_url('assets/admin_assets/js/order_lead.js')?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>
<script>
 $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  function pagination(page) {
        $("#page").val(page);
        $("#dlist").html('');
        var start = $('#page').val();
        start++;
       // alert(page);
        
        $.ajax({
            url: base_url+"DeliveryOrder/ajax_getdelivery",
            type: 'post',
            dataType: 'html',
            data: {'data': $("#searchform").serialize()},
            success: function (responseData, status, XMLHttpRequest) {
            var html = $.trim(responseData);
            var resr = html.split('####@@@@@');
             //alert(resr[1]);
            //$("#totcnt").text(res[0]);
             //$("#dlist").html(res[1]);
            $('#page').attr('value', start);
            if (parseInt(resr[1]) != 1) {
             // alert('hi');
            $('#buyer_list').html(resr[1]);
            $(window).scrollTop(0);
            }
            else if (parseInt(resr[1]) == 1) {
              //alert('dfdfd');
            start--;
            $('#page').attr('value', start);
             $('#buyer_list').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
         
            $('#loadmoreajaxloader').text('No More Results');
            }
            $('.'+page).addClass('active');
            }
        });
    }
   var date = new Date();
    var d = new Date();        
      d.setDate(date.getDate());
        $(document).ready(function(){
           $('#createStartDate').datepicker({
                  format:"dd/mm/yyyy",
                  endDate: d     
             });
            $('#createEndDate').datepicker({
                  format:"dd/mm/yyyy",
                  //endDate: d     
             });
           
       });
        
        $(document).ready(function(){
           $('.1').addClass(' active');
          $('.abcs').attr('style','display:block');
            $('body').on('click',function(){
                $('.drop-menu').hide();
            });
            $('.select-box').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).next().show();
            });
            $('.drop-menu li a').click(function(){
                $("#keyword").attr("readonly", false);
                $('#keyword').attr('style','display:block;');
                var getText = $(this).text();
                $(this).parents('.drop-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
            });
        });
        $( ".abc1" ).change(function() {
          var va = $(".abc1").val();
          $('#searchbyval').val(va);
        });
        

 $('#total_count').text('('+"<?=$total_count?>"+')');
 $('#keyword').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('#search').click();
    //return false;  
  }
}); 


   $('#DOExport').click(function(){
    //alert('kkkk');
              var input = $("<input>").attr("type", "hidden").attr("name", "export").val("export");
              $('#searchform').append(input);
              $('#searchform').attr('method','post').submit();
      // window.location.href.reload();
    });

   function downloadFile(id){
    $.ajax({
        type: 'POST',
        url: base_url+"DeliveryOrder/downloadPdf",
        data: {id:id},
        dataType:'json',
        beforeSend:function(){
            $('.searchresultloader').show();
             snakbarAlert('Please Wait While PDF Is Getting Downloaded');
        },
        success: function (responseData, status, XMLHttpRequest) {
          console.log(responseData);
            $('#quotes_form_error').text('');
             $('.searchresultloader').hide();
            snakbarAlert(responseData.message);
             if(responseData.status){
               window.location=base_url+"DeliveryOrder/downloadBookingPdf?file="+responseData.file_name; 
             }
            }
        });
   // window.top.location.href = base_url+"deliveryOrder/downloadPdf/" + id; 
}

</script>