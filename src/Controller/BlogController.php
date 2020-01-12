<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/blog", name="blog")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $online = $this->session->get("is_online",false);

        return $this->render('/pages/index.html.twig',[
            'title' => $title,
            'announce' => $announce,
            'online' => $online
        ]);
    }
}