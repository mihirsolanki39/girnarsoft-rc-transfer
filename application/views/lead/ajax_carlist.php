<?php  
//echo "<pre>";print_r($requestData);exit;
if($requestData['fuelType']){
   $requestData['srh_fuel']=$requestData['fuelType'];
}
if($requestData['budget']){
   $requestData['srh_budget']=$requestData['budget'];
}
if($requestData['transmission']){
   $requestData['srh_transmission']=$requestData['transmission'];
}

$favourtiesArr = array();
$totalFavourtiesCar = 0;
if(!empty($requestData['leadId'])) {
    //echo "<pre>";print_r($getLeadFavoriteCar);exit;
        $favourtiesArr=$getLeadFavoriteCar;
	$totalFavourtiesCar = count($favourtiesArr);
}
?>
<div id="listingveiw">
<div id="buyerleads-new ">
	<div class="panel with-nav-tabs panel-default">
	<div class="panel-heading">
	<input type="hidden" id="cust_mobile_no" value="<?php echo $requestData['number'] ?>">
	<ul class="nav nav-tabs border-B">
	  <li  class=" tablinks flip-down " id="favourites_<?=$requestData['number']?>"><a href="javascript:void(0)" >Favourites (<span class="" id="totalFavourities_<?=$requestData['number']?>"><?php echo $totalFavourtiesCar; ?></span>)</a></li>
	  <li  class="tablinks flip-down" id="similar_<?=$requestData['number']?>"><a href="javascript:void(0)">Recommended (<span class="" id="recomCarTotalCount_<?php echo $requestData['number'] ?>">0</span>) </a></li>
	  <li class="pull-right">
                                 
              <button type="button" class="close close-new" id="close"  onclick="$('#flip-up_<?=$requestData['number']?>').slideUp('slow');"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"> <span class="sr-only">Close</span></button>
	  </li>
	</ul>
</div>
</div>

<?php  if(($requestData['type']=='favourites' || $requestData['type']=='flip-down') ){  //id="similar" class="tabcontent"      id="favourites" class="tabcontent" style="display:block" ?>
	
	<div style="border: 1px solid #ccc;border-top: none;">
	  <div>
	  	<?php $z = 1;
		  		if(isset($favourtiesArr) && !empty($favourtiesArr)) {
		  			?>
	  	<div id="carousel-fav-generic_<?php echo $requestData['number'] ?>" class="carousel slide" data-ride="carousel">
		
		  <div class="carousel-inner" id="new-buyerlead" role="listbox" style="text-align:left;">
		  	<?php
                        if(!empty($favourtiesArr)){
                        foreach($favourtiesArr as $key => $val) { 
                            $orp=$objGetcarFeature->getCarOnRoadPrice($val['city_name'],$val['version_id']);
                            $orp=($orp>0?no_to_words($orp):'');
                            $offer_amount=$objCrm_buy_lead_car_detail->getcaroffercount($val['car_id']);
                            $val['ins_month']  = sprintf("%02d", $val['ins_month'] );
                            
                        ?>
			<div class="item <?php if($z == '1') { echo 'active'; } ?>">				
			  <ul class="list-unstyled car-list">
				<li class="">
					<div class="clearfix " style="position:relative; padding: 0px 20px;">
						<div class="col-2">
							<div class="img-box clearfix"  data-toggle="modal">
                                                            <?php if($val['is_sold']!='1'){ ?>
                                                            <div class="pos-sold soldbg"><span class="pos-sold-text">Sold</span></div>
                                                            <?php } ?>
								<a href="#"> <div  class="img_thumb">
									<?php  $carImage = $objCrm_used_car->getUsedCarImages($val['car_id']);
									if(!empty($carImage)) {
									 ?>
									<img src="<?php echo $carImage; ?>" class="img-responsive img-height">
								<?php } ?>
								</div></a>
                                                            
                                                                <?php if(!$val['disable_unassign']){?><div class="icon-pos" onclick=changeFavourites(<?php echo $val['car_id']; ?>);><span class="sprite heart"></span></div><?php }?>
            
							</div>
						</div>
						<div class="col-3">							

							<div class="row">
								<div class="col-sm-5 col-md-3 pad-L0 border-R divheight203">	
									<h2 class="carname title-car mrg-B5">
								<?php echo $val['make'] . " " . $val['model'] . " " . $val['version']; ?>
                                                                        </h2>							
									<div class="row list-icon">
										<div class="col-sm-12 font-20 bold price-color mrg-T5">
											<i class="fa fa-inr font-20 price-color" aria-hidden="true"></i>
												<?php if(!empty($val['price'])) { ?>
													<!-- <i class="fa fa-inr font-14" aria-hidden="true"></i> --> 
													<?php 
													if($val['price'] >= 100000) {
														if(($val['price']%100000) == 0) {
															echo ($val['price']/100000).' Lakh';
														} else {
															echo number_format(($val['price']/100000),2).' Lakh';;
														}
													} else {
														echo $val['price']; 
													}
													?>
																<?php //echo $val[price]; ?>
																<?php } ?>
										</div>	
                                                                                <?php if($orp){?>
										<div class="col-sm-12 color-new-text mrg-T5">On Road Price : <i class="fa fa-inr font-14" aria-hidden="true"></i> <?php echo $orp;?></div> 
                                                                                <?php } if($offer_amount[0]->offer>0){ ?>
										<div class="col-sm-12 color-new-text mrg-T5"><?php echo $offer_amount[0]->offer;?> customer offer</div> 
										<div class="col-sm-12 color-new-text mrg-T5">(max offer <i class="fa fa-inr font-14" aria-hidden="true"></i> <?php echo no_to_words($offer_amount[0]->offer_amount);?> )</div> 
                                                                                <?php } ?>
										<!--<div class="mrg-B10">
											<span class="small text-italic">New Delhi</span>
											<span class="small text-muted mrg-L10 text-italic">Listed on: 09 Jul 2014</span>
											<span class="small text-muted mrg-L10 text-italic">|</span>
											<span class="small text-muted mrg-L10 text-italic">Profile ID: 33581</span>
									</div>-->									
									</div>
								</div>

								<div class="col-md-4 border-R divheight203">
									<div class="car-specs ">
									<h5><strong>Overview</strong></h5>
											<div class=" row  list-icon">
											<div class="col-md-7">
												<div class="row">
													<div class="col-sm-12 color-new-text ">
														<?php if( !empty($val['year'])) { ?>
														<?php echo $val['year'].' Model'; ?>
														<?php } ?>
													</div>
													<div class="col-sm-12 color-new-text mrg-T5">
														<?php if(!empty($val['fuel_type'])) { ?>
															<!--<span class="sprite icon-fuel1 mrg-R5"></span>--><?php echo $val['fuel_type']; ?>
														<?php } ?>
													</div>
													<div class="col-sm-12 color-new-text mrg-T5">
														<?php if(!empty($val['city_name'])) { ?>
															<!-- <span class="sprite icon-rg-city mrg-R5"></span> -->
														<?php echo $val['city_name'].' (Reg. City)'; ?>	
														<?php } ?>
													</div>
													<div class="col-sm-12 color-new-text mrg-T5">

														<?php if(!empty($val['insurance'])) { ?>
														<!-- <span class="sprite icon-insure mrg-R5"></span> -->
														<?php echo $val['insurance']; ?>
														<?php if(strtolower($val['insurance']) !='no insurance') { ?>
														<br>
														<span class="font-11">(Expiry: <?php  echo date("M", strtotime($val['ins_year'] ."-". $val['ins_month'] ."-01")).' '.$val['ins_year']; ?>)</span>
														<?php }} ?>


													</div>
												</div>
											</div> 
											<div class="col-md-5">
												<div class="row">
													<div class="col-sm-12 color-new-text"><?php if(!empty($val['km'])) { ?>
															<!-- <span class="sprite icon-kml mrg-R5"></span> -->
															<?php
                                                                                                                        $this->load->helpers('history_helper');
                                                                                                                        echo formatInIndianStyle($val['km']).' kms' ;?>
														<?php } ?>
													</div>
													<div class="col-sm-12 color-new-text mrg-T5">
														<?php if(!empty($val['transmission'])) { ?>
															<!-- <span class="sprite icon-kml mrg-R5"></span> -->
															<?php echo $val['transmission'];?>
														<?php } ?>
													</div>
													<div class="col-sm-12  color-new-text mrg-T5">
														<?php if(!empty($val['owner'])) { ?>
														<?php switch($val['owner']){
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
                                                                                                                } ?>
													<?php } ?>
													</div>
													<div class="col-sm-12 color-new-text mrg-T5">
														<?php if(!empty($val['color'])) { ?>
														<!-- <span class="sprite icon-color1 mrg-R5"></span> -->
														<?php echo $val['color']; ?>
														<?php } ?>
													</div>
												</div>
											</div>                 
										</div>
									</div>
								</div>
							<?php 
                                                        if(!empty($val['version_id'])) {
                                                        $arrCarFeatures = $objGetcarFeature->getcarfeature($val['version_id']);
                                                        if(!empty($arrCarFeatures)) {?>
							<div class="col-sm-12 col-md-4 divheight203">
                                                        <div class="car-specs ">
                                                        <h5><strong>Features</strong></h5>
                                                        <div class=" row" style="line-height: 21px;">
							<?php 
                                                        $counter=0;
							foreach($arrCarFeatures as $key => $val){?>
							<div class="col-sm-6 color-new-text mrg-T5"><?php echo $val['value']; ?></div>
                                                        <?php $counter++;} ?>
                                                        </div>
		                                        </div>
                        				</div>
                                                        <?php } } ?>
							 </div>
							</div>
						</div>
				</li>
			 </ul>
			</div>
                        <?php $z++;} }?>
			
		  </div>
		
		  <!-- Controls -->
                  <?php if($totalFavourtiesCar>1){ ?>
		  <a class="left carousel-control" href="#carousel-fav-generic_<?php echo $requestData['number'] ?>" role="button" data-slide="prev">
			<i class="fa fa-angle-left" aria-hidden="true"></i>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-fav-generic_<?php echo $requestData['number'] ?>" role="button" data-slide="next">
			<i class="fa fa-angle-right" aria-hidden="true"></i>
			<span class="sr-only">Next</span>
		  </a>
                  <?php  } ?>
		</div>
	  	<?php } else { ?>
	  	<div class="text-center pad-T30 pad-B30">
                    Sorry no favourite car found.
                  
                </div>
	  	<?php } ?>
	  </div>
	</div>

                <?php }else {  //echo "vikas";//exit; //id="similar" class="tabcontent"  ?>
	<div id="similar" style="border: 1px solid #ccc;border-top: none;">
		<div class="row mrg-all-0">
			<div class="col-md-12 mrg-B5 mrg-T30">
				<div class="">
					<form name="recommFrm" id="recommFrm" class="recommFrm_<?php echo $requestData['number'] ?>">
                                            	
                                            <div class="col-md-1 font-16 width110"><div class='row pad-T10'>Requirements : </div></div>
                                            <div class="col-md-3">
                                                
							<div class="row">
								<div class="col-md-6 pad-R5">
									<select name="srh_budget" id="srh_budget_<?php echo $requestData['number'] ?>" class="form-control">
                                                                            <option value=''> Select Budget</option>                 
										<?php //$getbudgetList=getbudgetList();
          
           
                                                                                foreach($range as $minkey=>$val){
            	$select="";
				if((isset($requestData['srh_budget'])) && ($requestData['srh_budget'] == $val['key'])) {
					$select = "selected";
				}
        	?>
          <option value="<?php echo $val['key'];?>" <?php echo $select ?>><?php echo $val['value'];?></option>
            <?php } ?>
									</select>											
								</div>
								<div class="col-md-6 pad-L5">
									<select name="srh_fuel" id="srh_fuel_<?php echo $requestData['number'] ?>" class="form-control">
										<option value="">Fuel</option>
									<?php $arrFuel = array('Petrol' => 'Petrol', 'Diesel' => 'Diesel','CNG' => 'CNG','LPG' => 'LPG','Hybrid' => 'Hybrid','Electric' => 'Electric');
									 foreach($arrFuel as $key => $val) {
									 	$select="";
										if((isset($requestData['srh_fuel'])) && ($requestData['srh_fuel'] == $key)){
											$select = "selected";
										}
									 ?>
										<option value="<?php echo $key; ?>" <?php echo $select ?>><?php echo $val; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-3 pad-L5">
							<div class="row">
								<div class="col-md-5 pad-R5 pad-L5">
									<select class="form-control" name="srh_transmission" id="srh_transmission_<?php echo $requestData['number'] ?>">
										<option value="">Transmission</option>
										<?php $arrTransmission = array('Automatic' => 'Automatic', 'Manual' => 'Manual');
										foreach($arrTransmission as $key => $val) {
											$select="";
											if((isset($requestData['srh_transmission'])) && ($requestData['srh_transmission'] == $key)) {
												$select = "selected";
											}
										 ?>
										<option value="<?php echo $key; ?>" <?php echo $select ?>><?php echo $val; ?></option>
										<?php } ?>
									</select>
								</div>	
							<div class="col-md-7 pad-R5 pad-L5">  
							<?php $bodyTypeArr = array("Hatchback" => "Hatchback", "MUV" => "MUV", "MUV/Minivan" => "MUV/Minivan", "Sedan" => "Sedan", " Convertible" => "Convertible", "SUV" => "SUV","Two-Door" => "Two-Door", "Two-Door/Convertible" => "Two-Door/Convertible"); ?>
							<select class="form-control" name="srh_body_type[]" id="body_type_Select_<?php echo $requestData['number'] ?>" multiple="multiple">
                                <?php if(isset($bodyTypeArr) && !empty($bodyTypeArr)){                               	
									    foreach($bodyTypeArr as $key => $val){
									          $select = "";
									          if((isset($requestData['srh_body_type'])) && ($requestData['srh_body_type']==$key)){
									              $select = "selected";
									        }
									        echo '<option value="'.$key.'" '.$select.'>'.$val.'</option>';
									  } 

                                        }?>
                            </select>                                            										
								</div>
							</div>
						</div>
						<div class="col-md-2" >
							<div class="row">
								<?php 
								$drpDownMake = $objMake_model->getMake();
								$modelDrpDown = $objMake_model->getModels();
								$makeModelOptVal = '';
								if(isset($drpDownMake) && !empty($drpDownMake)){ 
								    foreach($drpDownMake as $key => $val){
								          $select = "";
								          $modelVal = 'mk_'.$val->id;
								          if((isset($requestData['srh_model'])) && ($requestData['srh_model']==$modelVal)){
								              $select = "selected";
								        }
								        $makeModelOptVal .= '<option value="'.$modelVal.'" '.$select.'>'.$val->make.'</option>';
								  } 
								}
								$modelOptVal = '';
								if(isset($modelDrpDown) && !empty($modelDrpDown)){ 
								    foreach($modelDrpDown as $modelKey => $modelVal){
								          $select = "";
								          if((isset($requestData['srh_model'])) && ($requestData['srh_model']==$modelVal->id)){
								              $select = "selected";
								        }
								        $modelOptVal .= '<option value="'.$modelVal->id.'" '.$select.'>'. $modelVal->make." ".$modelVal->model.'</option>';
								  } 
								}
								?>				
								
									<div id="modelCustom-ctn" class="clearfix slctionBox" style="display: none"></div>
									<select class="form-control" name="srh_model[]" id="model_Select_<?php echo $requestData['number'] ?>" multiple="multiple">
                                    <?php if(isset($drpDownMake) && !empty($drpDownMake)){ 
                                            echo $makeModelOptVal; }?>
                                    <?php if(isset($modelDrpDown) && !empty($modelDrpDown)){ 
                                            echo $modelOptVal; }?>                                                            
                                                            </select>   
								
							</div>
						</div>
						<div class="col-md-2 pad-10">
							<div class="row">
								<div class="col-md-12 pad-L5 pad-R5">
									<button class="btn btn-primary mrg-T0" id="updaterequirements"  onclick="return getRecomCar('test')">UPDATE REQUIREMENTS</button>
								</div>
							</div>
						</div>
						
						
					</form>
				</div>
			</div>
		</div>
		<!--recom -->
	  <div id="carousel-example-generic_<?php echo $requestData['number'] ?>" class="carousel slide" data-ride="carousel">
		  
		</div>
		<!--recomm-->
	</div>
                            <?php } ?>
</div>
</div>



<script>
var mobile = <?php echo $requestData['number'] ?>;
var leadId = <?php echo $requestData['leadId']; ?>;
var strBody = '<?php echo $requestData['bodyType']; ?>';
//alert(strBody);
var modelContainerStr = '';
var strSrhModelArr = '';
<?php 
$searchModelArray = array();
if(!empty($requestData['makeIds'])) {
	$arrMakeReq = explode(",", $requestData['makeIds']);
	foreach($arrMakeReq as $key => $val) {
		$searchModelArray[] = 'mk_'.$val;
	}
}
if(!empty($requestData['modelIds'])) {
	$arrModelReq = explode(",", $requestData['modelIds']);
	foreach($arrModelReq as $key => $val) {
		$searchModelArray[] = $val;
	}
}
if(isset($searchModelArray) && !empty($searchModelArray)){  
	foreach($searchModelArray as $key => $val) { ?>
	    optionVal = $("#model_Select option[value='<?php echo $val; ?>']").text();  
	    modelContainerStr = modelContainerStr + '<div class="modelText" id="modelTextId<?php echo $val; ?>"><div>'+optionVal+'</div><span class="remove-model" onclick=removeModelSel("<?php echo $val; ?>")></span></div>';
	<?php } ?> 
strSrhModelArr = '<?php echo implode(',',$searchModelArray); ?>';
<?php } ?>
 
$(document).ready(function() {
   // $(document).on('multiselect', '#model_Select_'+mobile, function (ev) {
	$('#model_Select_'+mobile).multiselect({
	    nonSelectedText: 'Make Model',
	    enableFiltering: true,
            numberDisplayed: 3,
	    enableCaseInsensitiveFiltering: true,
	    buttonContainer: '<div class="model-btn-group btn-group" />',
	    onChange: function(option, checked) {                            
	        if(checked) {
	            var str = '<div class="modelText" id="modelTextId'+$(option).val()+'"><div>'+$(option).text()+'</div><span class="remove-model" onclick=removeModelSel("'+$(option).val()+'")></span></div>';
	            if($('#modelCustom-ctn').is(':hidden')) {
	                //$('#modelCustom-ctn').show();
	            }
	            $('#modelCustom-ctn').append(str); 
	        } else {
	            $('#modelTextId'+$(option).val()).remove();
	            if(!$('#modelCustom-ctn').find('.modelText').length) {
	                if($('#modelCustom-ctn').is(':visible')) {
	                    $('#modelCustom-ctn').hide();
	                }
	            }
	        }
	    }
	});
	if(modelContainerStr != '') {
	    $('#modelCustom-ctn').html(modelContainerStr);
	}
	if(strSrhModelArr != '') {  
	    multiSelectCheck('model_Select_'+mobile,strSrhModelArr); 
	}                    
	if($('#modelCustom-ctn').find('.modelText').length) {
	    //$('#modelCustom-ctn').show();
	} else {
	   $('#modelCustom-ctn').hide(); 
	}
    $('#body_type_Select_'+mobile).multiselect({
        nonSelectedText: 'Body Type',
        numberDisplayed: 2
    });
    if(strBody != '') {
        multiSelectCheck('body_type_Select_'+mobile,strBody);
    }
}); 
//getRecomCar();         
</script>