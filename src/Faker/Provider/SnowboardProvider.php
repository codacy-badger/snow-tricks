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

    public function trickName(): string
    {
        return self::randomElement( self::TRICK_NAME_PROVIDER);
    }

    public function trickSlug(): string
    {
        return self::randomElement(self::TRICK_SLUG_PROVIDER);
    }
}
