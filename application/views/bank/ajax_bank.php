<?php if(intval($source) == 1) {?>
<?php if(!$is_search){ ?>
         <div class="cont-spc pad-all-20" id="buyer-lead">
               <form id="search_form" name="search_form" method="post" class="" role="form">
                <input type="hidden" id="source" name="source" value="1" />
                <input type="hidden" id="page" name="page" value="1" />
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label" >Search By</label>
                        <input type="text" class="form-control" name="search_by" id="search_by" placeholder="Bank Name">
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Status</label>
                              <select class="form-control crm-form testselect1" name="bstatus" id="bstatus">
                                 <option value="">Status</option>
                                 <option value="1">Active</option>
                                 <option value="0">Inactive</option>
                              </select>
                             
                     </div>
                     
                     <div class="col-md-2 pad-R0">
                        <span id="spnsearch">
                            <input type="button" class="btn-save btn-save-new" onclick="banksearchList();" value="Search" id="search">
                            <a href="JavaScript:Void(0)" onclick="getBankHtml(1)" id="Reset" class="btn-reset">RESET</a>
                            <input type="hidden" name="dashboard" id="dashboard" value="<?=(!empty($url)?$url:'')?>">
                        </span>
                     </div>
                  </div>
               </form>
            </div>
<?php } ?>
<div class="list_div mrg-T20">
         <div class="background-ef-tab" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                        <h5 class="cases">Partner Banks/NBFC List (<span id="totcase"><?php echo $totalCounts; ?></span>)</h5>
                   </div>
                   <div class="col-md-6">
                     <a href="<?=base_url()?>addBank" target="_blank"> <button class="btn-success pull-right">ADD NEW</button></a>
                   </div>  
              </div>
               <!-- Tab panes -->
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                     <div class="container-fluid ">
                        <div class="row">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                              <style>
                              #banklisting .dealer-ship{font-size:14px; color:#000000; opacity:0.87; font-weight:500;}
                              #banklisting .dt-bank{font-size:#000000; opacity:.67; font-size:14px; margin-top:5px;}
                              #banklisting .switch {position: relative;display: inline-block;width: 34px;height: 14px; vertical-align: middle;}

                              </style>
                                 <div class="table-responsive" id="banklisting">
                                    <table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
                                       <thead>
                                          <tr>
                                            
                                             <th width="10%">S.No.</th>
                                             <th width="30%">Bank Details</th>
                                             <th width="20%" >Loan Limit</th>
                                             <th width="20%" >Status</th>
                                               <th width="10%" >Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php 
                                        if(!empty($bankRecords))
                                        {
                                            foreach($bankRecords as $record)
                                            {
                                                $status  = '';
                                                    $bchecked = '';
                                                    $class   = '';
                                                    if ($record['status'] == 0)
                                                    {
                                                        $bchecked = '';
                                                        $status  = 'Inactive';
                                                        $class   = "class='inactive-danger'";
                                                    }
                                                        else if ($record['status'] == 1)
                                                    {
                                                        $status  = 'Active';
                                                        $class   = "class=''";
                                                        $bchecked = "checked='checked'";
                                                    }
                                    $bankName  = $this->Crm_banks_List->crmBankName($record['bank_id']);
                                    ?>
                                          <tr>
                                            <td>
                                                <div class="dealer-ship"><?php echo $record['id'] ?></div>
                                                
                                            </td>
                                            <td>
                                                <div class="dealer-ship"><?php echo !empty($bankName[0]->bank_name)?$bankName[0]->bank_name:'' ?></div>
                                                <div class="bank"><?php echo !empty($record['address']) ? ucwords($record['address']).",":''; ?><?php echo !empty($record['branch_name']) ? ucwords($record['branch_name']):''; ?></div>
                                            </td>
                                            <td>
                                                <div class="dealer-ship"><i class="fa fa-rupee"></i> <?php echo indian_currency_form($record['amount_limit']) ?></div>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-checkbox customCheck2" <?php echo $bchecked; ?> id="<?php echo $record['id']; ?>" onclick="activeDeactiveBank('<?php echo $record['id']; ?>','<?php echo $record['bank_name'] ?>','partner')">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                            <?php if($record['status'] == 1){ ?>    
                                                <a href="<?php echo base_url().'addBank/'.base64_encode(DEALER_ID.'_'.$record['id']); ?>" title="Edit"><button title="Edit" class="btn btn-default">EDIT</button></a>
                                            <?php } ?>
                                            </td>
                                           </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                          <tr>
                                            <td align='center' colspan='5'><div class='text-center pad-T30 pad-B30'><img src='<?php echo base_url('assets/admin_assets/images/NoRecordFound.png'); ?>'></div>
                                            </td>
                                          </tr>
                                        <?php } ?>
                                          <tr><td colspan="5" align="center"><?php if(intval($totalCounts) > 0){ ?>
                                    <div class="">
                                      <div class="col-lg-12 col-md-12">
                                         <nav aria-label="Page navigation">
                                            <ul class="pagination customePagination" >
                                              <?php
                                                $total_pages  = ceil($totalCounts / $limit);  
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
                                                      $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="pagination('.$prePage.');"><a class="page-link" aria-label="Previous"><span aria-hidden="true">Prev</span>
                                                        <span class="sr-only">Prev</span></a></li>';
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
                                                      $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="pagination('.$nextPage.');"><a class="page-link" aria-label="Next"><span aria-hidden="true">Next</span>
                                                        <span class="sr-only">Next</span></a></li>';
                                                  }
                                                }

                                                echo $pagLink; 
                                              ?>
                                            </ul>
                                         </nav>
                                      </div>
                                    </div>
                                  <?php } ?></td></tr>  
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
<?php }else{ ?>
<?php if(!$is_search){ ?>
        <div class="cont-spc pad-all-20" id="buyer-lead">
               <form id="search_form" name="search_form" method="post" class="" role="form">
                <input type="hidden" id="source" name="source" value="2" />
                <input type="hidden" id="page" name="page" value="1" />
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label" >Search By</label>
                        <input type="text" class="form-control" name="search_by" id="search_by" placeholder="Bank Name">
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Status</label>
                              <select class="form-control crm-form testselect1" name="bstatus" id="bstatus">
                                 <option value="">Status</option>
                                 <option value="1">Active</option>
                                 <option value="0">Inactive</option>
                              </select>
                             
                     </div>
                     
                     <div class="col-md-2 pad-R0">
                        <span id="spnsearch">
                            <input type="button" class="btn-save btn-save-new clsbtn" onclick="banksearchList();" value="Search" id="search">
                            <a href="JavaScript:Void(0)" onclick="getBankHtml(2)" id="Reset" class="btn-reset">RESET</a>
                            <input type="hidden" name="dashboard" id="dashboard" value="<?=(!empty($url)?$url:'')?>">
                        </span>
                     </div>
                  </div>
               </form>
            </div>
<?php } ?> 
<div class="col-md-12 mrg-T20">
   <div class="row">
      <div class="list_div">
         <div class="background-ef-tab" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                        <h5 class="cases">All Banks/NBFC (<span id="totcase"><?php echo $totalCounts; ?></span>)</h5>
                   </div>
                   <div class="col-md-6">
                     <a onclick="return addNewbank();"> <button class="btn-success pull-right">ADD NEW</button></a>
                   </div>  
              </div>
               <!-- Tab panes -->
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                     <div class="container-fluid ">
                        <div class="row">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                              <style>
                              #banklisting .dealer-ship{font-size:14px; color:#000000; opacity:0.87; font-weight:500;}
                              #banklisting .dt-bank{font-size:#000000; opacity:.67; font-size:14px; margin-top:5px;}
                              #banklisting .switch {position: relative;display: inline-block;width: 34px;height: 14px; vertical-align: middle;}

                              </style>
                                 <div class="table-responsive" id="banklisting">
                                    <table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
                                       <thead>
                                          <tr>
                                             <th width="10%">S.No.</th>
                                             <th width="50%">Bank Details</th>
                                             <th width="20%" >Status</th>
                                             <th width="10%" >Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php 
                                        if(!empty($bankRecords))
                                        {
                                            foreach($bankRecords as $record)
                                            {
                                                    $status  = '';
                                                    $checked = '';
                                                    $class   = '';
                                                    if ($record['status'] == 0)
                                                    {
                                                        $checked = '';
                                                        $status  = 'Inactive';
                                                        $class   = "class='inactive-danger'";
                                                    }
                                                        else if ($record['status'] == 1)
                                                    {
                                                        $status  = 'Active';
                                                        $class   = "class=''";
                                                        $checked = "checked='checked'";
                                                    }
                                    ?>
                                          <tr>
                                            <td>
                                                <div class="dealer-ship"><?php echo $record['bank_id'] ?></div>
                                                
                                            </td>
                                            <td>
                                                <div class="dealer-ship"><?php echo !empty($record['bank_name'])?$record['bank_name']:'' ?></div>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $record['bank_id']; ?>" <?php echo $checked; ?> onclick="activeDeactiveBank('<?php echo $record['bank_id']; ?>','<?php echo $record['bank_name'] ?>','all')">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                            <?php if($record['status'] == 1){ ?>    
                                                <button title="Edit" onclick="return updateCustomerBank('<?php echo $record['bank_id'] ?>','<?php echo !empty($record['bank_name'])?$record['bank_name']:'' ?>')" class="btn btn-default">EDIT</button>
                                            <?php } ?>
                                            </td>
                                           </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                          <tr>
                                            <td align='center' colspan='4'><div class='text-center pad-T30 pad-B30'><img src='<?php echo base_url('assets/admin_assets/images/NoRecordFound.png'); ?>'></div>
                                            </td>
                                          </tr>
                                        <?php } ?>
                                          <tr>
                                              <td colspan="4" align="center">
                                              <?php if(intval($totalCounts) > 0){ ?>
                                            <div class="">
                                              <div class="col-lg-12 col-md-12">
                                                 <nav aria-label="Page navigation">
                                                    <ul class="pagination customePagination" >
                                                      <?php
                                                        $total_pages  = ceil($totalCounts / $limit);  
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
                                                              $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="pagination('.$prePage.');"><a class="page-link" aria-label="Previous"><span aria-hidden="true">Prev</span>
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
                                                              $pagLink .= '<li style="cursor: pointer;" class="page-item" onclick="pagination('.$nextPage.');"><a class="page-link" aria-label="Next"><span aria-hidden="true">Next</span>
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
                                              </td>
                                          </tr>  
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
<?php } ?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
<script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script>
  $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
  </script>
