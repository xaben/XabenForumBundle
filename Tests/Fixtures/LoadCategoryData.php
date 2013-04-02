<?php

namespace Xaben\ForumBundle\Tests\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Xaben\ForumBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cat1 = new Category();
        $cat1->setTitle('First category');
        $manager->persist($cat1);

        $cat2 = new Category();
        $cat2->setTitle('Second category');
        $manager->persist($cat2);

        $manager->flush();

        $this->addReference('category1', $cat1);
        $this->addReference('category2', $cat2);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
