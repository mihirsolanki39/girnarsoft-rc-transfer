<!-- Modal content-->
<div class="modal-content" style="width: 700px; margin: auto !important;">
    <div class="modal-header modal-header-custom">
        <button type="button" class="close" id="uploadImage" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"></button>
        <h4 class="modal-title">View Images</h4>
        <div id="photo-popup"><span><?=$carDetails['mm_my']?></span> <span class="dv"></span> <span><?=$carDetails['km_driven']?> Kms</span> <span class="dv"></span> <span><?=!empty($carDetails['reg_no'])?$carDetails['reg_no']:'NA'?> Reg No.</span></div>
    </div>
    <div class="modal-body popcls">
        <div class="row">
            <div class="col-sm-12">
                <div class="tabbable mrg-B20">
                    <div class="row mrg-B5">
                        <div class="col-sm-12 col-md-12">
                            <div class="btn-group float-ini mrg-T5mrg-L20" role="group" aria-label="First group">
<!--                                <a aria-expanded="true" rel="" class="btn btn-default" id="uploadmanagePhtos" onclick="uploadmanagePhtos()" >Upload Photos</a>
                                <a  role="tab" rel="" class="btn btn-default active" id="TagneweditedPhotos" onclick="tagnew()" >Tag Photos</a>-->
                                <a  role="tab" rel="" class="btn btn-default image_tabs active" onclick="viewActiveImage('<?=$car_id?>')"  id="vieweditedphotos">View Photos<span class="badge" id="available_active_img"><?=$image_count['active']?></span></a>
                                <a  href=".showAlltab" role="tab" class="btn btn-default image_tabs"onclick="viewFlaggedImage('<?=$car_id?>')"  id="flagedPhotos" data-toggle="tab" aria-controls="profile" aria-expanded="false">Flaged Photos<span class="badge" id="available_flaged_img"><?=$image_count['flagged']?></span></a>
                                <a  href=".showAlltab" role="tab" class="btn btn-default image_tabs"onclick="viewRejectedImage('<?=$car_id?>')"  id="rejectedPhotos" data-toggle="tab" aria-controls="profile" aria-expanded="false">Rejected Photos<span class="badge" id="available_rejected_img"><?=$image_count['rejected']?></span></a>
                            </div>
                            <div class="shoImgg" id="shoImgg"> 


                            </div>
                            <input type="hidden" name="carImgId" id="carImgId" value="">
                        </div>
                    </div>     
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var carId='<?=$car_id?>';
    function viewActiveImage(car_id){
        $.ajax({
            type: "POST",
            url: "stock/all_images",
            dataType: 'html',
            data: {car_id: car_id,status:'active'},
            success: function(data){
             $('#shoImgg').html(data);
            }
        });
   }
   viewActiveImage(carId);
   
   function viewRejectedImage(car_id){
        $.ajax({
            type: "POST",
            url: "stock/all_images",
            dataType: 'html',
            data: {car_id: car_id,status:'rejected'},
            success: function(data){
             $('#shoImgg').html(data);
            }
        });
   }
   function viewFlaggedImage(car_id){
        $.ajax({
            type: "POST",
            url: "stock/all_images",
            dataType: 'html',
            data: {car_id: car_id,status:'flagged'},
            success: function(data){
             $('#shoImgg').html(data);
            }
        });
   }
   $('.image_tabs').click(function(){
       $('.image_tabs').removeClass('active');
       $(this).addClass('active');
   });
</script>	
