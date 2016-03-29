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

    /**
     * @var PicRatingDAO
     */
    private $ratingDAO;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->ratingDAO = new PicRatingDAO($this->baseFactory->getDbConnection(), $this->mandant);
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
        $editId = null;
        if (array_key_exists("name", $get)) {
            $name = $get["name"];
        } else {
            throw new InvalidArgumentException("Parameter name missing.");
        }
        if (array_key_exists("description", $get)) {
            $descr = $get["description"];
        }

        if (array_key_exists("editId", $get)) {
            $editId = $get["editId"];
        }

        $category = new Category($this->mandant, $editId, $name, $descr); // editId == null if we should create a new one

        $categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);

        if (null != $editId) {
            $result = $categoryDAO->updateCategory($category);
            // TODO: what shall we do with the result ?!
            $catId = $editId;
        } else {
            $catId = $categoryDAO->createCategory($category);
        }
        if ($catId == false) {
            return array("status" => "ERR", "errMsg" => "Kategorie konnte nicht angelegt werden");
        }

        $resultArray["category_id"] = $catId;
        $resultArray["category_name"] = $name;
        $resultArray["category_description"] = $descr;

        return json_encode($resultArray);
    }

    public function categorizePicAction()
    {
        $resultArray = array(
            "status"    => "OK"
        );

        $post = $this->getRequest()->getPostParam();

        // TODO: validate input
        $picId = $this->getValueOrNull("picId", $post);
        $categories = $this->getValueOrNull("categories", $post);

        if (null == $picId) {
            throw new InvalidArgumentException("Parameter picId missing.");
        }

        if (null == $categories) {
            throw new InvalidArgumentException("Parameter categories missing.");
        }

        if (count($categories) == 0) {
            throw new InvalidArgumentException("There must be at least one category given.");
        }

        $picCatMapDAP = new PicCatMapDAO($this->baseFactory->getDbConnection(), $this->mandant);
        foreach ($categories as $catId) {
            $picCatMapDAP->createEntry($picId, new Category($this->mandant, $catId));
        }

        $derden = (count($categories) == 1) ? "der Ausstellung" : "den Ausstellungen";
        $this->getAlertManager()->setSuccessMessage("<strong>OK: </strong> Das Gemälde wurde $derden zugeordnet.");

        return json_encode($resultArray);
    }

    public function rateAction()
    {
        $resultArray = array(
            "status"    => "OK"
        );

        $get = $this->getRequest()->getGetParam();

        if (!array_key_exists("picId", $get)) {
            throw new InvalidArgumentException("Parameter pidId missing.");
        }

        if (!array_key_exists("value", $get)) {
            throw new InvalidArgumentException("Parameter value missing.");
        }

        $picId = $get["picId"];
        $ratingeValue = $get["value"];

        if ($ratingeValue < 1 || $ratingeValue > 5) {
            throw new InvalidArgumentException("Value must be between 1 and 5");
        }

        $visitorRatingId = RatingManager::getVisitorRatingId();

        $result = true;
        $update = false;
        $ratingId = $this->ratingDAO->getRatingIdForVisitor($visitorRatingId, $picId);
        if (null != $ratingId) {
            // update rating value
            $this->ratingDAO->updateVotingEntry($ratingeValue, $ratingId);
            $update = true;

        } else {
            // create a new rating value
            $result = $this->ratingDAO->createVotingEntry($picId, $ratingeValue, $visitorRatingId);
        }

        if ($result == false) {
            throw new IllegalStateException("Could not save rating");
        }

        // fetch the current overall rating value
        $overallRating = $this->ratingDAO->getOverallRatingForPic($picId);

        $resultArray["overall_rating"] = $overallRating;
        $resultArray["value"] = $ratingeValue;
        $resultArray["update"] = $update;

        return json_encode($resultArray);
    }

}