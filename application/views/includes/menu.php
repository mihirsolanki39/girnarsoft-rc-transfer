<?php 
$activ ='';
$urlExplode=explode('/',current_url());
if(APPLICATION_ENV=='local'){
$url = !empty($urlExplode)? $urlExplode[3]:'';
} 
else
{
  $url = !empty($urlExplode)? $urlExplode[4]:''; 
}
$loan = '';
$ins = '';
 $role =!empty( $this->session->userdata['userinfo']['role_name'])?$this->session->userdata['userinfo']['role_name']:''; 
 $linkLogo = base_url('dashboard');
 if($role=='Prelogin')
 {
  $linkLogo = '#';
 }

?>

<nav class="navbar navbar-default">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>                        
               </button>
               <a class="navbar-brand" href="<?=$linkLogo?>"  style="text-align:left;padding: 10px 15px"><img src="<?=base_url('assets/images/cdrivelogo.png')?>" style="text-align:left; width: 115px"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
            <?php if(!empty($menu))
            {
              $i = 0;
              $atoggel ='';
              $count = count($menu);
              foreach ($menu as $mkey => $mvalue) {
                $i++;
                $atoggel = '';
                if(!empty($mvalue['sub'])){
                  $atoggel = 'aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" style="background: transparent none repeat scroll 0% 0%;"';
                  foreach ($mvalue['sub'] as $skey => $svalue) 
                    { 
                       $activ = ($url==$svalue['url'])?'':'';
                    }
                 }
                if($i==7)
                { ?>
                   <li class="dropdown <?=(isset($url) && $url=='dealerListing' || $url=='bank' ||  $url=='team'||  $url=='userList' || $url=='role') ?'active':''?>">
                  <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" id="more" href="#">More <span class="caret"></span></a>
                   <ul role="menu" class="dropdown-menu ">
                <?php } ?>

                 
                <?php
                if($i>=7){
                $u = $mvalue['url']; ?>
                <li class=""><a href="<?=base_url($u)?>" target="_blank"><?=$mvalue['menu'];?></a></li> <?php } ?>
                <?php if(($i==$count) && (($i>=7))){ ?>
                  </ul>
                  <?php } ?>
                <?php if($i==7){?>
               </li>
                <?php }
                else if($i<7){
               ?>

              <li class="<?php echo $activ?> abc" id="<?php echo (!empty($mvalue['menu'])?str_replace(' ', '_', trim($mvalue['menu'])):'')?>"><a <?=(!empty($mvalue['menu'])?$atoggel:'')?> href="<?=base_url(!empty($mvalue['url'])?'/'.$mvalue['url']:'')?>" target="_blank"><?=(!empty($mvalue['menu'])?$mvalue['menu']:'')?>
                <?php if(!empty($mvalue['sub']))
                {?>
                <span class="caret"></span></a>
                     <ul role="menu" class="dropdown-menu">
                 <?php foreach ($mvalue['sub'] as $skey => $svalue) 
                    { ?>
                          <li><a href="<?=base_url(!empty($svalue['url'])?'/'.$svalue['url']:'')?>" target="_blank"><?=(!empty($svalue['menu'])?$svalue['menu']:'')?></a></li>
                   <?php } ?>
                   </ul>
              <?php }else{ echo '</a>'; }?> 
                </li>
             <?php }
            }
            }
            ?>
            <li class="dropdown lastli_border">
                     <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="<?=base_url('assets/admin_assets/images/user.png')?>" alt="" class="usreIcon"><span class="name">Hi <?php echo $userinfo['name'];?></span>
                     <span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <!--<li><a href="#">My Profile</a></li>-->
                        <li><a href="<?=base_url('admin/logout')?>">Logout</a></li>
                     </ul>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
<script>
   $(document).ready(function(){
       $('#myNavbar .nav li').click(function(){
          $('#myNavbar .nav li.active').removeClass('active');
           var da = "<?=$url?>";
       if(da == 'dashboard'){
      setTimeout(function(){ $('#Dashboard').addClass('active'); }, 30);
    }
    else if(da == 'dealerListing') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){$('#Dealer_Listing').addClass('active'); }, 30);
    }
    else if(da == 'inventoryListing') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Stock').addClass('active'); }, 30);
    }
    else if(da == 'usedcarpurchase') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Stock').addClass('active'); }, 30);
    }
    else if(da == 'userList') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Employee_Listing').addClass('active'); }, 30);
    }
    else if(da == 'addUser') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Employee_Listing').addClass('active'); }, 30);
    }
    else if(da == 'addDealer') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Dealer_Listing').addClass('active'); }, 30);
      
    }
    else if(da == 'addInsurance') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insListing') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'inspersonalDetail') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insvehicalDetail') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insFileLogin') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insPolicyDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }else if(da == 'insPremiumDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }else if(da == 'insDocumentDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }else if(da == 'inspaymentDetail') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insInspection') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insPreviousDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
         //  $(this).addClass('active');
       });


      // alert('fferere');
       var da = "<?=$url?>";
     // alert(da);
       if(da == 'dashboard'){
      setTimeout(function(){ $('#Dashboard').addClass('active'); }, 30);
    }
    else if(da == 'dealerListing') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){$('#Dealer_Listing').addClass('active'); }, 30);
    }
    else if(da == 'userList') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Employee_Listing').addClass('active'); }, 30);
    }
    else if(da == 'addUser') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Employee_Listing').addClass('active'); }, 30);
    }
    else if(da == 'addDealer') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Dealer_Listing').addClass('active'); }, 30);
      
    }
    else if(da == 'addInsurance') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insListing') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'inspersonalDetail') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insvehicalDetail') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insFileLogin') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insPolicyDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }else if(da == 'insPremiumDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }else if(da == 'insDocumentDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }else if(da == 'inspaymentDetail') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insInspection') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if(da == 'insPreviousDetails') 
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Insurance').addClass('active'); }, 30);
      
    }
    else if((da=='leadDetails') || (da=='uploadDocs') || (da=='personalDetail') || (da=='personalDetail') || (da=='financeAcedmic') || (da=='loanExpected') || (da=='residentialInfo') || (da=='refrenceDetails') || (da=='bankInfo') || (da=='loanFileLogin') || (da=='cpvDetails') || (da=='decisionDetails') || (da=='disbursalDetails') || (da=='postDeliveryDetails') || (da=='paymentDetails') || (da=='loanListing'))
    {

      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Loan').addClass('active'); }, 30);
    }

    else if((da=='inventoryListing') || (da=='usedcarpurchase') || (da=='cardetails') || (da=='uploadcardocs') || (da=='sellerdetails') || (da=='paymentdetails'))
    {

      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Stock').addClass('active'); }, 30);
    }
    else if((da=='loanDoInfo') || (da=='orderListing') || (da=='loanReceiptDetail'))
    {

      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Delivery_Order').addClass('active'); }, 30);
    }
   else if((da=='lead') || (da=='LeadSell'))
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#Leads').addClass('active'); }, 30);
      
    }
    else
    {
      $('.abc').removeClass('active');
      setTimeout(function(){ $('#more').addClass('active'); }, 30);
    }

       
   });
   function highlight(e)
   {
      
  }
</script>
