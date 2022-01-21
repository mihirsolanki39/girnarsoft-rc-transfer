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
                     <h5 class="cases"> Stock (<span id="totcase">0</span>)</h5>
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
                                       <tbody id="buyer_list">
                                        <?php //echo "<pre>"; print_r($query); ?>
                                    <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                    <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>
                                         
                                       </tbody>

                                     </table>
                                   </div>
                                  <div id="loadmoreajaxloader" style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                              <img src="ajax/loading.gif" title="Click for more">Click for more
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
<script src="<?=base_url('assets/admin_assets/js/refurb.js')?>"></script>
<style>
  
#refurbhistory .modal-dialog {width: 500px;}
#refurbhistory .modal-body { padding: 0 0 30px 0; height: auto;}
#refurbhistory .timeline_content {height: 355px;overflow-y: auto;overflow-x: hidden;}
#refurbhistory .sidenav {background-color: #fff;overflow-x: hidden;padding-left: 0;}
#refurbhistory .sidenav ul {list-style-type: none; padding-left: 55px; overflow: hidden;padding-right: 20px; height: 100vh}
 #refurbhistory .side_nav{padding-left: 25px; clear: both;}
 #refurbhistory .side_nav .side_text {padding-top: 10px;padding-bottom: 12.5px; border-bottom: 0px solid #f1f1f1;}
#refurbhistory .sidenav a.sidenav-a { padding: 0px; text-decoration: none; border-bottom: 0px solid #f1f1f1; font-size: 14px; color: rgba(0, 0, 0, 0.87); line-height: 40px; font-weight: normal; display: block; margin-left: -15px;}
#refurbhistory .active_text {font-size: 14px;color: rgba(0, 0, 0, .87);}
#refurbhistory .Detail_text { font-size: 12.5px; color: rgba(0, 0, 0, .54); display: block;}
#refurbhistory .sidenav-a small { display: block;margin-top: -20px;margin-left: 0;font-size: 12.5px; color: rgba(0, 0, 0, .54);}
#refurbhistory .side_nav a.sidenav-a .img-type {height: 16px;width: 16px;margin-top: -5px;margin-left: -50px;margin-right: 35px;vertical-align: top;display: inline-block;position: relative;}
#refurbhistory .side_nav .col-sm-4 { padding-right: 0px;}
#refurbhistory .modal-title {font-size: 20px;font-weight: 500; color: rgba(0, 0, 0, 0.87);}
#refurbhistory  .sidenav-a .img-type:after {
    content: "";
    border-left: 1px dashed #ddd;
    left: 8px;
    position: absolute;
    top: 18px;
    height: 104px;
}
#refurbhistory .adownl{position: absolute; right: 0px}
</style>


<div class="modal fade" id="refurbhistory" role="dialog">
         <div class="modal-dialog" style="width: 580px; height:100vh;">
            <div class="modal-content">
              <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><img src="http://dealercentralcrm.com/assets/admin_assets/images/cancel.png"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Refurb History Details</h4>
              </div>

              <div class="modal-body">
                <div class="timeline_content">
                  <div class="row">
                     
                    <div id="commentInsHistory">

    
   
                    <div class="col-sm-12 sidenav">
                      <ul class="par-ul">
                        <li class="side_nav">
                              <div class="col-md-12 border-B">
                                <div class="row">
                                  <div class="col-sm-3">
                                    <a href="#" class="sidenav-a">
                                      
                                        <span class="img-type"> </span>12 Jan<small>Sent On</small>
                                        <span></span>12 Feb<small>Retun On</small>
                                     
                                    </a>
                                  </div>

                                  <div class="col-sm-9 side_text">
                                    <a class="adownl" href="javascript:void(0);" data-toggle="tooltip" data-placement="left" title="Download Workorder"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
                                    <span class="active_text">Workshop : Qutub Motors</span>
                                    <span class="Detail_text">1.  Washing </span>
                                    <span class="Detail_text">2.  Backdoor Repair </span>
                                    <span class="Detail_text">3.  AC Repair </span>
                                  </div>
                              </div>
                            </div>
                        </li>

                         <li class="side_nav">
                              <div class="col-md-12 border-B">
                                <div class="row">
                                  <div class="col-sm-3">
                                    <a href="#" class="sidenav-a">
                                      
                                        <span class="img-type"> </span>12 Jan<small>Sent On</small>
                                        <span></span>12 Feb<small>Retun On</small>
                                     
                                    </a>
                                  </div>

                                  <div class="col-sm-9 side_text">
                                    <a class="adownl" href="javascript:void(0);" data-toggle="tooltip" data-placement="left" title="Download Workorder"><img src="<?php echo base_url() ?>assets/images/download.svg" /></a>
                                    <span class="active_text">Workshop : Qutub Motors</span>
                                    <span class="Detail_text">1.  Washing </span>
                                    <span class="Detail_text">2.  Backdoor Repair </span>
                                    <span class="Detail_text">3.  AC Repair </span>
                                  </div>
                              </div>
                            </div>
                        </li>


                    </ul>
                  </div>
                </div>
                 </div>
                 </div>   
                <!--</div>--> 
            </div>

        </div>
        </div>
      </div>

      <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
      </script>