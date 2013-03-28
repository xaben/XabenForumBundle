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
}
