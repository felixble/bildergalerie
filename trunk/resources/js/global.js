/**
 * Created by Felix on 16.12.2015.
 */

$(document).ready(function () {
    // this will be executed when the document is ready

    navFixedOnScroll();
    selectCurrentMenuItem();
    autoScrollToId();

});

function autoScrollToId() {
    var scrollToEl = $('.scrollTo').first();
    if (null == scrollToEl) return;
    $('html, body').animate({
        scrollTop: scrollToEl.offset().top
    }, 1000);
}

/**
 * Pins the navigation bar on the top of the
 * page if the header is not in view anymore.
 */
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

/**
 * Selects the current menu item calculated
 * by the current url.
 */
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
        // we found no matching menu item, so we select the home item
        $("#home").addClass("active");
    }
}