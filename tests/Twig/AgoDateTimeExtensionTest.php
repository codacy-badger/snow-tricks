<?php

namespace App\Tests\Twig;


use App\Twig\AgoDatetimeExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class AgoDateTimeExtensionTest extends TestCase
{
    public function testAgo(TranslatorInterface $translator)
    {

        $date = new \DateTime('2019-01-01 00:00:01');

        $stringDateNow = '2019-01-09 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame("mon-nouveau-super-trick-e-c-oh-yeahh--cae", $agoDate);
    }
}
