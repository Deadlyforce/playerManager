<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Relationship
 *
 * @ORM\Table(name="relationships")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RelationshipRepository")
 */
class Relationship
{
    /**     
     * @var Prospect 
     * 
     * @ORM\OneToOne(targetEntity="Prospect", mappedBy="relationship", cascade={"persist"})
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prospect;
    
    /**
     * @var RelationshipRank
     * 
     * @ORM\ManyToOne(targetEntity="RelationshipRank") 
     * @ORM\JoinColumn(name="relationship_rank_id", referencedColumnName="id")
     */
    private $relationshipRank;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="meeting", type="boolean")
     */
    private $meeting;

    /**
     * @var integer
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * 
     * @ORM\Column(name="meeting_count", type="integer", nullable=true)
     */
    private $meetingCount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="numclosed", type="boolean")
     */
    private $numclosed;

    /**
     * @var integer
     *
     * @ORM\Column(name="kc", type="boolean")
     */
    private $kc;

    /**
     * @var integer
     *
     * @ORM\Column(name="fc", type="boolean")
     */
    private $fc;

    /**
     * @var integer
     *
     * @ORM\Column(name="distance", type="boolean")
     */
    private $distance;

    /**
     * @var integer
     *
     * @ORM\Column(name="flake", type="boolean")
     */
    private $flake;

    /**
     * @var text
     *
     * @ORM\Column(name="about", type="text", nullable=true)
     */
    private $about;


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
     * Set status
     *
     * @param boolean $status
     * @return Relationship
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set meeting
     *
     * @param boolean $meeting
     * @return Relationship
     */
    public function setMeeting($meeting)
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * Get meeting
     *
     * @return boolean 
     */
    public function getMeeting()
    {
        return $this->meeting;
    }
    
    /**
     * Set meetingCount
     *
     * @param integer $meetingCount
     * @return Relationship
     */
    public function setMeetingCount($meetingCount)
    {
        $this->meetingCount = $meetingCount;

        return $this;
    }

    /**
     * Get meetingCount
     *
     * @return integer 
     */
    public function getMeetingCount()
    {
        return $this->meetingCount;
    }

    /**
     * Set numclosed
     *
     * @param boolean $numclosed
     * @return Relationship
     */
    public function setNumclosed($numclosed)
    {
        $this->numclosed = $numclosed;
        return $this;
    }

    /**
     * Get numclosed
     *
     * @return boolean 
     */
    public function getNumclosed()
    {
        return $this->numclosed;
    }

    /**
     * Set kc
     *
     * @param integer $kc
     * @return Relationship
     */
    public function setKc($kc)
    {
        $this->kc = $kc;
        return $this;
    }

    /**
     * Get kc
     *
     * @return integer 
     */
    public function getKc()
    {
        return $this->kc;
    }

    /**
     * Set fc
     *
     * @param integer $fc
     * @return Relationship
     */
    public function setFc($fc)
    {
        $this->fc = $fc;
        return $this;
    }

    /**
     * Get fc
     *
     * @return integer 
     */
    public function getFc()
    {
        return $this->fc;
    }
    
    /**
     * Set RelationshipRank
     *
     * @param string $relationshipRank
     * @return RelationshipRank
     */
    public function setRelationshipRank($relationshipRank)
    {
        $this->relationshipRank = $relationshipRank;
        return $this;
    }

    /**
     * Get RelationshipRank
     *
     * @return string 
     */
    public function getRelationshipRank()
    {
        return $this->relationshipRank;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Relationship
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return integer 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set flake
     *
     * @param integer $flake
     * @return Relationship
     */
    public function setFlake($flake)
    {
        $this->flake = $flake;

        return $this;
    }

    /**
     * Get flake
     *
     * @return integer 
     */
    public function getFlake()
    {
        return $this->flake;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return Relationship
     */
    public function setAbout($about)
    {
        $this->commentaire = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }
    
    /*
     * Set prospect
     *
     * @param \AppBundle\Entity\Prospect $prospect
     * @return Relationship
    */
    public function setProspect(\AppBundle\Entity\Prospect $prospect = null)
    {
        $this->prospect = $prospect;
        
        return $this;
    }

    /**
     * Get prospect
     *
     * @return \AppBundle\Entity\Prospect 
    */
    public function getProspect()
    {
        return $this->prospect;
    }
    
    /**
     * Render a Relationship as a string
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getRelTypeString($this->getRelType());
    }
}
