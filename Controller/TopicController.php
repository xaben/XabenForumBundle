<?php

namespace Xaben\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xaben\ForumBundle\Entity\Topic;
use Xaben\ForumBundle\Entity\Post;
use Xaben\ForumBundle\Entity\Posttext;
use Xaben\ForumBundle\Entity\Userdata;
use Xaben\ForumBundle\Form\Type\TopicType;
use Xaben\ForumBundle\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TopicController extends Controller
{
    public function listAction($forumId, $page)
    {
        //get topics from current page
        $em = $this->getDoctrine()->getEntityManager();
        $topics = $em->getRepository('XabenForumBundle:Topic')
                     ->findAllByPage($this->getRequest(), $forumId, $page, $this->get('knp_paginator'));

        $forum = $em->getRepository('XabenForumBundle:Forum')
                    ->findOneById($forumId);

        return $this->render('XabenForumBundle:Default:topics.html.twig', array('topics'=>$topics, 'forum'=>$forum));
    }

    public function newAction($forumId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //render form
        $topicmanager = $this->get('xaben.forum.topicmanager');
        $topic = $topicmanager->getNewTopic($forumId);
        $form = $this->createForm(new TopicType(), $topic);

        return $this->render('XabenForumBundle:Default:newtopic.html.twig', array(
            'form' => $form->createView(),
            'forumId' => $forumId,
        ));
    }

    public function createAction(Request $request, $forumId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //create new topic
        $topicmanager = $this->get('xaben.forum.topicmanager');
        $topic = $topicmanager->getNewTopic($forumId);
        $form = $this->createForm(new TopicType(), $topic);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $topicmanager->addTopic($topic);
                $this->getDoctrine()->getEntityManager()->flush();
                return $this->redirect($this->generateUrl('XabenForumBundle_topics', array('forumId' => $forumId)));
            }
        }

        return $this->render('XabenForumBundle:Default:newtopic.html.twig', array(
                'form' => $form->createView(),
                'forumId' => $forumId,
        ));
    }
}
