/**
 * Created by Felix on 16.12.2015.
 */

$(document).ready(function () {

    navFixedOnScroll();
    selectCurrentMenuItem();

});

function navFixedOnScroll() {
    var menu = $('#nav');
    var origOffsetY = menu.offset().top;

    function scroll() {
        if ($(window).scrollTop() >= origOffsetY) {
            $('#nav').addClass('navbar-fixed-top');
        } else {
            $('#nav').removeClass('navbar-fixed-top');
        }


    }

    document.onscroll = scroll;
}

function selectCurrentMenuItem() {
    var path = window.location.pathname;

    var itemActivated = false;
    $(".auto_activate").each(function() {
        var index = path.indexOf($(this).attr('id'));
        if (index > -1) { // url contains item id
            $(this).addClass("active");
            itemActivated = true;
            return false; // breaks the each-loop
        }
    });

    if (!itemActivated) {
        $("#home").addClass("active");
    }
}