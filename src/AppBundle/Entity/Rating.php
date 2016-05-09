<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Prospect;

/**
 * Rating
 *
 * @ORM\Table(name="ratings") 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RatingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Rating
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
     * @ORM\OneToOne(targetEntity="Prospect", mappedBy="rating", cascade={"persist"})
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prospect;

    /**
     * @var smallint
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="attractiveness", type="smallint", nullable=true)
     */
    private $attractiveness;

    /**
     * @var smallint
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="socialStatus", type="smallint", nullable=true)
     */
    private $socialStatus;

    /**
     * @var smallint
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="senseHumor", type="smallint", nullable=true)
     */
    private $senseHumor;
    
    /**
     * @var smallint
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="cooking", type="smallint", nullable=true)
     */
    private $cooking;

    /**
     * @var smallint
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="kissing", type="smallint", nullable=true)
     */
    private $kissing;

    /**
     * @var smallint
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="sex", type="smallint", nullable=true)
     */
    private $sex;

    /**
     * @var smallint 
     * 
     * @ORM\Column(name="average", type="smallint", nullable=true)
     */
    private $average;
    
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
     * Set attractiveness
     *
     * @param integer $attractiveness
     *
     * @return Rating
     */
    public function setAttractiveness($attractiveness)
    {
        $this->attractiveness = $attractiveness;

        return $this;
    }

    /**
     * Get attractiveness
     *
     * @return int
     */
    public function getAttractiveness()
    {
        return $this->attractiveness;
    }

    /**
     * Set socialStatus
     *
     * @param integer $socialStatus
     *
     * @return Rating
     */
    public function setSocialStatus($socialStatus)
    {
        $this->socialStatus = $socialStatus;

        return $this;
    }

    /**
     * Get socialStatus
     *
     * @return int
     */
    public function getSocialStatus()
    {
        return $this->socialStatus;
    }

    /**
     * Set senseHumor
     *
     * @param integer $senseHumor
     *
     * @return Rating
     */
    public function setSenseHumor($senseHumor)
    {
        $this->senseHumor = $senseHumor;

        return $this;
    }

    /**
     * Get cooking
     *
     * @return int
     */
    public function getCooking()
    {
        return $this->cooking;
    }

    /**
     * Set cooking
     *
     * @param integer $cooking
     * @return Rating
     */
    public function setCooking($cooking)
    {
        $this->cooking = $cooking;

        return $this;
    }

    /**
     * Get senseHumor
     *
     * @return int
     */
    public function getSenseHumor()
    {
        return $this->senseHumor;
    }

    /**
     * Set kissing
     *
     * @param integer $kissing
     *
     * @return Rating
     */
    public function setKissing($kissing)
    {
        $this->kissing = $kissing;

        return $this;
    }

    /**
     * Get kissing
     *
     * @return int
     */
    public function getKissing()
    {
        return $this->kissing;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     *
     * @return Rating
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }
    
    
    /**
     * Set prospect
     *
     * @param Prospect $prospect
     * @return Relationship
     */
    public function setProspect(Prospect $prospect)
    {
        $this->prospect = $prospect;
        
        return $this;
    }

    /**
     * Get prospect
     *
     * @return prospect 
     */
    public function getProspect()
    {
        return $this->prospect;
    }
    
    /**
     * Set average
     *
     * @param smallint $average
     * @return Rating
     */
    public function setAverage($average)
    {
        $this->average = $average;
        
        return $this;
    }

    /**
     * Get average
     *
     * @return average 
     */
    public function getAverage()
    {
        return $this->average;
    }
    
    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function saveAveragedAttributes()
    {
        $avg = ($this->attractiveness + $this->cooking + $this->kissing + $this->senseHumor + $this->sex + $this->socialStatus)/6;
        $whole = floor($avg);
        $deci = $avg - $whole;
        
        if ($deci >= 0.5) {
            $roundedAvg = ceil($avg);
        } else {
            $roundedAvg = floor($avg);
        }

        $this->average = intval($roundedAvg);
    }
}

