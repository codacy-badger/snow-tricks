<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
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
     * @Route("/trick/{slug}", name="trick_show")
     */
    public function show(string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if (!$trick) {
            throw $this->createNotFoundException(sprintf('No "%s" trick found', $slug));
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }
}
