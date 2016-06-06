<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venue
 *
 * @ORM\Table(name="venue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VenueRepository")
 */
class Venue
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
     * @ORM\ManyToOne(targetEntity="Encounter", inversedBy="venues")
     * @ORM\JoinColumn(name="encounter_id", referencedColumnName="id", onDelete="CASCADE") 
     */
    private $encounter;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     *
     * @return Venue
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set encounter
     *
     * @param Encounter $encounter
     * @return venue
     */
    public function setEncounter($encounter)
    {
        $this->encounter = $encounter;     
        
        return $this;
    }
    
    /**
     * Get encounter
     *
     * @return Encounter 
     */
    public function getEncounter()
    {
        return $this->encounter;
    }
    
    public function __toString() 
    {
        return $this->getName();
    }
}

