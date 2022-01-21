<?php

 //ini_set("display_errors", "1");
 // error_reporting(E_ALL);
if(!$type){
    $dealerStock    =$getDealerCar;
    if($dealerStock){
        $response=array();
        $i=0;
        foreach ($dealerStock as $key=>$value){
            $response[$i]['id']           =$value['car_id'];
            $response[$i]['value']        =$value['make'].' '.$value['model'].' '.$value['carversion'].' ( '.$value['regno'].')';
            $carImage                     =$objbuyer->getUsedCarImages($value['car_id']);
            $response[$i]['html']         =getstockHtml($value,$carImage);
            $i++;
        }
    }
    else{
         $response[0]['value']        ='Sorry no car found.';
    }
    echo json_encode($response);die;
}
switch ($type) {
    case 'savestatus':
        echo updateStatus($_POST);exit;
        exit;
        break;
    case 'getfeedback':
        echo getFeedback($_POST,$objbuyer);exit;
        exit;
        break;
    case 'getbookingoffer':
        echo getBookAmountHtml($_POST,$objbuyer);exit;
        exit;
        break;
}
function updateoldStatus($post) {
    $datapost=array();
    if($post['status']){
    //$datapost[status]=$objbuyer->mapp_new_to_old($post['status']);
        $datapost[status]=$post['status'];
    }
    $dealerId=$_SESSION['ses_used_car_dealer_id'];
    $datapost[txtMobile]=$post['mobile'];
    
    
    if($post['feedback']){
        $feedBackArray      = explode('$',$post['feedback']);
        $datapost['feedback_id']=$feedBackArray[0];
        $datapost['comment']   =mysql_real_escape_string($feedBackArray[1]);
    }
    if($datapost['comment'] && $post['comment']){
        $datapost['comment']   .= ' | '.mysql_real_escape_string($post['comment']);  
        }
        else {
        $datapost['comment']    = mysql_real_escape_string($post['comment']);
        }
        $post['follow_up']          =date("Y-m-d H:i:s",strtotime($post['follow_up']));
        $datapost['followup_date']        = $post['follow_up'];
        $buyerEnquiry = new buyerEnquiry();
        $buyerEnquiry->savecustomerLead($datapost, $dealerId);
         return 1;
}

function updateStatus($post) {
    $oldupdatestatus=updateoldStatus($post);
    if($post['status']=='Booked'){
     $data['booking_amount']        = $post['offer'];
    }
    else if ($post['status']=='Customer Offer'){
     $data['offer_amount']          = $post['offer'];
    }
    else if ($post['status']=='Converted'){
    $data['sale_amount']            = $post['offer'];
    }
   
    $data['mobile']                 = $post['mobile'];
    $data['ucdid']                  = $_SESSION['ses_used_car_dealer_id'];
    $data['source']                 = 'SELF';
    $data['lead_source']            = 'SELF';
    $data['rating']                 = $post['rating'];
    $data['lead_status']            = $post['status'];
    $data['car_id']                 = $post['car_id'];
    //$data['APP_VERSION']            = 58;
    if($post['feedback']){
        $feedBackArray      = explode('$',$post['feedback']);
        $data['feedback_id']=$feedBackArray[0];
        $data['comment']   =mysql_real_escape_string($feedBackArray[1]);
    }
    if($data['comment'] && $post['comment']){
        $data['comment']   .= ' | '.mysql_real_escape_string($post['comment']);  
        }
        else if ($data['comment']){
        }
        else {
        $data['comment']    = mysql_real_escape_string($post['comment']);
        }
        
    //$data['feedback']               = mysql_real_escape_string($post['feedback']);
    if ($post['status'] == 'Walk In') {
        if($post['follow_up']){
           $post['follow_up']=date("Y-m-d H:i:s",strtotime($post['follow_up']));
        }
         if($post['reminder_date']){
           $post['reminder_date']=date("Y-m-d H:i:s",strtotime($post['reminder_date']));
        }
        $data['walkinDate']         = $post['follow_up'];
        $data['next_follow']        = $post['reminder_date'];
    } else {
        $post['follow_up']          =date("Y-m-d H:i:s",strtotime($post['follow_up']));
        $data['next_follow']        = $post['follow_up'];
    }
  //print_r($data);exit;
    $objbuyer = new GcloudAppBuyer();
    $result = $objbuyer->addeditLeads($data);
   
    return 1;
}

function getFeedback($post,$objbuyer) {
    $currentStatus = $post['status'];
    $lastStatus = $post['lastStatus'];
    if ($currentStatus == 'Walk-in Done') {
        $feedBackOptions= $objbuyer->getAllFeedBack(3);
        $response = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="'.BASE_HREF.'images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">What happened during Walk in?</h4>
      </div>
      <style>
        .modal label {
            margin-bottom: 10px !important;
            color: #000;
            opacity: 0.87;
            font-size: 14px;
            font-weight: 500 !important;
        }
      </style>
      <div class="modal-body pad-T25 pad-B0">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B20 font-14 text-999">
				Select what happened during walk in:
			</div>
			<div class="row">
                        '.renderFeedbackOptions($feedBackOptions).'
                                 <div class=" mrg-T15 font-14" id="show_comment" style="display:none;">
                                        <span class="text-999">Add Comment</span>
					<span class="">
                                        <textarea name="comment_feedback" id="comment_feedback" maxlength="200"  placeholder="Add Comment" rows="3" class="form-control mrg-T10 mrg-B5" style="height: 60px !important;"></textarea>
                    			</span>	
				</div>
				</div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5">
		  	
		  </div>         
      </div>
      <div class="modal-footer text-left" id="editpopup1">
		<button type="button" class="btn btn-primary"  id="saveFeedback">SAVE</button>
      </div>
    ';
    } else if ($currentStatus == 'Closed' && in_array($lastStatus,array('New','Follow Up','Interested'))) { //
        $feedBackOptions= $objbuyer->getAllFeedBack(1);
        $response = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="'.BASE_HREF.'images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Reason for closing the lead</h4>
      </div>
      <div class="modal-body">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B10">
				Select what happened during process:
			</div>
			<div class="row">
				'.renderFeedbackOptions($feedBackOptions).'
                                <div class="mrg-T10" id="show_comment" style="display:none;">
                                        Other
					<span class="mrg-R20">
                                        <textarea name="comment_feedback" id="comment_feedback" maxlength="200"  placeholder="Add Comment" rows="3" class="form-control "></textarea>
					</span>	
				</div>
                               
				</div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5">
		  	
		  </div>         
      </div>
      <div class="modal-footer pad-T0 text-left">
		<button type="button" class="btn btn-primary"  id="saveFeedback">Save</button>
      </div>
    ';
    } else {
        $feedBackOptions= $objbuyer->getAllFeedBack(2);
        $response = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="'.BASE_HREF.'images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Why did Customer change his mind?</h4>
      </div>
      <div class="modal-body pad-T30 pad-B0">
	 	<div class="col-md-12 clearfix">
		  	<div class="row pad-B10 font-14 text-999">
				Select what happened during process:
			</div>
			<div class="row">
				'.renderFeedbackOptions($feedBackOptions).'
                                <div class="mrg-T15 text-999" id="show_comment" style="display:none;">
                                        Add Comment
					<span class="mrg-R20">
                                        <textarea name="comment_feedback" id="comment_feedback" style="height: 60px !important;" placeholder="Add Comment" rows="3" class="form-control mrg-T10"></textarea>
					</span>	
				</div>
                                
				</div>
			</div>
		  </div> 
		  <div class="clearfix pad-T5">
		  	
		  </div>         
      </div>
      <div class="modal-footer text-left">
		  <button type="button" class="btn btn-primary"  id="saveFeedback">SAVE</button>
      </div>
    ';
    }

    return $response;
}
function renderFeedbackOptions($feedBackOptions){
    $options='';
    if($feedBackOptions){
        foreach ($feedBackOptions as $key=>$val){
        $class='';
        if(strtolower($val->feedback_text)=='other'){
            $class='show_comment_area';
        }
        $options .= '<div class="">
                        <span class="mrg-R20">
                        <input type="radio" class="'.$class.'" name="feedback_answer" id="'.$key.'" value="'.$val->id.'$'.$val->feedback_text.'"><label for="'.$key.'"><span></span>'.$val->feedback_text.'</label>
                        </span>	
                    </div>';    
        }
    }
    return $options;
}
function getBookAmountHtml($post,$objbuyer) {
    $favorite='';
    if($post['lead_id']) {
        $dataarray=array();
        $favorite=$objbuyer->getLeadFavoriteCar($post['lead_id']);
    }
    if($post['status']=='Booked'){
        //$text='Booking Done';
        $text='Select the car '.($post[customer_name]!=''?$post[customer_name]:'Customer').' has booked';
        $inputText='Booking';
    }else if ($post['status']=='Customer Offer'){
        //$text='Offer Done';
        $text='Select the car '.($post[customer_name]!=''?$post[customer_name]:'Customer').' has given offer on';
        $inputText='Offer';
    }
    else if ($post['status']=='Converted'){
        //$text='Sale Done';
         $text='Select the car '.($post[customer_name]!=''?$post[customer_name]:'Customer').' has bought';
        $inputText='Sale';
    }
    $response = '<div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="'.BASE_HREF.'images/cancel.png"><span class="sr-only">Close</span></button>
        <h4 class="modal-title">'.$text.'</h4>
        <div class="text-header-new">*You can select only one car</div>
      </div>
      <div class="pad-all-15 pad-T15 pad-B15" style="display:inline-block; width:100%;">
	  	<div role="tabpanel">
			<ul class="nav nav-tabs similartabs" role="tablist">
                        <input type="hidden" name="status_amount" id="status_amount" value="'.$post['status'].'"/>';
                            if($favorite){
                            $response .='<li class="active"><a href="#faves" aria-controls="faves" role="tab" data-toggle="tab" class="stock-in">Favourites</a></li>
                                        <li><a href="#stock-in" aria-controls="stock-in" role="tab" data-toggle="tab" class="stock-in">Stock</a></li>
                                        </ul>
                                        <div class="tab-content">';
                            }
                            else {
                            $response .='<li class="active"><a href="#stock-in" aria-controls="stock-in" role="tab" data-toggle="tab" class="stock-in">Stock</a></li>
                                        </ul>
                                        <div class="tab-content">';
                            }
    $fav='active';
    if($favorite){
    $favoriteHtml           =getFavoriteHtml($favorite,$inputText,$objbuyer);
    $response              .= $favoriteHtml;
    $fav='';
    }
    $response .='<div role="tabpanel" class="tab-pane '.$fav.'" id="stock-in">
					<div class="clearfix pad-T15 pad-B0">
						<div class="row">
							<div class="col-md-12">
								<input type="text" class="input-lg form-control ic-search edit-lead-name mrg-B15 searchmakemodellive" placeholder="Search Make Model here">
								<div id="carousel-example-generic3" class="carousel slide" data-ride="carousel">
							   <div class="carousel-inner" id="new-buyerlead2" role="listbox" style=" text-align: left; border: 1px solid #eee; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);  border-radius: 5px;">
							  <div class="item active">
									
								  <ul class="list-unstyled car-list" id="stockHtml">
									<li class="">
										<div class="clearfix " style="position:relative; width:100%">
											<div class="col-md-12">
												<div class="img-box clearfix"  data-toggle="modal" data-target="#model-uploadPhoto">
													<!--<a href="#"> <div  class="img_thumb"></div></a>-->
													
												</div>
												
												
												
											</div>

                      <div class="col-md-12">
                        <div class="car-specs">
                          <div class="row list-icon" id="pref-avail">
                          <h2 class="carname mrg-T15"></h2>
                          <div class="text-center" style="width:100%">
                          <img src="images/stock.png">
                          <div class="font-16 col-black mrg-T30 mrg-B30">No Car Available</div>
                          </div>
                          </div>
                          <div class="row mrg-T5">
                            <div class="col-black font-20 text-bold"></div>
                          </div>                          

                        </div>
											<div class="col-md-12">
												<!--<div class="car-specs">
													<div class="row list-icon" id="pref-avail">
														<ul>
															<li> </li>
														</ul>
													</div>
												</div>-->
												<div class="row mrg-T20">
													<div class="col-md-12">
														<!--<div class="row">
															<div class="col-md-3 pad-R0">
																<div class="font-14 col-black line-hit-35">Enter Amount</div>
															</div>
															<div class="col-md-6 pad-L0">
															 <input type="text" class="form-control rupee" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordc_'.$val['car_id'].'.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="wordc_'.$val['car_id'].'" class="price-text" style="clear:both;"></div>														</div>	
													
														</div>-->
													</div>													
												</div>
											</div>
											</div>
									</li>
									
								 </ul>
								</div>
              </div>
							
							 
							</div>
							</div>
						</div>           
					</div>

				</div>
        <div class="">
              <div class="mrg-T15">
                  <button type="button" class="btn btn-primary btn-popup" id="saveofferstatus" style="width:100%">SAVE</button>
              </div>
            </div> 

			</div>

		</div>
				
                   
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Back</button>
        
      </div>-->
     
';
    return $response;
}

function getFavoriteHtml($favorite,$inputText,$objbuyer) {
    $total=count($favorite);
    $response = '<div role="tabpanel" class="tab-pane active" id="faves">
					
					<div class="clearfix pad-B0">
						<div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
							  <div class="carousel-inner" id="new-buyerlead2" role="listbox" style="text-align:left; border:1px solid #eee; border-radius:5px; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);">';
                                         $counter=0;
                                         foreach($favorite as $key => $val) { 
                                         $price =historyTrack::no_to_words($val['price']);
                                         $active=($counter==0)?'active':'';
                                         $img=$objbuyer->getUsedCarImages($val['car_id']);
                                         $km=historyTrack::formatInIndianStyle($val['km']);
                                         $response .='<div class="item '.$active.'">
									<ul class="list-unstyled car-list">
									<li class="">
                                                                        <input type="hidden" id="amount_car_'.$val['car_id'].'" name="amount_car_'.$val['car_id'].'" value="'.$val[price].'" />
                                        <span class="check-bxnew">
                                        <input type="radio" class="selectoffercar" name="select_car_offer" value="'.$val['car_id'].'" id="'.$val['car_id'].'"><label for="'.$val['car_id'].'"><span></span></label>
                                        </span>
										<div class="clearfix " style="position:relative;">
											<div class="col-md-6">
												<div class="img-box clearfix"  data-toggle="modal" data-target="#model-uploadPhoto">
													<a href="#"> <div  class="img_thumb"><img src="'.$img.'" class="img-responsive"></div></a>
													
												</div>
												
												
											</div>
											<div class="col-md-6">
												<div class="car-specs">
													<div class="row list-icon" id="pref-avail">
                                        <h2 class="carname">'.$val['make'] . " " . $val['model'] . " " . $val['version'].'<a></a></h2>
													</div>
                          <div class="row mrg-T5">
                            <div class="col-black font-20 text-bold"><i class="fa fa-inr" aria-hidden="true"></i> '.$price.'</div>
                          </div>														

												</div>	

												<!--<div class="row mrg-T20">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-3 pad-R0">
																<div class="font-14 col-black line-hit-35">'.$inputText.' Amount</div>
															</div>
															<div class="col-md-6 pad-L0">
															 <input type="text" class="form-control rupee" id="amount_'.$val['car_id'].'" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordd_'.$val['car_id'].'.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="wordd_'.$val['car_id'].'" class="price-text" style="clear:both;"></div>														</div>	
													
														</div>
													</div>													
												</div>-->
											</div>
                      <div class="col-md-12">
                        <div class="details-car font-14">
                          <ul>
                              <li> <span>'.$km.'&nbsp;kms</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> '.$val['year'].'</span>  <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> '.$val['fuel_type'].'</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> '.$val['regno'].'</span></li>
                            </ul>
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mrg-T15 booking-amt mrg-B10">
                            <label>'.$inputText.' Amount</label>
                               <input type="text" class="form-control rupee" id="amount_'.$val['car_id'].'" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordv_'.$val['car_id'].'.innerHTML=convertNumberToWords(this.value);" maxlength="9">
                                   <div id="wordv_'.$val['car_id'].'" class="price-text" style="clear:both;"></div>
                              </div>
                        </div>

											</div>
									</li>
									
								 </ul>
								</div>';
                                         $counter++;
                                         }
                                         
						$response .='</div>';
							if($total>1){
							  $response .='<a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev" style="top: 50%; width:5%; left:-45px;">
								<i class="fa fa-angle-left" aria-hidden="true"></i>
								<span class="sr-only">Previous</span>
							  </a>
							  <a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next" style="top: 50%; width:5%;right: -35px;">
								<i class="fa fa-angle-right" aria-hidden="true"></i>
								<span class="sr-only">Next</span>
							  </a>';
                                                        }
							$response .='</div>
					</div>
				</div>';
    return $response;
}


function getstockHtml($val,$carImage){
$priceFilter=  str_replace(",","",$val['price']);
$price =historyTrack::no_to_words($priceFilter);
$response=' <li class="">
        <span class="check-bxnew">
          <input type="hidden" name="amount_car_'.$val['car_id'].'" id="amount_car_'.$val['car_id'].'" value="'.$priceFilter.'" />
          <input type="radio"  class="selectoffercar" checked name="select_car_offer" value="'.$val['car_id'].'" id="'.$val['car_id'].'"><label for="'.$val['car_id'].'"><span></span></label>
          </span>
                <div class="clearfix " style="position:relative;">
                        <div class="col-md-6">
                                <div class="img-box clearfix"  data-toggle="modal" data-target="#model-uploadPhoto">
                                        <a href="#"> <div  class="img_thumb"><img src="'.$carImage.'" class="img-responsive"></div></a>

                                </div>

                                
                        </div>

                        <div class="col-md-6">
                        <div class="car-specs">
                          <div class="row list-icon" id="pref-avail">
                          <h2 class="carname">'.$val['make'] . " " . $val['model'] . " " . $val['version'].'<a></a></h2>
                          </div>
                          <div class="row mrg-T5">
                            <div class="col-black font-20 text-bold"><i class="fa fa-inr" aria-hidden="true"></i> '.$price.'</div>
                          </div>                            

                        </div>  

                        <div class="col-md-12">
                                <!--<div class="car-specs">
                                        <div class="row list-icon" id="pref-avail">
                                                <ul>
                                                        <li> <span>'.$price.',</span>  <span>'.$val['fuel_type'].',</span> <span>'.$val['transmission'].'</span></li>
                                                </ul>
                                        </div>														

                                </div>-->	
                                <!--<div class="row mrg-T20">
                                        <div class="col-md-12">
                                                <div class="row">
                                                        <div class="col-md-3 pad-R0">
                                                                <div class="font-14 col-black line-hit-35">Enter Amount</div>
                                                        </div>
                                                        <div class="col-md-6 pad-L0">
                                                         <input type="text" class="form-control rupee" id="amount_'.$val['car_id'].'" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="wordm_'.$val['car_id'].'.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="wordm_'.$val['car_id'].'" class="price-text" style="clear:both;"></div>
                                                        </div>	

                                                </div>
                                        </div>													
                                </div>-->
                        </div>

                        </div>
                        <div class="col-md-12">
                        <div class="details-car font-14">
                          <ul>
                              <li> <span>'.$val['Kms'].'&nbsp;kms</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> '.$val['myear'].'</span>  <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> '.$val['fuel_type'].'</span> <span> <i class="fa fa-circle col-dot" aria-hidden="true"></i> '.$val['regno'].'</span></li>
                            </ul>
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="mrg-T15 booking-amt mrg-B15">
                            <label>Enter Amount</label>
                               <input type="text" class="form-control rupee" id="amount_'.$val['car_id'].'" placeholder="Enter Amount"  onkeypress="return forceNumber(event);"  onkeyup="worda_'.$val['car_id'].'.innerHTML=convertNumberToWords(this.value);" maxlength="9">
<div id="worda_'.$val['car_id'].'" class="price-text" style="clear:both;"></div>
                              </div>
                        </div>

                      </div>
        </li>';

return $response;
}



