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
     * @var Mandant
     */
    private $mandant;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
    }


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

        $dirName = "uploads/" . $this->mandant->getMandantId();
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
            $picPathDAO = new PicturePathDAO($this->baseFactory->getDbConnection(), $this->mandant);

            $picturePath = new PicturePath($this->mandant, /* id will be created */
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
        $tagDAO = new TagDAO(
            $this->baseFactory->getDbConnection(), $this->mandant);

        $tags = $tagDAO->queryForAll();

        $tagsArr = array();

        foreach ($tags as $tag) {
            $tagsArr[] = $tag->getTagName();
        }

        return json_encode($tagsArr);
    }

    public function addCategoryAction()
    {
        $resultArray = array(
            "status"    => "OK"
        );

        $get = $this->getRequest()->getGetParam();
        $descr = null;
        if (array_key_exists("name", $get)) {
            $name = $get["name"];
        } else {
            throw new InvalidArgumentException("Parameter name missing.");
        }
        if (array_key_exists("description", $get)) {
            $descr = $get["description"];
        }

        $category = new Category($this->mandant, null, $name, $descr);

        $categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $catId = $categoryDAO->createCategory($category);
        if ($catId == false) {
            return array("status" => "ERR", "errMsg" => "Kategorie konnte nicht angelegt werden");
        }

        $resultArray["category_id"] = $catId;
        $resultArray["category_name"] = $name;

        return json_encode($resultArray);
    }
}