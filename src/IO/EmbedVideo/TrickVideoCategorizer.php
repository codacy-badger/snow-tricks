<?php


namespace App\IO\EmbedVideo;


use App\Model\DTO\Video\AddVideoLinkDTO;
use Symfony\Component\Config\Definition\Exception\Exception;

class TrickVideoCategorizer
{

    public function getPlatformCode(AddVideoLinkDTO $videoLinkDTO): ?array
    {
        $hyperlink = $videoLinkDTO->getLink();

        if(strpos($hyperlink, 'youtu.be'))
        {
            $code = substr(strrchr($hyperlink, '/'), 1);
            return ['youtube', $code];
        }
        if(strpos($hyperlink, 'youtube'))
        {
            $code = substr(strrchr($hyperlink, '='), 1);
            return ['youtube', $code];
        }
        if(strpos($hyperlink, 'dai.ly'))
        {
            $code = substr(strrchr($hyperlink, '/'), 1);
            return ['dailymotion', $code];
        }
        if(strpos($hyperlink, 'dailymotion'))
        {
            $code = substr(strrchr($hyperlink, '/'), 1);
            return ['dailymotion', $code];
        }
        if(strpos($hyperlink, 'vimeo'))
        {
            $code = substr(strrchr($hyperlink, '/'), 1);
            return ['vimeo', $code];
        }

        throw new Exception ("Not recognized platform");
    }

}
