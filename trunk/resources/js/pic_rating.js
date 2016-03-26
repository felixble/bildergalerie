/**
 * Created by felix on 26.03.16.
 */

$(function() {
    var rating_el = document.querySelector('.c-rating');

    var current_rating = 0;

    var max_rating = 5;

    var callback = function(rating) {
        alert(rating);
    };

    var my_rating = rating(rating_el, current_rating, max_rating, callback);
});