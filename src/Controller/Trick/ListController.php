<?php

namespace App\Controller\Trick;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
<<<<<<< HEAD
    const MAX_TRICKS_PER_PAGE = 10;
=======
    const MAX_TRICKS_PER_PAGE = 4;
>>>>>>> add on top arrow

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    public function __construct(TrickRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    /**
<<<<<<< HEAD
     * @Route("/all-tricks/{page}", name="trick_list", defaults={"page"=1})
=======
     * @Route("/", name="homepage")
     */
    public function redirectHomepage(): Response
    {
        return $this->redirectToRoute('trick_list');
    }

    /**
     * @Route("/all-tricks/{page}", name="trick_list")
>>>>>>> add on top arrow
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
