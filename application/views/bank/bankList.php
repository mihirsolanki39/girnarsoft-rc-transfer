<style>
  .nav-tabs>li a{font-size: 16px;}
  .nav-tabs>li a:hover{background: none;}
  .nav-tabs>li.active>a:hover{}
  .nav-tabs>li.active>a:focus{background: none;}
  .nav-tabs>li.active>a{font-size: 16px}
  .assigned-tag {background: #ffefd6; padding: 7px 15px; border-radius: 15px; color: #000000; font-size: 12px;margin-top: 10px; display: inline-block;}

  .label-t{padding: 5px 10px;text-transform: uppercase;display: inline-block;float: right;}
  .availabe{background: #2196F3; color: #fff;border-radius: 3px;font-size: 11px;}
  .sold{background: #00B028;color: #fff;border-radius: 3px;font-size: 11px;}
  .refurb{ background: #6A6A6A;color: #fff;border-radius: 3px;font-size: 11px;}
  .booked{background: #F0B967;color: #fff;border-radius: 3px;font-size: 11px;}
  .removed{ background: #FF0000;color: #fff;border-radius: 3px;font-size: 11px;} 
  #banklist-cd .nav-tabs>li.active>a{background-color: transparent;}
</style>
<div class="container-fluid mrg-all-20 mrg-B0">
  <div class="row" id="banklist-cd">
    <h5 class="cases mrg-B20">Bank List</h5>
    <ul class="nav nav-tabs">
      <li id="partner_bank" class="options <?php if(intval($type) == 1) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >Partner Bank</a></li>
      <li id="all_bank" class="options <?php if(intval($type) == 2) { ?>active<?php } ?>"><a data-toggle="tab" style="cursor: pointer;" >All Banks</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade in active">
        <div id="bank_case_div" class=""></div>
      </div>
    </div>
  </div>
</div>
<div class="modal-backdrop fade bs-example-modal-md" id="addbank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none">
  <div class="modal-dialog modal-md" role="document">
    <form name="frmbank" id="frmbank" method="post"> 
      <div class="modal-content">
      <div class="modal-header bg-gray">
          <button type="button" class="close" onclick="closeBank();" data-dismiss="modal"><img src="<?=base_url('assets/admin_assets/images/cancel.png')?>"> <span class="sr-only">Close</span></button>
                <h4 class="modal-title">Bank Details</h4>
            </div>
            <div class="modal-body">
                  
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                         <label for="" class="crm-label">Bank Name</label>
                         <input type="text" name="bankName" id="bankName" onkeypress="return nameOnly(event)" class="form-control crm-form nameCaseLoan" value="" placeholder="Bank Name">
                         <div class="error" id="bankName_err"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeBank();" id="bcancel">Cancel</button>
                <button type="button" name="btnsavebank" id="btnsavebank" class="btn btn-primary">SAVE</button>
                <input type="hidden" name="bankid" id="bankid" value="">
                <input type="hidden" name="bankNames" id="bankNames" value="">
            </div>
          </div>
          </form>   
        </div>
      </div>

<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>

<script type="text/javascript">
<?php if($type !=''){ ?>
    var ttype     = '<?php echo $type; ?>';
    getBankHtml(ttype);
  <?php } ?>    
$(document).ready(function() {
      $('.options').on('click', function() { 
        $(".options").removeClass('active');
        $(this).addClass('active');
        
        if($(this).attr('id') == 'partner_bank'){
          getBankHtml(1);
        } else if($(this).attr('id') == 'all_bank'){
          getBankHtml(2);
        } 
      });
      $('#btnsavebank').on('click', function (ev) {
      $('#btnsavebank').attr("disabled",true);
      var bankname=$('#bankName').val();
      var banknames=$('#bankNames').val();
      var bankId=$('#bankid').val();
      if(banknames!='' && bankId!=''){
          var type='edit';
      }else{
          var type='add';
      }
      if(bankname==''){
           $('#btnsavebank').attr("disabled",false);
           $('#bankName').focus();
           $('#bankName_err').html("Bank Name field is empty");
           return false;
      }
      $.ajax({
      url: base_url+"bank/addCustomerBankData",
      type: 'post',
      dataType: 'json',
      data: {'bankName':bankname,'bankId':bankId, 'type':type},
      success: function(response)
      {
        if ($.trim(response.status) == '1') {
                setTimeout(function () {
                $('#btnsavebank').attr("disabled",true);
                snakbarAlert("Data saved Successfully");
                getBankHtml(2);
                $('#addbank').attr('style','display: none; padding-right: 15px;');
                $('#addbank').attr('class','modal fade');
            }, 1500);
            return true;
        } else {
             $('#btnsavebank').attr("disabled",false);
             $('#bankName').focus();
             $('#bankName_err').html(response.message);
            return false;
        } 

      }
    });    
      });
      
   $(document).bind('keypress', function(e) {
    if(e.keyCode==13){
         $('#search').trigger('click');
         e.preventDefault();
     }
    });  
  });
  function getBankHtml(source){
     $('#loadmoreajaxloader').show();
    $.ajax({
      url: base_url+"bank/ajax_getbank",
      type: 'post',
      dataType: 'html',
      data: {'source':source},
      success: function(response)
      {
        $("#bank_case_div").html(response);
        $('#imageloder').hide();
        if(parseInt(source) == 1){
           
        } else if(parseInt(source) == 2){
          
        } 
      }
    });
  }
  function pagination(page){
    $("#page").val(page);
    $.ajax({
      url: base_url+"bank/ajax_getbank",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $(".list_div").html(response);
        $( window).scrollTop( 0 );
      }
    });
  }
  function banksearchList(){
    $("#page").val(1);
    $.ajax({
      url: base_url+"bank/ajax_getbank",
      type: 'post',
      dataType: 'html',
      data: {'data':$("#search_form").serialize()},
      success: function(response)
      {
        $(".list_div").html(response);
      }
    });
  }
  function addNewbank(){
      $('.error').html('');
      $('#addbank').attr('style','display: block; padding-right: 15px;');
      $('#addbank').attr('class','modal fade in');
      $('#bankName').val('');
      $('#bankNames').val('');
      $('#bankid').val('');
      $("#btnsavebank").attr("disabled",false);
  }
  function closeBank(divid)
        {
          $('#addbank').attr('style','display: none; padding-right: 15px;');
          $('#addbank').attr('class','modal fade');
        }
           
  function saveBankDetails1(){
      if($('#bankName').val()==''){
          $('#bankName').focus();
                   $('#bankName_err').html("Bank Name field is empty");
                   return false;
      }
      $.ajax({
      url: base_url+"bank/addCustomerBankData",
      type: 'post',
      dataType: 'html',
      data: {'bankName':bankName},
      success: function(response)
      {
        $('#imageloder').hide();
         
      }
    });
      
    }
  function updateCustomerBank(id,name){
     $('.error').html('');  
     var bankId=id; 
     $('#addbank').attr('style','display: block; padding-right: 15px;');
      $('#addbank').attr('class','modal fade in');
      $('#bankName').val(name);
      $('#bankNames').val(name);
      $('#bankid').val(id);
      $("#btnsavebank").attr("disabled",false);
      /*$.ajax({
      url: base_url+"bank/addCustomerBankData",
      type: 'post',
      dataType: 'html',
      data: {'bankId':bankId,'type':'edit'},
      success: function(response)
      {
        if ($.trim(response) == '1') {
                setTimeout(function () {
                //window.location.href =base_url+"bank";
            }, 500);
            return true;
        } else {
            return false;
        } 

      }
    });*/    
      } 
    function nameOnly(event)
    {
      var inputValue = event.which;
      //alert(inputValue);
       if(!(inputValue >= 65 && inputValue <= 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8)) { 
           event.preventDefault(); 
            return false;
       }
      // console.log(inputValue);
    }
</script>