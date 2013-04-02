<?php

namespace Xaben\Forumbundle\Manager;

use Doctrine\ORM\EntityManager;

class ForumManager
{
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Return Forum by forumId.
     * @param $forumId
     * @return mixed
     */
    public function getForumById($forumId) {
        return $this->em->getRepository('XabenForumBundle:Forum')
            ->findOneById($forumId);
    }
}
