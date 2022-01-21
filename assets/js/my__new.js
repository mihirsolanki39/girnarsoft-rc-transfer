//show another field on View more button	
$(document).ready(function() {
    
        // Menu Dropdown Menu
    $('ul.nav li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeIn(300);
        $(this).find('a.dropdown-toggle').css('border-bottom', '3px solid #e66437');
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeOut(300);
        $(this).find('a.dropdown-toggle').css('border-bottom', '3px solid #1e345f');
    });
    
    
    var k=$(".count").val();
   
    $(".click__more").click(function() {
        //alert(k);
        var html = $("#temp-div").html();
       // alert(html)
        html = html.replace(/COUNTER/g,k);
        $("#appendOnViewMore").append(html);

        k++;
        if (k >= 1) {
            $(".buttn-R0").show();
        }
    });



//check all
  $(".check__all").change(function(){
      if ($(this).prop('checked') == true){
        $(this).parent(".chkall_li").nextAll(".comm_cls").find(".chkdOnChkAll").prop("checked" , true);
        //$(this).parent(".chkall_li").nextAll(".comm_cls").find(".customize-form").removeAttr("readonly");
        $(this).parent(".chkall_li").nextAll(".comm_cls").find(".customize-form").prop("disabled",false);
         $(this).parent(".chkall_li").nextAll(".comm_cls").find(".customize-form").attr("required", true);
        $(this).parent(".chkall_li").nextAll(".comm_cls").find(".btnn__view").removeClass("display-n"); 
        $('.active_for_sms').attr('value','1');
        $('.active_for_email').attr('value','1');
      } else{
        $(this).parent(".chkall_li").nextAll(".comm_cls").find(".chkdOnChkAll").prop("checked" , false);
        //$(this).parent(".chkall_li").nextAll(".comm_cls").find(".customize-form").attr("readonly", true);
        $(this).parent(".chkall_li").nextAll(".comm_cls").find(".customize-form").prop("disabled",true);
         $(this).parent(".chkall_li").nextAll(".comm_cls").find(".customize-form").removeAttr("required");
        $(this).parent(".chkall_li").nextAll(".comm_cls").find(".btnn__view").addClass("display-n");  
        $('.active_for_sms').attr('value','0');
        $('.active_for_email').attr('value','0');
      }
  });
//check on sms
  $(".by__sms").change(function(){
      if ($(this).prop('checked') == true){
         //$(this).parent(".pad740").nextAll().find(".customize-form").removeAttr("readonly");
         $(this).parent(".pad740").nextAll().find(".customize-form").prop("disabled",false);
          $(this).parent(".pad740").nextAll().find(".customize-form").attr("required", true);
         $(this).parent(".pad740").siblings(".btnn__view").removeClass("display-n");
         $('.active_for_sms').attr('value','1');
      }else{
          $(this).parent(".pad740").nextAll().find(".customize-form").removeAttr("required");
          $(this).parent(".pad740").nextAll().find(".customize-form").prop("disabled",true);
         // $(this).parent(".pad740").nextAll().find(".customize-form").attr("readonly", true);
          $(this).parent(".pad740").siblings(".btnn__view").addClass("display-n");
          $('.active_for_sms').attr('value','0');
      }
  });
//check on email
  $(".by__email").change(function(){
      if ($(this).prop('checked') == true){
         //$(this).parent(".pad740").nextAll().find(".customize-form").removeAttr("readonly");
         $(this).parent(".pad740").nextAll().find(".customize-form").prop("disabled",false);
         $(this).parent(".pad740").nextAll().find(".customize-form").attr("required", true);
         $(this).parent(".pad740").siblings(".btnn__view").removeClass("display-n");
         $('.active_for_email').attr('value','1');
      }else{
           $(this).parent(".pad740").nextAll().find(".customize-form").removeAttr("required");
           $(this).parent(".pad740").nextAll().find(".customize-form").prop("disabled",true);
          //$(this).parent(".pad740").nextAll().find(".customize-form").attr("readonly", true);
          $(this).parent(".pad740").siblings(".btnn__view").addClass("display-n");
          $('.active_for_email').attr('value','0');
      }
  });
//check all chkbox true when all individual checked
    $('.chkdOnChkAll').change(function(){
        var tNoOfChkBox = $(this).parents("ul").find(".chkdOnChkAll").length;
        var nOfChkdChkBox = $(this).parents("ul").find(".chkdOnChkAll").filter(':checked').length;
        //alert(nOfChkdChkBox);
        if (tNoOfChkBox == nOfChkdChkBox){
            $(".check__all").prop("checked",true);
        }else{
            $(".check__all").prop("checked",false);
        }
    });
  
//append in sms section 
//    var i = 0;
//    $(".clickOnSms").click(function() {
//         $(".appendInSms").append('<div class="row appendToSms mrg-B15"><div class="col-md-3">&nbsp;</div><div class="col-md-3"><select id="" class="form-control customize-form" placeholder="Enter City"><option value="">Select User</option><option value="">Kunal</option><option value="">Mithilesh</option><option value="">Sumit</option><option value="">Ravindra</option><option value="">Danish</option><option value="">Other</option></select></div><div class="col-md-3"><input type="text" name="" id="" class="form-control customize-form" placeholder="Enter Mobile Number"></div><div class="btnn__view btn__hide" style="display:none;"><a href="javascript:void(0)" class="view__less" id="removeRowSms"><span class="pad-R5"><i class="fa fa-trash"></i></span>Remove</a></div></div>');
//
//        i++;
//        if (i >= 1) {
//            $(".btn__hide").show();
//        }
//    });
//
//    $(document).on("click", "#removeRowSms", function() {
//        $(".appendToSms").eq(-1).remove();
//        i--;
//        if (i == 0) {
//            $(".btn__hide").hide();
//        }
//
//    });
//    
//    
//    
//    //append in sms section btnn__view
//    var i = 0;
//    $(".clickOnEmail").click(function() {
//        $(".appendInEmail").append('<div class="row appendToEmail mrg-B15"><div class="col-md-3">&nbsp;</div><div class="col-md-3"><select id="" class="form-control customize-form" placeholder="Enter City"><option value="">Select User</option><option value="">Kunal</option><option value="">Mithilesh</option><option value="">Sumit</option><option value="">Ravindra</option><option value="">Danish</option><option value="">Other</option></select></div><div class="col-md-3"><input type="text" name="" id="" class="form-control customize-form" placeholder="Enter Email Address"></div><div class="btnn__view btn__hide" style="display:none;"><a href="javascript:void(0)" class="view__less" id="removeRowEmail"><span class="pad-R5"><i class="fa fa-trash"></i></span>Remove</a></div></div>');
//
//        i++;
//        if (i >= 1) {
//            $(".btn__hide").show();
//        }
//    });
//
//    $(document).on("click", "#removeRowEmail", function() {
//        $(".appendToEmail").eq(-1).remove();
//        i--;
//        if (i == 0) {
//            $(".btn__hide").hide();
//        }
//
//    });

});
    $('body').delegate('.view__less','click',function()  {

        $(this).parents('.appended__item').remove();

    });
String.prototype.replaceAll = function(searchStr, replaceStr) { 
    var str = this;

//escape regexp special characters in search string 
searchStr = searchStr.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'); 
return str.replace(new RegExp(searchStr, 'gi'), replaceStr); 
};




























