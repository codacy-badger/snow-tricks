<?php

namespace App\Controller;

use App\Model\DTO\User\CreateUserDTO;
use App\Model\Entity\User;
use App\Form\UserSignupType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        AuthenticationUtils $authenticationUtils,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->authenticationUtils = $authenticationUtils;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/user/login", name="user_login")
     */
    public function login(): Response
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
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
            $user = CreateUserDTO::create($createUser);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'your account is created');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/signup.html.twig', [
            'userSignup' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout()
    {
    }
}
