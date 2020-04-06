<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Interest;


class InterestsController extends Controller
{
    /**
     * @Route("/searchForInterests", name="searchForInterests")
     */
    public function searchForInterests()
    {
        $request = Request::createFromGlobals();
        $tag = $request->request->get('tag');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('tags')
            ->from('App:Tag', 'tags')
            ->where($qb->expr()->like('tags.name', "'%".$tag."%'"))
            ->getQuery()
            ->getResult();
        $query = $qb->getQuery();
        $tags = $query->getResult();
        $tagsCollection = [];
        foreach ($tags as $tag){
            array_unshift($tagsCollection, [
                'id' => $tag->getId(),
                'name'=>$tag->getName()
            ]);
        }
        $response = new JsonResponse;
        $response->setData(
            array('response'=>'success',
                    'tags'=>$tagsCollection)
            
        );
        return $response;
    }
    /**
     * @Route("/interests", name="persistInterests")
     */
    public function persistInterests()
    {
    	$endOfString = false;
    	$max = 0;
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getUsername();
        $user = $this->getUser();
        $request = Request::createFromGlobals();
        if($request->getMethod()=='POST'){
            //$user=$em->getRepository('App:User')->findOneBy(array('username' => $username));
            $tagsString = $request->getContent();
            while($endOfString == false){
            	$tagName = get_string_between($tagsString, '=', '&');
            	$tag=$em->getRepository('App:Tag')->findOneBy(array('name' => $tagName));
            	$newInterest = new Interest;
            	$newInterest->setUser($user);
            	$newInterest->setTag($tag);
            	$newInterest->setEnabled(true);
            	$newInterest->setName($tag->getName());
            	$em->persist($newInterest);
            	$user->addInterest($newInterest);
            	$tag->addUserInterested($user);
            	//$user->addInterest($tag);

            	$tagsString = substr_replace($tagsString, '', 0, strpos($tagsString, '&')+1);
            	if(strpos($tagsString, '&') === false){
            		$endOfString = true;
            		$tagName = substr($tagsString, 2);
            		$tag=$em->getRepository('App:Tag')->findOneBy(array('name' => $tagName));
            		$newInterest = new Interest;
	            	$newInterest->setUser($user);
	            	$newInterest->setTag($tag);
	            	$newInterest->setEnabled(true);
	            	$newInterest->setName($tag->getName());
	            	$em->persist($newInterest);
	            	$user->addInterest($newInterest);
	            	$tag->addUserInterested($user);
            		//$user->addInterest($tag);
            	}
            	$max = $max +1;
            }
            $em->flush();
			//$tag=$em->getRepository('App:Tag')->findOneBy(array('id' => $username));
            //$user->setPhone($request->request->get('phone'));
            //$em->flush();
        }
        return $this->render('Preferences/notificaciones.html.twig',[]);
    }
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}