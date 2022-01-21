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
        $.post(base_url+"lead/get_history", {
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
       this.follow_up       =$('#followup_date_'+this.lead_id).val();
       this.rating          =$('#rating_'+this.lead_id).val();
       this.reminder_date   =$('#reminder_date_'+this.lead_id).val();
       var oldFollowUP = new Date(this.follow_up);
       $newFollowUp = new Date();
       $newFollowUp.setDate($newFollowUp.getDate());
       checkFollowUP=true;
       if(oldFollowUP < $newFollowUp){
       checkFollowUP=false;
       }
       //alert(checkFollowUP+'---'+this.currentStatus +'---'+oldFollowUP+'---'+$newFollowUp);
       if(!this.follow_up && (this.currentStatus !='Converted' && this.currentStatus !='Closed')){
           //alert('please select followup date.');
           snakbarAlert('please select followup date.');
           return false;
       } 
       else if (checkFollowUP==false && (this.currentStatus !='Converted' && this.currentStatus !='Closed')){
            //alert('please select future followup date and time.');
            snakbarAlert('please select future followup date and time.');
              return false;
       }
       if($.inArray(this.currentStatus, ['New', 'Interested', 'Walk-in Scheduled', 'Follow Up']) != -1){
           this.saveStatusProcess();
       }
       else if($.inArray((this.currentStatus), ['Walk-in Done','Closed']) != -1) {
           /* condition used to handle same status submit again proces */
           if(this.lastStatus==this.currentStatus){
               this.saveStatusProcess();
           }else
           {
                 this.openFeedbackForm();
           }
       }
       else {
            /* condition used to handle same status submit again proces */
            if(this.lastStatus==this.currentStatus){
                this.saveStatusProcess();
            }else
            {
                this.openSelectionForm();
            }
           
       }
       //console.log(this.lead_id +'---'+this.mobile+'---'+this.lastStatus+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
}

leadObj.prototype.processFeedback = function (ev) {
       this.feedback        = $("input:radio[name=feedback_answer]:checked").val();
       var feedback_comment = $("#comment_feedback").val();
       if(!this.feedback && !feedback_comment){
           //alert('please select feedback option.');
           snakbarAlert('please select feedback option.');
       }
       else {
           if(this.feedback && feedback_comment ){
                var feedbackVal=this.feedback.split('$');
                this.feedback=feedbackVal[0]+'$'+feedback_comment;//this.feedback+" : "+
         }
        else if(feedback_comment) {
            this.feedback=feedback_comment;
        }
           this.saveStatusProcess();
          jQuery('#feedbackFrm').modal('hide');
           $('#walkinfeedback').empty();
       }
      //console.log( this.feedback +'---'+ this.lead_id +'---'+this.mobile+'---'+this.lastStatus+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
}
leadObj.prototype.processOffer = function (ev) {
       this.car_id   =$("input:radio[name=select_car_offer]:checked").val();
       this.offer    =parseInt($('#amount_'+this.car_id).val().replace(/,/g, ""));
       var currentStatus=$('#status_amount').val();
       var pricAmount=parseInt($('#amount_car_'+this.car_id).val());
       //alert(pricAmount+'---'+currentStatus+'---'+this.offer);
       if(!this.car_id){
           //alert('please select a car.');
           snakbarAlert('please select a car.');
       }
       else if(!this.offer){
           //alert('please enter amount');
           snakbarAlert('please enter amount');
           $('#amount_'+this.car_id).focus();
       }
       else if (currentStatus=='Booked' && this.offer>pricAmount){
            //alert('Offer amount should be less than car price.');
            snakbarAlert('Offer amount should be less than car price.');
            $('#amount_'+this.car_id).focus();
       }
       else if (this.offer>pricAmount || this.offer<20000 && currentStatus!='Booked'){
            //alert('Amount should be less than car price and greater than 20k.');
            snakbarAlert('Amount should be less than car price and greater than 20k.');
            $('#amount_'+this.car_id).focus();
       }
       else {
           
           this.saveStatusProcess();
           jQuery('#booking-done').modal('hide');
       }
      //console.log( this.feedback +'---'+ this.lead_id +'---'+this.mobile+'---'+this.lastStatus+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
}
leadObj.prototype.saveStatusProcess = function () {
    //alert(this.lead_id +'---'+this.mobile+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
     var ths=this;
     if(this.currentStatus=='Closed' || this.currentStatus=='Walk-in Done'){
     }
     else {
               this.feedback=null;   
     }
     if (this.lead_id) {
        $('#imageloder').show();
        $('#comment_mapper_id').val(this.lead_id);
        $('saveleadupdate_'+this.lead_id).attr('disabled','disabled');
        $.post(base_url+"lead/ajax_buyer_lead_update", {
            lead_id             : this.lead_id,
            txtmobile           : this.mobile,
            status              : this.currentStatus,
            follow_up           : this.follow_up,
            rating              : this.rating,
            reminder_date       : this.reminder_date,
            comment             : this.comment,
            feedback            : this.feedback,
            car_id              : this.car_id,
            offer               : this.offer,
            type                : 'savestatus'
        }, function (data) {
           this.feedback            =null;
           this.car_id              =null;
           this.booking_amount      =null;
           this.offer_amount        =null;
           this.sale_amount         =null;
        if(data){
           $('#saveleadupdate_'+ths.lead_id).attr('disabled','');
           $('#spnsavecustomerdetail_'+ths.lead_id).text('');
           
           setTimeout(function(){
               var result=JSON.parse(data);
               if(result.booking_form_url!='' &&  result.booking_form_url!=null && typeof result.booking_form_url !='undefined'){
                   window.open(result.booking_form_url,'_blank');
               }
           },2100);
           snakbarAlert('Lead updated successfully');
           $('#imageloder').hide();
           $('#spnsavecustomerdetail_'+ths.lead_id).text('');
           window.location.href = data;

            
           
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
            customer_name       : customer_name,
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
    //console.log(this.lead_id +'---'+this.mobile+'----'+this.currentStatus+'---'+this.follow_up+'---'+this.rating+'---'+this.reminder_date+'---'+this.comment);
    if (this.lead_id) {
        $('#comment_mapper_id').val(this.lead_id);
        $.post(base_url+"lead/ajax_buyer_lead_update", {
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
           console.log(ui);
           if(ui.item.id){
           $('#stockHtml').empty().append(ui.item.html);
       }
      }
    });
    })
})