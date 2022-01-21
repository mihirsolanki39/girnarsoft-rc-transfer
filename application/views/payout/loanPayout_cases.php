<script src="<?php echo base_url(); ?>assets/js/finance_lead_detail.js" type="text/javascript"></script>
<?php
  $urlExplode=explode('/',current_url());
  $url = !empty($urlExplode[5])? ($urlExplode[5]):'';
  
?><?php $this->load->view ('payout/loanPayout_search', $loan_listing); ?>
<div class="container-fluid mrg-T20" >
   <div class="row">
      <div class="">
         <div class="background-ef-tab" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                     <h5 class="cases">Loan Cases <span id="total_count">(<?=$total_count?>)</span></h5>
                   </div>
                   <?php if(($rolemgmt[0]['role_name']=='admin') || ($rolemgmt[0]['role_name']=='Accountant')){ ?>
                   <div class="col-md-6">
                     <button class="btn btn-default pull-right" data-toggle="modal" data-target="#makePayout" onclick="makePayout()">Make Payout</button>
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
                                             <th width="8%" >Payout Status</th>
                                          </tr>
                                       </thead>
                                       <tbody id="payoutcases">
                                        <?php 
           if(!empty($loan_listing))
           {
               $countArr = array_count_values($loan_list_id);
               $dateLable = '';
               foreach($loan_listing as $key => $value)
               {
                  $reopen  = '';
                  $datetime = '';
                  $tagStatus =  $value['file_tag'];
                  if (!empty($value['loanid'])) 
                  {
                     $countmore = (int)$countArr[$value['loanid']]-1;
                  }
                  if(!empty($value['tag_flag']) && $value['tag_flag']=='4')
                  {
                     $dateLable = 'Disbursed on';
                     if($value['disbursed_date']!='0000-00-00 00:00:00')
                     {
                        $datetime = date('d M, Y', strtotime($value['disbursed_date']));
                     }
                  }                 
                  if(!empty($value['loan_approval_status']) && ($value['loan_approval_status']=='7' || $value['loan_approval_status']=='8'))
                  {
                     if(!empty($value['upload_docs_created_at']) && $value['loan_approval_status']=='7')
                     {
                        $dateLable = 'Login Docs Collected';
                        $datetime = date('d M, Y', strtotime($value['upload_docs_created_at']));
                     }
                     if(!empty($value['upload_dis_created_date']) && $value['loan_approval_status']=='8')
                     {
                        $dateLable = 'Disbursed Docs Collected';
                        $datetime = date('d M, Y', strtotime($value['upload_dis_created_date']));
                     }
                  }
                ?>
             <tr class="hover-section">
              <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=$value['sr_no']?></b></div>
                                                     
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=ucwords(strtolower($value['name']))?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['customer_mobile']?></span><br><?=$value['customer_email']?></div>
                                                      <?php if(!empty($value['residence_address'])){?>
                                                      <div><span class="text-gray-customer font-13"><?=$value['residence_address']?> <?=(!empty($value['customer_city'])?(' ,'.$value['customer_city']):'')?></span></div><?php } ?>
                                                      <div><span class="text-gray-customer font-13"><?=date('d M, Y',strtotime($value['customer_created_on']))?></span></div>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>
                                                      <?php 
                                                         if(!empty($value['make_name'])){
                                                         echo $value['make_name'].' '.$value['model_name'].' '.$value['version_name'];
                                                         }
                                                         else
                                                         {  
                                                            echo "NA";

                                                            }?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">
                                                          <?php if(!empty($value['reg_year'])) {
                                                              echo strtoupper($value['regno']) .' '.$value['reg_year']; ?>    Model <?php } ?></span></div>
                                                      <a href="#" data-toggle="modal">
                                                         <div class="arrow-details" >
                                                            <span class="font-10"><?php $loan_for = ($value['loan_for']=='2')?'Used Car':'New Car';
                                                           echo  $loan_for.' - '.ucwords($value['loan_type']);
                                                              ?></span>
                                                         </div>
                                                      </a>
                                                   </td>
                                                   <td style="position:relative">
                                                   <?php if(!empty($value['file_loan_amount'])){?>
                                                       <div class="mrg-B5 payout_amount_commas" id="<?=$value['sr_no'] ?>"><b>Loan Amount - <i class="fa fa-rupee"></i><span class="<?=$value['sr_no'] ?>">  <?=(!empty($value['disbursed_amount'])?$value['disbursed_amount']:(!empty($value['approved_loan_amt'])?$value['approved_loan_amt']:$value['file_loan_amount']))?></span></b></div>
                                                     
                                                       <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['financer_name']?></span></div>
                                                      <div ><span class="text-gray-customer font-13">Ref. Id - <?=!empty($value['ref_id'])?$value['ref_id']:'NA'?></span></div>
                                                      <div><span class="text-gray-customer font-13">Interest Rate - <?=(!empty($value['approved_roi'])?$value['approved_roi']:(!empty($value['file_roi'])?$value['file_roi']:'NA'))?>%</span></div>
                                                      <div><span class="text-gray-customer font-13">Loan Tenure - <?=(!empty($value['approved_tenure'])?$value['approved_tenure']:(!empty($value['file_tenure'])?$value['file_tenure']:'NA'))?> Months</span></div><br>
                                                     <?php } else{
                                                         echo "NA";
                                                         }?>
                                                   </td>
                                                   <td style="position:relative">
                                                   <?php $source=($value['source_type']=='1')?'Dealer':'InHouse';?>
                                                      <div class="mrg-B5"><b>Source - <?=$source?></b></div>
                                                      <?php if($source=='Dealer'){?>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">Dealer Organization - <?=$value['organization']?></span></div>
                                                      <div><span class="text-gray-customer font-13">Assigned to - <?=$value['assigned_to']?></span></div>
                                                      <?php } ?>
                                                      <div><span class="text-gray-customer font-13">Sales Executive - <?=$value['sales_executive']?></span></div>
                                           
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>Status - <?=$value['file_tag']?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$dateLable?> - <?=$datetime?></span></div>
                                                   </td>
                                                    <td style="position:relative">
                                                     <?php 
                                                      $payout_status = "Pending";
                                                      $dateLable = $datetime = "";
                                                      if(!empty($value['payout_id'])){
                                                          $payout_status = "Paid";
                                                          $dateLable = "Payout On";
                                                          $Payout_datetime = date('d M, Y', strtotime($value['payout_date']));

                                                      }
                                                      ?>                                                                                              
                                                      <div class="mrg-B5"><b>Status - <?=$payout_status?></b></div>
                                                      <?php if(!empty($value['payout_id'])){ ?>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$dateLable?> - <?=$Payout_datetime?></span></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13">Payment ID - <?=$value['payout_id']?></span></div>
                                                      <?php }?>
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
                                if ((int)$page > 1) {
                                    $prePage = (int)$page - 1;
                                    ?>
                                    <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = (int)$page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                            ?>   
                                            <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                }

                                //this is the current page
                                // if($i > $page){ ?>
                                <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>
                               
                                <?php
                             // }
                                //this will print pages which will come after current page
                                for ($i = $page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
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
                                                <?php } if(empty($loan_listing))
           { echo "<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='".base_url()."assets/admin_assets/images/NoRecordFound.png'></div></td></tr>"; }?>
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

<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url('assets/admin_assets/js/payoutlisting.js')?>"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  </script>
<script>
    
    function makePayout()
    {
       $('#makePayout').addClass(' in');
       $('#makePayout').attr('style','display:block');
      var type = 'add';
      var date = new Date();
      var d = new Date();        
      d.setDate(date.getDate());
      $.ajax({
        url: base_url+"Payout/makepayout",
        type: 'post',
        dataType: 'html',
        data: '',
        success: function(response)
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
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/getHistoryDetail/",
              data : {caseId:loanid},
              dataType: 'html',
              success: function (response) 
              { 
                $('#hisfeedBack').addClass('in');
                $('#hisfeedBack').attr('style','display:block');
                $('#showHisData').html(response);
              }
              });   
           

         }
      </script>
<script>
    var date = new Date();
    var d = new Date();        
      d.setDate(date.getDate());
        $(document).ready(function(){
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
           var type = "<?=$url?>";
       });
        //loanlisting();
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
        function bankList()
        {
           $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "Finance/getBankList/",
           dataType: 'html',
           success: function (response) 
           { 
              $('.abc3').attr('style','display:block;');
              $('.abc3').html(response);

           }
           });
        }
          
        function reset()
        {
          location. reload(true);
        }
        function reopen(caseId,link){
        {
        // alert('hi');
         var r = confirm("Do You Want to Reopen this Case?");
            if (r == true)
            {
                $.ajax({
                  type : 'POST',
                  url : "<?php echo base_url(); ?>" + "Finance/reopenCase/",
                  data : {caseId:caseId},
                  dataType: 'html',
                  success: function (response) 
                  { 
                     setTimeout(function(){ window.location.href = link; }, 300);
                  }
               });
            }
            else
            {
              alert('You Choose Cancel!');
            }
         }
         }
        
        $(document).ready(function(){
        addCommasToListing();
            var team = "<?=$this->session->userdata['userinfo']['team_name']?>";
            var role = "<?=$this->session->userdata['userinfo']['role_name']?>";
            if((team=='Loan') && (role=='Accountant'))
            {
              $('#loan_status').val('4');
              $('#loan_status')[0].sumo.reload();
              $('#search').trigger('click');
            }

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

        function closeHistory()
        {
            $('#hisfeedBack').removeClass('in');
            $('#hisfeedBack').attr('style','display:none');
        }

        function pagination(page) {
        $("#page").val(page);
        $("#payoutcases").html('');
        $('#imageloder').show();
        var formDataSearch=$('#searchform').serialize();
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
            $('#payoutcases').html(html);
            $(window).scrollTop(0);
            }
            else if (parseInt(html) == 1) {
            start--;
            $('#page').attr('value', start);
             $('#payoutcases').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
         
            $('#loadmoreajaxloader').text('No More Results');
            }
            $('.'+page).addClass('active');
            $('#imageloder').hide();
            addCommasToListing();
            }
        });
    }
     $('#total_count').text('('+"<?=$total_count?>"+')');
     $('#searchbyval').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
       $('#search').trigger('click');
    }
});
function addCommasToListing(){
     $("#payoutcases").find(".payout_amount_commas").each(function(){
                 var id = $(this).attr('id');
                var val = $("."+id).text();  
               var val_Comma = addCommased(val, id,'','1');
                $("."+id).html("");
                $("."+id).html(val_Comma);
            })
}
</script>
