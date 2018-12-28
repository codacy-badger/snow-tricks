<?php

namespace App\Twig;

use Symfony\Component\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AgoDatetimeExtension extends AbstractExtension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
            if ($diffFromNow->y == 1) {
                return $this->translator->trans(
                    'ago.one_year',
                    ['nbYears' => $diffFromNow->y],
                    'date');
            }

            return $this->translator->trans(
                'ago.years',
                ['nbYears' => $diffFromNow->y],
                'date');
        }

        if ($diffFromNow->m > 0) {
            if ($diffFromNow->m == 1) {
                return $this->translator->trans(
                    'ago.one_month',
                    [],
                    'date');
            }

            return $this->translator->trans(
                'ago.months',
                ['nbMonth' => $diffFromNow->m],
                'date');
        }

        if ($diffFromNow->d > 0) {
            if ($diffFromNow->d == 1) {
                return $this->translator->trans(
                    'ago.one_day',
                    [],
                    'date');
            }

            return $this->translator->trans(
                'ago.days',
                ['nbDays' => $diffFromNow->d],
                'date');
        }

        if ($diffFromNow->h > 0) {
            if ($diffFromNow->h == 1) {
                return $this->translator->trans(
                    'ago.one_hour',
                    [],
                    'date');
            }

            return $this->translator->trans(
                'ago.hours',
                ['nbHours' => $diffFromNow->h],
                'date');
        }

        if ($diffFromNow->i > 0) {
            if ($diffFromNow->i == 1) {
                return $this->translator->trans(
                    'ago.one_minute',
                    [],
                    'date');
            }

            return $this->translator->trans(
                'ago.minutes',
                ['nbMinutes' => $diffFromNow->i],
                'date');
        }

        if ($diffFromNow->s > 0) {
            if ($diffFromNow->s == 1) {
                return $this->translator->trans(
                    'ago.one_seconds',
                    [],
                    'date');
            }

            return $this->translator->trans(
                'ago.seconds',
                ['nbSeconds' => $diffFromNow->s],
                'date');
        }

        return "à l'instant";
    }
}
