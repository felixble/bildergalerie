<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 16.02.2016
 * Time: 13:01
 */
class UserDAO implements IUserDAO
{

    const TABLE_NAME = "galery_user";

    const COL_MANDANT_ID= "mandant_id";
    const COL_USER_ID = "user_id";
    const COL_USERNAME = "username";
    const COL_PASSWORD = "password";
    const COL_SALT = "salt";
    const COL_FIRST_NAME = "first_name";
    const COL_LAST_NAME = "last_name";
    const COL_EMAIL = "email";
    const COL_LASTLOGIN = "lastlogin";
    const COL_DATE_REGISTERED = "date_registered";

    const PASSWORD_PEPPER = "G=}W9+=T";

    /**
     * @var Simplon\Mysql\Manager\SqlManager
     */
    private $sqlManager;

    /**
     * Current mandant
     *
     * @var Mandant
     */
    private $mandant;

    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        $this->sqlManager = new \Simplon\Mysql\Manager\SqlManager($dbConn);
        $this->mandant = $mandant;
    }

    /**
     * Returns the user identified by the username
     * or {@code null} iff the password does not match
     * or the user does not exists.
     *
     * @param $user string username
     * @param $pass string password
     * @return User|null
     */
    public function getValidUser($user, $pass)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM galery_user WHERE username = :user AND mandant_id =:m_id')
            ->setConditions(array('user' => $user, "m_id" => $this->mandant->getMandantId()));

        $row = $this->sqlManager->fetchRow($sqlBuilder);
        if ($this->sqlManager->getRowCount()) {
            if ($this->isValidUser($row[self::COL_PASSWORD], $row[self::COL_SALT], $pass)) {
                return new User(
                    $this->mandant,
                    $row[self::COL_USER_ID],
                    $row[self::COL_USERNAME],
                    $row[self::COL_LAST_NAME],
                    $row[self::COL_FIRST_NAME],
                    $row[self::COL_EMAIL]
                );
            }
        }

        return null;
    }

    /**
     * @param $pass
     * @param $salt
     * @param $passUserInput
     * @return bool
     */
    private function isValidUser($pass, $salt, $passUserInput)
    {
        $passUserHash = md5($passUserInput . $salt . self::PASSWORD_PEPPER);
        return $pass == $passUserHash;
    }

    private function getSqlBuilder()
    {
        $sqlBuilder = new Simplon\Mysql\Manager\SqlQueryBuilder();

        $sqlBuilder->setTableName(self::TABLE_NAME);
        return $sqlBuilder;
    }
}