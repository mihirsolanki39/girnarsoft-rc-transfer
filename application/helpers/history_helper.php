<?php
function renderHistoryHTMLFinal($historyData){
    //echo '<pre>';print_r($historyData);die;
    $finalHtml='<div class="comment-wrap  mCustomScrollbar"  data-mcs-theme="dark" id="add_Comment_buyerL" style="overflow-y:scroll; height:390px;"><ul class="timeline">';
    
    foreach ($historyData as $key=>$outerval){
        $finalHtml .='<li><div class="timeline-badge"></div><div class="timeline-panel modal-padding "><div class="timeline-heading border-BL clearfix">';
       $html=renderDateDiv($outerval['datetime']) ;
       $finalHtml .=$html;
       $finalHtml  .='<div class="edit-secL width80">';
       if(isset($outerval['call'])){
       $html=renderCallDiv($outerval['call']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['status_change'])){
       $html=renderStatusDiv($outerval['status_change']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['feedback'])){
       $html=renderFeedbackDiv($outerval['feedback']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['comment'])){
       $html=renderCommentDiv($outerval['comment']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['share'])){
       $html=renderShareDiv($outerval['share']) ;
       $finalHtml .=$html;
       }
       $finalHtml .='</div>';
       $finalHtml .=' </div></div></li>';
    }
     $finalHtml .='</ul></div>';
     return $finalHtml;
}
function renderFeedbackDiv($data){
    if($data){
    return '<p class="">Feedback: '.stripslashes($data).'</p> ';
    }
}
   function formatTotalTalkTime($seconds){
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds / 60) % 60);
            $seconds = $seconds % 60;
            return $hours > 0 ? "$hours h, $minutes m" : ($minutes > 0 ? "$minutes m, $seconds s" : "$seconds s");

    }
function renderCommentDiv($data){
     if($data){
    return '<p class="">Comment: '.stripslashes($data['comment_text']).'</p> ';
     }
}
function renderCallDiv($data){
     if($data){
    if(strtolower($data['type'])=='incoming'){
    return '<h4 class="timeline-title"><i class="fa fa-phone pad-R5" aria-hidden="true"></i> Call ('.$data['duration'].') <span class="float-R"><img src="'.ASSET_PATH.'boot_origin_asset_new/images/incoming.png" alt="missed-call" /></span></h4>';
    }
    else if(strtolower($data['type'])=='outgoing'){
    return '<h4 class="timeline-title"><i class="fa fa-phone pad-R5" aria-hidden="true"></i> Call ('.$data['duration'].') <span class="float-R"><img src="'.ASSET_PATH.'boot_origin_asset_new/images/call-outgoing.png" alt="missed-call" /></span></h4>';
    }
    else if (strtolower($data['type'])=='missed'){
          return '<h4 class="timeline-title"><i class="fa fa-phone pad-R5" aria-hidden="true"></i> Missed Call <span class="float-R"><img src="'.ASSET_PATH.'boot_origin_asset_new/images/missed.png" alt="missed-call" /></span></h4>';

    }
     }
}
function renderShareDiv($data){
     if($data){
         
    if(strtolower($data['shared_by'])=='whatsapp'){
    return '<p class="edit-sec">'.$data['shared_item'].' <span class="float-R"> <img src="'.base_url('assets/admin_assets/images/whatsapp.png').'" alt="whatsaap" width="21px" /></span></p>';
    }
    else if(strtolower($data['shared_by'])=='email')
    {
     return '<p class="edit-sec">'.$data['shared_item'].' <span class="float-R"> <img src="'.base_url('assets/admin_assets/images/gmail.png').'" alt="gmail" /></span></p> ';   
    }
     else if(strtolower($data['shared_by'])=='sms')
    {
     return '<p class="edit-sec">'.$data['shared_item'].' <span class="float-R"> <img src="'.base_url('assets/admin_assets/images/sms.png').'" alt="Sms" width="21px" /></span></p> ';   
    }
     }
}
function renderStatusDiv($data){
    $html='';
     if($data){
   $html   .='<h4 class="timeline-title">'.$data['status_text'].'</h4>';
   if($data['status_text']=='Booked')
   {
   $html   .='<p class="">Booking amount <span><i class="fa fa-inr font-13" aria-hidden="true"></i></span>'.formatInIndianStyle($data['booking_amount']).'</p>';
   }
   else if($data['status_text']=='Customer Offer')
   {
   $html   .='<p class="">Offer amount <span><i class="fa fa-inr font-13" aria-hidden="true"></i></span>'.formatInIndianStyle($data['offer_amount']).'</p>';
   }
   else if($data['status_text']=='Converted')
   {
   $html   .='<p class="">Sale amount <span><i class="fa fa-inr font-13" aria-hidden="true"></i></span>'.formatInIndianStyle($data['sale_amount']).'</p>';
   }
   return $html;
     }
}
function renderDateDiv($data){
     if($data){
    $time=strtotime($data);
    $day=date("M d",$time);
    $time=date("g:i A",$time);
   return '<div class=" edit-secL width20"><h4 class="timeline-title">'.$day.'</h4><p class="">'.$time.'</p></div>'; 
     }
}
function renderHistoryHTMLRCFinal($historyData){
  //echo '<pre>';print_r($historyData);die; 
   $finalHtml='<div class="col-sm-12 sidenav hisrcBack" id="hisfeedBack"><ul class="par-ul">';
   foreach ($historyData as $key=>$outerval){
       $finalHtml .='<li class="side_nav"><div class="col-sm-4"> <a href="#" class="sidenav-a ">';
       $html=renderDateDivRc($outerval['created_on']) ;
       $finalHtml .=$html;
       $finalHtml  .='</small></a></div>';
       $finalHtml .='<div class="col-sm-4 side_text"><span class="active_text">';
       $finalHtml .= $outerval['activity'];
       $finalHtml .='</span></div>';
       $finalHtml .='<div class="col-sm-4"><span class="Detail_text">';
       $finalHtml .= (!empty($outerval['created_name'])) ? ucwords($outerval['created_name']) : '';
       $finalHtml .='</span></div></li>';
   }
   $finalHtml .='</ul></div>';
   return $finalHtml;  
}
function renderHistoryRenewHTMLFinal($historyData){
    //echo '<pre>';print_r($historyData);die;
    $finalHtml='<div class="comment-wrap  mCustomScrollbar"  data-mcs-theme="dark" id="add_Comment_buyerL" style="overflow-y:scroll; height:390px;"><ul class="timeline">';
    $statusArr=[];
    foreach ($historyData as $key=>$outerval){
        $status=!empty($outerval['status']) ? $outerval['status']:'';
        //print_r($statusArr);
        if(in_array($status,$statusArr)){
            $status='';
        }else{
            $status=$status;
        }
        $finalHtml .='<li><div class="timeline-badge"></div><div class="timeline-panel modal-padding "><div class="timeline-heading border-BL clearfix">';
       $html=renderDateDiv($outerval['datetime']) ;
       $finalHtml .=$html;
       $finalHtml  .='<div class="edit-secL width80">';
       if(isset($outerval['status'])){
       $html='<h4 class="timeline-title">'.$status.'</h4>';
       $finalHtml .=$html;
       }
       if(!empty($outerval['activity_text'])){
       $html='<p class="">Comment: '.stripslashes($outerval['activity_text']).'</p> ';
       $finalHtml .=$html;
       }
       $finalHtml .='</div>';
       $finalHtml .=' </div></div></li>';
       $statusArr[].=$status;
    }
     $finalHtml .='</ul></div>';
     return $finalHtml;
}
function renderRenewStatusDiv($status){
    $html='';
     if($status){
   $html   .='<h4 class="timeline-title">'.$status.'</h4>';
   return $html;
     }
}

if(!function_exists('formatInIndianStyle')){      
function formatInIndianStyle($num) {
        $pos = strpos((string) $num, ".");
        if ($pos === false) {
            $decimalpart = "";
        } else {
            $decimalpart = "." . substr($num, $pos + 1, 2);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 3 & strlen($num) <= 12) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3);
            $formatted = makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . $decimalpart;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . $decimalpart;
        } elseif (strlen($num) > 12) {
            $stringtoreturn = number_format($num, 2);
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }

        return $stringtoreturn;
    }
}
    function makecomma($input) {
        if (strlen($input) <= 2) {
            return $input;
        }
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }
    
    function renderDateDivRc($data){
     if($data){
     $time=strtotime($data);
     $day=date("M d",$time);
     $time=date("g:i A",$time);
     return '<span class="img-type"></span>'.$day .' <small>'.$time.'</small>'; 
     }
    }
