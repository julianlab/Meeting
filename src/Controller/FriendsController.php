<?php

namespace App\Controller;

use App\Form\LoginType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FriendsController extends Controller
{
    /**
     * @Route("/friends", name="friends")
     */
    public function friends()
    {
        //$this->addFriend('222222222');
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getId();
        $request = Request::createFromGlobals();
        $friendAndDataList=$this->getUser()->getFriendsWithMe();
        if($request->getMethod()=='POST'){
            if($new_friend = $request->request->get('newFriend')){
                $friend = $em->getRepository('App:User')->findOneBy(array('phone' => $new_friend));
                $this->getUser()->addFriendsWithMe($friend);
                $em->flush();
            }
            else if($old_friend = $request->request->get('oldFriend')){
                $friend = $em->getRepository('App:User')->findOneBy(array('phone' => $old_friend));
                $this->getUser()->removeFriendsWithMe($friend);
                $em->flush();
            }


        }

        return $this->render('Friends/friends.html.twig', [
            'friends' => $friendAndDataList
        ]);




    }

    /**
     * @param $friendId
     */
    public function addFriend($friendPhone){
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getId();
        
        $user=$em->getRepository('App:Usuario')->findOneBy(array('username' => $username));
        
        $em->flush();
    }
    /**
     * @param $friendId
     */
    public function removeFriend($friendId){
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getId();
        $user=$em->getReference("App:Usuario",$username);
        $friendList = $user->getFriendList();
        unset($friendList[$friendId]);
        $user->setFriendList($friendList);
        $em->flush();
    }
}
?>