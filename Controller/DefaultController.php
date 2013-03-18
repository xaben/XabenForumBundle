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

    public function topicsAction($forumId, $page)
    {
        //get topics from current page
        $em = $this->getDoctrine()->getEntityManager();
        $topics = $em->getRepository('XabenForumBundle:Topic')
                     ->findAllByPage($this->getRequest(), $forumId, $page, $this->get('knp_paginator'));

        $forum = $em->getRepository('XabenForumBundle:Forum')
                    ->findOneById($forumId);

        return $this->render('XabenForumBundle:Default:topics.html.twig', array('topics'=>$topics, 'forum'=>$forum));
    }

    public function postsAction($topicId, $page)
    {

        //get topics from current page
        $em = $this->getDoctrine()->getEntityManager();
        $posts = $em->getRepository('XabenForumBundle:Post')
                     ->findAllByPage($this->getRequest(), $topicId, $page, $this->get('knp_paginator'));

        return $this->render('XabenForumBundle:Default:posts.html.twig', array('posts'=>$posts));

    }

    public function newtopicAction(Request $request, $forumId)
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
                $poster = $this->get('security.context')->getToken()->getUser();

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

                $em->flush();

                return $this->redirect($this->generateUrl('XabenForumBundle_topics', array('forumId' => $forumId)));
            }
        }

        return $this->render('XabenForumBundle:Default:newtopic.html.twig', array(
                'form' => $form->createView(),
                'forumId' => $forumId,
        ));
    }

    public function newpostAction(Request $request, $topicId)
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
