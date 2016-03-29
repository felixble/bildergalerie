/**
 * Created by felix on 29.03.16.
 */

$(function() {
    var id = -1;
    var select_el;

    function setExhibitionError(hasError) {
        var form_group = $('#form-group-exhibition');
        var msg = form_group.attr('data-error');
        var errorDiv = form_group.find('.help-block');
        if (hasError) {
            errorDiv.html(msg);
            // simple hack because addClass('has-error') does not work...
            errorDiv.css('color', '#A94442');
        } else {
            errorDiv.html('');
        }
    }

    $('.save_categorize_pic').on('click', function() {
        id = $(this).attr("data-id");
        select_el = $('#categorize_' + id);
        var categories = select_el.val();
        if (null == categories) {
            var selected_arr = select_el.selectpicker('val');
            setExhibitionError(null == selected_arr || selected_arr.length == 0);
            return;
        }
        // TODO: error msg if nothing was selected

        dataObj = {picId: id, categories: categories};

        $.ajax({
            type: "post",
            url: "ajax/categorizePic",
            data: dataObj,
            success: success
        });
    });

    function success(result) {
        var json = $.parseJSON(result);
        if (json.status === "OK") {
            window.location.href = "backend";
        } else {
            console.log(json);
            alert("Entschuldigung, es ist ein Fehler aufgetreten.");
        }
    }
});