$(document).ready(function(){
              $("#mobile").keypress(function (e) {
		//if the letter is not digit then display error and don't type anything
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		 return false;
		}
	});
var resend_otp_attempt = 0;

    $('.resendbtn').click(function () {
        resend_otp_attempt++;
        if (resend_otp_attempt > 2) {
            alert("Can't resend OTP, Please contact admin!");
            return false;
        }
        var data = $('#sign_in_otp').serialize();
        ajax_get_otp(data);

    });
                  
                 function repeat() {
                       $(".animationImage").css({"left":'-100px'}).show();        
         
                       $(".animationImage").animate({left:'+=1000px'},4000);
         
                       $('.animationImage').delay(500).fadeOut(1000,repeat);
                   }
         
                repeat();    
             
           //otp box
            $(".otp-in").keyup(function () {
               var value = $(this).val().length;
               if (value == 1) {
                  $(this).next().focus();
               }
            });
           $(".otp-in").keyup(function (event) {
               if(event.which == 8){
                  var value = $(this).val().length;
                  if(value < 1){
                      $(this).prev().focus();
                      $(this).removeClass("bg-none");
                  }
               }
           });
           $(".otp-in").focus(function (){
               $(this).addClass("bg-none");
           });
           //show and hide otp box
          /* $(".GetOtpBtn").click(function(){
               $(this).hide();
               $(this).parent().next().removeClass("hideon");
               $(".invalid-user").removeClass("hideon");
           });*/
           $('.inv-mob').click(function(){
               $(this).hide();
               $(this).parent().next().next(".otp-sec").addClass('hideon');
               $(this).parent().next().children().show();
           });
            
           // 
             
           $('#sign_inBtn').click(function(){
               $('#sign_in').show();
               $('#sign_in_otp').hide();
               $('#sign_in_otpBtn').removeClass("active");
               $(this).addClass("active");
           });
         
           $('#sign_in_otpBtn').click(function(){
               $('#sign_in').hide();
               $('#sign_in_otp').show();
               $('#sign_inBtn').removeClass("active");
               $(this).addClass("active");
           });
             
           $('.navbar-nav li').click(function(){
               $('.navbar-nav li').removeClass("active");
               $(this).addClass("active");
           });
             
             
             $("#forgotpass").click(function () {
            $('#sign_in').hide();
            $('#sign_Up').hide();
            $('#sign_in_otpBtn').hide();
            $('#sign_inBtn').hide();

            $('.showHide').attr('style', 'display:none;');
            $('#forgotpasword').show();
            $('#sign_in_otpBtn').removeClass("active");
            $('#sign_inBtn').removeClass("active");
        }); 

             
         });
             
            $(function(){
               function onScrollInit( items, trigger ) {
                   items.each( function() {
                   var osElement = $(this),
                       osAnimationClass = osElement.attr('data-os-animation'),
                       osAnimationDelay = osElement.attr('data-os-animation-delay');
                     
                       osElement.css({
                           '-webkit-animation-delay':  osAnimationDelay,
                           '-moz-animation-delay':     osAnimationDelay,
                           'animation-delay':          osAnimationDelay
                       });
         
                       var osTrigger = ( trigger ) ? trigger : osElement;
                       
                       osTrigger.waypoint(function() {
                           osElement.addClass('animated').addClass(osAnimationClass);
                           },{
                               triggerOnce: true,
                               offset: '90%'
                       });
                   });
               }
         
               onScrollInit( $('.os-animation') );
               onScrollInit( $('.staggered-animation'), $('.staggered-animation-container') );
         });//]]> 
         
         
         
         function ajax_get_otp(data)
        {
            var mobile = $('#mobile').val();
            $('#small-loader').show();
            $.ajax({
                type: "POST",
                url:  "login/ajaxOtp",
                data: {mobile:mobile,apikey:'U3KqyrewdMuCotTS'},
               jsonp: "callback",
                        // tell jQuery we're expecting JSONP
                dataType: "jsonp",
                success: function (r, s) {
                    
                    $('#otp').prop('value', '');
                    $('.valid-otp').text('');

                    if (r.status === 'F')
                    {
                        $('#small-loader').hide();
                        $(this).hide();
                        $(".otp-sec").addClass("hideon");
                        $("#otp-login").removeAttr("style");
                        $('.otp-sec').hide();
                        $(this).parent().next().addClass("hideon");
                        alert(r.error);
                        return false;
                    } else {
                        $('#small-loader').hide();
                        $(this).hide();
                        $('#otp-verify').css('display','block');
                        $(".otp-sec").removeClass("hideon");
                        $(".otp-sec").removeAttr("style");
                        $("#inv-otp").removeAttr("style");
                        $(".GetOtpBtn").hide();
                        $("#inv-otp").removeClass("hideon");
                        $(this).parent().next().removeClass("hideon");
                        $('.valid-otp').text('');
                         $('.otp-box').find('input:text').val(''); 
                    }
                }
            });
        }
        
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        $(".otp-in").keyup(function (event) {
            if (event.which == 8) {
                var value = $(this).val().length;
                if (value < 1) {
                    $(this).prev().focus();
                    $(this).removeClass("bg-none");
                }
            }
        });
        
        function verticalCenterBlk() {
            $('section').css({'height': $('.mysection').innerHeight()})
        }
        $(window).load(function () {
            verticalCenterBlk();
        });
        $(window).resize(function () {
            verticalCenterBlk();
        });
       /* $('#otp-process-send').click(function () {
                var otp = $('.otp-in').val();
                if (otp == '') {
                    alert("Please Enter OTP");
                    $('#otp').focus();
                    return false;
                }
                var mobile = $('#mobile').val();
                $('#mob').attr('value', mobile);
    
    
    
        });*/