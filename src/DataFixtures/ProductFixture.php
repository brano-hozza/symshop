<?php
namespace App\DataFixtures;
use App\Entity\ApiToken;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class ProductFixture extends BaseFixture
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_products', function($i) use ($manager) {
            $product = new Product();
            $product->setName($this->faker->lastName);
            $product->setDescription($this->faker->text);
            $product->setSize($this->faker->numberBetween(30,50));
            $product->setBrand($this->faker->name);
            $product->setPcs($this->faker->numberBetween(10,30));
            $product->setType($this->faker->randomElement(["Shoes", "T-Shirt", "Headgear", "Trousers"]));
            $product->setPrice($this->faker->randomFloat(2,30,300));
            return $product;
        });
        $manager->flush();
    }
}