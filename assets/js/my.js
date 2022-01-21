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
	  $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeIn(300);
	  $(this).find('a.dropdown-toggle').css('border-bottom','3px solid #e66437');
	}, function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeOut(300);
	   $(this).find('a.dropdown-toggle').css('border-bottom','3px solid #1e345f');
	});  
	
	// Insurance Radio Button
	$('#Comprehensive,#thirdParty').click(function(){
		$('.year-field').show();
	});
	$('#NoInsurance').click(function(){
		$('.year-field').hide();
	})
	
	
	
	
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
//kunal	  
//TAB6
 $(document).ready(function(){
        
         $(".C-hide10").click(function(){
         $(".hide-T10").hide();
         });
         $(".C-hide11").click(function(){
         $(".hide-T11").hide();
         });
  });
//HIDE PANEL
$(document).ready(function(){

	 //PAKAGE PANEL HIDE
			 $(".P-hide").click(function(){
				 $(this).parents(".hide-TP").remove();
			 });
			  //SKU PANEL HIDE
			 $(".S-hide").click(function(){
				 $(this).parents(".hide-TS").remove();
			 });
			 //SERVICE PANEL HIDE
			 

 
	 //Timepicker bootstrap
	   $('.time').timepicker({ });
	 //Datepicker bootstrap
	   $('#dp3').datepicker();$('#dp4').datepicker();$('#dp5').datepicker(); $('#dp6').datepicker();$('#dp7').datepicker(); $('#dp8').datepicker(); $('#dp9').datepicker();
       $('#dp10').datepicker(); $('#dp11').datepicker(); $('#dp12').datepicker(); $('#dp13').datepicker(); $('#dp14').datepicker(); $('#dp15').datepicker();
       $('#dp16').datepicker(); $('#dp17').datepicker(); $('#dp18').datepicker();$('#dp19').datepicker(); $('#dp20').datepicker(); $('#dp21').datepicker();
	   $('#dp22').datepicker();$('#dp23').datepicker();$('#dp24').datepicker(); $('#dp25').datepicker();$('#dp26').datepicker(); $('#dp27').datepicker();
       $('#dp28').datepicker();$('#dp29').datepicker();$('#dp30').datepicker(); $('#dp31').datepicker(); $('#dp32').datepicker();$('#dp33').datepicker();
       $('#dp34').datepicker();$('#dp35').datepicker();$('#dp36').datepicker(); $('#dp37').datepicker();$('#dp38').datepicker();$('#dp39').datepicker();
       $('#dp40').datepicker(); $('#dp41').datepicker();$('#dp42').datepicker();$('#dp43').datepicker();$('#dp44').datepicker();$('#dp45').datepicker();
       $('#dp46').datepicker(); $('#dp47').datepicker();$('#dp48').datepicker(); $('#dp49').datepicker(); $('#dp50').datepicker();$('#dp51').datepicker();
       $('#dp52').datepicker();$('#dp53').datepicker();$('#dp54').datepicker();
});
      //show another field on View more button	
$(document).ready(function(){
	var i=0;
              $("#addMore").click(function(){
				 //alert("hi"); 
				  
			$("#append-on-view-more").append('<li class="Otiming-li"><div class="row"><div class="col-lg-3 col-md-3 col-sm-6 width22p"><div class="form-group mrg-B29"><label for="" class="customize-label show-on-mobile-screen">Virtual Number</label> <input type="text" class="form-control customize-form" id="" value="9090909090" placeholder="Enter Virtual Number"></div></div><div class="col-lg-3 col-md-3 col-sm-6 width22p"><div class="form-group mrg-B29"><label for="Outlettype" class="customize-label show-on-mobile-screen">Map to *</label><div class="padTR0a"><span class="radio1 radio2"><input type="radio" name="name8" id="defaultc" class="custom-radio" value="default-b" ><label for="defaultc"><span class="mrg-R10"></span>Default No.</label></span><span class="radio1 radio2"><input type="radio" name="name8" id="empc" class="custom-radio" value="emp-b" checked><label for="empc"><span class="mrg-R10"></span>Employee</label></span></div></div></div><div class="col-lg-3 col-md-3 col-sm-6 width22p"> <div class="form-group mrg-B29"><label for="" class="customize-label show-on-mobile-screen">Select Employee*</label> <select id="" class="form-control customize-form" placeholder=""><option value="">Select</option><option value="">0</option><option value="">1</option><option value="">2</option><option value="">3</option></select></div></div><div class="col-lg-3 col-md-3 col-sm-6 width22p"><div class="form-group mrg-B29"><label for="" class="customize-label show-on-mobile-screen">Contact No*</label><div class="input-group"><span class="input-group-addon inupt-group-addon-customize">+91</span><input type="text" name="" id="" class="form-control customize-form" value="" placeholder="Enter Contact No."></div></div></div><div class="buttn buttn-R" style="display:none;"><a href="javascript:void(0)" class="view-less" id="remove-row"><span class="pad-R5"><i class="fa fa-trash"></i></span>Remove</a></div></div></li>');
			
	       i++;
	        if(i>=1)
	          {
		        $(".buttn-R").show();
	          }
	});
	
	     $(document).on("click", ".view-less", function(){
		   //alert('hi');
		     $(".Otiming-li").eq(-1).remove();
		       i--;
		        if(i==0)
	               {
		            $(".buttn-R").hide();
	               }					   
												   
      });  


           //custom slider text toogle 
                 $("body").on("change",".customCheck",function(){
                     if ($(this).prop('checked')== true){
                         $(this).parents('li.li-switch').find('span.open1').text('Open');
                     }else {
                         $(this).parents('li.li-switch').find('span.open1').text('Close'); 
                     }
                 });
                  $("body").on("change",".customCheck1",function(){
                     if ($(this).prop('checked')== true){
                         $(this).parents('li.li-switch').find('span.open2').text('Open');
                     }else {
                         $(this).parents('li.li-switch').find('span.open2').text('Weekly Off'); 
                     }
                 });



});

function Permission(id) {
    window.open("/user/advance/permissions/view.php?userId=" + id, '_blank');
}


              
         
         






