
<div class="container-fluid mrg-all-20">
    <div class="row">
        <h5 class="cases mrg-B20">Stock Reconciliation</h5>
        <div class="cont-spc pad-all-20" id="buyer-lead">
            <form id="tally_filter" name="tally_filter" method="post" class="" role="form">
                <div class="row">
                    <div class="col-md-3 pad-R0">
                        <label for="" class="crm-label">Search</label>
                        <input type="text" class="form-control" name="search_by" id="search_by" value="" placeholder="search by make model or reg no.">
                    </div>

                    <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Status</label>
                        <select class="form-control " id="status" name="status">
                            <option value="0">Select Status</option>  
                            <option value="1">In</option>
                            <option value="2">Out</option>
                            <option value="3">Other</option>
                        </select>
                    </div>

                    <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Date</label>
                         <div class="input-group date" id="dp4">
                            <input type="text" class="form-control crm-form insdate crm-form_1" id="filter_date" name="filter_date" autocomplete="off" value="<?=!empty($bookingData['instrument_date'])?date('d-m-Y', strtotime($bookingData['instrument_date'])):date('d-m-Y');?>"  placeholder="Date">
                            <span class="input-group-addon">
                                <span class="">
                                    <img src="<?php echo base_url(); ?>assets/admin_assets/images/fltr-calendar.svg">
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2 pad-R0">
                        <span>
                            <a class="btn-save btn-save-new" id="search_button" onclick="getTallyList();">SEARCH</a>
                            <a href="javascript:void(0)" onclick="resetForm()" class="mrg-L10 used__car-reset-btn">RESET</a>
                        </span>
                    </div>
                </div>
            </form>
            <img class="loader-wait" src="<?php echo base_url(); ?>assets/images/loader.gif" style="position: absolute;z-index: 1000;left: 540px;top: 180px;width: 200px;display:none;">
        </div>
        <div class="list_div" id="tally_list">
          
        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_assets/css/sumoselect.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.sumoselect.min.js"></script>
<script>
$('#filter_date').datepicker({
    format: 'dd-mm-yyyy',
    startDate: '-6d',
    endDate: 'd',
    autoclose: true,
    todayHighlight: true
});     
      
      $('#search_by').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
       getTallyList();
    }
});      
var getTallyList = function (){

    $.ajax({
        type: 'GET',
        url : "<?php echo base_url(); ?>" + "Stock/getTallyList/?"+$('#tally_filter').serialize(),
        data:{},
        dataType: "html",
        beforeSend(){
          $('.loader-wait').show();  
        },
        success: function(response) 
        {
            $('.loader-wait').hide();  
            $('#tally_list').html(response);
            countEachRecord();

        }   
        });
}
var resetForm = function (){
    $("#tally_filter").trigger("reset");
    getTallyList();
}
var saveTallyData = function(){
        $.ajax({
        type: 'POST',
        url : "<?php echo base_url(); ?>" + "Stock/saveReconcillationList/?date="+$('#filter_date').val(),
        data:$('#tally_data').serialize()+"&"+$('#key_form').serialize(),
        dataType: "json",
        
        success: function(response){
            snakbarAlert(response.msg);
            //setTimeout(function(){location.reload();},1500);
            getTallyList();
        }   
    });
}
var savePDFData = function(){
        $.ajax({
        type: 'POST',
        url : "<?php echo base_url(); ?>" + "Stock/reco_pdf/?"+$('#tally_filter').serialize(),
        dataType: "json",
        beforeSend:function(){
             snakbarAlert('Please Wait While PDF Is Getting Downloaded');
        },
        success: function(response) 
        {
            snakbarAlert(response.msg);
            if(response.status){
               window.location=base_url+"stock/downloadBookingPdf/?file="+response.file_name+"&type="+response.type;
            }
        }   
    });
}
var saveNewStockData = function(){
        $.ajax({
        type: 'POST',
        url : "<?php echo base_url(); ?>" + "Stock/saveRecoStock/",
        data:$('#add_stock_form').serialize(),
        dataType: "json",
        success: function(response) 
        {
            snakbarAlert(response.msg);
            if(response.status==true){
                $('#add_stock_form').trigger('reset');
                $('#add_stock').modal('toggle');
                setTimeout(function(){location.reload();},1500);
            }
        }   
    });
}
var  countEachRecord = function(){
        $.ajax({
        type: 'POST',
        url : "<?php echo base_url(); ?>" + "Stock/incrCount/",
        data:$('#tally_data').serialize(),
        dataType: "json",
        success: function(response) 
        {
            $('#in_count').html(response.in);
            $('#out_count').html(response.out);
            $('#other_count').html(response.oth);
            $('#refurb_count').html(response.r);
            $('#delivered_count').html(response.d);
            $('#total_count').html(response.t);
            $('#removed_count').html(response.rem);
        }   
    });
}
var  getCarVersion = function(mm_id){
        $.ajax({
        type: 'POST',
        url : "<?php echo base_url(); ?>" + "Stock/getVersion/",
        data:{mm_id},
        dataType: "html",
        success: function(response) 
        {
            $('#version_list').html(response);
            $('#version_id').SumoSelect({ csvDispCount: 3, search: true,  searchText:'Enter here.' });
            $('#version_id')[0].sumo.reload();
        }   
    });
}

var isNumberKey= function (evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
var setCookie = function (cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=<?php echo base_url(); ?>Stock/reconcillationList";
}

$(document).ready(function(){
    getTallyList();
    
    $('#tally_list').delegate('.tally_status','change',function(){
       var tally_status= $(this).val();
       if(tally_status==='3'){
         $(this).parent('.tally-status-select').siblings('.assigned-tag').show() ;
       }
       else{
         $(this).parent('.tally-status-select').siblings('.assigned-tag').hide() ;
       }
       setCookie(this.id,tally_status)
       countEachRecord();
    });
    
    $('#tally_list').delegate('#make_model','change',function(){
       var mm_id= $(this).val();
       getCarVersion(mm_id)
    });
    
    $('#tally_list').delegate('.saveTallyList','click',function(){
      saveTallyData();
      
    });
    $('#tally_list').delegate('.download_pdf','click',function(){
      savePDFData();
      
    });
    $('#tally_list').delegate('#add_new_stock','click',function(){
      saveNewStockData();
      
    });
    
    
    
});
            
</script>