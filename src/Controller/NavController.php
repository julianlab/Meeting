<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavController extends Controller
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('nav/index.html.twig', [
            'controller_name' => 'NavController',
        ]);
    }
}
