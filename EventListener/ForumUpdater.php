<?php
namespace Xaben\ForumBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Xaben\ForumBundle\Entity\Post;
use Xaben\ForumBundle\Entity\Topic;

class ForumUpdater
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        
        if ($entity instanceof Post) {
            $forum = $entity->getTopic()->getForum();
            $forum->setPosts($forum->getPosts() + 1);
            $forum->setLastPost($entity);
            
            $em->persist($forum);
        }
        
        if ($entity instanceof Topic) {
            $forum = $entity->getForum();
            $forum->setTopiccount($forum->getTopiccount() + 1);
            
            $em->persist($forum);
        }
    }
}