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

var obj = $("#uploadzone");

obj.on('dragleave', function (e)
{
    e.stopPropagation();
    e.preventDefault();
    $(this).removeClass('is-dragover');
    $('#drop_text').hide();
    $('#drop_help').show();
});
obj.on('dragover', function (e)
{
    e.stopPropagation();
    e.preventDefault();
    $(this).addClass('is-dragover');
    $('#drop_text').show();
    $('#drop_help').hide();
});
obj.on('drop', function (e)
{
    $('#drop_help').hide();
    $('#drop_text').hide();
    $('#uploading_text').show();
    $(this).removeClass('is-dragover');
    e.preventDefault();
    var files = e.originalEvent.dataTransfer.files;
    picUploader.startUpload(files);

    //We need to send dropped files to Server
    //handleFileUpload(files,obj);
});