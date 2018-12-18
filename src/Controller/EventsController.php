<?php

namespace App\Controller;
use App\Entity\Evento;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
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
        if($request->getMethod()=='POST') {
            $event = new Evento();
            $date = new \DateTime($request->request->get('fecha'));
            date_format($date, 'Y-m-d');
            $event->setNameCreador($this->getUser()->getName());
            $event->setMailCreador($this->getUser()->getEmail());
            $event->setMunicipioId($request->request->get('municipio'));
            $event->setFecha($date);
            $event->setDescripcion($request->request->get('descripcion'));
            $event->setIsActive(1);
            $event->setIdCreator($this->getUser());
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
            'filledEvents'=>$filledEvents
        ]);
    }
    /**
     * @Route("/join-event/{id}", name="joinEvent")
     * @ParamConverter("evento", options={"mapping": {"id": "id"}})
     * @Template()
     **/
    public function joinEvent(Evento $event){
        if ($this->eventIsAdded($event)){
            $addedEventLog = "Este evento ya ha sido añadido.";
        }
        else if(sizeof($this->quantityOfEvents($event))>2){
            $addedEventLog = "No se puede unir al evento. Ya tiene 3 el mismo dia.";
        }else{
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->addEventsJoined($event);
            $em->flush();
            $addedEventLog = "Evento añadido.";
        }
        return $this->render('Home/index.html.twig', [
            'addedEventLog' => $addedEventLog
        ]);
    }



    public function socialPanel()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $username = $this->getUser()->getId();
        $username_id = $this->getUser()->getId();
        $qb->select('events')
            ->from('App:Evento', 'events')
            ->where($qb->expr()->notIN('events.id_creator', $username))
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
}
?>