<?php

namespace App\Controller;

use App\Model\Entity\Trick;
use App\Form\TrickFormType;
use App\Repository\TrickGroupRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Slugger\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var TrickGroupRepository
     */
    private $trickGroupRepository;
    /**
     * @var Slugger
     */
    private $slugger;

    public function __construct(
        TrickRepository $trickRepository,
        UserRepository $userRepository,
        TrickGroupRepository $trickGroupRepository,
        EntityManagerInterface $entityManager,
        Slugger $slugger
    ) {
        $this->trickRepository = $trickRepository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->trickGroupRepository = $trickGroupRepository;
        $this->slugger = $slugger;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $tricks = $this->trickRepository->findAll();

        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/trick/show/{slug}", name="trick_show")
     */
    public function show(Trick $trick): Response
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }

    /**
     * @Route("/trick/create", name="trick_create")
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request): Response
    {
        $trick = new Trick();

        $trickForm = $this->createForm(TrickFormType::class, $trick);

        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick = $trickForm->getData();

            $trick->setUser($this->getUser());
            $trick->setCreatedAt(new \DateTime('now'));
            $trick->setUpdatedAt(new \DateTime('now'));
            $trick->setSlug($this->slugger->slugify($trick->getName()));

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            $this->addFlash('success', 'You just created a new trick!');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/new.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
    }

    /**
     * @Route("/trick/edit/{slug}", name="trick_edit")
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Trick $trick): Response
    {
        $trickForm = $this->createForm(TrickFormType::class, $trick);

        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $trick = $trickForm->getData();

            $trick->setUpdatedAt(new \DateTime('now'));

            $this->entityManager->persist($trick);
            $this->entityManager->flush();

            $this->addFlash('success', 'You just modify '.$trick->getName().' trick!');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
    }

    /**
     * @Route("/trick/delete/{slug}", name="trick_delete")
     */
    public function delete(Trick $trick): Response
    {
        $this->entityManager->remove($trick);

        $this->addFlash('success', 'You just delete '.$trick->getName().' trick!');

        return $this->redirectToRoute('homepage');
    }
}
