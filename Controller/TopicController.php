<?php

namespace Xaben\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xaben\ForumBundle\Form\Type\TopicType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TopicController extends Controller
{
    /**
     * Display and paginate all topics for a given forum
     *
     * @param integer $forumId
     * @param integer $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($forumId, $page)
    {
        //get topics from current page
        $em = $this->getDoctrine()->getManager();
        $topics = $em->getRepository('XabenForumBundle:Topic')
                     ->findAllByPage($this->getRequest(), $forumId, $page, $this->get('knp_paginator'));

        $forum = $em->getRepository('XabenForumBundle:Forum')
                    ->findOneById($forumId);

        return $this->render('XabenForumBundle:Default:topics.html.twig', array('topics'=>$topics, 'forum'=>$forum));
    }

    /**
     * Display form for creating a new topic in a given forum
     *
     * @param integer $forumId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function newAction($forumId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //render form
        $topicManager = $this->get('xaben.forum.topicmanager');
        $topic = $topicManager->getNewTopic($forumId);
        $form = $this->createForm(new TopicType(), $topic);

        return $this->render('XabenForumBundle:Default:newtopic.html.twig', array(
            'form' => $form->createView(),
            'forumId' => $forumId,
        ));
    }

    /**
     * Process new topic form data
     *
     * @param Request $request
     * @param $forumId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function createAction(Request $request, $forumId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //create new topic
        $topicManager = $this->get('xaben.forum.topicmanager');
        $topic = $topicManager->getNewTopic($forumId);
        $form = $this->createForm(new TopicType(), $topic);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                foreach ($topic->getPosts() as $post) {
                    $this->getDoctrine()->getManager()->persist($post);
                }
                $this->getDoctrine()->getManager()->persist($topic);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect($this->generateUrl('XabenForumBundle_topics', array('forumId' => $forumId)));
            }
        }

        return $this->render('XabenForumBundle:Default:newtopic.html.twig', array(
                'form' => $form->createView(),
                'forumId' => $forumId,
        ));
    }
}
