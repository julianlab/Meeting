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
        //$this->removeFriend('222222222');
        $params = array('friendAndDataList'=>array());
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getId();
        $friends = $em->getReference("App:Usuario",$username)->getFriendList();
        //print_r($friends);
        foreach ($friends as $key=>$value){
            $friendFromDatabase = $em->getRepository("App:Usuario")->findOneBy(array('phone' => $value['friendId']));
            $friend = (object)[
                'friend'=>$friendFromDatabase,
                'data'=>$value['date'],
            ];
            //print_r($value['date']);
            array_push($params['friendAndDataList'],$friend);
        }

        return $this->render('Friends/friends.html.twig', $params);
    }

    /**
     * @param $friendId
     */
    public function addFriend($friendId){
        $em = $this->getDoctrine()->getManager();
        $username = $this->getUser()->getId();
        $fechahora=date("Y-m-d H:i:s");
        $user=$em->getReference("App:Usuario",$username);
        $friendList = $user->getFriendList();
        $newOne = array('friendId'=>$friendId,'date'=>$fechahora);
        array_push($friendList, $newOne);
        $user->setFriendList($friendList);
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
        unset($friendList[array_search($friendId, $friendList)]);
        $user->setFriendList($friendList);
        $em->flush();
    }
}
?>