<footer class="text-left" id="footer">
   <div class="container-fluid">
      <div class="row">
            <div class="col-md-5 text-left">
               <p class="copyright" style="display:inline-block; float:left">© Copyright gaadi.com All Rights Reserved.
               </p>
                <ul class="foot-policy clearfix pull-left">
                  <li><a href="#">Terms and Conditions</a></li>
                  <li><a href="#">Feedback</a></li>
               </ul>
            </div>
            <div class="col-md-7 pull-right text-right">
               
                <div class="pull-right -s2 footer_last">
                   <span class="f-image pad-"><img src="<?=base_url('assets/admin_assets/images/svg/phone.svg')?>" alt="call-img" /><span class="mobile-no">+918010887766</span><span class="pad-L5 pad-R5">|</span></span>
                   <span class="f-image"><img src="<?=base_url('assets/admin_assets/images/svg/email.svg')?>" alt="mail-img" /> <a href="mailto:dealersupport@gaadi.com?Subject=Dealer Central Feedback" target="_top" class="email-id">dealersupport@gaadi.com</a></span> 
                </div>
             </div>
         </div> 
   </div>         
</footer>
      <!-- /.tool-tip -->
     
     
      <!-- Bootstrap core JavaScript
         ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
      <script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
      <script src="<?=base_url('assets/admin_assets/js/bootstrap.min.js')?>"></script>
      <script src="<?=base_url('assets/admin_assets/js/my.js')?>"></script>      
      <script src="<?=base_url('assets/admin_assets/js/daterangepicker.js')?>"></script>
      <script src="<?=base_url('assets/admin_assets/js/moment.min.js')?>" type="text/javascript"></script>
      <!--<script src="js/bootstrap-datepicker.js" type="text/javascript"></script>-->
      <!--[if IE]><script src="js/excanvas.js"></script><![endif]-->
      <script src="<?=base_url('assets/js/bootstrap-select.js')?>"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="<?=base_url('assets/admin_assets/js/assets/ie10-viewport-bug-workaround.js')?>"></script>
      <script src="<?php echo base_url(); ?>assets/js/multiselect.js" type="text/javascript"></script>
      <script src="<?=base_url('assets/admin_assets/js/jquery-ui/jquery.datetimepicker.js')?>"></script>
      <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>-->
      <script src="<?=base_url('assets/js/jquery.sumoselect.min.js')?>"></script>  
      <link rel="stylesheet" href="<?php echo base_url('assets/admin_assets/css/jquery.mCustomScrollbar.css'); ?>" />
      
      <!-- <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.fd.css'); ?>" /> -->

        <script src="<?php echo base_url('assets/admin_assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

      <script>
         $(document).ready(function(){
           $('.dropdown-submenu a.test').mouseover("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
           });
            
            $('.dropdown-submenu a.test').mouseleave(function() {
              $(this).next('ul').fadeOut();
               e.stopPropagation();
               e.preventDefault();
            });
            $('.hover-section').hover(function(){
               $('.text-btn').addClass('btnHoverG');
            });
         });
         function footerBottom(){
          var contentH = $('#content').height();
          var winH = $(window).height();
          var footerH = $("footer").outerHeight();
          var navH = $('nav').outerHeight();
          //alert($("#footer").outerHeight())
          if(contentH<winH){
            $('#content').css("min-height", $(window).height() - (footerH+navH)-20);
          }
         }
         $(window).resize(function() {
            footerBottom();
          });
        footerBottom();
          
         //$(".trigger input:radio").attr('disabled',true);

         $('.testselect1').SumoSelect();
    $('.testselect2').SumoSelect();
    $('.optgroup_test').SumoSelect();
      </script>
      <?php 
       // echo $CustomerInfo['tag_flag'];
        //echo $rolemgmt[0]['role_name'];
        if((!empty($CustomerInfo['tag_flag']) && ($CustomerInfo['tag_flag']=='4')) && (!empty($rolemgmt) && (($rolemgmt[0]['role_name']=='Used Car') && ($rolemgmt[0]['role_name']=='New Car') &&  ($rolemgmt[0]['role_name']=='Prelogin')))) { ?>
      <script>
          $('.loan_read_only .form-control').attr('style',"pointer-events: none !important;");
           $('.loan_read_only .bbbb').attr('style',"pointer-events: none !important;display:none;");
          $('.loan_read_only .trigger,.loan_type').attr('disabled',"disabled;");
          $('#CaseInfoForm .form-control').attr('style',"pointer-events: none !important;");
          $('#financeAcedmic .form-control').attr('style',"pointer-events: none !important;");
          $('#loanExForm .form-control').attr('style',"pointer-events: none !important;");
          $('#residenceForm .form-control').attr('style',"pointer-events: none !important;");
          $('#refrenceForm .form-control').attr('style',"pointer-events: none !important;");
          $('#bankForm .form-control').attr('style',"pointer-events: none !important;");
          $('#bankForm .trigger').attr('disabled',"disabled;");
          $(document).ready(function () {
          window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, okCancelInMulti:true, searchText:'Enter here.',triggerChangeCombined: true}); 
          var disbrsal = $('#disbrsal').val();
          if(disbrsal=='1')
          {
              $(".form-group").css('pointer-events','none');
          }
          else
          {
              $(".form-group").css('pointer-events','initial');
        
          }
      });
      </script>
       <?php }
       else if((!empty($rolemgmt[0]['role_name']) && (($rolemgmt[0]['role_name']!='admin') && ($rolemgmt[0]['role_name']!='Loan Admin'))))
        { ?>
       
          <script>
          $('.loan_read_only .form-control').attr('style',"pointer-events: initial !important;");
           $('.loan_read_only .bbbb').attr('style',"pointer-events: initial !important;display:none;");
         // $('.loan_read_only .trigger,.loan_type').attr('disabled',"disabled;");
          $('#CaseInfoForm .form-control').attr('style',"pointer-events: initial !important;");
          $('#financeAcedmic .form-control').attr('style',"pointer-events: initial !important;");
          $('#loanExForm .form-control').attr('style',"pointer-events: initial !important;");
          $('#residenceForm .form-control').attr('style',"pointer-events: initial !important;");
          $('#refrenceForm .form-control').attr('style',"pointer-events: initial !important;");
          $('#bankForm .form-control').attr('style',"pointer-events: initial !important;");
          //$('#bankForm .trigger').attr('disabled',"disabled;");
          $(document).ready(function () {
          window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, okCancelInMulti:true, searchText:'Enter here.' }); 
          var disbrsal = $('#disbrsal').val();
          if(disbrsal=='1')
          {
              $(".form-group").css('pointer-events','initial');
          }
          else
          {
              $(".form-group").css('pointer-events','initial');
        
          }
           
      });
          $('.leaddealer').on('change', function () {
           var saleid = $(this).val();
            if(saleid>='1'){
              //$('#meet_the_customer.search-box')[0].sumo.reload();
              $.ajax({
                      type: 'POST',
                      url : "<?php echo base_url(); ?>" + "DeliveryOrder/getSalesList/",
                      data:{saleid:saleid},
                      dataType: "json",
                      success: function(response) 
                      {
                       // $('.meet_the_customer')[0].sumo.selectItem(response);
                          $('#meet_the_customer').val(response);
                      }
                      });
            }
        });
      </script>
         <?php }?>
   </body>
   
</html>
<script src="<?php echo base_url(); ?>assets/js/jquery_dataTable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/dropzone.css'); ?>" />
<script src="<?= base_url('assets/js/dropzone.js'); ?>"></script> 
<script src="<?php echo base_url(); ?>assets/admin_assets/js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.plugin.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.maxlength.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_assets/js/dc-crm.js"></script>

 <script src="<?php echo base_url();?>assets/js/bootstrap.fd.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>-->
<script type="text/javascript">

</script>
<?php 
if(!empty($CustomerInfo['tag_flag']) && $CustomerInfo['tag_flag']=='4'){ ?>
<script>
    //$('.crm-form').;
    
</script>

 <?php }?>
 <style>
   .fixedFooter{position: fixed; bottom: 0; left: 0; width: 100%;}
   
   </style>
<?php

 if(((!empty($rolemgmt[0]['role_name']) && (($rolemgmt[0]['role_name']!='admin')))) || (!empty($this->session->userdata['userinfo']['role_name']) && (strtolower($this->session->userdata['userinfo']['role_name'])!='admin')))
        { ?>

  <style>
     /*body, html{     
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;  
}*/
   </style>
    <script type="text/javascript">
$(document).ready(function () {
    //Disable cut copy paste
    //alert('dfsf');
   /* $('body').bind('cut copy', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });*/

});

</script>
<?php } ?>
