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
        // TODO: Implement indexAction() method.
        $this->getRouter()->reRouteTo("home", "index");
    }

    /**
     * @return BootstrapView
     * @AuthRequired
     */
    public function createAction()
    {
        $mandant = $this->baseFactory->getMandantManager()->getMandant();

        // check if form is submitted
        if (array_key_exists("add_pic_submit", $this->getRequest()->getPostParam())) {
            $this->processCreatePicture($mandant);
        }

        $picFormView = new Picture_formView();

        // get Categories
        $categoryDAO = new CategoryDAO(
            $this->baseFactory->getDbConnection(),
            $mandant);

        $picFormView->setCategories($categoryDAO->getAllCategories());

        return $this->getContentFrameView("Bild hinzufügen", $picFormView, false);
    }

    private function processCreatePicture($mandant)
    {
        $post = $this->getRequest()->getPostParam();
        $uploadedBy = $this->baseFactory->getAuthenticator()->getLoggedInUser();
        $owner = $uploadedBy;

        $success = false;
        try {
            // TODO: validate user input -> throw exception in setters of picture ?!
            $picture = new Picture($mandant, null, $post["title"], $post["description"], null, $post["material"],
                null, null, null, $post["picPathId"], null, null, $uploadedBy, $owner, $post["category"], null,
                $post["tags"]);

            // store the new picture in the database
            $pictureDAO = new PictureDAO($this->baseFactory->getDbConnection(), $mandant);
            $pictureDAO->createPicture($picture);
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
}