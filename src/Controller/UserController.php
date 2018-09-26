<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function signUp(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $user = new User();

        $user->setFirstname('Bernard');
        $user->setLastname('Toto');
        $user->setEmail('berToto@jmail.fr'.rand(1, 1000));
        $user->setRoles('ROLE_USER');
        $user->setPassword('motdepasse');
        $user->setCreatedAt(new \DateTime('now'));

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('just creating a validate new user');
    }

    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function logout()
    {
    }
}
