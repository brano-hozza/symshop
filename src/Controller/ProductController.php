<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @Route("/products", name="products")
     * @param Request $request
     * @param ProductRepository $repository
     * @return Response
     */
    public function show(Request $request, ProductRepository $repository)
    {
        $title = "Bshop";
        $announce = "Welcome to bshop";
        //dd($request->get('min_price'));
        $products = $repository->getByFilter($request->get('type'), $request->get('brand'),$request->get('size'),[$request->get('min_price'),$request->get('max_price')]);
        return $this->render('/pages/products.html.twig', [
            'title' => $title,
            'announce' => $announce,
            'products' => $products,
            'sizes' => $repository->getFilterOf("size"),
            'brands' => $repository->getFilterOf("brand"),
            'types' => $repository->getFilterOf("type"),
            'prices' => $repository->getFilterOf("price")
        ]);
    }

    public function create()
    {

    }
}