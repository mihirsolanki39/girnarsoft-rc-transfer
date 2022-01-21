                                               <div class="row">
                                                   <div class="col-md-12">
                                                   <form method="post" id="checkForm">
                                                     <div class="table-responsive">
                                                      <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                                        
                                                         <tbody>

                                                         <?php  foreach($uploadDocList as $key => $val ) {
                                                          ?>
                                                             
                                                              <?php 
                                                                          $v= [];
                                                                          if(!empty($val['subList'])){
                                                                           $row= count($val['subList']);
                                                                       
                                                                       ?>
                                                                          <tr>
                                                                 <td rowspan="<?=$row?>" style="width: 20%">
                                                                     <?php echo $val['name'];?>
                                                                 </td>
                                                                 <?php   foreach($val['subList'] as $subkey => $subval){
                                                                 
                                                                  $onclick = '';
                                                                  $recieved = "";
                                                                  if(in_array($subkey, $allsub_id))
                                                                  {
                                                                       
                                                                      $onclick = ' onclick="showpop('.$subkey.');"';
                                                                  }
                                                                  
                                                                  foreach($imageList as $alreadyupload){
                                                                      if($alreadyupload['id'] == $subkey){
                                                                          $recieved = "checked=checked";
                                                                          break;
                                                                      }
                                                                  }

                                                                  ?>
                                                                 <td style="width: 20%">
                                                                     <?php echo $subval['name']?>
                                                                 </td>

                                                                 <td style="width: 20%">
                                                                     <span class="">
                                                                         <input type="radio" name="bk_<?=$subkey?>" id="rec_<?=$subkey?>" value="1" class="trigger" <?=$rec?> <?=$subval['check_status']=='1'?'checked=checked':''?>  <?= $recieved; ?>>
                                                                          <label for="rec_<?=$subkey?>"><span class="dt-yes"></span> Received </label>
                                                                      </span>
                                                                 </td>

                                                                 <td style="width: 20%">
                                                                      <span class="">
                                                                          <input type="radio" name="bk_<?=$subkey?>" id="pen_<?=$subkey?>" value="2" <?=$onclick;?> class="trigger"  <?=$pen?><?=($subval['check_status']=='2' && $recieved == "")?'checked=checked':''?>>
                                                                          <label for="pen_<?=$subkey?>"><span class="dt-yes"></span> Pending </label>
                                                                      </span>
                                                                     
                                                                 </td>

                                                                 <td style="width: 20%">
                                                                     <span class="">
                                                                          <input type="radio" name="bk_<?=$subkey?>" id="na_<?=$subkey?>" value="3" <?=$subval['check_status']=='3'?'checked=checked':''?> class="trigger" <?=$onclick;?> <?=$na?>>
                                                                          <label for="na_<?=$subkey?>"><span class="dt-yes"></span> Not Applicable </label>
                                                                      </span>
                                                                 </td>
                                                                  </tr>
                                                                 <? } }?>
                                                            
                                                             <? } ?>                                                           
                                                         </tbody>
                                                        </table>
                                                  </div>
                                                   <input type="hidden" name="checklistform" value="1" id="checklistform">
                                                  </form>
                                                   </div>
                                              </div>


      <div class="modal fade" id="checkliststatus" role="dialog">
         <div class="modal-dialog">
           
            <div class="modal-content">
               <div class="modal-header modal-header-custom">
                  <button type="button" class="close closee" data-dismiss="modal"><img src="<?=base_url()?>assets/images/close-model.svg" alt=""></button>
                  <div class="row">
                     <div class="col-md-9 clearfix">
                        <h4 class="modal-title" id="headerdiv" align="center">  Confirmation!</h4>
                     </div>
                  </div>
               </div>
               <div class="modal-body">
                        <div class="modal-body text-center" id="bodysdiv"> You have tagged this document. Are you sure you want to remove tag and change status.</div>
                     </div>
                     <div class="modal-footer">
                         <input type="hidden" name="tgid" id="tgid" value="">
                          <button type="button" class="btn btn-default stocksms_cancel " data-dismiss="modal" onclick="return removeChecklist();" id="yes">Yes</button>
                         <button type="button" class="btn btn-primary closee" id="no"  name="ins_ok">No</button>                
                     </div>
            </div>

         </div>
      </div>
<script type="text/javascript">

function showpop(tag_id)
{
  $('#tgid').val('');
  $('#checkliststatus').addClass(' in');
  $('#checkliststatus').attr('style','display:block');
  $('#tgid').val(tag_id);

}
  function removeChecklist()
  {
    var case_id = "<?=$car_id?>";
    var tag_id = $('#tgid').val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedcarPurchase/loanTagMapping/",
              data : {tag_id:tag_id,customer_id:customer_id,type:'remove',case_id:case_id,doc:'1',flag:'1'},
              dataType: 'json',
              success: function (response) { 
                if(response.status)
                { 
                  $('#tgid').val('');
                  $('#checkliststatus').removeClass(' in');
                  $('#checkliststatus').attr('style','display:none');   
                }
                else
                {
                  alert(response.msg);
                  //$('.next').trigger('click');
                }

              }
              });
  }

  $('.closee').click(function(){
    $('#tgid').val('');
    $('#checkliststatus').removeClass(' in');
    $('#checkliststatus').attr('style','display:none');
   // $('#tgid').val(tag_id);
  });

  <?php if(!empty($checklist)){ ?>
    var checkedChecklist = <?php echo json_encode($checklist);?>;
    $(checkedChecklist).each(function(index,val){
      if(val.status == 1){
        $("#rec_"+val.tag_id).prop('checked',true);  
      }
      else if(val.status == 3){
        $("#na_"+val.tag_id).prop('checked',true);  
      }
    });
<?php } ?>
</script>