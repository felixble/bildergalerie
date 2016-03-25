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
        current_container_el = $('#_' + hash);
        current_container_el.addClass("active");
    }

    // hide all tab-containers
    $('.tab_container:not(.active)').hide();

    // set onclick handler for tab controls
    $('.tab-control').click(function(event) {
        // hide current container
        if (null !== current_container_el) {
            current_container_el.hide();
        }
        if (null !== active_tab) {
            active_tab.removeClass("active");
        }

        // show related container
        var related_container = $(this).attr('data-tab');
        // simple hack to prevent the default scroll event to the anchor: the real id of the selected tab starts with
        // an underline so there is no element with the id given in the url (hash)
        var related_container_el = $('#_' + related_container);
        related_container_el.show();

        active_tab = $(this).parent();
        active_tab.addClass("active");
        current_container_el = related_container_el;

        return true;
    });

});