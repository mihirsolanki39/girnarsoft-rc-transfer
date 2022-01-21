<?php setlocale(LC_MONETARY, 'en_IN'); if(intval($source) == 1) { ?>
<?php if(!$is_search){ ?>
  <div class="cont-spc pad-all-20" id="buyer-lead">
    <form id="search_form" name="search_form" method="post" class="" role="form">
      <input type="hidden" id="source" name="source" value="1" />
      <input type="hidden" id="page" name="page" value="1" />
      <div class="row">
        <div class="col-md-2 pad-R0">
          <label for="" class="crm-label">Search By</label>
          <input type="text" class="form-control" name="search_by" id="search_by" value="" placeholder="Reg. No./ Make/ Model">
        </div>

        <div class="col-md-2 pad-R0">
            <label for="" class="crm-label">Current Status</label>
            <select class="form-control testselect1" name="carStatus" id="carStatus">
              <option value="">Select Status</option>  
              <option value="1">Available</option>
              <option value="6">Refurb</option>
              <option value="4">Booked</option>
              <option value="5">Sold</option>
              <option value="2">Removed</option>
            </select>
        </div>
            <div class="col-md-6 pad-R0" id="wdlabel">
                        
                         <div class="col-sm-3 pad-R0">
                               <label for="" class="crm-label">Date</label>
                                 <select name="date_status" id="date_status" class="form-control">
                                    <option value="1">Sent Date</option>
                                    <option value="2">Return Date</option>
                                  </select>
                          </div>
                          <div class="col-sm-3 pad-R0 pad-L0 mrg-T25">
                                <div class="date input-append demo" id="reservation_to" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                    <input type="text" name="daterange_to" id="daterange_to" class="form-control crm-form add-on icon-cal1 new_input" placeholder="From" readonly> 
                              </div>
                           </div>
                          <div class="col-sm-3 pad-R0 pad-L0  mrg-T25">
                              <div class="date input-append demo" id="reservation_from" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                  <input type="text" name="daterange_from" id="daterange_from" class="form-control crm-form add-on icon-cal1 new_input" placeholder="To" readonly> 
                              </div>
                           </div>
                         </div>  

        <!-- <div class="col-md-2 pad-R0">
            <label for="" class="crm-label">Date From</label>
            <div class="date input-append demo" >
                <input type="text" name="from_date" id="from_date" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="From" data-date-format="dd-mm-yyyy">
            </div>
        </div>

        <div class="col-md-2 pad-R0">
          <label for="" class="crm-label">Date To</label>
            <div class="date input-append demo" >
                <input type="text" name="to_date" id="to_date" class="form-control customize-form add-on icon-cal1 pad-L8" placeholder="To" data-date-format="dd-mm-yyyy"> 
            </div>
        </div> -->

        <div class="col-md-2 pad-R0">
          <span>
              <a class="btn-save btn-save-new" onclick="searchList();" id="search">SEARCH</a>
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
        <h5 class="cases"> <span id="refcase"> Stock </span> Cases (<span id="totcase"><?php echo $totalCount; ?></span>)</h5>
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
                             <th width="30%">Car Details</th>
                             <th width="30%">Status</th>
                             <th width="30%">Actual Refurb Amount</th>
                             <th width="10%">Action</th>
                          </tr>
                       </thead>
                       <tbody>
                          <?php 
                          /*echo "<pre>";
                          print_r($caseList);
                          exit;*/
                          if(count($caseList) > 0) { ?>
                          <?php foreach($caseList as $index => $indexItem){ ?>
                          <tr>
                            <td>
                              <div class="mrg-B5"><b><?php echo $indexItem['make'].' '.$indexItem['model'].' '.$indexItem['version'];?></b>  </div>
                              <div class="font-13 text-gray-customer">
                               <span class="font-14"><?php echo !empty($indexItem['regno']) ? 'Reg No '.$indexItem['regno'].' | ' :'';?><span class="dot-sep"></span><?php echo $indexItem['make_year'];?> Model</span>
                              </div>
                            </td>
                            <td><b>
                              <?php
                                if($indexItem['active'] == '1'){
                                  echo "Available";
                                } else if($indexItem['active'] == '6'){
                                  echo "Refurb";
                                } else if($indexItem['active'] == '4'){
                                  echo "Booked";
                                } else if($indexItem['active'] == '3'){
                                  echo "Sold";
                                } else if($indexItem['active'] == '2'){
                                  echo "Removed";
                                }
                              ?>
                                </b>      
                              <div class="font-13 text-gray-customer">
                               <span class="font-14">Refurb Done in <?php echo $indexItem['total_refurbs']; ?> Workshops
                                </span>
                              </div>
                            </td>
                            <td>
                              <?php echo  (!empty($indexItem['actual_amount'])) ? '<i class="fa fa-rupee"></i> '.$indexItem['actual_amount'] :''?>
                            </td>
                            <td>
                              <button class="btn btn-default" data-toggle="modal" data-target="#refurbhistory" onclick="getHistory(<?php echo $indexItem['car_id'];?>)" >View Refurb History</button>
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
<?php } else if(intval($source) == 2) { ?>
<?php if(!$is_search){ ?>
  <div class="cont-spc pad-all-20" id="buyer-lead">
    <form id="search_form" name="search_form" method="post" class="" role="form">
      <input type="hidden" id="source" name="source" value="2" />
      <input type="hidden" id="page" name="page" value="1" />
      <div class="row">
         
        <div class="col-md-2 pad-R0">
            <label for="" class="crm-label">Search By</label>
            <input type="text" class="form-control" name="search_by" id="search_bys" value="" placeholder="Workshop/Mobile/Owner Name">
        </div>

        <div class="col-md-2 pad-R0">
          <label for="" class="crm-label">Min Payment Due</label>
          <input type="text" class="form-control rupee-icon" maxlength="8" onkeypress="return isNumberKey(event);" onkeyup="addCommased(this.value,'min_payment')"  name="min_payment" id="min_payment" value="">
        </div>

        <div class="col-md-2 pad-R0">
          <span>
              <a class="btn-save btn-save-new" onclick="searchList();" id="searchb">SEARCH</a>
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
                           <th width="30%">Stock In Workshop</th>
                           <th width="30%">Payment Due</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($caseList) > 0) { ?>
                        <?php foreach($caseList as $index => $indexItem){ ?>
                        <tr>
                          <td>
                            <div class="mrg-B5"><b><?php echo $indexItem['name'];?></b>  </div>
                            <div class="font-13 text-gray-customer">
                            <span class="font-14"><?php echo  !empty($indexItem['owner_name']) ? 'Owner Name - '.$indexItem['owner_name'] :'';?></span>
                             <span class="font-14"><?php echo !empty($indexItem['owner_mobile']) ? '<br/>Owner Mobile - '.$indexItem['owner_mobile'] :'';?></span>
                             <span class="font-14"><?php echo  '<br/>Created On - '.$indexItem['created_at']; ?></span>
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
                            <?php echo '<i class="fa fa-rupee"></i> '. $indexItem['payment_due'];//(intval($indexItem['total_amount']) - intval($indexItem['total_pay']));?>

                            <?php echo  '<br/>Last Payment Done On - '.$indexItem['payment_on']; ?>
                          </td>
                          <td>
                            <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment(<?php echo $indexItem['id'];?>,'','','refublist_module')" >Make Payment</button>
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
             
             
 $('#search_by').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
       $('#search').trigger('click');
       return false;
    }

});


 $("#search_bys").keypress(function(event){
var keycode = (event.keyCode ? event.keyCode : event.which);
 if(keycode == '13'){
        searchList(); 
        return false;
    }
});
</script>