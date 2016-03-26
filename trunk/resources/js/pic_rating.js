/**
 * Created by felix on 26.03.16.
 */

$(function() {
    var rating_el = document.querySelector('.c-rating');
    var $rating_el = $('.c-rating'); // the rating jquery object

    var overall_rating = $rating_el.attr('data-overall-rating');
    var picId = $rating_el.attr('data-pic-id');

    var current_rating = 0;

    var max_rating = 5;

    var success = function (result) {
        var json = $.parseJSON(result);
        console.log(json);
    };

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
    if (null != overall_rating || overall_rating !== "") {
        my_rating.setRating(overall_rating, false);
    }
});