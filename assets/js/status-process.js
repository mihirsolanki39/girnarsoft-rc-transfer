/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var statusObj =function () {this.dealerId='';};
/* Get Feedback From  */
statusObj.prototype.getFeedbackForm = function (ev) {
    var dealer_id=$(ev.currentTarget).attr('id').split('-');
    this.dealerId=dealer_id[1];
    if(this.dealerId){
         $.post(HOST+"dealer/ajax_dealer_assistance_feedback_from", {
             'type':'getfeedback'
           }, function (data) {
               $('#update_status_form').empty();
               $('#update_status_form').append(data);
               $('#update_status_form').modal('show');
               $( "#next_follow_date" ).datepicker( {dateFormat: 'yy-mm-dd',minDate: new Date()});
        });
    }
    else {
            return false;
         }
};
statusObj.prototype.validateFormNotCallData= function () {
    /*var issue = $('.issue_check_not:checked').map(function(){
                return this.value;
            }).get();*/
        var next_follow_date= $('#next_follow_date').val();
        /*if(issue.length==0){
          return response={status:false, message:"Please select call not connect options."};  
        }*/
       if(!next_follow_date){
                $('#next_follow_date').focus();
                return response={status:false, message:"Please select next followup date."};  
        }
         else {
             return response={status:true};
        }
    }
statusObj.prototype.validateFormData= function (data) {
    var call_typ =$("select[name='call_type'] option:selected").val();
    if(call_typ==""){
       $('#call_type').focus(); 
       return response={status:false, message:"Please select Call Status"}; 
    }
    if(call_typ!=1){
        return this.validateFormNotCallData();
    }
    var next_follow_date= $('#next_follow_date').val();
    var sentiments_type= $("input[name='sentiments_type']:checked").val();
    var comment=$('#comment').val();
    var issue = $('.issue_check:checked').map(function(){
                return this.value;
            }).get();
    
    if(!this.dealerId){
        return response={status:false, message:"Dealer id can't be blank"};
    }
    else if(issue.length===0){
      return response={status:false, message:"Please select feedback options."};  
    }
    else if(!next_follow_date){
      $('#next_follow_date').focus();
      return response={status:false, message:"Please select next followup date."};  
    }
    else if(!comment){
      $('#comment').focus();
      return response={status:false, message:"Please enter some feedback comment."}; 
    }
    else if(!sentiments_type){
      $('#sentiments_type').select();
      return response={status:false, message:"Please select sentiment."}; 
    }
    else {
         return response={status:true};
    }
};
statusObj.prototype.viewHistory= function (ev) {
    var dealer_id=$(ev.currentTarget).attr('id').split('-');
    this.dealerId=dealer_id[1];
    if(this.dealerId){
         $.post(HOST+"dealer/ajax_dealer_assistance_feedback_history", {
             'dealer_id':this.dealerId
           }, function (data) {
               $('#timeline-new').empty();
               $('#timeline-new').append(data);
               $('#timeline-new').modal('show');
        });
    }
};
statusObj.prototype.openDealerDashBoard= function (ev) {
    var dealer_id=$(ev.currentTarget).attr('id');
    var domain=$(ev.currentTarget).attr('domain');
    this.dealerId=dealer_id;
    console.log('http://'+domain+'/admin/dealeruser/dealer_direct_login/?token='+dealer_id);
    window.open('http://'+domain+'/admin/dealeruser/dealer_direct_login/?token='+dealer_id,'blank');
    };
statusObj.prototype.swipeOption = function (ev){
   var type=$('select[name="call_type"]').val()
   if(type!=1 && type!=''){
       $('#call_connected').fadeOut('fast');
       //$('#call_not_connected').fadeIn('slow');
   }else {
       //$('#call_not_connected').fadeOut('fast');
       $('#call_connected').fadeIn('slow');
   }
}
statusObj.prototype.saveFeedbackForm = function (ev) {
    var response=this.validateFormData(ev);
    if(!response["status"])
    {
        alert(response["message"]);
        return false;
    }
    else {
            var call_typ =$("select[name='call_type'] option:selected").val();
                if(call_typ!=1){
                    this.saveNotConnectFeedback();
                }
            else {
                    this.saveConnectFeedback();
                }
         }
};
statusObj.prototype.saveNotConnectFeedback= function (ev){
            /*var issue = $('.issue_check_not:checked').map(function(){
                return this.value;
            }).get();*/
            $.post(HOST+"dealer/ajax_dealer_assistance_save_feedback", {
             'call_type'        : $("select[name='call_type'] option:selected").val(),
             'dealer_id'        : this.dealerId,
             'next_follow_date' : $('#next_follow_date').val(),
             'comment'          : $('#comment').val(),
            }, function (data) {
               if(data.response.status){
                   alert(data.response.message);
                   $('#searchDealer').trigger('click');
               }
               else {
                   alert('Sorry feedback not saved successfully');
               }
               $('#update_status_form').modal('hide');
            });
}
statusObj.prototype.saveConnectFeedback= function (ev){
            var issue = $('.issue_check:checked').map(function(){
                return this.value;
            }).get();
            console.log(issue);
            $.post(HOST+"dealer/ajax_dealer_assistance_save_feedback", {
             'issue_check'            : issue,
             'call_type'        : $("select[name='call_type'] option:selected").val(),
             'sentiments_type'  : $("input[name='sentiments_type']:checked").val(),
             'next_follow_date' : $('#next_follow_date').val(),
             'comment'          : $('#comment').val(),
             'dealer_id'        : this.dealerId
            }, function (data) {
               if(data.response.status){
                   alert(data.response.message);
                   $('#searchDealer').trigger('click');
               }
               else {
                   alert('Sorry feedback not saved successfully');
               }
               $('#update_status_form').modal('hide');
            });
}
var statusObjInit = new statusObj();
 $('body').on('click', '.update_status', function (ev) {
            statusObjInit.getFeedbackForm(ev);
    });
$('body').on('click', '#update_status_sub', function (ev) {
            statusObjInit.saveFeedbackForm(ev);
});
 $('body').on('click', '.history_view', function (ev) {
           statusObjInit.viewHistory(ev);
});
$('body').on('click', '.dashboard', function (ev) {
           statusObjInit.openDealerDashBoard(ev);
});
$('body').on('click', '.connected', function (ev) {
           statusObjInit.swipeOption(ev);
});
