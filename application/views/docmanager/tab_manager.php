 <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                     <tbody>
                                         <?php foreach($uploadDocList as $doc => $subdoc){?>
                                         <tr>
                                            <td style="width: 20%">
                                                <input onclick="" type="checkbox" id="car-Premium" name="ispremium">
                                                <label for="car-Premium"><span></span>
                                                <?php echo $subdoc['name'];?></label>    
                                             </td>
                                             <?php foreach($subdoc['subList'] as $subkey => $subval){?>
                                            <td style="width: 20%"><?=$subval['name']?></td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_<?=$subkey?>" id="rec_<?=$subkey?>" value="1" class="trigger">
                                                      <label for="rec_<?=$subkey?>"><span class="dt-yes"></span> Not Required </label>
                                                  </span>
                                             </td>
                                             <td style="width: 20%">
                                                  <span class="">
                                                      <input type="radio" name="bk_<?=$subkey?>" id="pen_<?=$subkey?>" value="2" class="trigger">
                                                      <label for="pen_<?=$subkey?>"><span class="dt-yes"></span> Optional </label>
                                                  </span>
                                             </td>

                                             <td style="width: 20%">
                                                 <span class="">
                                                      <input type="radio" name="bk_<?=$subkey?>" id="na_<?=$subkey?>" value="3" class="trigger">
                                                      <label for="na_<?=$subkey?>"><span class="dt-yes"></span> Mandatory </label>
                                                  </span>
                                             </td>
                                             <?php } ?>
                                            </tr>
                                        
                                         <?php } ?>
                                         
                                        </tbody>
                                    </table>
                              </div>