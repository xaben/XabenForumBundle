<?php

namespace Xaben\Forumbundle\Manager;

use Doctrine\ORM\EntityManager;
use Xaben\ForumBundle\Entity\Post;
use Xaben\ForumBundle\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;

class PostManager
{
    private $em;
    private $usermanager;
    private $forummanager;
    private $topicmanager;
    private $request;

    public function __construct(EntityManager $em, UserManager $usermanager, ForumManager $forummanager, Request $request)
    {
        $this->em = $em;
        $this->usermanager = $usermanager;
        $this->forummanager = $forummanager;
        $this->request = $request;
    }

    public function getNewPost($topicId = null)
    {
        //create new Post
        $post = new Post();
        $post->setIp($this->request->getClientIp());
        $post->setPostTime(new \DateTime);
        $post->setPoster($this->usermanager->getCurrentUser());

        //get topic
        if (null !== $topicId) {
            $topic = $this->em->getRepository('XabenForumBundle:Topic')
                ->findOneById($topicId);
            $post->setTopic($topic);
        }

        return $post;
    }

    public function addPost(Post $post)
    {
        $this->updateTopic($post);
        $this->forummanager->addPost($post);

        $this->em->persist($post);
    }

    private function updateTopic(Post $post)
    {
        $topic = $post->getTopic();
        if (!$topic->getFirstPost()) {
            $topic->setFirstPost($post);
        }
        $topic->setLastPost($post);
        $topic->setReplies($topic->getReplies() + 1);
        $topic->setPostTime(new \DateTime);

        $this->em->persist($topic);
    }

}
