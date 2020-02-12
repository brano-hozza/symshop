<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\User;
use App\Repository\ProductOrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'title' => 'B-SHOP',
            'announce' => 'nahaha',
            'admin' => true,
        ]);
    }

    /**
     * @Route("/admin/order", name="admin_order")
     * @param ProductOrderRepository $repository
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function order(ProductOrderRepository $repository, Request $request)
    {
        $complete = "false";
        if( $request->get('complete', '') == "on"){
            $complete = "true";
        }
        $filter = [
            'product'=>$request->get('product', ''),
            'user' => $request->get('user', ''),
            'price' => $request->get('price', ''),
            'date' =>$request->get('created_at', ''),
            'complete' => $complete,

        ];
        $orders = $repository->findByFilter($filter);

        return $this->render('admin/order.html.twig', [
            'title' => "BSHOP",
            'announce' => 'nahahahahha',
            'admin' => true,
            'product' => $request->get('product', ''),
            'user' => $request->get('user', ''),
            'price' => $request->get('price', ''),
            'date' =>$request->get('created_at', ''),
            'complete' => $request->get('complete', ''),
            'orders' => $orders
        ]);

    }

    /**
     * @Route("/admin/user", name="admin_user")
     * @param UserRepository $repository
     * @return RedirectResponse|Response
     */
    public function user(UserRepository $repository, Request $request)
    {
        $admin = "false";
        if( $request->get('admin', '') == "on"){
            $admin = "true";
        }
        $banned = "false";
        if( $request->get('banned', '') == "on"){
            $banned = "true";
        }
        $filter = [
            'username'=>$request->get('username', ''),
            'firstName' => $request->get('firstName', ''),
            'lastName' => $request->get('lastName', ''),
            'email' =>$request->get('email', ''),
            'city' =>$request->get('city', ''),
            'country' =>$request->get('country', ''),
            'street' =>$request->get('street', ''),
            'postal' =>$request->get('postal', ''),
            'phone_number' =>$request->get('phone_number', ''),
            'admin' => $admin,
            'active'=> $banned == "false"

        ];
        $users = $repository->findByFilter($filter);
        return $this->render('admin/user.html.twig', [
            'title' => "BSHOP",
            'announce' => 'nahahahahha',
            'admin' => true,
            'users' => $users,
            'username'=>$request->get('username', ''),
            'firstName' => $request->get('firstName', ''),
            'lastName' => $request->get('lastName', ''),
            'email' =>$request->get('email', ''),
            'city' =>$request->get('city', ''),
            'country' =>$request->get('country', ''),
            'street' =>$request->get('street', ''),
            'postal' =>$request->get('postal', ''),
            'phone_number' =>$request->get('phone_number', ''),
            'is_admin' => $admin,
            'banned'=> $banned
        ]);

    }

    /**
     * @Route("/admin/product", name="admin_product")
     * @param ProductRepository $repository
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function product(ProductRepository $repository, Request $request)
    {
        $reserved = "false";
        if( $request->get('reserved', '') == "on"){
            $reserved = "true";
        }
        $filter = [
            'name'=>$request->get('name', ''),
            'brand' => $request->get('brand', ''),
            'description' => $request->get('description', ''),
            'price' =>$request->get('price', ''),
            'pcs' =>$request->get('pcs', ''),
            'size' =>$request->get('size', ''),
            'image' =>$request->get('image', ''),
            'reserved' => $reserved,

        ];
        $products = $repository->findByFilter($filter);
        return $this->render('admin/product.html.twig', [
            'title' => "BSHOP",
            'announce' => 'nahahahahha',
            'admin' => true,
            'products' => $products,
            'name'=>$request->get('name', ''),
            'brand' => $request->get('brand', ''),
            'description' => $request->get('description', ''),
            'price' =>$request->get('price', ''),
            'pcs' =>$request->get('pcs', ''),
            'size' =>$request->get('size', ''),
            'image' =>$request->get('image', ''),
            'reserved' => $reserved,
        ]);

    }

    /**
     * @Route("/admin/user/{user}", name="admin_user_edit")
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
         * @var array roles
         */
        $roles = $user->getRoles();
        if ($request->get("isAdmin") == "on" && !in_array("ROLE_ADMIN", $roles)) {
            array_push($roles, "ROLE_ADMIN");
        } else if ($request->get("isAdmin") == null) {
            $key = array_search("ROLE_ADMIN", $roles);
            if ($key !== false) {
                unset($roles[$key]);
            }
        }
        if ($request->get("banned") == "on"){
            $user->setActive(false);
        }
        else if($request->get("banned") == null){
            $user->setActive(true);
        }

        $user->setRoles($roles);
        dump($user);
        dump($request->get("isAdmin"));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        return $this->redirectToRoute('admin_user');

    }

    /**
     * @Route("/admin/order/{order}", name="admin_order_edit")
     * @param ProductOrder $order
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit_order(ProductOrder $order, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($order == null) {
            return $this->redirectToRoute('index');
        }
        if (!$request->get("submit")){
            $order->removeProducts();
            $em->remove($order);
            $em->flush();
            return $this->redirectToRoute('admin_order');
        }
        $isComplete = $request->get("isComplete") == "on";
        if ($order->getIsComplete() != $isComplete) {
            $order->setIsComplete(!$order->getIsComplete());
        }
        $em->persist($order);
        $em->flush();


        return $this->redirectToRoute('admin_order');

    }

    /**
     * @Route("/admin/product/{product}", name="admin_product_edit")
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit_product(Product $product, Request $request)
    {
        if ($product == null) {
            return $this->redirectToRoute('index');
        }
        $is_reserved = $request->get("reserved") == "on";
        $product->setName($request->get("name"));
        $product->setBrand($request->get("brand"));
        $product->setDescription($request->get("description"));
        $product->setPcs($request->get("pcs"));
        $product->setPrice($request->get("price"));
        $product->setSize($request->get("size"));
        $file = $request->files->get("image");
        $newFileName = $product->getName() . '-' . uniqid() . '.' . $file->guessExtension();
        dump($newFileName);
        try {
            $file->move($this->getParameter('img_directory'), $newFileName);
        } catch (FileException $e) {
            throw $e;
        }
        $product->setImg($newFileName);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();


        return $this->redirectToRoute('admin_product');

    }
}
