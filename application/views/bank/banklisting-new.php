<style>
  .nav-tabs>li a{font-size: 16px;}
  .nav-tabs>li a:hover{background: none;}
  .nav-tabs>li.active>a:hover{}
  .nav-tabs>li.active>a:focus{background: none;}
  .nav-tabs>li.active>a{font-size: 16px}
  .assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px;margin-top: 10px; display: inline-block;}

  .label-t{padding: 5px 10px;text-transform: uppercase;display: inline-block;float: right;}
  .availabe{background: #2196F3; color: #fff;border-radius: 3px;font-size: 11px;}
  .sold{background: #00B028;color: #fff;border-radius: 3px;font-size: 11px;}
  .refurb{ background: #6A6A6A;color: #fff;border-radius: 3px;font-size: 11px;}
  .booked{background: #F0B967;color: #fff;border-radius: 3px;font-size: 11px;}
  .removed{ background: #FF0000;color: #fff;border-radius: 3px;font-size: 11px;} 
</style>
<div class="container-fluid mrg-all-20 mrg-B0">
  <div class="row">
    <h5 class="cases mrg-B20">Bank List</h5>
    <ul class="nav nav-tabs">
      <li id="stock_list" class="options <?php if(intval($type) == 1) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Stock Listing</a></li>
      <li id="work_list" class="options <?php if(intval($type) == 2) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Work Listing</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade in active">
        <div id="refurb_case_div" class=""></div>
      </div>
    </div>
  </div>
</div>
<div id="content">
<div class="container-fluid mrg-all-20">
   <div class="row">
      <div class="">
         <div class="cont-spc pad-all-20" id="buyer-lead">
               <form id="searchform">
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label" >Search By</label>
                        <input type="text" class="form-control" placeholder="Enter">
                                    
                                 
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Status</label>
                              <select class="form-control crm-form" name="sale_emp" id="sale_emp">
                                 <option value="">Status</option>
                                 <option>Active</option>
                                 <option>Inactive</option>
                              </select>
                              <span class="d-arrow"></span>
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
                        <h5 class="cases">Bank Listing (42)</h5>
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
                                            
                                             <th width="20%">Bank Details</th>
                                             <th width="20%">Branch</th>
                                             <th width="20%" >Loan Limit</th>
                                             <th width="20%" >Status</th>
                                               <th width="20%" >Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                            <td>
                                                <div class="dealer-ship">Punjab National Bank</div>
                                                <div class="dt-bank">PUNB0016000</div>
                                            </td>
                                            <td>
                                                <div class="dealer-ship">Delhi</div>
                                            </td>
                                            <td>
                                                <div class="dt-bank">1000000</div>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-checkbox customCheck2" id="20" checked="" onclick="activeDeactiveEmp('20','')">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                            <button data-target="#" data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-default">EDIT</button>
                                            </td>
                                           </tr>



                                           <tr>
                                            <td>
                                                <div class="dealer-ship">Punjab National Bank</div>
                                                <div class="dt-bank">PUNB0016000</div>
                                            </td>
                                            <td>
                                                <div class="dealer-ship">Delhi</div>
                                            </td>
                                            <td>
                                                <div class="dt-bank">1000000</div>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-checkbox customCheck2" id="20" checked="" onclick="activeDeactiveEmp('20','')">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                            <button data-target="#" data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-default">EDIT</button>
                                            </td>
                                           </tr>



                                           <tr>
                                            <td>
                                                <div class="dealer-ship">Punjab National Bank</div>
                                                <div class="dt-bank">PUNB0016000</div>
                                            </td>
                                            <td>
                                                <div class="dealer-ship">Delhi</div>
                                            </td>
                                            <td>
                                                <div class="dt-bank">1000000</div>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-checkbox customCheck2" id="20" checked="" onclick="activeDeactiveEmp('20','')">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                            <button data-target="#" data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-default">EDIT</button>
                                            </td>
                                           </tr>


                                           <tr>
                                            <td>
                                                <div class="dealer-ship">Punjab National Bank</div>
                                                <div class="dt-bank">PUNB0016000</div>
                                            </td>
                                            <td>
                                                <div class="dealer-ship">Delhi</div>
                                            </td>
                                            <td>
                                                <div class="dt-bank">1000000</div>
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="custom-checkbox customCheck2" id="20" checked="" onclick="activeDeactiveEmp('20','')">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                            <button data-target="#" data-toggle="tooltip" title="Edit" data-placement="top" class="btn btn-default">EDIT</button>
                                            </td>
                                           </tr>

                                       
                                       
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
 </div>

