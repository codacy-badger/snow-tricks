<?php

namespace App\Controller\User;

use App\Model\DTO\User\ConfirmUserDTO;
use App\Model\DTO\User\CreateUserDTO;
use App\Model\Entity\User;
use App\Form\User\UserSignupType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/user/confirm/{confirmationToken}", name="user_confirm")
     */
    public function confirm(Request $request): Response
    {
        /** @var User $user */
        $user = $this->userRepository->findBy(['confirmationToken']);

        if($user != null){

            $user->confirm();
        }

        return $this->redirectToRoute('user_login');
    }
}
