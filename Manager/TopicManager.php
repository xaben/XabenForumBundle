<?php

namespace Xaben\Forumbundle\Manager;

use Doctrine\ORM\EntityManager;
use Xaben\ForumBundle\Entity\Topic;
use Xaben\ForumBundle\Manager\PostManager;
use Xaben\ForumBundle\Manager\UserManager;
use Xaben\ForumBundle\Manager\ForumManager;

class TopicManager
{
    private $em;
    private $postmanager;
    private $usermanager;
    private $forummanager;

    public function __construct(EntityManager $em, PostManager $postmanager, UserManager $usermanager, ForumManager $forummanager)
    {
        $this->em = $em;
        $this->postmanager = $postmanager;
        $this->usermanager = $usermanager;
        $this->forummanager = $forummanager;
    }
    
    public function getTopicById($topicId) {
        return $this->em->getRepository('XabenForumBundle:Topic')
            ->findOneById($topicId);
    }

    public function getNewTopic($forumId)
    {
        $topic = new Topic();
        $topic->setForum($this->forummanager->getForumById($forumId));
        $topic->setPoster($this->usermanager->getCurrentUser());
        $topic->addPost($this->postmanager->getNewPost());

        return $topic;
    }

    public function addTopic(Topic $topic)
    {
        //save related post
        $posts = $topic->getPosts();
        foreach ($posts as $post) {
            $this->postmanager->addPost($post);
        }

        $this->forummanager->addTopic($topic);
        $this->em->persist($topic);
    }
}
