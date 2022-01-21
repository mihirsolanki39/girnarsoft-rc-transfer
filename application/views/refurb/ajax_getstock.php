       

<div class="background-efOne background-efTwo bgImgN">
      <div class="row">
<div class="list_div col-md-12">
<div class="background-ef-tab mrg-T20" id="loandetails">
  <div class="tabs loandetails">
    <div class="row pad-all-20">
      <div class="col-md-6">
        <h5 class="cases"> Refurb Stock Details (<?= $totalCount; ?>)</h5>
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
                          <!-- <th>Sr. No</th>-->
                           <th>Stock Details</th>
                           <th>Status</th>
                           <th>Services</th>
                           <th>Date</th>
                           <th>Actual Refurb Amount</th>
                           <th>Payment Status</th>
                           <th>Action</th>
                           
                        </tr>
                     </thead>
                     <tbody id="tablecode">
                        <?php if(count($caseList) > 0) { ?>
                        <?php foreach($caseList as $index => $indexItem){//$counter = intval($index)+1; ?>
                        <tr>
                         <!-- <td>
                            
                            <div class="font-13 text-gray-customer">
                             <span class="font-14"><?php echo $counter;?></span>
                            </div>
                          </td>-->
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['make'].' '.$indexItem['model'].' '.$indexItem['version'].'<br/>'.$indexItem['regno']; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo ($indexItem['is_refurb_done']=='0')?'In Refurb':'Refurb Done';?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo $indexItem['services']; /*foreach($services_array as $key => $val){
                                    if($key==$indexItem['services'])
                                    {
                                      echo $val;
                                    }
                                } */ ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo '<strong>Sent on</strong> -' . date('d M Y', strtotime($indexItem['sent_to_refurb'])); ?> 
                               <br>
                                <?php echo '<strong>Return on</strong> -' . date('d M Y', strtotime($indexItem['estimated_date'])); ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                            <div class="font-13 text-gray-customer">
                             <span class="font-14">
                               <?php echo '<i class="fa fa-rupee"></i> '. $indexItem['actual_amt']; ?> 
                              </span>
                            </div>
                          </td>
                          <td>
                              <div class="font-13 text-gray-customer">
                                  <span class="font-14">
                                      <?php
                                      if($indexItem['payment_id'] > 0){
                                          echo "<b>Paid</b>";
                                          echo "<br/>";
                                          echo "<b>PaymentId</b>: ".$indexItem['payment_id'];
                                      }else{
                                          echo "<b>Pending</b>";    
                                      }
                                      
                                      
                                      ?>
                                  </span>
                              </div>
                          </td>
                          <td>
                              <?php $filename = $indexItem['file_name']; ?>
                             <a class="adownl" style="cursor: pointer;" onclick="downloadFile('<?=$filename?>')" data-toggle="tooltip" data-placement="left" title="Download Workorder"><img src="<?= base_url('assets/images/download.svg');?>"></a>
                            
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                          <tr>
                            <td align='center' colspan='10'><div class='text-center pad-T30 pad-B30'><img src='<?php echo base_url('assets/admin_assets/images/NoRecordFound.png'); ?>'></div>
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
  </div>
</div>
</div>
</div>
<?php if(intval($totalCount) > 0){ ?>
      <div class="row">
        <div class="col-lg-12 col-md-12">
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
                        $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="stockpagination('.$prePage.');"><a class="page-link" aria-label="Previou"><span aria-hidden="true"><img src="'.base_url().'assets/admin_assets/images/pagination-left.png" ></span>
                          <span class="sr-only">Previous</span></a></li>';
                        //this for loop will print pages which come before the current page
                        for ($i = $page - 6; $i < $page; $i++)
                        {
                            if ($i > 0)
                            {
                                $pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='stockpagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 
                            }
                        }
                    }

                    //this is the current page
                    $pagLink .= "<li class='page-item active'><a class='page-link' >".$page."</a></li>";  

                    //this will print pages which will come after current page
                    for ($i = $page + 1; $i <= $total_pages; $i++)
                    {
                        $pagLink .= "<li style='cursor: pointer;' class='page-item' onclick='stockpagination(".$i.");' ><a class='page-link' >".$i."</a></li>"; 

                        if ($i >= $page + 3)
                        {
                            break;
                        }
                    }

                    // this is for next button
                    if ($page != $total_pages)
                    {
                        $nextPage = intval($page) + 1;
                        $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="stockpagination('.$nextPage.');"><a class="page-link" aria-label="Next"><span aria-hidden="true"><img src="'.base_url().'assets/admin_assets/images/pagination-right.png" ></span>
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
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
<script>
var d = new Date();   
var date = new Date();        
      d.setDate(date.getDate());
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
</script>