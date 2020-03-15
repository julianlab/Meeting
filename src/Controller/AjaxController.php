<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class AjaxController extends Controller
{
    /**
    * @Route("/searchEvents", name="searchEvents")
    */
    public function searchEvents(){
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST') {
            $value = $request->request->get('searchBox');
            $em=$this->getDoctrine()->getManager();
            $searchFor = $request->request->get('value');
            $query = $em->createQuery('SELECT e FROM App:Evento e WHERE e.title LIKE :value');
            $query->setParameter('value', '%'.$searchFor.'%');
            $eventos = $query->getResult();
            $response = [];
            foreach($eventos as $evento){
                array_unshift($response,[
                    $evento->getId(),
                    $evento->getTitle(),
                    $evento->getFecha()
                ]);
            }
            $respuesta = new JsonResponse();
            $respuesta->setData(
                array('response'=>'success',
                    'request_ajax'=> true,
                    'eventsObjects'=>$eventos,
                    'eventos'=>$response)
            );
        }
        return $respuesta;
    }
    
    /**
     * @Route("/ajax_provincias", name="ajax_provincias")
     *
     */
    public function ajax_provincias()
    {
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){
            $content = $request->getContent();
            $comunidad = $content;
            $encoder = array(new JsonEncoder());
            $normalizer = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizer,$encoder);

            $em = $this->getDoctrine()->getManager();
            $provincias = $em->getRepository('App:Provincias')->findBy(['comunidadId'=>$comunidad]);
            $respuesta = new JsonResponse();

            $respuesta->setData(
                array('response'=>'success',
                    'provincias'=>$serializer->serialize($provincias,'json'
                ))
            );
        }
        return $respuesta;
    }
    /**
     * @Route("/ajax_municipios",name="ajax_municipios")
     */
    public function ajax_municipios(){
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){
            $content = $request->getContent();
            $provincia = $content;
            $encoder = array(new JsonEncoder());
            $normalizer = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizer,$encoder);

            $em = $this->getDoctrine()->getManager();
            $municipios = $em->getRepository('App:Municipios')->findBy(['provinciaId'=>$provincia]);
            $respuesta = new JsonResponse();

            $respuesta->setData(
                array('response'=>'success',
                    'municipios'=>$serializer->serialize($municipios,'json')));
        }
        return $respuesta;
    }
}
