<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Option
 *
 * @ORM\Table(name="options")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OptionRepository")
 */
class Option
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var Prospect
     * 
     * @ORM\OneToOne(targetEntity="User", mappedBy="option", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="orderby", type="string", length=20, nullable=true)
     */
    private $orderby;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=1,nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="relationshipLevel", type="string", length=1,nullable=true)
     */
    private $relationshipLevel;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set orderby
     *
     * @param string $orderby
     *
     * @return Option
     */
    public function setOrderby($orderby)
    {
        $this->orderby = $orderby;

        return $this;
    }

    /**
     * Get orderby
     *
     * @return string
     */
    public function getOrderby()
    {
        return $this->orderby;
    }

    /**
     * Set sex
     *
     * @param smallint $sex
     *
     * @return Option
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return smallint
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set relationshipLevel
     *
     * @param smallint $relationshipLevel
     *
     * @return Option
     */
    public function setRelationshipLevel($relationshipLevel)
    {
        $this->relationshipLevel = $relationshipLevel;

        return $this;
    }

    /**
     * Get relationshipLevel
     *
     * @return smallint
     */
    public function getRelationshipLevel()
    {
        return $this->relationshipLevel;
    }
    
    /**
     * Set user
     *
     * @param User $user
     * @return Option
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}

