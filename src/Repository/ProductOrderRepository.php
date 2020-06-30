<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductOrder[]    findAll()
 * @method ProductOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOrder::class);
    }

    public function findByFilter($filter){
        $qb = $this->createQueryBuilder("o");
        return $qb
            ->leftJoin("o.products", "p")
            ->leftJoin("o.user", "u")
            ->andWhere("u.username LIKE :username")
            ->setParameter("username", "%".$filter["user"]."%")
            ->andWhere("p.name LIKE :product")
            ->setParameter("product", "%".$filter["product"]."%")
            ->orWhere("p.brand LIKE :brand")
            ->setParameter("brand", "%".$filter["product"]."%")
            ->andWhere("p.price LIKE :price")
            ->setParameter("price", "%".$filter["price"]."%")
            ->andWhere("o.is_complete = ".$filter["complete"])
            ->orderBy("o.created_at",$filter["date"])
            ->getQuery()
            ->getResult();

    }

    public function addNew(Product $product, User $user)
    {
        $entityManager = $this->getEntityManager();
        $order = new ProductOrder();
        $order->setUser($user);
        $order->addProduct($product);
        $order->setCreatedAt(new \DateTime());
        $order->setIsComplete(false);
        dump($order);
        $entityManager->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

    }
}
