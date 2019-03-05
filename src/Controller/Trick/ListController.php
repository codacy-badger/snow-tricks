<?php

namespace App\Controller\Trick;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    const MAX_TRICKS_PER_PAGE = 4;

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    /**
     * @Route("/{page}", name="homepage", defaults={"page"=1})
     */
    public function index(int $page): Response
    {
        $tricks = $this->trickRepository->findAllSortAndPaginate($page, self::MAX_TRICKS_PER_PAGE);

        $nbPages = intval(ceil($tricks->count() / self::MAX_TRICKS_PER_PAGE));

        return $this->render('trick/index.html.twig', [
            'tricks' => $tricks,
            'nbPages' => $nbPages,
            'page' => $page,
        ]);
    }
}
