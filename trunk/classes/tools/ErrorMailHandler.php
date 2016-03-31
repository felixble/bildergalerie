<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 31.03.16
 * Time: 16:58
 */
class ErrorMailHandler
{

    const ERROR_MAIL_TO = "fehler@hildes-bildergalerie.de";
    const SUBJECT = "Fehler - Bildergalerie";


    public static function sendErrorMail(Exception $e)
    {
        $mail = new Mail(self::ERROR_MAIL_TO, self::SUBJECT);

        $mail->putLine("Hallo Admins,")
            ->putLine("")
            ->putLine("soeben ist ein Fehler in der Bildergalerie aufgetreten:")
            ->putLine("Exception Name: " . get_class($e))
            ->putLine("Message: " . $e->getMessage())
            ->putLine("Code: " . $e->getCode())
            ->putLine("File: " . $e->getFile())
            ->putLine("Line: " . $e->getLine())
            ->putLine("StackTrace: " . $e->getTraceAsString())
            ->putLine("")
            ->putLine("Server Name: " . $_SERVER["SERVER_NAME"])
            ->putLine("Request Time: " . $_SERVER["REQUEST_TIME"])
            ->putLine("Remote Address: " . $_SERVER["REMOTE_ADDR"])
            ->putLine("Remote User Agent: " . $_SERVER["HTTP_USER_AGENT"])
            ->putLine("Request URI: " . $_SERVER["REQUEST_URI"]);

        $mail->send();
    }

}