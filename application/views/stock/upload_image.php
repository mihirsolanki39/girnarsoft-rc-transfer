<div class="tab-pane" id="ptabp-hoto4"><!--Tab4 -->
    <div class="row mrg-all-0 mrg-B0 mrg-T0">
          <fieldset class="fieldset pad-B0"> 
      <legend class="text-warning pad-T0 mrg-B10"><strong>Upload Photos</strong></legend> 
  </fieldset> 
  <div class="row form-group"> 
      <img href="javascript:void(0)" src="" class="main-img"  id="notdrag" onmousedown="return false" draggable="false"> 
    </div> 
    <div class="col-sm-12 iframe-div"> 
        <?php
          if($car_id) { 
            $upload_action = 'stock/upload_new_image/'.$car_id;    
          } else {
            $upload_action = 'stock/upload_new_image/';
          }
        
        ?>
        <form action="<?php echo base_url().$upload_action; ?>" class="dropzone dz-clickable clearfix dropzone-E" id="stock-upload">
          <?php
          
          foreach ($imageMapArray as $k=> $images)
          {
              if ($images['id'] != '')
              {
              ?>
              <div id="dz-div-<?= $images['id'] ?>" class="dz-preview dz-file-preview">
                  <div class="dz-details">
                      <div class="dz-filename"><span data-dz-name></span></div>
                      <div class="dz-size" data-dz-size></div>
                      <img data-dz-thumbnail src="<?= $images['image_url'];?>"/>
                  </div>
                  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                  <div class="dz-success-mark"><span>✔</span></div>
                  <div class="dz-error-mark"><span>✘</span></div>
                  <div class="dz-error-message"><span data-dz-errormessage></span></div>
                  <a class="dz-remove" href="javascript:removeStckImg('<?= $images['image_name'] ?>','<?= $images['id'] ?>');" data-dz-remove="">Remove</a>
              </div>
              <?php
              }
          }
          ?>
          <div id="file" <?php if(count($imageMapArray) > 0) { ?>style="display:none;"<?php } ?> class="dz-default dz-message"><span>Drop files here to upload</span></div>
        </form>
    </div> 
  </div>  
    </div>
</div>
<script type="text/javascript">
function removeStckImg(name,id='') {
          //alert(name+' = '+id);
        if(id != ''){                            
          if(confirm('Are You Sure You Want To Delete Image')){
              jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>inventories/ajax_image_delete/",
                data: {image_id: + id},
                dataType: "json",
                success: function (result) {
                    //alert(result);
                    $('#dz-div-' + id).remove();
                    //alert(result.response.data.error);
                }

            });
          }
        }else{
          jQuery.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>inventories/ajax_image_delete",
              data: {name:name},
              dataType: "json",
              success: function (result) {
                //$('#dz-div-' + imageId).remove();
                  //alert(result.response.data.error);
              }

          });
        }
    }

</script>

