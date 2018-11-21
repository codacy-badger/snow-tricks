<?php


namespace App\IO\EmbedVideo;


use Symfony\Component\Config\Definition\Exception\Exception;

class TrickVideoCategorizer
{

    CONST RECOGNIZED_PLATFORM = ['youtube', 'youtu.be', 'dailymotion', 'dai.ly', 'vimeo'];
    CONST SEPARATOR = [',',';',' '];

    public function getCode($hyperlink): string
    {
        if(!$this->isRecognizedPlatform($hyperlink)){
            throw new Exception("Not recognized video");
        }

        $test = strrchr($hyperlink, '/');
        dd($test);

        return substr( 1, strrchr($hyperlink, '/'));
    }

    public function getPlatformType($hyperlink): string
    {
        if(!$this->isRecognizedPlatform($hyperlink)){
            throw new Exception("Not recognized video");
        }

        if(preg_match('youtu', $hyperlink))
        {
            return 'youtube';
        }

        if(preg_match('dai', $hyperlink))
        {
            return 'dailymotion';
        }

        return 'vimeo';
    }

    private function isRecognizedPlatform(string $hyperlink): bool
    {
        foreach(self::RECOGNIZED_PLATFORM as $knownPlatform){
            if(strpos($hyperlink, $knownPlatform) !== false){
                return true;
            }
        }
    }

    public function getHyperlinkArray (string $linksString): array
    {
        $links = [];
        foreach (self::SEPARATOR as $separator)
        {
            $linksArray = explode($separator, $linksString);

            foreach ($linksArray as $link)
            {
                if(!strpos($link,' ')){
                    $links[] = $link;
                }
            }
        }

        return $links;
    }
}
