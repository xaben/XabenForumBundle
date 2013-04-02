<?php


namespace Xaben\ForumBundle\Tests\Liip;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerFunctionalTest extends WebTestCase
{
    public function testIndexPage()
    {
        //test with no categories
        $this->loadFixtures(array());
        $content = $this->fetchContent('/forum/', 'GET', false);
        $this->assertContains('No categories configured', $content);

        //test with 2 categories but no forums
        $this->loadFixtures(array(
            'Xaben\ForumBundle\Tests\Fixtures\LoadCategoryData',
        ));
        $content = $this->fetchContent('/forum/', 'GET', false);
        $this->assertContains('First category', $content);
        $this->assertContains('Second category', $content);
        $this->assertContains('No forum configured in this category', $content);


        //test with 2 categories and 4 forums
        $this->loadFixtures(array(
            'Xaben\ForumBundle\Tests\Fixtures\LoadCategoryData',
            'Xaben\ForumBundle\Tests\Fixtures\LoadForumData',
        ));
        $content = $this->fetchContent('/forum/', 'GET', false);
        $this->assertContains('First category', $content);
        $this->assertContains('Second category', $content);
        $this->assertContains('First forum', $content);
        $this->assertContains('Second forum', $content);
        $this->assertContains('Third forum', $content);
        $this->assertContains('Fourth forum', $content);
        $this->assertContains('First forum description', $content);
        $this->assertContains('Second forum description', $content);
        $this->assertContains('Third forum description', $content);
        $this->assertContains('Fourth forum description', $content);
    }

    public function test404Page()
    {
        $this->fetchContent('/asdasdas', 'GET', false, false);
    }
}
