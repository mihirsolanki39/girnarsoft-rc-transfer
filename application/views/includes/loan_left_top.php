<?php 
$admin = ''; 
$role  = "";
$newPay = '';
$caseinfotab = '1';
if($_SESSION['userinfo']['role_id']=='6')
{
  $role = "";
}
else if($_SESSION['userinfo']['is_admin']=='1')
{
  $admin = '1';
  $newPay = '1';
}
else if(($_SESSION['userinfo']['role_name']=='Accountant') && (strtolower($_SESSION['userinfo']['team_name'])=='all'))
{
  $newPay = '1';
}
$app_status ='';
$down = '';
if((!empty($CustomerInfo['cust_bnk_id'])) && ($CustomerInfo['Buyer_Type']=='2'))
{
  $down = '1';
}
//echo '<pre>';print_r($CustomerInfo);die;?>
<?php //echo '<pre>';print_r($customerMobileNumber);die;

if((!empty($CustomerInfo['guaranter_case'])) && (!empty($CustomerInfo['co_applicant'])))
{
    if((!empty($CustomerInfo['coapplicant_id'])) && (!empty($CustomerInfo['guarantor_id']))){
      $caseinfotab = '1';
    }
    else
    {
       $caseinfotab = '';
    }
}
elseif((empty($CustomerInfo['guaranter_case'])) && (!empty($CustomerInfo['co_applicant'])))
{
  if((!empty($CustomerInfo['coapplicant_id']))){
      $caseinfotab = '1';
    }
    else
    {
       $caseinfotab = '';
    }
}
elseif((!empty($CustomerInfo['guaranter_case'])) && (empty($CustomerInfo['co_applicant'])))
{
  if((!empty($CustomerInfo['guarantor_id']))){
      $caseinfotab = '1';
    }
    else
    {
       $caseinfotab = '';
    }
}
if(!empty($CustomerInfo['disbursed_amount']))
{
    $loanamt = $CustomerInfo['disbursed_amount'];
    $tenor = $CustomerInfo['disbursed_tenure'];
    $roi = $CustomerInfo['disbursed_roi'];
    $reff_id = !empty($CustomerInfo['ref_id'])?$CustomerInfo['ref_id']:'';
}
else if((!empty($CustomerInfo['approved_loan_amt'])) && empty($CustomerInfo['disbursed_amount']))
{
    $loanamt = $CustomerInfo['approved_loan_amt'];
    $tenor = $CustomerInfo['approved_tenure'];
    $roi = $CustomerInfo['approved_roi'];
    $reff_id = !empty($CustomerInfo['ref_id'])?$CustomerInfo['ref_id']:'';
}
else
{
    $loanamt = !empty($loanamt)?$loanamt:'';
    $tenor =!empty($CustomerInfo['tenor'])?$CustomerInfo['tenor']:'' ;
    $roi = !empty($CustomerInfo['roi'])?$CustomerInfo['roi']:'' ;
    $reff_id = !empty($CustomerInfo['ref_id'])?$CustomerInfo['ref_id']:'';
}
$urlExplode=explode('/',current_url());
$urls = ''; 
$st ='0';
if(APPLICATION_ENV=='development')
{
  $url = !empty($urlExplode[4])? ($urlExplode[4]):'';
  //echo $urlExplode[5]; exit;
  if($urlExplode[6]=='dis')
  {
    $urls = 'uploadDocs';
  }
  if($urlExplode[6]=='dis')
  {
    $urls = 'uploadDocs';
  }
   if($urlExplode[6]=='post')
  {
    $urlss = 'uploadDocs';
  }
} 
else
{
  $url = !empty($urlExplode[4])? ($urlExplode[4]):'';

}
if($url=='personalDetail' || $url == 'financeAcedmic' || $url == 'loanExpected' || $url=='residentialInfo' || $url=='refrenceDetails' || $url=='bankInfo' || $url=='coapplicantDetail' || $url=='guarantorDetail')
{
  $st = '1';
}
if(($url=='uploadDocs' && ($urls=='')) || $url=='personalDetail' || $url == 'financeAcedmic' || $url == 'loanExpected' || $url=='residentialInfo' || $url=='refrenceDetails' || $url=='leadDetails' || $url=='loanFileLogin' || $url=='bankInfo' || $url=='coapplicantDetail' || $url=='guarantorDetail')
{
  $washout = 'Cancel';
  $marked = 'Mark as';
  if(!empty($CustomerInfo['cancel_id']) && $CustomerInfo['cancel_id']>='1')
  {
      $marked = 'Marked as';
  }
}
else
{
  $washout = 'Washout';
  $marked = 'Mark as';
 if(!empty($CustomerInfo['cancel_id']) && $CustomerInfo['cancel_id']>='1')
  {
      $marked = 'Marked as';
  }
}

$statusName = '';
if((!empty($CustomerInfo['loan_approval_status'])) && (($CustomerInfo['loan_approval_status']=='5') || ($CustomerInfo['loan_approval_status'])=='7'))
{
    $statusName = 'Open';
}
else if(!empty($CustomerInfo['file_tag']))
{
  $statusName = $CustomerInfo['file_tag'];
}
//echo $app_status; exit;
 if((empty($CustomerInfo['file_tag'])) && ($app_status=='Open') )
{
  $statusName = 'Open';
}
//echo $urls; exit;
?>
<section class="all_details sticky">
         <div class="container-fluid">
            <div class="row">
        <div class="col-dc <?php if(!empty($CustomerInfo["loan_for"])){  echo " col-dc-width-auto"; } ?>">
                  <h3 class="subheading">Case Type</h3>
                   <div class="sub-value"><ul class="sub-value-list"><li>
                               <?php if(!empty($CustomerInfo["loan_for"])){
                                 echo (($CustomerInfo['loan_for']=='2')?'Used Car':'New Car') . " - " .$CustomerInfo["loan_type"];
                                }
                                else
                                {
                                  echo "NA";
                                }
                                ?>
                           </li></ul></div>
               </div>
               <div class="col-dc <?= !empty($CustomerInfo['name'])?'col-dc-width-auto':''?>">
                  <h3 class="subheading">Buyer Details</h3>
                  <div class="sub-value">
                     <ul class="sub-value-list">
                        <li><?= !empty($CustomerInfo['name'])?$CustomerInfo['name']:'NA'?></li>
                        <?php if(!empty($customerMobileNumber['mobile'])) { ?><li><?= !empty($customerMobileNumber['mobile']) ? $customerMobileNumber['mobile']:'' ?></li> <?php } ?>
                     </ul>
                  </div>
               </div>
               <div class="col-dc <?php if(!empty($CustomerInfo['make_name'])){  echo " col-dc-width-auto" ;} ?>">
                  <h3 class="subheading">Car Details</h3>
                  <ul class="sub-value-list">
                      <?php if(!empty($CustomerInfo['make_name']) && !empty($CustomerInfo['model_name']) && !empty($CustomerInfo['version_name'])) { ?>     
                        <li>
                            <?= !empty($CustomerInfo['make_name'])?$CustomerInfo['make_name']:''?> 
                            <?= !empty($CustomerInfo['model_name'])?$CustomerInfo['model_name']:''?>
                           <!-- <?= !empty($CustomerInfo['version_name'])?$CustomerInfo['version_name']:''?>-->
                        </li>

                        <?= !empty($CustomerInfo['regno'])?'<li>'.strtoupper($CustomerInfo['regno']).'</li>':''?>
                      <?php }else{ echo 'NA'; } ?>

                 </ul>
               </div>
               <div class="col-dc <?php if(!empty($CustomerInfo['financer'])){  echo " col-dc-width-auto" ;} ?>">
                  <h3 class="subheading">Loan Details <a onclick="showLoanHistory(<?=(!empty($CustomerInfo['customer_loan_id'])?$CustomerInfo['customer_loan_id']:"")?>)"> <i class=" <?php if(!empty($CustomerInfo['customer_id'])){echo "fa fa-info-circle";} ?>"></i></a></h3>
                  <ul class="sub-value-list">
                          <?php if (!empty($CustomerInfo['financer'])) { ?>
                           <!-- <?php if(!empty($reff_id)){?><li><?=!empty($reff_id)? $reff_id : '' ?></li><?php } ?>-->
                              <li><?= !empty($CustomerInfo['financer']) ? $CustomerInfo['financer_name'] : '' ?></li>
                               <li class="indirupee rupee-icon"> <?= !empty($loanamt) ? $loanamt : '' ?></li>
                              <li> <?= !empty($tenor) ? $tenor . ' Months' : '' ?></li>
                              <li><?= !empty($roi) ? $roi . ' % ROI' : '' ?></li>
                          <?php }else{ echo 'NA'; }  ?>

                      </ul>
               </div>   
               <div class="col-dc <?php if(!empty($statusName)){  echo " col-dc-width-auto"; } ?>">
                  <h3 class="subheading">Status</h3>
                   <div class="sub-value"><ul class="sub-value-list"><li>
                               <?php if(!empty($statusName)){
                                 echo $statusName;
                                }
                                else
                                {
                                  echo "NA";
                                }
                                ?>
                           </li></ul> </div>
               </div>
               <?php if(((!empty($CustomerInfo["tag_flag"]) && $CustomerInfo["tag_flag"]!='4') || (empty($CustomerInfo['tag_flag']) && !empty($CustomerInfo['loan_approval_status']))) && !empty($CustomerInfo)){?>
                <div class="wash-out">
                  <a href="javascript:void(0);" id="<?=$washout?>"><?=$marked.' '.$washout?></a>
                </div>
                <?php } ?>
            </div>
         </div>
      </section>
        <div class="row mrg-all-0">
            <div class="col-crm-left sidenav" id="sidebar">
            <ul class="par-ul">
                <li class="side_nav">
                    <a href="<?= !empty($CustomerInfo["customer_id"])? base_url('leadDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-a <?= !empty($CustomerInfo["customer_id"])? 'completed':'active'?>"><span class="img-type"></span> Lead Details</a></li>

               
               <?php 
          
               if ((empty($CustomerInfo["residence_pincode"]) && ($CustomerInfo["Buyer_Type"]=='1')))
               {
                $CustomerInfo["residence_pincode"] =  'aaa';
               }

                if((!empty($CustomerInfo["customer_id"])) && ((!empty($CustomerInfo["highest_education"]))|| (!empty($CustomerInfo["office_city"]))) && (!empty($CustomerInfo["loan_expected"])) && (!empty($CustomerInfo["ref_name_one"])) && (!empty($CustomerInfo["residence_pincode"])) && (!empty($CustomerInfo['custbranch'])) && ((!empty($caseinfotab)) && ($caseinfotab=='1'))) {
             $complete = 'completed';
                 } ?>
               <li class="side_nav"><a href="#" class="sidenav-a sub-down  <?= !empty($complete)?$complete:'' ?>"> 
                  <span class="img-type <?=($st=='1')?'img-after':'';?>"></span> Case Info <img src="<?php echo base_url(); ?>assets/admin_assets/images/<?=($st=='1')?'minus.svg':'plus.svg';?>" alt="minus-plus" class="minus-sign"></a>
                   <ul class="case-info-sublist" style="<?=($st=='1')?'display:block':'display: none'?>">
                      <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"])  && !empty($CustomerInfo["id"]))? base_url('personalDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["pan_number"]))? 'completed':((isset($url) && ($url=='personalDetail'))?'active':'#')?>"><span class="img-type"></span>Personal Details</a>
                      </li>
                       <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"]) && ((!empty($CustomerInfo["highest_education"])) || (!empty($CustomerInfo["office_city"])) ))? base_url('financeAcedmic/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && ((!empty($CustomerInfo["highest_education"])) || (!empty($CustomerInfo["office_city"]))))? 'completed':((isset($url) && ($url=='financeAcedmic'))?'active':'#')?>"><span class="img-type"></span>Financial &amp; Academic</a>
                      </li>
                        <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"]) && (!empty($CustomerInfo["office_city"]) || !empty($CustomerInfo["highest_education"])))? base_url('loanExpected/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["loan_expected"]))? 'completed':((isset($url) && ($url=='loanExpected'))?'active':'#')?>"><span class="img-type"></span>Loan Expected</a>
                      </li>
                      <? if((!empty($CustomerInfo["Buyer_Type"])) && ($CustomerInfo["Buyer_Type"]=='2')){
                        $ab = '';?>
                       <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["loan_amt"])) ? base_url('residentialInfo/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["residence_pincode"]))? 'completed':((isset($url) && ($url=='residentialInfo'))?'active':'#')?>"><span class="img-type"></span>Residential Information</a>
                      </li>
                      <? } 
                      else {  $ab = '1';}?>
                       <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"])  && (!empty($CustomerInfo["residence_pincode"])) || ($ab=='1'))? base_url('refrenceDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["ref_name_one"]))? 'completed':((isset($url) && ($url=='refrenceDetails'))?'active':'#')?>"><span class="img-type"></span>Reference/Guarantor</a>
                      </li>
                       <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["ref_name_one"]))? base_url('bankInfo/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["cust_bnk_id"]))? 'completed':((isset($url) && ($url=='bankInfo'))?'active':'#')?>"><span class="img-type"></span>Banking information</a>
                      </li>
                      <?php if($CustomerInfo["co_applicant"]=='1'){?>
                      <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"]) && ((!empty($CustomerInfo["highest_education"])) || (!empty($CustomerInfo["office_city"])) ))? base_url('coapplicantDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && ((!empty($CustomerInfo["highest_education"])) && (!empty($CustomerInfo["coapplicant_id"]))))? 'completed':((isset($url) && ($url=='coapplicantDetail'))?'active':'#')?>"><span class="img-type"></span>Co-Applicant Details</a>
                      </li>
                    <?php } if($CustomerInfo["guaranter_case"]=='1'){?>
                      <li class="sub-side-nav">
                          <a href="<?= (!empty($CustomerInfo["customer_id"]) && ((!empty($CustomerInfo["highest_education"])) || (!empty($CustomerInfo["office_city"])) ))? base_url('guarantorDetail/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-sub-a <?= (!empty($CustomerInfo["customer_id"]) && ((!empty($CustomerInfo["highest_education"])) && (!empty($CustomerInfo["guarantor_id"]))))? 'completed':((isset($url) && ($url=='guarantorDetail'))?'active':'#')?>"><span class="img-type"></span>Guarantor Details</a>
                      </li>
                    <? } ?>
                   </ul>
               </li>
              <?php // echo "<pre>";print_r($CustomerInfo);die;?>
               <li class="side_nav"><a href="<?= (!empty($CustomerInfo["customer_id"])&& !empty($CustomerInfo["ref_name_one"]))? base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["upload_login_doc_flag"]))?'completed':((isset($url) && ($url=='uploadDocs'))?'active':'#')?>"> 
                  <span class="img-type"></span> Upload Docs</a>
               </li>
               <li class="side_nav"><a href="<?= (!empty($CustomerInfo["customer_id"])&& !empty($CustomerInfo["upload_login_doc_flag"]) && ($CustomerInfo["upload_login_doc_flag"]=='1'))? base_url('loanFileLogin/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" 
                  class="sidenav-a <?=(!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']!='5'))?'completed':((isset($url) && ($url=='loanFileLogin'))?'active':'#')?>" id="fileLogins"> 
                  <span class="img-type"></span> File Login</a>
               </li>
               <li class="side_nav"><a href="<?=(!empty($CustomerInfo["file_tag"]) && !empty($CustomerInfo["tag_flag"]>='1'))? base_url('cpvDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" 
               class="sidenav-a <?=(!empty($CustomerInfo['cpvstatus']) && ($CustomerInfo['cpvstatus']>0))?'completed':((isset($url) && ($url=='cpvDetails'))?'active':'#')?>"> 
                  <span class="img-type"></span> CPV Details</a>
               </li>
               <li class="side_nav"><a href="<?=(!empty($CustomerInfo["file_tag"]) && (!empty($CustomerInfo['cpvstatus']) && ($CustomerInfo['cpvstatus']>0) ))? base_url('decisionDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" 
                  class="sidenav-a <?=(!empty($CustomerInfo['tag_flag']) && (($CustomerInfo['tag_flag']=='2')||($CustomerInfo['tag_flag']=='3')||($CustomerInfo['tag_flag']=='4')) && (!empty($CustomerInfo['cpvstatus']) && ($CustomerInfo['cpvstatus']>0) ))?'completed':((isset($url) && ($url=='decisionDetails'))?'active':'#')?>"> 
                  <span class="img-type"></span> Decisions</a>
               </li>
                <li class="side_nav"><a href="<?=(!empty($CustomerInfo["file_tag"]) && (($CustomerInfo["tag_flag"]=='2'  || $CustomerInfo["tag_flag"]=='4')))? base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]).'/dis':'#'?>" class="sidenav-a <?= (!empty($CustomerInfo["customer_id"]) && !empty($CustomerInfo["upload_dis_doc_flag"]))?'completed':((isset($urls) && ($urls=='uploadDocs'))?'active':'#')?>"> 
                  <span class="img-type"></span> Pre Disbursal Docs</a>
               </li>
               <li class="side_nav"><a href="<?=(!empty($CustomerInfo["file_tag"]) && (($CustomerInfo["tag_flag"]=='2') || $CustomerInfo["tag_flag"]=='4') && (!empty($CustomerInfo["upload_dis_doc_flag"]) && $CustomerInfo["upload_dis_doc_flag"]=='1'))? base_url('disbursalDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" 
                class="sidenav-a <?=(!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4'))?'completed':((isset($url) && ($url=='disbursalDetails'))?'active':'#')?>"> 
                  <span class="img-type"></span> Disbursal</a>
               </li>
               <!--(!empty($CustomerInfo["file_tag"]) && (($CustomerInfo["tag_flag"]=='2') || $CustomerInfo["tag_flag"]=='4'))? base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]).'/dis':'#'-->

              <li class="side_nav"><a href="<?=(!empty($CustomerInfo["tag_flag"]) && ($CustomerInfo["tag_flag"]=='4'))? base_url('paymentDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-a <?=(!empty($CustomerInfo['instrument_type']))?'completed':((isset($url) && ($url=='paymentDetails'))?'active':'#')?>"> 
                  <span class="img-type"></span> Payment Details</a>
               </li>
               <li class="side_nav"><a href="<?=(!empty($CustomerInfo["instrument_type"]) && ($CustomerInfo["instrument_type"]>='1'))? base_url('postDeliveryDetails/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):'#'?>" class="sidenav-a  <?=(!empty($CustomerInfo['rc_engine_no']))?'completed':((isset($url) && ($url=='postDeliveryDetails'))?'active':'#')?> "> 
                  <span class="img-type"></span> Post Delivery Info</a>
               </li>
  
                <?php if($CustomerInfo['loan_for']=='1') { ?>
               <li class="side_nav"><a href="<?=(!empty($CustomerInfo["invoice_no"]))? base_url('uploadDocs/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]).'/post':'#'?>" class="sidenav-a <?=(!empty($CustomerInfo['upload_post_doc_flag']) && ($CustomerInfo["upload_post_doc_flag"]=='1'))?'completed':((isset($urlss) && ($urlss=='uploadDocs'))?'active':'#')?>"> 
                  <span class="img-type"></span> Post Delivery Docs</a>
               </li>
               <?php }             
               if(($newPay=='1') ){  ?>  
                  <li class="side_nav"><a href="<?=(!empty($CustomerInfo["invoice_no"]) || (!empty($CustomerInfo["tag_flag"]) && ($CustomerInfo["tag_flag"]=='4')))? base_url('loanpayment/').base64_encode('CustomerId_'.$CustomerInfo["customer_loan_id"]):''?>" class="sidenav-a <?=(!empty($CustomerInfo["left_amt"]) && ($CustomerInfo["left_amt"]=='1'))?'completed':((isset($url) && ($url=='loanpayment'))?'active':'#')?>"> 
                  <span class="img-type"></span> Loan Payment</a>
               </li>
               <? } ?>

               
            </ul>
         </div>
       <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="hisfeedBack">
           <div class="modal-backdrop fade in" style="height:100%"></div>
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header bg-gray">
                  <button type="button" onclick="closeloanHistory()" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Customer History</h4>
               </div>
               <div class="modal-body">
               <div class="timeline_content">
                  <div class="row">
                     <div class="col-sm-12 sidenav">
                        <ul class="par-ul" id="loanshowHisData">

                          <!-- <li class="side_nav">
                              <div class="col-sm-4"> <a href="#" class="sidenav-a "><span class="img-type"></span>Sep 03 <small>11.23 pm</small></a></div>
                              <div class="col-sm-8 side_text">
                                 <span class="active_text">
                                    Payment Requested
                                 </span>
                                 <span class="Detail_text">
                                    NA
                                 </span>
                              </div>
                           </li> -->
                        </ul>
                     </div>
                  </div>
               </div>
               </div>
            </div>
            <!-- /.modal-comment -->
         </div>
      </div>
         <div class="col-crm-right">

      <div class="loaderClas"><img class="resultloader" src="<?=base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
      <div class="loaderoverlay loaderClas">
      </div> 
      <?php
        if(!empty($CustomerInfo) && $CustomerInfo['cancel_id']=='0') { ?>
         <script>
             
           $('#Cancel').click(function(){
              $('#cancel_model').attr('style','display:block;');
              $('#cancel_model').addClass(' in');
           });
           $('#Washout').click(function(){
              $('#washout_model').attr('style','display:block;');
              $('#washout_model').addClass(' in');
           });
           
         </script>
         <?php } ?>
         <?php
        if(!empty($CustomerInfo['financer'])) { ?>
         <script>
          var abc = $('.indirupee').text();
                var cc = abc.split(' ');
                indianform(cc[1].replace(/,/g, ''));
            function indianform(x)
            {
              //var x=123456524578;
              x=x.toString();
              var lastThree = x.substring(x.length-3);
              var otherNumbers = x.substring(0,x.length-3);
              if(otherNumbers != '')
                  lastThree = ',' + lastThree;
              var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
              $('.indirupee').text(res);
            }
       </script>
       <?php } ?>
         <script>
         function showLoanHistory(loanid)
         {
            $.ajax({
              type : 'POST',
              url : "<?php echo base_url(); ?>" + "Finance/getHistoryDetail/",
              data : {caseId:loanid},
              dataType: 'html',
              success: function (response) 
              { 
                $('#hisfeedBack').addClass('in');
                $('#hisfeedBack').attr('style','display:block');
                $('#loanshowHisData').html(response);
              }
              });   
           

         }
          function closeloanHistory()
        {
            $('#hisfeedBack').removeClass('in');
            $('#hisfeedBack').attr('style','display:none');
        }
        $('.loaderClas').attr('style','display:none;');
      </script>
         <style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
         </style>
