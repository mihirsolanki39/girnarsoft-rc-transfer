/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var leadObj = function () {
    var lead_id                = '';
    var mobile                 ='';
    var currentStatus          ='';
    var comment                ='';
    var follow_up              ='';
    var lastStatus             ='';
    var feedback               ='';
    var car_id                 ='';
    var offer                  ='';
    var sortType               ='';
    
    

};
leadObj.prototype.getHistory = function (ev) {
    var ths = ev.currentTarget;
    this.lead_id = $(ths).attr('data-id');
    if (this.lead_id) {
        $('#comment_mapper_id').val(this.lead_id);
        $.post(base_url+"insrenewal/get_history", {
            lead_id: this.lead_id,
        }, function (data) {
            if(data!='Sorry request not valid'){
            $('#commentHistory').empty();
            $('#commentHistory').append(data);
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
leadObj.prototype.changeStatusOption = function (ev) {
       var ths          = ev.currentTarget;
       var status       =$(ths).val();
       var selectId     =$(ths).attr('id').split('_');
       if(status=='Interested'){
           $('#rating_'+selectId[1]).css('display','block');
           $('#reminder_date_'+selectId[1]).css('display','none');
           $('#followdate_'+selectId[1]).css('display','none');
           $('#Reminderdiv_'+selectId[1]).css('display','none');
           $('#reminder_date_'+selectId[1]).val('');

       }
       else if (status=='Walk-in Scheduled'){
           $('#rating_'+selectId[1]).css('display','none');
           $('#reminder_date_'+selectId[1]).css('display','block');
           $('#followdate_'+selectId[1]).css('display','block');
           $('#Reminderdiv_'+selectId[1]).css('display','block');
           $('#rating_'+selectId[1]).val('');

       }else {
           $('#rating_'+selectId[1]).css('display','none');
           $('#reminder_date_'+selectId[1]).css('display','none');
           $('#followdate_'+selectId[1]).css('display','none');
           $('#Reminderdiv_'+selectId[1]).css('display','none');
           $('#rating_'+selectId[1]).val('');
           $('#reminder_date_'+selectId[1]).val('');

       }

}
leadObj.prototype.processLeadUpdate = function (ev) {
       
       var ths              = ev.currentTarget;
       this.lead_id         =$(ths).attr('data-leadid');
       this.mobile          =$(ths).attr('data-mobile');
       this.lastStatus      =$('#prevStatusId_'+this.lead_id).val();
       this.currentStatus   =$('#status_'+this.lead_id).val();
       this.comment         =$('#comment_'+this.lead_id).val();
       this.follow_up       =$.trim($('#followup_date_'+this.lead_id).val());
       this.duedatefo       =$.trim($('#duedatefo_'+this.lead_id).val());
       this.foll = $('#clickfolow_'+this.lead_id).val();
       //alert( this.duedatefo );
       //this.rating          =$('#rating_'+this.lead_id).val();
       //this.reminder_date   =$('#reminder_date_'+this.lead_id).val();
       var oldFollowUPdue = LeadObjInit.getOnlyDate(this.follow_up);
       var newFollowUpdue =this.duedatefo;
       //alert(oldFollowUPdue+'------'+newFollowUpdue);
       if((oldFollowUPdue>newFollowUpdue) && (this.foll!='1'))
       {
         $('#savecase_id').val(this.lead_id);
         $('#clickfolow_'+this.lead_id).val('1');
         $("#displayalertfu").attr('style','display:block');
         $("#displayalertfu").addClass(' in');
         return false;
       }else{
        $('#clickfolow_'+this.lead_id).val('0');
        $("#displayalertfu").attr('style','display:none');
        $("#displayalertfu").removeClass(' in');
       }
        
        console.log("Follow up"+this.follow_up);
        checkFollowUP=true;
       //var oldFollowUP = new Date(this.follow_up);
       if(this.follow_up != ""){
       oldFollowUP = LeadObjInit.getOnlyDate(this.follow_up);
       $newFollowUp = LeadObjInit.getOnlyDate(new Date());
       console.log(oldFollowUP+"==========="+$newFollowUp);
//       $newFollowUp = new Date();
//       $newFollowUp.setDate($newFollowUp.getDate());
      
       
       if(oldFollowUP < $newFollowUp){
       checkFollowUP=false;
       }
       
       }
       
       if(this.follow_up == "" && this.currentStatus != "Closed"){
           snakbarAlert('please select followup date.');
           return false;   
       }
       
       //alert(checkFollowUP+'---'+this.currentStatus +'---'+oldFollowUP+'---'+$newFollowUp);
       else if(this.follow_up == "" && (this.currentStatus !='New' && this.currentStatus !='Closed' && this.currentStatus !='Policy Pending')){
           //alert('please select followup date.');
           snakbarAlert('please select followup date.');
           return false;
       } 
       else if (checkFollowUP==false && (this.currentStatus !='New' && this.currentStatus !='Closed' && this.currentStatus !='Policy Pending')){
            //alert('please select future followup date and time.');
            snakbarAlert('please select future followup date and time.');
              return false;
       }
       if(this.comment=='' && (this.currentStatus !='New' && this.currentStatus !='Closed')){
          // console.log("please add comment.");
          snakbarAlert('please add comment.');
              return false; 
       }
       if($.inArray(this.currentStatus, ['Follow Up', 'Quotes shared']) != -1){
            // console.log("saveStatusProcess");
           this.saveStatusProcess();
       }
       else {
            /* condition used to handle same status submit again proces */
            if(this.lastStatus==this.currentStatus){
              //  console.log("save karo");
                this.saveStatusProcess();
            }else if(this.currentStatus=='Closed')
            {
                this.openFeedbackForm();
            }else{
               
            }
           
       }
       //console.log(this.lead_id +'---'+this.mobile+'---'+this.lastStatus+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
}

leadObj.prototype.processFeedback = function (ev) {
       this.feedback        = $("input:radio[name=feedback_answer]:checked").val();
       //var feedback_comment = $("#comment_feedback").val();
       if(!this.feedback){
           //alert('please select feedback option.');
           snakbarAlert('please select feedback option.');
       }
       else {
           arr=this.feedback.split('$');
           this.feedback=arr[0];
           this.feedback_comment=arr[1];
           if(this.feedback){
                this.feedback=this.feedback;
                this.feedback_comment=this.feedback_comment;
         }
           this.saveStatusProcess();
          jQuery('#feedbackFrm').modal('hide');
           $('#walkinfeedback').empty();
       }
      //console.log( this.feedback +'---'+ this.lead_id +'---'+this.mobile+'---'+this.lastStatus+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
}
leadObj.prototype.saveStatusProcess = function () {
    //alert(this.lead_id +'---'+this.mobile+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
     var ths=this;
     if(this.currentStatus=='Quotes shared' || this.currentStatus=='Payment Pending' || this.currentStatus=='Policy Pending'){
     }else if(this.currentStatus=='Closed'){
         this.feedback_id=this.feedback;
         this.comment=this.feedback_comment;
     }
     else {
               this.feedback=null;   
     }
     if (this.lead_id) {
        $('#imageloder').show();
        //$('#comment_mapper_id').val(this.lead_id);
        $('saveleadupdate_'+this.lead_id).attr('disabled','disabled');
        $.post(base_url+"insrenewal/renewUpdateStatus", {
            case_id             : this.lead_id,
            feedback_id         : this.feedback_id,
            status              : this.currentStatus,
            follow_up           : this.follow_up,
            comment             : this.comment,
            type                : 'savestatus'
        }, function (data) {
           //this.feedback            =null;
           this.car_id              =null;
        if(data){
           $('#saveleadupdate_'+ths.lead_id).attr('disabled','');
           $('#spnsavecustomerdetail_'+ths.lead_id).text('');
           snakbarAlert('Insurance Renewal update succesfully ');
           $('#imageloder').hide();
           setTimeout(function () {
            $('#spnsavecustomerdetail_'+ths.lead_id).text('');
            $('#search').trigger('click');
                    }, 2000);
           
        }
        else {
            $('#imageloder').hide();
            //alert('Sorry request not valid');
            snakbarAlert('Sorry request not valid');
        }
            
        }, 'html');
    } else {
        //alert('sorry lead data not valid');
         snakbarAlert('sorry lead data not valid');
    }

}
leadObj.prototype.openSelectionForm = function () {
    jQuery('#booking-done').modal('show');
    $('#bookoffersalecar').empty();
    var favorite=$('#favouriteCars_'+this.mobile).val();
    var cusid='customer_name_'+this.mobile;
    var customer_name=$("#"+cusid).text();
    //console.log(this.lead_id +'---'+this.mobile+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
    if (this.lead_id) {
        $('#comment_mapper_id').val(this.lead_id);
        $.post(base_url+"lead/ajax_buyer_lead_update", {
            status              : this.currentStatus,
            lastStatus          : this.lastStatus,
            type                : 'getbookingoffer',
            lead_id             : this.lead_id,
            customer_name             : customer_name,
            favorite            : favorite
        }, function (data) {
            if(data){
            //console.log(data)
            $('#bookoffersalecar').append(data);
        }
        else {
            //alert('Sorry request not valid');
            snakbarAlert('Sorry request not valid');
        }
            
        }, 'html');
    } else {
        //alert('sorry lead data not valid');
        snakbarAlert('sorry lead data not valid');
    }

}
leadObj.prototype.openFeedbackForm = function () {
    jQuery('#feedbackFrm').modal('show');
    $('#walkinfeedback').empty();
    //console.log(this.lead_id +'--'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
    if (this.lead_id) {
        $('#comment_mapper_id').val(this.lead_id);
        $.post(base_url+"insrenewal/ajax_renew_lead_update", {
            status              : this.currentStatus,
            lastStatus          : this.lastStatus,
            type                : 'getfeedback'
        }, function (data) {
            if(data){
            //console.log(data)
            $('#walkinfeedback').append(data);
        }
        else {
            //alert('Sorry request not valid');
            snakbarAlert('Sorry request not valid');
        }
            
        }, 'html');
    } else {
        //alert('sorry lead data not valid');
        snakbarAlert('sorry lead data not valid');
    }

},
leadObj.prototype.sortLeadData = function (ev) {
    var ths =ev.currentTarget;
    alert(ths);
    $('#lead_sort').val($(ths).val());
    $('#search').trigger('click');
 },
leadObj.prototype.changeDataType = function (ev){
    var ths          = ev.currentTarget;
    var value        = $(ths).val();
   // alert(value);
    if(value=='todayworks'){
        $('.selectpicker').prop('disabled', true);
        //$('').selectpicker('refresh');
        $('#allleads_label').removeClass('text-bold');
        $('#'+value+'_label').addClass('text-bold');
        //$('#sort_filter').css('display','none');
    }
    else{
        $('.selectpicker').prop('disabled', false);
       // $('#basic').selectpicker('refresh');
        $('#todayworks_label').removeClass('text-bold')
        $('#'+value+'_label').addClass('text-bold');
        //$('#sort_filter').css('display','block');
   }
   
  /* $('#'+value).toggle(
        function () { 
            $('#'+value).attr('Checked','Checked'); 
        },
        function () { 
            $('#'+value).removeAttr('Checked'); 
        }
    )*/
    //$('#filter_data_type').val(value);
    //$('#search').trigger('click');

//alert($('#'+value).is(':checked'));
 if($('#'+value).is(':checked')==true){
        $('#filter_data_type').val("todayworks");
        $('#sort_filter').css('display','none');
    }else{
        $('#filter_data_type').val("allleads");
        $('#sort_filter').css('display','block');
    }
   
}
leadObj.prototype.getOnlyDate = function (dateObject){
   var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = day + "/" + month + "/" + year;

    return date;
}


var LeadObjInit = new leadObj();
$(window).on('load',function(){
        $('.selectpicker').prop('disabled', true);
})
$(document).ready(function () {
    $(document).on('click', '.history-more', function (ev) {
        LeadObjInit.getHistory(ev);

    })
    $(document).on('change', '.status_select', function (ev) {
          LeadObjInit.changeStatusOption(ev);
    })
    $(document).on('click', '.typecheck', function (ev) {
          LeadObjInit.changeDataType(ev);
    })
    $(document).on('click','.updatelead', function (ev) {
        LeadObjInit.processLeadUpdate(ev);
    })
     $(document).on('click','.updateleadyes', function (ev) {
        var case_id = $('#savecase_id').val();
        $('#saveleadupdate_'+case_id).trigger('click');
        //LeadObjInit.processLeadUpdate(ev,'1');
    })
    $(document).on('click','#saveFeedback',function(ev){
         LeadObjInit.processFeedback(ev);
    })
    $(document).on('click','.show_comment_area',function(ev){
        $('#show_comment').css('display','block');
    })
     $(document).on('click','#saveofferstatus',function(ev){
         LeadObjInit.processOffer(ev);
    })
    $(document).on('change','#basic',function(ev){
         LeadObjInit.sortLeadData(ev);
    })
    $(document).on('click','.stock-in',function(ev){
         $("input:radio[name='select_car_offer']").each(function(i) {
         this.checked = false;
        });
        $('.rupee').val('');
        $('.price-text').text('');
    })
    $(document).on('click','.searchmakemodellive',function(ev){
       $( ".searchmakemodellive" ).autocomplete({
       source: "ajax_buyer_lead_update",
       minLength: 2,
       select: function( event, ui ) {
           //console.log(ui);
           if(ui.item.id){
           $('#stockHtml').empty().append(ui.item.html);
       }
      }
    });
    })
})