$(document).ready(function () {
    $('#bankRecord').dataTable({
        "aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
        "iDisplayLength": 10,
        "bLengthChange": false,
        "order": [[0, "asc"]],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search Here..."
        }
    });
});

function activeDeactiveBank(id, name,type) {
            if ($("#" + id).is(":checked")) {
            var data = "bank_id=" + id + "&name=" + name + "&flag=activate&type="+type;
            bootbox.confirm({
                message: "Are you sure you want to activate Bank " + name + " ?",
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
                        ajax_bank_activate_deactivate(data,type);
                        //location.reload();
                    }
                }
            });
        } else {
            if(type == "all"){
               var msg =  "Are you sure you want to Inactive Bank " + name + " ?";
            }else{
              var msg =  "Heads Up! <br /><hr>Are You Sure You Want To Inactive Bank " + name + 
                        " ? <br /> Making Inactive Will Remove The Limit Assigned To The Employees From This Bank.";
            }
            var data = "bank_id=" + id + "&name=" + name + "&flag=deactivate&type="+type;
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
                        ajax_bank_activate_deactivate(data);
                    }
                }
            });
        }
    }
    ;

    function ajax_bank_activate_deactivate(data,type) {
        $.ajax({
            type: "POST",
            url: "bank/activeInactive",
            data: data,
            dataType: "json",
            success: function (result) {
              var type = $("#source").val();
                if(result){
                    if(type=='partner'){
                    //location.reload();
                   // window.location.href =base_url+"bank/?type=1"
                      getBankHtml(1);
                    }else if(type=='all'){
                    getBankHtml(2);  
                    }else{
                         getBankHtml(type);
                    }
                }
            }
        });
    }
function activeDeactiveDealer(id, name) {
        if ($("#" + id).is(":checked")) {
            var data = "dealer_id=" + id + "&name=" + name + "&flag=activate";
            bootbox.confirm({
                message: "Are you sure you want to activate Dealer " + name + " ?",
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

                        ajax_dealer_activate_deactivate(data);
                        //location.reload();
                    }
                }
            });
        } else {
            var data = "dealer_id=" + id + "&name=" + name + "&flag=deactivate";
            bootbox.confirm({
                message: "Are you sure you want to deactive Dealer " + name + " ?",
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
                        ajax_dealer_activate_deactivate(data);
                    }
                }
            });
        }
    }
    ;

    function ajax_dealer_activate_deactivate(data) {
        $.ajax({
            type: "POST",
            url: "dealer/activeInactiveDealer",
            data: data,
            dataType: "json",
            success: function (result) {
                if(result){
                    location.reload();
                }
            }
        });
    }
    
    function activeDeactiveTeam(id, name) {
          if ($("#" + id).is(":checked")) {
            var data = "id=" + id + "&status=1";
            bootbox.confirm({
                message: "Are you sure you want to activate Team " + name + " ?",
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

                        ajax_team_activate_deactivate(data);
                        //location.reload();
                    }
                }
            });
        } else {
            var data = "id=" + id + "&status=0";
            bootbox.confirm({
                message: "Are you sure you want to deactive Team " + name + " ?",
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
                        ajax_team_activate_deactivate(data);
                    }
                }
            });
        }
    }
    
    function ajax_team_activate_deactivate(data) {
        
        $.ajax({
            type: "POST",
            url: base_url+"team/activeInactiveTeam",
            data: data,
            dataType: "json",
            success: function (result) {
                if(result){
                    location.reload();
                }
            }
        });
    }
    
    function activeDeactiveRole(id, name) {
        if ($("#" + id).is(":checked")) {
            var data = "id=" + id + "&status=1";
            bootbox.confirm({
                message: "Are you sure you want to activate Role " + name + " ?",
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

                        ajax_role_activate_deactivate(data);
                        //location.reload();
                    }
                }
            });
        } else {
            var data = "id=" + id + "&status=0";
            bootbox.confirm({
                message: "Are you sure you want to deactive Role " + name + " ?",
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
                        ajax_role_activate_deactivate(data);
                    }
                }
            });
        }
    }
    
    function ajax_role_activate_deactivate(data) {
        $.ajax({
            type: "POST",
            url: base_url+"role/activeInactiveRole",
            data: data,
            dataType: "json",
            success: function (result) {
                if(result){
                    location.reload();
                }
            }
        });
    }
    
    function editTeam(id) {
                var pos = $(this).attr("id");
                //e.preventDefault();
                //alert(pos);
                $('#teamTypeId').val(id);
                $('#teamlist').attr('action', "/team/edit").submit();
    }

$("#employee_team").change(function(){
    var data = "id=" + $("#employee_team").val() + "&status=1";
       $.ajax({
            type: "POST",
            url: base_url+"user/getUserRoleByTeam",
            data: data,
            dataType: "json",
            success: function (result) {
                
                if(result.status == 1){
                    var html = "<option value=''>Select Role</option>"
                $.each(result.data, function (key, value) {                  
                   html += "<option value='"+value.id+"'>"+value.role_name+"</option>";
                });
                    $("#employee_role").html("");
                    $("#employee_role").html(html);
                    $('#employee_role')[0].sumo.reload();
                    
                }
            }
        });
});

$("#empsearch").click(function (event) {
    var is_search = 1;
    $("#page").val(1);
    $('#imageloder').show();
    $.ajax({
        url: base_url + "user/ajax_userList",
        type: 'post',
        dataType: 'html',
        data: $("#empsearchform").serialize(),
        success: function (response)
       {
           console.log(response);
            $('#employee_list').html("");
            $("#employee_list").html(response);
        }
    });
});

$("#Reset").click(function(){
     location.reload();
})
