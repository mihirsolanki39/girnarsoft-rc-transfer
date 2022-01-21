<?php
function renderInsuranceHTMLFinal($qu=''){
  $head = 'Change Accepted Quote';
  $body = 'Are you Sure you want to change accepted Quotes? <br/> *Details in subsequent sections will be changed accordingly.';
  if(empty($qu))
  {
    $head = 'Accept Quote';
    $body = 'Are you sure you want to accept this Quote? <br/> *You may change accepted quote later.';
  }
  ?>

         <form name="insconf_form" id="insconf_form">
             <div class="modal-content" >
                 <div class="modal-header bg-gray">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                     <h4 class="modal-title"><?php echo $head;?></h4>
                 </div>
                 <div class="modal-body text-center pad-all-15" >
                     <div class="tab-content" id="insmsg">
                       <?php echo $body;?>    
                     </div>    
                     <div class="modal-footer pad-B0 pad-T0 pad-L15 pad-R15">
                         <button type="button" class="btn btn-default stocksms_cancel" data-dismiss="modal" id="ins_cancel">Cancel</button>
                         <button type="button" class="btn btn-primary" id="ins_ok" name="ins_ok">Ok</button>
                     </div>
                 </div>
             </div><!-- /.modal-comment -->
         </form>
     
 <?php } ?>
<?php
function renderInsurancequotesBreakUp($data,$inscat){
    //print_r($data);
?>    
       
    <div class="modal-header bg-gray">
        <button type="button" class="close" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png');?>"> <span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo !empty($data[0]['short_name']) ? $data[0]['short_name']:'';?></h4>
        <span class="light idv-pb font-14" id="pb_val_idv">IDV: ₹<span><?php echo !empty($data[0]['idv'])?indian_currency_form($data[0]['idv']):"0";?></span></span>
        <span class="light idv-pb font-14">Zone:<span><?php echo (!empty($data[0]['zone']) && ($data[0]['zone']=='1')) ? 'A':'B'; ?></span></span>
    </div>
<div class="modal-body">
<?php
            $addOn=0;
            $totgst='';
            $totpremium='';
            if($data[0]['road_side_assistance']=='1'){
            $addOn=(int)$data[0]['road_side_assistance_txt'];
            }
            if($data[0]['loss_of_personal_belonging']=='1'){
            $addOn+=(int)$data[0]['loss_of_personal_belonging_txt'];
            }
            if($data[0]['emergency_transport_hotel_premium']=='1'){
            $addOn+=(int)$data[0]['emergency_transport_hotel_premium_txt'];
            }
            
            if($data[0]['driver_cover']=='1'){
            $driver_cover=(int)$data[0]['paid_driver'];
            }
            if($data[0]['personal_acc_cover']=='1'){
            $personal_acc_cover=(int)$data[0]['personal_acc_cover'];
            }
            if($data[0]['passenger_cover']=='1'){
            $passenger_cover=$data[0]['pass_cover'];
            }
            if($data[0]['anti_theft']=='1'){
              $addOn-=$data[0]['anti_theft_txt'];
            }
            if($data[0]['add_on']){
             $addOn+=$data[0]['add_on'];
            }

            $idv=(int)$data[0]['idv'];
            $od_disc_perc=(int)$data[0]['od_disc_perc'];
            $basicOwnDamage=round($data[0]['basic_own_damage']);
            $odDiscount=round($data[0]['od_discount']);
            
            if($data[0]['electrical_accessories']=='1'){
            $electrical=(int)$data[0]['electrical'];//eletrical
            $electrical=round($electrical);
            }
            if($data[0]['non_electrical_accessories']=='1'){
            $nonelectrical=(int)$data[0]['non_electrical'];//non electrical
            $nonelectrical=round($nonelectrical);
            }
            $ncbtotal=round($data[0]['ncb']);
            $finalownDamage=round($data[0]['own_damage']);
            
            $basicThirdParty=(int)$data[0]['basic_third_party'];//basic third party
            /*if($inscat=='1'){
            $personalAccCover=(int)$data[0]['pcover']; // personal accident cover
            $paidDriver=(int)$data[0]['pdriver'];; // paid driver
            }else{
             $personalAccCover=(int)$data[0]['pcover'];; // personal accident cover
            $paidDriver=(int)$data[0]['pdriver'];; // paid driver   
            }*/
            
            //$thirdParty=(int)$basicThirdParty+(int)$driver_cover+(int)$personal_acc_cover+(int)$passenger_cover; // third party
            $thirdParty=(int)$data[0]['third_party'];
            $thirdParty=round($thirdParty);
?>
        <?php if($data[0]['policy_type_customer'] != 2){?>
            <div class="clearfix bord-bot mrg-B10">
                  <div class="col-md-12 padin">
                    <div class="row">
                      <div class="col-xs-6 mrg-B5 ">
                        <span class="strn">Own Damage </span>
                      </div>
                      <div class="col-xs-6 mrg-B5 text-right ">
                        <span class="strn">₹ <?php echo !empty($finalownDamage)?indian_currency_form($finalownDamage):"0";?></span>
                      </div>
                      <div class="col-xs-6  ">
                        <span class="light">Basic Own Damage</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light">₹ <?php echo !empty($basicOwnDamage)?indian_currency_form($basicOwnDamage):"0";?></span>
                      </div>
                      <div class="col-xs-6  ">
                        <?php if(!empty($data[0]['ftype']) && ($data[0]['ftype']=='2')){?>  
                        <span class="light">OD Discount </span>
                        <?php } else{?>
                        <span class="light">OD Discount (<?php echo$od_disc_perc?>%)</span>
                        <?php } ?>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light">₹ <?php echo !empty($odDiscount)?indian_currency_form($odDiscount):"0";?></span>
                      </div>
                      <?php if((!empty($data[0]['claim_taken'])) && ($data[0]['claim_taken']=='2') && !empty($data[0]['ftype']) && ($data[0]['ftype']=='1')){?>  
                      <div class="col-xs-6 ">
                          <?php $ncbDisc=!empty($data[0]['ncb_discount']) ? $data[0]['ncb_discount']:''?>
                        <span class="light">NCB Discount (<?php echo $ncbDisc;?>%)</span>
                      </div>
                      <div class="col-xs-6 text-right" style="">
                        <span class="light">₹<?php echo !empty($ncbtotal)?indian_currency_form($ncbtotal):"0";?></span>
                      </div>
                      <?php }elseif(!empty($data[0]['ftype']) && ($data[0]['ftype']=='2')){ ?>
                        <div class="col-xs-6 ">
                          <?php $ncbtot=!empty($data[0]['ncb']) ? $data[0]['ncb']:''?>
                        <span class="light">NCB Discount </span>
                      </div>
                      <div class="col-xs-6 text-right" style="">
                        <span class="light">₹<?php echo !empty($ncbtot)?indian_currency_form($ncbtot):"0";?></span>
                      </div>
                      <?php } ?>  
                      <?php if(isset($electrical)){?>  
                      <div class="col-xs-6" style="">
                        <span class="light">Electrical</span>
                      </div>
                      <div class="col-xs-6 text-right" style="">
                        <span class="light"> <?php echo !empty($electrical) ? '₹'. indian_currency_form($electrical):'included';?></span>
                      </div>
                      <?php } ?>  
                      <?php if(isset($nonelectrical)){?>   
                      <div class="col-xs-6">
                        <span class="light">Non Electrical</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($nonelectrical) ? '₹'. indian_currency_form($nonelectrical):'included';?></span>
                      </div>
                       <?php } ?>
                    </div>
                  </div></div>
        <?php } if($data[0]['policy_type_customer'] != 3){?>
                  <div class="clearfix bord-bot mrg-B10">
                  <div class="col-md-12 padin">
                      <div class="row">
                      <div class="col-xs-6 mrg-B5 ">
                        <span class="strn">Third Party</span>
                      </div>
                      <div class="col-xs-6 mrg-B5 text-right ">
                        <span class="strn"><?php echo '₹'. indian_currency_form($thirdParty);?></span>
                      </div>
                      <?php
                      if($basicThirdParty!=''){
                        ?>    
                      <div class="col-xs-6">
                        <span class="light">Basic Third Party</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($basicThirdParty) ? '₹'. indian_currency_form($basicThirdParty):'0';?></span>
                      </div>
                      <?php
                      }
                      if($data[0]['passenger_cover']=='1'){
                        $passenger_cover=$data[0]['passenger_cover_txt'];?>    
                      <div class="col-xs-6">
                        <span class="light">Passenger Cover</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($passenger_cover) ? '₹'. indian_currency_form($passenger_cover):'0';?></span>
                      </div>
                      <?php
                      }
                      if($data[0]['personal_acc_cover']=='1'){
                        $personal_acc_cover=$data[0]['personal_acc_cover_txt'];?>
                        <div class="col-xs-6">
                        <span class="light">Personal Accidental Cover</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($personal_acc_cover) ? '₹'. indian_currency_form($personal_acc_cover):'included';?></span>
                      </div>
                    <?php      
                    }
                      if($data[0]['driver_cover']=='1'){
                        $driver_cover=$data[0]['driver_cover_txt'];?>
                        <div class="col-xs-6">
                        <span class="light">Liability to paid driver</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($driver_cover) ? '₹'. indian_currency_form($driver_cover):'included';?></span>
                      </div>
                    <?php
                    }
                    ?>    
                      </div></div></div>
<?php }?>
        <?php if($data[0]['policy_type_customer'] != 2){?>
                    <div class="clearfix bord-bot mrg-B10">
                   <div class="col-md-12 padin">    
                      <div class="row">
                      <div class="col-xs-6 mrg-B5 ">
                        <span class="strn">AddOns</span>
                      </div>
                    <?php
                    $bundleKey='';
                    $bundleFlag=false;
                    if($data[0]['invoice_cover']=='1'){
                    $bundleKey.='Invoice Cover';
                    $bundleFlag=true;
                    }
                    if($data[0]['consumables']=='1'){
                        if($bundleFlag==true){    
                        $bundleKey.=' + Consumables';
                        }else{
                        $bundleKey.='Consumables';    
                        }
                      $bundleFlag=true;  
                    }
                    if($data[0]['engine_cover_box']=='1'){
                        if($bundleFlag==true){     
                        $bundleKey.=' + Engine Cover Box';
                        }else{
                        $bundleKey.='Engine Cover Box';    
                        }
                       $bundleFlag=true; 
                    }
                    if($data[0]['key_replacement']=='1'){
                        if($bundleFlag==true){
                        $bundleKey.=' + Key Replacement';
                        }else{
                         $bundleKey.='Key Replacement';   
                        }
                        $bundleFlag=true;
                    }
                    if($data[0]['ncb_protection_cover']=='1'){
                        if($bundleFlag==true){
                        $bundleKey.=' + Ncb Protection Cover'; 
                        }else{
                         $bundleKey.='Ncb Protection Cover';   
                        }
                       $bundleFlag=true; 
                    }
                    if($data[0]['tyre_secure']=='1'){
                        if($bundleFlag==true){
                        $bundleKey.=' + Tyre Secure';
                        }else{
                        $bundleKey.='Tyre Secure';    
                        }
                       $bundleFlag=true; 
                    }if($data[0]['zero_dep']=='1'){
                        if($bundleFlag==true){
                        $bundleKey.=' + Zero Dep';
                        }else{
                         $bundleKey.='Zero Dep';   
                        }
                        $bundleFlag=true;
                    }if($data[0]['loss_of_personal_belonging']=='1'){
                        if($bundleFlag==true){
                        $bundleKey.=' + Loss Of Personal Belonging';
                        }else{
                         $bundleKey.='Loss Of Personal Belonging';   
                        }
                        $bundleFlag=true;
                    }if($data[0]['emergency_transport_hotel_premium']=='1'){
                        if($bundleFlag==true){
                        $bundleKey.=' + Emergency Transport Hotel Premium';
                        }else{
                         $bundleKey.='Emergency Transport Hotel Premium';   
                        }
                        $bundleFlag=true;
                    } ?>    
                      <div class="col-xs-6 mrg-B5 text-right ">
                        <span class="strn"> <?php 
                        if(!empty($addOn)){
                            echo '₹'.indian_currency_form($addOn) ;
                        }elseif($bundleFlag==false){
                            echo '₹ 0';
                        }else{
                            echo '₹ 0';
                        }
                         ?></span>
                      </div>
                      <?php 
                      if($data[0]['road_side_assistance']=='1'){
                        $road_side_assistance=$data[0]['road_side_assistance_txt'];
                      ?>  
                        <div class="col-xs-6">
                        <span class="light">Road Side Assistance</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($road_side_assistance) ? '₹'. indian_currency_form($road_side_assistance):'included';?></span>
                      </div>
                    <?php
                      }
                      
                    /*if($data[0]['passenger_cover']=='1'){
                        $passenger_cover=$data[0]['passenger_cover_txt'];?>
                        <div class="col-xs-6">
                        <span class="light">Passenger Cover</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($passenger_cover) ? '₹'. indian_currency_form($passenger_cover):'included';?></span>
                      </div>      
                    <?php
                    }*/
                    ?>
                     <?php 
                      if($data[0]['anti_theft']=='1'){
                        $anti_theft=$data[0]['anti_theft_txt'];
                      ?>  
                        <div class="col-xs-6">
                        <span class="light">Anti Theft</span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($anti_theft) ? ' - '. '₹'. indian_currency_form($anti_theft):'included';?></span>
                      </div>
                    <?php
                      }?>
                      <?php if($bundleKey){
                          $budleAddOn=!empty($data[0]['add_on']) ? $data[0]['add_on']:0;
                      ?>
                      <div class="col-xs-6">
                        <span class="light"><?php echo $bundleKey;?></span>
                      </div>
                      <div class="col-xs-6 text-right">
                        <span class="light"><?php echo !empty($budleAddOn) ? '₹'. indian_currency_form($budleAddOn):'included';?></span>
                      </div>    
                      <?php } ?>    
                      </div></div></div>
<?php } ?>
                <div class="clearfix bord-bot mrg-B10">
                  <div class="col-md-12 padin">
                    <div class="row">
                      <div class="col-xs-6 mrg-B5 ">
                        <span class="strn">GST(18%)</span>
                      </div>
                      <div class="col-xs-6 mrg-B5 text-right ">
                          <?php 
                           $totgst=!empty($data[0]['gst']) ? $data[0]['gst']:0;
                          ?>
                        <span class="strn"> <?php echo !empty($totgst) ? '₹'.indian_currency_form($totgst) : 0;?></span>
                      </div>
                    </div>    
                    </div>
                </div>
                <div class="clearfix bord-bot mrg-B10">
                  <div class="col-md-12 padin">
                    <div class="row">
                      <div class="col-xs-6 mrg-B5 ">
                        <span class="strn">Total Premium</span>
                      </div>
                      <div class="col-xs-6 mrg-B5 text-right ">
                          <?php 
                          $totpremium=!empty($data[0]['totpremium']) ? $data[0]['totpremium']:0;
                          ?>
                        <span class="strn"> <?php echo !empty($totpremium) ? '₹'.indian_currency_form($totpremium) : '';?></span>
                      </div>
                    </div>  
                  </div>
                </div>
    </div>
    <?php } ?>
    
   
