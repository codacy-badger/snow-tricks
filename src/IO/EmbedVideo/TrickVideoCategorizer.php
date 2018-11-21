<?php


namespace App\IO\EmbedVideo;


use Symfony\Component\Config\Definition\Exception\Exception;

class TrickVideoCategorizer
{

    CONST RECOGNIZED_PLATFORM = ['youtube', 'youtu.be', 'dailymotion', 'dai.ly', 'vimeo'];
    CONST SEPARATOR = ' ';

    public function getCode($hyperlink): string
    {
        if (!$this->isRecognizedPlatform($hyperlink)) {
            throw new Exception("Not recognized video");
        }

        return substr(strrchr($hyperlink, '/'), 1);
    }

    public function getPlatformType($hyperlink): string
    {
        if (!$this->isRecognizedPlatform($hyperlink)) {
            throw new Exception("Not recognized video");
        }

        if (strpos($hyperlink, 'youtu')) {
            return 'youtube';
        }

        if (strpos($hyperlink, 'dai')) {
            return 'dailymotion';
        }

        return 'vimeo';
    }

    private function isRecognizedPlatform(string $hyperlink): bool
    {
        foreach (self::RECOGNIZED_PLATFORM as $knownPlatform) {
            if (strpos($hyperlink, $knownPlatform) !== false) {
                return true;
            }
        }
        
        return false;
    }

    public function getHyperlinkArray(string $linksString): array
    {
        return explode(self::SEPARATOR, $linksString);
    }
}
