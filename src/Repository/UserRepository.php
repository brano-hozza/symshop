<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByFilter(array $filter)
    {
        $role = "[";
        if ($filter["admin"] == "true"){
            $role= "ROLE_ADMIN";
        }
        $qb = $this->createQueryBuilder("u");
        return $qb
            ->andWhere("u.username LIKE :username")
            ->setParameter("username", "%".$filter["username"]."%")
            ->andWhere("u.first_name LIKE :firstName")
            ->setParameter("firstName", "%".$filter["firstName"]."%")
            ->andWhere("u.last_name LIKE :lastName")
            ->setParameter("lastName", "%".$filter["lastName"]."%")
            ->andWhere("u.email LIKE :email")
            ->setParameter("email", "%".$filter["email"]."%")
            ->andWhere("u.city LIKE :city")
            ->setParameter("city", "%".$filter["city"]."%")
            ->orWhere("u.city IS NULL")
            ->andWhere("u.country LIKE :country")
            ->setParameter("country", "%".$filter["country"]."%")
            ->orWhere("u.country IS NULL")
            ->andWhere("u.street LIKE :street")
            ->setParameter("street", "%".$filter["street"]."%")
            ->orWhere("u.street IS NULL")
            ->andWhere("u.postal LIKE :postal")
            ->setParameter("postal", "%".$filter["postal"]."%")
            ->orWhere("u.postal IS NULL")
            ->andWhere("u.phone_number LIKE :phone_number")
            ->setParameter("phone_number", "%".$filter["phone_number"]."%")
            ->orWhere("u.phone_number IS NULL")
            ->andWhere("u.roles LIKE :role")
            ->setParameter("role", "%".$role."%")
            ->andWhere("u.active = ". ($filter["active"]==true?"true":"false"))
            ->orderBy("u.id")
            ->getQuery()
            ->getResult();
    }

}
