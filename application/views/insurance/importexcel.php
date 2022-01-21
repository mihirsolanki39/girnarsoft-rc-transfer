<div class="container-fluid mrg-all-20">
    <style>.dot-sep{content: ""; height: 4px; width: 4px; background: rgba(0,0,0,0.3); border-radius: 15px; display: inline-block; margin: 3px 7px;} </style>
   <div class="row">
      <div class="">
         <div class="cont-spc pad-all-20" id="buyer-lead">
              <?php if(!empty($rowmsgs_error)){ ?> <span class="text-danger" ><?php echo $rowmsgs_error; ?> </span> <?php } ?>
              <?php if(!empty($rowmsgs_success)){ ?> <span class="text-success" ><?php echo $rowmsgs_success; ?> </span> <?php } ?>
                  <div class="row">
                    <form  action="uploadinsFile" id="import_form11" method="post" enctype="multipart/form-data">  
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Upload File</label>
                        <input type="file" name="uploadfile" id="uploadfile" class="form-control crm-form">            
                     </div>
                        
                     <div class="col-md-2 pad-R0">
                        <span id="spnsearch">
                            <input type="submit" class="btn-save btn-save-new" value="Upload" name="SubmitButton" id="upload">
                        </span>
                     </div>
                    </form>
                      <div class="col-md-2 pad-R0" style="padding-top: 220px;">
                      </div>    
                  </div>
               </form>
            </div>
      </div>
   </div>
</div>
<script>
$(document).ready(function(){

 $('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>insurance/uploadinsFile",
   method:"POST",
   data:new FormData(this),
   contentType:false,
   cache:false,
   processData:false,
   success:function(data){
    $('#uploadfile').val('');
    //load_data();
    alert(data);
   }
  })
 });

});
</script>

