<?php

namespace App\Controller;

use App\Entity\Evento;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NotificationsController extends Controller
{
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
    /**
    *  @Route(name="joinEvent")
     *
    **/
    public function joinEvent(Request $request){
        $em = $this->getDoctrine()->getManager();
        //$event=$em->getRepository('App:Evento')->findOneBy(array('id' => $request->request->get('id')));
        //$event->addUsersJoined($this->getUser());
        //$this->getUser()->addEventsJoined($event);
        return $this->redirect($request->getUri());

    }
}
