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

    public function createAction(Request $request, $forumId)
    {
        //check if user logged in
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        //display form
        $form = $this->createForm(new TopicType(), null);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();

                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getEntityManager();

                //get forum
                $forum = $em->getRepository('XabenForumBundle:Forum')
                ->findOneById($forumId);

                //get user
                $masteruser = $this->get('security.context')->getToken()->getUser();
                $poster = new Userdata();
                $poster->setMasteruser($masteruser);

                //set topic properties
                $topic = new Topic();
                $topic->setForum($forum);
                $topic->setPoster($poster);
                $topic->setPostTime(new DateTime);
                $topic->setTitle($data['title']);
                $topic->setReplies(1);

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

                //update forum
                $forum->setLastPost($post);
                $forum->setTopiccount($forum->getTopiccount() + 1);
                $forum->setPosts($forum->getPosts() + 1);

                $em->persist($topic);
                $em->persist($posttext);
                $em->persist($post);
                $em->persist($forum);
                $em->persist($poster);

                $em->flush();

                return $this->redirect($this->generateUrl('XabenForumBundle_topics', array('forumId' => $forumId)));
            }
        }

        return $this->render('XabenForumBundle:Default:newtopic.html.twig', array(
                'form' => $form->createView(),
                'forumId' => $forumId,
        ));
    }
}
