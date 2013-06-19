<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Xaben\ForumBundle\Entity\Forum
 *
 * @ORM\Table(name="forum_forum")
 * @ORM\Entity(repositoryClass="Xaben\ForumBundle\Entity\ForumRepository")
 */
class Forum
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
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="forums")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="forum")
     */
    protected $topics;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "The title must be at least {{ limit }} characters length",
     *      maxMessage = "The title cannot be longer than {{ limit }} characters length"
     * )
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer $position
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $position;

    /**
     * @var integer $posts
     *
     * @ORM\Column(name="posts", type="integer")
     * @Assert\Type(type="integer")
     */
    private $posts = 0;

    /**
     * @var integer $topiccount
     *
     * @ORM\Column(name="topiccount", type="integer")
     * @Assert\Type(type="integer")
     */
    private $topiccount = 0;

    /**
     * @ORM\OneToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="last_post_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $last_post;

    public function __construct()
    {
        $this->topics = new ArrayCollection();
    }

    public function __toString()
    {
        return null === $this->title ? '' : $this->title;
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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
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
     * Set topiccount
     *
     * @param integer $topiccount
     */
    public function setTopiccount($topiccount)
    {
        $this->topiccount = $topiccount;
    }

    /**
     * Get topiccount
     *
     * @return integer
     */
    public function getTopiccount()
    {
        return $this->topiccount;
    }

    /**
     * Set category
     *
     * @param Xaben\ForumBundle\Entity\Category $category
     */
    public function setCategory(\Xaben\ForumBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Xaben\ForumBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add topics
     *
     * @param Xaben\ForumBundle\Entity\Topic $topics
     */
    public function addTopic(\Xaben\ForumBundle\Entity\Topic $topics)
    {
        $this->topics[] = $topics;
    }

    /**
     * Get topics
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTopics()
    {
        return $this->topics;
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
