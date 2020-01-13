<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="index")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $online = $this->session->get("is_online");
        if($online == null){
            $online = false;
        }
        return $this->render('/pages/index.html.twig',[
            'title' => $title,
            'announce' => $announce,
            'online' => $online
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $online = $this->session->get("is_online");
        return $this->render('/pages/index.html.twig',[
            'title' => $title,
            'announce' => $announce,
            'online' => $online
        ]);
    }
}