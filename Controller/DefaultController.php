<?php

namespace Xaben\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xaben\ForumBundle\Entity\Topic;
use Xaben\ForumBundle\Entity\Post;
use Xaben\ForumBundle\Entity\Posttext;
use Xaben\ForumBundle\Form\Type\TopicType;
use Xaben\ForumBundle\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //get categories and forums
        $em = $this->getDoctrine()->getEntityManager();
        $categories = $em->getRepository('XabenForumBundle:Category')
                         ->findAllWithForums();

        return $this->render('XabenForumBundle:Default:index.html.twig', array('categories'=>$categories));
    }
}
