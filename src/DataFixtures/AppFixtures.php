<?php


namespace App\DataFixtures;


use App\Entity\Blog;
use App\Entity\ApiToken;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Faker\Factory;
use Faker\Generator;
class AppFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /** @var ObjectManager */
    private $manager;
    /** @var Generator */
    protected $faker;
    /**
     * @inheritDoc
     */

    public function addBlog(ObjectManager $em, User $user){
        $post = new Blog();
        $post->setTitle($this->faker->name);
        $post->setCreatedAt($this->faker->dateTime);
        $post->setText($this->faker->text);
        $post->setUser($user);
        $em->persist($post);
    }
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->createMany(61, 'main1', function($i) use ($manager) {
            $product = new Product();
            $product->setName($this->faker->lastName);
            $product->setDescription($this->faker->text);
            $product->setSize($this->faker->randomFloat(1,30,50));
            $product->setBrand($this->faker->randomElement(["Adidas", "Converse", "Puma", "Jordan", "Nike", "Reebok", "Vans", "Calvin Klein", "Estos", "Balenciaga", "Gucci", "Givenchy", "Goyard"]));
            $product->setPcs($this->faker->numberBetween(10,30));
            $product->setType($this->faker->randomElement(["Shoes", "T-Shirt", "Headgear", "Trousers"]));
            $product->setPrice($this->faker->randomFloat(2,30,300));
            $product->setImg($this->faker->randomElement(["img1.jpg", "img2.jpg", "img3.jpg", "jordan1.jpg", "jordan2.jpg", "jordan_hat1.jpg", "jordan_hat2.jpg", "none.jpg"]));
            return $product;
        });
        $manager->flush();
        $this->createMany(100, 'main2', function($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $i));
            $user->setUsername($this->faker->userName);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $user->setCity($this->faker->city);
            $user->setCountry($this->faker->country);
            $user->setPostal($this->faker->postcode);
            $user->setStreet($this->faker->streetName);
            $user->setPhoneNumber($this->faker->phoneNumber);
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            if($this->faker->boolean) {
                $this->addBlog($manager, $user);
            }
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            return $user;
        });
        $manager->flush();
        $this->createMany(10, 'main3', function($i) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@thespacebar.com', $i));
            $user->setUsername($this->faker->userName);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $user->setCity($this->faker->city);
            $user->setCountry($this->faker->country);
            $user->setPostal($this->faker->postcode);
            $user->setStreet($this->faker->streetName);
            $user->setPhoneNumber($this->faker->phoneNumber);
            return $user;
        });
        $manager->flush();
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
        return ['main1', 'main2', 'main3'];
    }
}