/**
 * Created by felix on 19.02.16.
 */

$("#uploadFile").change(function() {
    setPicPathId("");

    var file_data = $('#uploadFile').prop('files')[0];
    var formData = new FormData();
    formData.append('uploadFile', file_data);
    uploadFile(
        formData,
        function (result) {
            var json = $.parseJSON(result);

            if (json.status == "OK") {
                uploadSuccessful(json.filePath, json.thumbPath, json.picPathId);
            } else {
                console.log(result);
                uploadError(json.errMsg);
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

function uploadSuccessful(filePath, thumbPath, picPathId) {
    if (thumbPath == null) {
        thumbPath = filePath;
    }

    // hide error message which could be visible
    $('#upload_error').css('display', 'none');

    setPicPathId(picPathId);

    $('#uploadFile').hide();
    var uploadPreview = $('#uploadPreview');

    uploadPreview.attr('src', thumbPath);
    uploadPreview.show();
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