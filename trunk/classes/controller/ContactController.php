<?php

/**
 * Controller for all actions related to the
 * contact functions.
 *
 * User: ottinm
 * Date: 23.03.2016
 * Time: 11:14
 */
class ContactController extends BildergalerieController
{

    const MAILADDRESS = MANDANT_EMAIL;

    /**
     * @var PictureDAO pictureDAO
     */
    private $pictureDAO;

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
     */
    public function indexAction()
    {
        $contactView = new ContactView($this->getRequest()->getPostParam());
        $get = $this->getRequest()->getGetParam();
        if(array_key_exists("ref_pic", $get)) {
            $this->pictureDAO = new PictureDAO($this->baseFactory->getDbConnection(), $this->mandant);
            $picDetails = $this->pictureDAO->getPictureById($get);
            $contactView->setPicture($picDetails);
        }

        return $this->getContentFrameView("Kontaktformular", $contactView);
    }


    public function sendAction()
    {
        $recaptcha = new GoogleRecaptcha(reCAPTCHA_SECRET_KEY);

        try {
            $post = $this->getRequest()->getPostParam();
            $name = self::getValueOrNull("name", $post);
            $lastName = self::getValueOrNull("lastName", $post);
            $mail = self::getValueOrNull("mail", $post);
            $telephone = self::getValueOrNull("tel", $post);
            $subject = self::getValueOrNull("subject", $post);
            $content = self::getValueOrNull("content", $post);
            $picId = self::getValueOrNull("edit_id", $post);
            $recaptchaResponse = self::getValueOrNull("g-recaptcha-response", $post);

            $recaptcha->verify($recaptchaResponse);
            if (!$recaptcha->isValid()) {
                throw new UserException(
                    "ReCaptcha Fehler: " . $recaptcha->getErrorCodesAsString());
            }

            $this->sendMailToMandant($name, $lastName, $mail, $telephone, $subject, $content, $picId);
            $this->sendInfoMailToInquirer($mail, $name, $lastName, $subject, $content);
            $this->getAlertManager()->setSuccessMessage("<strong>OK:</strong> Vielen Dank. Ihre Anfrage wird umgehend bearbeitet.");
        } catch (Exception $e) {
            $error = "<strong>Fehler:</strong> ";
            if (!$recaptcha->isValid()) {
                $error .= "Wir konnten nicht sicherstellen, dass Sie kein Roboter sind. Bitte versuchen Sie es erneut.";
                ErrorMailHandler::sendErrorMail($e);
            } else {
                $error .= "Ihre Anfrage konnte leider nicht gesendet werden. Bitte versuchen Sie es erneut.";
            }
            $this->getAlertManager()->setErrorMessage($error);
            return $this->indexAction();
        }
        $this->getRouter()->reLocateTo("home");
        return null; // this statement will not be reached...
    }

    private function sendMailToMandant($name, $lastName, $mail, $telephone, $subject, $content, $picId)
    {
        $mailToMandant = new Mail(
            self::MAILADDRESS,
            "Hildes-Bildergalerie - $subject",
            sprintf("%s %s <%s>", $name, $lastName, $mail)
        );

        $mailToMandant
            ->putLine("Sehr geehrter Kunde,")
            ->putLine()
            ->putLine("Sie haben eine Kontaktanfrage von $name $lastName erhalten.")
            ->putLine("Bitte senden Sie eine Antwortmail an: $mail.");

        if (null != $telephone) {
            $mailToMandant
                ->putLine("Alternativ erreichen Sie $name $lastName auch über folgende Telefonnummer: $telephone.");
        }

        if (null != $picId) {
            $path = MvcConfig::getInstance()->getCompleteBaseUrl() . "pictures/pic/id/".$picId;
            $mailToMandant->putLine("Das angefragte Gemälde finden Sie unter: " . $path);
        }

        $mailToMandant
            ->putLine()
            ->putLine("Der Betreff der E-Mail lautet: $subject")
            ->putLine()
            ->putLine($content);

        $mailToMandant->send();
    }

    private function sendInfoMailToInquirer($to, $name, $lastName, $subject, $content)
    {
        $mailToInquirer = new Mail($to, "Ihre Anfrage - $subject");

        $mailToInquirer
            ->putLine("Hallo $name $lastName,")
            ->putLine()
            ->putLine("vielen Dank für Ihre Anfrage, wir werden diese umgehend bearbeiten und uns bei Ihnen melden.")
            ->putLine()
            ->putLine("Ihre Nachricht lautet:")
            ->putLine()
            ->putLine($content)
            ->putLine()
            ->putLine("Herzliche Grüße")
            ->putLine($this->mandant->getPageTitle());

        $mailToInquirer->send();
    }
}