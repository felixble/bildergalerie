<?php

class GoogleRecaptcha
{

    private static $errorDescription = [
        "missing-input-secret" => "The secret parameter is missing.",
        "invalid-input-secret" => "The secret parameter is invalid or malformed.",
        "missing-input-response" => "The response parameter is missing.",
        "invalid-input-response" => "The response parameter is invalid or malformed."
    ];

    private $privateKey;

    private $responseData = null;

    /**
     * GoogleRecaptcha constructor.
     * @param $privateKey
     */
    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public static function getApiScript() {
        return 'https://www.google.com/recaptcha/api.js';
    }

    public static function printApiScriptTag() {
        echo '<script src="' . self::getApiScript() . '"></script>';
    }

    public static function drawWidget($publicKey, $dataCallback = "") {
        if (!empty($dataCallback)) {
            $dataCallback = ' data-callback="' . $dataCallback . '"';
        }
        echo '<div class="g-recaptcha" data-sitekey="' . $publicKey . '"' . $dataCallback . '></div>';
    }

    public function verify($responseField) {
        $verifyResponse = self::curl(self::getApiRequestUrl($this->privateKey, $responseField));
        $this->responseData = json_decode($verifyResponse);
    }

    public function isValid() {
        if ($this->responseData == null) return false;

        return $this->responseData->success;
    }

    /**
     * @return array
     */
    public function getErrorCodes() {
        if ($this->responseData == null) return [];

        return $this->responseData->{'error-codes'};
    }

    public function getErrorCodesAsString() {
        $res = "[";
        $first = true;
        foreach ($this->getErrorCodes() as $errorCode) {
            if ($first) $first = false; else $res .= ', ';
            $res .= $errorCode . ':' . self::getErrorDescription($errorCode);
        }
        return $res . ']';
    }

    public static function getErrorDescription($errorCode) {
        return self::$errorDescription[$errorCode];
    }

    private static function getApiRequestUrl($privateKey, $responseField, $remoteip = "") {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $url .= '?secret=' . $privateKey;
        $url .= '&response=' . $responseField;
        if (!empty($remoteip)) {
            $url .= '&remoteip=' . $remoteip;
        }

        return $url;
    }

    private static function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}