<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Entity\User;
use App\Repository\ProductOrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/admin/edit_user/{user}", name="admin_edit_user")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit_user(User $user, Request $request)
    {
        if ($user == null) {
            return $this->redirectToRoute('index');
        }
        $user->setUsername($request->get("username"));
        $user->setFirstName($request->get("firstName"));
        $user->setLastName($request->get("lastName"));
        $user->setEmail($request->get("email"));
        /**
         * array roles
         */
        $roles = $user->getRoles();
        if($request->get("isAdmin") == "on" && !in_array("ROLE_ADMIN", $roles)){
            array_push($roles, "ROLE_ADMIN");
        }
        else if($request->get("isAdmin") == null){
            $key = array_search("ROLE_ADMIN", $roles);
            if ($key !== false) {
                unset($roles[$key]);
            }
        }

        $user->setRoles($roles);
        dump($user);
        dump($request->get("isAdmin"));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        return $this->redirectToRoute('admin');

    }
}
