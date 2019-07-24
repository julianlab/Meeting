<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        //$form = $this->createForm(LoginType::class);
        return $this->render('Home/index.html.twig', []);
    }
    /**
     * @Route("/login", name="login")
     */
    /*public function login()
    {
        return $this->render("Security/login.html.twig");
    }*/

    /**
     * @Route("/register", name="register")
     */
    /*public function register()
    {
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){
            $user = new Usuario();
            $user->setEmail($request->request->get('email'));
            $user->setUsername($request->request->get('user'));
            $user->setPassword($request->request->get('password'));
            $user->setName($request->request->get('nombre'));
            $user->setSurname($request->request->get('apellidos'));
            $user->setPhone($request->request->get('phone'));
            $user->setIsActive(1);
            $em->persist($user);
            $em->flush();
        }
        return $this->render("Home/register.html.twig");
    }*/
}

?>