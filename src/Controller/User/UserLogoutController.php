<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserLogoutController extends AbstractController
{
    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout(): void
    {
    }
}
