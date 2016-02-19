<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 07:41
 *
 * @JsonResponse
 */
class AjaxController extends BildergalerieController
{


    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     * @throws UnsupportedAjaxCall
     */
    public function indexAction()
    {
        throw new UnsupportedAjaxCall();
    }

    public function uploadAction()
    {
        $resultArray = array(
            "status"    => "ERR"
        );

        if (!array_key_exists("uploadFile", $this->getRequest()->getFiles())) {
            throw new IllegalArgumentException("Uploaded file not given.");
        }

        $file = $this->getRequest()->getFiles()["uploadFile"];

        $mandantId = $this->baseFactory->getMandantManager()->getMandant()->getMandantId();

        $dirName = "uploads/" . $mandantId;
        if (!is_dir($dirName)) {
            mkdir($dirName);
        }

        $picUploader = new PictureUploader($file, $dirName);
        if ($picUploader->uploadFile()) {
            // pic upload was successful
            $resultArray["status"] = "OK";
            $resultArray["filePath"] = $picUploader->getUploadedFilePath();
            $resultArray["thumbPath"] = $picUploader->getThumbFilePath();
        }

        return json_encode($resultArray);
    }
}