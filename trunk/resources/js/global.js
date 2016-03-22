/**
 * Created by Felix on 16.12.2015.
 */

$(document).ready(function () {
    // this will be executed when the document is ready

    navFixedOnScroll();
    selectCurrentMenuItem();
    autoScrollToId();
    confirmationOnClick();

});

function autoScrollToId() {
    var scrollToEl = $('.scrollTo').first();

    if (null == scrollToEl.offset()) return;
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
        var currentId = $(this).attr('id').substr(4); // remove the nav_-prefix
        console.log(currentId);
        var index = path.indexOf(currentId);

        if (index > -1) { // url contains item id
            var skip = false;
            // only-on-index special case
            if ($(this).hasClass("only-on-index")) {
                var remainingPath = path.substr(index + currentId.length);
                skip = !(remainingPath == "" || remainingPath == "/" || remainingPath.indexOf("index") > -1);
            }

            if (!skip) {
                $(this).addClass("active");
                itemActivated = true;
                //return false; // breaks the each-loop
            }
        }
    });

    if (!itemActivated) {
        // we found no matching menu item, so we select the home item
        $("#nav_home").addClass("active");
    }
}

/**
 * Add onclick-handler for all elements
 * requiring a confirmation dialog
 */
function confirmationOnClick() {
    $('.confirmation').click(function() {
        var msg = ($(this).attr('data-confirmation-text')) ? $(this).attr('data-confirmation-text') : "Möchten Sie diese Aktion wirklich ausführen?";

        return confirm(msg);
    });
}