<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($data);
?>
<style type="text/css">
  .modal-dialog {z-index: 9999 !important;}
    .page-title{margin: 30px 0px 20px}
</style>



<link href="<?= base_url('/assets/css/common.css') ?>" rel="stylesheet">
<div id="content">
<div class="container-fluid mrg-T20 mrg-B20">
     <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="cont-spc pad-all-20" id="buyer-lead">
               <form id="empsearchform" name="empsearchform">
                  <div class="row">
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label" >Search By</label>
                        <input type="text" name="search_by" id="search_by" value="" class="form-control" placeholder="Employee Name/Mobile">
                                    
                                 
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Team</label>
                              <select class="form-control crm-form testselect1" name="employee_team" id="employee_team">
                              <option value="">Select Team</option>
                              <?php foreach($teams as $key=>$team){?>
                              <option value="<?=$team['id']?>"><?=$team['team_name']?></option>
                              <?php } ?>
                              </select>
                     </div>
                    <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Role</label>
                              <select class="form-control crm-form testselect1" name="employee_role" id="employee_role">
                              <option value="">Select Role</option>                             
                              </select>
                     </div>
                     <div class="col-md-2 pad-R0">
                        <label for="" class="crm-label">Status</label>
                              <select class="form-control crm-form testselect1" name="sale_emp" id="sale_emp">
                                 <option value="">Status</option>
                                 <?php foreach (STATUS as $k => $status) { ?>
                                     <option value="<?= $k ?>"><?= $status ?></option>
                                 <?php } ?>
                              </select>
                            
                     </div>
                     
                     <div class="col-md-2 pad-R0">
                        <span id="spnsearch">
                            <input type="button" class="btn-save btn-save-new" value="Search" id="empsearch">
                            <a href="JavaScript:Void(0)" onclick="reset()" id="Reset" class="btn-reset">RESET</a>
                            <input type="hidden" name="page" id="page" value="1">
                        </span>
                     </div>
                  </div>
               </form>
            </div>
      </div>
   </div>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
            <div class="background-ef-tab" id="loandetails">
            <div class="tabs loandetails">
              <div class="row pad-all-20">
                   <div class="col-md-6">
                        <h5 class="cases">Employee List <span id="total_cases">(<?=$total_count?>)</span></h5>
                   </div>
                   <div class="col-md-6">
                     <a href="<?=base_url()?>addNewUser" target="_blank"> <button class="btn-success pull-right">ADD NEW</button></a>
                   </div>  
              </div>
   <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active tabn" id="finalized">
                     <div class="container-fluid ">
                        <div class="row">
                           <div class="col-lg-12 col-md-12">
                              <div class="row">
                              <style>
                              #banklisting .dealer-ship{font-size:14px; color:#000000; opacity:0.87; font-weight:500;}
                              #banklisting .dt-bank{font-size:#000000; opacity:.67; font-size:14px; margin-top:5px;}
                              #banklisting .switch {position: relative;display: inline-block;width: 34px;height: 14px; vertical-align: middle;}

                              </style>
                                 <div class="table-responsive" id="banklisting">
                                    <table class="table table-bordered table-striped table-hover enquiry-table myLoantbl">
                                       <thead>
                                          <tr>
                                            <!-- <th>Loan ID </th>-->
                                             <th width="30%">Employee Details</th>
                                             <th width="30%">Role & Team</th>
                                             <th width="25%" >Status</th>
                                               <th width="10%" >Action</th>
                                          </tr>
                                       </thead>
                                       <tbody id="employee_list">
             <?php 
                  $data = json_decode(json_encode($results), True);
                    if(!empty($data))
                    {                    
                        foreach($data as $key => $val)
                        {
                            $is_sales_ex = 0;
                            if($val['team_id'] == 3 && $val['role_id'] == 16){
                                $is_sales_ex = 1;
                            }
                                $status  = '';
                                $checked = '';
                                $class   = '';
                                if ($val['status'] == 0)
                                {
                                    $checked = '';
                                    $status  = 'Inactive';
                                    $class   = "class='inactive-danger'";
                                }
                                    else if ($val['status'] == 1)
                                {
                                    $status  = 'Active';
                                    $class   = "class=''";
                                    $checked = "checked='checked'";
                                }
                    ?>
                    <tr>
                        <td>
                          <div class="dealer-ship"><?=$val['name']?></div>
                          <div class="dt-bank"><?=$val['email']?></div>
                          <div class="dt-bank"><?=$val['mobile']?></div>
                        </td>
                        <td>
                            <div class="dealer-ship"><?=$val['role']?></div>
                            <div class="dt-bank"><?=$val['team']?></div>
                        </td>
                        <td><label class="switch">
                            <input type="checkbox" class="custom-checkbox customCheck2" id="<?php echo $val['id']; ?>" <?php echo $checked; ?> onclick="activeDeactiveEmp('<?php echo $val['id']; ?>','<?php echo $val['name'] ?>','<?=$is_sales_ex?>')">
                            <div class="slider round"></div>
                          </label>
                          <span class="switch-primary table-text-edit_<?php echo $val['id']; ?>" id="<?php echo $val['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </td>
                                           
                     <td>
                        <?php if($val['status'] == 1){?>
                          <a class="btn btn-default button" style="line-height: 10px; width: 100%" href="<?php echo base_url() . 'edituser/' . base64_encode(DEALER_ID.'_'.$val['id']); ?>" title="Edit" >EDIT</a>
                        <?php } ?>
                     </td>
                     </tr>
                    <?php
                        }
                    }
                    ?>
                    <input type="hidden" name="userTypeId" id="userTypeId" value=""/>
                    <?php echo form_close(); ?>
                    <tr><td colspan="8" style="text-align: center !important;">
    <?php if ((int)$total_count > 0) { ?>

                <div class="col-lg-12 col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" >
                            <?php
                            $total_pages = ceil($total_count / $limit);
                            $pagLink = "";

                            if ($total_pages < 1) {
                                $total_pages = 1;
                            }

                            if ($total_pages != 1) {

                                //this is for previous button
                                if ((int)$page > 1) {
                                    $prePage = (int)$page - 1;
                                    ?>
                                    <li onclick="pagination('<?php echo $prePage ?>');"><a href="#" aria-label="Previous"><span aria-hidden="true">Prev</span></a></li>
                                    <?php
                                    //this for loop will print pages which come before the current page
                                    for ($i = (int)$page - 6; $i < $page; $i++) {
                                        if ($i > 0) {
                                            ?>   
                                            <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $i; ?></a></li>
                                            <?php
                                        }
                                    }
                                }

                                //this is the current page
                                // if($i > $page){ ?>
                                <li class="active"  onclick='pagination(<?php echo $i; ?>);'><a href='#'><?php echo $page ?></a></li>
                               
                                <?php
                             // }
                                //this will print pages which will come after current page
                                for ($i = $page + 1; $i <= $total_pages; $i++) {
                                    ?>
                                    <li class="<?=$i?>" onclick='pagination(<?php echo $i; ?>);' ><a href='#'><?php echo $i; ?></a></li> 
                                    <?php
                                    if ($i >= $page + 3) {
                                       break;
                                    }
                                }

                                // this is for next button
                                if ($page != $total_pages) {
                                    $nextPage = (int)$page + 1;
                                    ?> 
                                    <li onclick="pagination('<?php echo $nextPage; ?>')"><a href="#" aria-label="Next"><span aria-hidden="true">Next</span></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                        <?php } ?>     
        </td></tr>
        </tbody>
    </table>
   
</div>
</div>

</div>
        </div>

</div>

</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery_dataTable.js" type="text/javascript"></script>
   
   <script src="<?php echo base_url(); ?>assets/js/jQuery.js" type="text/javascript"></script>
   <script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
   <link rel="stylesheet" href="<?=base_url()?>assets/css/sumoselect.css">
   <script src="<?=base_url()?>assets/js/sumoselect.js"></script>
<script type="text/javascript">
    $('.testselect1').SumoSelect({triggerChangeCombined:true,search: true, searchText: 'Search here.'});
    $('#total_cases').text('('+"<?=!empty($total_count)?$total_count:"0"?>"+')');
</script>
<script type="text/javascript">
   function pagination(page) {
        $("#page").val(page);
        $("#loancases").html('');
        $('#imageloder').show();
        var formDataSearch=$('#empsearchform').serialize();
        var start = $('#page').val();
        start++;
        $.ajax({
            url: base_url+"User/ajax_userList",
            type: 'post',
            dataType: 'html',
            data: formDataSearch,
            success: function (responseData, status, XMLHttpRequest) {
            var html = $.trim(responseData);
            $('#page').attr('value', start);
            if (parseInt(html) != 1) {
            $('#employee_list').html("");
            $('#employee_list').html(html);
            $(window).scrollTop(0);
            }
//            else if (parseInt(html) == 1) {
//           // start--;
//           // $('#page').attr('value', start);
//             //$('#employee_list').html("<tr><td align='center' colspan='7'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
//            }
            $('.'+page).addClass('active');
            $('#imageloder').hide();
            }
        });
    }
  function activeDeactiveEmp(id, name,is_sales_ex) {
        if ($("#" + id).is(":checked")) {
            var data = "id=" + id + "&status=1";
            bootbox.confirm({
                message: "Are you sure you want to activate Employee " + name + " ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result == false) {
                        location.reload();
                    } else {

                        ajax_employee_activate_deactivate(data);
                        //location.reload();
                    }
                }
            });
        } else {
            var data = "id=" + id + "&status=0";
            if(is_sales_ex == 1){
                var msg = "Heads Up! <br /><hr>Are You Sure You Want To Inactive Employee " + name +
                " ?<br /> Making Inactive Will Remove All Banks Limit Assigned To This Employee.";
            }else
                var msg = "Are you sure you want to Inactive Employee " + name + " ?";
            bootbox.confirm({
                message: msg,
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if (result == false) {
                        location.reload();
                    } else {
                        ajax_employee_activate_deactivate(data);
                    }
                }
            });
        }
    }
    
    function ajax_employee_activate_deactivate(data) {
        
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>user/activeInactiveEmp",
            data: data,
            dataType: "json",
            success: function (result) {
                if(result){
                    location.reload();
                }
            }
        });
    }

    function deleteEmp(id, name) { 
       if (confirm('Are you sure you want to delete '+name+'?')) 
       {
          var data = "id=" + id + "&status=2";
          $.ajax({
            type: "POST",
            url: "<?=base_url()?>user/activeInactiveEmp",
            data: data,
            dataType: "json",
            success: function (results) {
                if(results){
                    location.reload(true);
                }
              }
          });
       }
    }
      $('#search_by').keypress(function(event){
       var keycode = (event.keyCode ? event.keyCode : event.which);
       if(keycode == '13'){
         $('#empsearch').trigger('click');
       }
    });
</script>

