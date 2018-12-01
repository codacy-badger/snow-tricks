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

        $objectSet = $loader->loadFiles(
            [
                __DIR__.'/fixtures/users.yaml',
                __DIR__.'/fixtures/trickgroups.yaml',
                __DIR__.'/fixtures/tricks.yaml',
                __DIR__.'/fixtures/messages.yaml',
                __DIR__.'/fixtures/videos.yaml'
            ]
        );

        foreach ($objectSet->getObjects() as $object)
        {
            $manager->persist($object);
        }

        $manager->flush();
    }
}
