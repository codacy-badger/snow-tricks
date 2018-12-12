<?php

namespace App\Utils;

class Slugger
{
    public static function slugify(string $name): string
    {
        $slug = '';
        $slugArray = explode(' ', $name);

        foreach ($slugArray as $word) {
            $slug .= $word.'-';
        }
        $slug = strtolower(substr($slug, 0, strlen($slug) - 1));

        return $slug;
    }
}
