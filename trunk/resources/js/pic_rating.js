/**
 * Created by felix on 26.03.16.
 */

$(function() {
    var rating_el = document.querySelector('.c-rating');

    var overall_rating = $('.c-rating').attr('data-overall-rating');

    var current_rating = 0;

    var max_rating = 5;

    var callback = function(rating) {
        alert(rating);
    };

    var my_rating = rating(rating_el, current_rating, max_rating, callback);
    if (null != overall_rating || overall_rating !== "") {
        my_rating.setRating(overall_rating, false);
    }
});