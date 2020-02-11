<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            AppFixtures::class,
            OrderFixtures::class
        );
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
    }
}