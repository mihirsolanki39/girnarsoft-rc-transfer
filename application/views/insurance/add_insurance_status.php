<div class="container-fluid">
               <div class="row">
                   <form name="statusform" id="statusform" method="post" action="">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                     <div class="white-section">
                        <div class="row">
                           <div class="col-md-12">
                             <h2 class="sub-title mrg-T0">Add Insurance Lead</h2>
                            </div>
                            
                            
                           
                           <div class="col-md-12">
                               <div class="btn-sec-width">
                                  <input  style="text-align: center" type="button" class="btn btn-lg btn-save-editable" name="btnform4" id="btnform4" value="<?= (!empty($data[0])) ? 'UPDATE AND CONTINUE' : 'SAVE AND CONTINUE' ?>">
                                  <input type="hidden" name="step4" value="true">
                                  <input type="hidden" name="customerId" id="customer_id" value="<?php echo isset($customerId) ? $customerId :''; ?>">
                               </div>
                           </div>
                        </div>
                     </div>
                   
                      
                  </div>
                   </form>
               </div>
            </div>
         </div>
         <?php $currentdate=date('Y/m/d');?>
<script>
    $(document).ready(function() {
     StartDate =  '<?=date('Y/m/d',  strtotime($currentdate.' -18 year'));?>';
      now      = '<?= date('Y-m-d') ?>';
       $('#follow_up_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        startDate: StartDate,
        maxDate:'<?=date('d/m/Y')?>',
        constrainInput: true,
        scrollMonth: false,
        scrollTime: false,
        scrollInput: false,
    });
    });
     </script>
         <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>