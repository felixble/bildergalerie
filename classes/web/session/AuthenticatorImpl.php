<?php


class AuthenticatorImpl implements \App\Utils\Authenticator
{

    /**
     * @var Authenticator
     */
    private $deprAuthenticator;

    /**
     * AuthenticatorImpl constructor.
     * @param Authenticator $deprAuthenticator
     */
    public function __construct(Authenticator $deprAuthenticator)
    {
        $this->deprAuthenticator = $deprAuthenticator;
    }


    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->deprAuthenticator->isAuthenticated();
    }
}