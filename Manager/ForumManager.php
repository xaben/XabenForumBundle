<?php

namespace Xaben\Forumbundle\Manager;

use Doctrine\ORM\EntityManager;
use Xaben\ForumBundle\Entity\Post;
use Xaben\ForumBundle\Entity\Topic;

class ForumManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getForumById($forumId) {
        return $this->em->getRepository('XabenForumBundle:Forum')
            ->findOneById($forumId);
    }

    public function addTopic(Topic $topic)
    {
        $forum = $topic->getForum();
        $forum->setTopiccount($forum->getTopiccount() + 1);

        $this->em->persist($forum);
    }

    public function addPost(Post $post)
    {
        $forum = $post->getTopic()->getForum();
        $forum->setPosts($forum->getPosts() + 1);
        $forum->setLastPost($post);

        $this->em->persist($forum);
    }
}
