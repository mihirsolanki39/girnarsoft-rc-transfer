         <?php 
         $str = "##@";
           if(!empty($loan_listing))
           {
              $services = '';
               $countArr = array_count_values($loan_list_id);
               $dateLable = '';
               foreach($loan_listing as $key => $value)
               {
                  $linkk =$value['link'];
                  $datetime = '';
                  if (!empty($value['loanid'])) 
                  {
                     $countmore = (int)$countArr[$value['loanid']]-1;
                  }
                  if($value['services']=='1')
                  {
                    $services = 'Denting';
                  }
                  if($value['services']=='2')
                  {
                    $services = 'Painting';
                  }
                  if($value['services']=='3')
                  {
                    $services = 'Washing';
                  }
                  if($value['services']=='4')
                  {
                    $services = 'Engine Repair';
                  }
                  if($value['services']=='5')
                  {
                    $services = 'AC Repair';
                  }
                ?>
             <tr class="hover-section"> 
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b><?=$value['name']?></b></div>
                                                      <div class="font-13 text-gray-customer"><span class="font-13"><?=$value['mobile']?></span><br><?=$value['service']?></div>
                                                       <div><span class="text-gray-customer font-13">Services : <?=$services?></span></div>
                                                      <div><span class="text-gray-customer font-13">Added On : <?=$value['created_on']?></span></div>
                                                   </td>
                                                   <td style="position:relative">
                                                      <div class="mrg-B5"><b>
                                                      <?php 
                                                         if(!empty($value['owner_name'])){
                                                         echo (!empty($value['owner_name'])?$value['owner_name'].', ':''). $value['owner_mobile'];
                                                         }
                                                         else
                                                         {  
                                                            echo "NA";

                                                            }?></b></div>
                                                   
                                                   <td>
                                                      <div >
                                                        <a href="<?=$linkk?>" ><button data-target="#booking-done" data-toggle="tooltip" title="view detail" data-placement="top" class="btn btn-default">VIEW DETAILS</button></a>
                                                      </div>
                                                   </td>
                                                </tr>
                                                <?php } } if(empty($loan_listing))
           { echo "1"; exit;}?>




      <script type="text/javascript">
    $('#total_count').text('('+"<?=$total_count?>"+')');
</script>


                                               
