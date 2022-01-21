<div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <div class="content">
      <div class="container-fluid">
    <div class="row">
        <h5 class="cases mrg-B20"><?=$case?> Leads</h5>
        <div class="list_div">
          <div class="background-ef-tab mrg-T20 mrg-B20" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                <div class="col-md-6">
                  <h5 class="cases font-20"> <?=$case?> Lead Report (<span><?=$counts?></span>)</h5>
                </div>
              </div>

              <div class="container-fluid ">
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="row">
                      <div class="table-responsive">
                        <table class="table border-T table-bordered table-striped table-hover enquiry-table mytbl">
                           <thead>
                              <tr>
                                 <th width="20%">Customer Details</th>
                                 <th width="20%"><?=(strtolower($case)=='conversion')?'Bought Car':'Interested In'?></th>
                                 <th width="20%"><?=(strtolower($case)=='conversion')?'Purchased on':'Visited On'?></th>
                                 <th width="20%">Current Status</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </thead>
                           <tbody id="buyer_list">
                           <?php if(!empty($data)){
                            foreach ($data as $key => $value) {
                          
                            ?>
                             <tr class="hover-section">
                                <td style="position:relative">
                                  <div class="mrg-B5"><b><?=(!empty($value['ldm_name']))?ucwords($value['ldm_name']):'NA';?></b></div>
                                  <div class="font-13 text-gray-customer"><span class="font-14"><?=!empty($value['mobile'])?$value['mobile']:'';?></span></div>
                                </td>
                                <td style="position:relative">
                                  <div class="mrg-B5"><b><?=!empty($value['make'])?$value['make'].' '.$value['model'].' '.$value['db_version']:''?></b></div> 

                                  <div class="font-13 text-gray-customer"><span class="font-14"><?=!empty($value['reg_no'])?$value['reg_no'].',':''?>  <?=!empty($value['make_year'])?$value['make_year']:''?></span></div>     
                                </td>
                                <td style="position:relative">
                                  <div class="font-13 text-gray-customer"><span class="font-14"><?=date('d M, Y',strtotime($value['created_date']))?></span></div>
                                </td>
                                <td style="position:relative">
                                  <div class="mrg-B5"><b><?=$value['status_name'];?></b></div>
                                </td>
                                <td style="position:relative">
                                  <a href="<?php echo base_url('lead/getLeads/dashleads_'.$value['mobile']);?>" data-toggle="tooltip" title="" data-placement="top" class="btn btn-default" data-original-title="Edit">EDIT</a>
                                  
                                </td>
                              </tr>

                                <?php } } ?>                           
                              
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