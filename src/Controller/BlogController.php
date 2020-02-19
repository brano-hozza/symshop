<?php


namespace App\Controller;


use App\Entity\Blog;
use App\Form\BlogCreateType;
use App\Repository\BlogRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Translation\TranslatorInterface;

class BlogController extends AbstractController
{
    protected $serializer;
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
        $title = "Bshop";
        $announce = "Welcome to bshop";
        dump($phrase);
        if ($request->isXmlHttpRequest()) {
            $jsonResp = array();
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                foreach ($response as $blog) {
                    array_push($jsonResp, '
                          <div class="blog-container">
                            <div class="blog-remove">
                                <p class="blog-user">u/' . ($blog->getUser())->getUsername() . '</p>
                                    <form action="/blog/remove/' . $blog->getId() . '" id="delete">
                                    
                                        <button type="submit"><img src="images/close.svg" alt="close"></button>
                                    </form>
                            </div>
                            <h2 class="blog-title">' . $blog->getTitle() . '</h2>
                            <p class="blog-text">' . $blog->getText() . '</p>
                            <p class="blog-date">' . $this->translator->trans('CREATED_ON') . '
                                : ' . $blog->getCreatedAt()->format('Y/m/d') . '</p>
                        </div>'
                    );

                }
                return new JsonResponse($jsonResp);
            }
            foreach ($response as $blog) {
                array_push($jsonResp, /** @lang HTML */ '
                         <div class="blog-container">
                    <div class="blog-remove">
                        <p class="blog-user">u/' . ($blog->getUser())->getUsername() . '</p>
                    </div>
                    <h2 class="blog-title">' . $blog->getTitle() . '</h2>
                    <p class="blog-text">' . $blog->getText() . '</p>
                    <p class="blog-date">' . $this->translator->trans('CREATED_ON') . '
                        : ' . $blog->getCreatedAt()->format('Y/m/d') . '</p>
                </div>');

            }
            return new JsonResponse($jsonResp);
        }

        return $this->render('blog/index.html.twig', [
            'title' => $title,
            'announce' => $announce,
            'page' => $page,
            'blogs' => $response,
            'phrase' => $phrase
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
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
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
        } else {
            throw $this->createAccessDeniedException();
        }
    }

    /**
     * @Route("/blog/remove/{blog}", name="blog_remove")
     * @param Blog $blog
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public
    function remove(Blog $blog, EntityManagerInterface $entityManager)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $entityManager->remove($blog);
            $entityManager->flush();
            return $this->redirectToRoute('blog');
        } else {
            throw $this->createAccessDeniedException();
        }

    }
}