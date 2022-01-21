   <?php 
   if((!empty($disbural)))
    {
      $onclick = 'cardoc();';
      $href = '#cardoc';
      $stylup = 'display:none';
      $styleC = 'display:block';
      $heading = 'Upload Car Docs';
    }
    else
    {
      $href = '#';
      $onclick = 'return false;';
      $stylup = 'display:block';
      $styleC = 'display:none';
      $heading = 'Upload Car Photos';
    }
    ?>
   <link href="<?php echo base_url(); ?>assets/css/imageviewer.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/common_new.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>assets/css/dropzone_loan.css" rel="stylesheet">
 <div class="container-fluid">
            <div class="row">
               <div class="col-md-12 pad-LR-10 mrg-B40">
                  <h2 class="page-title"><?=$heading?></h2>
                  <div class="white-section upload-docs">
                     <div class="row">
                        <div class="col-md-12">
                           <!-- Nav tabs -->
                           <div class="card">
                              <ul class="nav nav-tabs" role="tablist">
                                 <li role="presentation" style="<?=$stylup?>" class="active"><a href="#login" onclick="login();" aria-controls="login" role="tab" data-toggle="tab">Car Photos</a></li>
                                <li role="presentation" style="<?=$styleC?>"><a id="diss" href="<?=$href?>" onclick="<?=$onclick?>"  aria-controls="cardoc" role="tab" data-toggle="tab"> Documents</a></li>
                              </ul>
                              <div class="tab-content">
                               <div role="tabpanel" class="tab-pane active" id="login">
                               </div>
                                <div role="tabpanel" class="tab-pane" id="cardoc">
                                </div>
                              </div>
                            </div>
                            <input type="hidden" name="cases_id" value="<?=(!empty($case_id))?$case_id:''?>" id="cases_id">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
</div></div></div>
<script src="<?= base_url('assets/js/dropzone_loan.js'); ?>"></script> 
     <!--<script src="<//?php echo base_url(); ?>assets/js/sorting.js"></script>-->
      <script src="<?php echo base_url(); ?>assets/js/imageviewer.js"></script>
      <?php if((!empty($disbural)))
    { ?>
      <script>
 $(document).ready(function(){
   $('#diss').trigger('click'); 
 });
 </script>
  <?php } else{ ?>
<script>
 $(document).ready(function(){
    login();  
 });
 </script>
<?php } ?>
<script>
 function login()
    {
      var cases_id = $('#cases_id').val();
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" +"UsedcarPurchase/logindoc",
        dataType: 'html',
        beforeSend(){
          $('.searchresultloader').show();  
        },
        data: {cases_id:cases_id},
        success: function(data){
            $('.searchresultloader').hide();
          $('#login').html(data);

        }
    });
  }
  function cardoc()
    {
    //alert('hi');
       //$('.loaderClas').attr('style','display:block;');   
      var customer_id = $('#cust_id').val();
      var cases_id = $('#cases_id').val();
       $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>" +"UsedcarPurchase/cardoc",
        dataType: 'html',
        data: {customer_id: customer_id,cases_id:cases_id},
        success: function(data){
         $('#login').html('');
         $('#cardoc').html(data);

        }
    });
  }
</script>
 
