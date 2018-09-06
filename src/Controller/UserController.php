<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/sign-up", name="user-sign-up")
     */
    public function signUp(EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $user = new User();

        $user->setFirstname('Bernard')
            ->setLastname('Toto')
            ->setUsername('BerToto'.rand(1, 1000))
            ->setEmail('berToto@jmail.fr'.rand(1, 1000))
            ->setRoles('User')
            ->setPassword('motdepasse')
            ->setCreatedAt(new \DateTime('now'))
        ;

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('just creating a validate new user');
    }
}
