<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
    	$request = Request::createFromGlobals();
        if($request->getMethod()=='POST') {
            $eventos = [];
            $em=$this->getDoctrine()->getManager();
            $searchFor = $request->request->get('searchBox');
            if ($searchFor != "") {
                $query = $em->createQuery('SELECT e FROM App:Evento e WHERE e.title LIKE :value');
                $query->setParameter('value', '%'.$searchFor.'%');
                $eventos = $query->getResult();
            }
            
        }
        return $this->render('search/search.html.twig', [
            'events' => $eventos,
        ]);
    }
    /**
     * @Route("/search", name="searchUsers")
     */
    public function searchUsers()
    {
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST') {
            $eventos = [];
            $em=$this->getDoctrine()->getManager();
            $searchFor = $request->request->get('searchBox');
            if ($searchFor != "") {
                $query = $em->createQuery('SELECT u FROM App:User u WHERE u.name LIKE :value');
                $query->setParameter('value', '%'.$searchFor.'%');
                $eventos = $query->getResult();
            }
            
        }
        return $this->render('search/search.html.twig', [
            'events' => $eventos,
        ]);
    }
}
