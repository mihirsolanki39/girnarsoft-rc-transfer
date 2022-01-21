<div class="" id="content">
<?php
	if(empty($postInfo))
	{?>
 <div class="row">
                  <div class="col-md-12 pad-LR-10 mrg-B40">
                    <h2 class="page-title">Payment Info</h2>
		<?  $this->load->view('/finance/loanPaymentDetails'); ?>
		 </div></div>
	<?}
	else
	{


?>
 <div class="row">
        <div class="list_div col-md-12 mrg-T10">
        <div class="background-ef-tab" id="loandetails">
          <div class="tabs loandetails">
            <div class="row pad-all-20">
              <div class="col-md-6">
                <h5 class="cases"> Payment Details </h5>
              </div>
              <div class="col-md-6" style="text-align: right">
              <button class="btn btn-default" id="addpay"  onclick="makePartPayment()">Add Payment</button>
              </div>
            </div>
            <!-- Tab panes -->
            <?php if(!empty($postInfo)){?>
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
                                 
                                   <th>Instrument Type</th>
                                   <th>Instrument No.</th>
                                   <th>Drawn On Bank</th>
                                   <th>Account No.</th>
                                   <th>Instrument Date</th>
                                   <th>Amount</th>
                                   <th>Favouring</th>
                                   <th>Signed By</th>
                                   <th>Action</th>
                                   
                                </tr>
                             </thead>
                             <tbody>
                             <?php 
                             $i=1;
                             $clr = '0';
                            foreach($postInfo as $ky => $vl){
                              // echo $vl['instrument_type']; exit;
                             $i=$i++; ?>
                                <tr>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?php if($vl['instrument_type']=='1')
                                       {
                                          echo "Cheque";
                                        }else if($vl['instrument_type']=='2')
                                        {
                                            echo "ECS";
                                        }
                                        else if($vl['instrument_type']=='3')
                                        {
                                            echo "SI";
                                        }
                                        else if($vl['instrument_type']=='4')
                                        {
                                            echo "Cancelled Cheque";
                                        }
                                        else if($vl['instrument_type']=='5')
                                        {
                                            echo "Security";
                                        }

                                        ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                     <?php if($vl['instrument_type']=='1'){?>
                                     <?echo $vl['cheque_from'].(!empty($vl['cheque_to'])?' - '.$vl['cheque_to']:''); } 
                                     else 
                                     { 
                                     	echo !empty($vl['instrument_no'])?$vl['instrument_no']:'-'; 
                                     }
                                     ?> 
                                      </span>
                                    </div>
                                  </td>  
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?= !empty($vl['bank_name'])?$vl['bank_name']:''; ?>
                                      </span>
                                    </div>
                                  </td>                   
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?= !empty($vl['account_no'])?$vl['account_no']:''; ?>
                                      </span>
                                    </div>
                                  </td>
                                   <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                         <?= (!empty($vl['instrument_date']) && ($vl['instrument_date']!='0000-00-00'))?date('d M,Y',strtotime($vl['instrument_date'])):''; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                      <i class="fa fa-rupee"></i> 
                                       <?= !empty($vl['amount'])?$vl['amount']:''; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
	                                      <?= !empty($vl['favouring'])?$vl['favouring']:''; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="font-13 text-gray-customer">
                                     <span class="">
                                       <?= !empty($vl['signed_by'])?$vl['signed_by']:''; ?>
                                      </span>
                                    </div>
                                  </td>
                                  <td>
                                    <?php  $id=$vl['id'];?>
                                    <button class="btn btn-default" data-toggle="modal" data-target="#makePayment" onclick="makePartPayment(<?=$id?>)">Edit Payment</button>
                                  </td>
                                </tr>
                                <?php } ?>
                              </tbody>
                          </table>
                        </div>
                       </div>
                        <input type="hidden" name="paymentForm2" value="1" id="paymentForm2">
                            <input type="hidden" name="rolemgmt" value="<?=(!empty($rolemgmt[0]['role_name'])?$rolemgmt[0]['role_name']:'')?>" id="rolemgmt">
                        <input type="hidden" name="case_id" id="case_id" value="<?=$CustomerInfo['customer_loan_id']?>">
                        <input type="hidden" name="customer_id" id="customer_id" value="<?=$CustomerInfo['customer_id']?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>

          <div class="col-md-12 row">
                               <div class="btn-sec-width">
                                  <?php 
                                      $stylesss = 'display:block';
                                      $stylec = 'display:none';
                                      $action = '';
                                    if(((!empty($CustomerInfo['instrument_type'])) && ($rolemgmt[0]['edit_permission']=='0') && (!empty($CustomerInfo['cust_bnk_id'])))|| ($rolemgmt[0]['add_permission']=='0'))
                                      {
                                          $stylesss  = 'display:none';
                                          $stylec = 'display:block';
                                          $action = base_url('postDeliveryDetails/');

                                      } 
                                       if($CustomerInfo['cancel_id']=='0'){ ?>
                                  <button type="button" class="btn-continue saveCont" style="<?=$stylesss?>" id="paymentpopDetailsButton">SAVE AND CONTINUE</button>
                                   <button type="button" class="btn-continue" onclick="countinue('<?=$action?>')" style="<?=$stylec?>">CONTINUE</button>
                                <?php } ?>
                               </div>
                           </div>
        </div>
        </div>
      </div>
       
      <?php } ?>
</div>
<div class="modal fade" id="makePayment" role="dialog">

  <div class="modal-backdrop fade in" style="height:100%"></div>
      <div class="modal-dialog" style="width: 580px; height:100px;">
        <div class="modal-content" >

          <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/cancel.png'); ?>"> <span class="sr-only">Close</span></button>
            <h4 class="modal-title">Make Payment</h4>
          </div>
          <div id="payment_modal"></div>
        </div>
    </div>
  </div>
<script>
	function makePartPayment(id='')
    {
       	$('#makePayment').addClass(' in');
       	$('#makePayment').attr('style','display:block');
     	var type = 'add';
	    if(id!='')
	      {
	        type='edit';
	      }
        var case_id = $('#case_id').val();
    	$.ajax({
        url: base_url+"Finance/makeloanpartpayment",
        type: 'post',
        dataType: 'html',
        data: {'case_id':case_id,type:type,id:id},
        success: function(response)
        {
          $("#payment_modal").html(response);
          $('#type').val(type);
          $('#edit_id').val(id);
          $('#instrument_date').datepicker({
                format: 'dd-mm-yyyy',
                //endDate:'+1d',
                autoclose: true,
                todayHighlight: true   
             });
        }
      });
    }
    $('.close').click(function() {
      $('#makePayment').removeClass(' in');
       $('#makePayment').attr('style','display:none');
    });

    $('#paymentpopDetailsButton').click(function () {
        var admin = $('#rolemgmt').val();
        var case_id = $('#case_id').val();
        var paymentForm2 = 'paymentForm2';
        var r = true;
        if((admin!='admin') && (admin!='Loan Admin')){
          $('#loanPop').addClass(' in');
          $('#loanPop').attr('style','display:block');
          $('#frmids').val('paymentDetails');
       }
                 else{
                        $.ajax({
                          type: "POST",
                          url: base_url + "saveUpdateFinanceData",
                          data: {paymentForm2:paymentForm2,case_id:case_id},
                          //dataType: 'json',
                          success: function (response) {
                             // alert(response);
                              var data = $.parseJSON(response);
                              console.log(data);
                              if (data.status == 'True') {
                                  snakbarAlert(data.message);
                                  $('.loaderClas').attr('style','display:block;');                 
                                  setTimeout(function () {
                                      window.location.href =data.Action;
                                  }, 2500);

                                  return true;
                              } else {
                                  if(typeof data.errortype !== 'undefined' && data.errortype ==2){
                                    var model = $('#cancel_model');
                                    model.find('.modal-title').html(data.titlehead);
                                    $('.duplicatecheck').remove();
                                    model.find('.modal-body').prepend(data.message);
                                    model.find('.modal-footer').html(data.footer);
                                    $('#cancel_model').attr('style','display:block;');
                                    $('#cancel_model').addClass(' in');
                                  }else {
                                    snakbarAlert(data.message);
                                    return false;
                                  }
                              }
                          }
                      });
                  }
        // saveCaseInfoData(formData);

    });
</script>