<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Form\BlogCreateType;
use App\Repository\BlogRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BlogController extends AbstractController
{
    protected $serializer;

    /**
     * @Route("/blog", name="blog")
     * @param Request $request
     * @param BlogRepository $repository
     * @return Response
     */
    public function index(Request $request, BlogRepository $repository)
    {

        $page = $request->get("next_page", 1);
        $response = null;
        $phrase = $request->get("search_phrase", null);
        if ($request->isXmlHttpRequest()) {
            $phrase = $request->request->get("data");
            $page = 1;
        }
        if ($phrase != null && $phrase != "") {
            $response = $repository->getBySearch($phrase, $page);
        } else {
            $response = $repository->findBy([], ["created_at" => "DESC"], 20, ($page - 1) * 20);
        }
        dump($request->isXmlHttpRequest());

        $title = "Bshop";
        $announce = "Welcome to bshop";
        if ($request->isXmlHttpRequest()) {
            $jsonResp = array();
            foreach ($response as $blog) {
                array_push($jsonResp, '<div class="blog-container">
                            <p class="blog-user">u/' . ($blog->getUser())->getUsername() . '</p>
                            <h2 class="blog-title">' . $blog->getTitle() . '</h2>
                            <p class="blog-text">' . $blog->getText() . '</p>
                            <p class="blog-date">Created On: ' . $blog->getCreatedAt()->format('Y/m/d') . '</p>
                        </div>');

            }
            return new JsonResponse($jsonResp);
        }

        return $this->render('blog/index.html.twig', [
            'title' => $title,
            'announce' => $announce,
            'page' => $page,
            'blogs' => $response,
            'phrase' => $request->get("search_phrase", "")
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
        if ($this->getUser()) {
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
        } else {
            return $this->redirectToRoute('blog');
        }
    }
}