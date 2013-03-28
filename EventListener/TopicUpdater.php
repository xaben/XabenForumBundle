<?php
namespace Xaben\ForumBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Xaben\ForumBundle\Entity\Post;

class TopicUpdater
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $post = $args->getEntity();
        $em = $args->getEntityManager();
        
        if ($post instanceof Post) {
            $topic = $post->getTopic();
            if (!$topic->getFirstPost()) {
                $topic->setFirstPost($post);
            }
            $topic->setLastPost($post);
            $topic->setReplies($topic->getReplies() + 1);
            $topic->setPostTime(new \DateTime);
            
            $em->persist($topic);
        }
    }
}