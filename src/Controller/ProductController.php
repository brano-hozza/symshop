<?php


namespace App\Controller;


use App\Entity\Product;
use App\Entity\User;
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
    public function index(Request $request, ProductRepository $repository)
    {
        $title = "Bshop";
        $announce = "Welcome to bshop";
        //dd($request->get('min_price'));
        $type = $request->get('type');
        $brand = $request->get('brand');
        $size = $request->get('size');
        $price = array($request->get('min_price'), $request->get('max_price'));
        $sort_by = $request->get('sort_by');
        $page = $request->get('page');
        $products = $repository->getByFilter($type, $brand, $size, $price, $sort_by, $page);


        /**
         * @var $product Product
         * @var $products Product[]
         *
         */
        foreach ($products as $id => $product){
            if(strlen($product->getDescription()) > 20){
                $products[$id]->setDescription(str_split($product->getDescription(), 20)[0]."...");
            };
        }

        return $this->render('product/index.html.twig', [
            'title' => $title,
            'announce' => $announce,
            'products' => $products,
            'sizes' => $repository->getFilterOf("size"),
            'old_size' => $size?$size:array(""),
            'brands' => $repository->getFilterOf("brand"),
            'old_brand' => $brand?$brand:array(""),
            'types' => $repository->getFilterOf("type"),
            'old_type' => $type?$type:array(""),
            'prices' => $repository->getFilterOf("price"),
            'old_price' => $price?$price:array(null, null),
            'page' => $page?$page:1,
            'old_sort' =>$sort_by
        ]);
    }

    /**
     * @Route("/products/{product}", name="products_detail")
     * @param Request $request
     * @param Product $product
     * @param ProductRepository $repository
     * @return Response
     */
    public function detail(Request $request, Product $product, ProductRepository $repository)
    {
        if($product == null){
            return $this->redirectToRoute('products');
        }
        $can_shop = true;
        /**
         * @var User $user
         */
        if ($user = $this->getUser()){
            if ($user->getCity() == "" or
                $user->getCountry() == "" or
                $user->getStreet() == "" or
                $user->getPostal() == "" or
                $user->getPhoneNumber() == ""){
                $can_shop = false;

            }
        }else{
            $can_shop = false;
        }
        return $this->render('product/detail.html.twig',[
            'title' => "Bshop",
            'announce' =>  "Welcome to bshop",
            'product' => $product,
            'can_shop' => $can_shop
        ]);
    }
}