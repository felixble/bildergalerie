/**
 * Created by felix on 19.02.16.
 */

$("#uploadFile").change(function() {
    setFilePath("", "");

    var file_data = $('#uploadFile').prop('files')[0];
    var formData = new FormData();
    formData.append('uploadFile', file_data);
    uploadFile(
        formData,
        function (result) {
            console.log(result);

            var json = $.parseJSON(result);

            if (json.status == "OK") {
                uploadSuccessful(json.filePath, json.thumbPath);
            } else {
                uploadError(json.errMsg);
                // TODO: tell the user about the occured error
            }
        }
    );
});

function uploadError(msg) {
    var uploadFileInput = $("#uploadFile");
    uploadFileInput.replaceWith(uploadFileInput.val('').clone(true));
    $('#upload_error').css('display', 'block');
    $('#upload_error_msg').html(msg);
}

function uploadSuccessful(filePath, thumbPath) {
    // hide error message could be visible
    $('#upload_error').css('display', 'none');

    setFilePath(filePath, thumbPath); // if thumbPath is null, we should not set it.

    if (thumbPath == null) { // but we want to show the file in the preview, tough.
        thumbPath = filePath;
    }

    $('#uploadFile').hide();
    var uploadPreview = $('#uploadPreview');

    uploadPreview.attr('src', thumbPath);
    uploadPreview.show();
}


function setFilePath(filePath, thumbPath) {
    if (thumbPath == null) {
        thumbPath = "";
    }
    $('#thumbPath').val(thumbPath);
    var filePathEl = $('#filePath');
    filePathEl.val(filePath);
    $('#add_pic_submit').prop('disabled', !filePathEl.val());
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