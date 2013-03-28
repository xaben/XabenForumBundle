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
            $userdata->setFirstActivity(new \Datetime());
            $this->em->persist($userdata);
            $this->em->flush();
        }

        return $userdata;
    }
}
