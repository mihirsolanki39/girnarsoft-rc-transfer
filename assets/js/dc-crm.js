stickyOffset = $('.sticky').offset().top;
function stickyNav(){
   var scroll = $(window).scrollTop();
       if (scroll > stickyOffset){
           var getAddC = $('.sticky').hasClass('fixed');
           if(getAddC==false){
             $('.sticky').addClass('fixed');
           }
            $('.sidenav').css('margin-top','75px');
       }else{
           $('.sticky').removeClass('fixed');
           $('.sidenav').css('margin-top',0-scroll);
       }
}


$(document).ready(function(){
    $("#sidebar").stick_in_parent();
    $('.sidenav-a').click(function(){
        var setImgDiv = $(this).children('img');
        var setImg = setImgDiv.attr('src');
        if( setImg == 'images/plus.svg'){
            $(setImgDiv).attr('src','images/minus.svg');
            $('#sidebar').css('height','auto');
        }else{
           $(setImgDiv).attr('src','images/plus.svg');
           $('#sidebar').css('height','100%');
        }
        $(this).next().toggle();
    });
    $('.sub-down').click(function(){
        $(this).children('.img-type').toggleClass('img-after')
    });

});

$(window).scroll(function(){ 
  stickyNav();
});

$('body').on('blur','.crm-form',function(){
    var chkInpt = $('.crm-form').val().length;
    if(chkInpt == ""){
        $(this).parent().next().show();
    }
});
