<?php

namespace App\Controller\User;

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

class SignupController extends AbstractController
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
     * @Route("/user/sign-up", name="user_signup")
     */
    public function signUp(Request $request): Response
    {
        $createUser = new CreateUserDTO();

        $form = $this->createForm(UserSignupType::class, $createUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $createUser);

            $this->eventDispatcher->dispatch('user.registration.success', $event);

            $user = User::create($createUser);

            $this->userRepository->save($user);

            $this->addFlash('success', 'user.success.creation');

            return $this->redirectToRoute('trick_list');
        }

        return $this->render('user/signup.html.twig', [
            'userSignup' => $form->createView(),
        ]);
    }
}
