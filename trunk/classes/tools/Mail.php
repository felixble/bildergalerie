<?php

/**
 * Simple helper class to write
 * E-Mails.
 *
 * User: felix
 * Date: 31.03.16
 * Time: 17:09
 */
class Mail
{

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string[]
     */
    private $messageLines = array();

    /**
     * @var string
     */
    private $message;

    /**
     * @var string|null
     */
    private $headers = null;

    /**
     * @var string
     */
    private $additionalParameters = null;

    /**
     * Mail constructor.
     * @param $to
     * @param $subject
     * @param $from
     */
    public function __construct($to, $subject, $from)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->from = $from;
    }

    public function putLine($line)
    {
        $this->messageLines[] = $line;
        return $this;
    }

    public function send()
    {
        return mail($this->to, $this->subject, $this->getMessage(), $this->getHeaders(), $this->getAdditionalParameters());
    }

    private function getHeaders()
    {
        if (null == $this->headers) {
            $this->headers  = "MIME-Version: 1.0\r\n";
            $this->headers .= "Content-type: text/plain; charset=UTF-8\r\n";
            $this->headers .= "From: " . $this->from. "\r\n";
            $this->headers .= "Reply-To: " . $this->from . "\r\n";
        }

        return $this->headers;
    }

    private function getAdditionalParameters()
    {
        return $this->additionalParameters;
    }

    private function getMessage()
    {
        $this->message = "";
        $first = true;
        foreach ($this->messageLines as $line) {
            if ($first) $first = false;
            else $this->message .= "\r\n";
            $this->message .= $line;
        }

        $this->santizePasswords();

        return $this->message;
    }

    private function santizePasswords()
    {
        $this->message = str_replace(DB_PASS, "###", $this->message);
    }

}