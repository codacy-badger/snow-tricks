<?php

namespace App\Twig;

use App\Model\Entity\Video;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EmbeddedVideoExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter(
                'embedded_video',
                [$this, 'embed'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }

    public function embed(\Twig_Environment $twig, Video $video)
    {
        return $twig->render('video/'.$video->getPlatform().'.html.twig',
            [
                'code' => $video->getVideoCode(),
            ]);
    }
}
