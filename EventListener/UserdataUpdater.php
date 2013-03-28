<?php
namespace Xaben\ForumBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Xaben\ForumBundle\Entity\Post;
use Xaben\ForumBundle\Entity\Topic;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserdataUpdater
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $post = $args->getEntity();
        $em = $args->getEntityManager();

        if ($this->container->has('xaben.forum.usermanager')) {

            $userdata = $this->container->get('xaben.forum.usermanager')->getCurrentUser();

            if ($post instanceof Post) {
                $userdata->setPosts($userdata->getPosts() + 1);
                $userdata->setLastpost(new \Datetime());
                $em->persist($userdata);
            }

            if ($post instanceof Topic) {
                $userdata->setTopics($userdata->getTopics() + 1);
                $em->persist($userdata);
            }
        }
    }
}