<?php //echo "<PRE>";print_r($getRcDetail);
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

?>
 <div class="row mrg-all-0">
            <!--<div class="col-crm-left sidenav sidebar-ins" id="sidebar">
            <ul class="par-ul">
               <li class="side_nav"><a href="<?=(!empty($getBookingDetail["id"]))? base_url('addrefurbworkshop/').base64_encode('RefurbId_'.$getBookingDetail["id"]):'#'?>" class="sidenav-a <?= (!empty($getBookingDetail["id"]))? 'completed':'active'?>">
                        <span class="img-type"></span>Workshop Details</a>
               </li>
            </ul>
         </div>-->

     <div class="">
         <div class="loaderClas" style="display:none;"><img class="resultloader" src="<?php echo base_url()?>/assets/images/loading.gif" style="position: absolute;left: 0;right: 0;text-align: center;top: 0;bottom: 0;margin: auto;z-index: 9999;"></div>
      <div class="loaderoverlay loaderClas"></div>
      <script>
          $('.loaderClas').attr('style','display:none;');
      </script>    
      <style type="text/css">
           .loaderoverlay{position: fixed;left: 0;right: 0;top: 0;bottom: 0; background: rgba(0,0,0,0.5); z-index: 999;}
           .loaderClas{position: fixed; left:0; top: 0;right: 0; bottom: 0; margin:auto;z-index: 9999;}
         </style>
