var leadObj = function () {};

var LeadObjInit = new leadObj();
leadObj.prototype.getHistory = function (ev) {
    var ths = ev.currentTarget;
    this.customer_id = $(ths).attr('data-id');
    if (this.customer_id) {
        //$('#comment_mapper_id').val(this.lead_id);
        $.post(base_url+"insurance/get_history", {
            customer_id: this.customer_id,
        }, function (data) {
            if(data!='Sorry request not valid'){
            $('#commentInsHistory').empty();
            $('#commentInsHistory').append(data);
        }
        else {
            //alert('Sorry request not valid');
            snakbarAlert('Sorry request not valid');
        }
            
        }, 'html');
    } else {
        //alert('sorry view more id is blank');
        snakbarAlert('sorry view more id is blank');
    }
}
$(document).ready(function () {
$(document).on('click', '.history-more', function (ev) {
        LeadObjInit.getHistory(ev);

    })
});
function blockSpecialChar(e) {
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

