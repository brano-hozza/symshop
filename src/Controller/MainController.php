<?php


namespace App\Controller;


use App\Repository\ProductRepository;
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
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        return $this->render('main/index.html.twig',[
            'products' => $repository->findInRange(0,2),
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
        return $this->render('main/contact.html.twig',[
            'title' => $title,
            'announce' => $announce
        ]);
    }
}