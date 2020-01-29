<?php

namespace App\Controller;

use App\Repository\ProductOrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductOrderController extends AbstractController
{
    /**
     * @Route("/order/create", name="order_create")
     * @param Request $request
     * @param ProductRepository $prodRepo
     * @param ProductOrderRepository $poRepo
     * @return RedirectResponse|void
     */
    public function index(Request $request, ProductRepository $prodRepo, ProductOrderRepository $poRepo)
    {
        if(!$this->getUser()){
            return $this->redirectToRoute("user_login");
        }
        else if(!$request->get("id")){
            return $this->redirectToRoute("products");
        }
        else{
            $amount = $request->get("amount")?$request->get("amount"):1;
            dump($amount);
            $id = $request->get("id");
            $product = $prodRepo->findOneBy(["id"=>$id]);
            for ($i = 0; $i < $amount; $i++){
                $poRepo->addNew($product, $this->getUser());
            }
            return $this->redirectToRoute("user_profile");
        }
    }
}
