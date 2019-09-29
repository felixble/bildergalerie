/**
 * Created by felix on 19.02.16.
 */

$("#uploadFile").change(function() {
    setPicPathId("");

    var file_data = $('#uploadFile').prop('files');
    var formData = new FormData();
    formData.append('uploadFile', file_data[0]);
    var loading = $('#loading');
    loading.show();
    uploadFile(
        formData,
        function (result) {
            var json = $.parseJSON(result);

            if (json.status == "OK") {
                uploadSuccessful(json.filePath, json.thumbPath, json.picPathId, json.fileName);
            } else {
                console.log(result);
                uploadError(json.errMsg);
            }
            loading.hide();
        }
    );
});

function uploadError(msg) {
    var uploadFileInput = $("#uploadFile");
    uploadFileInput.replaceWith(uploadFileInput.val('').clone(true));
    $('#upload_error').css('display', 'block');
    $('#upload_error_msg').html(msg);
}

function uploadSuccessful(filePath, thumbPath, picPathId, fileName) {
    if (thumbPath == null) {
        thumbPath = filePath;
    }

    // hide error message which could be visible
    $('#upload_error').css('display', 'none');

    setPicPathId(picPathId);

    $('#uploadFile').hide();

    $('#upload_file_name').html(fileName);

    var uploadPreview = $('#uploadPreview');

    uploadPreview.attr('src', thumbPath);
    uploadPreview.show();

    $('#uploadFile_path').val(filePath);
    $('#uploadFile_thumbPath').val(thumbPath);
}

function setPicPathId(picPathId) {
    var picPathEl = $('#picPathId');
    picPathEl.val(picPathId);
    $('#add_pic_submit').prop('disabled', !picPathEl.val());
}

function uploadFile(formData, success) {
    $.ajax({
        type: "POST",
        url: "ajax/upload",
        data: formData,
        processData: false,
        contentType: false,
        success: success
    });

}


$('#picForm').submit(function(e) {
    // check if at least one exhibition chosen
    var el = $('#category');
    var selected_arr = el.selectpicker('val');

    if (null == selected_arr || selected_arr.length == 0) {
        e.preventDefault();
        setExhibitionError(true);
    }
});

$('#category').change(function(e) {
    var selected_arr = $(this).selectpicker('val');
    setExhibitionError(null == selected_arr || selected_arr.length == 0);
});

$('.open_category_dialog').focus(function() {
    var el = $('#category');
    var selected_arr = el.selectpicker('val');
    setExhibitionError(null == selected_arr || selected_arr.length == 0);
});

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