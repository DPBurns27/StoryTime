<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 21/2/17
 * Time: 3:28 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;


class MatcherService
{
    /**
     * @var array
     */
    private $unmatchedUsers;

    /**
     * @param User $user
     */
    public function addUnmatchedUser(User $user)
    {
        $this->unmatchedUsers[] = $user;
    }

    /**
     * @param array
     */
    public function removeUnmatchedUsers($users)
    {
        $this->unmatchedUsers = array_diff($this->unmatchedUsers, $users);
    }

    /**
     * @return array
     */
    public function getUnmatchedUsers()
    {
        return $this->unmatchedUsers;
    }

    public function matchUsers()
    {
        if (count($this->unmatchedUsers) > 1)
        {
            $matchedUsers = array($this->unmatchedUsers[0],$this->unmatchedUsers[1]);
            $this->removeUnmatchedUsers($matchedUsers);
            return $matchedUsers;
        }
        return null;
    }
}