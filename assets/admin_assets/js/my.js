$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});

$('.editretail, .editdealer').click(function () {
	$(this).parent(".retailprice, .dealerprice").hide();
	$(this).parent().next(".edit-retailprice, .edit-dealerprice").show();	
});
$('#saveretail, #cancelretail, #savedealer, #canceldealer').click(function () {
	$(this).parent().parent().parent().prev(".retailprice, .dealerprice").show();
	$(this) .closest(".edit-retailprice, .edit-dealerprice").hide();	
});

$('#filterbtn').click(function () {
	$("#search-wraper").slideToggle();
});




 /* $(function () {
   // var top = 280; 
   var upperHeight = $("header").height() + $(".mainnav").height() + $(".tophead") .height();
   //var navHeight = $(".mainnav").height();
   
     $(window).scroll(function () {
		if ($(window).width() > 991) {
        if (upperHeight <= $(window).scrollTop()) {
            // if so, add the fixed class
            $('#search-wraper').addClass('searchfixed  fade in shadow');
			//alert("fixed");
			
        } else {
            // otherwise remove it
            $('#search-wraper').removeClass('searchfixed fade in shadow');
        }
		 } else {
			  $('#search-wraper').removeClass('searchfixed fade in shadow');
		}
    })
	   
});
*/
 $(function () {
   // var top = 280; 
   jQuery.upperHeight =400;//$("header").height() + $(".mainnav").height() + $(".tophead") .height() +150;
   //var navHeight = $(".mainnav").height();
   //alert($('#type span .badge').text());
     
		if ($(window).width() > 991) {
			$(window).scroll(function () { 
			//alert($(window).scrollTop());
        if (jQuery.upperHeight <= $(window).scrollTop()) {
var tabtype=$('#type').val();
var tabtypecount=$("#"+tabtype+"new").text();
//alert(tabtypecount)
		if(parseInt(tabtypecount)==5){
		jQuery.upperHeight = 490;
		}
		else{
			jQuery.upperHeight = 400;

			}

	//if($(window).scrollTop() == ($(document).height() - $(window).height())){
            // if so, add the fixed class
            $('#search-wraper').addClass('searchfixed ');
			//alert("fixed");
			
        } else {
            // otherwise remove it
            $('#search-wraper').removeClass('searchfixed ');
        }
			
    })
		}
});

function showMe (box) 
    {
    if($('input[type="checkbox"][name="checkcar"]').is(":checked"))   
        $("#checkactionbar").show().addClass("checkbarfixed fade in ");
    else
       $("#checkactionbar").hide().removeClass('checkbarfixed fade in ');
}
/*
// Dealer Support
$('#support').hover(function(){
	$('.support-detail').show();
	});
	
	$('.support-detail').mouseleave(function(){
	$(this).hide();
});*/


	// advance search
	$('.advanced-search-btn').click(function(){
		//alert('sdfsdf');
		$('.advance-search,.down,.up').toggle();
	});



	//Add Enquiry Row Append
	var i=0;
	$('.add-More-row').click(function(){
		
	$(".row-append").append("<div class='row mrg-all-0 mrg-B0 mrg-T0 appended-div'><div class='col-md-4'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Select Make:</label><select class='form-control search-form-select-box' placeholder='Select Make '><option>Select</option><option>Select</option></select></div></div><div class='col-md-4'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Select Model:</label><select class='form-control search-form-select-box' placeholder='Select Model'><option>Select Model</option><option>Select Model</option><option>Select Model</option></select></div></div><div class='col-md-4'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Fuel Type: </label><select class='form-control search-form-select-box' placeholder='Fuel Type'><option>Petrol</option><option>Diesel</option><option>CNG</option></select></div></div><div class='clearfix'></div><hr class='mrg-T10 mrg-B0'></div>");
	i++;
	if(i>=1)
	{
		$('.remove-append').show();
	}
	
	});
	
	$('.remove-append').click(function(){
		$(".appended-div").eq(-1).remove();
		i--;
		if(i==0)
	{
		$('.remove-append').hide();
	}
	});
	//Add Enquiry Row Append END
	
	// List on Dealer Inventory Platformpp
	$('#list-on-DP').click(function() {
		$('.dealer-inv-plateform').show();
        
    });
	
	var j=0;
	$('.add-More-row2').click(function(){
		
	$(".row-append2").append("<div class='row mrg-all-0 mrg-B0 mrg-T0 appended-div2'><div class='col-md-6'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Select Make:</label><select class='form-control search-form-select-box' placeholder='Select Make '><option>Select</option><option>Select</option></select></div></div><div class='col-md-6'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Select Model:</label><select class='form-control search-form-select-box' placeholder='Select Model'><option>Select Model</option><option>Select Model</option><option>Select Model</option></select></div></div><div class='clearfix'></div><hr class='mrg-T10 mrg-B0'></div>");
	j++;
	if(j>=1)
	{
		$('.remove-append2').show();
	}
	
	});
	
	$('.remove-append2').click(function(){
		$(".appended-div2").eq(-1).remove();
		j--;
		if(j==0)
	{
		$('.remove-append2').hide();
	}
	});
	//Add Enquiry Row Append END
	
	//Add Enquiry Row Append
	var i=0;
	$('.add-More-row3').click(function(){
		
	$(".row-append3").append("<div class='row mrg-all-0 mrg-B0 mrg-T0 appended-div3'><div class='col-md-4'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Select Make:</label><select class='form-control search-form-select-box' placeholder='Select Make '><option>Select</option><option>Select</option></select></div></div><div class='col-md-4'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Select Model:</label><select class='form-control search-form-select-box' placeholder='Select Model'><option>Select Model</option><option>Select Model</option><option>Select Model</option></select></div></div> <div class='col-md-4'><div class='form-group text-left'><label class='control-label search-form-label' for='inputSuccess2'>Fuel Type:</label><select class='form-control search-form-select-box' placeholder='Select Model'><option>Petrol</option><option>CNG</option><option>Diesel</option></select></div></div><div class='clearfix'></div><hr class='mrg-T10 mrg-B0'></div>");
	i++;
	if(i>=1)
	{
		$('.remove-append3').show();
	}
	
	});
	
	$('.remove-append3').click(function(){
		$(".appended-div3").eq(-1).remove();
		i--;
		if(i==0)
	{
		$('.remove-append3').hide();
	}
	});
	//Add Enquiry Row Append END
	
	// List on Dealer Inventory Platformpp
	$('#list-on-DP').click(function() {
		$('.dealer-inv-plateform').show();
        
    });
	
	function showActionbar (box) {
    //var chboxs = document.getElementsByName("simchack");
	var chboxs = document.getElementsByClassName("simchack");
	//alert(chboxs);
    var vis = "none";
    for(var i=0;i<chboxs.length;i++) { 
        if(chboxs[i].checked){
         vis = "block";
            break;
        }
    }
    document.getElementById(box).style.display = vis;
}

// Menu Dropdown Menu
$(document).ready(function(){
	$('ul.nav li.dropdown').hover(function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeIn(300);
	  $(this).find('a').css('background','transparent');
	}, function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeOut(300);
	   $(this).find('a').css('background','transparent');
	});  
	// Calender Dropdown
	$('.xdsoft_calendar').click(function() {
		$('.xdsoft_datetimepicker').hide();
	});
});




// Add Dealership Form

$(document).ready(function(){
    $('#Website').click(function(){
        if(this.checked)
            $('#web_box').fadeIn();
        else
            $('#web_box').fadeOut();
    });
	
	/*$('#Classified').click(function(){
        if(this.checked)
            $('#classified_box').fadeIn();
        else
            $('#classified_box').fadeOut();
    });
	
	$('#Warranty').click(function(){
        if(this.checked)
            $('#Warranty_box').fadeIn();
        else
            $('#Warranty_box').fadeOut();
    });
	
	$('#SellerPackage').click(function(){
        if(this.checked)
            $('#Seller_box').fadeIn();
        else
            $('#Seller_box').fadeOut();
    });*/
	
	$('#FeaturedGaadi').click(function(){
        if(this.checked)
            $('#FeatureGaadi_box').fadeIn();
        else
            $('#FeatureGaadi_box').fadeOut();
    });
	
	$('#FeaturedCardekho').click(function(){
        if(this.checked)
            $('#FeatureCardekho_box').fadeIn();
        else
            $('#FeatureCardekho_box').fadeOut();
    });
	
});

/* Progress Bar Change */
$('.step_nxt').click(function () {
	$('.progressbar li.active').next().addClass('active');
	if ($('#progress')) {};
});

$('.steppckge_prev').click(function () {
	$('.progressbar li.active').next().removeClass('active');
	if ($('#progress')) {};
});

$('.stepcntct_prev').click(function () {
	$('.progressbar li:last.active').removeClass('active');
	if ($('#progress')) {};
});


/*$('#delrshp_nxt').click(function () {
	$('#dealer_details').fadeOut();
	$('#package_details').fadeIn();
	
	$('#pckge2').removeAttr('disabled');
	//$('#cntct3').removeAttr('disabled')
	
	
	
});*/

$('#pckge_prev').click(function () {
	$('#package_details').fadeOut();
	$('#dealer_details').fadeIn();
});

/*$('#pckge_nxt').click(function () {
	$('#package_details').fadeOut();
	$('#contact_details').fadeIn();
});*/

$('#cntct_prev').click(function () {
	$('#package_details').fadeIn();
	$('#contact_details').fadeOut();
	
});
//start for edit vikas
/*$('#delrshp_nxtddd').click(function () {
//alert('aaa');
	$('#dealer_details').fadeOut();
	$('#package_details').fadeIn();
	$('.step').removeClass('active');
	$('#delrshp_nxtdd').addClass('active');
	
});*/

$('#pckge_prevdd').click(function () {
	$('#package_details').fadeOut();
	$('#dealer_details').fadeIn();
	$('.step').removeClass('active');
	$('#dlrshp1dd').addClass('active');
});

/*$('#pckge_nxtddd').click(function () {
//alert('asssd');
	$('#package_details').fadeOut();
	$('#contact_details').fadeIn();
	$('.step').removeClass('active');
	$('#pckge_nxtdd').addClass('active');
});*/

$('#cntct_prevdd').click(function () {
	$('#package_details').fadeIn();
	$('#contact_details').fadeOut();
	$('.step').removeClass('active');
	$('#delrshp_nxtdd').addClass('active');
	
});

/*$('#delrshp_nxtdd').click(function () {
	//alert('a');
	$('#contact_details').fadeOut();
	$('#dealer_details').fadeOut();
	$('#package_details').fadeIn();
	$('.step').removeClass('active');
	//$('#delrshp_nxtdd').next().addClass('active');
	$('#delrshp_nxtdd').addClass('active');
});*/
/*$('#pckge_nxtdd').click(function () {
	$('#dealer_details').fadeOut();
	$('#package_details').fadeOut();
	$('#contact_details').fadeIn();
	$('.step').removeClass('active');
	//$('#pckge_nxtdd').next().addClass('active');
	$('#pckge_nxtdd').addClass('active');
});*/
$('#dlrshp1dd').click(function () {
	$('#contact_details').fadeOut();
	$('#package_details').fadeOut();
	$('#dealer_details').fadeIn();
	
	$('.step').removeClass('active');
	//$('.progressbar li.active').next().removeClass('active');
	$('#dlrshp1dd').addClass('active');
});

// end for edit vikas

$('#dlrshp1').click(function () {
	$('#package_details').fadeOut();
	$('#contact_details').fadeOut();
	$('#dealer_details').fadeIn();
	
	$('.step').removeClass('active');
	//$('.progressbar li.active').next().removeClass('active');
	$('#dlrshp1').addClass('active');
});

/*$('#pckge2').click(function () {
	$('#contact_details').fadeOut();
	$('#dealer_details').fadeOut();
	$('#package_details').fadeIn();

	
	

	$('.progressbar li:last.active').removeClass('active');
});*/

function snakbarAlert(mesage) {
    $('#snakbarAlert').html(mesage);
    $('#snakbarAlert').addClass('show');
    setTimeout(function(){  $('#snakbarAlert').removeClass('show'); }, 2000);
}
