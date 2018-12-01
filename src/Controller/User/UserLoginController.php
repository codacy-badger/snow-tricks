<?php

namespace App\Controller\User;

use App\Form\User\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserLoginController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils) {

        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/user/login", name="user_login")
     */
    public function login(): Response
    {
        $userLoginForm = $this->createForm(UserLoginType::class);

        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'user_login_form' => $userLoginForm->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
