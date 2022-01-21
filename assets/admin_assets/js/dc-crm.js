
$(document).ready(function(){
    /*$('body').on('blur','input.crm-form',function(){
        if ($(this).val()==""){
         $(this).parent().next().show();
       }else{
          $(this).parent().next().hide(); 
       }

    });*/
    $('body').on('focus','.drop-form',function(){
       $(this).prev().find('.btn-drop').addClass('focus-bor');
    });
    $('body').on('blur','.drop-form',function(){
        $(this).prev().find('.btn-drop').removeClass('focus-bor');
    });
});

//SideNav
// stickyOffset = $('.sticky').offset().top;
stickyOffset = $('.sticky').offset();

function stickyNav(){
    var sideBarH = $('#sidebar').height();
    var scroll = $(window).scrollTop();
    var getWinH = $(window).height();
    var getNavH = $('nav').height();
    var getStickyH = $('.all_details').outerHeight();
    var fooOffTop = $('footer').offset().top;
    
    var TotalLeftH = sideBarH+getNavH+getStickyH;
    var scrollRightPx = getWinH+scroll;
    
   if (scroll > stickyOffset){
       var getAddC = $('.sticky').hasClass('fixed');
       if(getAddC==false){
           $('.sticky').addClass('fixed');
           $('.col-crm-right').css('margin-top',75);
           $('.col-crm-left').css('margin-top',75);
       }
       var getMarT = $('.col-crm-left').css('margin-top');
        var getscrH = TotalLeftH-getWinH;


        if(scroll>getscrH){    // && scroll>getNavH
            
            if(getscrH>getNavH){
                $('#sidebar').css({'position':'fixed','top':-(getscrH-getStickyH), 'height':sideBarH});
            } else {
                $('#sidebar').css({'position':'fixed','top':0, 'height':sideBarH});
            }
            //return false;
        }
   }else{
       $('.sticky').removeClass('fixed');
       $('.sidenav').removeAttr('style');
       $('.col-crm-right').removeAttr('style');
   }
    
    var rightBH = $('.col-crm-right').outerHeight();
    if(scroll-190>rightBH-getWinH){
        console.log(scroll+'=='+(rightBH-getWinH));
        $('#sidebar').css({'position':'fixed','top':-(scroll-(rightBH-getWinH)-210)});
    }
    
}
$(window).scroll(function(){ 
    stickyNav();
});


//Toggle Image 
$(document).ready(function(){
    $('.sidenav-a').click(function(){
        var setImgDiv = $(this).children('img');
        var setImg = setImgDiv.attr('src');
        if( setImg == base_url+'assets/admin_assets/images/plus.svg'){
            $(setImgDiv).attr('src', base_url+'assets/admin_assets/images/minus.svg');
            //alert($('#sidebar').height());
            $('#sidebar').css('height',$('#sidebar').height()+$('.case-info-sublist').height());
        }else{
           $(setImgDiv).attr('src',base_url+'assets/admin_assets/images/plus.svg');
           $('#sidebar').css('height','auto');
        }
        $(this).next().toggle();
    });
    $('.sub-down').click(function(){
        $(this).children('.img-type').toggleClass('img-after')
    });

});