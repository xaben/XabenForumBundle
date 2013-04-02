<?php

namespace Xaben\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Display forum index
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        //get categories and forums
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('XabenForumBundle:Category')
                         ->findAllWithForums();

        return $this->render('XabenForumBundle:Default:index.html.twig', array('categories'=>$categories));
    }
}
