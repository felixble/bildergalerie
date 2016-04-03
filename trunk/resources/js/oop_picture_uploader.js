/**
 * Created by felix on 03.04.16.
 */



var PictureUploader = function (callback) {
    this.callback = callback;


    this.uploadPicsCount = 0;
}; // constructor for our class

PictureUploader.prototype.startUpload = function(files) {
    this.uploadPicsCount = files.length;
    for (var i = 0; i < files.length; i++) {
        var formData = new FormData();
        formData.append('uploadFile', files[i]);
        this.uploadFile(formData);
    }
};


PictureUploader.prototype.uploadFile = function(formData) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "ajax/upload",
        data: formData,
        processData: false,
        contentType: false,
        success: self.onSuccess,
        refObj: self
    });
};

PictureUploader.prototype.onSuccess = function(result) {
    var self = this.refObj;
    var json = $.parseJSON(result);

    if (json.status == "OK") {
        self.callback.uploadSuccessful(json.filePath, json.thumbPath, json.picPathId, json.fileName);
    } else {
        console.log(result);
        self.callback.uploadError(json.errMsg);
    }
    self.uploadPicsCount--;
    if (self.uploadPicsCount == 0) {
        self.callback.onAllPicsUploaded();
    }
};