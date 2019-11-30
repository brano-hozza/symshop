<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        return $this->render('/pages/index.html.twig',[
            'title' => $title,
            'announce' => $announce
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        return $this->render('/pages/index.html.twig',[
            'title' => $title,
            'announce' => $announce
        ]);
    }
}