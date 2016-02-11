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

    const SESS_USER_OBJECT = "user";

    /**
     * @var SessionManager
     */
    private $sess_manager;

    /**
     * @var IUser
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

        if (!$user_segment->get(self::SESS_USER_OBJECT, false)) {
            $this->user = null;
            return;
        }

        $this->user = unserialize($user_segment->get(self::SESS_USER_OBJECT));
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
        $user_segment->set(self::SESS_USER_OBJECT, serialize($user));
    }

    /**
     * Returns the user object of the user
     * currently logged in.
     *
     * @return IUser
     */
    public function getUser()
    {
        return $this->user;
    }



}