<?php

namespace App\Tests\Twig;

use App\Twig\AgoDatetimeExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AgoDateTimeExtensionTest extends KernelTestCase
{
    private $translator;

    protected function setup()
    {
        self::bootKernel();

        $this->translator = self::$container->get('translator');
    }

    public function testYears()
    {
        $date = new \DateTime('2021-01-01 00:00:01');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame('Il y a 2 ans', $agoDate);
    }

    public function testMonths()
    {
        $date = new \DateTime('2019-03-15 00:00:01');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame('Il y a 2 mois', $agoDate);
    }

    public function testDays()
    {
        $date = new \DateTime('2019-01-03 00:00:01');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame('Il y a 2 jours', $agoDate);
    }

    public function testHours()
    {
        $date = new \DateTime('2019-01-01 05:00:01');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame('Il y a 5 heures', $agoDate);
    }

    public function testMinutes()
    {
        $date = new \DateTime('2019-01-01 00:05:01');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame('Il y a 5 minutes', $agoDate);
    }

    public function testSeconds()
    {
        $date = new \DateTime('2019-01-01 00:00:18');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame('Il y a 17 secondes', $agoDate);
    }

    public function testNow()
    {
        $date = new \DateTime('2019-01-01 00:00:01');

        $stringDateNow = '2019-01-01 00:00:01';

        $AgoDateTimeExtension = new AgoDatetimeExtension($this->translator);

        $agoDate = $AgoDateTimeExtension->ago($date, $stringDateNow);

        $this->assertSame("à l'instant", $agoDate);
    }
}
