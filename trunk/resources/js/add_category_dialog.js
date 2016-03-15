/**
 * Created by Felix on 24.02.2016.
 */

function onSuccessPicForm(id, name, description) {
    var el = $('#category');
    var selected_arr = el.selectpicker('val');
    selected_arr.push(id);

    el
        .append($('<option>', {
            value: id,
            text: name
        }))
        .selectpicker('val', selected_arr)
        .selectpicker('refresh')
        .last().trigger('change');
}

function onSuccessDashboard(id, name, description) {
    $('#exhibition_name_' + id).html(name);
    $('#exhibition_descr_' + id).html(description);

}

$(function() {
    var dialog, dialog_element, form, editCategory, saveBtnTitle, successFunction,
        catId = -1,
        name = $( "#category_name" ),
        descr = $( "#category_description"),
        allFields = $( [] ).add( name ).add( descr),

        dialog_buttons = {};


    var ajaxAddCategory = function (name, descr, editId, success) {
        $.ajax({
            type: "get",
            url: "ajax/addCategory",
            data: {'name': name, 'description': descr, 'editId' : editId},
            success: success
        });
    };

    function isValid() {
        var result = true;
        form.validator('validate');
        form.find('.form-group').each(function(){
            if($(this).hasClass('has-error')){
                result = false;
                return false;
            }
        });
        return result;
    }

    function addCategory() {
        var valid = isValid();

        if ( valid ) {
            ajaxAddCategory(name.val(), descr.val(), catId, function(result) {
                var json = $.parseJSON(result);

                if (json.status == "OK") {
                    successFunction(json.category_id, json.category_name, json.category_description);
                    dialog.dialog( "close" );
                } else {
                    console.log(json);
                    // TODO: error...
                }
            });
        }
        return valid;
    }

    dialog_element = $("#dialog-add_category");
    editCategory = dialog_element.attr("data-edit") == "true";
    saveBtnTitle = (editCategory) ? "Änderungen speichern" : "Ausstellung hinzufügen";
    dialog_buttons[saveBtnTitle] = addCategory;
    dialog_buttons["Abbrechen"] = function() { dialog.dialog( "close" ); };

    dialog = dialog_element.dialog({
        title: (editCategory) ? "Ausstellung bearbeiten" : "Neue Ausstellung hinzufügen",
        autoOpen: false,
        height: 400,
        width: 500,
        modal: true,
        buttons: dialog_buttons,
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( "ui-state-error" );
        }
    });

    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        addCategory();
    });


    $( ".open_category_dialog" ).on( "click", function() {
        if ($(this).attr("data-id")) {
            catId = $(this).attr("data-id");
        }
        if ($(this).attr("data-category-name")) {
            name.val($(this).attr("data-category-name"));
        }
        if ($(this).attr("data-category-description")) {
            descr.val($(this).attr("data-category-description"));
        }

        // TODO: if we edit a second time (without realod) the data fields are not up to date...

        // very dirty approach...
        successFunction = window[$(this).attr("data-on-success")];

        dialog_element.attr("title", "hallo");//(editCategory) ? "Neue Ausstellung hinzufügen" : "Ausstellung bearbeiten");


        dialog.dialog( "open" );
        return false;
    });
});