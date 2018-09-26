<?php

namespace App\Controller;

use App\Entity\User;
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
     * @Route("/user/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/user/sign-up", name="user_signup")
     */
    public function signUp(EntityManagerInterface $entityManager, ValidatorInterface $validator, Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserSignupType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime('now'));

            $entityManager->persist($user);
            $entityManager->flush();

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
