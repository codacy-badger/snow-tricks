<?php

namespace App\Faker\Provider;

use Faker\Provider\Base as BaseProvider;

final class SnowboardProvider extends BaseProvider
{
    const TRICK_NAME_PROVIDER = [
            'One-Two',
            'A B',
            'Beef Carpaccio',
            'Beef curtains',
            'Bloody Dracula',
            'Canadian Bacon',
            'Cannonball/UFO',
            'Chicken salad',
            'China Air',
            'Crail',
            'Cross-Rocket',
            'Drunk Driver',
            'Frontside grab',
            'Gorilla',
            'Japan Air',
            'Lien Air',
            'Korean Bacon',
    ];

    const TRICK_SLUG_PROVIDER = [
        'one-two',
        'a-b',
        'beef-carpaccio',
        'beef-curtains',
        'bloody-dracula',
        'canadian-Bacon',
        'cannonball-UFO',
        'chicken-salad',
        'china-Air',
        'crail',
        'cross-rocket',
        'drunk-driver',
        'frontside-grab',
        'gorilla',
        'japan-air',
        'lien-air',
        'korean -bacon',
    ];

    const TRICK_VIDEOS_PROVIDER = [
        'n0F6hSpxaFc',
        'aINlzgrOovI',
        '3_fr5l-JvTM',
        'FYQesbQXCac',
        '-27nqjI844I',
        'PZlqeg-PjC4',
        'KoHzXi7Usl8',
        'G9qlTInKbNE',
        'PePNEXh_1N4',
        'X9DIG3Ux79E',
        'K-RKP3BizWM',
    ];

    public function trickName(): string
    {
        return self::randomElement(self::TRICK_NAME_PROVIDER);
    }

    public function trickSlug(): string
    {
        return self::randomElement(self::TRICK_SLUG_PROVIDER);
    }

    public function trickVideos(): string
    {
        return self::randomElement(self::TRICK_VIDEOS_PROVIDER);
    }
}
