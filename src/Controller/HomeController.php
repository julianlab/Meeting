<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     *
     */
    public function home()
    {
        //$form = $this->createForm(LoginType::class);
        return $this->render('Home/index.html.twig', ['request_ajax'=>false]);
    }
    /**
     * @Route("/login", name="login")
     */
    /*public function login()
    {
        return $this->render("Security/login.html.twig");
    }*/
}

?>