/**
 * Created by felix on 20.03.16.
 */

$(function() {

    var hash = window.location.hash.substring(1);
    var active_tab = $('.tab-item.active');
    var current_container_el = $('.tab_container.active');

    if (hash !== "") {
        active_tab.removeClass("active");
        active_tab = $('#tab_' + hash);
        active_tab.addClass("active");

        current_container_el.removeClass("active");
        current_container_el = $('#' + hash);
        current_container_el.addClass("active");
    }
    console.log(current_container_el);

    // hide all tab-containers
    $('.tab_container:not(.active)').hide();

    // set onclick handler for tab controls
    $('.tab-control').click(function() {

        console.log("click");
        console.log(current_container_el);

        // hide current container
        if (null !== current_container_el) {
            current_container_el.hide();
        }
        if (null !== active_tab) {
            active_tab.removeClass("active");
        }

        // show related container
        var related_container = $(this).attr('data-tab');
        var related_container_el = $('#' + related_container);
        related_container_el.show();

        active_tab = $(this).parent();
        active_tab.addClass("active");
        current_container_el = related_container_el;

        console.log("next");
        console.log(current_container_el);

        return true;
    });

});