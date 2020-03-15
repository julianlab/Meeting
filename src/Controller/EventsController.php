<?php

namespace App\Controller;
use App\Entity\Evento;
use App\Entity\Tag;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class EventsController extends Controller
{

    /**
     * @Route("/firstStep", name="events")
     */
    public function events()
    {
        $em=$this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $filledEvents = false;
        $qb = $em->createQueryBuilder();
        $qb->select('tags')
            ->from('App:Tag', 'tags')
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $tags = $query->getResult();
        if($request->getMethod()=='POST') {
            $event = new Evento();
            $date = new \DateTime($request->request->get('fecha'));
            $event->setTitle($request->request->get('title'));
            $event->setNameCreador($this->getUser()->getName());
            $event->setMailCreador($this->getUser()->getEmail());
            $event->setMunicipioId($request->request->get('municipio'));
            $event->setFecha($date);
            $event->setDescripcion($request->request->get('descripcion'));
            $event->setSubscribers($request->request->get('subscribers'));
            foreach($request->request->get('checkboxes') as $tag){
                $qb = $em->createQueryBuilder();
                $qb->select('tags')
                    ->from('App:Tag', 'tags')
                    ->where($qb->expr()->eq('tags.id', $tag))
                    ->getQuery()
                    ->getResult();
                $query = $qb->getQuery();
                $tag = $query->getResult();
                $event->addTag($tag[0]);
            }
            $event->setIsActive(1);
            $event->setIdCreator($this->getUser());
            $event->setIsExpired(0);
            if (sizeof($this->quantityOfEvents($event))>2) {
                $filledEvents = true;
            }
            else{
                $this->getUser()->addEvento($event);
                $em->persist($event);
                $this->getUser()->addEventsJoined($event);
                $em->flush();
                $filledEvents = false;
            }
        }
        return $this->render('Events/firstStep.html.twig',[
            'filledEvents'=>$filledEvents,
            'tags'=>$tags
        ]);
    }
    /**
     * @Route("/event/{id}", name="event")
     * @ParamConverter("evento", options={"mapping":{"id":"id"}})
     * @Template()
     */
    public function event(Evento $event){
        $creator = 0;
        $joined = 0;
        $this->lookEventExpire();
        $eventsJoined = $this->getUser()->getEventsJoined();
        if($this->getUser()->getId() == $event->getIdCreator()->getId()){
            $creator = 1;
        }
        foreach ($eventsJoined as $eventJoined){
            if($eventJoined->getId() == $event->getId()){
                $joined = 1;
            }
        }
        $subscribers = sizeof($event->getUsersJoined());
        return $this->render('Events/event.html.twig', [
            'evento' => $event,
            'control' => 'main',
            'creator' => $creator,
            'joined' => $joined,
            'subscribers' => $subscribers
        ]);
    }
    /**
    * @Route("/eventFromId/{id}", name="eventFromId")
    **/
    public function eventFromId($id){
        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('event')
            ->from('App:Evento', 'event')
            ->where('event.id = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        $event = $query->getResult();
        //$event = new Evento($event);
        //die(var_dump($event[0]));
        $this->event($event[0]);
        $response = $this->forward('App\Controller\EventsController::event', [
            'event'  => $event[0],
        ]);
        return $response;
    }

    /**
     * @Route("/join-event/{id}", name="joinEvent")
     * @ParamConverter("evento", options={"mapping": {"id": "id"}})
     * @Template()
     **/
    public function joinEvent(Evento $event){
        if ($this->eventIsAdded($event)){
            $addedEventLog = "Ya estas apuntado en este evento.";
        }
        else if(sizeof($this->quantityOfEvents($event))>2){
            $addedEventLog = "No se puede unir al evento. Ya tiene 3 el mismo dia.";
        }
        else{
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->addEventsJoined($event);
            $em->flush();
            $addedEventLog = "Evento añadido.";
        }
        return $this->render('Home/index.html.twig', [
            'addedEventLog' => $addedEventLog
        ]);
    }
    /**
     * @param Evento $event
     * @Route("unjoin-event/{id}", name="unjoinEvent")
     * @ParamConverter("evento", options={"mapping": {"id": "id"}})
     * @Template()
     *
     **/
    public function unjoinEvent(Evento $event){
        $em = $this->getDoctrine()->getManager();
        //$addedEventLog = "No estas unido a este evento.";
        $this->getUser()->removeEventsJoined($event);
        $em->flush();
        $addedEventLog = "Evento quitado de tu lista.";
        return $this->render('Events/firstStep.html.twig', [
            'addedEventLog' => $addedEventLog
        ]);
    }
    /**
     * @Route("/disable-event/{id}", name="disableEvent")
     *
     * @ParamConverter("evento", options={"mapping":{"id":"id"}})
     * @Template()
     */
    public function disableEvent(Evento $event){
        $em = $this->getDoctrine()->getManager();
        $addedEventLog = "Event disabled.";
        $eventToDisable = $em->getRepository('App:Evento')->findOneBy(array('id'=>$event->getId()));
        $eventToDisable->setIsActive(0);
        $em->flush();
        return $this->render('Home/index.html.twig', [
            'addedEventLog' => $addedEventLog
        ]);
    }
    /**
     * @Route("/enable-event/{id}", name="enableEvent")
     * @ParamConverter("evento", options={"mapping":{"id":"id"}})
     * @Template()
     */
    public function enableEvent(Evento $event){
        $em = $this->getDoctrine()->getManager();
        $addedEventLog = "Event enabled.";
        $eventToDisable = $em->getRepository('App:Evento')->findOneBy(array('id'=>$event->getId()));
        $eventToDisable->setIsActive(1);
        $em->flush();
        return $this->render('Home/index.html.twig', [
            'addedEventLog' => $addedEventLog
        ]);
    }


    /**
     * @param Evento $event
     * @return bool
     * @ParamConverter("evento", options={"mapping": {"id": "id"}})
     * @Template()
     */
    public function userIsJoined(Evento $event){
        $eventsJoined = $this->getUser()->getEventsJoined();
        return 1;
    }



    public function socialPanel()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $username = $this->getUser()->getId();
        $username_id = $this->getUser()->getId();
        $eventsJoined = $this->getUser()->getEventsJoined();
        $joined = array();
        foreach ($eventsJoined as $evJoined) {
            array_push($joined, $evJoined->getId());
        }
        if(empty($joined)) {
            $joined = 0;
        }
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->notIN('events.id_creator', $username))
            ->andWhere($qb->expr()->eq('events.isActive', 1))
            ->andWhere($qb->expr()->notIN("events.id", $joined))
            ->andWhere("events.fecha >= :date")
            ->setParameter('date', date('Y/m/d', time()))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();

        return $this->render('Home/_socialPanel.html.twig', [
                'events' => $events,
                'username_id' => $username_id,
                'control' => 'social'
            ]
        );
    }

    public function socialPanelAux()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $username = $this->getUser()->getId();
        $username_id = $this->getUser()->getId();
        $eventsJoined = $this->getUser()->getEventsJoined();
        $joined = array();
        foreach ($eventsJoined as $evJoined){
            array_push($joined,$evJoined->getId());
        }
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->notIN('events.id_creator', $username))
            ->andWhere($qb->expr()->eq('events.isActive',1))
            ->andWhere($qb->expr()->notIN("events.id",$joined))
            ->andWhere("events.fecha >= :date")
            ->setParameter('date',date('Y/m/d', time()))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();

        $result = [];
        foreach ($events as $event){
            array_push($result, [
                'id' => $event->getId(),
                'date' => $event->getFecha(),
                'description' => $event->getDescripcion()
            ]);
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    public function eventIsAdded(Evento $event):bool {
        $eventsJoined = $this->getUser()->getEventsJoined();
        return($eventsJoined->contains($event));
    }


    public function quantityOfEvents(Evento $event):Array {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $eventsJoined = $this->getUser()->getEventsJoined();
        $joined = array();
        foreach ($eventsJoined as $evJoined){
            array_push($joined,$evJoined->getId());
        }
        if(empty($joined)){
            $joined = 0;
        }
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->in('events.id', $joined))
            ->andWhere("events.fecha like :date")
            ->setParameter('date',$event->getFecha()->format('Y-m-d'))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $events = $query->getResult();

        return $events;
    }

    public function lookEventExpire(){
        $em = $this->getDoctrine()->getManager();
        
        return 0;
    }
}
