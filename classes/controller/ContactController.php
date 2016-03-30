<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 23.03.2016
 * Time: 11:14
 */
class ContactController extends BildergalerieController
{

    const MAILADDRESS = "otting.marc@gmail.com";

    /**
     * @var PictureDAO pictureDAO
     */
    private $pictureDAO;

    /**
     * @var Mandant
     */
    private $mandant;

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
        $contactView = new ContactView();
        $get = $this->getRequest()->getGetParam();
        if(array_key_exists("ref_pic", $get))
        {
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->pictureDAO = new PictureDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $picDetails = $this->pictureDAO->getPictureById($get);
        $contactView->setPicture($picDetails);
        }

        return $this->getContentFrameView("Kontaktformular", $contactView);
    }


    public function sendAction()
    {
        try {
            $post = $this->getRequest()->getPostParam();
            $name = $this->getValueOrNull("name", $post);
            $lastName = $this->getValueOrNull("lastName", $post);
            $mail = $this->getValueOrNull("mail", $post);
            $telephone = $this->getValueOrNull("tel", $post);
            $subject = $this->getValueOrNull("subject", $post);
            $content = $this->getValueOrNull("content", $post);
            $picId = $this->getValueOrNull("edit_id", $post);

            $message = $this->buildMessage($name, $lastName, $mail, $telephone, $subject, $content, $picId);

            $headerFrom = sprintf("FROM: %s %s <%s>", $name, $lastName, $mail);

            mail(self::MAILADDRESS, "Hildes-Bildergalerie - $subject", $message, $headerFrom);
            $this->getAlertManager()->setSuccessMessage("<strong>OK:</strong> Vielen Dank. Ihre Anfrage wird umgehend bearbeitet.");
        } catch (Exception $e) {
            $this->getAlertManager()->setErrorMessage("<strong>Fehler:</strong> Ihre Anfrage konnte leider nicht gesendet werden. Bitte versuchen sie es erneut.");
            return $this->indexAction();
        }
        $this->getRouter()->reLocateTo("home");
        return null; // this statement will not be reached...
    }

    private function buildMessage($name, $lastName, $mail, $telephone, $subject, $content, $picId)
    {
        $tel = (null==$telephone) ? ". Die Telefonnummer lautet: ".$telephone : "";
        $path = (null!=$picId) ?
            "\r\nDas angefragte Gemälde finden Sie unter: ".
            MvcConfig::getInstance()->getCompleteBaseUrl() . "pictures/pic/id/".$picId :"";

        $message = "Sehr geehrter Kunde,\r\nSie haben eine Kontaktanfrage von ".$name.
                    " ".$lastName." erhalten\r\n"."Bitte senden Sie eine Antwortmail an:" .
                    $mail.$tel."\r\nDer Betreff der E-Mail lautet: ".$subject.$path.
                    "\r\n und es wurde folgender Inhalt eingetragen:\r\n\r\n".$content;

        return $message;
    }
}