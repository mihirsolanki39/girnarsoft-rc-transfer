<div class="tab-pane active bg-gray pad-T10 pad-B10" id="ptab-photo3"><!--Tab3 -->
    <form name="tag_photos" id="save_tags_new" method="post">
        <input type="hidden" name="type" id="type" value="save_Tags_manageinv">
        <input type="hidden" name="car_id" id="car_id" value="<?php echo $car_id; ?>">

        <?php
        //print_r($getAllImage); exit;
        if (!empty($getAllImage))
        {
            ?>
            <button type="submit" class="btn btn-primary mrg-L15" >Save All Tags</button>
            <button type="button" class="btn btn-default" id="clearTags">Clear All Tags</button>
<?php } ?>
        <div class="clearfix pad-T15 tag-photo-scroll" id="ptab-scroll">
            <div class="row mrg-all-0 mrg-B10">
                <?php
               /* echo "<pre>";
                print_r($getAllImage);
                exit;*/
                if (!empty($getAllImage))
                {
                    $d = 0;
                    foreach ($getAllImage as $key => $vals)
                    {
                        $tag_id=$imageTags[$vals['image_name']];
                        $image=explode('.',$vals['image_name']);
                        $Image=$image[0];
                        ?>
                        <div class="col-md-6">
                            <div class="row tag-photo-bg mrg-all-0 mrg-B10">
                                <div class="col-xs-5 col-md-4 pad-all-0">								
                                    <div class="recent-list-img">
                                        <img class="img-responsive" alt="64x64" src="<?php echo $vals['image_url'] ?>">
                                        <input type="hidden" name="img[]" id="img_<?= $d ?>" value="<?= $vals['image_name'] ?>">
                                    </div>                        			
                                </div>
                                <div class="col-xs-7 col-md-8 pad-R5">
                                    <textarea class="form-control small-textarea mrg-T5 arraytypefield" placeholder="Description" id="desc_<?= $d ?>" name="desc[]"></textarea>
                                    <div id="selectTags">
                                        <select name="<?=$Image?>" id="tag_<?= $d ?>" class="form-control search-form-select-box mrg-T5 mrg-L0 arraytypeselect">
                                            <option value="0" class="jMake">Select Tag Name</option>
                                            <?php
                                            foreach ($getAllTags as $key => $val)
                                            {
                                                ?>
                                                <?php
                                                if ($val['parent'] == '0')
                                                {
                                                    ?>
                                                    <optgroup label="<?= $val['tag_name']; ?>">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?> 
                                                        <option  value="<?= $val['id']; ?>" <?php echo (($tag_id == $val['id']) ? "selected" : '0'); ?>><?= $val['tag_name']; ?></option>
            <?php } ?>
        <?php } ?>
                                        </select> 									
                                    </div>									
                                </div>
                            </div>
                        </div>
                        <?php
                        $d++;
                    }
                    ?>        
                <?php
                }
                else
                {
                    ?>
                    <div style="text-align:center;padding-top:30px;">You have not upload any image yet. Please upload images.</div>
<?php } ?>                                 
            </div>                                    
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(function () {
            $("#save_tags_new").submit(function (event) {
                var myData = $("#save_tags_new").serializeArray();
                $.ajax({
                    url: 'stock/saveTagsManageInv',
                    type: 'POST',
                    data: myData,
                    dataType:'json',
                    success: function (response) {
                        if(response=='1'){
                            alert('Tag Updated Successfully');
                        }
                        else{
                            alert('Unsuccessfull Update');
                        }
                    }
                });
                return false;
            });
        });
        $(function () {
            $("#clearTags").click(function () {
                if (confirm("Are you sure you want to clear all tags?"))
                {


                    $("#save_tags_new")[0].reset();
                    $('.arraytypefield').val('');
                    $('.arraytypeselect').val('0');
                }
            });

        });
    });
</script>
