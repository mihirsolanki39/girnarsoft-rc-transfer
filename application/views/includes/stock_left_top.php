<?php //echo "<PRE>";print_r($usedCarInfo);// exit;
//rror_reporting(1);
$urlExplode=explode('/',current_url());
if(APPLICATION_ENV=='local')
{
  $url = !empty($urlExplode[3])? ($urlExplode[3]):'';
  $urls =  !empty($urlExplode[5])? ($urlExplode[5]):'';
}
else
{
  $url = !empty($urlExplode[4])? ($urlExplode[4]):'';
  $urls =  !empty($urlExplode[6])? ($urlExplode[6]):'';
}
$getRcDetail = $usedCarInfo;
?>
<?php// echo 'dewdwedwed'; exit;?>
<section class="all_details sticky">
        <div class="container-fluid">
            <div class="row">
               <div class="col-dc <?php echo (!empty($getRcDetail['tradetype'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Trade-In</h3>
                  <ul class="sub-value-list">
                   <li> <?php
                   if(!empty($usedCarInfo['case_id'])){
                   echo (!empty($getRcDetail['tradetype']) && ($getRcDetail['tradetype']=='1')) ? 'Park & Sell' : 'Off-Load';} else { echo "NA"; }?>
                   </li>
                  </ul>
               </div>
               <div class="col-dc <?php echo (!empty($getRcDetail['make'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Car details</h3>
                  <ul class="sub-value-list">
                        <li><?php if(!empty($getRcDetail['make'])) { echo $getRcDetail['make']; } if(!empty($getRcDetail['model'])) { echo ' '.$getRcDetail['model']; } if(!empty($getRcDetail['carversion'])) { echo ' '.$getRcDetail['carversion']; } else{ echo "NA" ;}?></li>
                        <?php if(!empty($getRcDetail['reg_no'])) { echo '<li>'.$getRcDetail['reg_no'].'</li>'; }?>
                       
                </ul>
               </div>
                <div class="col-dc <?php echo (!empty($getRcDetail['seller_name'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Seller details</h3>
                  <ul class="sub-value-list">
                        <?php if(!empty($getRcDetail['seller_name'])) { echo '<li>'.$getRcDetail['seller_name'].'</li>'; }?><li><?php if(!empty($getRcDetail['seller_mobile'])) { echo ' '.$getRcDetail['seller_mobile']; }else{ echo "NA" ;} ?></li>
                             
                </ul>
               </div>
                <?php if(!empty( $getRcDetail['tradetype']) && $getRcDetail['tradetype']==2){?>
               <div class="col-dc <?php echo (!empty($paymentDe[0]['purchaseprice'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Purchase price</h3>
                  <ul class="sub-value-list">
                        <?php if(!empty($paymentDe[0]['purchaseprice'])) { echo '<li class="indirupee rupee-icon">'.$paymentDe[0]['purchaseprice']; }else{ echo '<li>'."NA";} ?></li>
                             
                </ul>
               </div>
                <?php } ?>
                 <?php if(!empty( $getRcDetail['tradetype']) && $getRcDetail['tradetype']==1){?>
               <div class="col-dc <?php echo (!empty($paymentDe[0]['expected_price'])) ? 'col-dc-width-auto' : '';?>">
                  <h3 class="subheading">Expected price</h3>
                  <ul class="sub-value-list">
                        <?php if(!empty($paymentDe[0]['expected_price'])) { echo '<li class="indirupee rupee-icon">'.$paymentDe[0]['expected_price']; }else{ echo '<li>'."NA";} ?></li>
                             
                </ul>
               </div>
                <?php } ?>
               <?php if((!empty( $getRcDetail['tradetype']) && $getRcDetail['tradetype']==1 && !empty($getRcDetail['customer_id']))
                       || (!empty( $getRcDetail['tradetype']) && $getRcDetail['tradetype']==2 && isset($balance_amount_left) && $balance_amount_left==0) ){?>
                     <a class="pull-right" id="idexportpdf" style="padding-right: 30px;padding-top: 22px;" >
                         <button title="generate <?php echo (!empty($getRcDetail['tradetype']) && ($getRcDetail['tradetype']=='1')) ? 'Park & Sell' : 'Delivery Notes';?>" onclick="renderpdf(<?php echo $getRcDetail['case_id']?>);" class="btn btn-default">Generate <?php echo (!empty($getRcDetail['tradetype']) && ($getRcDetail['tradetype']=='1')) ? 'Park & Sell' : 'Delivery Notes';?> </button>
                     </a>
             <?php } ?>
            </div>    
         </div>
      </section>
<img style="left: 50%; position: fixed; top: 50%; z-index: 1002; border-radius: 30px; display: none;" src="http://dealercrm.com/assets/images/loader.gif" class="searchresultloader">
 <div class="row mrg-all-0">
            <div class="col-crm-left sidenav sidebar-ins" id="sidebar">
            <ul class="par-ul">
               <?php if(($_SESSION['userinfo']['role_id']!=21)){ ?>
               <li class="side_nav"><a href="<?php echo (!empty($usedCarInfo['case_id'])?base_url().'usedcarpurchase/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']):'')?>"  class="sidenav-a <?php echo (!empty($usedCarInfo['case_id']))? 'completed':'' ?> <?= (($url=='usedcarpurchase')?'active':'')?>">
                        <span class="img-type"></span> Case information</a>
               </li>
              <?php } ?>
             
               <li class="side_nav"><a href="<?php echo (!empty($usedCarInfo['case_id'])?base_url().'cardetails/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']):'#')?>" class="sidenav-a <?php echo !empty($usedCarInfo['car_id'])? 'completed':'' ?> <?= (($url=='cardetails')?'active':'')?>">
                        <span class="img-type"></span> Car details</a>
               </li>
             
               

               <li class="side_nav"><a href="<?=!empty($usedCarInfo['car_id'])?base_url().'uploadcardocs/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']):'javascript:void(0)'?>" class="sidenav-a <?= (!empty($usedCarInfo['upload_car_photos']) && ($usedCarInfo['upload_car_photos']=='1'))? 'completed':'' ?> <?=(($url=='uploadcardocs')?'active':'')?> ">

                        <span class="img-type"></span> Car photos</a>
               </li>
             
               <?php if($_SESSION['userinfo']['role_id']!=21){ ?>

               <li class="side_nav"><a href="<?=(!empty($usedCarInfo['upload_car_photos'])?base_url().'sellerdetails/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']):'javascript:void(0)')?>" class="sidenav-a <?= !empty($usedCarInfo['customer_id'])? 'completed':'' ?> <?=(($url=='sellerdetails')?'active':'')?>">
        <span class="img-type"></span> Seller details</a>
               </li>
               <?php } ?>
               <?php if($_SESSION['userinfo']['role_id']!=21){ ?>

               <li class="side_nav"><a href="<?=(!empty($usedCarInfo['customer_id'])?base_url().'uploadcardocs/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']).'/dis':'javascript:void(0)')?>" class="sidenav-a <?= !empty($usedCarInfo['upload_car_docs'])? 'completed':'' ?> <?=(($urls=='dis')?'active':'')?>">

                        <span class="img-type"></span> Documents</a>
               </li>
               <?php } ?>
               <?php if($_SESSION['userinfo']['role_id']!=21 && !empty($getRcDetail['tradetype']) && ($getRcDetail['tradetype']=='2')){ ?>

               <li class="side_nav"><a href="<?=!empty($usedCarInfo['upload_car_docs'])?base_url().'paymentdetails/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']):'javascript:void(0)'?>" class="sidenav-a <?= ((!empty($paymentDe[1]['instrumenttype']))&& ($balance_amount_left==0))? 'completed':'' ?> <?=(($url=='paymentdetails')?'active':'')?>">

                        <span class="img-type"></span> Payment details</a>
               </li>
               <?php } ?>
               <?php if(($usedCarInfo['refurb']=='1')){?>
               <!--<li class="side_nav"><a href="<?=!empty($paymentDe[0]['purchaseprice'])?base_url().'refurbdetails/'.base64_encode(DEALER_ID.'_'.$usedCarInfo['case_id']):'javascript:void(0)'?>" class="sidenav-a <?= !empty($usedCarInfo['refurbdetail'])? 'completed':(($url=='refurbdetails')?'active':'')?>">

                        <span class="img-type"></span> Refurb details</a>
               </li> -->
               <?php } ?>              
            </ul>
         </div>

     <div class="col-crm-right">
         <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
 
         <div class="loaderoverlay loaderClas"></div>
      <script>
          $('.loaderClas').attr('style','display:none;');
           function renderpdf(caseId){
         window.top.location.href = "<?php echo base_url(); ?>UsedcarPurchase/printpdf/" + caseId;
           /*$.ajax({
           type : 'POST',
           url : base_url+"DeliveryOrder/getpdf",
           data : {orderId : orderId},
           //dataType: 'html',
           success: function (response)
           {
              //alert(response);

           }
           });*/
       
     }  
      </script>    
      <style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
           .side_nav a.sidenav-a.active {color: #e46536;}
         </style>
       <?php
        if(!empty($paymentDe[0]['purchaseprice']) || !empty($paymentDe[0]['expected_price'])) { ?>
         <script>
          var abc = $('.indirupee').text();
        //  alert(abc);
                var cc = abc.split(' ');

                indianform(cc[0].replace(/,/g, ''));
            function indianform(x)
            {
              //var x=123456524578;
              x=x.toString();
              var lastThree = x.substring(x.length-3);
              var otherNumbers = x.substring(0,x.length-3);
              if(otherNumbers != '')
                  lastThree = ',' + lastThree;
              var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
             // alert(res);
              $('.indirupee').text(res);
            }
       </script>
       <?php } ?>
