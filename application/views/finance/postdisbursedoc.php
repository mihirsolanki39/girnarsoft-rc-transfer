<?php 
$styl = 'display:block';
if((!empty($CustomerInfo['instrument_type'])) && ((!empty($rolemgmt[0]['role_name'])) && (($rolemgmt[0]['role_name']!='admin') || ($rolemgmt[0]['role_name']!='Loan Admin'))))
{
  $styl = 'display:none';
}
?>
 <div class="sec-card">
                                       <ul class="nav nav-tabs nav-uptag" role="tablist">
                                          <li role="presentation" class="active"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab"  onclick="postd()" id="uploadimage">UPLOAD</a></li>
                                          <li role="presentation"><a href="#tag" aria-controls="tag" role="tab" data-toggle="tab" id="tagimage">TAG</a></li>
                                       </ul>
                                       <div class="tab-content">
                                      
                                          <div role="tabpanel" class="tab-pane active" id="upload">
                                           <?php if(!empty($imageList)){?>
                                          <div class="col-md-12">
                                                <div class="downloadAllImg" style="text-align: right; position: absolute; right: 0;top: -70px;">
                                             <a id="downloadAll" alt="Download all images" onclick="downloadAll()" > Download All  </a>
                                             <a id="removeAll" class="pad-L10" alt="remove all images" onclick="removeAll()" > Remove All  </a>
                                                <!-- <label for="removeAll">Remove All</label>
                                                 <input type="checkbox" name="removeAll" id="removeAll">-->
                                             </div>
                                             </div>
                                             <!--<div class="col-md-2 removeAllImg">-->
                                             
                                                <!-- <label for="removeAll">Remove All</label>
                                                 <input type="checkbox" name="removeAll" id="removeAll">-->
                                             <!--</div>-->
                                               <?php } ?>
                                             <form class="needsclick  <?php if(!empty($imageList)){?> dz-clickable bg-none <?}?>" <?php if(!empty($imageList)){?> style="border-width: 0px;" <?}?>   id="demoUpload">
                                                <div id="preview" <?php if(!empty($imageList)){?> class="ui-sortable"<?}?> >
                                                  <?php 
                                                  $j = 1;
                                                   $tagId =[];
                                                   $pendency_doc_ids = [];
                                                  /* echo "<pre>";
                                                   print_r($imageList);
                                                   exit;*/
                                                  if(!empty($imageList)) {
                                                          
                                                  foreach ($imageList as $ikey => $ival){
                                                    if(!empty($ival['sub_id']))
                                                    {
                                                      $tagId[$ival['sub_id']][]=$ival['sub_id'];
                                                    }
                                                    $type= end(explode('.',$ival['doc_name']));
                                                      ?>
                                                  <div class="dz-preview dz-image-preview">
                                                    <div class="dz-image">
                                                      <!--<img data-dz-thumbnail="" alt="<?=$ival['doc_name']?>" src="<?=$ival['doc_url']?>">-->
                                                      <?php if($type=='pdf'){ ?>
                                                            
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
                                                        <span data-dz-name=""><?=(!empty($ival['name'])?$ival['name']:'')?></span>
                                                      </div>
                                                    </div>
                                                    <div class="dz-progress">
                                                      <span class="dz-upload" data-dz-uploadprogress=""></span>
                                                    </div>
                                                    <div class="dz-error-message" <?php if(empty($ival['err']) && ($ival['err']==0)){ 
                                                      ?>style="display:none;" <?}?>>
                                                      <span data-dz-errormessage=""><?php if(!empty($ival['err'])){ echo ($ival['err']=='1')?'Incorrect Doc':'Unclear Image';}?></span>
                                                    </div>
                                                    <div class="tag tagClass_<?=$j?>" id="<?=$ival['id']?>">Tag</div>
                                                    <div class="dz-success-mark"></div>
                                                    <div class="dz-error-mark" style="<?=$styl?>">
                                                      <div class="del-btns" id="del_<?=$ival['id']?>" onclick="delImg(this)">×</div>
                                                    </div>
                                                  </div>
                                                  <?php $j++; } }
                                                    ?>

                                                </div>
                                                <div class="addfile" id="secUploadBtn" <?php if(!empty($imageList)){?> style="display:block;" <?}?>></div>
                                             </form>
                                          </div>
                                          <div role="tabpanel" class="tab-pane" id="tag">
                                             <div class="row">
                                                <div class="options" style="text-align: right;margin-bottom:10px !important;position:relative !important;">
                                                  <ul class="options-ul">
                                                    <li id="mkIncorrect"><a href="#" class="option-list" data-toggle="modal" data-target="#markIncorrect">MARK INCORRECT</a></li>  
                                                    <li><a href="#" class="option-list" data-toggle="modal" data-target="#addPendency" onclick="getCategoryList()" >ADD PENDENCY</a></li>  
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
                                                            <img src="<?=base_url()?>assets/images/left.svg" class="prev"/>
                                                            <img src="<?=base_url()?>assets/images/left.svg" class="next"/>
                                                            
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="panel-group" id="accordion">
                                                         <!------>
                                                          <?php 
                                                            $i = 1; 
                                                           /* echo "<pre>";
                                                            print_r($uploadDocList);
                                                            exit;*/
                                                            foreach($uploadDocList as $key => $val ) {
                                                            $req = '';
                                                            if($val['is_require']=='1')
                                                            {
                                                              $req = '*';
                                                            }
                                                            
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
                                                              }
                                                            }
                                                            ///$style = '';
                                                            /*if(!empty($tagId)){
                                                            foreach ($tagId as $ksel => $vsel) 
                                                            {
                                                              //$style[$key]='';
                                                              if($key==$ksel)
                                                              {
                                                                $style[$key]='style="display: inline;"';
                                                              }
                                                            }
                                                          }*/
                                                            if(!empty($pendencyDoc)){
                                                             $error =[];
                                                             $pendencyStr = '';
                                                             $pendency_doc_ids = [];
                                                             foreach($pendencyDoc as $pkey => $pval){
                                                              $pendencyStr .= $pval['doc_id'].',';
                                                              if($pval['doc_parent_id']>0){
                                                                $error[$pval['doc_parent_id']] = 'style="display: inline;"';
                                                                }
                                                                else
                                                                {
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
                                                               <div class="panel-heading" id="doc_<?=$key?>">
                                                                  <h4 class="panel-title">
                                                                     <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>" id="doct_<?=$key?>" class="collapsed">
                                                                     <?=$val['name']?> <?=$req?> 
                                                                       <span class="tick" id="tick_<?=$key?>"
                                                                       <?php echo ((!empty($style[$key]) && empty($error[$key]))?$style[$key]:'');
                                                                      ?> 
                                                                       >
                                                                        <img src="<?=base_url()?>assets/images/tick-green.svg" alt="Doc Uploaded">
                                                                       </span>
                                                                       <span class="error" id="err_<?=$key?>"  <?=(!empty($error[$key])?$error[$key]:'')?>>
                                                                        <img src="<?=base_url()?>assets/images/error.svg" alt="Error">
                                                                       </span>
                                                                     </a>
                                                                  </h4>
                                                               </div>
                                                               <div id="collapse<?=$i;?>" class="panel-collapse collapse">
                                                                  <div class="panel-body">
                                                                     <ul class="child-drop">
                                                                        <?php 
                                                                          $v= [];
                                                                         
                                                                          
                                                                          foreach($val['subList'] as $subkey => $subval){ 
                                                                           /* echo "<pre>";
                                                                            print_r($subval);
                                                                            exit;*/
                                                                            $addfrm = '';
                                                                            if(in_array($subval['sub_category_id'], $pendency_doc_ids))
                                                                            {
                                                                              $addfrm = 'active';
                                                                            }
                                                                          $subreq = '';
                                                                          if($val['is_require']=='1')
                                                                          {
                                                                            $subreq = '*';
                                                                          }
                                                                        /* echo "<pre>";
                                                                         print_r($tagId);
                                                                         exit;*/
                                                                          foreach ($tagId as $ksel => $vsel) 
                                                                          {
                                                                             $count = 0;
                                                                              foreach($vsel as $vk=>$vv)
                                                                              {  

                                                                                if(intval($subval['sub_category_id'])==intval($vv))
                                                                                {
                                                                                  $count = intval($count)+1;
                                                                                }
                                                                                  if($count>0){
                                                                                  $v[$subkey]= 'badge_'.$count;
                                                                                }
                                                                              }
                                                                          } 
                                                                          $arrClass =[];
                                                                          if(!empty($v[$subkey])){
                                                                            // /echo $v[$subkey]; 
                                                                             $arrClass = explode('_',$v[$subkey]);
                                                                              if($arrClass[1]==0)
                                                                               {
                                                                                $arrClass = [];
                                                                               }
                                                                           }
                                                                           ?>
                                                                        <li class="app-form <?=$addfrm?> subrc_<?=$subval['sub_category_id']?>  <?=(!empty($arrClass))?'active':''?>" rel="subr_<?=$subval['sub_category_id']?>" id="sudbreq_<?=$subkey?>"  onclick="imageTagging(this)" ><?=$subval['name'];?>  
                                                                         <span><?=$subreq?></span>
                                                                          <span id="subclass_<?=$subkey?>" class="subr_<?=$subval['sub_category_id']?> badg <?=(!empty($arrClass))?$arrClass[0]:''?>"> <?=(!empty($arrClass))?$arrClass[1]:''?></span>
                                                                        </li>
                                                                        <?php } ?>
                                                                      </ul>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <?php $i++; } ?>
                                                            <!------>

                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   
                       
      <input type="hidden" name="case_id" value="<?=(!empty($CustomerInfo['customer_loan_id']))?$CustomerInfo['customer_loan_id']:''?>" id="case_id"> 
      <input type="hidden" name="tagId" value="<?=(!empty($imageList[0]['id']))?$imageList[0]['id']:''?>" id="tagId"> <!--current image id -->
      <input type="hidden" name="tagdocId" value="" id="tagdocId"> 
      <input type="hidden" name="customer_id" value="<?=(!empty($CustomerInfo['customer_id']))?$CustomerInfo['customer_id']:''?>" id="customer_id"> <!--current customer id -->
      <input type="hidden" name="imagesId" value="" id="imagesId">
      <input type="hidden" name="imags" id="imags" value="">
      <input type="hidden" name="curr_img" value="" id="curr_img"><!--current image id -->
      <input type="hidden" name="allImgId" value="" id="allImgId"><!--all image id -->
      <input type="hidden" name="current_i" value="<?=$j?>" id="current_i"> <!--current img serial number -->
      <input type="hidden" name="tagging_id" value="" id="tagging_id"> <!--tag document -->
       <input type="hidden" name="counttagid" value="" id="counttagid"> <!--count tag document -->
       <input type="hidden" name="tagIdAccImg" value="<?=(!empty($imageList[0]['tag_id']))?$imageList[0]['tag_id']:''?>" id="tagIdAccImg"> <!--current tag id -->
       <input type="hidden" name="imgloop" value="" id="imgloop">
       <input type="hidden" name="countloop" value="1" id="countloop">

                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-12">
   <div class="btn-sec-width tag-btn-complete">
    <?/*php if($CustomerInfo['cancel_id']=='0'){ ?>
      <a onclick="savelogindoc();" class="btn-continue saveCont final-submit">SAVE AND CONTINUE</a>
    <?php } */?>
     <?php 

                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                      if(((!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4')) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id']))) || ($rolemgmt[0]['add_permission']=='0'))
                                      {
                                          /*$stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('postDeliveryDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]); */
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('disbursalDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]);

                                      } if($CustomerInfo['cancel_id']=='0'){ ?>
      <a onclick="savelogindoc()" style="<?=$stylesss?>" class="btn-continue saveCont final-submit">SAVE AND CONTINUE</a>
      <a class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</a>
      <?php } ?>
    </div>
  </div>
                                   <!-- </div>-->
                                    <!--<div role="tabpanel" class="tab-pane" id="disbursement">
                                      
                                      
                                    </div>-->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

        <div class="modal fade" id="applicationBank" role="dialog">
         <div class="modal-dialog">
            
            <div class="modal-content">
               <div class="modal-header modal-header-custom">
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                  <div class="row">
                     <div class="col-md-9 clearfix">
                        <h4 class="modal-title"> Select Bank</h4>
                     </div>
                  </div>
               </div>
               <div class="modal-body">
                   <div class="row">
                      <div class="col-md-12">
                         <div class="form-group">
                            <select class="form-control crm-form" name="bank_name" id="bank_name">
                            <option>Select Bank</option>
                           </select> 
                           <div class="d-arrow d-arrow-new"></div>
                         </div>
                       </div>
                       <div class="col-md-12 clearfix  textcenter">
                           <a class="btn-continue btn-proceed pop-btn" onclick="updateBank();" data-dismiss="modal">Save</a>
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
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
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
                  <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                  <div class="row">
                     <div class="col-md-6 clearfix">
                        <h4 class="modal-title">Add Pendency</h4>
                     </div>
                  </div>
               </div>
               <div class="modal-body">
                   <div class="row">
                      <div class="col-md-12">
                        <div id="pendencyErr"></div>
                         <div class="form-group">
                         <label class="crm-label">Pendency Name</label>
                           <select class="form-control crm-form" id="category_id" name="category_id">
                              <option value="">Select Category </option>
                           </select> 
                           <div class="d-arrow"></div>
                         </div>
                         <div class="form-group">
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

      var to = $('#tagId').val();
      if(to=='')    
      {    
         $('#mkIncorrect').attr('style','display:none;');    
      }
      var countloop = $('#countloop').val();
      var case_id = $('#case_id').val();
      var customer_id = $('#customer_id').val();
    // alert(case_id.'-'.customer_id);
      // Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("form#demoUpload", {
                url: '<?php echo base_url(); ?>Finance/uploadLoginDocs/'+case_id+"-"+customer_id+"-"+'9',
                previewsContainer: '#preview',
                success: function(file, response){
                  $('.loaderClas').attr('style','display:block;'); 
                   //$('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('id',response).attr('onclick','tagImages(this)');
                   $('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('id',$.trim(response));
                  ///$('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('onclick','tagImages(this)');
                   var tagCurrId = $('#current_i').val();
                  $('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('class','tag tagClass_'+tagCurrId);
                    $('.addfile').show();
                    $('.needsclick').css('border-width',0).addClass('bg-none');
                     $('img[alt="'+file.name+'"]').parent().siblings('.dz-error-mark').find('.del-btns').attr('id','del_'+response);
                    $('img[alt="'+file.name+'"]').parent().siblings('.dz-error-mark').find('.del-btns').attr('onclick','delImg(this)');
                     $('.dz-error-message').attr('style','display:none');
                      var imgloop = $('.dz-preview').length;
                   //alert(countloop+'countloop');
                     if(imgloop>1)
                    {
                      //alert(imgloop+'asss');
                      $('#imgloop').val(imgloop);
                    }
                    else
                    {
                       //$('.loaderClas').attr('style','display:block;'); 
                    }
                   
                    if(parseInt(imgloop)!=parseInt(countloop))
                    {
                        var ii = $('#countloop').val();
                        ii++;
                        $('#countloop').val(ii);
                    }
                    var j = parseInt(tagCurrId) + parseInt(1);
                    $('#current_i').val(j);
                    showImages(customer_id,case_id);
                    if(parseInt(imgloop)==parseInt(ii))
                    {                   
                      //$('.loaderClas').attr('style','display:none;');
                       postd();
                    }
                    
                    
                  }
            });
myDropzone.on("queuecomplete", function(file) {
   postd(); 
  $('.loaderClas').attr('style','display:none;');
});
           var myDropzone1 = new Dropzone("div#secUploadBtn", {
                url: base_url+'Finance/uploadLoginDocs/'+case_id+"-"+customer_id+"-"+'9',
                previewsContainer: '#preview',
                success: function(file, response){
                  $('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('id',$.trim(response));
                  //$('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('onclick','tagImages(this)');
                   var tagCurrId = $('#current_i').val();
                  $('img[alt="'+file.name+'"]').parent().siblings('.tag').attr('class','tag tagClass_'+tagCurrId);
                   $('img[alt="'+file.name+'"]').parent().siblings('.dz-error-mark').find('.del-btns').attr('id','del_'+response);
                   $('img[alt="'+file.name+'"]').parent().siblings('.dz-error-mark').find('.del-btns').attr('onclick','delImg(this)');
                   $('.dz-error-message').attr('style','display:none');
                   
                    var j = parseInt(tagCurrId) + parseInt(1);
                    $('#current_i').val(j);
                   showImages(customer_id,case_id);
                   postd();
                  }
                  
           });
           $('.needsclick').on("dragenter", function(event) {
              $('.needsclick').css('border-color','#333');
            });
            $('body').on('click','.dz-error-mark .del-btns',function(){

            });
         
          
          
          //Image Viewer
          $(document).ready(function(){
             showImages(customer_id,case_id);
                $('.app-form').click(function(){
                    $(this).addClass('active');
                    $(this).parents('.panel').find('.tick').show();
                    $(this).parents('.panel').find('.error').hide();
                });
               $('.final-submit').click(function(){
                  
               });
             
              $('#tag').click( function(){
              }); 
         
         }); 
               
                function showImages(customer_id,case_id='')
                {
                  $('.loaderClas').attr('style','display:block;');  
                   //alert(customer_id);
                     $.ajax({
                      type : 'POST',
                      url : "<?php echo base_url(); ?>" + "Finance/showImagesToTag/",
                      data : {customer_id:customer_id,doctype:'post',case_id:case_id},
                      dataType: 'json',
                      success: function (img) { 
                        $('#imags').val(img); 
                       var str = '';
                       var strtagId='';
                      for (var i = 0; i < img.length; i++) {
                          str += img[i].id+',';
                      }
                      for (var i = 0; i < img.length; i++) {
                          strtagId += img[i].tag_id+',';
                      }
                        str=str.slice(0,-1); 
                        strtagId=strtagId.slice(0,-1); 
                        $('#counttagid').val(strtagId);
                        $('#allImgId').val(str);
                        initial(img);
                        if(str=='')
                        {
                          $('.next , .prev').attr('style','display:none;');
                        } else{
                          $('#tg').attr('style','display:block;');
                         
                      }
                       
                      }
                    });
                   
                    $('.loaderClas').attr('style','display:none;');   

                }
                    

             
    function initial(imagesssss){
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
      if(tagCountArr[i]=='null')
      {
        countRemaining=parseInt(countRemaining)+parseInt(1);
      }
    }
    $("#tagCount").html(countRemaining);
    if(curr_index<2)
    {
       curr_index = 1;
    }
    var imgId = $('#allImgId').val();
    var imgIdArr = imgId.split(',');
    var currImgsTg = $('#tagId').val();

    imgtagName('',currImgsTg);
    var l =[];
    var k = [];
    for (var i = 0; i < imgIdArr.length; i++) {
     l[i+1] = parseFloat(imgIdArr[i]);
    }
    for (var j = 0; j < tagCountArr.length; j++)
    {
      k[j+1] = parseFloat(tagCountArr[j]);
    }
   // console.log(l);
    var curImageIdx = curr_index, 
       
    total = images.length;
    var wrapper = $('#image-gallery'),
        curSpan = wrapper.find('.current');
    var viewer = ImageViewer(wrapper.find('.image-container'));
 
    //display total count
    wrapper.find('.total').html(total);
 
    function showImage(){
      var current_i = $('#current_i').val();    
       if((current_i!='') || (current_i!='undefined')){     
          // $('.loaderClas').attr('style','display:block;');        
        }
        var imgObj = images[curImageIdx - 1];
        viewer.load(imgObj.small, imgObj.big,imgObj.image_type);
        curSpan.html(curImageIdx);
        setTimeout(function(){ $('.loaderClas').attr('style','display:none;');   }, 500);
    }
    
    wrapper.find('.next').click(function(){
         curImageIdx++;
          if(curImageIdx > total) {
            curImageIdx = 1;
          }
          $("#tagId").val(l[curImageIdx]);
          $("#tagIdAccImg").val(k[curImageIdx]);
          imgtagName(k[curImageIdx]);
          if(parseInt(k[curImageIdx])>0){
            $('#removeTag').attr('style','display:block;');
          }
          else
          {
             $('#removeTag').attr('style','display:none;');
          }
          showImage();
    });
 
    wrapper.find('.prev').click(function(){
         curImageIdx--;
        $("#tagId").val(l[curImageIdx]);
        $("#tagIdAccImg").val(k[curImageIdx]);
        imgtagName(k[curImageIdx]);
        if(curImageIdx < 1) 
        {
              curImageIdx = total; 
              $("#tagId").val(l[curImageIdx]);
              $("#tagIdAccImg").val(k[curImageIdx]);
        }
        if(parseInt(k[curImageIdx])>0){
          $('#removeTag').attr('style','display:block;');
        }
        else
        {
           $('#removeTag').attr('style','display:none;');
        }
        showImage();
    });
  
  if(parseInt(k[curImageIdx])>0){
    $('#removeTag').attr('style','display:block;');
  }
  else
  {
     $('#removeTag').attr('style','display:none;');
  }
 
    showImage();
};


  function delImg(eve)
  {
    var reConfirm = confirm("Do you want to Delete this Image");
    if(reConfirm==true){
    var ids = $(eve).attr('id');
    var idarr = ids.split('_');
    var id = idarr[1];
    var tag_seq = $('#'+id).attr('class');
    var removedId = tag_seq.split('_');
    var tagCurrId = $('#current_i').val();
    var j = parseInt(tagCurrId) - parseInt(1);
    var newId = parseInt(removedId[1]);
    var oldId = parseInt(newId)+parseInt(1);
    //alert('totalimage-'+j);
    for(var i = removedId[1];i<=j;i++)
    {
        //alert('oldId-'+oldId+' newId-'+newId);
        var tagClass = $('.tagClass_'+oldId).attr('class','tag tagClass_'+newId);
        oldId++;
        newId++;
    }
    //var tagClass = $('.tagClass_'+removedId);
    $('#current_i').val(j);
    $.ajax({
      type : 'POST',
      url : "<?php echo base_url(); ?>" + "Finance/deleteImg/",
      data : {id:idarr[1]},
    });
    $('#'+id).parents('.dz-preview').remove();
    var chkNoOfDiv = $("#preview > *").length;
    if(chkNoOfDiv == 0){
      $('.addfile').hide();
      $('.needsclick').css('border-width','1px').removeClass('bg-none');
    }
  }
  else
  {
    return false;
  }
  }
  $('#tagimage').click(function(){
    var customer_id = $('#customer_id').val();
     var case_id = $('#case_id').val();
    showImages(customer_id,case_id);
  });
$('#uploadimage').click(function(){
    var customer_id = $('#customer_id').val();
  });

  $(document).ready(function(){
    $('body').on('click','.dz-preview .tag',function(){
      var currID=$(this).attr('id');
      var currCl=$(this).attr('class');
      if(currID!='')
      {

        $('#tagId').val(currID);
        var currentImg = currCl.split('_');
        $('#curr_img').val(currentImg[1]);
        $('#tagimage').trigger('click');
        var customer_id = $('#customer_id').val();
        var case_id = $('#case_id').val();
        showImages(customer_id,case_id);
        return true;
      }
    });
  });
          function imageTagging(eve)
          {
            var taggedID=$(eve).attr('id');
            var imageTagId = taggedID.split('_');
            var relId=$(eve).attr('rel');
            var subcatTagId = relId.split('_');
            var currImgId = $('#tagId').val();
            var tagdocId = imageTagId[1];
            var tagText = $('#'+taggedID).text();
            $('#tagging_id').val(imageTagId[1]);

            if((currImgId>0) && (tagdocId>0))
            {
              $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/loanTagMapping/",
              dataType: 'json',
              data : {ImgID:currImgId,taggID:tagdocId,customer_id:customer_id,type:'add',doctype:'post',case_id:case_id,subcat:subcatTagId[1]},
              success: function (response) { 
                 if(response.status=='1')
                  {
                     // alert(response.msg);
                      updateCounter(imageTagId[1],'add',subcatTagId[1]);
                      //$('#subclass_'+imageTagId[1]).attr('class','badg badge');
                      $('.subr_'+subcatTagId[1]).addClass('badge');
                      $('.subrc_'+subcatTagId[1]).addClass('active');
                      var removedCount = $('#tagCount').html();
                      if(parseInt(removedCount)>0){
                       var countRemaining=parseInt(removedCount)-parseInt(1);
                       $('#tagCount').html(countRemaining);
                       $('.next').trigger('click');
                    }

                  }
                  else
                  {
                     alert(response.msg);
                     $('.subr_'+subcatTagId[1]).removeClass('badge');
                     $('.subrc_'+subcatTagId[1]).removeClass('active');
                     var tick_id = $(".subrc_"+subcatTagId[1]).parents('.panel').find('.tick').attr("id");
                     setTimeout(function(){
                        $("#"+tick_id).hide();
                        $("#"+tick_id).css("display","none");
                     }, 1000);
                  }
                }
              });
            }
          }
          $('#removeTag').click(function(){
            var image_id = $('#tagId').val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/loanTagMapping/",
              data : {ImgID:image_id,customer_id:customer_id,type:'remove',doctype:'post',case_id:case_id},
              dataType: 'json',
              success: function (response) { 
                if(response.status)
                { 
                   updateCounter(response.parent_tag_id,'remove',response.tag_id);
                   $('#removeTag').attr('style','display:none;');
                   var removedCount = $('#tagCount').html();
                   var countRemaining=parseInt(removedCount)+parseInt(1);
                   $('#tagCount').html(countRemaining);
                   var removetick = 0;
                    $("#sudbreq_"+response.parent_tag_id).parent('ul').find('li').each(function(){
                        if($(this).hasClass("active")){
                            removetick = 1;
                        }
                    });
                    if(removetick == 0){
                      $("#sudbreq_"+response.parent_tag_id).parents('.panel').find('.tick').hide();                           
                    }
                   $('.next').trigger('click');

                }
                else
                {
                  alert(response.msg);
                  //$('.next').trigger('click');
                }

              }
              });
          });

            function updateCounter(tagId,type,classId)
                  {
                      var counter= $('#subclass_'+tagId).text();
                      counter = $.trim(counter);
                      var strn= '';
                      //alert(counter);
                      if(counter=='*')
                      {
                        strn = '*';
                        counter='';
                      }
                      if(counter.indexOf('*') != -1)
                      {
                        strn = '*';
                        counter = counter.replace('*','');
                      }
                      if(type=='add')
                      {
                        if(counter=='')
                        {
                           $('#subclass_'+tagId).text('1');
                           $('#sudbreq_'+tagId).addClass('active'); 
                           $('.subr_'+classId).text('1');
                           $('.subr_'+classId).addClass('active');
                        }
                        else
                        {
                          var abc = parseInt(counter)+parseInt(1);
                          $('#subclass_'+tagId).text('');
                          $('.subr_'+classId).text(''); 
                          $('#subclass_'+tagId).text(abc); 
                          $('.subr_'+classId).text(abc);
                          $('.subr_'+classId).addClass('active');
                          $('#sudbreq_'+tagId).addClass('active');              
                        }
                      }
                      else
                      {
                         if($.trim(counter)=='')
                          {
                            $('#subclass_'+tagId).text('');
                            $('#sudbreq_'+tagId).removeClass('active'); 
                            $('.subr_'+classId).html(''); 
                            $('.subrc_'+classId).removeClass('active'); 
                          }
                          else
                          {
                            var countarr = counter.split(' ');
                            var cc = '';
                            var ee = '';
                            if(countarr[1]==undefined)
                            {
                              cc = countarr;
                            }
                            else
                            {
                              cc = countarr[1];
                              ee = '*';
                            }
                            if(cc>1)
                            {
                              $('.subr_'+classId).text('');
                              var abc = parseInt(cc)-parseInt(1);
                              $('#subclass_'+tagId).text(ee+' '+abc);
                              $('#sudbreq_'+tagId).addClass('active'); 
                              $('.subr_'+classId).text(ee+' '+abc);
                               $('.subr_'+classId).addClass('active');  
                            }
                            else
                            {
                              $('#subclass_'+tagId).text('');
                              $('#sudbreq_'+tagId).removeClass('active'); 
                              $('.subr_'+classId).text('');
                              $('.subr_'+classId).removeClass('active'); 
                            }
                            
                          }
                      }
                  }

      
          function appBank(tag_id)
          {
              $('#applicationBank').attr('class','modal fade in');
              $('#applicationBank').attr('style','display:block;');
              $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/getBankList/",
              data : {type:'loan',customer_id:customer_id,tag_id:tag_id,doctype:'post',case_id:case_id},
              success: function (response) { 
                $("#bank_name").html(response);
                }
              });
              return false;
          }
          $(".close").click(function(){
             $('#applicationBank').attr('class','modal fade');
             $('#applicationBank').attr('style','display:none;');
          });

          function updateBank()
          {
            var bank = $("#bank_name").val();
            var tag_id = $("#tagging_id").val();
            var img_id = $('#tagId').val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/loanTagMapping/",
              data : {bank:bank,taggID:tag_id,ImgID:img_id,customer_id:customer_id,type:'bank',doctype:'post',case_id:case_id},
              dataType: 'json',
              success: function (response) 
              { 
                //alert(response)
                 if(response.status=='1')
                  {
                    alert(response.msg);
                    $('#subclass_'+tag_id).attr('class','badg badge');
                   // $('#subclass_'+imageTagId[1]).attr('class','badg badge');
                     var removedCount = $('#tagCount').html();
                     if(parseInt(removedCount)>0){
                       var countRemaining=parseInt(removedCount)-parseInt(1);
                       $('#tagCount').html(countRemaining);
                       $('.next').trigger('click');
                       updateCounter(tag_id,'add');
                    }

                  }
                $('#applicationBank').attr('class','modal fade');
                $('#applicationBank').attr('style','display:none;');
              }
             });

          }

          function markIncorrect()
          {
            var reason = $('#markincor').val();
            var tag_id = $("#tagging_id").val();
            var img_id = $('#tagId').val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/loanTagMapping/",
              data : {reason_id:reason,taggID:tag_id,ImgID:img_id,customer_id:customer_id,type:'markincorrect',doctype:'post',case_id:case_id},
              dataType: 'json',
              success: function (response) 
              { 
                if(response.status=='0')
                  {
                    $('.next').trigger('click');
                  }


              }

            });
          }


           $("#category_id").change(function() {
            var catId = $("#category_id").val();
            var case_id = $("#case_id").val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/pendencyByCatId/",
              data : {catId:catId,doctype:9,case_id:case_id},
              dataType: 'html',
              success: function (response) 
              { 
                 $("#pendency_id").html(response);
              }

            });
          });

           function getCategoryList()
           {
            // var catId = $("#category_id").val();
              var case_id = $("#case_id").val();
              $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/pendencyByCatId/",
              data : {type:'getcategoryId',doctype:9,case_id:case_id},
              dataType: 'html',
              success: function (response) 
              { 
                 $("#category_id").html(response);
                 $("#pendency_id").val('');
              }

              });
          }

function addPendency()
{
  var customer_id = $("#customer_id").val();
  var case_id = $("#case_id").val();
  var pendencyId = $("#pendency_id").val();
  var category_id = $("#category_id").val();
 // alert(category_id);
   $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/addPendencyDoc/",
              data : {case_id:case_id,doctype:9,pendencyId:pendencyId,category_id:category_id},
              dataType: 'json',
              success: function (response) 
              { 
                if(response.status=='1'){
                 $('#err_'+category_id).attr('style','display: inline');
                 $('#sudbreq_'+pendencyId).addClass('active');
                 $("#pendencyErr").html('');
                 $("#pendency_id").val('');
                 $("#category_id").val('');
                }
                else{
                  $("#pendencyErr").html(response.msg);
                  $("#pendency_id").val('');
                  $("#category_id").val('');
                }
                $('#addPendency').removeClass('in');
                $('.close').trigger('click');
              }

            });
}

function removeAll()
{
  var allImg = $('#allImgId').val();
  if (confirm("Do you want to delete all images"))
  {
    $.ajax({
          type : 'POST',
          url : "<?php echo base_url(); ?>" + "Finance/deleteImg/",
          data : {id:allImg,type:'all'},
          success: function (response) 
          { 
            postd();
          }
    });
  }
  else
  {
    return false;
  }
}

        function savelogindoc()
        {
          var customer_id = $("#customer_id").val();
          var case_id = $("#case_id").val();
           $.ajax({
                  type : 'POST',
                  url : "<?php echo base_url(); ?>" + "Finance/saveLoginDocs/",
                  data : {customer_id:customer_id,case_id:case_id,doctype:'9'},
                  dataType: 'json',
                  success: function (response) 
                  { 
                    if (response.status == 'True')
                    {
                      snakbarAlert(response.message);
                      $('.loaderClas').attr('style','display:block;'); 
                      setTimeout(function () {
                      window.location.href =response.Action;
                     }, 2500);

                      return true;
                    }
                    else 
                    {
                      snakbarAlert(response.message);
                      return false;
                    } 
                  }
            }); 
        }
         function imgtagName(tagid='',imag_id='')
        {
          if(imag_id=='')
          {
             var imag_id = $("#tagId").val();
          }
           var case_id = $("#case_id").val();
           $.ajax({
              type : 'POST',
              url : base_url+ "Finance/getTagName/",
              data : {tagid:tagid,case_id:case_id,imag_id:imag_id,doctype:9},
              dataType : 'json',
              success: function(data)
              {
                $('#img_tag_name').attr('style',"display:none !important");
                $('#removeTag').attr('style',"display:none !important");
                if(data!='')
                {
                  $('#img_tag_name').attr('style',"display:block !important");
                  $('#img_tag_name').html(data);
                  $('#removeTag').attr('style',"display:block !important");
                }

              }
            });
        }
        function countinue(action)
        {
           window.location.href = action;
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
          window.top.location.href = base_url+"Finance/getImagedownload/"+case_id+"/9 ";  
        }
      </script>



