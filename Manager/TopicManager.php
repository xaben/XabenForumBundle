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

    /**
     * @param EntityManager $em
     * @param PostManager $postmanager
     * @param UserManager $usermanager
     * @param ForumManager $forummanager
     */
    public function __construct(EntityManager $em, PostManager $postmanager, UserManager $usermanager, ForumManager $forummanager)
    {
        $this->em = $em;
        $this->postmanager = $postmanager;
        $this->usermanager = $usermanager;
        $this->forummanager = $forummanager;
    }

    /**
     * Return Topic by topicId.
     *
     * @param integer $topicId
     * @return mixed
     */
    public function getTopicById($topicId) {
        return $this->em->getRepository('XabenForumBundle:Topic')
            ->findOneById($topicId);
    }

    /**
     * Returns an empty Topic object for use in forms.
     *
     * @param integer $forumId
     * @return Topic
     */
    public function getNewTopic($forumId)
    {
        $topic = new Topic();
        $topic->setForum($this->forummanager->getForumById($forumId));
        $topic->setPoster($this->usermanager->getCurrentUser());
        $topic->addPost($this->postmanager->getNewPost());

        return $topic;
    }
}
