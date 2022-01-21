<form name="customerDetailFrm" id="employee_from" method="post">
    <div class="modal-dialog clearfix" id="customerDetailCtr" style="display:block;">
        <div class="modal-content" id="createUser" style="width: 480px">
            <div class="modal-header modal-header-custom">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url('assets/admin_assets/images/close-model.svg') ?>" alt=""></button>
                <div class="row">
                    <div class="col-md-8 clearfix">
                        <h4 class="modal-title clstask">Assign Tasks</h4>
                    </div>

                </div>

            </div>
            <span class="errors" id="assign_error"></span>    
            <div class="modal-body" id="buyer-lead3333">

                <input type="text" placeholder="search" name="srchassign" id="srchassign" class="form-control">
                <div class="list-group mrg-T10" id="divassign">
                    <?php
                    if (!empty($execList))
                    {
                        $i = 0;
                        foreach ($execList as $ekey => $eval)
                        {
                            
                            ?>   
                    
                            <div class="list-group-item">
                                <div class="col-md-12 pad-L0 pad-R0">
                                    <input  class="mrg-T10 clsoptassign"  type="radio" name="optassign[]" id="exe_<?php echo $i; ?>" value="<?php echo $eval['id'] ?>">
                                    <label class="w100" for="exe_<?php echo $i; ?>">
                                        <p class="ws mrg-B0" style="display: inline-block"><?php echo $eval['name'] ?><br><i class="oi"><?php echo $eval['email'] ?></i></p> <span class="mrg-R0"></span>

                                    </label>
                                </div>
                            </div>
          <?php $i++; }}?>  
                </div>
                <button class="btn btn-primary clsassign" style="width: 100%">UPDATE</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
</form>

<script>
 $("#srchassign").on('change keyup paste', function() {
    var txtsrch=$(this).val();
    $.ajax({
            type: 'POST',
            url: base_url+"lead/getEmplist",
            data : "txtsrch=" + txtsrch ,
            dataType: 'html',
            success: function (data) {
                //alert(data);
                //var response = data.split('@#$%*');
                $('#divassign').html(data);
            }
        });
    });
    $(".clsassign").click(function (e) {
        var assignval = $('.clsoptassign:checked').length
         var lead_array = [];
         
         
         var assign_to_all =$("input[name='assign_to_all']").prop('checked')?"y":"n";
         
         
         if(assign_to_all=='n'){
            $.each($("input[name='lead_assigned']:checked"), function(){            
                lead_array.push($(this).val());
            });
        }
        console.log(JSON.stringify(lead_array));
        var assigned_leads=JSON.stringify(lead_array);
        
        if(assignval==0){
        $('#assign_error').show();
        $('#assign_error').html("Please Select at least One Executive");
        return false;
        }else{
        var formdata = $('#employee_from').serialize();
        var filter = $('#searchform').serialize();
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: base_url+"lead/assign_leads_to_user_manually",
            data : formdata+'&assign_to_all='+assign_to_all+'&assigned_leads='+assigned_leads+'&'+filter ,
            dataType: 'html',
            success: function (response) {
                var data = $.parseJSON(response);
                    
                    if (data.status == 'True') {
                        snakbarAlert(data.message);
                        location.reload();

                        return true;
                    } else {
                        snakbarAlert(data.message);
                        return false;
                    }
                  return false;  
            }
        });
        }
        
    });
</script>