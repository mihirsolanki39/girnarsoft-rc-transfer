  
  <form id="forms">
  <div class="row">
            <div class="col-md-12">
                <h4 class="page-head">Set Permission</h4>
                <div class="whte-strip whtStrpTable">
                   
                    Insurance Documents
                
                </div>
  <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                     <tbody>
                                     <?php foreach($uploadDocList as $dockey => $docval){
                                     //echo "<pre>";
                                      //print_r($docval); 
                                      $uncheck = 0;
                                             if($docval['substatus'] == '0' && $docval['subisrequire'] == '0'){
                                                $uncheck  = 1; 
                                             }
                                            // echo "pp".$uncheck;
                                             $row= count($docval['subList']);
                                      ?>
                                         <tr>
                                            <td style="width: 20% " rowspan="<?=$row?>">
                                                <input onclick="onOffCategory(<?=$dockey?>)" type="checkbox" id="carPremium_<?=$dockey?>" name="onoff_<?=$dockey?>" <?= ($uncheck == 0)?'checked="checked"':'' ?>>
                                                <label for="carPremium_<?=$dockey?>"><span></span>
                                                <?=$docval['name']?></label>    
                                             </td>
                                             <?php 
                                             foreach($docval['subList'] as $subkey => $subval){?>
                                            <td style="width: 20%"><?=$subval['name']?></td>

                                             <td style="width: 20% <?= ($uncheck == 0)?';pointer-events: inline !important;"':';pointer-events: none !important;opacity: 0.5"' ?>" class="onoff_<?=$dockey?>">
                                                 <span class="">
                                                     <input type="radio" name="bk_<?=$subkey?>" id="rec_<?=$subkey?>" value="1" class="trigger aa_<?=$dockey?>" <?=(($subval['status'] == '0' && $uncheck == 0)?'checked="checked"':'')?> onclick="chnages();">
                                                      <label for="rec_<?=$subkey?>"><span class="dt-yes"></span> Not Required </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20% <?= ($uncheck == 0)?';pointer-events: inline !important;"':';pointer-events: none !important;opacity: 0.5"' ?>" class="onoff_<?=$dockey?>">
                                                  <span class="">
                                                      <input type="radio" name="bk_<?=$subkey?>" id="pen_<?=$subkey?>" value="2" class="trigger aa_<?=$dockey?>" <?=(($uncheck == 0 &&($subval['is_require']=='0') && ($subval['status']=='1')) ?'checked="checked"':'')?> onclick="chnages();" >
                                                      <label for="pen_<?=$subkey?>"><span class="dt-yes"></span> Optional </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20% <?= ($uncheck == 0)?';pointer-events: inline !important;"':';pointer-events: none !important;opacity: 0.5"' ?>" class="onoff_<?=$dockey?>">
                                                 <span class="">
                                                      <input type="radio" name="bk_<?=$subkey?>" id="na_<?=$subkey?>" value="3" class="trigger aa_<?=$dockey?>" <?=(( $uncheck == 0 && ($subval['is_require']=='1') && ($subval['status']=='1'))?'checked="checked"':'')?> onclick="chnages();">
                                                      <label for="na_<?=$subkey?>"><span class="dt-yes"></span> Mandatory </label>
                                                  </span>
                                             </td>
                                             <input type="hidden" name="prntid_<?=$dockey?>" id="prntid_<?=$dockey?>" value="1">
                                              </tr> 
                                             <? } ?>
                                           
                                            <? } ?>                                   
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="doctype" id="docty" value="<?=$doctype?>">
                                    <input type="hidden" name="ins_type" id="ins_type" value="<?=$ins_type?>">
                                     <div class="col-md-12">
                                        <div class="btn-sec-width">
                                        <input type="hidden" name="doct" value="1" id="doct">
                                         <input type="hidden" name="cngs" value="0" id="cngs">
                                        <button type="button" class="btn-continue saveCont" style="display:block" id="personalDetails">SAVE AND CONTINUE</button>
                                        </div>
                                    </div>
                                    </form>
                              </div>
<script type="text/javascript">
/*function tabpages(doctype,instype)
        {
             $('#newcar').html('');
             $('#usedcar').html('');
             $('#renewal').html('');
             $('#policyexpired').html('');
             $('#policyexpired2').html('');
            $.ajax({
              type: 'POST',
              url: "<?php echo base_url(); ?>" +"Docmanager/getDocInfo",
              data: {doctype: doctype,instype:instype,flag:'1'},
              dataType: "html",
              success: function (responseData)
              {
               // alert(responseData);
                  if(instype=='1')
                  {
                    $('#newcar').html(responseData);
                    $('#doct').val('1');
                  }
                  if(instype=='2')
                  {
                    $('#usedcar').html(responseData);
                    $('#doct').val('2');
                  }
                  if(instype=='3')
                  {
                    $('#renewal').html(responseData);
                    $('#doct').val('3');
                  }
                  if(instype=='4')
                  {
                    $('#policyexpired').html(responseData);
                    $('#doct').val('4');
                  }
                  if(instype=='5')
                  {
                    $('#policyexpired2').html(responseData);
                    $('#doct').val('5');
                  }
              }
            });
        }*/
        function onOffCategory(id)
          {
           // alert(id);
            var abe = $('input:checkbox[name=onoff_'+id+']').is(':checked');
            if(abe==true)
            {
              $("td.onoff_"+id).attr('style',"pointer-events: inline !important;");
              $("#prntid_"+id).val('1');
              $('.aa_'+id). prop("checked", true);
            }
            else
            {
               $("td.onoff_"+id).attr('style',"pointer-events: none  !important;opacity: 0.5 !important;");
               $("#prntid_"+id).val('0');
               $('.aa_'+id). prop("checked", false);
            }
            $('#cngs').val('1');
          }
        $('.saveCont').click(function(){
             var formData=$('#forms').serialize();
             var doctype = $("#docty").val();
             var instype = $("#ins_type").val();
             $.ajax({
              type: 'POST',
              url: "<?php echo base_url(); ?>" +"Docmanager/saveDocsInfo",
              data: formData,
              async:false,
              dataType: "html",
              success: function (responseData)
              {
                snakbarAlert('Updates Save Successfully.'); 
                $('#cngs').val('0');
                if(instype=='1')
                {
                  var page = '7';
                }
                if(instype=='2')
                {
                  var page = '8';
                }
                if(instype=='3')
                {
                  var page = '9';
                }
                if(instype=='4')
                {
                  var page = '10';
                }
                if(instype=='5')
                {
                  var page = '11';
                }
               getdocpage(page);
              }
            });
        });

        function chnages()
        {
          $('#cngs').val('1');
        }
        </script>