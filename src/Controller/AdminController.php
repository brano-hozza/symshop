<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Repository\ProductOrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param ProductRepository $productRepository
     * @param UserRepository $userRepository
     * @param ProductOrderRepository $productOrderRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository, UserRepository $userRepository, ProductOrderRepository $productOrderRepository)
    {
        $products = $productRepository->findAll();
        $users = $userRepository->findAll();
        $orders = $productOrderRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'title' => 'B-SHOP',
            'announce' => 'nahaha',
            'products' => $products,
            'users' => $users,
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/admin/edit_order/{order}", name="admin_edit_order")
     * @param ProductOrder $order
     * @return RedirectResponse|Response
     */
    public function edit_order(ProductOrder $order)
    {
        if ($order == null) {
            return $this->redirectToRoute('index');
        }
        return $this->render('admin/order_detail.twig', [
            'title' => "BSHOP",
            'announce' => 'nahahahahha',
            'order' => $order
        ]);

    }
}
