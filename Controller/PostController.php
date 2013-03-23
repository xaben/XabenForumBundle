<?php

namespace Xaben\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xaben\ForumBundle\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostController extends Controller
{

    public function listAction($topicId, $page)
    {

        //get topics from current page
        $em = $this->getDoctrine()->getEntityManager();
        $posts = $em->getRepository('XabenForumBundle:Post')
                     ->findAllByPage($this->getRequest(), $topicId, $page, $this->get('knp_paginator'));

        return $this->render('XabenForumBundle:Default:posts.html.twig', array('posts'=>$posts));

    }

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
            $form->bindRequest($request);
            if ($form->isValid()) {
                $postmanager->addPost($post);
                $this->getDoctrine()->getEntityManager()->flush();
            }
        }

        return $this->redirect($this->generateUrl('XabenForumBundle_posts', array(
            'topicId' => $topicId
        )));
    }
}
