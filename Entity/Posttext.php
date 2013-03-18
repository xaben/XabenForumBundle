<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Xaben\ForumBundle\Entity\Posttext
 *
 * @ORM\Table(name="forum_posttext")
 * @ORM\Entity(repositoryClass="Xaben\ForumBundle\Entity\PosttextRepository")
 */
class Posttext
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
     * @var text $text
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\OneToOne(targetEntity="Xaben\ForumBundle\Entity\Post", inversedBy="posttext")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $post;

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
     * Set text
     *
     * @param text $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set post
     *
     * @param  Xaben\ForumBundle\Entity\Post $post
     * @return Posttext
     */
    public function setPost(\Xaben\ForumBundle\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return Xaben\ForumBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
