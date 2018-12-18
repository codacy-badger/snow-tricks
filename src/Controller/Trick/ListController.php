<?php

namespace App\Controller\Trick;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
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
     * @Route("/all-tricks/{page}", name="trick_list")
     */
    public function index(int $page = 1): Response
    {
        $tricks = $this->trickRepository->findAllSortAndPaginate($page);

        $nbPages = intval(ceil($tricks->count() / 20));

        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks,
            'nbPages' => $nbPages,
            'page' => $page
        ]);
    }
}
