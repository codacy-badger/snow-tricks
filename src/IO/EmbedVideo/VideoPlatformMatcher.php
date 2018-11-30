<?php

namespace App\IO\EmbedVideo;

use App\Model\DTO\Video\AddVideoLinkDTO;
use App\Model\ValueObject\VideoMeta;
use Symfony\Component\Config\Definition\Exception\Exception;

class VideoPlatformMatcher
{
    const YOUTUBE_SHORTENED_DOMAIN = 'yout.be';
    const YOUTUBE_DOMAIN = 'youtube';
    const DAILYMOTION_SHORTENED_DOMAIN = 'dai.ly';
    const DAILYMOTION_DOMAIN = 'dailymotion';
    const VIMEO_DOMAIN = 'vimeo';

    public static function match(AddVideoLinkDTO $videoLinkDTO): VideoMeta
    {
        $hyperlink = $videoLinkDTO->getLink();

        if (strpos($hyperlink, self::YOUTUBE_SHORTENED_DOMAIN)) {
            $code = substr(strrchr($hyperlink, '/'), 1);

            return new VideoMeta($code, self::YOUTUBE_DOMAIN);
        }
        if (strpos($hyperlink, self::YOUTUBE_DOMAIN)) {
            $code = substr(strrchr($hyperlink, '='), 1);

            return new VideoMeta($code, self::YOUTUBE_DOMAIN);
        }
        if (strpos($hyperlink, self::DAILYMOTION_SHORTENED_DOMAIN)) {
            $code = substr(strrchr($hyperlink, '/'), 1);

            return new VideoMeta($code, self::DAILYMOTION_DOMAIN);
        }
        if (strpos($hyperlink, self::DAILYMOTION_DOMAIN)) {
            $code = substr(strrchr($hyperlink, '/'), 1);

            return new VideoMeta($code, self::DAILYMOTION_DOMAIN);
        }
        if (strpos($hyperlink, self::VIMEO_DOMAIN)) {
            $code = substr(strrchr($hyperlink, '/'), 1);

            return new VideoMeta($code, self::VIMEO_DOMAIN);
        }

        throw new Exception('Not recognized platform');
    }
}
