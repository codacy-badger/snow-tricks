<?php

namespace App\Slugger;

class Slugger
{
    public static function slugify(string $name): string
    {
        $slug = '';
        $slugArray = explode(' ', $name);

        foreach ($slugArray as $word) {
            $slug .= $word.'-';
        }
        $slug = substr($slug, 0, strlen($slug) - 1);

        return $slug;
    }
}
