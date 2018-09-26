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

    public function trickName()
    {
        return self::randomElement(self::TRICK_NAME_PROVIDER);
    }
}
