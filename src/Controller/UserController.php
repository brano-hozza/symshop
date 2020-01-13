<?php


namespace App\Controller;


use http\Client\Curl\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;

class UserController extends AbstractController
{
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/profile", name="profile")
     */
    public function show(){
        $title = "Bshop";
        $announce = "Welcome to bshop";
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $online = $this->session->get("is_online", false);
        if ($online){
            /**
             * @var $user User
             */
            $user = $this->getUser();
            if(!is_null($user)) {
                return $this->render('/pages/profile.html.twig', [
                    'title' => $title,
                    'announce' => $announce,
                    'online' => $online,
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