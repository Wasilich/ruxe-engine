//
// This is The Scripts used for Ruxe-Engine Theme
//

function main() {

(function () {
   'use strict';
   
    /***** Show Menu on top *****/
    $(window).bind('scroll', function() {
        var navHeight = $(window).height() - 150;
        if ($(window).scrollTop() > navHeight) {
            $('.navbar-default').addClass('on');
        } else {
            $('.navbar-default').removeClass('on');
        }
    });
    /***** Widest menu *****/
            $('body').scrollspy({ 
        target: '.navbar-default',
        offset: 80
    });

}());
}
main();