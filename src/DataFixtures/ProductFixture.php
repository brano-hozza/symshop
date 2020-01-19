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
        $this->createMany(61, 'main_products', function($i) use ($manager) {
            $product = new Product();
            $product->setName($this->faker->lastName);
            $product->setDescription($this->faker->text);
            $product->setSize($this->faker->randomFloat(1,30,50));
            $product->setBrand($this->faker->randomElement(["Adidas", "Converse", "Puma", "Jordan", "Nike", "Reebok", "Vans", "Calvin Klein", "Estos", "Balenciaga", "Gucci", "Givenchy", "Goyard"]));
            $product->setPcs($this->faker->numberBetween(10,30));
            $product->setType($this->faker->randomElement(["Shoes", "T-Shirt", "Headgear", "Trousers"]));
            $product->setPrice($this->faker->randomFloat(2,30,300));
            $product->setImg($this->faker->randomElement(["img1", "img2", "img3", "jordan1", "jordan2", "jordan_hat1", "jordan_hat2", "none"]));
            return $product;
        });
        $manager->flush();
    }
}