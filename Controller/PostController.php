<?php

namespace Xaben\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xaben\ForumBundle\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostController extends Controller
{
    /**
     * Display and paginate all posts for a given topic
     *
     * @param integer $topicId
     * @param integer $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($topicId, $page)
    {

        //get topics from current page
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('XabenForumBundle:Post')
                     ->findAllByPage($this->getRequest(), $topicId, $page, $this->get('knp_paginator'));

        return $this->render('XabenForumBundle:Default:posts.html.twig', array('posts'=>$posts));

    }

    /**
     * Display form for creating a new post in a given topic
     *
     * @param integer $topicId
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function newAction($topicId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //render form
        $form = $this->createForm(new PostType(), null);

        return $this->render('XabenForumBundle:Default:newpost.html.twig', array(
            'form' => $form->createView(),
            'topicId' => $topicId,
        ));
    }

    /**
     * Process new post form data
     *
     * @param Request $request
     * @param integer $topicId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function createAction(Request $request, $topicId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //create new post
        $postmanager = $this->get('xaben.forum.postmanager');
        $post = $postmanager->getNewPost($topicId);

        $form = $this->createForm(new PostType(), $post);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($post);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->redirect($this->generateUrl('XabenForumBundle_posts', array(
            'topicId' => $topicId
        )));
    }
}
