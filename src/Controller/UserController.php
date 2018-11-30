<?php

namespace App\Controller;

use App\Form\User\UserLoginType;
use App\Model\DTO\User\CreateUserDTO;
use App\Model\Entity\User;
use App\Form\User\UserSignupType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        AuthenticationUtils $authenticationUtils,
        UserRepository $userRepository,
        ValidatorInterface $validator
    ) {
        $this->authenticationUtils = $authenticationUtils;
        $this->validator = $validator;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/login", name="user_login")
     */
    public function login(): Response
    {
        $userLoginForm = $this->createForm(UserLoginType::class);

        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'user_login_form' => $userLoginForm->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/user/sign-up", name="user_signup")
     */
    public function signUp(Request $request): Response
    {
        $createUser = new CreateUserDTO();

        $form = $this->createForm(UserSignupType::class, $createUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = User::create($createUser);

            $this->userRepository->save($user);

            $this->addFlash('success', 'user.success.creation');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/signup.html.twig', [
            'userSignup' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout(): void
    {
    }
}
