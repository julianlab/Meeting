<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
                'username_id' => $username_id
        ]
        );
    }
}
