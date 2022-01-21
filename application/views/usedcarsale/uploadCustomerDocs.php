   <link href="<?php echo base_url(); ?>assets/css/imageviewer.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/common_new.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/dropzone_loan.css" rel="stylesheet">
   <?php 
   if((!empty($disbural)))
    {
      $onclick = 'disbursement();';
      $href = '#disbursement';
    }
    else
    {
      $href = '#';
      $onclick = 'return false;';
    }
    ?>
 <div class="container-fluid">
            <div class="row">
               <div class="col-md-12 pad-LR-10 mrg-B40">
                  <h2 class="page-title">Upload Sales Docs</h2>
                  <div class="white-section upload-docs">
                     <div class="row">
                        <div class="col-md-12">
                           <!-- Nav tabs -->
                           <div class="card">
                              <ul class="nav nav-tabs" role="tablist">
                                <?php if($form=='doc_details') {?> <li role="presentation" class="active"><a href="#login" onclick="login();" aria-controls="login" role="tab" data-toggle="tab">Documents</a></li><?php } ?>
                                <?php if($form=='vehicle_details') {?>  <li role="presentation"><a id="diss" href="<?=$href?>" onclick="<?=$onclick?>"  aria-controls="disbursement" role="tab" data-toggle="tab">Vehicle Docs</a></li><?php } ?>
                              </ul>
                              <div class="tab-content">
                               <div role="tabpanel" class="tab-pane active" id="login">
                               </div>
                                <div role="tabpanel" class="tab-pane" id="disbursement">
                                </div>
                              </div>
                            </div>
                            <input type="hidden" name="cust_id" value="<?=(!empty($CustomerInfo['customer_id']))?$CustomerInfo['customer_id']:''?>" id="cust_id">
                            <input type="hidden" name="cases_id" value="<?=(!empty($CustomerInfo['case_id']))?$CustomerInfo['case_id']:''?>" id="cases_id">
                            <input type="hidden" name="disbre" id="disbre" value="<?=(!empty($disbural)?$disbural:'')?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
</div>
<script src="<?= base_url('assets/js/dropzone_loan.js'); ?>"></script> 
     <!--<script src="<//?php echo base_url(); ?>assets/js/sorting.js"></script>-->
      <script src="<?php echo base_url(); ?>assets/js/imageviewer.js"></script>
<script>
 $(document).ready(function(){
   /*  $('body').on('click','.del-btns',function(){
         $(this).parents('.dz-preview').hide();
     });
*/
  var disbre = $('#disbre').val();
  if(disbre=='')
  {
      login();  
  }
  else if(disbre=='1')
  {
    $('#diss').trigger('click');
   // disbursement();
  }
  

 });

 function login()
    {
      // $('.loaderClas').attr('style','display:block;');   
      var customer_id = $('#cust_id').val();
      var cases_id = $('#cases_id').val();
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" +"UsedCarSale/logindoc",
        dataType: 'html',
        data: {customer_id: customer_id,cases_id:cases_id},
        success: function(data){
          $('.buyer-docs').addClass('active').removeClass('completed');
          $('.vehicle-docs').removeClass('active').addClass('completed');
          $('#disbursement').html('');
          $('#login').html(data);
          // $('.loaderClas').attr('style','display:none;');   
        }
    });
  }
  function disbursement()
    {
       //$('.loaderClas').attr('style','display:block;');   
      var customer_id = $('#cust_id').val();
      var cases_id = $('#cases_id').val();
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" +"UsedCarSale/disbursedoc",
        dataType: 'html',
        data: {customer_id: customer_id,cases_id:cases_id},
        success: function(data){
          $('.vehicle-docs').addClass('active').removeClass('completed');
          $('.buyer-docs').removeClass('active').addClass('completed');
           $('#login').html('');
         $('#disbursement').html(data);
         //  $('.loaderClas').attr('style','display:none;');   

        }
    });
  }
</script>
 