<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends Controller
{
    /**
     * @Route("/searchFromNavbar", name="searchFromNavbar")
     */
    public function searchFromNavbar()
    {
    	$request = Request::createFromGlobals();
        if($request->getMethod()=='POST') {
            $value = $request->request->get('searchBox');
            $em=$this->getDoctrine()->getManager();
            $searchFor = $request->request->get('value');
            $qb = $em->createQueryBuilder();
            $query = $em->createQuery('SELECT e FROM App:Evento e WHERE e.title LIKE :value');
            $query->setParameter('value', '%'.$searchFor.'%');
            $eventos = $query->getResult();
            $response = [];
            foreach($eventos as $evento){
                array_unshift($response,[
                    $evento->getId(),
                    $evento->getTitle()
                ]);
            }
            $respuesta = new JsonResponse();
            $respuesta->setData(
                array('response'=>'success',
                    'eventos'=>$response)
            );
        }
        return $respuesta;
    }
    /**
     * @Route("/search", name="search")
     */
    public function searchEvents()
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
            'searchResult' => 'events',
            'events' => $eventos,
        ]);
    }
    /**
     * @Route("/search/users", name="users")
     */
    public function searchUsers()
    {
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST') {
            $users = [];
            $em=$this->getDoctrine()->getManager();
            $searchFor = $request->request->get('searchBox');
            $currentUser = $this->getUser()->getId();
            if ($searchFor != "") {
                $query = $em->createQuery('SELECT u FROM App:User u WHERE u.name LIKE :value AND u.id NOT LIKE :currentUser');
                $query->setParameter('value', '%'.$searchFor.'%');
                $query->setParameter('currentUser', $currentUser);
                $users = $query->getResult();
            }
            
        }
        return $this->render('search/search.html.twig', [
            'searchResult' => 'users',
            'users' => $users,
        ]);
    }
}
