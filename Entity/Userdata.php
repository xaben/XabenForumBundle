<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\UserInterface;

/**
 * Xaben\ForumBundle\Entity\Userdata
 *
 * @ORM\Table(name="forum_userdata")
 * @ORM\Entity()
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
    public function setMasteruser(FOS\UserBundle\Model\UserInterface $baseuser)
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
}
