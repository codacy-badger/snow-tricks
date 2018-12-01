<?php

namespace App\Controller\Trick;

use App\Model\Entity\Trick;
use App\Model\Entity\Video;
use App\Repository\TrickRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrickVideoRemovingController extends AbstractController
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
     * @IsGranted("ROLE_USER")
     * @Route("/trick/{slug}/video/{id}/delete", name="trick_remove_video")
     * @ParamConverter("trick", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("video", options={"mapping": {"id": "id"}})
     */
    public function removeVideo(Trick $trick, Video $video)
    {
        $trick->removeVideo($video);

        $this->trickRepository->save($trick);

        $this->addFlash('success', 'video.trick.success.deletion');

        return $this->redirectToRoute('trick_edit', [
            'slug' => $trick->getSlug(),
        ]);
    }
}
