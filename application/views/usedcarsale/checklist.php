<div class="row">
    <div class="col-md-12">
        <form method="post" id="checklistForm">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover enquiry-table mytbl">

                    <tbody>

                        <?php foreach ($uploadDocList as $key => $val)
                        {
                            ?>

                            <?php
                            $v = [];
                            if (!empty($val['subList']))
                            {
                                $row = count($val['subList']);
                                ?>
                                <tr>
                                    <td rowspan="<?= $row ?>" style="width: 20%">
                                    <?php echo $val['name']; ?>
                                    </td>
                                    <?php
                                    foreach ($val['subList'] as $subkey => $subval)
                                    {
                                        //$pen = 'checked="checked"';
                                        $rec = '';
                                        $na  = '';
                                        $onclick='';
                                        if (in_array($subkey, $allsub_id))
                                        {
                                            //$rec = 'checked="checked"';
                                            //$pen = '';
                                            //$na  = '';
                                            $onclick = ' onclick="showpop('.$subkey.',this);"';
                                        }
                                        ?>
                                        <td style="width: 20%">
            <?php echo $subval['name'] ?>
                                        </td>

                                        <td style="width: 20%">
                                            <span class="">
                                                <input type="radio" name="bk_<?= $subkey ?>" <?=$subval['check_status']=='1'?'checked=checked':''?> id="rec_<?= $subkey ?>" value="1" class="trigger" <?= $rec ?>>
                                                <label for="rec_<?= $subkey ?>"><span class="dt-yes"></span> Received </label>
                                            </span>
                                        </td>

                                        <td style="width: 20%">
                                            <span class="">
                                                <input type="radio" name="bk_<?= $subkey ?>" <?=$onclick;?>  <?=$subval['check_status']=='2' || empty($subval['check_status'])?'checked=checked':''?> id="pen_<?= $subkey ?>" value="2" class="trigger"  <?= $pen ?>>
                                                <label for="pen_<?= $subkey ?>"><span class="dt-yes"></span> Pending </label>
                                            </span>

                                        </td>

                                        <td style="width: 20%">
                                            <span class="">
                                                <input type="radio" name="bk_<?= $subkey ?>"  <?=$onclick;?> <?=$subval['check_status']=='3'?'checked=checked':''?> id="na_<?= $subkey ?>" value="3" class="trigger" <?= $na ?>>
                                                <label for="na_<?= $subkey ?>"><span class="dt-yes"></span> Not Applicable </label>
                                </span>
                            </td>
                        </tr>
                        <?php } }?>

                        <?php } ?>                                                           
                    </tbody>
                </table>
            </div>
            <input name="case_id"  type="hidden" value="<?=$case_id?>" >
             <input name="doc_type" type="hidden" value="<?=$doc_type?>" >
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
                         <input type="hidden" name="tag_status" id="tag_status" value="">
                          <button type="button" class="btn btn-default stocksms_cancel " data-dismiss="modal" onclick="return removeChecklist();" id="yes">Yes</button>
                         <button type="button" class="btn btn-primary closee" id="no"  name="ins_ok">No</button>                
                     </div>
            </div>

         </div>
      </div>
<script>
//    $('input[type="radio"]').click(function(){
//        alert();
//        return false;
//    });
function showpop(tag_id,ref)
{
  $('#tgid').val('');
  $('#checkliststatus').addClass(' in');
  $('#checkliststatus').attr('style','display:block');
  $('#tgid').val(tag_id);
  $('#tag_status').val(ref.value);
  return true;
}
  function removeChecklist()
  {
    var case_id = "<?=$case_id?>";
    var tag_status = $('#tag_status').val();
    var tag_id = $('#tgid').val();
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "UsedCarSale/loanTagMapping/",
              data : {taggID:tag_id,customer_id:'',type:'remove',case_id:case_id,flag:'1',tag_status:tag_status},
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
</script>