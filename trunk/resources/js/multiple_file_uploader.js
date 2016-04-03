/**
 * Created by felix on 03.04.16.
 */


var callback = {
    onAllPicsUploaded: function() {
        window.location.reload();
    },
    uploadSuccessful: function (filePath, thumbPath, picPathId, fileName) {
    },
    uploadError: function(msg) {
        alert(msg);
    }
};

var picUploader = new PictureUploader(callback);
var uploadzoneObj = $("#uploadzone");

function startUpload(files) {
    $('#drop_help').hide();
    $('#drop_text').hide();
    $('#uploading_text').show();
    uploadzoneObj.removeClass('is-dragover');
    picUploader.startUpload(files);
}

$('#fileUpload').change(function() {
    startUpload($(this).prop('files'));
});

uploadzoneObj.on('dragleave', function (e)
{
    e.stopPropagation();
    e.preventDefault();
    $(this).removeClass('is-dragover');
    $('#drop_text').hide();
    $('#drop_help').show();
});
uploadzoneObj.on('dragover', function (e)
{
    e.stopPropagation();
    e.preventDefault();
    $(this).addClass('is-dragover');
    $('#drop_text').show();
    $('#drop_help').hide();
});
uploadzoneObj.on('drop', function (e) {
    e.preventDefault();
    startUpload(e.originalEvent.dataTransfer.files);
});