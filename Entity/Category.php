<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Xaben\ForumBundle\Entity\Category
 *
 * @ORM\Table(name="forum_category")
 * @ORM\Entity(repositoryClass="Xaben\ForumBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Forum", mappedBy="category")
     */
    protected $forums;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\MaxLength(255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var integer $sort
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer", nullable=true)
     * @Assert\Type(type="integer")
     */
    private $position;

    public function __construct()
    {
        $this->forums = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
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
     * Add forums
     *
     * @param Xaben\ForumBundle\Entity\Forum $forums
     */
    public function addForum(\Xaben\ForumBundle\Entity\Forum $forums)
    {
        $this->forums[] = $forums;
    }

    /**
     * Get forums
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getForums()
    {
        return $this->forums;
    }
}
