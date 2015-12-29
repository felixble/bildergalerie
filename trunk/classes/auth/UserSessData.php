<?php

/**
 * Contains all session information of the current user.
 *
 * User: Felix
 * Date: 27.12.2015
 * Time: 16:42
 */
class UserSessData
{

    const SESS_USER_ID = "user_id";
    const SESS_USER_NAME = "user_name";
    const SESS_NAME = "name";
    const SESS_FIRST_NAME = "first_name";
    const SESS_EMAIL = "email";

    /**
     * @var SessionManager
     */
    private $sess_manager;

    /**
     * @var User
     */
    private $user = null;

    /**
     * UserSessData constructor.
     * @param SessionManager $sess_manager
     */
    public function __construct(SessionManager $sess_manager)
    {
        $this->sess_manager = $sess_manager;
        $this->laodUserFromSession();
    }



    /**
     * Loads all user information from the session
     * into a user object.
     */
    private function laodUserFromSession()
    {
        $user_segment = $this->sess_manager->getUserSegment();

        if (!$user_segment->get(self::SESS_USER_ID, false)) {
            $this->user = null;
            return;
        }

        $this->user = new User(
            $user_segment->get(self::SESS_USER_ID),
            $user_segment->get(self::SESS_USER_NAME),
            $user_segment->get(self::SESS_NAME),
            $user_segment->get(self::SESS_FIRST_NAME),
            $user_segment->get(self::SESS_EMAIL)
        );
    }

    /**
     * Saved the user object as session data.
     *
     * @param $user User to store as session data.
     */
    public function storeUser($user)
    {
        $this->user = $user;

        $user_segment = $this->sess_manager->getUserSegment();
        $user_segment->set(self::SESS_USER_ID, $user->getUserId());
        $user_segment->set(self::SESS_USER_NAME, $user->getUsername());
        $user_segment->set(self::SESS_NAME, $user->getName());
        $user_segment->set(self::SESS_FIRST_NAME, $user->getFirstName());
        $user_segment->set(self::SESS_EMAIL, $user->getEmail());
    }

    /**
     * Returns the user object of the user
     * currently logged in.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }



}