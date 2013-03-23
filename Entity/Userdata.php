<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\UserInterface;

/**
 * Xaben\ForumBundle\Entity\Userdata
 *
 * @ORM\Table(name="forum_userdata")
 * @ORM\Entity(repositoryClass="Xaben\ForumBundle\Entity\UserdataRepository")
 */
class Userdata
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="FOS\UserBundle\Model\UserInterface")
     * @var UserInterface
     */
    protected $baseuser;

    /**
     * @var integer $posts
     *
     * @ORM\Column(name="posts", type="integer")
     * @Assert\Type(type="integer")
     */
    private $posts = 0;

    /**
     * @var integer $topics
     *
     * @ORM\Column(name="topics", type="integer")
     * @Assert\Type(type="integer")
     */
    private $topics = 0;

    public function __toString()
    {
        return $this->baseuser->getUsername();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set baseuser
     *
     * @param FOS\UserBundle\Model\UserInterface $masteruser
     */
    public function setBaseuser($baseuser)
    {
        $this->baseuser = $baseuser;
    }

    /**
     * Get baseuser
     *
     * @return FOS\UserBundle\Model\UserInterface
     */
    public function getBaseuser()
    {
        return $this->baseuser;
    }

    /**
     * Set posts
     *
     * @param integer $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get posts
     *
     * @return integer
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set topics
     *
     * @param integer $topics
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getTopics()
    {
        return $this->topics;
    }
}
