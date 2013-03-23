<?php

namespace Xaben\Forumbundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Xaben\ForumBundle\Entity\Userdata;

class UserManager
{
    private $em;
    private $securitycontext;

    public function __construct(EntityManager $em, SecurityContextInterface $securitycontext)
    {
        $this->em = $em;
        $this->securitycontext = $securitycontext;
    }

    public function getCurrentUser()
    {
        //try to get existing userdata or create new one
        $user = $this->securitycontext->getToken()->getUser();
        $userdata = $this->em->getRepository('XabenForumBundle:Userdata')
                            ->findOneByBaseuser($user);

        if (null === $userdata) {
            $userdata = new Userdata();
            $userdata->setBaseuser($user);
            $this->em->persist($userdata);
        }
        return $userdata;
    }

    public function incrementPosts()
    {
        $userdata = $this->getCurrentUser();
        $userdata->setPosts($userdata->getPosts() + 1);

        $this->em->persist($userdata);
    }

    public function incrementTopics()
    {
        $userdata = $this->getCurrentUser();
        $userdata->setTopics($userdata->getTopics() + 1);

        $this->em->persist($userdata);
    }

}
