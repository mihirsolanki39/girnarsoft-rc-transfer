 
<style>
    .modal-backdrop.in {
     opacity: -1.5 !important;
}
.modal-backdrop {
    z-index: 0 !important;
}


</style>  

<!-- Feedback modal -->
      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="my ModalLabel" aria-hidden="true" id="feedBack">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-gray">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Feedback</h4>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <div class="form-group text-left">
                        <label class="control-label search-form-label" for="inputSuccess2">Please Enter Your Feedback:</label>
                        <textarea class="form-control search-form-select-box feedBack" placeholder="Type Here..."></textarea>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary">Submit</button>
               </div>
            </div>
            <!-- /.modal-comment -->
         </div>
      </div>
 
 <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="stocksmsEmail">
     <div class="modal-dialog">
         <form name="stocksms_form" id="stocksms_form">
             <div class="modal-content" >
                 <div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                     <h4 class="modal-title">Send Car Details</h4>
                 </div>
                 <div class="modal-body text-center pad-all-15" >
                     <?php
                     $pageArrname = explode('/', $_SERVER['PHP_SELF']);
                     if (end($pageArrname) == 'inventoryListing') {
                         ?>
                     <ul class="nav nav-tabs active" id="navbar">
                             <li class="active" id="liemail"><a id='stock_email'  data-toggle="tab" href="#email" onclick="sendSmsNewVersion($('#custoMobile').val(),'','email',$('#email_id').val())">Email</a></li>
                             <li  class="" id="lisms"><a id='stock_sms' data-toggle="tab" href="#sms" onclick="sendSmsNewVersion($('#custoMobile').val(),'','message',$('#email_id').val())">SMS</a></li>        
                             <input type="hidden" name="car_id" value='' id='car_id' />
                         </ul>
                                             

                     <?php } else { ?>

                         <ul class="nav nav-tabs" id="navbar">
                             <li class="active"><a id='li_email'  data-toggle="tab" href="#email">Email</a></li>
                             <li ><a id='stock_sms'data-toggle="tab" href="#sms" >SMS</a></li>        
                             <input type="hidden" name="car_id" value='' id='car_id' />
                         </ul>
                     <?php } ?>
                     <div class="tab-content" >
                         <div id="email" class="tab-pane active in">
                             <div class="input-group mrg-T15">
                                 <div class="input-group-addon "><i class="fa envelope" data-unicode="f0e0"></i></div>
                                 <input name="txtEmail" type="email" onkeydown="" maxlength="100" placeholder="Enter Email" id="email_id" class="form-control search-form-select-box email-address" value="<?php //echo (($sqlRoleDetail['email']) ? $sqlRoleDetail['email'] : '') ?>">
                             </div>
                             <div id="stock_lead_cars">

                             </div> 
                         </div>  

                         
                         <div id="sms" class="tab-pane fade">
                             <div class="modal-body pad-all-15 pad-B0 pad-R0 pad-L0" id="stocksms_return" style="text-align:center">

                                 <div class="form-group">

                                     <div class="form-group text-left">

                                         <input id="custoMobile" onkeypress="return isNumberKey(event)" class=" custoMobile form-control search-form-select-box" type="text" maxlength="10" name="custoMobile" value="" placeholder="Enter Mobile Number">
                                     </div>
                                     
                                     <div class="form-group text-left">

                                         <textarea class="form-control search-form-select-box feedBack" name="stocksmsn" id="stocksmsn" placeholder="Type Here ..."></textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>    
                     <div class="modal-footer pad-B0 pad-T0 pad-L15 pad-R15">
                         <span  id="success_stock" style="color:green;font-family:Arial;font-size:14px"></span>
                         <span  id="error_stock" style="color:red;font-family:Arial;font-size:14px"></span>
                         <input type="hidden" name="send_type" class="share_type" value="email"/>
                         <?php if (end($pageArrname) == 'inventoryListing') {
                             ?>
                             <button type="button" class="btn btn-primary" id="stocksms_sub_v2" name="stocksms_sub_v2" onclick="sendSmsEmail()">Send</button>
                         <?php } else { ?>
                             <button type="button" class="btn btn-primary" id="stocksms_sub" name="stocksms_sub">Send</button>
                         <?php } ?>
                         <a type="button" class=" stocksms_cancel" data-dismiss="modal" id="stocksms_cancel">Cancel</a>
                         

                     </div>
                 </div>
             </div><!-- /.modal-comment -->
         </form>
     </div>
 </div>


<script>
  
        $("#stock_sms").click(function(){
                $(".share_type").val('sms');
        });
                $("#stock_email").click(function(){
                $(".share_type").val('email');
                });
  
</script>

