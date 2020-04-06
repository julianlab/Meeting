<?php

namespace App\Controller;

use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->in('events.id_creator', $this->getUser()->getId()))
            ->andWhere("events.fecha >= :date")
            ->setParameter('date',date('Y/m/d', time()))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();
        return $this->render('Preferences/eventos.html.twig', [
            'events' => $events,
            'control' => 'created'
        ]);
    }

    /**
     * @Route("/events/expired", name="expiredEvents")
     */
    public function expiredEvents(){
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->in('events.id_creator', $this->getUser()->getId()))
            ->andWhere("events.fecha <= :date")
            ->setParameter('date',date('Y/m/d', time()))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();
        foreach ($events as $event) {
            $event->setIsExpired(1);
        }
        $em->flush();
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
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $interests = $user->getInterests();
        
        return $this->render('Preferences/notificaciones.html.twig',[
            'interests' => $interests
        ]);
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
        $em = $this->getDoctrine()->getManager();
        $eventsJoined = $this->getUser()->getEventsJoined();
        $joined = array();
        foreach ($eventsJoined as $evJoined) {
            array_push($joined, $evJoined->getId());
        }
        if(empty($joined)) {
            $joined = 0;
        }
        $qb = $em->createQueryBuilder();
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->in('events.id', $joined))
            ->andWhere("events.fecha >= :date")
            ->setParameter('date', date('Y/m/d', time()))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();

        return $this->render('Preferences/eventos.html.twig',[
            'events' => $events,
            'control' => 'subscribed'
        ]);
    }
    /**
     * @Route("/subscripciones/expired", name="expiredSubscribedEvents")
     */
    public function expiredSubscribedEvents(){
        $em = $this->getDoctrine()->getManager();
        $eventsJoined = $this->getUser()->getEventsJoined();
        $joined = array();
        foreach ($eventsJoined as $evJoined){
            array_push($joined,$evJoined->getId());
        }
        $qb = $em->createQueryBuilder();
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->in('events.id', $joined))
            ->andWhere("events.fecha <= :date")
            ->setParameter('date',date('Y/m/d', time()))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();
        foreach ($events as $event) {
            $event->setIsExpired(1);
        }
        $em->flush();
        return $this->render('Preferences/eventos.html.twig', [
            'events' => $events,
            'control' => 'subscribed'
        ]);
    }
}
?>