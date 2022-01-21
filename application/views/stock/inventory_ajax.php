<style>
    .dropdown-toggle:hover { border-bottom: 1px solid #e47d3c !important;}
    .more-opt:focus{border: 1px solid #e47d3c !important;}
    .accepted{ width: 100%; display: inline-block;  background: #e2ffda;border: 1px solid #1e89003d;color: #1e8900;}
    .tags-images {top: 10px;}
    .max-selling-price{color: #444444; margin-bottom: 5px;z-index: 1000;}
    .er-incom{font-size: 16px;  color: #f9bb01; line-height: 24px;  vertical-align: -webkit-baseline-middle;}
    .col-g{font-size: 20px;margin-left: 15px; color: #999; line-height: 20px}
    #maincontainer .stockmanager-new .badge { background: none;color: inherit;font-size: 14px;line-height: 12px; vertical-align: middle;}
    .price-edit .input-group{display: flex; line-height: 36px;}
                            
</style>
<?php
//echo '<pre>';print_r($stockData);die;
if (!empty($stockData)) {

    foreach ($stockData as $key => $datas) {
        $accessLevel = $datas['accessLevel'];
        ?>
        <div id="dynamiclist">
            <ul class="list-unstyled car-list" id="mydynamic_ul">
                <li id="inventory_list_<?= $datas['id'] ?>" class="pageno1 invnty2">
                    <div class="clearfix " style="position:relative;">
                        <div class="col-md-2 col-custom-sls" onclick="viewImgListStock('<?= $datas['id']; ?>', '<?= base64_encode(DEALER_ID . '_' . $datas['case_id']) ?>', '<?= $datas['imageCount'] ?>', 0, 0)">
        <!--                    <a name="<?= $datas['id']; ?>"  id="img_<?= $datas['id'] ?>" href="javascript:void(0);">-->
                            <div class="img-box clearfix" style="cursor: pointer">
                                <?php $imageCount = ''; ?>
                                <?php if ($datas['ispremium'] == '1') { ?>
                                    <span style="position: absolute;top: 0px; left:10px;z-index: 1;"><img src="<?php echo base_url() ?>assets/admin_assets/images/featured-logo.png" ></span>
                                <?php } ?>
                                <?php
                                $countimgload = 1;
                                $allowUploadImage = ($datas['imageCount'] < 1 && $accessLevel == 1) ? 'none' : 'block';
                                if (!empty(trim($datas['profileimage']))) {
                                    $arr = explode('/',$datas['profileimage']);
                                    $imgNmi = count($arr)-1;
                                    $imgNm = 'https://images10.gaadicdn.com/usedcar_image/medium_srp/'.$arr[$imgNmi];

//                         if($countimgload<=4){
//                                $imageSource='<img onclick="$(this).parent().parent().siblings(\'.editpic\').find(\'a\').click();" src="'.$datas['profileimage'].'"class="img-responsive">';
//                                $countimgload++;
//                                 } else {
                                    //$imageSource = '<img  src="' . $datas['profileimage'] . '"class="img-responsive">';
                                    $imageSource = '<img  src="' . $imgNm . '"class="img-responsive">';
                                    //}
                                    $imageCount = '<span class="totalpic">' . $datas['imageCount'] . ' Photo</span>';
                                    $photoText = 'View Photos';
                                } else {
                                    $onClick = "";
//              if($accessLevel==1){
//                                   $onClick="void(0)"; 
//                                }
                                    $imageSource = '<img onclick="' . $onClick . '" src="' . base_url() . 'assets/admin_assets/images/noimage.jpg" class="img-responsive">';
                                    $photoText = 'Click to upload';
                                    ?>
                                <?php } ?>
                                <a href="javascript:void(0);">
                                    <div class="img_thumb"><?php echo $imageSource; ?></div></a>
                                <?php echo $imageCount; ?>
                                <span style="display:block" id="view_img_<?= $datas['id']; ?>" class="editpic" data-toggle="modal"  >
                                    <?php //echo $photoText;?>
                                </span>
                                <?php if (!empty($datas['CStatus'])) { ?>
                                    <div class="trustmark-sm"><img src="<?= base_url() ?>assets/admin_assets/images/trustmark-sm.svg"></div>
                                <?php } ?>
                            </div>
                            <!--                        </a>-->
                        </div>
                        <div class="col-md-10 col-custom-sll">
                            
                            <div class="row">
                                <div class="col-sm-6 col-md-8">
                                    <h2 class="carname">
                                        <a target="_blank" href="<?php echo base_url() . 'cardetails/' . base64_encode(DEALER_ID . '_' . $datas['case_id']); ?>"><?= $datas['make']; ?> <?= $datas['model']; ?> <?= $datas['carversion']; ?></a>
                                        <span class="small editretail"data-toggle="tooltip" title="Purchase Details Are Incomplete" >
                                            <?php if (!$datas['isPurCompleted']) { ?><i style="cursor:default !important;" class="fa fa-exclamation-triangle er-incom" ></i><?php } ?>
                                        </span>

                                    </h2>
                                    <div class="clearfix price-edit">
                                        <div class="retailprice pricetag"  style="height: 44px" ><span id="show_retail_price_<?= $datas['id']; ?>" class="font-20 stock-price-n">
                                                <i class="fa fa-inr"></i> <?= priceFormatShortVersion($datas['price']) ?></span>
                                            <?php if (!in_array($datas['active'], [2, 3, 4, 6])) { ?>   
                                                <span class="small editretail">&nbsp;&nbsp;&nbsp;<a onclick="$(this).parent().parent().hide();$(this).parent().parent().next().show();" class="btn-edit" id="<?= $datas['id']; ?>" href="javascript:void(0);">Edit</a></span>
                                            <?php } ?>
                                        </div>
                                        <div class="edit-retailprice editretalPriceDiv_<?= $datas['id']; ?>"  style="height: 44px" >
                                            <div class="input-group">
                                                <input type="text" onkeypress="return forceNumber(event);" id="edit_retail_price_<?= $datas['id']; ?>" name="<?= $datas['id']; ?>" value="<?= $datas['price']; ?>" style="width: 140p; height: 34px" maxlength="8" class="form-control text-primary font-13">
                                                <span class="input-group-addon edit-price-span">
                                                    <img class="countloaderprice" style="position:absolute;right:20px;top:6px;width:16px;display:none;" src="<?php echo base_url(); ?>assets/images/loader.gif">
                                                </span>
                                                <span class="small editretail" >
                                                    <a class="btn-edit" onclick="saveRetailPrice('<?= $datas['id']; ?>');" href="javascript:void(0);">Save</a>
                                                </span>
                                                <span class="" onclick="$(this).parents('.price-edit').find('.pricetag').show();$(this).parents('.edit-retailprice').hide();"><a href="javascript:void(0)">Close</a></span>
                                            </div>

                                        </div>


                                    </div>
                                    <?php  if(($_SESSION['userinfo']['role_id']==25 || $_SESSION['userinfo']['is_admin'] == 1) && ($datas['tradetype'] == '1')){  ?>
                                    <div class="max-selling-price">Expected Selling Price <i class="fa fa-inr mrg-L10"></i><?= priceFormatShortVersion($datas['expected_price']) ?></div>
                                    <?php } 
                                           if(($_SESSION['userinfo']['role_id']==25 || $_SESSION['userinfo']['is_admin'] == 1) && ($datas['tradetype'] != '1')) {?>
                                    <style>.popover{z-index: 999; display: block}</style>
                                    <div class="max-selling-price" style="position:relative">Min Selling Price (Automatic)<i class="fa fa-inr mrg-L10"></i>
                                              <?= priceFormatShortVersion((int)$datas['msp']) ?>
                                        <a tabindex="0"
   class="" 
   role="button" 
   data-html="true" 
   data-toggle="popover" 
   data-trigger="hover" 
   title="Min Selling Price Breakup" 
   data-content="<div>Actual Purchase Price: Rs <?= indian_currency_form((int)$datas['purchase_cost']) ?></div><div>Refurb Cost: Rs <?= indian_currency_form((int)$datas['refurb_cost']) ?></div>
                                        <div>Inventory holding Cost: Rs <?= indian_currency_form((int)$datas['inv_holding_cost']) ?></div>
                                        <div>Profit (<?=$datas['pp']?>%) : Rs <?= indian_currency_form((int)$datas['profit']) ?></div>
                                        <div>Total : Rs <?= indian_currency_form((int)$datas['msp']) ?></div>" aria-describedby="popover"><i class="fa fa-info-circle font-18 mrg-L10" aria-hidden="true" data-trigger="" data-container=""  data-placement="bottom" 
                                                                                                                  check box unchecked data-original-title="" title=""></i></a>
                                    </div>
                                    
                                    <?php } if($_SESSION['userinfo']['is_admin'] == 1 || $_SESSION['userinfo']['role_id']==23 || $_SESSION['userinfo']['role_id']==24 || $_SESSION['userinfo']['role_id']==23){ ?>
                                    <div class="min-sell-price">Min Selling Price (Manual)  :  <i class="fa fa-inr"></i> <?= priceFormatShortVersion((int)$datas['min_selling_price']) ?> </div>
                                    <?php } ?>
                                    <div class="mrg-B10">
                                        <span class="small"><?= $datas['regplace']; ?></span>
                                        <span class="small text-muted mrg-L10">Listed on:<?= $datas['listedon']; ?></span>
                                        <span class="small text-muted mrg-L10">|</span>
                                        <span class="small text-muted mrg-L10">Stock Age: <?= (!empty($datas['ageofstock'])?$datas['ageofstock']:'0 day(s)');?> </span>


                                        <?php if (!empty($datas['CStatus'])) { ?>
                                            <span class="small text-muted mrg-L10">|</span><span class="small text-muted mrg-L10">Inspection Status: <?= $datas['CStatus']; ?> </span> 
                                        <?php } ?>
                                    </div>
                                    <div class="car-specs">
                                        <div class=" row">                                      
                                            <div class="col-xs-6 col-sm-6  col-md-4 col-lg-2 small">
                                                <div class="font-14" id="myear_5000220"><?= indian_currency_form($datas['km']); ?></div>
                                                <div class="font-stk"> KM</div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 small">
                                                <div class="font-14" id="myear_5000220"><?= $datas['myear']; ?></div>
                                                <div class="font-stk">Mfg Year</div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 small">
                                                <div class="font-14" id="myear_5000220"><?= $datas['fuel']; ?></div>
                                                <div class="font-stk"> Fuel Type</div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 small">
                                                <div class="font-14" id="myear_5000220"><?= $datas['transmission']; ?></div>
                                                <div class="font-stk"> Transmission</div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 small pad-L0">
                                                <div class="font-14" id="myear_5000220"><?= $datas['owner']; ?></div>
                                                <div class="font-stk"> Owner</div>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 small pad-R0 pad-L0">
                                                <div class="font-14" id="myear_5000220"><?= $datas['reg_no']; ?></div>
                                                <div class="font-stk"> Reg No.</div>
                                            </div> 
                                            <!--<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 small">
                                                <div class="font-14" id="myear_5000220"><?= $datas['colour']; ?></div>
                                                <div class="font-stk"> Colors</div>
                                                
                                        </div>-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="clearfix col-md-12 actionbtns mrg-T10 action-tabs">
                                        <!--<div class="btn-group btn-group-sm "role="group"><a data-original-title="Edit" title="Edit" href="javascript:void(0);"onclick="window.location='add_inventories.php?car_id=5000219';"class="edit_track mrg-R15" ><span class="sprite icon-edit"></span></a><span class="btn-group btn-group-sm mark_as_sold_track mrg-R15"data-remotee="http://abha.gaadi.com/user/ajax/addremove_used_car_sold_new.php?car_id=5000219&amp;type=sold&amp;certification_id=0&remaining_renew_no=&gaadi_id=5000223&r_new=yes&renew_sku_status=0&renew_exhausted=-2"role="group"data-toggle="modal"data-target="#model-mark_as_Sold" title="Mark as Sold"><a href="#"title="Mark as Sold"class=""><span data-original-title="Add to Stock"data-toggle="tooltip"data-placement="top"title="Remove"class="sprite icon-delete"></span></a></span></div>-->
                                            <!-- <div class="btn-group btn-group-sm" data-toggle="modal" data-target="#model-mark_as_Renew">
                                                 <a href="javascript:void(0)" title="Renew" renewtitle="1" renew_exhausted="-2" renew_sku_status="0" class="btn btn-default">Renew </a>
                                             </div>-->

                                            <?php
                                            if (!in_array($datas['active'], [2, 3, 4])) {
                                                if ($datas['ispremium'] == '0') {
                                                    ?>
                                                    <div class="btn-group btn-group-sm make_premium_track" role="group"  onclick="viewPremiumData('<?= $datas['id']; ?>', 'Add','<?= $datas['case_id']; ?>')" data-toggle="modal">
                                                        <a href="javascript:void(0)" title="Mark Featured" class="btn btn-default">MAKE FEATURED</a>
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="btn-group btn-group-sm make_premium_track" role="group"  onclick="viewPremiumData('<?= $datas['id']; ?>', 'Remove','<?= $datas['case_id']; ?>')" data-toggle="modal">
                                                        <a href="javascript:void(0)" title="Unmark Featured" class="btn btn-default">UNMAKE FEATURED</a>
                                                    </div>
                                                <?php
                                                }
                                            } ?>
                                            <?php if(in_array($datas['active'], [6])){?> 
                                            <div class="btn-group btn-group-sm make_premium_track" role="group"  onclick="viewRefurbvalid('<?= $datas['id']; ?>', 'Add')" data-toggle="modal">
                                                <a href="javascript:void(0)" title="Make Refurb" class="btn btn-default">Mark Available</a>
                                            </div>
                                            <?php } ?> 
                                            <?php if(in_array($datas['active'], [2])){ ?> 
                                             <div class="btn-group btn-group-sm " role="group" data-toggle="modal" data-target="#stockFeature">
                                                 <a href="javascript:void(0)" id="feature_track" title="Make Available" class="btn btn-default" onclick="addRemoveFeature(this.id, 'Add', '<?php echo $datas['id']; ?>')">Mark Available</a>
                                             </div>
                                            <?php } ?>  
                                            <?php
                                            if (in_array($datas['active'], [1])) {
                                            ?>
                                            <div class="btn-group btn-group-sm make_premium_track" role="group"  onclick="viewRefurbdata('<?= $datas['id']; ?>', 'Add')" data-toggle="modal">
                                                <a href="javascript:void(0)" title="Add To Refurb" class="btn btn-default">ADD TO REFURB</a>
                                            </div>
                                            <?php
                                            }
if ($_SESSION['userinfo']['is_admin'] == 1 || ($_SESSION['userinfo']['team_id'] == 7 && ($_SESSION['userinfo']['role_id'] == 21 || $_SESSION['userinfo']['role_id'] == 15 || $_SESSION['userinfo']['role_id'] == 24 || $_SESSION['userinfo']['role_id'] == 25))) {
                                                if (!in_array($datas['active'], [2, 3, 6, 4])) {
                                                    ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group"  >
                                                        <a  href="<?php echo $datas['sales_edit_form_link']; ?>" title="mark as booked" class="btn btn-default" >MARK AS BOOKED</a>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!in_array($datas['active'], [1,2, 3, 6])) { ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group" >
                                                        <a   href="javascript:void(0)" onclick="markAsSold('<?= $datas['id']; ?>','<?= $datas['sales_edit_form_link']; ?>')" title="mark as sold" class="btn btn-default" >MARK AS SOLD</a>
                                                    </div>
                                                    <div class="btn-group btn-group-sm"  role="group" >
                                                        <a  target="_blank" href="javascript:void(0)" onclick="openCancelBookingModal('<?= $datas['id']; ?>')" data-toggle="modal" title="cancel booking" class="btn btn-default" >CANCEL BOOKING</a>
                                                    </div>
                                                    <?php
                                                }
                                                if (in_array($datas['active'], [3,4])) { ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group" >
                                                        <a class="btn btn-default" target="_blank" href="javascript:void(0)" onclick="downloadBookingForm('<?php echo $datas['id'];?>','booking')" data-toggle="tooltip" data-placement="bottom" title="download booking form">
                                                          BOOKING FORM <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                                if (in_array($datas['active'], [3])) { ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group" >
                                                        <a class="btn btn-default" target="_blank" href="javascript:void(0)" onclick="downloadBookingForm('<?php echo $datas['id'];?>','salesInvoice')" data-toggle="tooltip" data-placement="bottom" title="download invoice">
                                                          INVOICE <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                                if (in_array($datas['active'], [3])) { ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group" >
                                                        <a class="btn btn-default" target="_blank" href="javascript:void(0)" onclick="downloadBookingForm('<?php echo $datas['id'];?>','paymentReceipt')" data-toggle="tooltip" data-placement="bottom" title="download payment receipt">
                                                          PAYMENT RECEIPT <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                                if (in_array($datas['active'], [3])) { ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group" >
                                                        <a class="btn btn-default" target="_blank" href="javascript:void(0)" onclick="downloadBookingForm('<?php echo $datas['id'];?>','gatePass')" data-toggle="tooltip" data-placement="bottom" title="download gate pass">
                                                          GATE PASS <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                                if (in_array($datas['active'], [3])) { ?>
                                                    <div class="btn-group btn-group-sm" data-remotee="" role="group" >
                                                        <a class="btn btn-default" target="_blank" href="javascript:void(0)" onclick="downloadBookingForm('<?php echo $datas['id'];?>','deliveryNote')" data-toggle="tooltip" data-placement="bottom" title="download delivery note">
                                                          DELIVERY NOTE <i class="fa fa-download" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                <?php
                                                }
                                            }
                                            ?>

        <?php if (!in_array($datas['active'], [2, 3, 4,6]) || !empty($datas['CStatus'])) { ?>
                                                <div class="btn-group btn-group-sm" data-toggle="modal" data-target="#model-mark_as_Renew">
                                                    <a href="javascript:void(0)" title="Renew" renewtitle="1" renew_exhausted="-2" renew_sku_status="0" class="btn btn-default dropdown-toggle more-opt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/three-dots.png">
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <?php if (!in_array($datas['active'], [2, 3, 4,6])) { ?>
                                                            <li><a href="javascript:void(0)" onclick="openAddLeadModal('<?= $datas['id']; ?>')">Add Lead</a></li> 
                                                        <?php } if (!empty($datas['CStatus'])) { ?>
                                                            <li><a href="javascript:void(0)" onclick="viewInspectionDetails('<?= $datas['id']; ?>')">Inspected Report </a></li>
            <?php } ?> 
                                                    </ul>
                                                </div>
        <?php } ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-2 col-md-1">
        <?php if ($searchData['tab_value'] == 'all') { ?><div class="label-status <?= $datas['tab'] ?>"><?= $datas['status_label'] ?></div> <?php } ?>
                                    <div class="row progessbox ">

                                        <div class="col-xs-6  col-sm-12 text-center p-lead-box">
                                            <a href="<?php
                                            if ($datas['total_leads'] > 0) {
                                                echo base_url('lead/getLeads?viewlead=viewlead&type=all&filter_data_type=allleads&gaadi_id=' . $datas['id']);
                                            } else {
                                                echo "javascript:void(0)";
                                            }
                                            ?>" class="lead-circle ">
                                                <div class="leadbx"><div class="pie_progress__number" id="<?='leadcnt_'.$datas['id']?>"><?= $datas['total_leads'] ?></div>
                                                    <div class="pie_progress__label">Total Lead</div></div></a></div>
                                        <!--<div class="col-xs-6 col-sm-12  col-md-10 "><div class=" text-center viewer">15 Views</div></div>--></div>

                                </div>
                                <div class="col-sm-4 col-md-3 editprice-box">
                                    <div class="clearfix">
                                        <div class="clearfix">
                                            <div class="btn-group btn-group-sm " role="group">

        <?php if ($_SESSION['userinfo']['is_admin'] == 1 || ($_SESSION['userinfo']['role_id'] == 17 || ($_SESSION['userinfo']['role_id'] == 25))) { ?>
                                                    <span class="editretail" style="line-height: 24px;">
                                                        <a style='' target="_blank" href="<?= $datas['edit_form_link']; ?>" data-toggle="tooltip" data-placement="bottom" title="View Purchase Details">
                                                            <img style="opacity:.54" src="<?= base_url() ?>assets/admin_assets/images/purchase.svg">
                                                        </a>
                                                    </span>
        <?php } if($_SESSION['userinfo']['is_admin'] == 1 || ($_SESSION['userinfo']['role_id'] == 21) || ($_SESSION['userinfo']['role_id'] == 25)){?>
                                                <?php if (in_array($datas['active'], [3,4])) {?>
                                                    <span class="editretail" style="line-height: 24px;">
                                                        <a style='' target="_blank" href="<?php echo $datas['sales_edit_form_link']; ?>" data-toggle="tooltip" data-placement="bottom" title="View Sale Details">
                                                            <img style="opacity:.54" src="<?= base_url() ?>assets/admin_assets/images/sell.svg">
                                                        </a>
                                                    </span>
                                                <?php } } ?>
        <?php if (!in_array($datas['active'], [2, 3,4])) { ?>
                                                    <span class="mrg-R20 btn-group btn-group-sm " role="group" data-toggle="modal" data-target="#stocksmsEmail">
                                                        <a href="javascript:void(0)" id="send_email_track" title="Share" onclick="sendSmsNewVersion(this.id, '', 'email', '', 'refresh', '<?php echo $datas['id']; ?>')" data-toggle="tooltip" data-placement="bottom" title="Share">
                                                            <img src="<?= base_url() ?>assets/admin_assets/images/shar-i.svg">
                                                        </a>
                                                    </span>
                                                <?php } ?>
                                                <?php
                                                if ($_SESSION['userinfo']['team_id'] == 7 && ($_SESSION['userinfo']['role_id'] == 19 ||  $_SESSION['userinfo']['role_id'] == 25) &&
                                                        !in_array($datas['active'], [3, 4])) {
                                                    ?>
                                                    <a data-original-title="Edit" title="Edit" href="<?= base_url('cardetails/' . base64_encode(DEALER_ID . '_' . $datas['case_id'])) ?>" class="mrg-R15" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                        <img src="<?= base_url() ?>assets/admin_assets/images/edit-i.svg">
                                                    </a>
                                                <?php } ?>

        <?php if (!in_array($datas['active'], [2, 3, 4,6])) { ?>
                                                    <span class="mrg-R20 btn-group btn-group-sm">
                                                        <a href="javascript:void(0)" onclick="deleteStock(<?php echo $datas['id'] ?>)" title="Remove" data-toggle="tooltip" data-placement="bottom" title="Remove">
                                                            <img src="<?= base_url() ?>assets/admin_assets/images/delete-i.svg">

                                                        </a>
                                                    </span>
                                                <?php } ?>

                                                <?php if (in_array($datas['active'], [2])) { ?>
                                                    <!--<div class="btn-group btn-group-sm " role="group" data-toggle="modal" data-target="#stockFeature"><a href="javascript:void(0)" id="feature_track" title="Make Featured" class="" onclick="addRemoveFeature(this.id, 'Add', '<?php echo $datas['id']; ?>')"><span data-original-title="Remove" data-toggle="tooltip" data-placement="top" title="Add to Stock" class="sprite icon-add"></span></a></div>-->
                                                <?php } ?>
                                            </div>

                                        </div>
                                        <div class=" col-xs-6 col-sm-12 pad-R0"><div class="mrg-T15">

                                                    <?php if (!in_array($datas['active'], [2, 3, 4])) { ?>
                                                    <div>
                                                        <?php
                                                        $totalclassified = $datas['totalclassified'];
                                                        $totalinvlist = $datas['inventorytolist'];
                                                        $featuredCars = 0;
                                                        if ($datas['ispremium'] == '1') {
                                                            $featuredCars = 1;
                                                        }
                                                        $isClassifiedReadOnly = ($accessLevel == 1) ? '' : '';
                                                        ?>

                                                        <?php if ($datas['isclassified'] == '1') { ?>
                                                            <input type="checkbox" <?php echo $isClassifiedReadOnly; ?> checked="checked" onclick="changeCheckboxVal(<?php echo $datas['id']; ?>, '1',<?php echo $totalclassified; ?>,<?php echo $totalinvlist; ?>,<?php echo $featuredCars; ?>)" class="classifiedcheckuncheck" name="classified" id="classified<?php echo $datas['id']; ?>" value="<?php echo $datas['id']; ?>"><label for="classified<?php echo $datas['id']; ?>"><span></span></label>
                                                        <?php } else { ?>
                                                            <input type="checkbox" <?php echo $isClassifiedReadOnly; ?> onclick="changeCheckboxVal(<?php echo $datas['id']; ?>, '0',<?php echo $totalclassified; ?>,<?php echo $totalinvlist; ?>,<?php echo $featuredCars; ?>)" class="classifiedcheckuncheck" name="classified" id="classified<?php echo $datas['id']; ?>" value="<?php echo $datas['id']; ?>"><label for="classified<?php echo $datas['id']; ?>"><span></span></label>
            <?php } ?>
                                                        Classified  <a class="classified-help-icon"   id="statusover<?php echo $datas['id']; ?>" href="javascript:void(0)" >
                                                        </a><i class="fa fa-info-circle font-18" aria-hidden="true" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" data-content="By checking this box, the stock will get pushed to Gaadi.com and CarDekho.com. It may take up to 30 minutes to take effect." check box unchecked data-original-title="" title=""></i>
                                                    </div>
        <?php } ?>
                                             

                                                <div class="col-md-12 hidden-xs tips-div tips mrg-T15" style="padding-right:0px;padding-left:0; display:block; text-align:center; display:none;">
                                                    <a class="" href="javascript:void(0)" id="2-1234" data-toggle="modal" data-target="#tips-popup">
                                                        <img src="<?php echo base_url(); ?>assets/admin_assets/images/bulb-modal.svg">View Tips  (0)</a>
                                                </div>
        <?php if (!in_array($datas['active'], [2, 3,4])) { ?> 
                                                    <div class="mrg-T15 view-tips-sm">               
                                                        <span>View On: </span>
            <?php if ($datas['id'] > 0) { ?>
                                                            <a target="_blank" class="GAViewOnWebsite" onclick="GAViewOnWebsite()" title="My Website" href="http://<?= $datas['domain'] ?>/cardetails/<?php echo base64_encode(DEALER_ID.'_'.$datas['case_id']); ?>"><i class="source-icon website"></i></a>&nbsp;&nbsp;
                                                            <a target="_blank" class="GAViewOnGaadi" onclick="GAViewOnGaadi()" title="Gaadi.com" href="http://www.gaadi.com/usedcars/details-<?= $datas['gaadi_id'] ?>-Tata_Safari+Storme+2012+2015_LX"><img src="<?php echo base_url(); ?>assets/admin_assets/images/gaadi-logo.png"></a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                         <?php if(!empty($datas['getWebsiteLinks'])){
                                                            foreach ($datas['getWebsiteLinks'] as $kurl => $vurl) {
                                                                if(!empty($vurl['website_name'])){?>
                                                                <a target="_blank" class=""  title="<?=$vurl['website_name']?>" href="<?= $vurl['website_link'] ?>"><img src="<?php echo base_url(); ?>assets/images/websitelink/<?php echo strtolower($vurl['website_name']).'.png'; ?>"</a>&nbsp;&nbsp;
                                                           <?php }}
                                                            }?>
            <?php if ($datas['cardekho_id'] > 0 && $datas['isclassified'] == '1') { ?>

                                                            <a target="_blank" class="GAViewOnCardekho" onclick="GAViewOnCardekho()" title="CarDekho.com" href="https://www.cardekho.com/used-car-details/used-Tata-Safari-Storme-2012-2015-LX-cars-New-Delhi_<?= $datas['cardekho_id'] ?>.htm"><img src="<?php echo base_url(); ?>assets/admin_assets/images/cardekho.png" width="41px;"></a>
                                                    <?php } ?>
                                                    </div>
                                                <?php } ?>
        <?php if (in_array($datas['active'], [2, 6])) { ?>
                                                    <!--                                        <div class="clearfix actionbtns pad-T10 action-tabs">
                                                                                                <div class="btn-group btn-group-sm " role="group">
                                                                                                    <a href="<?= base_url() . 'cardetails/' . base64_encode(DEALER_ID . '_' . $datas['case_id']); ?>"  title="Edit" class=""><span data-original-title="Edit" title="Edit" class="sprite icon-edit"></span></a>
                                                                                                </div>
                                                                                                <div class="btn-group btn-group-sm " role="group" data-toggle="modal" data-target="#stockFeature"><a href="javascript:void(0)" id="feature_track" title="Make Featured" class="" onclick="addRemoveFeature(this.id,'Add','<?php echo $datas['id']; ?>')"><span data-original-title="Remove" data-toggle="tooltip" data-placement="top" title="Add to Stock" class="sprite icon-add"></span></a></div>
                                                                                            </div>-->

        <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div></div>

                        </div></div></li>
            </ul>
    <?php } ?>
        <input type="hidden" class="pagenum" value="<?= $page ?>" />
        <input type="hidden" class="rowcount" value="<?= $totStock ?>" />
    </div>
    <?php
} else {
    //echo '1';    
}
?>
<style>
    .msp-info:hover #msp_details{display: block}
    #msp_details{display: none;z-index:10000;height: 120px;width: 280px;border:1px solid grey ;border-radius:5px ; background: white;position:absolute}
</style>



<script>
    $(".act").click(function () {
        $(".nonact").toggle();
    });

    $(".list-act").click(function () {
        $(".list-acts").show();
    });

    $(".list-act").click(function () {
        $(".list").hide();
    });
    $(".acts-cls").click(function () {
        $(".list-acts").hide();
    });
    $(".acts-cls").click(function () {
        $(".list").show();
    });
    

    $(function () {
        $('[data-toggle="popover"]').popover()
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    function forceNumber(event) {
        var keyCode = event.keyCode ? event.keyCode : event.charCode;
        if ((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
            return false;
    }
    function markAsSold(car_id,edit_link){
        $.ajax({
            type: "POST",
            url: base_url + "Stock/markSold",
            data: {car_id,edit_link},
            //dataType: 'json',
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.status == true) {
                    //snakbarAlert(data.message);
                    $('.loaderClas').attr('style','display:block;');
                    setTimeout(function () {
                        window.location.href =data.Action;
                    }, 2500);

                    return true;
                } else {
                    //snakbarAlert(data.message);
                    return false;
                }
            }
         });
    }
    function openCancelBookingModal(car_id){
        $('#cancel_booking').modal('toggle');
        var htm =` 
            <div class="modal-body text-center" > 
                        Are you sure you want to cancel the booking?  
            </div>
            <div class="modal-footer">
                <a type="button" class="mrg-R10" data-dismiss="modal">No</a>
                <button type="button" class="btn btn-primary" onclick="cancelBooking(${car_id})" data-dismiss="modal">Yes</button>
            </div>`;
        $('#booking-modal-content').html(htm);
        
    }
    function cancelBooking(car_id){
       
       $.ajax({
            type: "POST",
            url: base_url + "Stock/cancelBooking",
            data: {car_id},
            //dataType: 'json',
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.status == true) {
                    //snakbarAlert(data.message);
                    $('.loaderClas').attr('style','display:block;');
                    setTimeout(function () {
                        window.location.href =data.Action;
                    }, 2500);

                    return true;
                } else {
                    //snakbarAlert(data.message);
                    return false;
                }
            }
         });
        
    }
</script>
