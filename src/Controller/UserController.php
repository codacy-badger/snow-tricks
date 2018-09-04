<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/sign-up", name="user-sign-up")
     */
    public function signUp(EntityManagerInterface $entityManager)
    {
        $user = new User();

        $user->setFirstname('Bernard')
            ->setLastname('Toto')
            ->setPseudo('BerToto'.rand(1, 1000))
            ->setEmail('berToto'.rand(1, 1000))
            ->setRole('users')
            ->setPassword('motdepasse')
            ->setCreatedAt(new \DateTime('now'));

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('just creating a new user');
    }
}
