<?php

namespace App\DataFixtures\ORM;

use App\Faker\Provider\SnowboardProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class LoadFixtures extends Fixture
{
    /**
     * Get fixtures from a yaml file and encode password
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();

        $faker = $loader->getFakerGenerator();
        $faker->addProvider(SnowboardProvider::class);

        $objectSet = $loader->loadFile(__DIR__.'/fixtures/users.yaml')->getObjects();

        foreach ($objectSet as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }
}
