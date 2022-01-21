 //$('#search').click(function (event) {
$(document).on('click','#search',function(event){
    $('#page').val('1');
    $('#imageloder').show();
    let formDataSearch=$('#stockSearchForm').serialize();
    $.ajax({
      type: 'POST',
      url: base_url+"refurb/ajax_getRefurb",
      data: formDataSearch,
      dataType: 'html',
      success: function (responseData, status, XMLHttpRequest) {
        var resr = responseData.split('####@@@@@');
        if (resr[1] == 1) {
          var resrtype = resr[0].split('--');
          $('#totcase').text($.trim(resrtype[0]));
          $('#imageloder').hide();
          $('#buyer_list').html("<tr><td align='center' colspan='4'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
        } else {
          var resrtype = resr[0].split('--');
          $('#totcase').text($.trim(resrtype[0]));
          $('#imageloder').hide();
          $('#buyer_list').html(resr[1]);
        }
      }
    });
});
 
jQuery(function(){
 jQuery('#crateddate_from').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#crateddate_to').val()?jQuery('#crateddate_to').val():false
   });
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
 jQuery('#crateddate_to').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#crateddate_from').val()?jQuery('#crateddate_from').val():false
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});

jQuery(function(){
 jQuery('#from_date').datetimepicker({
  format:'d-m-Y',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#to_date').val()?jQuery('#to_date').val():false
   })
  },
  timepicker:false
 });
 jQuery('#to_date').datetimepicker({
  format:'d-m-Y',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#from_date').val()?jQuery('#from_date').val():false
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});

jQuery(function(){
 jQuery('#updatedaterange_from').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#updatedaterange_to').val()?jQuery('#updatedaterange_to').val():false
   })
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
 jQuery('#updatedaterange_to').datetimepicker({
  format:'d/m/Y',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#updatedaterange_from').val()?jQuery('#updatedaterange_from').val():false
   });
  },
  timepicker:false,
  scrollMonth:false,
  scrollTime:false,
  scrollInput:false
 });
});


$(document).ready(function(){
    $('#search').trigger('click');
    var start = 1;
    $('#search,#stocklist,#worklist,#keyword,#lead_source,#make,#budget_min,budget_max,#startdate,#enddate,#status,#regno,#follow_from,#follow_to,#km_from,#km_to,#year_from,#year_to,#price_min,#price_max,#car-withoutPhotos,#car-withPhotos,#crateddate_from,#crateddate_to,#updatedaterange_from,#updatedaterange_to,#startfollowdate,#endfollowdate,#todayworks,#otp_verified').keypress(function (e) {
      if (e.which == 13) {
        //$("#search_button").trigger('click');
        $('#type').val('all');
        $("#all").trigger('click');
        $('#search').trigger('click'); 
        e.preventDefault();
      }
    });
    
    $(window).scroll(function () {
      if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
      start = $('#page').val();
      start++;
      if (jQuery.trim(jQuery('.jtdtext').text()) != 'No record found.')
      {
        $('#loadmoreajaxloader').text('Loading...');
        $('div#loadmoreajaxloader').show();
      }

      $('#page').attr('value', start);
      var formDataload=$('#searchform').serialize();
      $.ajax({
        type: 'POST',
        url: base_url+"refurb/ajax_getRefurb",
        data: formDataload,
        dataType: 'html',
        success: function (responseData, status, XMLHttpRequest) {
          $('#page').attr('value', start);
          var html = $.trim(responseData);
          var resr = html.split('####@@@@@');
          if (parseInt(resr[1]) != 1) {
            $('table.mytbl  tr:last').after(resr[1]);
          }
          else if (parseInt(resr[1]) == 1) 
          {
            start--;
            $('#page').attr('value', start);
            $('#loadmoreajaxloader').text('No More Results');
          }
        }
      });
      }
    });
});

function forceNumber(event){
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
        return false;
}
  
function unique(array){
    return array.filter(function(el, index, arr) {
        return index == arr.indexOf(el);
    });
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function viewrefurb(id){
    getlist(id);
}
 
function getlist(type){

  $('#page').val('1');
  $('#imageloder').show();
  if(type == 1){
    $("#stock_main_div").show();
    $("#work_main_div").hide();
    let formDataSearch=$('#stockSearchForm').serialize();
  } else if(type == 2){
    $("#stock_main_div").hide();
    $("#work_main_div").show();
    let formDataSearch=$('#searchform').serialize();
  }
  
  $.ajax({
    type: 'POST',
    url: base_url+"refurb/ajax_getRefurb",
    data: formDataSearch,
    dataType: 'html',
    success: function (responseData, status, XMLHttpRequest) {
      var resr = responseData.split('####@@@@@');
      if (resr[1] == 1) {
      var resrtype = resr[0].split('--');
      $('#imageloder').hide();
      $('#buyer_list').html("<tr><td align='center' colspan='4'><div class='text-center pad-T30 pad-B30'><img src='"+base_url+"assets/admin_assets/images/NoRecordFound.png'></div></td></tr>");
      } else {
      var resrtype = resr[0].split('--');
      if(type==1){
          $('#refcase').text('Stock');
      }else{
          $('#refcase').text('Workshop');
      }
      $('#totcase').text($.trim(resrtype[0]));
      
      $('#imageloder').hide();
      $('#buyer_list').html(resr[1]);
      }
    }
  });
}

