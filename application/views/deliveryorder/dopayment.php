<?php 
$i = 1; ?>
  <div class="container-fluid pad-T20 bg-container-new mrg-T70" id="maincontainer">
   <div class="row">
      <div id="payment_stock_div" class="">


        <div class="col-lg-12 col-md-12 mrgBatM clearfix pad-R15 pad-L15" id="topSection">
           <div class="background-efOne background-efTwo bgImgN">
              <div class="row">
                 <div class="col-md-12">
                    <div class="total-lead-recieved clearfix">
                       <ul class="mrg-all-0 pad-all-0">
                          <li class="pull-left font-16 col-black-o">Payment Summary</li>
                       </ul>
                    </div>
                 </div>
                 <div class=" col-md-12 total-lead-digit">
                    <div class="row mrg-all-0">
                       <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                           <a href="javascript:void(0);">
                             <p class="font-36 col-green"><span class="font-18"> ₹ </span> <span id="purchaseamt"><?=$showroom?></span></p>
                             <p class="font-18 col-black-o">Showroom Balance</p>
                          </a>
                       </div>
                       <div class="col-md-4 col-sm-3 col-xs-3 cus-col">
                          <a href="javascript:void(0);">
                             <p class="font-36 col-yellow"><span class="font-18"> ₹ </span>  <span id="amtPaid"><?=$inhouse?></span></p> </a>
                             <p class="font-18 col-black-o">Customer Balance</p>
                      </div>

                      
                    </div>
                 </div>
              </div>
           </div>
        </div>

</div>
       

        
        
        <div class="list_div col-md-12">
        <div class="background-ef-tab mrg-T20" id="loandetails">
          <div class="tabs loandetails">
            <div class="row pad-all-20">
              <div class="col-md-6">
                <h5 class="cases"> Payment To Showroom </h5>
              </div>
              <div class="col-md-6" style="text-align: right">
              <button class="btn btn-default"  onclick="makePayment('','','1')">Add Payment</button>
              </div>
            </div>
            <!-- Tab panes -->
            <?php if(!empty($paymentshow)){?>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                <div class="container-fluid ">
                  <div class="row">
                    <div class="col-lg-12 col-md-12">
                      <div class="row">
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                             <thead>
                                <tr>
                                  
                                  <th>Payment By</th>
                                   <th>Amt. Paid</th>
                                   <th>Date Of Payment</th>
                                   <th>Payment Mode</th>
                                   <th>Instrument Date</th>
                                   <th>Instrument Number</th>
                                   <th>Bank Name</th>
                                   <th>Remark</th>
                                   <th>Action</th>
                                   
                                </tr>
                             </thead>
                             <tbody class="do_showroom_cases">
                             <?php 
                             $i=1;
                             foreach($paymentshow as $ky => $vl){

                             $i=$i++; ?>
                                <tr>
                                 
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_by']=='1')
                                       {
                                          echo "Customer";
                                        }else if($vl['payment_by']=='2')
                                        {
                                            echo "Inhouse";
                                        }
                                        else if($vl['payment_by']=='3')
                                        {
                                            echo "Bank";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="do_showroom_amount">
                                       <i class="fa fa-rupee"></i> <?=$vl['amount']?> 
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=date('d M, Y',strtotime($vl['payment_date']))

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_mode']=='1')
                                       {
                                          echo "Cash";
                                        }else if($vl['payment_mode']=='2')
                                        {
                                            echo "Cheque";
                                        }
                                        else if($vl['payment_mode']=='3')
                                        {
                                            echo "DD";
                                        }
                                        else if($vl['payment_mode']=='4')
                                        {
                                            echo "Online";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <?php if(!empty($vl['instrument_date']) && $vl['instrument_date'] != "0000-00-00") {?>
                                            <?php if($vl['payment_mode'] != 1 && $vl['payment_mode'] != 4) { ?>
                                                <?=date('d M, Y',strtotime($vl['instrument_date']))?>
                                         <?php }} ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">

                                         <?php if($vl['payment_mode']!='1')
                                       { ?>
                                          <?=$vl['instrument_no'];?>
                                       <?php }?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <?php if(($vl['payment_mode']=='2') ||($vl['payment_mode']=='3') ){ echo $vl['bank_name']; } else{ echo ""; }?>
                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=$vl['pay_remark']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <?php  $id=$vl['id'];?>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment('1',<?=$id?>,'1')">Edit Payment</button>
                                    
                                  </td>
                                </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                        </div>
                       </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        </div>
        

        <div class="list_div col-md-12 mrg-T30">
            <div class="background-ef-tab" id="loandetails">
              <div class="tabs loandetails">
                <div class="row pad-all-20">
                  <div class="col-md-6">
                    <h5 class="cases"> Payment To Inhouse</h5>
                  </div>
                  <div class="col-md-6" style="text-align: right">
                  <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment('','','2')">Add Payment</button>
                  </div>
                </div>
                <!-- Tab panes -->
                <?php if(!empty($Clearanceshow)){?>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                    <div class="container-fluid ">
                      <div class="row">
                        <div class="col-lg-12 col-md-12">
                          <div class="row">
                            <div class="table-responsive">
                              <table class="table table-bordered table-striped table-hover enquiry-table mytbl">
                                 <thead>
                                    <tr>
                                      
                                       <th>Payment By</th>
                                       <th>Amt. Paid</th>
                                       <th>Date Of Payment</th>
                                       <th>Payment Mode</th>
                                       <th>Instrument Date</th>
                                       <th>Instrument Number</th>
                                       <th>Bank Name</th>
                                       <th>Remark</th>
                                       <th>Action</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody class="do_payment_cases">
                                 <?php
                                    $i=1;
                                 //   echo "<pre>";print_r($Clearance);die;
                             foreach($Clearanceshow as $ky => $vl){

                             $i=$i++; ?>
                                <tr>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_by']=='1')
                                       {
                                          echo "Customer";
                                        }else if($vl['payment_by']=='2')
                                        {
                                            echo "Bank";
                                        }
                                        else if($vl['payment_by']=='3')
                                        {
                                            echo "Showroom";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                        <span class="do_amount_commas" id="<?=$vl['id']?>" >
                                       <i class="fa fa-rupee"></i> <?=$vl['amount']?> 
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=date('d M, Y',strtotime($vl['payment_date']))?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['payment_mode']=='1')
                                       {
                                          echo "Cash";
                                        }else if($vl['payment_mode']=='2')
                                        {
                                            echo "Cheque";
                                        }
                                        else if($vl['payment_mode']=='3')
                                        {
                                            echo "DD";
                                        }
                                        else if($vl['payment_mode']=='4')
                                        {
                                            echo "Online";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                          <?php if(!empty($vl['instrument_date']) && $vl['instrument_date'] != "0000-00-00") {?>
                                             <?php if($vl['payment_mode'] != 1 && $vl['payment_mode'] != 4) { ?>
                                                <?=date('d M, Y',strtotime($vl['instrument_date']))?>
                                             <?php } } ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <?=$vl['instrument_no']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <? if(($vl['payment_mode']=='2') ||($vl['payment_mode']=='3') ){ echo $vl['bank_name'] ;} else{ echo ""; }?>
                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                        <?=$vl['pay_remark']?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <?php  $id=$vl['id'];?>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePayment('1',<?=$id?>,'2')">Edit Payment</button>
                                    
                                  </td>
                                </tr>
                                <?php } ?>
                                  </tbody>
                              </table>
                            </div>
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php  }   $action = base_url('orderListing/');?>
            </div></div>
            <div class="col-md-12 row mrg-B20">
                <div class="btn-sec-width">
                    <input type="hidden" name="case_id" id="case_id" value="<?=$orderinfo['orderId']?>">
                    <button type="button" class="btn-continue saveCont" onclick="countinue('<?=$action?>')" style="display:block" id="paydetails">SAVE AND CONTINUE</button>
                </div>
            </div>
</div>
       
   </div>
  </div>
  <div class="modal fade" id="makePayment" role="dialog">
  <div class="modal-backdrop fade in" style="height:100%"></div>
      <div class="modal-dialog" style="width: 580px; height:100px;">
        <div class="modal-content">
          <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
            <h4 class="modal-title">Make Payment</h4>
          </div>
          <div id="payment_modal"></div>
        </div>
    </div>
  </div>
  <script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
    <script>
        $(document).ready(function(){
          
          $(".do_payment_cases").find(".do_amount_commas").each(function(){
                var val = $(this).text();
                var id = $(this).attr('id');                
                var val_Comma = convertToIndianCurrency(val,'','1','1');   
                $(this).html("");
                $(this).html("<i class='fa fa-rupee'></i> "+val_Comma);
            })  
             $(".do_showroom_cases").find(".do_showroom_amount").each(function(){
                var val = $(this).text();
                var id = $(this).attr('id');                
               var val_Comma = convertToIndianCurrency(val,'','1','1');   
                $(this).html("");
                $(this).html("<i class='fa fa-rupee'></i> "+val_Comma);
            })  
        })
         
    function makePayment(flag='',id='',tp="")
    {
       $('#makePayment').addClass(' in');
       $('#makePayment').attr('style','display:block');
      var type = 'add';
      if(flag!='')
      {
        type='edit';
      }
      var case_id = $('#case_id').val();
      $.ajax({
        url: base_url+"DeliveryOrder/makepayment",
        type: 'post',
        dataType: 'html',
        data: {'case_id':case_id,type:type,id:id},
        success: function(response)
        {
          $("#payment_modal").html(response);
          $('#type').val(type);
          $('#edit_id').val(id);
          $('#tp').val(tp);
          $('#receiptdate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true   
          });
          var d = "<?=date('dd-mm-yyyy')?>";
          $('#paydates').datepicker({
              format: 'dd-mm-yyyy',
              endDate:'d',
              autoclose: true,
              todayHighlight: true   
          });
          $('#instrument_date').datepicker({
              format: 'dd-mm-yyyy',
              autoclose: true,
              todayHighlight: true   
          });
        }
      });
    }
    $('.close').click(function() {
      $('#makePayment').removeClass(' in');
       $('#makePayment').attr('style','display:none');
    })

    function saveEditData(flag='')
    {
      var instrumenttype      = $.trim($('#payment_by').val());
       var paymentmode      = $.trim($('#payment_mode').val());
      var amount              = $.trim($('#amount').val());
      var paydates            = $.trim($('#paydates').val());
      var insno               = $.trim($('#instrument_no').val());
      var insdate             = $.trim($('#instrument_date').val());
      var payment_bank        = $.trim($('#payment_banks').val());
      var favouring           = $.trim($('#favourings').val());
      var workshop_id         = $.trim($('#workshop_id').val());
      var edit_id             = $.trim($('#edit_id').val());
      var remark             = $.trim($('#remark').val());
      var cust             = $.trim($('#cust').val());
      var payamount = amount.replace(/,/g, "");
    
      var error               = 0;
      $(".error").html("");

      if(instrumenttype == '0'){
        $("#err_instrumenttypes").html("Please select Payment By.");
        error++;
      }

      if(paymentmode == '0'){
        $("#err_paymentmode").html("Please select Payment Mode.");
        error++;
      }
      if(amount == ''){
        $("#err_amounts").html("Please enter amount.");
        error++;
      }
      if(flag==''){
        if((paymentmode=='1') && (parseInt(payamount) > 200000))
        {
          getCashAlert();
          return false;
        }
      }
      if(parseInt(payamount) >= 100000000){
         $("#err_amounts").html("Entered amount should be less than 10 crore");
        error++;  
      }
      if(paydates == ''){
        $("#err_paydate").html("Please select payment date.");
        error++;
      }

      if(paymentmode=='2')
      {
          /*if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }

          if(insdate == ''){
            $("#err_insdates").html("Please select instrument date.");
            error++;
          }

          if(payment_bank == ''){
            $("#err_bank_lists").html("Please select bank name.");
            error++;
          }

          if(favouring == ''){
            $("#err_favourings").html("Please enter favouring.");
            error++;
          }*/
      }

      if(paymentmode=='3')
      {
         /* if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }

          if(insdate == ''){
            $("#err_insdates").html("Please select instrument date.");
            error++;
          }

          if(favouring == ''){
            $("#err_favourings").html("Please enter favouring.");
            error++;
          }*/
      }

      if(paymentmode=='4')
      {
          /*if(insno == ''){
            $("#err_insnos").html("Please enter instrument no.");
            error++;
          }*/
      }
      
      if(error > 0){
        return false;
      } else{
        $(".loaderClas").show();
         var formData=$('#CaseInfoForm').serialize();
        $.ajax({
          url: base_url+"DeliveryOrder/save_payment",
          type: 'post',
          dataType: 'json',
          data:formData,
          //data:{instrumenttype:instrumenttype,amount:amount,insno:insno,insdate:insdate,payment_bank:payment_bank,favouring:favouring,paydates:paydates,workshop_id:workshop_id,edit_id:edit_id,remark:remark},
          success: function(response) 
          {
            $(".loaderClas").hide();
            setTimeout(function(){ location.href = base_url+"dopayment/"+cust; }, 300);
          }   
        });
      }

    }

    function getCashAlert()
    {
          bootbox.confirm({
          message: "Are you sure you want to add Cash entry for more than 2 Lakhs?",
          buttons: {
              confirm: {
                  label: 'Yes',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'Cancel',
                  className: 'btn-danger'
              }
          },
          callback: function (result) {
              if(result==false)
              {
                
              }
              else
              {
                  saveEditData(1);
              }
          }
      });
    }
 function countinue(action)
      {
         window.location.href = action;
      }

    function addCommased(nStr,control,flag='')
    {
     // alert(nStr);
     if(flag==''){
      nStr=nStr.replace(/,/g,''); 
    }else
    {
        nStr=nStr; 
    }
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{2})/;
      var len;
      var x3="";
      len=x1.length;
      if(len>3){
        var par1=len-3;

        x3=","+x1.substring(par1,len);
        x1=x1.substring(0,par1);

        //alert(x3);
      }
      len=x1.length;
      if(len>=3 && x3!=""){
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      }
            document.getElementById(control).value=x1 +x3+x2;
    }
   function convertToIndianCurrency(nStr,control,flag='',flag1 ='')
  {
        if(flag==1){
            nStr=nStr.replace(/,/g,''); 
        }else
        {
            nStr=nStr; 
        }     
        x=nStr.toString();
        var afterPoint = '';
        if(x.indexOf('.') > 0)
           afterPoint = x.substring(x.indexOf('.'),x.length);
        x = Math.floor(x);
        x=x.toString();
        var lastThree = x.substring(x.length-3);
        var otherNumbers = x.substring(0,x.length-3);
        if(otherNumbers != '')
            lastThree = ',' + lastThree;
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
         if(flag1 == 1)
            return res;
        else
            document.getElementById(control).value=res;
  }
</script>
  
