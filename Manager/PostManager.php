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
    private $request;

    /**
     * @param EntityManager $em
     * @param UserManager $usermanager
     * @param Request $request
     */
    public function __construct(EntityManager $em, UserManager $usermanager, Request $request)
    {
        $this->em = $em;
        $this->usermanager = $usermanager;
        // $this->forummanager = $forummanager;
        $this->request = $request;
    }

    /**
     * Returns an empty Post object for use in forms
     *
     * @param integer $topicId
     * @return Post
     */
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
}
