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

    public function createAction(Request $request, $topicId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //display form
        $form = $this->createForm(new PostType(), null);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();

                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getEntityManager();

                //get topic
                $topic = $em->getRepository('XabenForumBundle:Topic')
                ->findOneById($topicId);

                //get forum
                $forum = $topic->getForum();

                //get user
                $poster = $this->get('security.context')->getToken()->getUser();

                //set post properties
                $post = new Post();
                $post->setIp($request->getClientIp());
                $post->setPoster($poster);
                $post->setPostTime(new DateTime);
                $post->setTopic($topic);

                $posttext = new Posttext();
                $posttext->setText($data['text']);

                //bind toghether
                $posttext->setPost($post);

                $topic->addPost($post);
                $topic->setFirstPost($post);
                $topic->setLastPost($post);
                $topic->setReplies($topic->getReplies() + 1);

                //update forum
                $forum->setLastPost($post);
                $forum->setPosts($forum->getPosts() + 1);

                $em->persist($topic);
                $em->persist($posttext);
                $em->persist($post);
                $em->persist($forum);

                $em->flush();

                return $this->redirect($this->generateUrl('XabenForumBundle_posts', array('topicId' => $topicId)));
            }
        }

        return $this->render('XabenForumBundle:Default:newpost.html.twig', array(
                'form' => $form->createView(),
                'topicId' => $topicId,
        ));

    }

}
