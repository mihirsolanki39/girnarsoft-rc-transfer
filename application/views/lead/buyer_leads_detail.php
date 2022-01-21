<?php //print_r($leaddata);?>
<style>
    #buyer-lead .cont-spc {
    padding: 0px 20px 20px 20px !important;
}
</style>
<link href="<?=base_url('assets/admin_assets/css/buyer-lead.css')?>" rel="stylesheet">
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.js')?>"></script>
<script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery-ui.js')?>"></script>
<link href="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.css')?>" rel="stylesheet">
<div class="container-fluid pad-T20 bg-container-new" id="maincontainer">
   <div class="row">
      <div class="container-fluid mrg-all-15 pad-all-0">
         <div class="row">
            <div class="col-md-12">
               <div class="background-ef-tab" id="workdetails">
                  <div class="pad-all-30">
                     <div class="row" >
                        <div class="col-md-6">
                           <h4 class="col-black-o fw-B mrg-all-0"><strong>Walk in Done Report</strong></h4>
                           <div> Date: 01 <?php echo date('M');?> - <?php echo date('d').' '.date('M').' '. date('y');?></div>
                           </br>
                        </div>
                     </div>
                  </div>
                  <div class="tabs border-T workingdetials" >
                     
                     <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active tabn">
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                 <thead>
                                    <tr>
                                       <th width="25%">Customer Details</th>
                                       <th width="25%">Interested In</th>
                                       <th width="12%">Visited On</th>
                                       <th width="13%">Current Status</th>
                                       <th width="25%">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if ($leaddata) :
                                        foreach ($leaddata as $key=>$val): ?>
                                     <tr class="hover-section" >
            <td style="position:relative">
            <?php echo $val['name'];
            echo '</br>';
            echo $val['number'];?>
        </td>
        <td style="position:relative">
                <?php echo $val['make'].' '.$val['model'].' '.$val['version'];?>
                </br>
               <?php //echo $val['regno'];?>     
        </td>
        <td style="position:relative">
            <?php echo $today = date("F d, Y h:i A",strtotime($val['httime']));?>
        </td>
       <td style="position:relative">
         <?php echo $val['lead_status'];?>
        </br>
       <?php if($type!='Walk-in Done'){?>Sale Amount : <i class="fa fa-inr" aria-hidden="true"></i> <?php echo  !empty($val['saleAmountFormat']) ? $val['saleAmountFormat']:''; ?><?php } ?>
       </td>
        <td style="position:relative">
            <a  style="color: #fff!important;background-color: #e77842!important;" href="<?php echo base_url()."lead/getLeads?filter_data_type=allleads&type=all&keyword=".$val['number'];?>" class="btn text-btn btn-default font-12 btn-pad-sm" >EDIT</a>
       </td>
</tr>
<?php endforeach; endif ?>
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
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<link href="<?=base_url('assets/admin_assets/css/bootstrap-multiselect.css')?>" rel="stylesheet">
