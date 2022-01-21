<i style="font-size:85%;color:#777">* Uploaded RC and Service history will be used for internal verification purpose only. It will not be shown on website or shared with anyone.</i>
<div class=" clearfix " style="margin-top: 32px" onmousedown="return false"> 
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6" >
            <div class="form-group mrg-B29">
                <label for="" class="customize-label">Upload RC Doc</label>
                <div class="form-group fg-docs">
                    <input type="file" id="rc_img_file" name="rc_img_file[]" class="file invt-docs">
                    <input type="hidden" name="rc_img_url" id="rc_img_url" class='hidden-img-name' value='<?= isset($inventory_docs['rc_img_url']) ?  $inventory_docs['rc_img_url'] : '' ?>'>

                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control customize-form cs_form" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                            <button class="browse btn btn-primary btn-B upload-doc" type="button">Browse</button>
                        </span>
                    </div>
                    <input type="hidden" value="0" class="hasError" id="hasRcError" />
                    <label class="image-error-message"></label>
                    <div><p class="doc-image-name"><?= isset($inventory_docs['rc_img_url']) ? end(explode('/', $inventory_docs['rc_img_url'])) : '' ?></p>
                    <div class="docs-image-del  delete-logo-banner" data-view="rc_img_file_view" id="rc_img-del"><?= !empty($inventory_docs['rc_img_url']) ?'<i class="fa fa-times-circle" aria-hidden="true"></i>' : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group mrg-B29">
                <div class="up_image captailize" style="display:<?= !empty($inventory_docs['rc_img_url']) ?'block' : 'none' ?>" id="rc_img_file_view"><a  href="#" data-toggle="modal" data-target="#view-rc-doc">View RC Image</a></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6" >
            <div class="form-group mrg-B29">
                <label for="" class="customize-label">Upload Service History Images#1</label>
                <div class="form-group fg-docs">
                    <input type="file" id="supporting_doc_1_file" name="supporting_doc_1_file[]" class="file invt-docs" >
                    <input type="hidden" name="supporting_doc_1_url" class='hidden-img-name' id="supporting_doc_1_url" value='<?= isset($inventory_docs['supporting_doc_1_url']) ? $inventory_docs['supporting_doc_1_url']: '' ?>' >

                    <div class="input-group col-xs-12">
                       <!--<span class="input-group-addon custom-group"><i class="glyphicon glyphicon-picture font-20"></i></span>-->
                        <input type="text" class="form-control customize-form cs_form" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                            <button class="browse btn btn-primary btn-B upload-doc" type="button">Browse</button>
                        </span>
                    </div>
                    <input type="hidden" value="0" class="hasError" id="hasSH1Error" />
                    <label class="image-error-message"></label>
                    <div><p class="doc-image-name"><?= isset($inventory_docs['supporting_doc_1_url']) ? end(explode('/', $inventory_docs['supporting_doc_1_url'])) : '' ?></p>
                     <div class="docs-image-del  delete-logo-banner" data-view="supporting_doc_1_file_view"  id="supporting_doc_1"><?= !empty($inventory_docs['supporting_doc_1_url']) ?'<i class="fa fa-times-circle" aria-hidden="true"></i>' : '' ?></div>
                    </div>
                    </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group mrg-B29">
                <div class="up_image captailize"  id="supporting_doc_1_file_view" style="display:<?= !empty($inventory_docs['supporting_doc_1_url']) ?'block' : 'none' ?>" ><a href="#"   data-toggle="modal" data-target="#view-sh-doc1">View Service History Images #1</a></div>
            </div>
        </div>


    </div>
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-6" >
            <div class="form-group mrg-B29">
                <label for="" class="customize-label">Upload Service History Images#2</label>
                <div class="form-group fg-docs">
                    <input type="file" id="supporting_doc_2_file" name="supporting_doc_2_file[]" class="file invt-docs">
                    <input type="hidden" name="supporting_doc_2_url" class='hidden-img-name' id="supporting_doc_2_url" value='<?= isset($inventory_docs['supporting_doc_2_url']) ? $inventory_docs['supporting_doc_2_url']: '' ?>'>

                    <div class="input-group col-xs-12">
                       <!--<span class="input-group-addon custom-group"><i class="glyphicon glyphicon-picture font-20"></i></span>-->
                        <input type="text" class="form-control customize-form cs_form" disabled placeholder="Upload Image">
                        <span class="input-group-btn">
                            <button class="browse btn btn-primary btn-B upload-doc" type="button">Browse</button>
                        </span>
                    </div>
                    <input type="hidden" value="0" class="hasError" id="hasSH2Error" />
                    <label class="image-error-message"></label>
                    <div><p class="doc-image-name"><?= isset($inventory_docs['supporting_doc_2_url']) ? end(explode('/', $inventory_docs['supporting_doc_2_url'])) : '' ?></p>
                     <div class="docs-image-del  delete-logo-banner" data-view="supporting_doc_2_file_view"  id="supporting_doc_2"><?= !empty($inventory_docs['supporting_doc_2_url']) ?'<i class="fa fa-times-circle" aria-hidden="true"></i>' : '' ?></div>
                    </div>
                    </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="form-group mrg-B29">
                <div class="up_image captailize" id="supporting_doc_2_file_view" style="display:<?= !empty($inventory_docs['supporting_doc_2_url']) ?'block' : 'none' ?>"  ><a href="#"   data-toggle="modal" data-target="#view-sh-doc2">View Service History Images #2</a></div>
            </div>
        </div>
    </div>
</div> 


<!-- Modal starts-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view-rc-doc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Uploaded RC Doc Image</h4>
            </div>
            <div class="modal-body">
                <div class="up-img-preview">
                    <img src="<?= isset($inventory_docs['rc_img_url']) ? $inventory_docs['rc_img_url']:base_url('assets/images/noImageUploaded.png')   ?>"  class="img-responsive doc-files-imges" id='rc_img_file_src'>
                </div>
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view-sh-doc1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Uploaded Service History Images #1</h4>
            </div>
            <div class="modal-body">
                <div class="up-img-preview">
                    <img src="<?= isset($inventory_docs['supporting_doc_1_url']) ? $inventory_docs['supporting_doc_1_url']:base_url('assets/images/noImageUploaded.png')   ?>"  class="img-responsive doc-files-imges" id='supporting_doc_1_file_src'>
                </div>
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view-sh-doc2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Uploaded Service History Images #2</h4>
            </div>
            <div class="modal-body">
                <div class="up-img-preview">
                    <img src="<?= isset($inventory_docs['supporting_doc_2_url']) ? $inventory_docs['supporting_doc_2_url']:base_url('assets/images/noImageUploaded.png')   ?>"  class="img-responsive doc-files-imges" id='supporting_doc_2_file_src'>
                </div>
            </div>
        </div>
        <!-- /.modal-comment -->
    </div>
</div>


<script src="<?=base_url('assets/js/uploading_docs.js'); ?>"></script>
<style>
    .file { visibility: hidden; position: absolute;}
    .upload-doc{border-top-left-radius: 0 !important; border-bottom-left-radius:0 !important; height: 40px !important; border-radius: 2px; padding: 6px 20px; border-bottom: 1px solid rgba(0,0,0,0.12) !important; }
    .upload-doc:hover{  color:#fff !important;}
    .upload-doc.active.focus, .upload-doc.active:focus, .upload-doc.active:hover, .upload-doc:active.focus, .upload-doc:active:focus, .upload-doc:active:hover, .open>.dropdown-toggle.upload-doc.focus, .open>.dropdown-toggle.upload-doc:focus, .open>.dropdown-toggle.upload-doc:hover{ background: #fff; border-color:rgba(0,0,0,0.12) !important; color:rgba(0,0,0,0.87);}
    .customize-form{background-color: #fff !important;}
    .upload-doc:hover, .upload-doc:focus, .upload-doc.focus, .upload-doc:active, .upload-doc.active, .open>.dropdown-toggle.upload-doc{color:#fff;}
    .custom-group{background: #fff; border-color:rgba(0,0,0,0.12); padding: 6px 15px;}
    .up_image{padding: 43px 20px; font-size: 16px;}
    .up_image a:focus, .up_image a:hover{color: #ed6b36;}
    .up-img-preview{min-height: 225px;}
    .cs_form{border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;}


    #carousel_inner {min-height:450px;max-height:450px;overflow-y:auto;}

    #carousel_editImg img{margin: 0 auto;}

    .carousel-caption{background:rgba(0, 0, 0, 0.15)}
    .doc-image-name{width: 291px;word-wrap: break-word;}
    .docs-image-del {
    position: absolute;
    top: 85px;
    right: 23px;
    color: #ed6b36;
    font-size: 21px;
}
.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    cursor: pointer;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.image-error-message span p{
    display: inline;
}

    
    
</style>

<script>
    
    var faCross ='<i class="fa fa-times-circle" aria-hidden="true"></i>';
    var ASSET_PATH= '<?=HOST_ROOT_STOCK?>';
    var APP_ENV= '<?=APPLICATION_ENV?>';
    $(document).on('click', '.browse', function ()
    {
        var file = $(this).parent().parent().parent().find('.file');
        file.trigger('click');
    });
    $(document).on('change', '.file', function ()
    {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });

    $('input[type=file]').on('change', function (event)
    {
        var ids = '#' + this.id;
        $(ids).parent().find('.image-error-message').html('');
        var files = event.target.files;
        var data = new FormData();
        $.each(files, function (key, value)
        {
            data.append('file', value);
        });

        $.ajax({
            url: "<?php echo base_url() . 'inventories/upload_inventory_docs'; ?>",
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            beforeSend:function(){
                $('#savedetail').prop('disabled',true);
                $('#Preview').prop('disabled',true);
                $(ids+'_view').css('display','none');
                $(ids).parent('.fg-docs').find('p.doc-image-name').html('<span style="color:grey" >uploading ...</span>');
            },
            success: function (data, textStatus, jqXHR)
            {
                $('#savedetail').prop('disabled',false);
                $('#Preview').prop('disabled',false);
                
                $('#doc_error_count').val(0);
                if (data.success == 1)
                {
                    //alert(ids);
                    //if(ids=='#rc_img_file'){
                       $(ids+'_view').css('display','block');
                    //}
                    $(ids).next().val(data.url);
                    $(ids + '_src').show();
                    $(ids + '_src').attr('src', data.url+'?t='+Date.now());
                    $(ids).parent('.fg-docs').find('p.doc-image-name').text(data.image_name);
                    $(ids).parent('.fg-docs').find('.docs-image-del').html(faCross);
                    $(ids).parent().find('.hasError').val(0);
                }
                if (data.success == 0)
                {
                    $(ids).next().val(data.url);
                    $(ids + '_src').show();
                    $(ids + '_src').attr('src',ASSET_PATH+'noImageUploaded.png');
                    $(ids).parent('.fg-docs').find('p.doc-image-name').text(data.image_name);
                    $(ids).parent('.fg-docs').find('.docs-image-del').html('');
                    
                    $(ids).parent().find('.hasError').val(1);
                    $(ids).parent().find('.image-error-message').css('color', '#a94442');
                    $(ids).parent().find('.image-error-message').html('<span>'+data.message+' <i class="fa fa-times-circle upload-errors" aria-hidden="true"></i>');
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
            }
        });
    });


    $('#carousel_editImg').carousel({
        pause: true,
        interval: false
    });
    
    
    $('.docs-image-del').click(function(e){
    
       if(confirm('Are you sure you want to delete this image?')){
           $(this).siblings('p').html('');
           $(this).html('');
           var hiddenInputImgName=$(this).parents('.fg-docs').children('input.hidden-img-name');
           var imageFileInput=$(this).parents('.fg-docs').children('input[type=file]');
           var uploadImageInput=$(this).parents('.fg-docs').find('input.cs_form');
           var errorLabel=$(this).parents('.fg-docs').find('label.image-error-message');
           var modal_img_src= imageFileInput.attr('id')+'_src';
           
           $('#'+modal_img_src).attr('src',ASSET_PATH+'noImageUploaded.png');
           $('#'+$(this).attr('data-view')).css('display','none');
           errorLabel.html('');
           imageFileInput.val('');
           hiddenInputImgName.val('');
           uploadImageInput.val('');
           imageFileInput.attr('id');
       }
    });
    
    $('.image-error-message').click(function(){
       $(this).html('');
       $(this).parents('.fg-docs').find('input.cs_form').val('');
       $(this).siblings('input[type=file]').val('');
       $(this).parents('.fg-docs').children('input.hidden-img-name').val('');
       $(this).parent().find('.hasError').val(0);
       
    });
    
    $(document).ready(function(){
       if($('.carousel-inner .item img').attr('src') == '') { 
          $('.carousel-control').css('display', 'none');
        }
    });
    if(APP_ENV!=='local'){
        $(document).keydown(function(e){
            if(e.which === 123){
         
               e.preventDefault();
               return false;
         
            }
         
        });
        $(document).bind("contextmenu",function(e) { 
          e.preventDefault();
         
        });
    }
    

</script>
