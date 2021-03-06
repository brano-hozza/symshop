<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserInfoFormType;
use App\Repository\ProductOrderRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/profile", name="user_profile")
     * @param ProductOrderRepository $orderRepository
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function index(ProductOrderRepository $orderRepository){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var $user User
         */
        $user = $this->getUser();
        if ($user){
            if(!is_null($user)) {
                $orders = $orderRepository->findBy(["user" => $user]);
                //dump($orders);
                return $this->render('user/profile.html.twig', [
                    'title' => $title,
                    'announce' => $announce,
                    'user' => $user,
                    'orders' => $orders
                ]);
            }else{
                throw new Exception("User wasn't found");
            }
        }else{
            return $this->redirectToRoute('user_login');
        }
    }

    /**
     * @Route("/user/edit", name="user_edit")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function edit(Request $request){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if ($user){
            if(!is_null($user)) {
                $form = $this->createForm(UserInfoFormType::class, $user);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute("user_profile");
                }
                return $this->render('user/edit.html.twig', [
                    'title' => $title,
                    'announce' => $announce,
                    'form' => $form->createView()
                ]);
            }else{
                throw new Exception("User wasn't found");
            }
        }else{
            return $this->redirectToRoute('user_login');
        }
    }
}