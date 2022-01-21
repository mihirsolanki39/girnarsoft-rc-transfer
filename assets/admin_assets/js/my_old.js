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




  $(function () {
   // var top = 280; 
   var upperHeight = 250;//$("header").height() + $(".mainnav").height() + $(".tophead") .height() +150;
   //var navHeight = $(".mainnav").height();
   
     
		if ($(window).width() > 991) {
			$(window).scroll(function () { 
			
        if (upperHeight <= $(window).scrollTop()) {
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

  $(function () {
   // var top = 280; 
   var upperHeight = $("header").height() + $(".mainnav").height() + $(".tophead") .height();
   var navtHeight = upperHeight + 50;
   
     $(window).scroll(function () {
		if ($(window).width() > 991) {
        if (navtHeight <= $(window).scrollTop()) {           
			$('#checkactionbar').addClass('checkactionbarfix  ');
			//alert("fixed");
			
        } else {
            // otherwise remove it
            $('#checkactionbar').removeClass('checkactionbarfix');
        }
		 } else {
			  $('#checkactionbar').removeClass('checkactionbarfix');
		}
    })
	   
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
    var chboxs = document.getElementsByName("simchack");
    var vis = "none";
    for(var i=0;i<chboxs.length;i++) { 
        if(chboxs[i].checked){
         vis = "block";
            break;
        }
    }
    document.getElementById(box).style.display = vis;
}


$(document).ready(function(){
	// Menu Dropdown Menu
	$('ul.nav li.dropdown').hover(function() {
	  $(this).find('.dropdown-menu').stop(false, false).delay(300).fadeIn(300);
	  $(this).find('a.dropdown-toggle').css('border-bottom','3px solid #e66437');
	}, function() {
	  $(this).find('.dropdown-menu').stop(false, false).delay(300).fadeOut(300);
	   $(this).find('a.dropdown-toggle').css('border-bottom','3px solid #1e345f');
	});  
	
	/*// Insurance Radio Button
	$('#Comprehensive,#thirdParty').click(function(){
		$('.year-field').show();
	});
	$('#NoInsurance').click(function(){
		$('.year-field').hide();
	})*/
	
	
	
	
});


		$(function () {
			var closediv = $(".multi-dropdwn" ).next(" .dropdown-menu");
			$(".multi-dropdwn").click( function(e){				
				$(this ).next(" .dropdown-menu").toggle();					
				})			
				$(document).mouseup(function(e) {
					if (closediv.has(e.target).length == 0) {
				closediv.hide();
				}
				})
			});
	  
	


