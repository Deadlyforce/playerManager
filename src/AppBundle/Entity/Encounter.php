<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Venue;

/**
 * Encounter
 *
 * @ORM\Table(name="encounters")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EncounterRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Encounter
{
    public function __construct() 
    {
        $this->venues = new ArrayCollection();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="expenses", type="integer", nullable=true)
     */
    private $expenses;

    /**
     * @var boolean
     *
     * @ORM\Column(name="venue_change", type="boolean", nullable=true)
     */
    private $venueChange;

    /**
     * @var json_array
     *
     * @ORM\Column(name="venues_list", type="json_array", nullable=true)
     */
//    private $venuesList;
    
    /**
     * @var ArrayCollection
     * 
     * @Assert\Count(
     *      max = "5",
     *      maxMessage = "You cannot specify more than {{ limit }} venues"
     * )
     * @ORM\OneToMany(targetEntity="Venue", mappedBy="encounter", cascade={"persist", "remove"}) 
     */
    private $venues;
    
    /**
     * @var Prospect
     * @ORM\ManyToOne(targetEntity="Prospect", inversedBy="encounters")
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE") 
     */
    private $prospect;

    

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Rencontre
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Encounter
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Encounter
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set expenses
     *
     * @param integer $expenses
     *
     * @return Rencontre
     */
    public function setExpenses($expenses)
    {
        $this->expenses = $expenses;

        return $this;
    }

    /**
     * Get expenses
     *
     * @return integer
     */
    public function getExpenses()
    {
        return $this->expenses;
    }

    /**
     * Set venueChange
     *
     * @param boolean $venueChange
     *
     * @return Encounter
     */
    public function setVenueChange($venueChange)
    {
        $this->venueChange = $venueChange;

        return $this;
    }

    /**
     * Get venueChange
     *
     * @return boolean
     */
    public function getVenueChange()
    {
        return $this->venueChange;
    }

    /**
     * Set venuesList
     *
     * @param json_array $venuesList
     *
     * @return Rencontre
     */
//    public function setVenuesList($venuesList)
//    {
//        $this->venuesList = $venuesList;
//
//        return $this;
//    }

    /**
     * Get venuesList
     *
     * @return json_array
     */
//    public function getVenuesList()
//    {
//        return $this->venuesList;
//    }
    
    /**
    * Get venues
    * 
    * @return Array
    */
   public function getVenues()
   {
        return $this->venues;
   }
   
   /**
    * Set Venue
    * 
    * @param Venue $venue
    * @return Encounter
    */
   public function addVenue(Venue $venue)
   {
        $this->venues[] = $venue;
        $venue->setEncounter($this);
        
        return $this;
   }
   
   /**
     * Remove Venue
     *
     * @param Venue $venue
     */
    public function removeVenue(Venue $venue)
    {
        $this->venues->removeElement($venue);
    }

    /**
     * Set prospect
     *
     * @return Rencontre
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect;

        return $this;
    }

    /**
     * Get Prospect
     *
     * @return Prospect
     */
    public function getProspect()
    {
        return $this->prospect;
    }
    
}

