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

    public function searchEvents(String $value){
        $request = Request::createFromGlobals();
        $em=$this->getDoctrine()->getManager();
        $eventos = $em->getRepository('App:Evento')->findBy(array('title'=>$value));
        $respuesta = new JsonResponse();
        $respuesta->setData(
            array('response'=>'success',
                'eventos'=>$serializer->serialize($eventos,'json')
            )
        );
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
