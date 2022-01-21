<?php
function renderHistoryHTMLFinaltimeline($historyData,$renewhistoryData=''){
   //echo '<pre>';print_r($historyData);die; 
   $finalHtml='<div class="col-sm-12 sidenav"><ul class="par-ul">';
   foreach ($historyData as $key=>$outerval){
       $finalHtml .='<li class="side_nav">
            
                <div class="col-md-12 border-B">
                <div class="row">
                    <div class="col-sm-4">
                <a href="#" class="sidenav-a">
                <span class="img-type"></span>'.date('jS M',strtotime($outerval['created_date'])).'<small>'.date('h:i A', strtotime($outerval['created_date'])).'</small>
                </a>
            </div>';
       if($outerval['source']=='not_interested'){
        $finalHtml .='<div class="col-sm-4 side_text">
                <span class="active_text">Not Interested</span>
                <span class="Detail_text">'.(!empty($outerval['activity_text'])?$outerval['activity_text']:'').'</span>
            </div>';   
       }
       else if($outerval['source']=='policy_cancel'){
        $finalHtml .='<div class="col-sm-4 side_text">
                <span class="active_text">Policy Cancelled</span>
                <span class="Detail_text">'.(!empty($outerval['activity_text'])?$outerval['activity_text']:'').'</span>
            </div>';   
       }else{
            $finalHtml .='<div class="col-sm-4 side_text">
                <span class="active_text">'.$outerval['activity_text'].'</span>
                <span class="Detail_text">'.(!empty($outerval['short_name'])?$outerval['short_name']:'').'</span>
            </div>';
          }  
            $finalHtml .='<div class="col-sm-4">
                <span class="Detail_text mrg-T15">'.(!empty($outerval['name'])?$outerval['name']:'').'</span>
            </div>
                </div>
            </div>
        </li>';
       
       
   }
   if(!empty($renewhistoryData)){
   foreach ($renewhistoryData as $key=>$outervall){ 
   $finalHtml .='<li class="side_nav">
            
                <div class="col-md-12 border-B">
                <div class="row">
                    <div class="col-sm-4">
                <a href="#" class="sidenav-a">
                <span class="img-type"></span>'.date('jS M',strtotime($outervall['datetime'])).'<small>'.date('h:i A', strtotime($outervall['datetime'])).'</small>
                </a>
            </div>';
   if(isset($outervall['status'])){
       $finalHtml .='<div class="col-sm-4 side_text">
                <span class="active_text">'.$outervall['status'].'</span>
                </div>';
       }
   }
   }
   $finalHtml .='</ul></div>';
  /* if(!empty($renewhistoryData)){
       $finalHtml.='<div class="comment-wrap  mCustomScrollbar"  data-mcs-theme="dark" id="add_Comment_buyerL" style="overflow-y:scroll; height:390px;"><ul class="timeline">';
    
    foreach ($renewhistoryData as $key=>$outerval){
        $status=!empty($outerval['status']) ? $outerval['status']:'';
        $finalHtml .='<li><div class="timeline-badge"></div><div class="timeline-panel modal-padding "><div class="timeline-heading border-BL clearfix">';
       $html=renderDateDiv($outerval['datetime']) ;
       $finalHtml .=$html;
       $finalHtml  .='<div class="edit-secL width80">';
       if(isset($outerval['status'])){
       $html='<h4 class="timeline-title">'.$status.'</h4>';
       $finalHtml .=$html;
       }
       if(isset($outerval['activity_text'])){
       $html='<p class="">Comment: '.stripslashes($outerval['activity_text']).'</p> ';
       $finalHtml .=$html;
       }
       $finalHtml .='</div>';
       $finalHtml .=' </div></div></li>';
    }
     $finalHtml .='</ul></div>';
   }*/
   return $finalHtml;
   
}
function renderHistoryHTMLFinal1($historyData){
    //echo '<pre>';print_r($historyData);die;
    $finalHtml='<div class="comment-wrap  mCustomScrollbar"  data-mcs-theme="dark" id="add_Comment_buyerL" style="overflow-y:scroll; height:390px;"><ul class="timeline">';
    
    foreach ($historyData as $key=>$outerval){
        $finalHtml .='<li><div class="timeline-badge"></div><div class="timeline-panel modal-padding "><div class="timeline-heading border-BL clearfix">';
       $html=renderDateDivtime($outerval['datetime']) ;
       $finalHtml .=$html;
       $finalHtml  .='<div class="edit-secL width80">';
       if(isset($outerval['call'])){
       $html=renderCallDivtime($outerval['call']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['status_change'])){
       $html=renderStatusDivtime($outerval['status_change']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['feedback'])){
       $html=renderFeedbackDivtime($outerval['feedback']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['comment'])){
       $html=renderCommentDivtime($outerval['comment']) ;
       $finalHtml .=$html;
       }
       if(isset($outerval['share'])){
       $html=renderShareDivtime($outerval['share']) ;
       $finalHtml .=$html;
       }
       $finalHtml .='</div>';
       $finalHtml .=' </div></div></li>';
    }
     $finalHtml .='</ul></div>';
     return $finalHtml;
}
function renderFeedbackDivtime($data){
    if($data){
    return '<p class="">Feedback: '.stripslashes($data).'</p> ';
    }
}
function renderCommentDivtime($data){
     if($data){
    return '<p class="">Comment: '.stripslashes($data['comment_text']).'</p> ';
     }
}
function renderCallDivtime($data){
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
function renderShareDivtime($data){
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
function renderStatusDivtime($data){
    $html='';
     if($data){
   $html   .='<h4 class="timeline-title">'.$data['status_text'].'</h4>';
   if($data['status_text']=='Booked')
   {
   $html   .='<p class="">Booking amount <span><i class="fa fa-inr font-13" aria-hidden="true"></i></span>'.$data['booking_amount'].'</p>';
   }
   else if($data['status_text']=='Customer Offer')
   {
   $html   .='<p class="">Offer amount <span><i class="fa fa-inr font-13" aria-hidden="true"></i></span>'.$data['offer_amount'].'</p>';
   }
   else if($data['status_text']=='Converted')
   {
   $html   .='<p class="">Sale amount <span><i class="fa fa-inr font-13" aria-hidden="true"></i></span>'.$data['sale_amount'].'</p>';
   }
   return $html;
     }
}
function renderDateDivtime($data){
     if($data){
    $time=strtotime($data);
    $day=date("M d",$time);
    $time=date("g:i A",$time);
   return '<span class="img-type"></span>'.$day.'<small>'.$time.'</small>'; 
     }
}
