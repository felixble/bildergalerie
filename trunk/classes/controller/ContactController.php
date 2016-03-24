<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 23.03.2016
 * Time: 11:14
 */
class ContactController extends BildergalerieController
{

    const MAILADDRESS = "hilde@blechschmitt.name";
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
        //TODO datenbankabfrage mit $get für bild details
        }

        return $this->getContentFrameView("Kontaktformular", $contactView);
    }


    public function sendAction()
    {
        $post = $this->getRequest()->getPostParam();
        $name = $this->getValueOrNull("name", $post);
        $lastName = $this->getValueOrNull("lastName", $post);
        $mail = $this->getValueOrNull("mail", $post);
        $telephone = $this->getValueOrNull("tel", $post);
        $subject = $this->getValueOrNull("subject", $post);
        $content = $this->getValueOrNull("content", $post);

        $message = $this->buildMessage($name,$lastName,$mail,$telephone,$subject,$content);

        mail(self::MAILADDRESS,$message);
    }

    private function buildMessage($name, $lastName, $mail, $telephone, $subject, $content)
    {
        $tel = (null==$telephone) ? "Die Telefonnummer lautet: ".$telephone : "";
        $message = "Sehr geehrter Kunde, Sie haben eine Kontaktanfrage von".$name.
                    " ".$lastName."erhalten\n\n"."Bitte senden Sie eine Antwortmail an:" .
                    $mail.$tel."\n\nDer Betreff der eMail lautet: ".$subject."\n und es wurde folgender"
                    . "Inhalt eingetragen: ".$content;

        return $message;
    }
}