/**
 * Created by felix on 19.02.16.
 */

$("#uploadFile").change(function() {
    setFilePath("");

    var file_data = $('#uploadFile').prop('files')[0];
    var formData = new FormData();
    formData.append('uploadFile', file_data);
    uploadFile(
        formData,
        function (result) {
            console.log(result);

            var json = $.parseJSON(result);

            if (json.status == "OK") {
                setFilePath(json.filePath);
            }
        }
    );
});


function setFilePath(filePath) {
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