<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        return $this->render('/pages/index.html.twig',[
            'title' => $title,
            'announce' => $announce
        ]);
    }

}