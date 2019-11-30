<?php
namespace App\DataFixtures;
use App\Entity\ApiToken;
use App\Entity\Blog;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserFixture extends BaseFixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function addBlog(ObjectManager $em, User $user){
        $post = new Blog();
        $post->setTitle($this->faker->name);
        $post->setCreatedAt($this->faker->dateTime);
        $post->setText($this->faker->text);
        $post->setUser($user);
        $em->persist($post);
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $i));
            $user->setUsername($this->faker->userName);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            if($this->faker->boolean) {
                $this->addBlog($manager, $user);
            }
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            return $user;
        });
        $this->createMany(3, 'admin_users', function($i) {
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
            return $user;
        });
        $manager->flush();
    }
}