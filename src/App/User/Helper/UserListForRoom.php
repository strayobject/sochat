<?php

namespace SoChat\App\User\Helper;

class UserListForRoom
{
    private $dbUsers;

    public function __construct($dbUsers)
    {
        $this->setDbUsers($dbUsers);
    }

    public function getList()
    {
        return $this->getDbUsers()->getAll();
    }

    /**
     * Gets the value of dbUsers.
     *
     * @return mixed
     */
    public function getDbUsers()
    {
        return $this->dbUsers;
    }

    /**
     * Sets the value of dbUsers.
     *
     * @param mixed $dbUsers the db users
     *
     * @return self
     */
    public function setDbUsers($dbUsers)
    {
        $this->dbUsers = $dbUsers;

        return $this;
    }
}
