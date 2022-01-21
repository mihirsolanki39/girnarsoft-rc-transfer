<?php
  $urlExplode=explode('/',current_url());
  $url = !empty($urlExplode[5])? ($urlExplode[5]):'';
?>
<div id="content">
  <div class="container-fluid mrg-all-20">
     <div class="row">
        <div class="">
           <div class="cont-spc pad-all-20" id="buyer-lead">
                 <form id="searchform">
                    <div class="row">
                       <div class="col-md-2 pad-R0">
                          <label for="" class="crm-label" >Search By</label>
                                      <div class="select-box" style="width:80px">Select </div>
                                      <ul class="drop-menu">
                                         <li><a href="#" onclick="searchby(this)" id="searchcustname">Owner Name</a></li>
                                         <li><a href="#" onclick="searchby(this)" id="searchmobile">Owner Mobile</a></li>
                                         <li><a href="#" onclick="searchby(this)" id="searchslip">Workshop Name</a></li>
                                         <li><a href="#" onclick="searchby(this)" id="searchbooking">Worshop Mobile</a></li>
                                      </ul>
                                   <!-- /btn-group -->
                                   <div id="dropD">
                                   <input type="text"  name="searchbyval" id="searchbyval" class="form-control crm-form drop-form abc" style="width:57%; display:block;" readonly="readonly" >
                                  </div>
                                   <input type="hidden" name="searchby" id="searchby" value="">
                                   
                       </div>
                       <div class="col-md-2 pad-R0">
                          <span id="spnsearch">
                              <input type="button" class="btn-save btn-save-new" value="Search" id="search">
                              <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                              <input type="hidden" name="page" id="page" value="1">
                              <input type="hidden" name="dashboard" id="dashboard" value="<?=(!empty($url)?$url:'')?>">
                          </span>
                       </div>
                    </div>
                 </form>
              </div>
        </div>
     </div>
  </div>
  <div class="container-fluid mrg-all-20">
     <div class="row">
        <div class="">
           <div class="background-ef-tab" id="loandetails">
              <div class="tabs loandetails">
                <div class="row pad-all-20">
                     <div class="col-md-6">
                          <h5 class="cases">Refurb Workshop <span id="total_count"></span></h5>
                     </div>
                     <div class="col-md-6">
                       <a href="<?=base_url()?>addrefurbworkshop" target="_blank"> <button class="btn-success pull-right">ADD WorkShop</button></a>
                     </div>  
                </div>
                 <!-- Tab panes -->
                 <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                       <div class="container-fluid ">
                          <div class="row">
                             <div class="col-lg-12 col-md-12">
                                <div class="row">
                                   <div class="table-responsive">
                                      <table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
                                         <thead>
                                            <tr class="hover-section">
                                              <!-- <th>Loan ID </th>-->
                                               <th width="40%">Workshop Details</th>
                                               <th width="40%">Owner Details</th>
                                               <th width="10%" >Actions</th>
                                            </tr>
                                         </thead>
                                         <tbody id="loancases">
                                         <span id="imageloder" style="display:none; position:absolute;left: 50%;border-radius: 50%;z-index:999; ">
                                      <img src="<?=base_url('assets/admin_assets/images/loader.gif')?>"></span>    
                                         </tbody>
                                      </table>
                                   </div>
                                    <div id="loadmoreajaxloader"  style="display:none;text-align:center;margin-bottom:20px;font-size:10px;">
                                      <img src="ajax/loading.gif" title="Click for more" />Click for more
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
 
 </div>

<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url('assets/js/refurb.js')?>"></script>
<script>
   var date = new Date();
    var d = new Date();        
      d.setDate(date.getDate());
        $(document).ready(function(){
           $('.icon-cal1').datepicker({
         format:'dd-mm-yyyy',
                  endDate: d     
             });
           var type = "<?=$url?>";
           if(type!='')
           {
              //searchLoanCase();
           }
       });
        //loanlisting();
        function searchby(eve='',e='')
        {
            if(eve!='')
            {
               var id = $(eve).attr('id');
               $('#searchby').val(id);
               if(id=='searchdealer')
               {
                  $('.abc').removeAttr("readonly");
                  $('.abc').attr('style','display:block;');
                  dealerList();
               }
               else
               {
                  $('.abc').removeAttr("readonly");
                  $('.abc').attr('style','display:block;');
                  //$('.abc1').attr('style','display:none;');
               }
            }
            else
            {
               var id = $(e).attr('id');
               $('#searchdate').val(id);
            }
        }
        function loanlisting()
        {
          $.ajax({
           type : 'POST',
           url : "<?php echo base_url(); ?>" + "DeliveryOrder/worshopListingCase/",
           dataType: 'html',
           success: function (response) 
           { 
              $('#loancases').html(response);
            }
           });
        }
   
        
        function reset()
        {
             location. reload(true);
        }
        
        $(document).ready(function(){
          $('body').on('click',function(){
                $('.drop-menu').hide();
            });
            $('.select-box').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).next().show();
            });
            $('.drop-menu li a').click(function(){
                var getText = $(this).text();
                $(this).parents('.drop-menu').prev().html(getText + '<span class="d-arrow d-arrow-new"></span>');
            });
        });
        $( ".abc1" ).change(function() {
          var va = $(".abc1").val();
          $('#searchbyval').val(va);
        });
</script>
