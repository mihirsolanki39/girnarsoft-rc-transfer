<?php //echo '<pre>';print_r($stock_list); die;?>
<div class="background-ef-tab mrg-T20" id="loandetails">
    <div class="tabs loandetails">
        <div class="row pad-all-20">
            <div class="col-md-6">
              <!--<h5 class="cases"> <span id="refcase"> Stock </span> Cases (<span id="totcase">13</span>)</h5>-->
                <div class="row">
                    <form id="key_form">
                    <div class="col-md-3 mrg-T10">Keys in Showroom</div>
                    <div class="col-md-1 pad-R0 pad-L0"><input class="form-control only-number" type="text"  maxlength="3" id='in_showroom' value="<?=isset($keys['keys_in'])?$keys['keys_in']:0?>" name="in_showroom"></div>
                    <div class="col-md-2 pad-R0 mrg-T10">Keys in Office</div>
                    <div class="col-md-1 pad-R0 pad-L0 mrg-L15"><input class="form-control only-number" type="text"  value="<?=isset($keys['keys_out'])?$keys['keys_out']:0?>" maxlength="3" id="in_office" name="in_office"></div>
                    </form>
                </div>
            </div>
            <div class="col-md-6"><button class="btn-success pull-right" data-toggle="modal" data-target="#add_stock">ADD STOCK</button></div>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                <div class="container-fluid ">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="table-responsive">
                                    <form id="tally_data" name ='tally_data'>
                                    <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                        <thead>
                                            <tr>
                                                <th width="5%">Sr.No.</th>
                                                <th width="55%">Car Details</th>
                                                <th width="45%">Status</th>
                                            </tr>
                                        </thead>
                                        <?php if(!empty($stock_list) && ((date('d-m-Y')==$filter_date) || (date('d-m-Y')!=$filter_date  &&  !empty($keys)))){ ?>
                                        
                                        <tbody>
                                            <?php $i=1;$j=0;$refurb_count=0;$delivered_count=0;$in_count=$out_count=$other_count=$removed_count=0;
                                            foreach($stock_list as $list){
                                                  if(empty($keys) && $filter_date==date('d-m-Y')){
                                                  $list['tally_status']= isset($_COOKIE['tally_status_'.$list['id']])?$_COOKIE['tally_status_'.$list['id']]:1;
                                                  $list['assigned_to'] = isset($_COOKIE['other_text_'.$list['id']])?$_COOKIE['other_text_'.$list['id']]:'';
                                                  }
                                                  $tally_status=isset($list['tally_status'])? $list['tally_status']:''
                                                ?>
                                            <tr>
                                                <td><?=$i++?></td>
                                                <td>
                                                    <div class="mrg-B5"><b><?=$list['make'].' '.$list['model'].' '.$list['version']?></b>  </div>
                                                    <div class="font-13 text-gray-customer">
                                                        <span class="font-14">Reg No <?=$list['reg_no']?> | <span class="dot-sep"></span><?=$list['make_year']?> Model</span>
                                                    </div>
                                                </td>
                                                <td>
                                                  
<!--                                                    <div class="col-md-6 assigned-tag" style="display:none">
                                                        <input type="text" class="form-control" id='assigned_to_<?=$list['id']?>' name="tally_status[<?=$j?>][assigned_to]">
                                                    </div>-->
                                            <?php if($list['car_status']==1 || $list['car_status']==4 || $list['car_status']==2 || isset($list['temp_stock'])){?>
                                                    <div class="col-md-6 tally-status-select">
                                                        <select class="form-control testselect1 tally_status" id="tally_status_<?=$list['id']?>" name="tally_status[<?=$j?>][status]" <?= date('d-m-Y')!=$filter_date?'disabled':'' ?> >
                                                            <option value="1" <?=isset($list['tally_status']) && $list['tally_status']==1?'selected':'' ?>>In</option>
                                                            <option value="2" <?=isset($list['tally_status']) && $list['tally_status']==2?'selected':'' ?>>Out</option>
                                                            <option value="3" <?=isset($list['tally_status']) && $list['tally_status']==3?'selected':'' ?> >Other</option>
                                                            <?php if(isset($list['temp_stock'])){ ?>
                                                            <option value="5" <?=isset($list['tally_status']) && $list['tally_status']==5?'selected':'' ?>>Delivered</option>
                                                            <option value="6" <?=isset($list['tally_status']) && $list['tally_status']==6?'selected':'' ?> >Removed</option>  
                                                           <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 assigned-tag" style="<?=isset($list['tally_status']) && $list['tally_status']==3?'display:block':'display:none' ?>">
                                                        <input type="text" class="form-control assigned-to" id="other_text_<?=$list['id']?>" name="tally_status[<?=$j?>][assigned_to]" value="<?=isset($list['assigned_to'])?$list['assigned_to']:''?>">
                                                    </div>
                                                    <?php }
                                                       if($list['car_status']==6 && !isset($list['temp_stock'])){ $refurb_count++; echo 'Refurb - '.$list['refb_workshop_name']; ?>
                                                    <input type="hidden" class="form-control" id="tally_status_<?=$list['id']?>" name="tally_status[<?=$j?>][status]" value="4">
                                                    <input type="hidden" class="form-control" id='assigned_to_<?=$list['id']?>' name="tally_status[<?=$j?>][assigned_to]" value='<?=$list['refb_workshop_name']?>'>
                                                      <?php }
                                                       elseif($list['car_status']==3 && !isset($list['temp_stock'])){ $delivered_count++; echo 'Delivered';?>
                                                     <input type="hidden" class="form-control" id="tally_status_<?=$list['id']?>" name="tally_status[<?=$j?>][status]" value="5">
                                                     <input type="hidden" class="form-control" id='assigned_to_<?=$list['id']?>' name="tally_status[<?=$j?>][assigned_to]" value=''>
                                                    <?php }
                                                    ?>
                                                    <input type="hidden" class="form-control" id='id_<?=$list['id']?>' name="tally_status[<?=$j?>][stock]" value="<?=$list['id']?>">
                                                    <!--<input type="hidden" class="form-control" id='id_<?=$list['id']?>' name="tally_status[<?=$j?>][tem_stock]" value="<?=$list['id']?>">-->
                                                </td>
                                            </tr>
                                            <?php $j++;
                                            
                                            if(isset($list['tally_status']) && $list['tally_status']==1){
                                                //$in_count++;
                                            }
                                            elseif(isset($list['tally_status']) && $list['tally_status']==2){
                                                //$out_count++;
                                            }
                                            elseif(isset($list['tally_status']) && $list['tally_status']==3){
                                                //$other_count++;
                                            }
                                            elseif(isset($list['tally_status']) && $list['tally_status']==6){
                                                $removed_count++;
                                            }
                                            elseif(isset($list['tally_status']) && isset($list['temp_stock']) && $list['tally_status']==5){
                                               // $delivered_count++;
                                            }
                                            
                                            } ?>
                                        </tbody>
                                        <?php } else{ ?>
                                        <tbody>
                                            <tr><td colspan="3" style="text-align: center"> No Record Exists on <?=$filter_date?> </td></tr>
                                        </tbody>
                                            
                                       <?php }?>
                                    </table>
                                    </form>
                                </div>
                                <?php if(!empty($stock_list)){?>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <style type="text/css">
                                                #statusUL li{ padding: 0; margin: 0; list-style: none; display: inline-block;margin-right: 30px; padding-bottom: 30px; margin-top: 10px;}
                                            </style>
                                            <?php $total_count= $in_count+$out_count+$refurb_count+$delivered_count+$other_count+$removed_count ?>
                                            <ul id="statusUL">
                                                <li>IN : <span id='in_count'><?=$in_count?></span></li>
                                                <li>OUT : <span id='out_count'><?=$out_count?></span></li>
                                                <li>REFURB : <span id='refurb_count'><?=$refurb_count?></span></li>
                                                <li>DELIVERED : <span id='delivered_count'><?=$delivered_count?></span></li>
                                                <li>REMOVED : <span id='removed_count'><?=$removed_count?></span></li>
                                                <li>OTHER : <span id='other_count'><?=$other_count?></span></li>
                                                <li>TOTAL : <span id='total_count'><?=$total_count?></span></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="pull-right">
                                                <?php if(date('d-m-Y')==$filter_date && empty($search_by) && empty($status)){?><a class="btn-save btn-save-new mrg-T0 saveTallyList" >SAVE</a><?php } ?>
                                                <?php if(!empty($keys)) { ?><a class="mrg-L10 used__car-reset-btn download_pdf">DOWNLOAD</a> <?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="row">
            <div class="col-lg-12 col-md-12 text-center">
               <nav aria-label="Page navigation">
                  <ul class="pagination customePagination">
                    <li class="page-item active"><a class="page-link">1</a></li><li style="cursor: pointer;" class="page-item" onclick="pagination(2);"><a class="page-link">2</a></li><li style="cursor: pointer;" class="page-item" onclick="pagination(2);"><a class="page-link" aria-label="Next"><span aria-hidden="true"><img src="http://localhost/girnarsoft-dealer-crm/assets/admin_assets/images/pagination-right.png"></span>
                              <span class="sr-only">Next</span></a></li>              </ul>
               </nav>
            </div>
          </div>-->
    </div>
</div>
<!-- Modal -->
<div id="add_stock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Stock</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <form id="add_stock_form">
                <div class="col-md-6 pad-T10">
                    <label for="" class="crm-label">Make Year</label>
                    <select class="form-control testselect1 "  name="make_year" id="make_year" >
                        <option value="0">Select Make Year</option>
                        <?php 
                        $currentYear = date('Y'); 
                        for ($i = $currentYear; $i >= 1985; $i--){ ?> 
                        <option class="form-control testselect1" value="<?= $i ?>" ><?= $i ?></option> 
                       <?php } ?>   
                    </select>
                </div>
                <div class="col-md-6 pad-T10">
                    <label for="" class="crm-label">Make Model</label>
                    <select class="form-control testselect1 " id="make_model" name="make_model" >
                        <option value="0">Select Make Model</option>
                        <?php foreach($mmList as $make_model){ ?>
                        <option value="<?=$make_model['make_id'].'_'.$make_model['model_id']?>"><?=$make_model['make'].' '.$make_model['model']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 pad-T10">
                    <label for="" class="crm-label">Version</label>
                    <div id="version_list">
                    <select class="form-control testselect1 "  name="version" id="version_id" >
                        <option value="0">Select Version</option>
                    </select>
                    </div>
                </div>
                <div class="col-md-6 pad-T10">
                    <label for="" class="crm-label">Reg. No.</label>
                    <input class="form-control" style="text-transform: uppercase;" type="text"  value="" name="reg_no" maxlength="11" placeholder="Ex. DL 3C 1 4526">
                </div>
           </form>
               
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-save btn-save-new" id="add_new_stock">Save</button>
      </div>
    </div>

  </div>
</div>

<script>
     $('.only-number').keypress(function(event){
        //console.log(event.target.className);
      return isNumberKey(event);
    });
    $('.assigned-to').blur(function(){
        setCookie(this.id,this.value)
    });
    $('#make_model').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
    $('#version_id').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
    
</script>