<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:27
 */
class BaseFactory
{

    /**
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * @var MandantManager
     */
    private $mandantManager;

    /**
     * @var GaleryMysql
     */
    private $dbConn = null;

    /**
     * BaseFactory constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->sessionManager = new SessionManager($request->getCookies());
        $this->mandantManager = new MandantManager($request, $this->getDbConnection(), $this->getSessionManager());
    }

    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    /**
     * @return GaleryMysql
     */
    public function getDbConnection()
    {
        if (null === $this->dbConn) {
            $this->dbConn = new GaleryMysql(
                DB_HOST,
                DB_USER,
                DB_PASS,
                DB_DATABASE,
                \PDO::FETCH_ASSOC,
                DB_CHARSET,
                array('port' => DB_PORT)
            );
        }

        return $this->dbConn;
    }
    /**
     * @return MandantManager
     */
    public function getMandantManager()
    {
        return $this->mandantManager;
    }

    /**
     * @return Authenticator
     */
    public function getAuthenticator()
    {
        return new Authenticator($this->getUserDAO(), $this->getSessionManager());
    }

    public function getUserDAO()
    {
        return new UserDAO($this->dbConn, $this->getMandantManager()->getMandant());
    }


}