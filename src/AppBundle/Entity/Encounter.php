<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Encounter
 *
 * @ORM\Table(name="encounters")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EncounterRepository")
 */
class Encounter
{
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
     * @ORM\Column(name="place", type="string", length=255, nullable=false)
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
    private $venuesList;
    
    /**
     * @var Prospect
     * @ORM\ManyToOne(targetEntity="Prospect", inversedBy="encounters")
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id") 
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
    public function setVenuesList($venuesList)
    {
        $this->venuesList = $venuesList;

        return $this;
    }

    /**
     * Get venuesList
     *
     * @return json_array
     */
    public function getVenuesList()
    {
        return $this->venuesList;
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
