<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 16/2/17
 * Time: 2:03 PM
 */

namespace AppBundle\Security;

use AppBundle\Entity\Story;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class StoryVoter extends Voter
{

    const EDIT = "edit";

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }

        // only vote on Story objects inside this voter
        if (!$subject instanceof Story) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Story $story */
        $story = $subject;

        switch ($attribute) {
//            case self::VIEW:
//                return $this->canView($story, $user);
            case self::EDIT:
                return $this->canEdit($story, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

//    private function canView(Story $story, User $user)
//    {
//        // if they can edit, they can view
//        if ($this->canEdit($story, $user)) {
//            return true;
//        }
//
//        // the Post object could have, for example, a method isPrivate()
//        // that checks a boolean $private property
//        return !$story->isPrivate();
//    }

    private function canEdit(Story $story, User $user)
    {

        $users = $story->getUsers();

        return $users->contains($user);

        //return $currentUser === $story->getOwner();
    }
}