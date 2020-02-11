<?php


namespace App\DataFixtures;


use App\Entity\ProductOrder;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory;
use Faker\Generator;
class OrderFixtures extends Fixture implements FixtureGroupInterface
{

    /** @var ObjectManager */
    private $manager;
    /** @var Generator */
    protected $faker;
    /**
     * @inheritDoc
     */


    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $this->createMany(10, 'second', function($i) {
            $order = new ProductOrder();
            $order->setUser($this->faker->randomElement($this->manager->getRepository(User::class)->findAll()));
            $order->addProduct($this->faker->randomElement($this->manager->getRepository(Product::class)->findAll()));
            $order->setCreatedAt($this->faker->dateTime);
            $order->setIsComplete(false);
            return $order;
        });
        $this->manager->flush();
    }
    protected function createMany(int $count, string $groupName, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = $factory($i);
            if (null === $entity) {
                throw new \LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }
            $this->manager->persist($entity);
            // store for usage later as groupName_#COUNT#
            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }

    /**
     * @inheritDoc
     */
    public static function getGroups(): array
    {
        return ['second'];
    }
}