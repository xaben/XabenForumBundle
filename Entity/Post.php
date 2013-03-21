<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Xaben\ProfileBundle\Entity\User;

/**
 * Xaben\ForumBundle\Entity\Post
 *
 * @ORM\Table(name="forum_post")
 * @ORM\Entity(repositoryClass="Xaben\ForumBundle\Entity\PostRepository")
 */
class Post
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
     * @ORM\ManyToOne(targetEntity="Topic", inversedBy="posts")
     * @ORM\JoinColumn(name="topic_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $topic;

    /**
     * @ORM\ManyToOne(targetEntity="Userdata")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank
     */
    protected $poster;

    /**
     * @var datetime $post_time
     *
     * @ORM\Column(name="post_time", type="datetime")
     * @Assert\DateTime()
     */
    private $post_time;

    /**
     * @var string $ip
     *
     * @ORM\Column(name="ip", type="string", length=255)
     * @Assert\Ip
     */
    private $ip;

    /**
     * @var datetime $edit_time
     *
     * @ORM\Column(name="edit_time", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $edit_time;

    /**
     * @var integer $edit_count
     *
     * @ORM\Column(name="edit_count", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $edit_count;

    /**
     * @ORM\OneToOne(targetEntity="Posttext", mappedBy="post")
     * @Assert\NotBlank()
     */
    protected $posttext;

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
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set edit_time
     *
     * @param datetime $editTime
     */
    public function setEditTime($editTime)
    {
        $this->edit_time = $editTime;
    }

    /**
     * Get edit_time
     *
     * @return datetime
     */
    public function getEditTime()
    {
        return $this->edit_time;
    }

    /**
     * Set edit_count
     *
     * @param integer $editCount
     */
    public function setEditCount($editCount)
    {
        $this->edit_count = $editCount;
    }

    /**
     * Get edit_count
     *
     * @return integer
     */
    public function getEditCount()
    {
        return $this->edit_count;
    }

    /**
     * Set topic
     *
     * @param Xaben\ForumBundle\Entity\Topic $topic
     */
    public function setTopic(\Xaben\ForumBundle\Entity\Topic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Get topic
     *
     * @return Xaben\ForumBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
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
     * @return Xaben\ProfileBundle\Entity\Userdata
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set posttext
     *
     * @param  Xaben\ForumBundle\Entity\Posttext $posttext
     * @return Post
     */
    public function setPosttext(\Xaben\ForumBundle\Entity\Posttext $posttext = null)
    {
        $this->posttext = $posttext;

        return $this;
    }

    /**
     * Get posttext
     *
     * @return Xaben\ForumBundle\Entity\Posttext
     */
    public function getPosttext()
    {
        return $this->posttext;
    }
}
