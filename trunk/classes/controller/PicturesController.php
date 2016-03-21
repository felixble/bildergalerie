<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 14.02.2016
 * Time: 16:44
 */
class PicturesController extends BildergalerieController
{

    /**
     * @var PictureDAO
     */
    private $pictureDAO;

    /**
     * @var CategoryDAO
     */
    private $categoryDAO;

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * Current picture which should be displayed
     * in any way.
     *
     * @var Picture
     */
    private $currentPicture;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->pictureDAO = new PictureDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $this->categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);
    }

    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     */
    public function indexAction()
    {
        return $this->exhibitionsAction();
    }

    /**
     * Shows all exhibitions.
     *
     * @return BootstrapView
     */
    public function exhibitionsAction()
    {
        $categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $teasers = $categoryDAO->getCategoryTeasers(false);

        $ausstellungenView = new ExhibitionsView($teasers);
        return $this->getContentFrameView("Ausstellungen", $ausstellungenView);
    }

    /**
     * Shows a single exhibition with all its
     * pictures.
     */
    public function exhibitionAction()
    {
        // remember: exhibition == category
        // first we must select the category_id from the get parameters
        $exhibitionId = $this->getIdRequestParam("id");


        $exhibition = null;
        if (!$exhibitionId) {
            //throw new SimpleUserErrorException("Die Ausstellung wurde nicht gefunden.");
            $exhibitionId = -1; // -1 stands for the special exhibition containing all pictures.
        } else {
            $exhibition = $this->categoryDAO->getCategoryById($exhibitionId);
        }

        $pictures = $this->pictureDAO->getPicturesFromCategory($exhibitionId);


        if (null == $exhibition && $exhibitionId != -1) {
            throw new SimpleUserErrorException("Die Ausstellung wurde nicht gefunden.");
        }

        $backtoParams = ($exhibitionId == -1) ? array() : array("id" => $exhibitionId) ;
        $this->baseFactory->getSessionManager()
            ->setBackTo(Router::getUrl("pictures", "exhibition", $backtoParams));
        if ($exhibitionId != -1) {
            $this->baseFactory->getSessionManager()
                ->setFlash("currentExhibition", $exhibitionId);
        }

        return $this->getContentFrameView("Ausstellung", new ExhibitionView($exhibition, $pictures), true);
    }

    /**
     * Shows detail view of a picture.
     * @return BootstrapView
     * @throws SimpleUserErrorException
     */
    public function picAction()
    {
        $this->setCurrentPictureFromRequest();
        $picture = $this->currentPicture;

        if (null == $picture) {
            throw new SimpleUserErrorException("Das Bild wurde nicht gefunden.");
        }

        // currentExhibition = the exhibition where the user comes from
        $currentExhibition = $this->baseFactory->getSessionManager()->getFlash("currentExhibition", /*refresh*/true);
        $pageTitle = "Gemälde";
        $currentExhibitionObj = null;
        if (null != $currentExhibition && is_numeric($currentExhibition)) {
            $currentExhibitionObj = $picture->getCategoryById($currentExhibition);
            $pageTitle = $currentExhibitionObj->getCategoryName();
        }

        $isAuthenticated = $this->baseFactory->getAuthenticator()->isAuthenticated();


        $backTo = $this->baseFactory->getSessionManager()->getBackTo(/*refresh*/true);
        $picDetailView = new Picture_detailView($picture, $backTo, $currentExhibitionObj, $isAuthenticated);

        // TODO: Set main category as page title
        return $this->getContentFrameView($pageTitle, $picDetailView, false); // TODO: title ??
    }

    /**
     * @return BootstrapView
     * @throws SimpleUserErrorException
     * @AuthRequired
     */
    public function editAction()
    {
        // check if form was submitted
        if (array_key_exists("add_pic_submit", $this->getRequest()->getPostParam())) {
            $editPicId = $this->getIdRequestParam("id", true);
            $this->processCreatePicture($editPicId);
        } else {
            $this->setCurrentPictureFromRequest();
        }

        $picFormView = $this->getPictureFormView(true);
        return $this->getContentFrameView("Bild bearbeiten", $picFormView, false);
    }

    /**
     * @return BootstrapView
     * @AuthRequired
     */
    public function createAction()
    {
        // check if form was submitted
        if (array_key_exists("add_pic_submit", $this->getRequest()->getPostParam())) {
            $this->processCreatePicture();
        }
        // TODO: we should check if there is already a related picture detail entry for the given path_id
        if (array_key_exists("path_id", $this->getRequest()->getGetParam())) {
            $mandant = $this->baseFactory->getMandantManager()->getMandant();
            $picture = new Picture($mandant);
            $picturePathDAO = new PicturePathDAO($this->baseFactory->getDbConnection(), $mandant);
            $path = $picturePathDAO->getPicturePathForId($this->getRequest()->getGetParam()["path_id"]);
            if (null != $path) {
                $picture->setPath($path);
                $this->currentPicture = $picture;
            } else {
                $this->getAlertManager()->setErrorMessage("<strong>Fehler:</strong> Das Bild wurde nicht gefunden.");
            }
        }

        $picFormView = $this->getPictureFormView();

        return $this->getContentFrameView("Bild hinzufügen", $picFormView, false);
    }

    /**
     *
     * @throws Exception
     * @throws SimpleUserErrorException
     * @AuthRequired
     */
    public function deleteAction()
    {
        $deletePicId = $this->getIdRequestParam("id", /* throw exception if not given */ true);

        $this->pictureDAO->deletePicture($deletePicId);

        // if deletePicture didn't throw any exception, redirect back?
        // TODO: where should we redirect to after deleting a picture ??

        $this->getAlertManager()->setSuccessMessage("<strong>OK:</strong> Das Gemälde wurde erfolgreich entfernt.");
        $this->getRouter()->reLocateTo(); // home ?!
    }

    private function getPictureFormView($createMode = false)
    {
        $picFormView = new Picture_formView($createMode);

        if (null != $this->currentPicture) {
            $picFormView->setPicture($this->currentPicture);
        }

        // get Categories
        $picFormView->setCategories($this->categoryDAO->getAllCategories());
        return $picFormView;
    }

    private function processCreatePicture($editPicId = null)
    {
        $edit = (null != $editPicId);

        $post = $this->getRequest()->getPostParam();
        $uploadedBy = $this->baseFactory->getAuthenticator()->getLoggedInUser();
        $owner = $uploadedBy;

        $title = $this->getValueOrNull("title", $post);
        $tags = $this->getValueOrNull("tags", $post);
        $descr = $this->getValueOrNull("description", $post);
        $material = $this->getValueOrNull("material", $post);
        $picPathId = $this->getValueOrNull("picPathId", $post);
        $category = $this->getValueOrNull("category", $post);

        $success = false;
        $picture = null;
        try {
            // TODO: validate user input (-> throw exception in setters of picture ?! - Maybe not the best idea...) - maybe validate method ??
            $picture = new Picture($this->mandant, /* null, iff create-new-pic-Mode */ $editPicId, $title, $descr, null, $material, null, null, null, $picPathId, null, null, $uploadedBy, $owner, null, $tags);
            $picture->addCategories($category);
            // store/update the new picture in the database
            if ($edit) {
                $this->pictureDAO->updatePicture($picture);
            } else {
                $this->pictureDAO->createPicture($picture);
            }
            $success = true;
        } catch (UserException $e) {
            $this->getAlertManager()->setErrorMessage("<strong>Fehler!</strong> " . $e->getMessage());
            // TODO: Set form values from request!
            if (null != $picture) {
                $this->currentPicture = $picture;
            }
        }

        if ($success) {
            $successMsg = ($edit)
                ? "Die Änderungen wurden erfolgreich gespeichert."
                : "Das Bild wurde erfolgreich hinzugefügt.";
            $this->getAlertManager()->setSuccessMessage("<strong>Super!</strong> $successMsg");
            // redirect so the user can reload the page without sending the form again.
            if ($edit) {
                $this->getRouter()->reLocateTo("pictures", "pic", array("id" => $editPicId));
            } else {
                $this->getRouter()->reLocateTo("pictures", "create");
            }
        }
    }

    private function setCurrentPictureFromRequest()
    {
        $this->currentPicture = $this->pictureDAO->getPictureById($this->getIdRequestParam("id", true));
    }


    /**
     * Returns the id from the request. This may be the first parameter or
     * value of the given key.
     *
     * @param $key
     * @param bool $throwExceptionIfNotGiven
     * @return bool|int ID or false if not given.
     * @throws SimpleUserErrorException
     */
    private function getIdRequestParam($key, $throwExceptionIfNotGiven = false)
    {
        $get = $this->getRequest()->getGetParam();
        if (array_key_exists($key, $get)) { // if we have the get param id its easy...
            return $get[$key];
        } elseif (count($this->getRequest()->getQueryParams()) > 0) { // otherwise, our first parameter key is our id
            return $this->getRequest()->getQueryParams()[0];
        }

        if ($throwExceptionIfNotGiven) {
            throw new SimpleUserErrorException("Das Bild wurde nicht gefunden.");
        }

        return false;
    }

}