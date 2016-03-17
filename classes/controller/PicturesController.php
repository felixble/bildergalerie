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

        if (!$exhibitionId) {
            throw new SimpleUserErrorException("Die Ausstellung wurde nicht gefunden.");
        }

        $exhibition = $this->categoryDAO->getCategoryById($exhibitionId);

        $pictures = $this->pictureDAO->getPicturesFromCategory($exhibitionId);


        if (null == $exhibition) {
            throw new SimpleUserErrorException("Die Ausstellung wurde nicht gefunden.");
        }

        $this->baseFactory->getSessionManager()
            ->setBackTo(Router::getUrl("pictures", "exhibition", array("id" => $exhibitionId)));
        $this->baseFactory->getSessionManager()
            ->setFlash("currentExhibition", $exhibitionId);

        return $this->getContentFrameView("Ausstellung", new ExhibitionView($exhibition, $pictures), true);
    }

    /**
     * Shows detail view of a picture.
     * @return BootstrapView
     * @throws SimpleUserErrorException
     */
    public function picAction()
    {
        $picId = $this->getIdRequestParam("id");

        if (!$picId) {
            throw new SimpleUserErrorException("Das Bild wurde nicht gefunden.");
        }

        $picture = $this->pictureDAO->getPictureById($picId);


        if (null == $picture) {
            throw new SimpleUserErrorException("Das Bild wurde nicht gefunden.");
        }

        // currentExhibition = the exhibition where the user comes from
        $currentExhibition = $this->baseFactory->getSessionManager()->getFlash("currentExhibition", /*refresh*/true);
        $pageTitle = "Details";
        $currentExhibitionObj = null;
        if (null != $currentExhibition && is_numeric($currentExhibition)) {
            $currentExhibitionObj = $picture->getCategoryById($currentExhibition);
            $pageTitle = $currentExhibitionObj->getCategoryName();
        }


        $backTo = $this->baseFactory->getSessionManager()->getBackTo(/*refresh*/true);
        $picDetailView = new Picture_detailView($picture, $backTo, $currentExhibitionObj);

        // TODO: Set main category as page title
        return $this->getContentFrameView($pageTitle, $picDetailView, false); // TODO: title ??
    }

    /**
     * @return BootstrapView
     * @AuthRequired
     */
    public function createAction()
    {
        // check if form is submitted
        if (array_key_exists("add_pic_submit", $this->getRequest()->getPostParam())) {
            $this->processCreatePicture();
        }

        $picFormView = new Picture_formView();

        // get Categories
        $picFormView->setCategories($this->categoryDAO->getAllCategories());

        return $this->getContentFrameView("Bild hinzufügen", $picFormView, false);
    }

    private function processCreatePicture()
    {
        $post = $this->getRequest()->getPostParam();
        $uploadedBy = $this->baseFactory->getAuthenticator()->getLoggedInUser();
        $owner = $uploadedBy;

        $tags = $this->getValueOrNull("tags", $post);
        $descr = $this->getValueOrNull("description", $post);
        $material = $this->getValueOrNull("material", $post);
        $picPathId = $this->getValueOrNull("picPathId", $post);
        $category = $this->getValueOrNull("category", $post);

        $success = false;
        try {
            // TODO: validate user input -> throw exception in setters of picture ?! - Maybe not the best idea...
            $picture = new Picture($this->mandant, null, $post["title"], $descr, null, $material, null, null, null, $picPathId, null, null, $uploadedBy, $owner, null, $tags);
            $picture->addCategories($category);
            // store the new picture in the database
            $this->pictureDAO->createPicture($picture);
            $success = true;
        } catch (UserException $e) {
            $this->getAlertManager()->setErrorMessage("<strong>Fehler!</strong> " . $e->getMessage());
            // TODO: Set form values from request!
        }

        if ($success) {
            $this->getAlertManager()->setSuccessMessage("<strong>Super!</strong> Das Bild wurde erfolgreich hinzugefügt.");
            // redirect so the user can reload the page without sending the form again.
            $this->getRouter()->reLocateTo("pictures", "create");
        }
    }


    /**
     * Returns the id from the request. This may be the first parameter or
     * value of the given key.
     *
     * @param $key
     * @return bool|int ID or false if not given.
     */
    private function getIdRequestParam($key)
    {
        $get = $this->getRequest()->getGetParam();
        if (array_key_exists($key, $get)) { // if we have the get param id its easy...
            return $get[$key];
        } elseif (count($this->getRequest()->getQueryParams()) > 0) { // otherwise, our first parameter key is our id
            return $this->getRequest()->getQueryParams()[0];
        }

        return false;
    }

}