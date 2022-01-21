<?php
//$imageList[0]['id']; exit;
$is_admin=$this->session->userdata['userinfo']['is_admin'];
$addPerm=isset($permission[0]['add_permission']) ? $permission[0]['add_permission'] :'' ;
$editPerm=isset($permission[0]['edit_permission']) ? $permission[0]['edit_permission']:'';
$viewPerm=isset($permission[0]['view_permission']) ? $permission[0]['view_permission'] : '';
$roleType=isset($permission[0]['role_name']) ? $permission[0]['role_name'] : '';
$mode=(!empty($CustomerInfo['upload_ins_doc_flag'])) ? 'edit' : 'add';
$stylec = 'display:block';
$action = ($mode=='edit')? base_url('insListing/') :'';?>
<div class="sec-card">
    <ul class="nav nav-tabs nav-uptag" role="tablist">
        <li role="presentation" class="active"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab" onclick="login()" id="uploadimage">UPLOAD</a></li>
        <li role="presentation"><a href="#tag" aria-controls="tag" role="tab" data-toggle="tab" id="tagimage">TAG</a></li>

    </ul>
        
    <div class="col-md-12 clearfix">
       
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="upload">
        <?php if (!empty($imageList)) { ?>
            <div class="col-md-12">
                <div class=" downloadAllImg" style="text-align: right; position: absolute; right: 0;top: -70px;">
                    <a id="downloadAll" alt="Download all images" onclick="downloadAll()" > Download All </a>
                    <a id="removeAll" class="pad-L10" alt="remove all images" onclick="removeAll()" > Remove All </a>
                </div>
                <!--<div class="removeAllImg" style="top:0px!important;">
                        
                </div>-->
            </div>
                <?php } ?>
                <form class="needsclick  <?php if (!empty($imageList)) { ?> dz-clickable bg-none <?php }?>" <?php if (!empty($imageList)) { ?> style="border-width: 0px;" <?php } ?>   id="demoUpload">
                        <div id="preview" <?php if (!empty($imageList)) { ?> class="ui-sortable"<?php }?> >
                            <?php
                            $j = 1;
                            $tagId = [];
                            $pendency_doc_ids = [];
                            if (!empty($imageList)) {

//echo "<pre>";print_r($imageList);die;
                                foreach ($imageList as $ikey => $ival) {
                                    if (!empty($ival['sub_id'])) {
                                        $tagId[$ival['sub_id']][] = $ival['sub_id'];
                                    }
                                    $type= end(explode('.',$ival['doc_name']));
                                    ?>
                                         <div class="dz-preview dz-image-preview">
                                            <div class="dz-image">
                                                <?php if(strtolower($type)=='pdf'){ ?>
                                                            
                                                        <embed src="<?=$ival['doc_url']?>" type="application/pdf"   height="100%" width="100%">
                                                      <?php  }
                                                      else{ ?>
                                                          
                                                      <img data-dz-thumbnail="" alt="<?=$ival['doc_name']?>" src="<?=$ival['doc_url']?>">
                                                     <?php }?>
                                            </div>
                                            <div class="dz-details">
                                                <div class="dz-size">
                                                </div>
                                                <div class="dz-filename">
                                                    <span data-dz-name=""><?php echo (!empty($ival['name']) ? $ival['name'] : '') ?></span>
                                                </div>
                                            </div>
                                            <div class="dz-progress">
                                                <span class="dz-upload" data-dz-uploadprogress=""></span>
                                            </div>
                                            <div class="dz-error-message" <?php if (empty($ival['err']) && ($ival['err'] == 0)) {
                        ?>style="display:none;" <?php }?>>
                                                     <span data-dz-errormessage=""><?php if (!empty($ival['err'])) {
                            echo ($ival['err'] == '1') ? 'Incorrect Doc' : 'Unclear Image';
                        } ?></span>
                                                </div>
                                                <div class="tag tagClass_<?php echo $j ?>" id="<?php echo $ival['id'] ?>">Tag</div>
                                                <div class="dz-success-mark"></div>
                                                <div class="dz-error-mark">
                                                    <?php if (($is_admin == '1') || ($roleType == 'Executive' && $CustomerInfo['upload_ins_doc_flag'] == '1')) { ?> 
                                                        <div class="del-btn" id="del_<?php echo $ival['id'] ?>" onclick="delImg(this)">×</div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php $j++;
                                        }
                                    }
                                    ?>

                                </div>
                                <div class="addfile" id="secUploadBtn" <?php if (!empty($imageList)) { ?> style="display:block;" <?php }?>></div>
                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tag">
                                <div class="row">
                                    <div class="options" style="text-align: right;margin-bottom:10px !important;position:relative !important;">
                                        <ul class="options-ul">
                                            <li><a href="#" class="option-list" data-toggle="modal" data-target="#markIncorrect">MARK INCORRECT</a></li>  
                                            <li><a href="#" class="option-list" data-toggle="modal" data-target="#addPendency" onclick="getCategoryList()">ADD PENDENCY</a></li>  
                                        </ul> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="clearfix">
                                                    <ul>
                                                        <li><a class="option-list pull-left pending-img"><span id="tagCount"></span> Image needs to tag.</a></li>
                                                            <li><a class="option-list pull-right remove-tag" id="removeTag" style="display: none;">REMOVE TAG</a></li>
                    
                                                    </ul> 
                                                </div>
                                                <div id="image-gallery">
                                                    <div class="image-container"></div>
                                                    <!--<div class="action-buttons">
                                                       <button class="gallery-zoom-in zoom-sprite ic-zoom-in"> </button>
                                                       <button class="gallery-zoom-out zoom-sprite ic-zoom-out"></button>
                                                       <button class="rotate zoom-sprite ic-rotate"> </button>
                                                       <button class="rotate-back zoom-sprite ic-fullscreen"></button>
                                                    </div>-->
                                                    <div class="img-tag-name" style="display:none;" id="img_tag_name"></div>
                                                    <img src="<?php echo base_url() ?>assets/images/left.svg" class="prev"/>
                                                    <img src="<?php echo base_url() ?>assets/images/left.svg" class="next"/>

                                                </div>
                                            </div>
                                            <?php // echo "<pre>";print_r($uploadDocList);die;?>
                                            <div class="col-md-4">
                                                <div class="panel-group" id="accordion">
                                                    <!------>
                                                    <?php
                                                  //  echo "<pre>";print_r($uploadDocList);die;
                                                    $i = 1;
                                                    foreach ($uploadDocList as $key => $val) {
                                                        $req = '';
                                                        if ($val['is_require'] == '1') {
                                                            $req = '*';
                                                        }
                                                        ///$style = '';
                                                      /*if (!empty($tagId)) {
                                                            foreach ($tagId as $ksel => $vsel) {
                                                                //$style[$key]='';
                                                                if ($key == $ksel) {
                                                                    $style[$key] = 'style="display: inline;"';
                                                                }
                                                            }
                                                        }*/
                                                         if(!empty($allParentIds))
                                                            {
                                                              foreach ($allParentIds as $ksel=>$vsel) 
                                                              {
                                 foreach($vsel as $ks =>$vs)
                                 {
                                  if($key==$vs)
                                  {
                                    $style[$key]='style="display: inline;"';
       
                                  }
                                }
                            }}
                                                        if (!empty($pendencyDoc)) {
                                                            $error = [];
                                                            $pendencyStr = '';
                                                          
                                                            foreach ($pendencyDoc as $pkey => $pval) {
                                                                $pendencyStr .= $pval['doc_id'].',';
                                                                if ($pval['doc_parent_id'] > 0) {
                                                                    $error[$pval['doc_parent_id']] = 'style="display: inline;"';
                                                                } else {
                                                                    $error[$pval['doc_id']] = 'style="display: inline;"';
                                                                }
                                                                if($pval['pendency_doc_id']!='')
                                                                {
                                                                    $pendency_doc_ids[] = $pval['pendency_doc_id'];
                                                                }
                                                            }
                                                        }
                                                        // exit;
                                                        //style="display: inline;" badge
                                                        ?>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" id="doc_<?php echo $key ?>">
                                                                <h4 class="panel-title">
                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i ?>" id="doct_<?php echo $key ?>" class="collapsed">
                                                        <?php echo $val['name'] ?> <?php echo $req ?> 
                                                                        <span class="tick" <?php echo ((!empty($style[$key]) && empty($error[$key])) ? $style[$key] : ''); ?> id="tick_<?=$key?>">
                                                                              <img src="<?php echo base_url() ?>assets/images/tick-green.svg" alt="Doc Uploaded">
                                                                        </span>
                                                                        <span class="error" id="err_<?=$key?>" <?php echo (!empty($error[$key]) ? $error[$key] : '') ?> >
                                                                            <img src="<?php echo base_url() ?>assets/images/error.svg" alt="Error">
                                                                        </span>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <ul class="child-drop">
                        <?php 
                        $v = [];
                        foreach ($val['subList'] as $subkey => $subval) {
                            $subreq = '';
                            $addfrm = '';
                            if(in_array($subval['sub_category_id'], $pendency_doc_ids))
                            {
                                $addfrm = 'active';
                            }
                            if ($subval['is_require'] == '1') {
                                $subreq = '*';
                            }
                            foreach ($tagId as $ksel => $vsel) {
                                $count = 0;
                                foreach ($vsel as $vk => $vv) {
                                    if (intval($subval['sub_category_id']) == intval($vv))
                                        $count = intval($count) + 1;
                                    //$v[$subkey]= 'badge_'.$count;
                                }
                                if ($count > 0) {
                                    $v[$subkey] = 'badge_' . $count;
                                }
                            }

                            $arrClass = [];
                            if (!empty($v[$subkey])) {
                                $arrClass = explode('_', $v[$subkey]);
                                if ($arrClass[1] == 0) {
                                    $arrClass = [];
                                }
                            } ?>
                            <li class="app-form subrc_<?=$subval['sub_category_id']?>  <?php echo $addfrm?> <?php echo (!empty($arrClass)) ? 'active' : ''; ?>" id="sudbreq_<?php echo $subkey; ?>" rel="subr_<?=$subval['sub_category_id']?>"  onclick="imageTagging(this)">
                                <?php echo $subval['name']; ?>  <?php echo ' '.$subreq; ?>
                                <span id="subclass_<?php echo $subkey; ?>" class="subr_<?php echo $subval['sub_category_id']?> badg <?php echo (!empty($arrClass)) ? $arrClass[0] : ''; ?>"><?php echo (!empty($arrClass)) ? $arrClass[1] : ''; ?></span>
                            </li>
                        <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                  <?php $i++; } ?>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="case_id" value="<?php echo (!empty($CustomerInfo['id'])) ? $CustomerInfo['id'] : '' ?>" id="case_id">
                                    <input type="hidden" name="inscategory" value="<?php echo (!empty($CustomerInfo['ins_category'])) ? $CustomerInfo['ins_category'] : '' ?>" id="inscategory"> 
                                    <input type="hidden" name="tagId" value="<?php echo (!empty($imageList[0]['id'])) ? $imageList[0]['id'] : '' ?>" id="tagId"> <!--current image id -->
                                    <input type="hidden" name="tagdocId" value="" id="tagdocId"> 
                                    <input type="hidden" name="customer_id" value="<?php echo (!empty($CustomerInfo['customer_id'])) ? $CustomerInfo['customer_id'] : '' ?>" id="customer_id"> <!--current customer id -->
                                    <input type="hidden" name="imagesId" value="" id="imagesId">
                                    <input type="hidden" name="imags" id="imags" value="">
                                    <input type="hidden" name="curr_img" value="" id="curr_img">
                                    <input type="hidden" name="allImgId" value="" id="allImgId">
                                    <input type="hidden" name="current_i" value="<?php echo $j ?>" id="current_i"> 
                                    <input type="hidden" name="tagging_id" value="" id="tagging_id"> 
                                    <input type="hidden" name="counttagid" value="" id="counttagid"> 
                                    <input type="hidden" name="tagIdAccImg" value="<?php echo (!empty($imageList[0]['tag_id'])) ? $imageList[0]['tag_id'] : '' ?>" id="tagIdAccImg"> 
                                    <div class="col-md-12">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-sec-width tag-btn-complete">
                    <?php if(($is_admin=='1') || (($addPerm=='1') && ($mode=='add')) ||  (($editPerm=='1') && ($mode=='edit'))){?>
                    <input  style="text-align: center" type="button" name="btnform7" id="btnform7" class="btn-continue" value="SAVE AND CONTINUE">    
                    <?php } elseif(($viewPerm=='1') && ($mode=='edit') || (!empty($CustomerInfo['payment_by']))){ ?>
                        <button type="button" class="btn-continue" onclick="countinue('<?php echo $action?>')" style="<?php echo $stylec?>">CONTINUE</button>
                    <?php } ?>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="modal fade" id="markIncorrect" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header modal-header-custom">
                                    <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url() ?>assets/images/close-model.svg" alt=""></button>
                                    <div class="row">
                                        <div class="col-md-9 clearfix">
                                            <h4 class="modal-title">Report Incorrect Document</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control crm-form" name="markincor" id="markincor">
                                                    <option value="0">Select Reason</option>
                                                    <option value="1">Incorrect Doc</option> 
                                                    <option value="2">Unclear Image</option>   
                                                </select> 
                                                <div class="d-arrow d-arrow-modal"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 clearfix  textcenter">
                                            <a href="#" class="btn-continue btn-proceed pop-btn" onclick="markIncorrect()" data-dismiss="modal">Save</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addPendency" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header modal-header-custom">
                                    <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url(); ?>assets/admin_assets/images/close-model.svg" alt=""></button>
                                    <div class="row">
                                        <div class="col-md-6 clearfix">
                                            <h4 class="modal-title">Add Pendency</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                     <div class="error" id="pendencyErr"></div>
                                        <div class="col-md-12">
                                           
                                            <div class="form-group">
                                                <label class="crm-label">Category</label>
                                                <select class="form-control crm-form" id="category_id" name="category_id">
                                                    <option value="">Select Category </option>
                                                </select> 
                                                <div class="d-arrow"></div>

                                            </div>
                                            <div class="form-group">
                                                <label class="crm-label">Pendency Name</label>
                                                <select class="form-control crm-form" id="pendency_id" name="pendency_id">
                                                    <option value="">Select Pendency Doc</option>  
                                                </select> 
                                                <div class="d-arrow"></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12 clearfix  textcenter">
                                            <a href="#" class="btn-continue btn-proceed pop-btn" onclick="addPendency()">Save</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 




                    <script>
                        var case_id = $('#case_id').val();
                        var customer_id = $('#customer_id').val();

                        // Dropzone.autoDiscover = false;
                        var myDropzone = new Dropzone("form#demoUpload", {
                            url: '<?php echo base_url(); ?>Insurance/uploadInsDocs/' + case_id + "-" + customer_id,
                            previewsContainer: '#preview',
                            success: function (file, response) {
                               $('.loaderClas').attr('style','display:block;');

                                //$('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('id',response).attr('onclick','tagImages(this)');
                                $('img[alt="' + file.name + '"]').parent().siblings('.tag').attr('id', $.trim(response));
                                ///$('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('onclick','tagImages(this)');
                                var tagCurrId = $('#current_i').val();
                                $('img[alt="' + file.name + '"]').parent().siblings('.tag').attr('class', 'tag tagClass_' + tagCurrId);
                                $('.addfile').show();
                                $('.needsclick').css('border-width', 0).addClass('bg-none');
                                $('img[alt="' + file.name + '"]').parent().siblings('.dz-error-mark').find('.del-btn').attr('id', 'del_' + response);
                                $('img[alt="' + file.name + '"]').parent().siblings('.dz-error-mark').find('.del-btn').attr('onclick', 'delImg(this)');
                                $('.dz-error-message').attr('style', 'display:none');
                                var j = parseInt(tagCurrId) + parseInt(1);
                                $('#current_i').val(j);
                                login();
                                showImages(customer_id, case_id);
                            }
                        });
myDropzone.on("queuecomplete", function(file) {
  $('.loaderClas').attr('style','display:none;');
});
                        var myDropzone1 = new Dropzone("div#secUploadBtn", {
                            url: base_url + 'Insurance/uploadInsDocs/' + case_id + "-" + customer_id,
                            previewsContainer: '#preview',
                            success: function (file, response) {
                                $('img[alt="' + file.name + '"]').parent().siblings('.tag').attr('id', $.trim(response));
                                //$('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('onclick','tagImages(this)');
                                var tagCurrId = $('#current_i').val();
                                $('img[alt="' + file.name + '"]').parent().siblings('.tag').attr('class', 'tag tagClass_' + tagCurrId);
                                $('img[alt="' + file.name + '"]').parent().siblings('.dz-error-mark').find('.del-btn').attr('id', 'del_' + response);
                                $('img[alt="' + file.name + '"]').parent().siblings('.dz-error-mark').find('.del-btn').attr('onclick', 'delImg(this)');
                                $('.dz-error-message').attr('style', 'display:none');

                                var j = parseInt(tagCurrId) + parseInt(1);
                                $('#current_i').val(j);
                                login();
                                showImages(customer_id, case_id);
                            }

                        });
                        $('.needsclick').on("dragenter", function (event) {
                            $('.needsclick').css('border-color', '#333');
                        });
                        $('body').on('click', '.dz-error-mark .del-btn', function () {
                            $(this).parents('.dz-preview').remove();
                            var chkNoOfDiv = $("#preview > *").length;
                            if (chkNoOfDiv == 0) {
                                $('.addfile').hide();
                                $('.needsclick').css('border-width', '1px').removeClass('bg-none');
                                ;
                            }
                        });

                             $('.app-form').click(function () {
                                //(this).children().addClass('badge');
                                $(this).parents('.panel').find('.tick').show();
                                $(this).parents('.panel').find('.error').hide();
                            });

                        //Image Viewer
                        $(document).ready(function () {

                            //alert(customer_id+'-'+case_id);
                            showImages(customer_id, case_id);
                            /*$('.app-form').click(function () {
                                //(this).children().addClass('badge');
                                $(this).parents('.panel').find('.tick').show();
                                $(this).parents('.panel').find('.error').hide();
                            });*/
                            $('.final-submit').click(function () {
                                /* $('.app-form').each(function(){
                                 var ChkActCls = $(this).hasClass('active'); 
                                 if(ChkActCls == false){
                                 $(this).parents('.panel').find('.error').show();
                                 }else{
                                 $('.error').hide();
                                 }
                                 
                                 });*/
                            });
                            //$('#preview').sortable();
                            $('#tag').click(function () {
                                // showImages(customer_id,case_id);
                                // /initial();
                                //setTimeout(function(){   initGalleryImage();  },1000)
                            });

                        });

                        function showImages(customer_id, case_id = '')
                        {
                            //alert(customer_id);
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/showImagesToTag/",
                                data: {customer_id: customer_id},
                                dataType: 'json',
                                success: function (img) {
                                    $('#imags').val(img);
                                    var str = '';
                                    var strtagId = '';
                                    for (var i = 0; i < img.length; i++) {
                                        str += img[i].id + ',';
                                    }
                                    for (var i = 0; i < img.length; i++) {
                                        strtagId += img[i].tag_id + ',';
                                    }
                                    str = str.slice(0, -1);
                                    strtagId = strtagId.slice(0, -1);
                                    $('#counttagid').val(strtagId);
                                    $('#allImgId').val(str);
                                    initial(img);
                                }
                            });



                        }

                        function initial(imagesssss) {
                    // alert('hiii');
                            var images = imagesssss;
                            var image_id = $('#imagesId').val();
                            var arr = image_id.split(',');
                            var curr_index = $('#curr_img').val();
                            var tagCount = $('#counttagid').val();
                            var tagCountArr = tagCount.split(',');
                            var taggCount = tagCountArr.length;
                            var countRemaining = 0;
                            for (var i = 0; i < taggCount; i++)
                            {
                                //alert(tagCountArr[i]);
                                if (tagCountArr[i] == 'null')
                                {
                                    countRemaining = parseInt(countRemaining) + parseInt(1);
                                }
                            }
                            $("#tagCount").html(countRemaining);
                            if (curr_index < 2)
                            {
                                curr_index = 1;
                            }
                            var imgId = $('#allImgId').val();
                            var imgIdArr = imgId.split(',');
                            var currImgsTg = $('#tagId').val();
                            imgtagName('', currImgsTg);
                    //alert(imgIdArr);
                            var l = [];
                            var k = [];
                            for (var i = 0; i < imgIdArr.length; i++) {
                                l[i + 1] = parseFloat(imgIdArr[i]);
                            }
                            for (var j = 0; j < tagCountArr.length; j++)
                            {
                                k[j + 1] = parseFloat(tagCountArr[j]);
                            }
                    // console.log(l);
                            var curImageIdx = curr_index,
                                    total = images.length;
                            var wrapper = $('#image-gallery'),
                                    curSpan = wrapper.find('.current');
                            var viewer = ImageViewer(wrapper.find('.image-container'));

                    //display total count
                            wrapper.find('.total').html(total);

                            function showImage() {
                                var imgObj = images[curImageIdx - 1];
                                viewer.load(imgObj.small, imgObj.big,imgObj.image_type);
                                curSpan.html(curImageIdx);
                            }

                            wrapper.find('.next').click(function () {
//alert('next');
                                curImageIdx++;
                                if (curImageIdx > total) {
                                    curImageIdx = 1;
                                }
                                $("#tagId").val(l[curImageIdx]);
                                $("#tagIdAccImg").val(k[curImageIdx]);
                                imgtagName(k[curImageIdx]);
                                if (parseInt(k[curImageIdx]) > 0) {
                                    $('#removeTag').attr('style', 'display:block;');
                                } else
                                {
                                    $('#removeTag').attr('style', 'display:none;');
                                }
                                showImage();
                            });

                            wrapper.find('.prev').click(function () {
                                
                                curImageIdx--;
                               
                                $("#tagId").val(l[curImageIdx]);
                                $("#tagIdAccImg").val(k[curImageIdx]);
                                 //alert(k[curImageIdx]);
                                imgtagName(k[curImageIdx]);
                                if (curImageIdx < 1)
                                {
                                    curImageIdx = total;
                                    $("#tagId").val(l[curImageIdx]);
                                    $("#tagIdAccImg").val(k[curImageIdx]);
                                }
                                if (parseInt(k[curImageIdx]) > 0) {
                                    $('#removeTag').attr('style', 'display:block;');
                                } else
                                {
                                    $('#removeTag').attr('style', 'display:none;');
                                }
                                showImage();
                            });

                            if (parseInt(k[curImageIdx]) > 0) {
                                $('#removeTag').attr('style', 'display:block;');
                            } else
                            {
                                $('#removeTag').attr('style', 'display:none;');
                            }

                    //initially show image
                            showImage();
                        }
                        ;


                    //initially show image
                    //showImage();

                        function delImg(eve)
                        {
                            var ids = $(eve).attr('id');
                            var idarr = ids.split('_');
                            var id = idarr[1];
                            var tag_seq = $('#' + id).attr('class');
                            var removedId = tag_seq.split('_');
                    //alert(removedId[1]);
                            var tagCurrId = $('#current_i').val();
                            var j = parseInt(tagCurrId) - parseInt(1);
                            var newId = parseInt(removedId[1]);
                            var oldId = parseInt(newId) + parseInt(1);
                    //alert('totalimage-'+j);
                            for (var i = removedId[1]; i <= j; i++)
                            {
                                //alert('oldId-'+oldId+' newId-'+newId);
                                var tagClass = $('.tagClass_' + oldId).attr('class', 'tag tagClass_' + newId);
                                oldId++;
                                newId++;
                            }
                    //var tagClass = $('.tagClass_'+removedId);
                            $('#current_i').val(j);
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/deleteImg/",
                                data: {id: idarr[1]},
                            });
                        }
                        $('#tagimage').click(function () {
                            var customer_id = $('#customer_id').val();
                            showImages(customer_id);
                        });
                        $('#uploadimage').click(function () {
                            var customer_id = $('#customer_id').val();
                        });

                        $(document).ready(function () {
                            $('body').on('click', '.dz-preview .tag', function () {
                                var currID = $(this).attr('id');
                                var currCl = $(this).attr('class');
                                if (currID != '')
                                {
                                    // alert('hii');
                                    //var ids = $(ev).attr('id');
                                    $('#tagId').val(currID);
                                    //var tagCurrentImage = $(ev).attr('class');
                                    var currentImg = currCl.split('_');
                                    $('#curr_img').val(currentImg[1]);
                                    $('#tagimage').trigger('click');
                                    var customer_id = $('#customer_id').val();
                                    showImages(customer_id);
                                    return true;
                                }
                            });
                        });
                        function imageTagging(eve)
                        {
                            //alert('fdfdf');
                            var taggedID = $(eve).attr('id');
                            var relId=$(eve).attr('rel');
                            var subcatTagId = relId.split('_');
                            var imageTagId = taggedID.split('_');
                            var currImgId = $('#tagId').val();
                            var tagdocId = imageTagId[1];
                            $('#tagging_id').val(imageTagId[1]);
                            var arr = ['8', '9', '10', '11', '12', '13'];
                            if (jQuery.inArray(imageTagId[1], arr) != -1)
                            {
                                appBank(imageTagId[1]);
                                return false;
                            }
                            //alert(currImgId+'-'+tagdocId);
                            if ((currImgId > 0) && (tagdocId > 0))
                            {
                                $.ajax({
                                    type: 'POST',
                                    url: "<?php echo base_url(); ?>" + "Insurance/loanTagMapping/",
                                    dataType: 'json',
                                    data: {ImgID: currImgId, taggID: tagdocId, customer_id: customer_id, type: 'add',subcat:subcatTagId[1],case_id:case_id},
                                    success: function (response) {
                                        if (response.status == '1')
                                        {
                                            updateCounter(imageTagId[1], 'add',subcatTagId[1]);
                                             $('.subr_'+subcatTagId[1]).addClass('badge');
                                             $('.subrc_'+subcatTagId[1]).addClass('active');
                                            //$('#subclass_' + imageTagId[1]).attr('class', 'badg badge');
                                            var removedCount = $('#tagCount').html();
                                            if (parseInt(removedCount) > 0) {
                                                var countRemaining = parseInt(removedCount) - parseInt(1);
                                                $('#tagCount').html(countRemaining);
                                                $('.next').trigger('click');
                                            }

                                        } else
                                        {
                                            alert(response.msg);
                                            $('.subr_'+subcatTagId[1]).removeClass('badge');
                                            $('.subrc_'+subcatTagId[1]).removeClass('active');
                                           // $('#subclass_' + imageTagId[1]).attr('class', 'badg');
                                        }
                                    }
                                });
                            }
                        }
                        $('#removeTag').click(function () {
                            var image_id = $('#tagId').val();
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/loanTagMapping/",
                                data: {ImgID: image_id, customer_id: customer_id, type: 'remove'},
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status)
                                    {
                                        snakbarAlert('Image Tag Removed.');
                                        //$('#img_tag_name').attr('style','display:block');
                                       // $('#img_tag_name').attr('');
                                        //$('.next').trigger('click');
                                        //alert(response.tag_id);
                                         updateCounter(response.parent_tag_id,'remove',response.tag_id);
                                        //updateCounter(response.tag_id, 'remove');
                                        $('#removeTag').attr('style', 'display:none;');
                                        var removedCount = $('#tagCount').html();
                                        var countRemaining = parseInt(removedCount) + parseInt(1);
                                        $('#tagCount').html(countRemaining);
                                        $('.next').trigger('click');

                                    } else
                                    {
                                        alert(response.msg);
                                        //$('.next').trigger('click');
                                    }

                                }
                            });
                        });

                        function updateCounter(tagId, type,classId)
                        {
                            var counter = $('#subclass_' + tagId).text();
                            counter = $.trim(counter);
                            var strn = '';
                            if (counter == '*')
                            {
                                strn = '*';
                                counter = '';
                            }
                            if (counter.indexOf('*') != -1)
                            {
                                strn = '*';
                                counter = counter.replace('*', '');
                            }
                            if (type == 'add')
                            {
                                if (counter == '')
                                {
                                    $('#subclass_' + tagId).text('1');
                                    $('#sudbreq_' + tagId).addClass('active');
                                    $('.subr_'+classId).text('1');
                                    $('.subr_'+classId).addClass('active');
                                } else
                                {
                                    var abc = parseInt(counter) + parseInt(1);
                                    $('#subclass_' + tagId).text('');
                                    $('.subr_'+classId).text(''); 
                                    $('#subclass_' + tagId).text(abc);
                                    $('#sudbreq_' + tagId).addClass('active');
                                    $('.subr_'+classId).text(abc); 
                                    $('.subr_'+classId).addClass('active');   
                                }
                            } else
                            {
                                if ($.trim(counter) == '')
                                {
                                    $('#subclass_' + tagId).text('');
                                    $('#sudbreq_' + tagId).removeClass('active');
                                    $('.subr_'+classId).html(''); 
                                    $('.subrc_'+classId).removeClass('active');
                                } else
                                {
                                    var countarr = counter.split(' ');
                                    var cc = '';
                                    var ee = '';
                                    if(countarr[1]==undefined)
                                    {
                                      cc = countarr;
                                      //ee = '*'
                                    }
                                    else
                                    {
                                      cc = countarr[1];
                                      ee = '*';
                                    }
                                    if(cc>1)
                                    {
                                      $('#subclass_'+tagId).text('');
                                      $('.subr_'+classId).text('');
                                      var abc = parseInt(cc)-parseInt(1);
                                      $('#subclass_'+tagId).text(ee+' '+abc);
                                      $('#sudbreq_'+tagId).addClass('active'); 
                                      $('.subr_'+classId).text(ee+' '+abc);
                                      $('#subr_'+classId).addClass('active');  
                                    }
                                    else
                                    {
                                       //alert('rrrr');
                                      $('#subclass_'+tagId).text('');
                                      $('.subr_'+classId).text('');
                                      $('.subr_'+classId).removeClass('active'); 
                                      $('#sudbreq_'+tagId).removeClass('active'); 
                                    }
                            

                                }
                            }
                        }

                        function markIncorrect()
                        {
                            var reason = $('#markincor').val();
                            var tag_id = $("#tagging_id").val();
                            var img_id = $('#tagId').val();
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/loanTagMapping/",
                                data: {reason_id: reason, taggID: tag_id, ImgID: img_id, customer_id: customer_id, type: 'markincorrect'},
                                dataType: 'json',
                                success: function (response)
                                {
                                    if (response.status == '0')
                                    {
                                        snakbarAlert(response.msg);
                                        //$('#img_tag_name').attr('style','display:block');
                                       // $('#img_tag_name').attr('');
                                        $('.next').trigger('click');
                                    }

                                }

                            });
                        }


                        $("#category_id").change(function () {
                            var catId = $("#category_id").val();
                            var case_id = $("#case_id").val();
                            var inscat = $("#inscategory").val();
                            var output = $("#category_id").find('option:selected').attr('rel');
                           // alert(output);
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/pendencyByCatId/",
                                data: {catId: catId, doctype: 3, case_id: case_id, inscat: inscat,rel_id:output},
                                dataType: 'html',
                                success: function (response)
                                {
                                    $("#pendency_id").html(response);
                                }

                            });
                        });

                        function getCategoryList()
                        {
                            $('#category_id').val('');
                            $('#pendency_id').val('');
                            var catId = $("#inscategory").val();
                            var case_id = $("#case_id").val();
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/pendencyByCatId/",
                                data: {type: 'getcategoryId', doctype: 2, case_id: case_id, inscat: catId},
                                dataType: 'html',
                                success: function (response)
                                {
                                    $("#category_id").html(response);
                                }

                            });
                        }

                        function addPendency()
                        {
                            var customer_id = $("#customer_id").val();
                            var case_id = $("#case_id").val();
                            var pendencyId = $("#pendency_id").val();
                            var category_id = $("#category_id").find('option:selected').attr('rel');;
                            // alert(category_id);
                            if(category_id=='')
                            {
                                $('#pendencyErr').attr('style','display:block;');
                                $('#pendencyErr').html('Please select Category');
                                return false;
                            }
                            if(pendencyId=='')
                            {
                                $('#pendencyErr').attr('style','display:block;');
                                $('#pendencyErr').html('Please select Pendency Doc');
                                return false;
                            }
                            if((category_id>='1') && (pendencyId>='1')){
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>" + "Insurance/addPendencyDoc/",
                                data: {case_id: case_id, doctype: 3, pendencyId: pendencyId, category_id: category_id},
                                dataType: 'json',
                                success: function (response)
                                {
                                    //alert(category_id);

                                    if (response.status == '1') {
                                        $('#err_' + category_id).attr('style', 'display: inline');
                                        $('#sudbreq_'+msg).addClass('active');
                                        $("#pendencyErr").html('');
                                        $("#pendency_id").val('');
                                        $("#category_id").val('');
                                    } else {
                                        $("#pendencyErr").html(response.msg);
                                        $("#pendency_id").val('');
                                        $("#category_id").val('');
                                    }
                                    $('#addPendency').removeClass('in');
                                    $('.close').trigger('click');
                                }

                            });
                            }
                        }

                        function removeAll()
                        {
                            var allImg = $('#allImgId').val();
                            if (confirm("Do you want to delete all images"))
                            {
                                $.ajax({
                                    type: 'POST',
                                    url: "<?php echo base_url(); ?>" + "Insurance/deleteImg/",
                                    data: {id: allImg, type: 'all'},
                                    success: function (response)
                                    {
                                        login();
                                    }
                                });
                            } else
                            {
                                return false;
                            }
                        }

                        function imgtagName(tagid = '', imag_id = '')
                        {
                            if (imag_id == '')
                            {
                                var imag_id = $("#tagId").val();
                            }
                            var case_id = $("#case_id").val();
                            $.ajax({
                                type: 'POST',
                                url: base_url + "Insurance/getTagName/",
                                data: {tagid: tagid, case_id: case_id, imag_id: imag_id, doctype: 3},
                                dataType: 'json',
                                success: function (data)
                                {
                                    //alert(data);
                                    $('#img_tag_name').attr('style', "display:none !important");
                                    $('#removeTag').attr('style',"display:none !important");
                                    if (data != '')
                                    {
                                        $('#img_tag_name').attr('style', "display:block !important");
                                        $('#img_tag_name').html(data);
                                        $('#removeTag').attr('style',"display:block !important");
                                    }
                                }
                            });
                        }

                        function downloadAll()
                        {
                            var allImg = $('#allImgId').val();
                            var case_id = $("#case_id").val();
                            var customer_id = $("#customer_id").val();
                            /*$.ajax({
                                  type : 'POST',
                                  url : "<?php echo base_url(); ?>" + "Finance/downloadImg/",
                                  data : {id:allImg,type:'all'},
                                  success: function (response) 
                                  { 
                                   //alert('hi');
                                  }
                            });*/
                          window.top.location.href = base_url+"Insurance/getImagedownload/"+case_id;  
                        }

                    </script>
                    <script src="<?php echo base_url(); ?>assets/js/insurance_process.js" type="text/javascript"></script>


