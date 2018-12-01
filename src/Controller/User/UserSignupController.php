<?php

namespace App\Controller\User;

use App\Model\DTO\User\CreateUserDTO;
use App\Model\Entity\User;
use App\Form\User\UserSignupType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSignupController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;
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
}
