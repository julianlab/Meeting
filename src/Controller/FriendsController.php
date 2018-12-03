<?php

namespace App\Controller;

use App\Form\LoginType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        $friendAndDataList=$this->getUser()->getFriendsWithMe();
        //$new_friend = $em->getRepository('App:User')->findOneBy(array('phone' => '444444444'));
        //die($new_friend->getId());
        //$this->getUser()->addMyFriend($new_friend); 
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
        print_r($friendList);
        unset($friendList[$friendId]);
        $user->setFriendList($friendList);
        $em->flush();
    }
}
?>