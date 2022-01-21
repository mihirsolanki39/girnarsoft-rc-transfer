<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="stockFeature">
     <div class="modal-dialog">
         <form name="stockfeature_form" id="stockfeature_form">
             <div class="modal-content" >
                 <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Featured</h4>
            </div>

            <i class="fa info-circle col-gray font-60" data-unicode="f05a"></i>

            <p class="edit-text font-14 pad-L20 pad-R20">
                                    
                    Are You Sure Want To Add Selected Car As Featured.            </p>

            <div class="modal-footer">
                <img class="premiumloader" style="display:none;width:30px;" src="<?php echo base_url(); ?>assets/images/loader.gif" >
                <span style="color:green;" class="success"></span>

                <button type="button" class="btn btn-default makepremiumcancel" data-dismiss="modal">Cancel</button>
                <input type="Button" value="YES" class="btn btn-primary" onclick="make_premium()" name="submit" id="submitbluk">
             </div>
             </div><!-- /.modal-comment -->
             <input type="hidden" name="carids" id="carids" value="">
             <input type="hidden" name="type" id="type" value="">
         </form>
     </div>
 </div>