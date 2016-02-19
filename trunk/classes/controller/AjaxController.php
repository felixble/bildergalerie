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

        // TODO: Check if file exists
        $file = $this->getRequest()->getFiles()["uploadFile"];
        $tmpFile = $file['tmp_name'];
        $fileName = $file['name'];

        if (!exif_imagetype($tmpFile)) {
            throw new FileIsNotAnImage($fileName);
        }

        $mandantId = $this->baseFactory->getMandantManager()->getMandant()->getMandantId();

        $dirName = "uploads/" . $mandantId;
        if (!is_dir($dirName)) {
            mkdir($dirName);
        }

        $newFilePath = $dirName . "/" . $fileName;

        if (is_file($newFilePath)) {
            throw new FileAlreadyExists($fileName);
        }

        if (@move_uploaded_file($tmpFile, $newFilePath)) {
            $resultArray["status"] = "OK";
            $resultArray["filePath"] = $newFilePath;
        }


        return json_encode($resultArray);
    }
}