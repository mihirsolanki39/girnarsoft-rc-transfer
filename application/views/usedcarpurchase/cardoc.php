<?php 
$styl = 'display:block';
?>
                                    <div class="sec-card">
                                       <ul class="nav nav-tabs nav-uptag" role="tablist">
                                          <li role="presentation" class="active"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab" onclick="cardoc()" id="uploadimage">UPLOAD</a></li>
                                          <li role="presentation"><a href="#tag" aria-controls="tag" role="tab" data-toggle="tab" id="tagimage">TAG</a></li>
                                           <li role="presentation"><a href="#checklists" aria-controls="tag" role="tab" data-toggle="tab" onclick="checklistdoc()" id="checkl">Check List</a></li>
                                       </ul>
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
                                          <form class="needsclick  <?php if(!empty($imageList)){?> dz-clickable bg-none <?}?>" <?php if(!empty($imageList)){?> style="border-width: 0px;" <?}?>   id="demoUpload">
                                            <div id="preview" <?php if(!empty($imageList)){?> class="ui-sortable"<?}?> >
                                              <?php 
                                                $j = 1;
                                                $tagId =[];
                                                $parent_id = [];
                                                $pendency_doc_ids = [];
                                              if(!empty($imageList)) {
                      
                                                foreach ($imageList as $ikey => $ival){                         
                                                if(!empty($ival['sub_id']))
                                                {
                                                  $tagId[$ival['sub_id']][]=$ival['sub_id'];
                                                  //$parent_id[$ival['parent_id']][]=$ival['parent_id'];
                                                }
                        //$imageList['allParentIds'];
                                                  ?>
                                              <div class="dz-preview dz-image-preview">
                                                <div class="dz-image">
                                                  <img data-dz-thumbnail="" alt="<?=$ival['doc_name']?>" src="<?=$ival['doc_url']?>">
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
                                              <? $j++; } }
                                                ?>

                                            </div>
                                            <div class="addfile" id="secUploadBtn" <?php if(!empty($imageList)){?> style="display:block;" <?}?>></div>
                                          </form>
                                          </div>
                                          <div role="tabpanel" class="tab-pane" id="tag">
                                             <div class="row">
                                                <div class="options">
                                                  <ul class="options-ul">
                                                    <li id="mkIncorrect"><a href="#" class="option-list" data-toggle="modal" data-target="#markIncorrect">MARK INCORRECT</a></li>  
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
                                                            <img src="<?=base_url()?>assets/images/left.svg" class="prev"/>
                                                            <img src="<?=base_url()?>assets/images/left.svg" class="next"/>
                                                            
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="panel-group" id="accordion">
                                                         <!------>
                                                          <?php 
                                                            $i = 1; 
                                                            /*echo "<pre>";
                                                            print_r($uploadDocList);
                                                            exit;*/
                                                            foreach($uploadDocList as $key => $val ) {
                                                            $req = '';
                                                            
                                                            if($val['is_require']=='1')
                                                            {
                                                              //$req = '*';
                                                            }
                                                            ///$style = '';
                                                            if(!empty($allParentIds))
                                                            {
                                                              foreach ($allParentIds as $ksel=>$vsel) 
                                                              {
                                                                     
                                                                        if($key==$vsel)
                                                                        {
                                                                          $style[$key]='style="display: inline;"';
                                             
                                                                        }
                                                                  
                                                              }
                                                            }
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
                                                           // echo "<pre>";
                                                          //  print_r($error);
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
                                                                       <span class="error" id="err_<?=$key?>" <?=(!empty($error[$key])?$error[$key]:'')?>>
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
                                                                          if(!empty($val['subList'])){
                                                                          foreach($val['subList'] as $subkey => $subval){ 
                                                                            //echo "<pre>";
                                                                            //print_r($pendency_doc_ids);
                                                                            //exit;
                                                                            $addfrm = '';
                                                                            if(in_array($subval['sub_category_id'], $pendency_doc_ids))
                                                                            {
                                                                              $addfrm = 'active';
                                                                            }
                                                                           $subreq = '';
                                                                          if($subval['is_require']=='1')
                                                                          {
                                                                           // $subreq = '*';
                                                                          }
                                                                          foreach ($tagId as $ksel => $vsel) 
                                                                          {
                                                                            $count = 0;
                                                                              foreach($vsel as $vk=>$vv)
                                                                              {
                                                                               // echo $subval['sub_category_id'].'---'.$vv.',';
                                                                                if(intval($subval['sub_category_id'])==intval($vv))
                                                                                $count = intval($count)+1;
                                                                              }
                                                                              //echo $count;
                                                                              if($count>0){
                                                                               $v[$subkey]= 'badge_'.$count;
                                                                                }
                                                                              //}
                                                                          }
                                                                          //exit;
                                                                         // print_r($v);

                                                                          $arrClass =[];
                                                                          if(!empty($v[$subkey])){
                                                                            //echo $v[$subkey]; 
                                                                             $arrClass = explode('_',$v[$subkey]);
                                                                              if($arrClass[1]==0)
                                                                               {
                                                                                $arrClass = [];
                                                                               }
                                                                           }
                                                                          ?>
                                                                            <li class="app-form subrc_<?=$subval['sub_category_id']?> <?=$addfrm?> <?=(!empty($arrClass))?'active':''?>" id="sudbreq_<?=$subkey?>" rel="subr_<?=$subval['sub_category_id']?>" onclick="imageTagging(this)" ><?=$subval['name'];?>  
                                                                            <span><?=$subreq?></span>
                                                                          <span id="subclass_<?=$subkey?>" class="subr_<?=$subval['sub_category_id']?> badg <?=(!empty($arrClass))?$arrClass[0]:''?>"><?=(!empty($arrClass))?$arrClass[1]:''?></span>
                                                                        </li>
                                                                        <?php } } ?>
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
                                        <input type="hidden" name="case_id" value="<?=(!empty($carid))?$carid:''?>" id="case_id"> <!--Car id -->
                                        <input type="hidden" name="tagId" value="<?=(!empty($imageList[0]['id']))?$imageList[0]['id']:''?>" id="tagId"> <!--current image id -->
                                        <input type="hidden" name="tagdocId" value="" id="tagdocId"> 
                                        <input type="hidden" name="customer_id" value="<?=(!empty($car_id))?$car_id:''?>" id="customer_id"> <!--current case id -->
                                        <input type="hidden" name="imagesId" value="" id="imagesId">
                                        <input type="hidden" name="imags" id="imags" value="">
                                        <input type="hidden" name="curr_img" value="" id="curr_img"><!--current image id -->
                                        <input type="hidden" name="allImgId" value="" id="allImgId"><!--all image id -->
                                        <input type="hidden" name="current_i" value="<?=$j?>" id="current_i"> <!--current img serial number -->
                                        <input type="hidden" name="tagging_id" value="" id="tagging_id"> <!--tag document -->
                                        <input type="hidden" name="counttagid" value="" id="counttagid"> <!--count tag document -->
                                        <input type="hidden" name="tagIdAccImg" value="<?=(!empty($imageList[0]['tag_id']))?$imageList[0]['tag_id']:''?>" id="tagIdAccImg"> 
                                        <input type="hidden" name="imgloop" value="" id="imgloop">
                                        <input type="hidden" name="countloop" value="1" id="countloop">
                                        <input type="hidden" name="personnelDocs" value="<?=(!empty($personnelDocs)?'1':'0')?>" id="personnelDocs">

                                     </div>
                                             </div>
                                              </div>

                                              </div>
                                                                                      <!--<div class="row col-md-12 clearfix">

                                               <div class="btn-sec-width tag-btn-complete">
                                                                                
                                                  <a onclick="savelogindoc()" style="<?=$stylesss?>" class="btn-continue saveCont final-submit">SAVE AND CONTINUE</a>
                                                </div>
                                              </div>-->

                                          </div>          
                                          </div>
                                       </div>

                                          </div>          
                                       <div role="tabpanel" class="tab-pane" id="checklists">
                                       </div>  
                                       <div class="col-md-12">

                                      <div class="btn-sec-width tag-btn-complete">
                                                                    
                                                                        
                                          <a onclick="savelogindoc()" style="<?=$stylesss?>" class="btn-continue saveCont final-submit">SAVE AND CONTINUE</a>
                                        
                                        </div>
                                      </div>
                                     
                                      
                                              
                                   


       <div class="modal fade" id="markIncorrect" role="dialog">
         <div class="modal-dialog">
             Modal content
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

      <div class="modal fade bs-example-modal-sm" id="chooseRadio" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-backdrop fade in" style="height: 100%"></div>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-custom">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" onclick="xclose();" class="close" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
              <div class="row">
                 <div class="col-md-6 clearfix">
                    <h4 class="modal-title">Print Letter</h4>
                 </div>
              </div>
        </div>
      <div class="modal-body">
      <?=(!empty($usedCarInfo['tradetype']) && $usedCarInfo['tradetype']=='1')?'Do you want to Print Letter for Park & Sell':'Do you want to Print Letter for Delivery Note'?>
         <div class="col-md-6">
                        <div class="form-group">
                            
                           <span class="radio-btn-sec">
                                <input type="radio" name="notes" id="yes" value="2" class="trigger ptype" <?= !empty($usedCarInfo)  && $usedCarInfo['print_docs']=='2'?'checked=checked':''?>>
                                <label for="yes"><span class="dt-yes"></span>Yes </label>
                            </span>
                             <span class="radio-btn-sec">
                                <input type="radio" name="notes" id="no" value="1" class="trigger ptype" <?= !empty($usedCarInfo) && $usedCarInfo['print_docs']=='1'?'checked=checked':''?>>
                                <label for="no"><span class="dt-yes"></span> No</label>
                            </span>
                            <div class="error" id="err_buyer_type"></div>
                        </div>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="choosePrint" onclick="savePrint()"  class="btn btn-primary">Save</button>
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
     var customer_id = $('#case_id').val();
     var case_id = $('#customer_id').val();
     var countloop = $('#countloop').val();
     //alert(countloop+'adededesd');
      // Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("form#demoUpload", {
                url: '<?php echo base_url(); ?>UsedcarPurchase/uploadCarDocs/'+case_id+"-"+customer_id,
                previewsContainer: '#preview',
                success: function(file, response){
                  // $('.loaderClas').attr('style','display:block;'); 
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
                      // $('.loaderClas').attr('style','display:block;'); 
                    }
                   
                    if(parseInt(imgloop)!=parseInt(countloop))
                    {
                        var ii = $('#countloop').val();
                        ii++;
                        $('#countloop').val(ii);
                    }
                   // alert(ii);
                    
                    var j = parseInt(tagCurrId) + parseInt(1);
                    $('#current_i').val(j);
                   //alert(customer_id+'-----'+case_id);
                    showImages(customer_id,case_id);
                    if(parseInt(imgloop)==parseInt(ii))
                    {                   
                      $('.loaderClas').attr('style','display:none;');
                       cardoc(); 
                    }
                    //login();
                  }
            });

           var myDropzone1 = new Dropzone("div#secUploadBtn", {
                url: base_url+'UsedcarPurchase/uploadCarDocs/'+case_id+"-"+customer_id,
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
                   // alert(customer_id+'---e--'+case_id);
                   showImages(customer_id,case_id);
                   cardoc();
                  }
                  
           });
         //alert('not gud');
           $('.needsclick').on("dragenter", function(event) {
              $('.needsclick').css('border-color','#333');
            });
            
         
          
          
          //Image Viewer
          $(document).ready(function(){
              
              $('body').on('click','.dz-error-mark .del-btns',function(){
                // alert('not gud1');
                 /* $(this).parents('.dz-preview').remove();
                  var chkNoOfDiv = $("#preview > *").length;
                  if(chkNoOfDiv == 0){
                     $('.addfile').hide();
                     $('.needsclick').css('border-width','1px').removeClass('bg-none');;
                 }*/
            });
            //alert(customer_id+'-'+case_id);
            //alert(customer_id+'---r--'+case_id);
                showImages(customer_id,case_id);
                $('.app-form').click(function(){
                  var cu = $('#curr_img').val();
                  if(cu!=''){
                    var dddid = $(this).attr('id');
                    //alert(dddid);
                    //alert($(this).attr('rel'));
                    var dfdf = dddid.split('_');
                    
                    
                    var currIDRel = $(this).attr('rel');
                    
                    
                    if((dfdf[1]=='1') || (dfdf[1]=='2'))
                    {
                      if(dfdf[1]=='1')
                      {
                         var s8 =  $('#subclass_1').text();
                      }
                      if(dfdf[1]=='2')
                      {
                         var s9 = $('#subclass_2').text();
                      }
                      if((s9>=1) && (s8>=1)){
                        $(this).parents('.panel').find('.tick').show();
                        $(this).parents('.panel').find('.error').hide();
                      }
                    }
                    else if((dfdf[1]!='1') || (dfdf[1]!='2'))
                    {
                      $(this).parents('.panel').find('.tick').show();
                      
                      $('li[rel='+currIDRel+']').parents('.panel').find('.tick').show();
                      
                      
                      $(this).parents('.panel').find('.error').hide();
                    }
                  }
                    //$(this).parents('.panel').find('.error').hide();
                });
               $('.final-submit').click(function(){
               });
              $('#tag').click( function(){
              }); 
         
         }); 
               
                function showImages(customer_id,case_id='')
                {
                     $.ajax({
                      type : 'POST',
                      url : "<?php echo base_url(); ?>" + "UsedcarPurchase/showImagesToTag/",
                      data : {customer_id:customer_id,case_id:case_id,doc:'1'},
                      dataType: 'json',
                      success: function (img) { 
                        //alert(img);
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
                        //alert(str);
                        strtagId=strtagId.slice(0,-1); 
                        $('#counttagid').val(strtagId);
                        $('#allImgId').val(str);
                        initial(img);
                        if(str=='')
                        {
                          $('.next , .prev').attr('style','display:none;');
                        }
                        else{
                         // $('#tg').attr('style','display:block;');
                         
                      }
                        }
                    });
                   //$('.loaderClas').attr('style','display:none;'); 
                    

                }
                    

             
    function initial(imagesssss){
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
    //imgtagName($('#tagIdAccImg').val());
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
    //alert(imgIdArr.length);
    for (var i = 0; i < imgIdArr.length; i++) {
     l[i+1] = parseFloat(imgIdArr[i]);
    }
    for (var j = 0; j < tagCountArr.length; j++)
    {
      k[j+1] = parseFloat(tagCountArr[j]);
    }
    console.log(l);
    var curImageIdx = curr_index,   
    total = images.length;
    var wrapper = $('#image-gallery'),
        curSpan = wrapper.find('.current');
    var viewer = ImageViewer(wrapper.find('.image-container'));
 
    //display total count
    wrapper.find('.total').html(total);
 
    function showImage(){
      var current_i = $('#current_i').val();
      //alert(current_i);
      if(current_i!='1'){
        //alert('hi');
          //$('.loaderClas').attr('style','display:block;');    
       }
        var imgObj = images[curImageIdx - 1];
        viewer.load(imgObj.small, imgObj.big);
        curSpan.html(curImageIdx);
        setTimeout(function(){ $('.loaderClas').attr('style','display:none;');   }, 500);
       
    }
    
    wrapper.find('.next').click(function(){
      
          curImageIdx++;
          if(curImageIdx > total) {
            curImageIdx = 1;
          }
         // alert(l[curImageIdx]);
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
     // $('.loaderClas').attr('style','display:block;');
         curImageIdx--;
         //alert(l[curImageIdx]);
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
        $('.loaderClas').attr('style','display:none;');
    });
  
  if(parseInt(k[curImageIdx])>0){
    $('#removeTag').attr('style','display:block;');
  }
  else
  {
     $('#removeTag').attr('style','display:none;');
  }
    
    //initially show image
    showImage();
};

 
    //initially show image
    //showImage();

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
    $('#current_i').val(j);
    $.ajax({
      type : 'POST',
      url : "<?php echo base_url(); ?>" + "UsedcarPurchase/deleteImg/",
      data : {id:idarr[1],doc:'1'},
    });
      $('#'+id).parents('.dz-preview').remove();
                  var chkNoOfDiv = $("#preview > *").length;
                  if(chkNoOfDiv == 0){
                    //alert('gggg'+id);
                     $('.addfile').hide();
                     $('.needsclick').css('border-width','1px').removeClass('bg-none');;
                 }
  }
    else
    {
      return false;
    }
  }

  $('#tagimage').click(function(){
    var customer_id = $('#case_id').val();
     var case_id = $('#customer_id').val();
     $('#checklists').attr('style','display:none');
     $('#checklists').html('');
     $('#tag').attr('style','display:block');
     //alert(customer_id+'--f---'+case_id);
    showImages(customer_id,case_id);
  });
$('#uploadimage').click(function(){
    var customer_id = $('#customer_id').val();
  });

  $(document).ready(function(){
    $('body').on('click','.dz-preview .tag',function(){
      var currID=$(this).attr('id');
      var currCl=$(this).attr('class');
      //alert(currID);
      if(currID!='')
      {
       // alert('hii');
        //var ids = $(ev).attr('id');
        $('#tagId').val(currID);
        //var tagCurrentImage = $(ev).attr('class');
        var currentImg = currCl.split('_');
        $('#curr_img').val(currentImg[1]);
        $('#tagimage').trigger('click');
        var customer_id = $('#case_id').val();
        var case_id = $('#customer_id').val();
       // alert(customer_id+'---fd--'+case_id);
        showImages(customer_id,case_id);
        return true;
      }
    });
  });
          function imageTagging(eve)
          {
            var taggedID=$(eve).attr('id');
            var relId=$(eve).attr('rel');
            var imageTagId = taggedID.split('_');
            var subcatTagId = relId.split('_');
            var currImgId = $('#tagId').val();
            var tagdocId = imageTagId[1];
            $('#tagging_id').val(imageTagId[1]);
            var tagText = $('#'+taggedID).text();
            var arr =['1','2','3','4','5','6'];
            if(jQuery.inArray(imageTagId[1], arr)!= -1)
            {
              //appBank(imageTagId[1],relId);
             // return false;
            }
            if((currImgId>0) && (tagdocId>0))
            {
              $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/loanTagMapping/",
              dataType: 'json',
              data : {ImgID:currImgId,taggID:tagdocId,customer_id:customer_id,type:'add',case_id:case_id,subcat:subcatTagId[1],doc:'1'},
              success: function (response) { 
          //alert(response.status);
                 if(response.status=='1')
                  {
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
                   // $('#subclass_'+imageTagId[1]).attr('class','badg');
                    $('.subr_'+subcatTagId[1]).removeClass('badge');
                    $('.subrc_'+subcatTagId[1]).removeClass('active');
                  }
                }
              });
            }
          }
          $('#removeTag').click(function(){
            var image_id = $('#tagId').val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/loanTagMapping/",
              data : {ImgID:image_id,customer_id:customer_id,type:'remove',case_id:case_id,doc:'1'},
              dataType: 'json',
              success: function (response) { 
                if(response.status)
                { 
                  // alert(response.tag_id);

                   updateCounter(response.parent_tag_id,'remove',response.tag_id);
                   $('#removeTag').attr('style','display:none;');
                   var removedCount = $('#tagCount').html();
                   var countRemaining=parseInt(removedCount)+parseInt(1);
                   $('#tagCount').html(countRemaining);
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
                          $('#sudbreq_'+tagId).addClass('active'); 
                          $('.subr_'+classId).text(abc); 
                           $('.subr_'+classId).addClass('active');             
                        }
                      }
                      else
                      {
                        //alert(counter)
                         if($.trim(counter)=='')
                          {
                           // alert('eeee');
                            $('#subclass_'+tagId).html('');
                            $('#sudbreq_'+tagId).removeClass('active'); 
                            $('.subr_'+classId).html(''); 
                             $('.subrc_'+classId).removeClass('active'); 
                          }
                          else
                          {
                            // alert('eeewwww');
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
          function appBank(tag_id,rel_id)
          {
              $('#applicationBank').attr('class','modal fade in');
              $('#applicationBank').attr('style','display:block;');
              $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/getBankList/",
              data : {type:'loan',customer_id:customer_id,tag_id:tag_id,case_id:case_id},
              success: function (response) { 
                $("#bank_name").html(response);
                $('#rel_id').val(rel_id);
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
            var text8 = $('#subclass_1').text();
            var text9 = $('#subclass_2').text();
            var rel_id = $('#rel_id').val();
            var re = rel_id.split('_');
            if((tag_id=='1') || (tag_id=='2')) 
            {
              // alert('rrrr2');
              if((tag_id=='1') && (text9!=''))
              {
                $('#err_1').attr('style','display: none');
                $('#subclass_1').parents('.panel').find('.tick').show();
                $('#subclass_1').parents('.panel').find('.error').hide();
              }
              if((tag_id=='2') && (text8!=''))
              {
                // alert('rrrr3');
                $('#err_1').attr('style','display: none');
                $('#subclass_2').parents('.panel').find('.tick').show();
                $('#subclass_2').parents('.panel').find('.error').hide();
              }
            }

            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/loanTagMapping/",
              data : {bank:bank,taggID:tag_id,ImgID:img_id,customer_id:customer_id,type:'bank',case_id:case_id,subcat:re[1],doc:'1'},
              dataType: 'json',
              success: function (response) 
              { 
                 if(response.status=='1')
                  {
                    $('#subclass_'+tag_id).attr('class','badg badge');
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
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/loanTagMapping/",
              data : {reason_id:reason,taggID:tag_id,ImgID:img_id,customer_id:customer_id,type:'markincorrect',case_id:case_id,doc:'1'},
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
            var case_id = $("#customer_id").val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/pendencyByCatId/",
              data : {catId:catId,doctype:'7',case_id:case_id},
              dataType: 'html',
              success: function (response) 
              { 
                 $("#pendency_id").html(response);
              }

            });
          });

           function getCategoryList()
           {
              var case_id = $("#customer_id").val();
              $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/pendencyByCatId/",
              data : {type:'getcategoryId',doctype:'7',case_id:case_id},
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
          var customer_id = $("#case_id").val();
          var case_id = $("#customer_id").val();
          var pendencyId = $("#pendency_id").val();
          var category_id = $("#category_id").val();
           $.ajax({
                      type : 'POST',
                      url : "<?php echo base_url(); ?>" + "UsedcarPurchase/addPendencyDoc/",
                      data : {case_id:case_id,doctype:'7',pendencyId:pendencyId,category_id:category_id},
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
          //alert('hi');
          var allImg = $('#allImgId').val();
          if (confirm("Do you want to delete all images"))
          {
            $.ajax({
                  type : 'POST',
                  url : "<?php echo base_url(); ?>" + "UsedcarPurchase/deleteImg/",
                  data : {id:allImg,type:'all',doc:'1'},
                  success: function (response) 
                  { 
                    cardoc();
                  }
            });
          }
          else
          {
            return false;
          }
        }
        function downloadAll()
        {
            var allImg = $('#allImgId').val();
            var customer_id = $("#case_id").val();
            var case_id = $("#customer_id").val();
            /*$.ajax({
                  type : 'POST',
                  url : "<?php echo base_url(); ?>" + "Finance/downloadImg/",
                  data : {id:allImg,type:'all'},
                  success: function (response) 
                  { 
                   //alert('hi');
                  }
            });*/
          window.top.location.href = base_url+"UsedcarPurchase/getImagedownloadcardoc/"+case_id;  
        }
        function choosePrint()
        {
          $('#chooseRadio').attr('style','display:block;');
          $('#chooseRadio').addClass(' in');
          
        }
        function savePrint()
        {
          $('#err_buyer_type').html(''); 
          var printType = $('input[name=notes]:checked').val();
          //alert(printType);
          if(printType!='')
          {
            $('#chooseRadio').removeClass(' in');
            $('#chooseRadio').attr('style','display:none;');
            setTimeout(function(){savedata(printType); }, 30);

          }
          else
          {
            $('#err_buyer_type').html('Please Select Print Type'); 
            return false;
            //$('#err_buyer_type').html('Please Select Print Type'); 
          }
        }

        function xclose()
        {
          $('#chooseRadio').removeClass(' in');
          $('#chooseRadio').attr('style','display:none;');
        }
        function savelogindoc()
        {
          var form = '';
          var customer_id = $("#customer_id").val();
          var case_id = $("#case_id").val();
          var checkloginform = $('#checklistform').val();
          var tradetype= '<?= $tradetype; ?>';
          
          if(checkloginform=='1')
          {
             form = $('#checkForm').serialize();
          }
           $.ajax({
                  type : 'POST',
                  url : "<?php echo base_url(); ?>" + "UsedcarPurchase/saveLoginDocs/",
                  data : {customer_id:case_id,case_id:customer_id,doctype:'7',doc:'1',checkloginform:form},
                  dataType: 'json',
                  success: function (response) 
                  { 
                    if (response.status == 'True')
                    {
                      snakbarAlert(response.message);
                      //tradetype =1 park and sell
                      if(tradetype==1){ choosePrint()}
                      else{
                           setTimeout(function () {window.location.href = response.Action }, 1500);
                      };
                      
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

        function savedata(printTypes)
        {
            //printTypes 1 = > no ; 2 => yes
          var case_id = $("#customer_id").val();
           $.ajax({
                  type : 'POST',
                  url : "<?php echo base_url(); ?>" + "UsedcarPurchase/printpdf/"+case_id,
                  data : {printTypes:printTypes,'dataType':'json'},
                  dataType: 'json',
                  success: function (response) 
                  { 
                    if (response.status == true)
                    {
                        if(printTypes==2){
                         window.location="<?php echo base_url(); ?>"+"UsedcarPurchase/downloadFile/?file="+response.file_name+"&type="+response.type;
                        }
                     setTimeout(function () {
                      window.location.href =response.Action;
                     }, 2500);
                      return true;
                    }
                  }
            }); 

        }

        function imgtagName(tagid='',imag_id='')
        {
          var case_id = $("#customer_id").val();
          //var personnelDocs = $('#personnelDocs').val();
          
          if(imag_id=='')
          {
            var imag_id = $("#tagId").val();
          }
            
            $.ajax({
              type : 'POST',
              url : base_url+ "UsedcarPurchase/getTagName/",
              data : {tagid:tagid,case_id:case_id,imag_id:imag_id,doctype:'7',doc:'1'},
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
        function checklistdoc()
        {
          $('#upload').attr('style',"display:none");
          $('#tag').attr('style',"display:none");
          $('#checklists').attr('style',"display:block");

             $.ajax({
              type : 'POST',
              url : base_url+ "UsedcarPurchase/getchecklistdoc/",
              data : {case_id:case_id,doctype:'7',doc:'1'},
              dataType : 'html',
              success: function(data)
              {
                $('#checklists').html(data);
              }
            });
        }


</script>



    
