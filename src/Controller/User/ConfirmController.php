<?php

namespace App\Controller\User;

use App\Model\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/confirm/{confirmationToken}", name="user_confirm")
     */
    public function confirm(string $confirmationToken): Response
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['confirmationToken' => $confirmationToken]);

        if ($user) {
            $user->confirm();

            $this->userRepository->save($user);
        }

        return $this->redirectToRoute('user_login');
    }
}
