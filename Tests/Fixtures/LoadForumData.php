<?php

namespace Xaben\ForumBundle\Tests\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Xaben\ForumBundle\Entity\Forum;


class LoadForumData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $forum1 = new Forum();
        $forum1->setTitle('First forum');
        $forum1->setDescription('First forum description');
        $forum1->setCategory($this->getReference('category1'));
        $manager->persist($forum1);

        $forum2 = new Forum();
        $forum2->setTitle('Second forum');
        $forum2->setDescription('Second forum description');
        $forum2->setCategory($this->getReference('category1'));
        $manager->persist($forum2);

        $forum3 = new Forum();
        $forum3->setTitle('Third forum');
        $forum3->setDescription('Third forum description');
        $forum3->setCategory($this->getReference('category2'));
        $manager->persist($forum3);

        $forum4 = new Forum();
        $forum4->setTitle('Fourth forum');
        $forum4->setDescription('Fourth forum description');
        $forum4->setCategory($this->getReference('category2'));
        $manager->persist($forum4);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
