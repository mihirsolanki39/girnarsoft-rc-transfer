<?php
$arrPreference = array();
$arrPreference['ucdid'] = $dealer_id;
$arrPreference['dealer_id'] = $dealer_id;
$arrPreference['body_type'] = '';
$arrPreference['modelIds'] = '';
$arrPreference['makeIds'] = '';
$arrPreference['budget'] = '';
$arrPreference['fuel_type'] = '';
$arrPreference['transmission'] = '';
$requestData['existCarIds']=$objCrm_buy_lead_car_detail->getOnlyFavortieCarIds($requestData['leadId']);
if ($requestData['type'] == 2) {
    if ($requestData['srh_body_type']) {
        $requestData['srh_body_type'] = explode(',', $requestData['srh_body_type']);
    }
    if ($requestData['makeIds']) {
        $requestData['srh_model'] = explode(',', $requestData['makeIds']);
    }
    $arrCarTotal = $objCrm_buy_lead_car_detail->getRecommCar($requestData, $arrPreference);
    if ($arrCarTotal) {
        echo count($arrCarTotal);
    } else {
        echo 0;
    }
    exit;
}

$arrCarList =$objCrm_buy_lead_car_detail->getRecommCar($requestData, $arrPreference);
 $objLeadmodel->crmToDcLeadSync($filter_data = [
                'dealer_id' => DEALER_ID,
                'ldm_id' =>  $requestData['leadId'],
            ]);
//echo "<pre>";print_r($arrCarList);exit;

if (isset($arrCarList) && !empty($arrCarList)) {
    $r = 1;
    ?>
    <div class="carousel-inner" id="new-buyerlead1" role="listbox" style="text-align:left;">
        <?php
        foreach ($arrCarList as $key => $val) {
            $orp = $objGetcarFeature->getCarOnRoadPrice($val->city_name, $val->version_id);
            $orp = ($orp > 0 ? no_to_words($orp) : '');
            $offer_amount = $objCrm_buy_lead_car_detail->getcaroffercount($val->carId);
            ?>
            <div class="item <?php if ($r == 1) { ?>active<?php } ?>">

                <ul class="list-unstyled car-list">
                    <li class="">
                        <div class="clearfix " style="position:relative; padding: 0px 20px;">
                            <div class="col-2">	
                                <input type="hidden" id="recom_year_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->myear; ?>">
                                <input type="hidden" id="recom_month_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?= !empty($val->mm)?$val->mm:''; ?>">
                                <input type="hidden" id="recom_version_id_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->version_id; ?>">
                                <input type="hidden" id="recom_city_name_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->city_name; ?>">
                                <input type="hidden" id="recom_city_id_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->city_id; ?>">
                                <input type="hidden" id="recom_color_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->colour; ?>">
                                <input type="hidden" id="recom_km_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->km; ?>">
                                <input type="hidden" id="recom_price_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->pricefrom; ?>">
                                <input type="hidden" id="recom_make_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->make; ?>">
                                <input type="hidden" id="recom_model_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->model; ?>">
                                <input type="hidden" id="recom_version_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->version; ?>">
                                <input type="hidden" id="recom_regno_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->regno; ?>">
                                <input type="hidden" id="recom_makeID_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->makeID; ?>">
                                <!--<input type="hidden" id="recom_website_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->carId; ?>">-->
                                <input type="hidden" id="recom_fuel_type_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->fuel_type; ?>">
                                <input type="hidden" id="recom_owner_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->owner; ?>">
                                <input type="hidden" id="recom_insurance_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->insurance; ?>">
                                <input type="hidden" id="recom_expiry_date_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?= !empty($val->expiry_date)?$val->expiry_date:''; ?>">
                                <input type="hidden" id="recom_expiry_insurance_month_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->month; ?>">
                                <input type="hidden" id="recom_expiry_insurance_year_<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->year; ?>">
                                <input type="hidden" id="recom_transmission<?php echo $requestData['mobile'] . '_' . $val->carId; ?>" value="<?php echo $val->transmission; ?>">
                                <div class="img-box clearfix"  data-toggle="modal" >
                                    <?php if($val->active!='1'){ ?>
                                    <div class="pos-sold soldbg"><span class="pos-sold-text">Sold</span></div>
                                    <?php } ?>
                                    <a href="#"> 
                                        <div  class="img_thumb">
        <?php $carImage = $objCrm_used_car->getUsedCarImages($val->carId);
        if ($carImage) {
            ?>
                                                <img src="<?php echo $carImage; ?>" class="img-responsive img-height">
        <?php } ?>
                                        </div></a>
                                   
                                    <div class="icon-pos sprite heart-o" onclick=saveCarInfo(<?php echo $val->carId; ?>);><span class="sprite heart-o"></span></div>
                                   

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-sm-5 col-md-3 pad-L0 border-R divheight203">	
                                        <h2 class="carname title-car mrg-B5">
                                                <?php echo $val->make . " " . $val->model . " " . $val->version; ?>
                                <!-- <a><i class="fa fa-heart col-orange" aria-hidden="true" onclick=changeFavourites(<?php //echo $val[car_id]; ?>)></i></a> --></h2>							
                                        <div class="row list-icon">
                                            <div class="col-sm-12 font-20 bold  price-color  mrg-T5">
                                                <i class="fa fa-inr font-20 price-color" aria-hidden="true"></i>
                                                <?php if (!empty($val->pricefrom)) { ?>
                                                                    <!-- <i class="fa fa-inr font-14" aria-hidden="true"></i> --> 
                                                    <?php
                                                    if ($val->pricefrom >= 100000) {
                                                        if (($val->pricefrom % 100000) == 0) {
                                                            echo ($val->pricefrom / 100000) . ' Lakh';
                                                        } else {
                                                            echo number_format(($val->pricefrom / 100000), 2) . ' Lakh';
                                                            ;
                                                        }
                                                    } else {
                                                        echo $val->pricefrom;
                                                    }
                                                    ?>
                                                <?php //echo $val[price];  ?>
                                            <?php } ?>
                                            </div>	
        <?php if ($orp) { ?>
                                                <div class="col-sm-12 color-new-text  mrg-T5">On Road Price : <i class="fa fa-inr font-14" aria-hidden="true"></i> <?php echo $orp; ?> </div> 
        <?php } if ($offer_amount[0]->offer > 0) { ?>
                                                <div class="col-sm-12 color-new-text mrg-T5"><?php echo $offer_amount[0]->offer; ?> customer offer</div> 
                                                <div class="col-sm-12 color-new-text mrg-T5">(max offer <i class="fa fa-inr font-14" aria-hidden="true"></i> <?php echo no_to_words($offer_amount[0]->offer_amount); ?>) </div> 
        <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4 border-R divheight203">
                                        <div class="car-specs ">
                                            <h5><strong>Overview</strong></h5>
                                            <div class=" row  list-icon">
                                                <div class="col-md-7">
                                                    <div class="row">
                                                        <div class="col-sm-12 color-new-text">
                                                            <?php //echo '<pre>';print_r($val);?>
                                                            <?php if (!empty($val->myear)) { ?>
                                                                    <!-- <span class="sprite icon-date1 mrg-R5"></span> -->
            <?php echo $val->myear . ' Model'; ?>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-sm-12 color-new-text mrg-T5">
                                                            <?php if (!empty($val->fuel_type)) { ?>
                                                                            <!--<span class="sprite icon-fuel1 mrg-R5"></span>--><?php echo $val->fuel_type; ?>
        <?php } ?>
                                                        </div>
                                                        <div class="col-sm-12 color-new-text mrg-T5">
                                                            <?php if (!empty($val->city_name)) { ?>
                                                                            <!-- <span class="sprite icon-rg-city mrg-R5"></span> -->
                                                                <?php echo $val->city_name . ' (Reg. City)'; ?>	
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-sm-12 color-new-text mrg-T5">

        <?php if (!empty($val->insurance)) { ?>
                                                                                                                            <!-- <span class="sprite icon-insure mrg-R5"></span> -->
            <?php echo $val->insurance; ?>
            <?php if (strtolower($val->insurance) != 'no insurance') { ?>
                                                                    <br>
                                                                    <span class="font-11">(Expiry: <?php echo date("M", strtotime($val->year ."-". $val->month ."-01")) .' '. $val->year; ?>)</span>
            <?php }
        } ?>


                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-5">
                                                    <div class="row">
                                                        <div class="col-sm-12 color-new-text"><?php if (!empty($val->km)) { ?>
                                                                            <!-- <span class="sprite icon-kml mrg-R5"></span> -->
            <?php echo $val->km . ' kms'; ?>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-sm-12 color-new-text mrg-T5">
                                                            <?php if (!empty($val->transmission)) { ?>
                                                                            <!-- <span class="sprite icon-kml mrg-R5"></span> -->
                                                                <?php echo $val->transmission; ?>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-sm-12 color-new-text mrg-T5">
                                                            <?php if (!empty($val->owner)) { ?>
                                                                <?php
                                                                switch ($val->owner) {
                                                                    case'1':
                                                                        echo 'First Owner';
                                                                        break;
                                                                    case '2':
                                                                        echo 'Second Owner';
                                                                        break;
                                                                    case '3':
                                                                        echo 'Third Owner';
                                                                        break;

                                                                    case '4':
                                                                        echo 'Fourth Owner';
                                                                        break;
                                                                }
                                                                ?>
        <?php } ?>
                                                        </div>
                                                        <div class="col-sm-12 color-new-text mrg-T5">
                                    <?php if (!empty($val->colour)) { ?>
                                                                    <!-- <span class="sprite icon-color1 mrg-R5"></span> -->
                                        <?php echo $val->colour; ?>
                                    <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>                 
                                            </div>
                                        </div>
                                    </div>
                                                <?php
                                                if (!empty($val->version_id)) {
                                                    $arrCarFeatures = $objGetcarFeature->getcarfeature($val->version_id);

                                                    if (!empty($arrCarFeatures)) {
                                                        ?>
                                            <div class="col-sm-12 col-md-4 divheight203">
                                                <div class="car-specs ">
                                                    <h5><strong>Features</strong></h5>
                                                    <div class=" row" style="line-height:24px;">

                <?php
                foreach ($arrCarFeatures as $key => $val) {
                    ?>
                                                            <div class="col-sm-6 color-new-text mrg-T5"><?php echo $val['value']; ?></div>
                <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
            <?php }
        } ?>
                                   
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        <?php $r++;
    } ?>
        <input type="hidden" id="totalRecomCar" value="<?php echo count($arrCarList); ?>">
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic_<?php echo $requestData['mobile']; ?>" role="button" data-slide="prev">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic_<?php echo $requestData['mobile']; ?>" role="button" data-slide="next">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
        <span class="sr-only">Next</span>
    </a>
<?php } else { ?>
    <div class="text-center pad-T30 pad-B30">
        <img src="<?=base_url('assets/admin_assets/images/face.png'); ?>"/>  
    </div>
<?php } ?>
		




