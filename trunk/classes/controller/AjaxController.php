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

    /**
     * @return string
     * @throws Exception
     * @throws FileAlreadyExists
     * @throws IllegalArgumentException
     */
    public function uploadAction()
    {
        $resultArray = array(
            "status"    => "ERR",
            "errMsg"   => "Das Bild konnte nicht gespeichert werden."
        );

        if (!array_key_exists("uploadFile", $this->getRequest()->getFiles())) {
            throw new IllegalArgumentException("Uploaded file not given.");
        }

        $file = $this->getRequest()->getFiles()["uploadFile"];

        $mandant = $this->baseFactory->getMandantManager()->getMandant();

        $dirName = "uploads/" . $mandant->getMandantId();
        if (!is_dir($dirName)) {
            mkdir($dirName);
        }

        $picUploader = new PictureUploader($file, $dirName);
        if (!$picUploader->uploadFile()) {
            // upload failed so we return the default error message
            return json_encode($resultArray);
        }

        // picture upload was successful, now we save the path in our database
        try {
            $picPathDAO = new PicturePathDAO($this->baseFactory->getDbConnection(), $mandant);

            $picturePath = new PicturePath($mandant, /* id will be created */
                null, $picUploader->getUploadedFilePath(),
                $picUploader->getThumbFilePath(), $this->baseFactory->getAuthenticator()->getLoggedInUser());

            $picPathId = $picPathDAO->createPicturePath($picturePath);
        } catch (Exception $e) {
            // if anything goes wrong, we must delete the uploaded file
            $picUploader->deleteUploadedFiles();
            throw $e;
        }


        $resultArray["status"] = "OK";
        $resultArray["picPathId"] = $picPathId;
        $resultArray["filePath"] = $picUploader->getUploadedFilePath();
        $resultArray["fileName"] = $file["name"];
        $resultArray["thumbPath"] = $picUploader->getThumbFilePath();
        return json_encode($resultArray);
    }

    public function getTagsAction()
    {
        $tags = array("Anika", "Felix", "Hilde", "Christoph", "Albert", "Coralie");
        return json_encode($tags);
    }
}