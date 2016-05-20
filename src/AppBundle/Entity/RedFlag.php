<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * RedFlag
 *
 * @ORM\Table(name="redflags")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RedFlagRepository")
 * @ORM\HasLifecycleCallbacks
 */
class RedFlag
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
     * @ORM\OneToOne(targetEntity="Prospect", mappedBy="redflag", cascade={"persist"})
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @ORM\Column(name="unemployed", type="smallint", nullable=true)
     */
    private $unemployed;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="needy", type="smallint", nullable=true)
     */
    private $needy;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="children", type="smallint", nullable=true)
     */
    private $children;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="smoker", type="smallint", nullable=true)
     */
    private $smoker;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="checkphone", type="smallint", nullable=true)
     */
    private $checkphone;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="boring", type="smallint", nullable=true)
     */
    private $boring;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="selfAbsorbed", type="smallint", nullable=true)
     */
    private $selfAbsorbed;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="cheapdate", type="smallint", nullable=true)
     */
    private $cheapdate;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="snore", type="smallint", nullable=true)
     */
    private $snore;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      minMessage = "Unauthorized number",
     *      maxMessage = "Unauthorized number"
     * )
     * @ORM\Column(name="hygiene", type="smallint", nullable=true)
     */
    private $hygiene;
    
    /**
     * @var smallint 
     * 
     * @ORM\Column(name="average", type="smallint", nullable=true)
     */
    private $average;
    
    /**
     * @var float 
     * 
     * @ORM\Column(name="percentAverage", type="float", nullable=true)
     */
    private $percentAverage;


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
     * Set unemployed
     *
     * @param integer $unemployed
     *
     * @return RedFlag
     */
    public function setUnemployed($unemployed)
    {
        $this->unemployed = $unemployed;

        return $this;
    }

    /**
     * Get unemployed
     *
     * @return int
     */
    public function getUnemployed()
    {
        return $this->unemployed;
    }

    /**
     * Set needy
     *
     * @param integer $needy
     *
     * @return RedFlag
     */
    public function setNeedy($needy)
    {
        $this->needy = $needy;

        return $this;
    }

    /**
     * Get needy
     *
     * @return int
     */
    public function getNeedy()
    {
        return $this->needy;
    }

    /**
     * Set children
     *
     * @param integer $children
     *
     * @return RedFlag
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return int
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set smoker
     *
     * @param integer $smoker
     *
     * @return RedFlag
     */
    public function setSmoker($smoker)
    {
        $this->smoker = $smoker;

        return $this;
    }

    /**
     * Get smoker
     *
     * @return int
     */
    public function getSmoker()
    {
        return $this->smoker;
    }

    /**
     * Set checkphone
     *
     * @param integer $checkphone
     *
     * @return RedFlag
     */
    public function setCheckphone($checkphone)
    {
        $this->checkphone = $checkphone;

        return $this;
    }

    /**
     * Get checkphone
     *
     * @return int
     */
    public function getCheckphone()
    {
        return $this->checkphone;
    }

    /**
     * Set boring
     *
     * @param integer $boring
     *
     * @return RedFlag
     */
    public function setBoring($boring)
    {
        $this->boring = $boring;

        return $this;
    }

    /**
     * Get boring
     *
     * @return int
     */
    public function getBoring()
    {
        return $this->boring;
    }

    /**
     * Set selfAbsorbed
     *
     * @param integer $selfAbsorbed
     *
     * @return RedFlag
     */
    public function setSelfAbsorbed($selfAbsorbed)
    {
        $this->selfAbsorbed = $selfAbsorbed;

        return $this;
    }

    /**
     * Get selfAbsorbed
     *
     * @return int
     */
    public function getSelfAbsorbed()
    {
        return $this->selfAbsorbed;
    }

    /**
     * Set cheapdate
     *
     * @param integer $cheapdate
     *
     * @return RedFlag
     */
    public function setCheapdate($cheapdate)
    {
        $this->cheapdate = $cheapdate;

        return $this;
    }

    /**
     * Get cheapdate
     *
     * @return int
     */
    public function getCheapdate()
    {
        return $this->cheapdate;
    }

    /**
     * Set snore
     *
     * @param integer $snore
     *
     * @return RedFlag
     */
    public function setSnore($snore)
    {
        $this->snore = $snore;

        return $this;
    }

    /**
     * Get snore
     *
     * @return int
     */
    public function getSnore()
    {
        return $this->snore;
    }

    /**
     * Set hygiene
     *
     * @param integer $hygiene
     * @return RedFlag
     */
    public function setHygiene($hygiene)
    {
        $this->hygiene = $hygiene;

        return $this;
    }

    /**
     * Get hygiene
     *
     * @return int
     */
    public function getHygiene()
    {
        return $this->hygiene;
    }

    /**
     * Set prospect
     *
     * @param integer $prospect
     * @return RedFlag
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect;

        return $this;
    }

    /**
     * Get prospect
     *
     * @return int
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
     * Set percentAverage
     *
     * @param smallint $percentAverage
     * @return Rating
     */
    public function setPercentAverage($percentAverage)
    {
        $this->percentAverage = $percentAverage;
        
        return $this;
    }

    /**
     * Get percentAverage
     *
     * @return percentAverage 
     */
    public function getPercentAverage()
    {
        return $this->percentAverage;
    }
    
    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function saveAveragedAttributes()
    {
        $total = 10;
        $attributes =  array($this->unemployed, $this->needy, $this->children, $this->smoker, $this->checkphone, $this->boring, $this->selfAbsorbed, $this->cheapdate, $this->snore,  $this->hygiene);
        foreach($attributes as $attribute){
            if ($attribute === null) {
                $total = $total - 1;
            }
        }
   
        $avg = (array_sum($attributes))/$total;
        $whole = floor($avg);
        $deci = $avg - $whole;
        
        if ($deci >= 0.5) {
            $roundedAvg = ceil($avg);
        } else {
            $roundedAvg = floor($avg);
        }

        $this->average = intval($roundedAvg);
    }
    
    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function saveExactAveragedAttributes()
    {
        $total = 10;
        $attributes =  array($this->unemployed, $this->needy, $this->children, $this->smoker, $this->checkphone, $this->boring, $this->selfAbsorbed, $this->cheapdate, $this->snore,  $this->hygiene);
        foreach($attributes as $attribute){
            if ($attribute === null) {
                $total = $total - 1;
            }
        }
        
        $avg = (array_sum($attributes))/$total;
        $percentAvg = round($avg, 1) * 20;
                
        $this->percentAverage = $percentAvg;
    }
}

