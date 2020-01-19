<?php


namespace App\Controller;


use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct()
    {
    }
    /**
     * @Route("/profile", name="profile")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /**
         * @var $user User
         */
        $user = $this->getUser();
        if ($user){
            if(!is_null($user)) {
                return $this->render('/pages/profile.html.twig', [
                    'title' => $title,
                    'announce' => $announce,
                    'user' => $user
                ]);
            }else{
                throw new \Exception("User wasn't found");
            }
        }else{
            return $this->redirectToRoute('app_login');
        }
    }

}