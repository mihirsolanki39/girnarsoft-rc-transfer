
<link href="<?= base_url('/assets/css/vdp.css') ?>" rel="stylesheet">
<?php //echo '<pre>';print_r($carDetail);die;
function indian_currency_format($money){
    $len = strlen($money);
    $m = '';
    $money = strrev($money);
    for($i=0;$i<$len;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
            $m .=',';
        }
        $m .=$money[$i];
    }
    return strrev($m);
}
?>
<div class="container-fluid mrg-all-20 mrg-T0 pad-all-0">
    <h1 class="main-heading mrg-T5">View Inventory</h1>
    <div class="row">
        <div class="col-md-6 mrg-B20">
            <div class="carousel-head"><strong><?= $carDetail['make'] ?> <?= $carDetail['ParentModel'] ?></strong> <span class="carouselSub-head"> <?= $carDetail['carversion'] ?></span></div>
            <!-- carousel start -->
            <?php
            if (!empty($image)) 
             {
                ?>
                <div id="carousel-main-img" class="carousel slide carousel-border" data-ride="carousel">

                    <div class="carousel-inner">  
                        <?php
                        foreach ($image as $key => $vals) { 
                        
                            if ($key == 0) {
                                $class = "active";
                            } else {
                                $class = "";
                            }
                            ?>						
                            <div class="item <?php echo $class; ?>">
                                <img src="<?= !empty($vals['image_name'])?UPLOAD_IMAGE_URL."uploadcar/original/".$vals['image_name']:'' ?>" class="img-responsive" >
                            </div>
                            <?}?>
                        </div>

                        <a class="left carousel-control" href="#carousel-main-img" data-slide="prev">
                            <span class=""><i class="fa fa-chevron-left"  style="margin-top: 165px;font-size: 28px;" data-unicode="f053"></i></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-main-img" data-slide="next">
                            <span class=""><i class="fa fa-chevron-right" style="margin-top: 165px;font-size: 28px;" data-unicode="f054"></i></span>
                        </a>
                    </div>


                    <div id="carousel-thumb-img" class="carousel slide bg-ltgray" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <ul class="list-unstyled row ucd-main-thumb">

                                    <?php
                                    $i = 0;
                                    $k = 0;
                                    foreach ($image as $key => $thumbvals) {
                                    $k++;
                                    if ($i == 0) {
                                    $class = "selected";
                                    } else {
                                    $class = "";
                                    }
                                    ?>
                            <li class="<?php echo $class ?>" id="carousel-selector-<?php echo $i ?>"><img src="<?= !empty($thumbvals['image_name'])?UPLOAD_IMAGE_URL."uploadcar/original/".$thumbvals['image_name']:'' ?>" class="img-responsive"></li>

                                        <?php
                                        if ($k % 5 == 0) {
                                            $k = 0;
                                            echo "</ul></div><div class='item'><ul class='list-unstyled row ucd-main-thumb'>";
                                        }
                                        $i++;
                                    }
                                    ?>

                                </ul>
                            </div>


                        </div>
                        <a class="left carousel-control" href="#carousel-thumb-img" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"><i class="" data-unicode="f053"></i></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-thumb-img" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"><i class="" data-unicode="f054"></i></span>
                        </a>
                    </div>

    <?php } ?>

                <!-- carousel end -->
            </div>
            <div class="col-md-6 mrg-B20 right-section-pad">
                <h1 class="main-heading mrg-T5">Information of the Car 
                        <a href="<?=base_url()?>inventories/add_inventories/<?=base64_encode(DEALER_ID.'_'.$carDetail['id'] )?>" target="_blank" class="btn btn-primary btn-lg b-btn-mob pull-right edit_detail"><i class="fa fa-pencil pad-R5" data-unicode="f040"></i>Edit Details</a>
                </h1>
                <hr class="mrg-T10">
                <ul class=" list-unstyled row">
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-calendar mrg-R5" data-unicode="f073"></i> <span class=" text-light">Make Month and Year:</span> <strong><?= !empty($monthText)?$monthText:'' ?> <?= $carDetail['myear'] ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-calendar mrg-R5" data-unicode="f073"></i> <span class=" text-light">Listing Date:</span> <strong> <?php echo date("d M Y", strtotime($carDetail['created_date'])); ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-map-marker mrg-R5" data-unicode="f041"></i> <span class=" text-light">Reg. No:</span> <strong> <?= (($carDetail['regno'] != 'Reg. No.' && $carDetail['regno'] != '') ? $carDetail['regno'] : 'Unregister Car') ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-map-marker mrg-R5" data-unicode="f041"></i> <span class=" text-light">Reg. Place:</span> <strong>  <?= (($carDetail['RegCity'] != '') ? $carDetail['RegCity'] : 'Unregister Car') ?>	</strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-tachometer mrg-R5" data-unicode="f0e4"></i> <span class=" text-light">Kilometers:</span> <strong><?= (($carDetail['km']) ? indian_currency_format($carDetail['km']) : 'N/A') ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-user mrg-R5" data-unicode="f007"></i> <span class=" text-light">No. of Owners:</span> <strong> 
    <?php
    if ($ownerText != '' && $ownerText != '--') {
        echo $ownerText;
    } else {
        echo 'N/A';
    }
    ?>
  </strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-tint mrg-R5" data-unicode="f043"></i> <span class=" text-light">Fuel Type:</span> <strong>  <?= (!empty($carDetail['fuel_type']) ? $carDetail['fuel_type'] : 'N/A') ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-cog mrg-R5" data-unicode="f013"></i> <span class=" text-light">Transmission Type:</span> <strong> <?= (!empty($carDetail['transmission'] != '' && $carDetail['transmission'] != '0') ? $carDetail['transmission'] : 'N/A') ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-paint-brush mrg-R5" data-unicode="f1fc"></i> <span class=" text-light">Color:</span> <strong> <?= (!empty($carDetail['colour']) ? $carDetail['colour'] : 'N/A') ?></strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-user-md mrg-R5" data-unicode="f0f0"></i> <span class=" text-light">Insurance:</span> <strong> <?= (!empty($carDetail['insurance'] && $carDetail['insurance'] != '0') ? $carDetail['insurance'] : 'NO') ?> </strong>
                    </li>
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-money mrg-R5" data-unicode="f0d6"></i> <span class=" text-light">Tax:</span> <strong> <?= (!empty($carDetail['tax'] && $carDetail['tax'] != '0') ? $carDetail['tax'] : 'N/A') ?></strong></li>
<!--                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-home mrg-R5" data-unicode="f015"></i> <span class=" text-light">Showroom Name:</span> <strong> <?= (($showroomName != '') ? $showroomName : 'N/A') ?></strong>
                    </li>-->
                    <li class="col-sm-6 mrg-B10">
                        <span class=" text-light">Status:</span> <strong> <?= !empty($CarStatus)?$CarStatus:''  ?></strong>
                    </li>
    <?php
     if (!empty($feature['resultModelInfo']['additional_feature'])) {
        ?>
                        <li class="col-sm-12 mrg-B10">
                            <i class="fa fa-list-alt mrg-R5" data-unicode="f022"></i> <span class=" text-light">Additional details:</span> 
                            <i class="carCity_735585 font-12"><?php
        if (!empty($feature['resultModelInfo']['additional_feature'])) {
            echo $feature['resultModelInfo']['additional_feature'];
        } else {
            echo 'N/A';
        }
        ?></i>
                        </li>
                    <?php } ?>
                </ul>

                <h1 class="main-heading mrg-T5">Pricing Details</h1>
                <hr class="mrg-T10">
                <ul class=" list-unstyled row">
                    <li class="col-sm-5 mrg-B10">
                        <span class=" text-light">Retail Price:</span> <strong  class="highlight-color font-18"><i class="fa fa-inr" data-unicode="f156"></i>  <?= (($carDetail['pricefrom']) ? indian_currency_format($carDetail['pricefrom']) : 'N/A') ?></strong>
                    </li>
                            <?php
                                ?>
                                <?php
                                if ($carDetail['offers'] != '0' && $carDetail['offers'] != '') {
                                    ?>
                            <li class="col-sm-5 mrg-B10">
                                <span class=" text-light">Special offers:</span> <strong> <?= (($carDetail['offers'] != '0' && $carDetail['offers'] != '') ? $carDetail['offers'] : 'N/A') ?></strong>
                            </li>
        <?php
        
    }
    ?>
                </ul>



                <h1 class="main-heading mrg-T5">Inspection Details</h1>
                <hr class="mrg-T10">
                <ul class=" list-unstyled row">
                    <li class="col-sm-6 mrg-B10">
                        <i class="fa fa-check-circle mrg-R5" data-unicode="f058"></i> <span class=" text-light">Certified By:</span> <strong><?= (($carId > 0 && $certificationName != '') ? $certificationName : 'N/A') ?></strong>
                    </li>

                    <?php
                    if ($carDetail['certification_status'] != '0') {
                    ?>
                    <li class="col-sm-5 mrg-B10">
                        <span class=" text-light">Inspection Status:</span> <strong> <?= $certified_status_array[$carDetail['certification_status']]; ?></strong>
                    </li>

                    <?php } ?>

                    <?php
                    if (!empty($cerexpiredate['expiry_date']) && $cerexpiredate['expiry_date'] != '0000-00-00') {
                    ?>

                    <li class="col-sm-5 mrg-B10">
                        <span class=" text-light">Expiry Date:</span> <strong> <?= date("d M Y", strtotime($cerexpiredate['expiry_date'])); ?></strong>
                    </li>

                    <?php } ?>

                    <li class="col-sm-12 mrg-B10">
                        <?php
                        if ($CStatus != '' && $CStatus != '0' && $CStatus != 'In Process') {
                        ?>
                        <div class="btn-group btn-group-sm "data-remotee="<?php echo BASE_HREF; ?>user/ajax/inspection_report.php?car_id=<?php echo $carDetail[id]; ?>&utm_medium=vdp" role="group" data-target="#model-issuewarrenty" data-toggle="modal"><a href="#" title="Inspection Report" class="btn btn-default">Inspection Report</a></div>

                        <div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="model-issuewarrenty">
                            <div class="modal-body">

                            </div>
                        </div><?php
                        }
                        if (!empty($carDetail['warranty_id'])) {
                        ?>  
                        &nbsp;&nbsp;
                        <div class="btn-group"><a target="_blank" href="http://usedcarsin.in/evaluation/evaluation_app/pdfs/CarDekho_TrustMark_Warranty_Certificate_<?php echo $carDetail['warranty_id'] ?>.pdf" class="btn btn-default"><i class="fa fa-eye font-14" data-unicode="f06e"></i> View Warranty Certificate </a></div>

                        <?php
                        }
                        ?>  
                    </li>

                </ul>

            </div>
    </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover enquiry-table">
                <thead>
                    <tr>
                        <th colspan="2"><h4 class="mrg-T5 mrg-B5"><strong>Condition of the Car</strong></h4></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td width="25%"> <strong>Overall Condition:</strong></td>	
                        <td><?= (!empty($feature['conditionName']['condition_name']) ? $feature['conditionName']['condition_name'] : '- - - - -'); ?> </td>	
                    </tr>
                    <tr>
                        <td><strong>Exterior:</strong></td>	
                        <td> <?= ((substr($feature['viewexterior'], 0, -2)) ? substr($feature['viewexterior'], 0, -2) : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Body & Frame:</strong></td>	
                        <td><?= ((substr($feature['bodyTypes'], 0, -2)) ? substr($feature['bodyTypes'], 0, -2) : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Interior:</strong></td>	
                        <td><?= ((substr($feature['interiors'], 0, -2)) ? substr($feature['interiors'], 0, -2) : '- - - - -'); ?> </td>	
                    </tr>
                    <tr>
                        <td><strong>Engine/Transmission/Clutch:</strong></td>	
                        <td><?= ((substr($feature['etcs'], 0, -2)) ? substr($feature['etcs'], 0, -2) : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Suspension/Steering:</strong></td>	
                        <td><?= ((substr($feature['susstes'], 0, -2)) ? substr($feature['susstes'], 0, -2) : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Tires:</strong></td>	
                        <td><?= ((substr($feature['tires'], 0, -2)) ? substr($feature['tires'], 0, -2) : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Electrical & Electronics:</strong></td>	
                        <td><?= (!empty($feature['electricalName']['electrical_name']) ?$feature['electricalName']['electrical_name'] : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>AC/Heater:</strong></td>	
                        <td><?= (!empty($feature['heaterName']['acheater_name']) ? $feature['heaterName']['acheater_name'] : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Battery:</strong></td>	
                        <td><?= (!empty($feature['batteriName']['battery_name']) ? $feature['batteriName']['battery_name'] : '- - - - -'); ?></td>	
                    </tr>
                    <tr>
                        <td><strong>Brakes:</strong></td>	
                        <td><?= ((substr($feature['breaks'], 0, -2)) ? substr($feature['breaks'], 0, -2) : '- - - - -'); ?></td>	
                    </tr>

                </tbody>
            </table>
        </div>

        <h1 class="main-heading mrg-T5">Model Details </h1>
        <hr class="mrg-T10">
        <div class="row">
            <div class="col-sm-3">
                <p><strong>Interiors / Exterior</strong></p>
                <ul class="list-unstyled list-link">
    <?php
    if (!empty($feature['resultModelInfo']['cupHolders'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Cup Holders</li>
    <?php } ?>
    <?php
    if (!empty($feature['resultModelInfo']['foldingRearSeat'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Folding Rear-Seat</li>
    <?php } ?>
    <?php
    if (!empty($feature['resultModelInfo']['tachometer'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Tachometer</li>
    <?php } ?>
    <?php
    if (!empty($feature['resultModelInfo']['leatherSeats'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Leather Seats</li>  
    <?php } ?> 
    <?php
    if (!empty($feature['resultModelInfo']['tubelessTyres'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Tubeless Tyres</li>
    <?php } ?>
    <?php
    if (!empty($feature['resultModelInfo']['sunRoof'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Sun-Roof</li>
    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['fogLights'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Fog Lights</li> 
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['washWiper'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Wash Wiper</li>
                    <?php } ?>

                </ul>
            </div>
            <div class="col-sm-3">
                <p><strong>Comfort and convenience</strong></p>
                <ul class="list-unstyled  list-link">
                    <?php
                    if (!empty($feature['resultModelInfo']['powerWindows'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Power Windows</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['powerSteering'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Power Steering</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['powerDoorLocks'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Power door locks</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['powerSeats'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Power seats</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['steeringAdjustment'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Steering Adjustment</li>
                    <?php } ?>
    <?php
    if (!empty($feature['resultModelInfo']['carStereo'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Car Stereo</li>
    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['displayScreen'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Display Screen</li>
                    <?php } ?>

                </ul>
            </div>
            <div class="col-sm-3">
                <p><strong>Safety and Security</strong></p>
                <ul class="list-unstyled  list-link">
                    <?php
                    if (!empty($feature['resultModelInfo']['antiLockBrakingSystem'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Anti-Lock Braking System</li>
                    <?php } ?>	
                    <?php
                    if (!empty($feature['resultModelInfo']['driverAirBags'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Driver Air-Bags</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['pssengerAirBags'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Passenger Air-Bags</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['immobilizer'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i>  Immobilizer</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['remoteBootFuelLid'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Remote Boot</li>
                    <?php } ?>
    <?php
    if (!empty($feature['resultModelInfo']['tractionControl'])) {
        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Traction Control</li>
    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['childSafetyLocks'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Child Safety Locks</li>
                    <?php } ?>
                    <?php
                    if (!empty($feature['resultModelInfo']['centralLocking'])) {
                        ?>
                        <li><i class="fa fa-check mrg-R5" data-unicode="f00c"></i> Central Locking</li><?php } ?>                                                             
                </ul>
            </div>
        </div>


                    <?php
//                    if ($carDetail['gaadi_id'] > 0  && count($lead_details) > 0)
//                        {
                        ?>
<!--            <h1 class="main-heading mrg-T5">Lead Details </h1>
            <hr class="mrg-T10">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover enquiry-table">

                    <tbody>
                        <tr>
                            <td  colspan='2'> <strong>Overall Buyer Leads:&nbsp;&nbsp;&nbsp;</strong><?php echo $total_lead[total]; ?></td>	
                            <td  colspan='3'><strong>Unique Buyer Leads:&nbsp;&nbsp;&nbsp;</strong><?php echo count($lead_details); ?></td>

                        </tr>

                        <tr>
                            <td ><strong>Lead Id</strong></td> <td ><strong>Customer Details</strong></td> <td ><strong>Date</strong></td> <td ><strong>Source</strong></td><td ><strong>Status</strong></td>	

                        </tr>
                        <?php
                        foreach ($lead_details as $key => $value) {
                            ?>
                            <tr>
                                <td ><?php echo $value[id]; ?></td> <td ><?php echo $value[cd_customer_name] . ' | ' . $value[cd_customer_mobile] . ' | ' . $value[cd_customer_email]; ?></td> <td ><?php echo date("d/m/Y", strtotime($value[last_enquiry_date])); ?></td> <td ><?php echo $value[source]; ?></td><td ><?php echo $value[ldf_status]; ?></td>	

                            </tr>-->
        <?php //} ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>




    <?php //}} ?>
    <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
    <script src="<?= base_url('/assets/js/inventories.js') ?>"></script>
<script type="text/javascript">

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>


