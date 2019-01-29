<?php

namespace App\Utils;

class Slugger
{
    public static function slugify($string)
    {
        $dict = [
            "I'm" => 'I am',
            'thier' => 'their',
            // Add your own replacements here
        ];

        return strtolower(
            preg_replace(
                ['#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'],
                ['-', ''],
                // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
                self::cleanString(
                    str_replace( // preg_replace can be used to support more complicated replacements
                        array_keys($dict),
                        array_values($dict),
                        urldecode($string)
                    )
                )
            )
        );
    }

    private static function cleanString($text)
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-',
            '/[’‘‹›‚]/u' => ' ',
            '/[“”«»„]/u' => ' ',
            '/ /' => ' ',
        ];

        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
}
