<?php

namespace App\Controller;
use App\Entity\Evento;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class EventsController extends Controller
{

    /**
     * @Route("/firstStep", name="events")
     */
    public function events()
    {
        $params = array('provincias' => array());
        $em=$this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){

            $event = new Evento();
            $test = new \DateTime($request->request->get('fecha'));
            date_format($test, 'Y-m-d');
            $event->setNameCreador($this->getUser()->getName());
            $event->setMailCreador($this->getUser()->getEmail());
            $event->setMunicipioId($request->request->get('municipio'));
            $event->setFecha($test);
            $event->setDescripcion($request->request->get('descripcion'));
            $this->getUser()->addEvent($event);
            $em->flush();
        }
        $params['comunidades']=$em->getRepository('App:Comunidades')->findAll();
        return $this->render('Events/firstStep.html.twig',$params);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/create_event", name="create_event")
     */
    public function create_event(){
        //$params = array('comunidad'=>'', 'provincia'=>'','municipio'=>'');
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){

            return $this->render('Events/firstStep.html.twig');
        }
        return $this->render('Events/firstStep.html.twig');
    }
}
?>