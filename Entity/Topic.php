<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
//use Xaben\ProfileBundle\Entity\User;

/**
 * Xaben\ForumBundle\Entity\Topic
 *
 * @ORM\Table(name="forum_topic")
 * @ORM\Entity(repositoryClass="Xaben\ForumBundle\Entity\TopicRepository")
 */
class Topic
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
     * @ORM\ManyToOne(targetEntity="Forum", inversedBy="topics")
     * @ORM\JoinColumn(name="forum_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    protected $forum;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="topic")
     */
    protected $posts;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\MaxLength(255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var time $post_time
     *
     * @ORM\Column(name="post_time", type="datetime")
     * @Assert\DateTime()
     */
    private $post_time;

    /**
     * @var integer $views
     *
     * @ORM\Column(name="views", type="integer")
     * @Assert\Type(type="integer")
     */
    private $views = 0;

    /**
     * @var integer $replies
     *
     * @ORM\Column(name="replies", type="integer")
     * @Assert\Type(type="integer")
     */
    private $replies = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Userdata")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $poster;

    /**
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="first_post_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $first_post;

    /**
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="last_post_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $last_post;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set post_time
     *
     * @param datetime $postTime
     */
    public function setPostTime($postTime)
    {
        $this->post_time = $postTime;
    }

    /**
     * Get post_time
     *
     * @return datetime
     */
    public function getPostTime()
    {
        return $this->post_time;
    }

    /**
     * Set views
     *
     * @param integer $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set replies
     *
     * @param integer $replies
     */
    public function setReplies($replies)
    {
        $this->replies = $replies;
    }

    /**
     * Get replies
     *
     * @return integer
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Set forum
     *
     * @param Xaben\ForumBundle\Entity\Forum $forum
     */
    public function setForum(\Xaben\ForumBundle\Entity\Forum $forum)
    {
        $this->forum = $forum;
    }

    /**
     * Get forum
     *
     * @return Xaben\ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Add posts
     *
     * @param Xaben\ForumBundle\Entity\Post $posts
     */
    public function addPost(\Xaben\ForumBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set poster
     *
     * @param Xaben\ForumBundle\Entity\Userdata $poster
     */
    public function setPoster(\Xaben\ForumBundle\Entity\Userdata $poster)
    {
        $this->poster = $poster;
    }

    /**
     * Get poster
     *
     * @return Xaben\ForumBundle\Entity\Userdata
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set first_post
     *
     * @param Xaben\ForumBundle\Entity\Post $firstPost
     */
    public function setFirstPost(\Xaben\ForumBundle\Entity\Post $firstPost)
    {
        $this->first_post = $firstPost;
    }

    /**
     * Get first_post
     *
     * @return Xaben\ForumBundle\Entity\Post
     */
    public function getFirstPost()
    {
        return $this->first_post;
    }

    /**
     * Set last_post
     *
     * @param Xaben\ForumBundle\Entity\Post $lastPost
     */
    public function setLastPost(\Xaben\ForumBundle\Entity\Post $lastPost)
    {
        $this->last_post = $lastPost;
    }

    /**
     * Get last_post
     *
     * @return Xaben\ForumBundle\Entity\Post
     */
    public function getLastPost()
    {
        return $this->last_post;
    }
}
