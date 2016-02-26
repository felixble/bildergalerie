/**
 * Created by Felix on 24.02.2016.
 */

$(function() {
    var dialog, form,
        name = $( "#category_name" ),
        descr = $( "#category_description" ),
        allFields = $( [] ).add( name ).add( descr );


    var ajaxAddCategory = function (name, descr, success) {
        $.ajax({
            type: "get",
            url: "ajax/addCategory",
            data: {'name': name, 'description': descr},
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
            ajaxAddCategory(name.val(), descr.val(), function(result) {
                var json = $.parseJSON(result);

                if (json.status == "OK") {
                    onSuccess(json.category_id, json.category_name);
                    dialog.dialog( "close" );
                } else {
                    console.log(json);
                    // TODO: error...
                }
            });
        }
        return valid;
    }

    function onSuccess(id, name) {
        $('#category')
            .append($('<option>', {
            value: id,
            text: name
            }))
            .val(id);
    }

    dialog = $( "#dialog-add_category" ).dialog({
        autoOpen: false,
        height: 400,
        width: 500,
        modal: true,
        buttons: {
            "Ausstellung hinzufügen": addCategory,
            "Abbrechen": function() {
                dialog.dialog( "close" );
            }
        },
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( "ui-state-error" );
        }
    });

    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        addCategory();
    });

    $( "#add_category" ).on( "click", function() {
        dialog.dialog( "open" );
    });
});