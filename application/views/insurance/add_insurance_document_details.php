   <link href="<?php echo base_url(); ?>assets/css/imageviewer.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/common_new.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/dropzone_loan.css" rel="stylesheet">
  <div class="container-fluid">
    <div class="row">
       <h2 class="page-title mrg-L10">Upload Docs</h2>
       <div class="col-md-12 pad-LR-10 mrg-B40">
          <div class="white-section upload-docs">
             <div class="row">
                <div class="col-md-12">
                   <!-- Nav tabs -->
                   <div class="card">
                      <div class="tab-content">
                       <div role="tabpanel" class="tab-pane active" id="login">
                       </div>
                        <div role="tabpanel" class="tab-pane" id="disbursement">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="cust_id" value="<?=(!empty($CustomerInfo['customer_id']))?$CustomerInfo['customer_id']:''?>" id="cust_id">
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>
      <script src="<?= base_url('assets/js/dropzone_loan.js'); ?>"></script> 
      <script src="<?php echo base_url(); ?>assets/js/sorting.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/imageviewer.js"></script>
<script>
 $(document).ready(function(){
  login();
 });

 function login()
    {
      var customer_id = $('#cust_id').val();
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" +"Insurance/logindoc",
        dataType: 'html',
        data: {customer_id: customer_id},
        success: function(data){
           $('#disbursement').html('');
         $('#login').html(data);
        
        }
    });
  }
  function disbursement()
    {
      var customer_id = $('#cust_id').val();
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" +"Insurance/disbursedoc",
        dataType: 'html',
        data: {customer_id: customer_id},
        success: function(data){
           $('#login').html('');
         $('#disbursement').html(data);

        }
    });
  }
</script>
 