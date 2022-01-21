<div id="content">
  <div class="container-fluid mrg-all-20 mrg-T0 pad-all-0">
         <div class="row" id="topSection">
         <?php 
        // echo DEALER_ID;
         $is_classified = '';
         $is_classified=!empty($this->session->userdata['userinfo']['is_classified'])?$this->session->userdata['userinfo']['is_classified']:'';
         if($is_classified=='1'){?>
         <!--<div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Stock Report Card</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                               <a href="<?php echo base_url('inventoryListing/1');?>">
                                 <p class="font-60 col-green bold"><?php echo (!empty($stockCount)) ? $stockCount  :0;?></p>
                                 <p class="font-18 col-black-o">Active Cases</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('inventoryListing/2');?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($stock45Count)) ? $stock45Count  :0;?></p>
                                 <p class="font-18 col-black-o">Age > 45 days</p>
                              </a>
                           </div>
                        </div>
                     </div>
                      
                  </div>
               </div>
            </div>    
          <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Month Leads Summary</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                               <a href="<?php echo base_url('lead/getLeads?filter=dash&&type=all');?>">
                                 <p class="font-60 col-green bold"><?php echo (!empty($leadCount['leadAdded'])) ? $leadCount['leadAdded']  :0;?></p>
                                 <p class="font-18 col-black-o">Leads Added</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <?php if(!empty($leadCount['walkdone'])){ ?>
                              <a href="<?php echo base_url('lead/buyerleadlist/walkin');?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadCount['walkdone'])) ? $leadCount['walkdone']  :0;?></p>
                                 <p class="font-18 col-black-o">Walk In Done</p>
                              </a>
                               <?php } else { ?>
                                 <p class="font-60 col-red bold">0</p>
                                 <p class="font-18 col-black-o">Walk In Done</p>
                               <?php } ?>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <?php if(!empty($leadCount['converted'])){?> 
                              <a href="<?php echo base_url('lead/buyerleadlist/converted');?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadCount['converted'])) ? $leadCount['converted']  :0;?></p>
                                 <p class="font-18 col-black-o">Conversions</p>
                              </a>
                              <?php }else{?>
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadCount['converted'])) ? $leadCount['converted']  :0;?></p>
                                 <p class="font-18 col-black-o">Conversions</p>
                              <?php  } ?>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('lead/getLeads?filter=dash&&pendingleads=pendingleads&viewlead=viewlead');?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadPending)) ? $leadPending  :0;?></p>
                                 <p class="font-18 col-black-o">Pending</p>
                              </a>
                           </div> 
                        </div>
                     </div>
                      
                  </div>
               </div>
            </div>  --> 
         <?php }else{
         //echo "<pre>";
         //print_r($rolemgmt);
      //    exit;
//echo print_r($rolemgmt);die;
            if((!empty($rolemgmt[0]['role_name'])) && ((($rolemgmt[0]['role_name']=='Executive') || ($rolemgmt[0]['role_name']=='Used Car') || ($rolemgmt[0]['role_name']=='New Car') || ($rolemgmt[0]['role_name']=='Refinance')  || ($rolemgmt[0]['role_name']=='Loan Admin')) && ($rolemgmt[0]['team_name']=='Loan')) || ($rolemgmt[0]['role_name']=='admin') && ((DEALER_ID=='49') || (DEALER_ID=='69') || (DEALER_ID=='6359')) || ((strtolower($rolemgmt[0]['role_name'])=='accountant'))){?>
         
                      <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Loan Report Cards</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('loanListing/1');?>">
                                 <p class="font-60 col-green bold"><?php echo (!empty($loanCount['ActiveCases'])) ? $loanCount['ActiveCases'] :0;?></p>
                                 <p class="font-18 col-black-o">Active Cases</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('loanListing/2');?>">
                                 <p class="font-60 col-darkyello bold"><?php echo (!empty($loanCount['AwaitLoginCount'])) ? $loanCount['AwaitLoginCount'] :0;?></p>
                                 <p class="font-18 col-black-o">Awaiting Login</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('loanListing/3');?>">
                                 <p class="font-60 col-darkyello bold"><?php echo (!empty($loanCount['AwaitDecisionCount'])) ? $loanCount['AwaitDecisionCount'] :0;?></p>
                                 <p class="font-18 col-black-o">Awaiting Decision</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('loanListing/4');?>">
                                 <p class="font-60 col-darkyello bold"><?php echo (!empty($loanCount['DisbursedCount'])) ? $loanCount['DisbursedCount'] :0;?></p>
                                 <p class="font-18 col-black-o">Awaiting Disbursal</p>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } if((!empty($rolemgmt[0]['role_name'])) && ((($rolemgmt[0]['role_name']!='Used Car') && ($rolemgmt[0]['role_name']!='New Car') && ($rolemgmt[0]['role_name']!='Refinance') && ((!empty($rolemgmt[0]['team_name'])) && ($rolemgmt[0]['team_name']!='Delivery'))) || ((!empty($rolemgmt[0]['role_name'])) && ($rolemgmt[0]['role_name']=='admin') || ($rolemgmt[0]['team_name']=='RC') || ($rolemgmt[0]['team_name']=='RC Transfer') || ($rolemgmt[0]['team_name']=='Sales'))) && ((DEALER_ID=='49')||(DEALER_ID=='69'))){?>
             <?php if(($rolemgmt[0]['role_name']=='admin') || ($rolemgmt[0]['team_name']=='RC Transfer') || ($rolemgmt[0]['team_name']=='RC') || ($rolemgmt[0]['team_name']=='Sales') && ((DEALER_ID=='49')||(DEALER_ID=='69') || (DEALER_ID=='6359'))){ ?>
            <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">RC Status</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="#">
                                 <p class="font-60 col-green bold">
                                     <a href="<?php echo base_url('rcListing/1');?>">
                                     <?php echo (!empty($rcCount['PendingCases'])) ? $rcCount['PendingCases'] :0;?>
                                     </a>
                                 </p>
                                 <p class="font-18 col-black-o">Pending Cases</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="#">
                                 <p class="font-60 col-red bold">
                                     <a href="<?php echo base_url('rcListing/2');?>">
                                     <?php echo (!empty($rcCount['InProcessCases'])) ? $rcCount['InProcessCases'] :0;?>
                                     </a>
                                </p>
                                 <p class="font-18 col-black-o">In Process</p>
                              </a>
                           </div>
            
            
                        </div>
                     </div>
                  </div>
               </div>
            </div>
             <?php } ?>
             <?php if(!empty($rolemgmt[0]['role_name']) && ($rolemgmt[0]['role_name']=='admin') || ($rolemgmt[0]['role_name']=='Executive') && ((DEALER_ID=='49') || (DEALER_ID=='69'))){ ?>
             <?php if(!empty($rolemgmt[0]['team_name']) && ((!empty($rolemgmt[0]['team_name'])) && ($rolemgmt[0]['team_name']=='RC Transfer')) || ((!empty($rolemgmt[0]['team_name'])) && ($rolemgmt[0]['team_name']=='RC')) || ((!empty($rolemgmt[0]['team_name'])) && ($rolemgmt[0]['team_name']=='Sales')) || ($rolemgmt[0]['role_name']=='admin') && ((DEALER_ID=='49') || (DEALER_ID=='69') || (DEALER_ID=='6359'))) { ?>  
            <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Bank Limit Left</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                            <?php if(!empty($bank)){
                              $i = 1;
                              foreach($bank as $bval => $kbnk) {
                               $arrbank = (!empty($kbnk['leftAmountRound'])) ? $kbnk['leftAmountRound'] :0;
                               if($arrbank>0)
                               {
                                  $bnkArr = explode('-',$arrbank);
                               }

                            ?>
                             
                                 <?php if($i< 4){?>
                                  <div class="col-md-3 col-sm-3 col-xs-3 cus-col hideMore" >
                                 <a href="#">
                     <p class="font-60 col-orange bold"> <span class="font-24"> &#x20B9 </span> <?php echo (!empty($bnkArr[0]) ? $bnkArr[0]:'0')  ?><span class="font-18"> <?php echo (!empty($bnkArr[1]) ? $bnkArr[1]:'')  ?></span> </p>
                                   


                                    <p class="font-18 col-black-o"><?=(!empty($kbnk['bank_name'])) ? $kbnk['bank_name'] :'' ?></p>
                                 </a>
                                   </div>
                                 <?php } else if($i==4)
                                 { ?>
                                  <div class="col-md-3 col-sm-3 col-xs-3 cus-col hideMore" >
                                    <a onclick="showMoreBnk()" >
                           
                                    <p class="font-18 mrg-T50 col-orange">MORE</p>
                                    </a>
                                      </div>
                                    <?php } ?>
                             
                           
                            <?php $i++;
                            }
                             foreach($bank as $bvals => $kbnks) {
                               $arrbanks = (!empty($kbnks['leftAmountRound'])) ? $kbnks['leftAmountRound'] :0;
                               if($arrbanks>0)
                               {
                                  $bnkArrs = explode('-',$arrbanks);
                               }
                            ?>
                              <div class="col-md-3 col-sm-3 col-xs-3 cus-col showMoreBnk"  style="display: none;">
                                 

                                 <a href="#">
                                     <p class="font-60 col-orange bold"> <span class="font-24"> &#x20B9 </span> <?php echo (!empty($bnkArrs[0]) ? $bnkArrs[0]:'0')  ?><span class="font-18"> <?php echo (!empty($bnkArrs[1]) ? $bnkArrs[1]:'')  ?></span> </p>
                                     <p class="font-18 col-black-o"><?=(!empty($kbnks['bank_name'])) ? $kbnks['bank_name'] :'' ?></p>
                                 </a>
                                
                              </div>
                           
                            <?php 
                            }
                           // $i++;
                            } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
             <?php } } }?>

             <?php if(((($rolemgmt[0]['role_name']=='Executive') || ($rolemgmt[0]['role_name']=='Lead')) && ((!empty($rolemgmt[0]['team_name'])) && ($rolemgmt[0]['team_name']=='Insurance') || ($rolemgmt[0]['team_name']=='Sales'))) || ($rolemgmt[0]['role_name']=='admin')|| (($rolemgmt[0]['role_name']=='Purchase Executive')) && ($rolemgmt[0]['team_name']!='Used Car')){?>
            <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Insurance</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                               <a href="<?php echo (!empty($insuranceCount['ActiveCases'])) ?base_url('insListing/1') :'#';?>">
                                 <p class="font-60 col-green bold"><?php echo (!empty($insuranceCount['ActiveCases'])) ? $insuranceCount['ActiveCases'] :0;?></p>
                                 <p class="font-18 col-black-o">Active Cases</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo (!empty($insuranceCount['PoliciesPendingCases'])) ?base_url('insListing/2') :'#';?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($insuranceCount['PoliciesPendingCases'])) ? $insuranceCount['PoliciesPendingCases'] :0;?></p>
                                 <p class="font-18 col-black-o">Policies Pending</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo (!empty($insuranceCount['PayPendingCases'])) ?base_url('insListing/3') :'#';?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($insuranceCount['PayPendingCases'])) ? $insuranceCount['PayPendingCases'] :0;?></p>
                                 <p class="font-18 col-black-o">Payment Pending</p>
                              </a>
                           </div> 
                            <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo (!empty($insuranceCount['pendingRenew'])) ?base_url('renewlisting') :'#';?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($insuranceCount['pendingRenew'])) ? $insuranceCount['pendingRenew'] :0;?></p>
                                 <p class="font-18 col-black-o">Pending Renewals</p>
                              </a>
                           </div> 
            
            
                        </div>
                     </div>
                  </div>
               </div>
            </div> 
            <?php } ?>
            <?php if(!empty($rolemgmt[0]['team_name']) && (($rolemgmt[0]['team_name']=='Delivery')) || (!empty($rolemgmt[0]['role_name']) && ($rolemgmt[0]['role_name']=='admin')) && ((DEALER_ID=='49') || (DEALER_ID=='69') || (DEALER_ID=='6359'))){?>   

             <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Delivery Order</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="#">
                                 <p class="font-60 col-green bold">
                                     <a href="<?php echo base_url('orderListing/1');?>">
                                     <?php echo (!empty($dcCount['FlaggedCases'])) ? $dcCount['FlaggedCases'] :0;?>
                                     </a>
                                 </p>
                                 <p class="font-18 col-black-o">Loan Pending Cases</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="#">
                                 <p class="font-60 col-green bold">
                                     <a href="<?php echo base_url('orderListing/2');?>">
                                     <?php echo (!empty($dcCount['Paymentpending'])) ? $dcCount['Paymentpending'] :0;?>
                                     </a>
                                 </p>
                                 <p class="font-18 col-black-o">Payment Pending Cases</p>
                              </a>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
            </div>
            <?php } ?>
            <?php if((!empty($rolemgmt[0]['team_name'])) && (($rolemgmt[0]['team_name']=='Used Car') && (($rolemgmt[0]['role_name']=='Purchase Executive') || ($rolemgmt[0]['role_name']=='Sales Executive') || ($rolemgmt[0]['role_name']=='Senior Manager'))) || ($rolemgmt[0]['role_name']=='admin') && ((DEALER_ID=='49') || (DEALER_ID=='69') || (DEALER_ID=='6359'))){?>  
            <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Stock Report Card</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                               <a href="<?php echo base_url('inventoryListing/1');?>">
                                 <p class="font-60 col-green bold"><?php echo (!empty($stockCount)) ? $stockCount  :0;?></p>
                                 <p class="font-18 col-black-o">Active Cases</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('inventoryListing/2');?>">
                                 <p class="font-60 col-red bold"><?php echo (!empty($stock45Count)) ? $stock45Count  :0;?></p>
                                 <p class="font-18 col-black-o">Age > 45 days</p>
                              </a>
                           </div>
                        </div>
                     </div>
                      
                  </div>
               </div>
            </div>
             <div class="col-lg-12 col-md-12 mrgBatM">
               <div class="background-efOne bgImgN">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="total-lead-recieved clearfix">
                           <ul class="mrg-all-0 pad-all-0">
                              <li class="pull-left font-16 col-black-o Bold">Month Leads Summary</li>
                           </ul>
                        </div>
                     </div>
                     <div class=" col-md-12 total-lead-digit">
                        <div class="row mrg-all-0">
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                               <a href="<?php echo base_url('lead/getLeads/currleadadd');?>" target="_blank">
                                 <p class="font-60 col-green bold"><?php echo (!empty($totlead)) ? $totlead  :0;?></p>
                                 <p class="font-18 col-black-o">Leads Added</p>
                              </a>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                               <?php if(!empty($leadCount['walkdone'])){ ?>
                              <a href="<?php echo base_url('getdashboardlistpage/walkin');?>" target="_blank">
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadCount['walkdone'])) ? $leadCount['walkdone']  :0;?></p>
                                 <p class="font-18 col-black-o">Walk In Done</p>
                              </a>
                               <?php } else { ?>
                                 <p class="font-60 col-red bold">0</p>
                                 <p class="font-18 col-black-o">Walk In Done</p>
                               <?php } ?>
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <?php if(!empty($leadCount['converted'])){?> 
                              <a href="<?php echo base_url('getdashboardlistpage/conversion');?>" target="_blank">
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadCount['converted'])) ? $leadCount['converted']  :0;?></p>
                                 <p class="font-18 col-black-o">Conversions</p>
                              </a>
                              <?php }else{?>
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadCount['converted'])) ? $leadCount['converted']  :0;?></p>
                                 <p class="font-18 col-black-o">Conversions</p>
                              <?php  } ?> 
                           </div>
                           <div class="col-md-3 col-sm-3 col-xs-3 cus-col">
                              <a href="<?php echo base_url('lead/getLeads/pending');?>" target="_blank">
                                 <p class="font-60 col-red bold"><?php echo (!empty($leadPending)) ? $leadPending  :0;?></p>
                                 <p class="font-18 col-black-o">Pending</p>
                              </a>
                           </div> 
                        </div>
                     </div>
                      
                  </div>
               </div>
            </div>
            <?php } }?>
         </div>
      </div>
    </div>
      <script>
         function showMoreBnk()
         {
            $('.showMoreBnk').attr('style','display:block');
            $('.hideMore').attr('style','display:none');
         }
      </script>
