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
                        <label for="" class="crm-label">Team</label>
                              <select class="form-control crm-form" name="showroom" id="showroom">
                              <option value="">Select Team</option>
                                 <option>Loan</option>
                                 <option>Insurance</option>
                                 <option>Sales</option>
                                 <option>RTO</option>
                                 <option>RC Transfer</option>
                                 <option>Delivery</option>
                                 <option>Used Car</option>
                              </select>
                               <span class="d-arrow"></span>
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
                        <h5 class="cases">Employee List (42)</h5>
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
                                            <!-- <th>Loan ID </th>-->
                                             <th width="30%">Employee Details</th>
                                             <th width="30%">Role & Team</th>
                                             <th width="25%" >Status</th>
                                               <th width="15%" >Action</th>
                                          </tr>
                                       </thead>
                                        <tbody>
                                       		<tr>
		                                        <td>
		                                            <div class="dealer-ship">Nishant Goel</div>
		                                            <div class="dt-bank">sumit.kumar@girnarsoft.com</div>
		                                            <div class="dt-bank">8835453433</div>
		                                        </td>
		                                        <td>
		                                            <div class="dealer-ship">Role</div>
		                                            <div class="dt-bank">Team</div>
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
		                                            <div class="dealer-ship">Nishant Goel</div>
		                                            <div class="dt-bank">sumit.kumar@girnarsoft.com</div>
		                                            <div class="dt-bank">8835453433</div>
		                                        </td>
		                                        <td>
		                                            <div class="dealer-ship">Role</div>
		                                            <div class="dt-bank">Team</div>
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
		                                            <div class="dealer-ship">Nishant Goel</div>
		                                            <div class="dt-bank">sumit.kumar@girnarsoft.com</div>
		                                            <div class="dt-bank">8835453433</div>
		                                        </td>
		                                        <td>
		                                            <div class="dealer-ship">Role</div>
		                                            <div class="dt-bank">Team</div>
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
		                                            <div class="dealer-ship">Nishant Goel</div>
		                                            <div class="dt-bank">sumit.kumar@girnarsoft.com</div>
		                                            <div class="dt-bank">8835453433</div>
		                                        </td>
		                                        <td>
		                                            <div class="dealer-ship">Role</div>
		                                            <div class="dt-bank">Team</div>
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
		                                            <div class="dealer-ship">Nishant Goel</div>
		                                            <div class="dt-bank">sumit.kumar@girnarsoft.com</div>
		                                            <div class="dt-bank">8835453433</div>
		                                        </td>
		                                        <td>
		                                            <div class="dealer-ship">Role</div>
		                                            <div class="dt-bank">Team</div>
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
		                                            <div class="dealer-ship">Nishant Goel</div>
		                                            <div class="dt-bank">sumit.kumar@girnarsoft.com</div>
		                                            <div class="dt-bank">8835453433</div>
		                                        </td>
		                                        <td>
		                                            <div class="dealer-ship">Role</div>
		                                            <div class="dt-bank">Team</div>
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