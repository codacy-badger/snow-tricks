<?php

namespace App\Twig;

use App\Model\Entity\Video;
use Symfony\Component\Validator\Constraints\Date;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AgoDatetimeExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter(
                'ago_datetime', [$this, 'ago']
            ),
        ];
    }

    public function ago(\DateTime $dateTime): string
    {
        $diffFromNow = date_diff($dateTime, new \DateTime());

        if ($diffFromNow->y > 0) {

            if ($diffFromNow->m == 0) {

                return "il y a " . $diffFromNow->y . " ans.";
            }
            return "il y a " . $diffFromNow->y . " ans et " . $diffFromNow->m . " mois.";
        }

        if ($diffFromNow->m > 0) {

            if ($diffFromNow->d == 0) {

                return "il y a " . $diffFromNow->m . " mois.";
            }
            return "il y a " . $diffFromNow->m . " mois et " . $diffFromNow->m . " jours.";
        }

        if ($diffFromNow->d > 0) {

            if ($diffFromNow->h == 0) {

                return "il y a " . $diffFromNow->d . " jours.";
            }
            return "il y a " . $diffFromNow->d . " jours et " . $diffFromNow->h . " heures.";
        }

        if ($diffFromNow->h > 0) {

            return "il y a " . $diffFromNow->h . " heures.";
        }

        if ($diffFromNow->i > 0) {

            return "il y a " . $diffFromNow->i . " minutes.";
        }

        if ($diffFromNow->s > 0) {

            return "il y a " . $diffFromNow->s . " secondes.";
        }

        return "à l'instant";
    }
}
