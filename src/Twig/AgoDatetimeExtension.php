<?php

namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
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

    public function ago(\DateTime $dateTime, string $stringDateNow = 'now'): string
    {
        $diffFromNow = date_diff($dateTime, new \DateTime($stringDateNow));

        if ($diffFromNow->y > 0) {
            return $this->translator->transChoice(
                'ago.years',
                $nbYears = $diffFromNow->y,
                ['%nbYears%' => $nbYears],
                'date'
            );
        }

        if ($diffFromNow->m > 0) {
            return $this->translator->transchoice(
                'ago.months',
                $nbMonth = $diffFromNow->m,
                ['%nbMonths%' => $nbMonth],
                'date'
            );
        }

        if ($diffFromNow->d > 7) {
            return $this->translator->transchoice(
                'ago.weeks',
                $nbWeeks = (int) ($diffFromNow->d / 7),
                ['%nbWeeks%' => $nbWeeks],
                'date'
            );
        }

        if ($diffFromNow->d > 0) {
            return $this->translator->transchoice(
                'ago.days',
                $nbDays = $diffFromNow->d,
                ['%nbDays%' => $nbDays],
                'date'
            );
        }

        if ($diffFromNow->h > 0) {
            return $this->translator->transChoice(
                'ago.hours',
                $nbHours = $diffFromNow->h,
                ['%nbHours%' => $nbHours],
                'date'
            );
        }

        if ($diffFromNow->i > 0) {
            return $this->translator->transChoice(
                'ago.minutes',
                $nbMinutes = $diffFromNow->i,
                ['%nbMinutes%' => $nbMinutes],
                'date'
            );
        }

        if ($diffFromNow->s > 0) {
            return $this->translator->transchoice(
                'ago.seconds',
                $nbSeconds = $diffFromNow->s,
                ['%nbSeconds%' => $nbSeconds],
                'date'
            );
        }

        return $this->translator->trans(
            'ago.now',
            [],
            'date'
        );
    }
}
