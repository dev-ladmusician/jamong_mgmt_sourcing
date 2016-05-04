$(document).ready(function() {
    var windowHeight = $(window).height();
    var navHeight = $('header').outerHeight();
    var footerHeight = $('footer').outerHeight();
    $('.content-wrapper').css('min-height', windowHeight - navHeight - footerHeight);
});