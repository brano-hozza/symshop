<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $productRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->productRepository = $entityManager->getRepository(Product::class);
    }

    /**
     * @Route("/products", name="products")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        return $this->render('/pages/products.html.twig',[
            'title' => $title,
            'announce' => $announce
        ]);
    }
    public function create(){

    }


    /**
     * @Route("/products/filter", name="filter_products")
     * @param Request $request
     * @return Response
     */
    public function filter_products(Request $request){
        $criteria = new Criteria();
        $criteria = $criteria->where(Criteria::expr()->gte("price", $request->get("min_price")))->andWhere(Criteria::expr()->lte("price",$request->get("max_price")));
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy( $criteria, "price");
        return new Response(json_encode($products));
    }
}