/*$(function () {
			var closediv = $(".multi-dropdwn" ).next(" .dropdown-menu");
			$(".multi-dropdwn").click( function(e){				
				$(this ).next(" .dropdown-menu").toggle();					
				})			
				$(document).mouseup(function(e) {
					if (closediv.has(e.target).length == 0) {
				closediv.hide();
				}
				})
			});*/

var is_reg_no_valid=true;

$(document).ready(function(){
	
/*$('#Comprehensive,#thirdParty').click(function(){
            $('.year-field').show();
    });
$('#NoInsurance').click(function(){
        $('.year-field').hide();
})*/

jQuery('#savedetail').click(function(){

	$('#clickbtton').val('save');
	
})
jQuery('#Preview').click(function(){

	$('#clickbtton').val('preview');
	
})

jQuery('#color').change(function()
{
      //alert(jQuery('#color').val());
	  if(jQuery('#color').val()!='')
		{
			$('#selcolordiv').removeClass('has-error');
			$("#selcolor").css("visibility", "hidden");
			//$("#selcolordivhide").css("display", "block");
			
		}
	  if(jQuery('#color').val()=='Other')
	  {
		$("#othercolors").css("display", "block");
		//$("#selcolordivhide").css("display", "none");
                //$("#othercolorsfirst").css("display", "none");
		
	  }
	  else
	  {
	  	$("#selcolordivhide").css("display", "block");
		$("#othercolors").css("display", "none");
                $("#othercolorsfirst").css("display", "none");
		//$('#othercolors').removeClass('has-error');
		$("#othercolors2").css("display", "none");
	  }
})


jQuery('#month').change(function(){
	if(jQuery('#month').val()!='')
	{
		$('#selmonthdiv').removeClass('has-error');
		$("#selmonth").css("display", "none");
	}

})

jQuery('#owner').change(function(){
	if(jQuery('#owner').val()!='')
	{
		$('#selownerdiv').removeClass('has-error');
		$("#selowner").css("display", "none");
	}
})

jQuery('#dealermobile').keypress(function(){
if(jQuery('#dealermobile').val()!='')
{
	$('#seldealermobilediv').removeClass('has-error');
	$("#seldealermobile").css("display", "none");
}
})

jQuery('#dealerprice').keypress(function(){
if(jQuery('#dealerprice').val()!='')
{
	$('#seldealerrealpricediv').removeClass('has-error');
		$("#seldealerrealprice").css("display", "none");
}
})

jQuery('#othercolor').keypress(function(){
if(jQuery('#othercolor').val()!='')
{
	$('#othercolors').removeClass('has-error');
	$("#othercolors2").css("display", "none");
}
})

jQuery('#otherregcity').keypress(function(){
if(jQuery('#otherregcity').val()!='')
{
	$('#otherplace').removeClass('has-error');
	$("#otherplace2").css("visibility", "hidden");
}
})

jQuery('#regcity').change(function(){
if(jQuery('#regcity').val()!='')
{
	$('#selregcitydiv').removeClass('has-error');
	$("#selregcity").css("display", "none");
	$('#otherplace').removeClass('has-error');
	$("#otherplace2").css("visibility", "hidden");
}

})
jQuery('#reg_month').change(function(){
if(jQuery('#reg_month').val()!='')
{
	$('#selregmonthdiv').removeClass('has-error');
	$("#selregmonth").css("display", "none");
	
}

})

jQuery('#reg_year').change(function(){
if(jQuery('#reg_year').val()!='')
{
	$('#selregyeardiv').removeClass('has-error');
	$("#selregyear").css("display", "none");
	
}

})

jQuery('#tranmission').change(function(){
if(jQuery('#tranmission').val()!='')
{
	$('#seltranmissiondiv').removeClass('has-error');
	$("#seltranmission").css("display", "none");
}

})

jQuery('#fuel').change(function(){
//alert('hello');
if(jQuery('#fuel').val()!='')
{
	$('#selfueldiv').removeClass('has-error');
	$("#selfuel").css("display", "none");
}

})

/*jQuery('#city').change(function(){
jQuery('.as-close').trigger('click');
 var cid=jQuery('#city').find('option:selected').attr('rel');
 jQuery.ajax({
					type:'POST',
					url: "ajax/zones.php?type=aads&cid="+cid,
					data:"",
					dataType:'html',
					async :false,
					
					success:function (responseData, status, XMLHttpRequest) { 
							
					}
				});

})
*/
	
	
$("#rcid").blur(function(e) {
			$("#rcid").attr('value','');
            
}) 

$('#jiyear').change(function(){
		if($('#jiyear').val()!='')
		{
			$('#insurancemonth').removeClass('has-error');
			$("#selinsurancemonth").css("display", "none");
		}
		
        var lastyear = $('#jiyear option:last-child').val();
        var firstyear = $("option.jiyear:first").val();
        var currentmonth = ($( ".iyear" ).val());
	var explode = currentmonth.split("_");
        var currentMonth=explode[0];
        var e =$(this);
        var currentYear=e.val();
        var html='';
        var text = '';
	//alert(lastyear);alert(firstyear);alert(currentmonth);alert(currentMonth);alert(currentYear);
        if(firstyear==currentYear)
        {
	
            for(var i=currentMonth;i<='12';i++)
            {
			

                if(i=='01')
                {
                    text ='Jan';
                }
                if(i=='02')
                {
                    text ='Feb';
                }
                if(i=='03')
                {
                  text ='Mar';
                }
                if(i=='04')
                {
                    text ='Apr';
                }
                if(i=='05')
                {
                    text ='May';
                }
                if(i=='06')
                {
                    text ='Jun';
                }
                if(i=='07')
                {
                    text ='Jul';
                }
                if(i=='08')
                {
                    text ='Aug';
                }
                if(i=='09')
                {
                    text ='Sep';
                }

                if(i=='10')
                {
                    text ='Oct';
                }
                if(i=='11')
                {
                    text ='Nov';
                }
                if(i=='12')
                {
                    text ='Dec';
                }
									
								
									
                html+='<option class="jimonth" value="'+i+'">'+text+'</option>';
            }
		
        }
       else if(lastyear==currentYear)
        {
	
            for(var i=01;i<=currentMonth;i++)
            {


                if(i=='01')
                {
                    text ='Jan';
                }
                if(i=='02')
                {
                    text ='Feb';
                }
                if(i=='03')
                {
                    text ='Mar';
                }
                if(i=='04')
                {
                    text ='Apr';
                }
                if(i=='05')
                {
                    text ='May';
                }
                if(i=='06')
                {
                    text ='Jun';
                }
                if(i=='07')
                {
                    text ='Jul';
                }
                if(i=='08')
                {
                    text ='Aug';
                }
                if(i=='09')
                {
                    text ='Sep';
                }
                if(i=='10')
                {
                    text ='Oct';
                }
                if(i=='11')
                {
                    text ='Nov';
                }
                if(i=='12')
                {
                    text ='Dec';
                }
							
                html+='<option class="jimonth" value="'+i+'">'+text+'</option>';
            }
        }else
	{
	      html+='<option  value="">Month</option>';

	}		

        $('#jimonth').html(html);
        //$('.jmselectbox').html('Month');
        //$('#jimonth').attr('value',0);
        $('#jimonth').change(function(){
	
            $('.insuranceradioerror').text('');
            var month  = $(this);
            var textversion = month.text();
            var month = month.attr('rel');
            $('#jimonth').attr('value',month);
            $('.jmselectbox').html(textversion);
        })
        $('.insuranceradioerror').text('');
        var year  = $(this);
        var yeatext = year.text();
        var yearrel = year.attr('rel');
        $('#jiyear').attr('value',yearrel);
        $('.jselectboxtyear').text(yeatext);
    })
	
	$('#registeredcar').click(function(){
		var elm = jQuery(this);
		if(!elm.is(':checked'))
			{
				$('#regshow').attr('style','display:none');
			$('#selregdiv').removeClass('has-error');
			$("#selreg").css("display", "none");
			$('#selregcitydiv').removeClass('has-error');
			$("#selregcity").css("display", "none");
			$('#selownerdiv').removeClass('has-error');
			$("#selowner").css("display", "none");
			$("#otherplace").css("visibility", "hidden");
			$('#selregmonthdiv').removeClass('has-error');
			$("#selregmonth").css("display", "none");
			$('#selregyeardiv').removeClass('has-error');
			$("#selregyear").css("display", "none");
			//	jQuery('.regerror').text('');
				//jQuery('.regcityerror').text('');
				//jQuery('.ownererror').text('');
				//jQuery('.regerror').text('');
				jQuery('#regcity').attr('disabled',true);
				jQuery('#regcity').val('');
				jQuery('#reg_month').attr('disabled',true);
				jQuery('#reg_month').val('');
				jQuery('#reg_year').attr('disabled',true);
				jQuery('#reg_year').val('');
				jQuery('#reg').attr('readonly',true);
				jQuery('#reg').val('');
				jQuery('#owner').val('0');
				jQuery('#owner').attr('disabled',true);
				jQuery('#showsite').attr('disabled',true);
				jQuery('#showsite').attr('checked',false);
				jQuery('#regcityrto').val('');
				jQuery('#regcityrto').attr('readonly',true);
				$("#otherplace2").css("visibility", "hidden");
				
				
			}
		else
			{
				//jQuery('.regerror').text('');
				//jQuery('.regcityerror').text('');
				//jQuery('.ownererror').text('');
				$('#regshow').attr('style','display:block');
				$("#otherplace2").css("visibility", "hidden");
				jQuery('#regcity').attr('disabled',false);
				jQuery('#regcity').attr('value','');
				jQuery('#reg_month').attr('disabled',false);
				jQuery('#reg_month').val('');
				jQuery('#reg_year').attr('disabled',false);
				jQuery('#reg_year').val('');
				jQuery('#reg').attr('readonly',false);
				jQuery('#reg').attr('value','');
				jQuery('#owner').attr('value','0');
				jQuery('#owner').attr('disabled',false);
				jQuery('#showsite').attr('disabled',false);
				jQuery('#showsite').attr('checked',false);
				jQuery('#regcityrto').attr('value','');
				
				jQuery('#regcityrto').attr('readonly',false);
				
			}
	});

$('#reg').blur(function(){ 
		var elm = jQuery(this);
		//var valueadded = elm.attr('value').replace(/\W/g, '');
		var valueadded =$("#reg").val();
		if(valueadded)
		{
			$('#selregdiv').removeClass('has-error');
			$("#selreg").css("display", "none");
		}
		//alert(valueadded);
			if(parseInt(valueadded.length)<=5){$("#regcityrto").val('');}
			if(parseInt(valueadded.length)>=4){
				
//			$.ajax({
//					type:'POST',
//					url: "ajax/map_rto_city.php?reg="+valueadded,
//					data:"",
//					dataType:'html',
//					async :false,
//					success:function (responseData, status, XMLHttpRequest) { 
//								//alert(responseData);
//							var datah=responseData.split('###');
//							$("#regcityrto").val(datah[0]);
//							
//							
//					}
//				});
			}
	});	


	
});

function forceNumber(event){
    var keyCode = event.keyCode ? event.keyCode : event.charCode;
    if((keyCode < 48 || keyCode > 58) && keyCode != 188 && keyCode != 8 && keyCode != 127 && keyCode != 13 && keyCode != 0 && !event.ctrlKey)
        return false;
}
 

function addCommasdd(nStr,control,hiddenfld)
{
	nStr=nStr.replace(/,/g,'');  
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{2})/;
	var len;
	var x3="";
	len=x1.length;
	if(len>3){
		var par1=len-3;
		
		x3=","+x1.substring(par1,len);
		x1=x1.substring(0,par1);
		
		//alert(x3);
	}
	len=x1.length;
	if(len>=3 && x3!=""){
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	}
	if(nStr)
	{
	 if(hiddenfld=="realkm")
	 {
		$('#selkmdiv').removeClass('has-error');
		$("#selkm").css("display", "none");
	 }
	 if(hiddenfld=="realprice")
	 {
		$('#selpricegaddidiv').removeClass('has-error');
		$("#selpricegaddi").css("display", "none");
		$('#seldealerrealpricediv').removeClass('has-error');
		$("#seldealerrealprice").css("display", "none");
		//var DealerPrice=parseInt($('#dealerprice').val());
		//if(DealerPrice!='' && DealerPrice>nStr)
		//{
		//	document.getElementById("dealerrealprice").value=nStr;
		//	document.getElementById("dealerprice").value=x1 +x3+x2;
		//}
	 }
	}
	//return x1 + x2;
	//alert(x1 + x2);
	document.getElementById(hiddenfld).value=nStr;
	jQuery('.gaadipricecheck-text').text('');
	document.getElementById(control).value=x1 +x3+x2;
}

function addCommasdealer(nStr,control,hiddenfld)
{
if(nStr)
{
 document.getElementById("addtodealer").checked = true;
}
else
{
 document.getElementById("addtodealer").checked = false;
}
	nStr=nStr.replace(/,/g,'');  
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{2})/;
	var len;
	var x3="";
	len=x1.length;
	if(len>3){
		var par1=len-3;
		
		x3=","+x1.substring(par1,len);
		x1=x1.substring(0,par1);
		
		//alert(x3);
	}
	len=x1.length;
	if(len>=3 && x3!=""){
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	}
	//return x1 + x2;
	//alert(x1 + x2);
	document.getElementById(hiddenfld).value=nStr;
	document.getElementById(control).value=x1 +x3+x2;
}
function getTimeTakenToUploadInventory(start,end){

var endtime = end;
var starttime =start;
var difference= endtime-starttime;

var daysDifference = Math.floor(difference/60/60/24);
difference -= daysDifference*60*60*24;

var hoursDifference = Math.floor(difference/60/60);
 difference -= hoursDifference*60*60;

 var minutesDifference = Math.floor(difference/60);
 difference -= minutesDifference*60;

 var secondsDifference = Math.floor(difference);

///console.log(daysDifference+' Day/s '+hoursDifference+' Hours '+minutesDifference+' Min '+secondsDifference+' Sec ');
var timespent =daysDifference+' Day/s '+hoursDifference+' Hours '+minutesDifference+' Min '+secondsDifference+' Sec ';
    return timespent;

}
//Query.noConflict();
   $('.btn-group-sm a').click(function (event) {
    event.preventDefault();
    var txt = $(this).text();
    if (txt == 'Inspection Report')
    {
        var myModal = $('#model-issuewarrenty');
        var modalBody = myModal.find('.modal-body');
        modalBody.html('');
        modalBody.load($(this).parent().attr('data-remotee'));
    }
});
/*$('#carousel-main-img').carousel({
    interval: 8000
});
$('#carousel-thumb-img').carousel({
    pause: true,
    interval: false
});

// handles the carousel thumbnails
$('[id^=carousel-selector-]').click(function () {
    var id_selector = $(this).attr("id");
    var id = id_selector.substr(id_selector.length - 1);
    id = parseInt(id);
    $('#carousel-main-img').carousel(id);
    $('[id^=carousel-selector-]').removeClass('selected');
    $(this).addClass('selected');
});

// when the carousel slides, auto update
$('#carousel-main-img').on('slid', function (e) {
    var id = $('.item.active').data('slide-number');
    id = parseInt(id);
    $('[id^=carousel-selector-]').removeClass('selected');
    $('[id^=carousel-selector-' + id + ']').addClass('selected');
});
 */
$('#addshortlist').click(function () {
    $('#addshortlist>.fa-heart').toggleClass('fa-heart-fill');
});

var ucdnav = $('#ucdtabnav li a');
ucdnav.click(function () {
    ucdnav.toggleClass(' darkgray');
});


function forceAlphaNumeric(e){
	var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
  /*  var keyCode = event.keyCode || event.which
    // Don't validate the input if below arrow, delete and backspace keys were pressed 
    if (keyCode == 8 || (keyCode >= 35 && keyCode <= 40)) { // Left / Up / Right / Down Arrow, Backspace, Delete keys
        return;
    }
    
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }*/	
}