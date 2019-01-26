<?php

namespace App\Tests\Utils;


use App\Utils\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlugify()
    {
        $slug = Slugger::slugify('mon nouveau super trick! ?_è-ç_ Oh yeahh !! çàè_"');

        $this->assertSame("mon-nouveau-super-trick-e-c-oh-yeahh--cae", $slug);
    }
}
