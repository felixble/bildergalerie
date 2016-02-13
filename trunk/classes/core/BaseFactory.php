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
     * @var \Simplon\Mysql\Mysql
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
        $this->mandantManager = new MandantManager($request, $this->getDbConnection());
    }

    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    public function getDbConnection()
    {
        if (null === $this->dbConn) {
            $this->dbConn = new Simplon\Mysql\Mysql(
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

    public function getUserDAO()
    {
        return new UserPseudoDAO();
        //throw new NotImplementedException("#getUserDAO() in BaseFactory not yet implemented.");
    }


}