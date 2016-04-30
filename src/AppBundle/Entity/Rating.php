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
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id")
     */
    private $prospect;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="attractiveness", type="integer", nullable=true)
     */
    private $attractiveness;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="socialStatus", type="integer", nullable=true)
     */
    private $socialStatus;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="senseHumor", type="integer", nullable=true)
     */
    private $senseHumor;
    
    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="cooking", type="integer", nullable=true)
     */
    private $cooking;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="kissing", type="integer", nullable=true)
     */
    private $kissing;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="sex", type="integer", nullable=true)
     */
    private $sex;


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
     * @return Prospect 
     */
    public function getProspect()
    {
        return $this->prospect;
    }
}

