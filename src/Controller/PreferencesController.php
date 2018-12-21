<?php

namespace App\Controller;

use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PreferencesController extends AbstractController
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @Route("preferences/{slug}", name="preferences")
     */
    /*public function preferences($slug)
    {
        if($slug=='perfil') $this->perfil();
        return $slug;//$this->render('Home/preferencias.html.twig',[]);
    }*/
    /**
     * @Route("preferences/perfil", name="perfil")
     */
    public function perfil()
    {//Muestra y modifica la entidad del usuario que está logeado.
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getUsername();
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){
            $user=$em->getRepository('App:User')->findOneBy(array('username' => $username));
            $user->setEmail($request->request->get('email'));
            $user->setName($request->request->get('name'));
            $user->setSurname($request->request->get('surname'));
            $user->setUsername($request->request->get('username'));
            $user->setPhone($request->request->get('phone'));
            $em->flush();
        }
        $user=$em->getRepository('App:User')->findOneBy(array('username' => $username));
        return $this->render("Preferences/perfil.html.twig", [
            'user' => $user,
        ]);
    }
    /**
     * @Route("eventos", name="eventos")
     */
    public function eventos()
    {
        $params=array('events',array());
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser()->getEmail();
        setlocale(LC_ALL,"es_ES");
        //$params['events']=$em->getRepository('App:Evento')->findAll(array('mailCreador'=>$user));
        $events=$this->getUser()->getEventos();
        return $this->render('Preferences/eventos.html.twig', [
            'events' => $events,
            'control' => 'created'
        ]);
    }
    /**
     * @Route("seguridad", name="seguridad")
     */
    public function seguridad()
    {
        return $this->render('Preferences/seguridad.html.twig',[]);
    }
    /**
     * @Route("notificaciones", name="notificaciones")
     */
    public function notificaciones()
    {
        return $this->render('Preferences/notificaciones.html.twig',[]);
    }
    /**
     * @Route("conexiones", name="conexiones")
     */
    public function conexiones()
    {
        return $this->render('Preferences/conexiones.html.twig',[]);
    }
    /**
     * @Route("subscripciones", name="subscripciones")
     */
    public function subscripciones()
    {
        $params=array('events',array());
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser()->getEmail();
        setlocale(LC_ALL,"es_ES");
        $events=$this->getUser()->getEventsJoined();
        return $this->render('Preferences/subscripciones.html.twig',[
            'events' => $events,
            'control' => 'subscribed'
        ]);
    }
    
}
?>