<?php

namespace App\Model\ValueObject;

class VideoMeta
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $platform;

    public function __construct(string $code, string $platform)
    {
        $this->code = $code;
        $this->platform = $platform;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }
}
