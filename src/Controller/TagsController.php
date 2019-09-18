<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TagsController extends Controller
{
    /**
     * @Route("/api/tags", name="tags")
     *
     */
    public function index()
    {
        $response = new JsonResponse(array('name'=> 'name'));
        return $response;
    }
    /**
    * @Route("/api/tags/{nameLike}", name="tags")
    *
    */
    public function tagsMatchingName($nameLike)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('tags')
            ->from('App:Tag', 'tags')
            ->where($qb->expr()->like('tags.name', "'%".$nameLike."%'"))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $tags = $query->getResult();
        $tagsCollection = array();
        foreach ($tags as $tag){
            array_push($tagsCollection, array(
                'id' => $tag->getId(),
                'name'=>$tag->getName()
            ));
        }
        $response = new JsonResponse(json_encode($tagsCollection));
        return $response;
    }

}
