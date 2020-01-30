<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Form\BlogCreateType;
use App\Repository\BlogRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/blog", name="blog")
     * @param Request $request
     * @param BlogRepository $repository
     * @return Response
     */
    public function index(Request $request, BlogRepository $repository){
        $page = $request->get("next_page") ?  $request->get("next_page")  : 1;
        $response = null;
        if ($phrase = $request->get("search_phrase")){
            $response = $repository->getBySearch($phrase, $page);
        }else{
            $response = $repository->findBy([], ["created_at"=>"DESC"], 20, ($page-1)*20);
        }

        $title = "Bshop";
        $announce = "Welcome to bshop";
        dump($response);

        return $this->render('blog/index.html.twig',[
            'title' => $title,
            'announce' => $announce,
            'page' => $page,
            'blogs' => $response,
            'phrase' => $request->get("search_phrase") ? $request->get("search_phrase") : ""
        ]);
    }

    /**
     * @Route("/blog/create", name="blog_create")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request): Response
    {
        if($this->getUser()) {
            $blog = new Blog();
            $form = $this->createForm(BlogCreateType::class, $blog);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $blog->setUser($this->getUser());
                $blog->setCreatedAt(new \DateTime());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($blog);
                $entityManager->flush();

                // do anything else you need here, like send an email

                return $this->redirectToRoute('blog');
            }

            return $this->render('blog/create.html.twig', [
                'form' => $form->createView(),
                "title" => "Bshop",
                "announce" => "nahahah"
            ]);
        }else{
            return $this->redirectToRoute('blog');
        }
    }
}