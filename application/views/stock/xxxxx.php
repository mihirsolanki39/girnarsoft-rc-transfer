<style>
  .nav-tabs>li a{font-size: 16px;}
  .nav-tabs>li a:hover{background: none;}
  .nav-tabs>li.active>a:hover{background: none;}
  .nav-tabs>li.active>a:focus{background: none;}
  .nav-tabs>li.active>a{background: none; font-size: 16px}
  .assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px;margin-top: 10px; display: inline-block;}

  .label-t{padding: 5px 10px;text-transform: uppercase;display: inline-block;float: right;}
  .availabe{background: #2196F3; color: #fff;border-radius: 3px;font-size: 11px;}
  .sold{background: #00B028;color: #fff;border-radius: 3px;font-size: 11px;}
  .refurb{ background: #6A6A6A;color: #fff;border-radius: 3px;font-size: 11px;}
  .booked{background: #F0B967;color: #fff;border-radius: 3px;font-size: 11px;}
  .removed{ background: #FF0000;color: #fff;border-radius: 3px;font-size: 11px;}
</style>
<div class="container-fluid">
<div class="row background-color box-S">
  <div class="col-md-12">
    <h5 class="basic-detail-heading">Workshop Name</h5>
  </div>
</div>
</div>
<div class="container-fluid mrg-all-20">
  <div class="row">
    
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#home">Payment Details</a></li>
      <li><a data-toggle="tab" href="#menu1">Stock History</a></li>
    </ul>
    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        DEMO
      </div>
      <div id="menu1" class="tab-pane fade">
        <div class="">
          <div class="cont-spc pad-all-20" id="buyer-lead">
            <form role="form" name="searchform" id="searchform">
              <div class="row">
                 <div class="col-md-2 pad-R0">
                    <label for="" class="crm-label">Search By</label>
                    <input class="form-control" type="text" placeholder="Enter Reg No">
                     
                </div>

                <div class="col-md-2 pad-R0">
                    <label for="" class="crm-label">Status</label>
                    <select class="form-control">
                      <option>One</option>
                      <option>Two</option>
                      <option>Three</option>
                      <option>Four</option>
                    </select>
                </div>

                <div class="col-md-2 pad-R0">
                    <label for="" class="crm-label">Date Range</label>
                    <input class="form-control" type="date" placeholder="Enter Reg No">
                     
                </div>



                <div class="col-md-2 pad-R0">
                    <span id="spnsearch">
                        <input type="button" class="btn-save btn-save-new" value="Search" id="search">
                        <a href="JavaScript:Void(0)" id="Reset" class="mrg-L10  used__car-reset-btn">RESET</a>
                        
                    </span>
                 </div>

              </div>
            </form>
            </div>

             <div class="background-ef-tab mrg-T20" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                     <h5 class="cases"> Stock (<span>0</span>)</h5>
                   </div>
                   <!--<div class="col-md-6">
                     <a href="<?php echo base_url('addInsurance')?>" target="_blank"> <button class="btn-success pull-right">ADD CASE</button></a>
                   </div>  -->
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
                                             <th width="20%">Stock Details</th>
                                             <th width="15%">Status</th>
                                             <th width="20%">Services</th>
                                             <th width="15%">Date</th>
                                             <th width="15%">Amount</th>
                                             <th width="15%">Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                         <tr>
                                           
                                           <td>
                                             <div class="mrg-B5"><b>Mercedes-Benz B-Class 200 CDI</b> </div>
                                             
                                             <div class="text-gray-customer">
                                              <span class="font-14">HR26DA4864</span>
                                            </div>
                                            
                                            
                                           </td>
                                           <td>
                                             In Refurb
                                           </td>
                                           <td>Services</td>
                                           <td>
                                             <div>Sent On 14 April 2019</div>
                                             <div>Return On 21 April 2019</div>
                                           </td>
                                           <td>87333</td>
                                          <td>
                                            <button class="btn btn-default"> Download Workorder</button></td>
                                         </tr>


                                         <tr>
                                           
                                           <td>
                                             <div class="mrg-B5"><b>Mercedes-Benz B-Class 200 CDI</b> </div>
                                             
                                             <div class="text-gray-customer">
                                              <span class="font-14">HR26DA4864</span>
                                            </div>
                                            
                                            
                                           </td>
                                           <td>
                                             In Refurb
                                           </td>
                                           <td>Services</td>
                                           <td>
                                             <div>Sent On 14 April 2019</div>
                                             <div>Return On 21 April 2019</div>
                                           </td>
                                           <td>87333</td>
                                          <td>
                                            <button class="btn btn-default"> Download Workorder</button></td>
                                         </tr>



                                         <tr>
                                           
                                           <td>
                                             <div class="mrg-B5"><b>Mercedes-Benz B-Class 200 CDI</b> </div>
                                             
                                             <div class="text-gray-customer">
                                              <span class="font-14">HR26DA4864</span>
                                            </div>
                                            
                                            
                                           </td>
                                           <td>
                                             In Refurb
                                           </td>
                                           <td>Services</td>
                                           <td>
                                             <div>Sent On 14 April 2019</div>
                                             <div>Return On 21 April 2019</div>
                                           </td>
                                           <td>87333</td>
                                          <td>
                                            <button class="btn btn-default"> Download Workorder</button></td>
                                         </tr>



                                         <tr>
                                           
                                           <td>
                                             <div class="mrg-B5"><b>Mercedes-Benz B-Class 200 CDI</b> </div>
                                             
                                             <div class="text-gray-customer">
                                              <span class="font-14">HR26DA4864</span>
                                            </div>
                                            
                                            
                                           </td>
                                           <td>
                                             In Refurb
                                           </td>
                                           <td>Services</td>
                                           <td>
                                             <div>Sent On 14 April 2019</div>
                                             <div>Return On 21 April 2019</div>
                                           </td>
                                           <td>87333</td>
                                          <td>
                                            <button class="btn btn-default" data-toggle="modal" data-target="#refurbhistory"> Download Workorder</button></td>
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
  </div>
</div>



      <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
      </script>