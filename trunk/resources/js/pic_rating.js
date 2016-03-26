/**
 * Created by felix on 26.03.16.
 */

$(function() {
    var rating_el = document.querySelector('.c-rating');
    var $rating_el = $('.c-rating'); // the rating jquery object

    var rating_info_el = $('#rating_info');

    var picId = $rating_el.attr('data-pic-id');

    var current_rating = 0;

    var max_rating = 5;

    var callback = function(rating) {
        dataObj = { picId: picId, value: rating };

        $.ajax({
            type: "get",
            url: "ajax/rate",
            data: dataObj,
            success: success
        });
    };

    var my_rating = rating(rating_el, current_rating, max_rating, callback);


    var updateRatingView = function(overall_rating, my_rating_value) {
        var rating_info_text = "Bisher wurden noch keine Bewertungen abgegeben";
        if (overall_rating !== "") {
            my_rating.setRating(overall_rating, false);
            rating_info_text = "Gesamtbewertung: " + overall_rating;
            if (my_rating_value !== "") {
                rating_info_text += " / Ihre Bewertung: " + my_rating_value;
            }
            rating_info_el.find('#overall_rating').html(overall_rating);
        }

        $('#rating_title').attr('title', rating_info_text);

    };


    var success = function (result) {
        var json = $.parseJSON(result);
        var msg_el = $('#rating_msg');

        if (json.status === "OK") {
            updateRatingView(json.overall_rating, json.value);
            msg_el.removeClass("alert-danger");
            msg_el.addClass("alert-success");
            var txt = (json.update) ? "Ihre Bewertung wurde aktualisiert." : "Ihre Bewertung wurde gespeichert.";
            msg_el.html("Vielen Dank! " + txt);
        } else {
            msg_el.addClass("alert-danger");
            msg_el.removeClass("alert-success");
            msg_el.html("Ihre Bewertung konnte leider nicht gespeichert werden.");
            console.log(json);
        }

        msg_el.fadeIn();
        setTimeout(function () {
            msg_el.fadeOut();
        }, 2500);
    };


    updateRatingView($rating_el.attr('data-overall-rating'), $rating_el.attr('data-my-rating'));

});