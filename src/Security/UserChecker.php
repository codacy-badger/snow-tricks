<?php

namespace App\Security;

use App\Model\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if(!$user instanceof AppUser){
            return;
        }

        // user is deleted, show a generic Account Not Found message.
        if ($user->get()) {
            throw new AccountDeletedException('...');

            // or to customize the message shown
        }
    }


    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }

}
