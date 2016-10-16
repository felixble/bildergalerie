<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 16.02.2016
 * Time: 13:01
 */
class UserDAO extends BaseMultiClientDAO implements IUserDAO
{

    const MYSQL_DATE_TIME_FORMAT = "Y-m-d H:i:s";

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

    /**
     * For more security we use salt and pepper to spice it up
     */
    const PASSWORD_PEPPER = "G=}W9+=T";

    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
    }

    /**
     * Returns the user identified by the username
     * or null iff the password does not match
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
            // we have to validate first because the object representation does not contain the password hash
            if ($this->isValidUser($row[self::COL_PASSWORD], $row[self::COL_SALT], $pass)) {
                $user = $this->row2Object($row);
                $user->setLastlogin(new DateTime());
                $this->updateUser($user);
                return $user;
            }
        }

        return null;
    }

    /**
     * @param User $user
     * @return bool
     */
    private function updateUser(User $user)
    {
        $data = array(
            self::COL_LASTLOGIN => $user->getLastlogin()->format(self::MYSQL_DATE_TIME_FORMAT)
        );

        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_USER_ID => $user->getUserId()))
            ->setData($data);

        return $this->sqlManager->update($sqlBuilder);
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

    public function row2Object($row)
    {
        return new User(
            $this->mandant,
            self::getValueOrNull($row, self::COL_USER_ID),
            self::getValueOrNull($row, self::COL_USERNAME),
            self::getValueOrNull($row, self::COL_LAST_NAME),
            self::getValueOrNull($row, self::COL_FIRST_NAME),
            self::getValueOrNull($row, self::COL_EMAIL)
        );
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}