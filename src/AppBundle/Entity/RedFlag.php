<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Prospect;

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
     * @var boolean
     *
     * @ORM\Column(name="unemployed", type="boolean")
     */
    private $unemployed;

    /**
     * @var boolean
     *     
     * @ORM\Column(name="needy", type="boolean", nullable=true)
     */
    private $needy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="children", type="boolean")
     */
    private $children;

    /**
     * @var boolean
     *
     * @ORM\Column(name="smoker", type="boolean")
     */
    private $smoker;

    /**
     * @var boolean
     *
     * @ORM\Column(name="snore", type="boolean")
     */
    private $snore;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hygiene", type="boolean")
     */
    private $hygiene;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="religion", type="boolean")
     */
    private $religion;
    
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
     * Set religion
     *
     * @param integer $religion
     * @return RedFlag
     */
    public function setReligion($religion)
    {
        $this->religion = $religion;

        return $this;
    }

    /**
     * Get religion
     *
     * @return int
     */
    public function getReligion()
    {
        return $this->religion;
    }

    /**
     * Set prospect
     *
     * @param Prospect $prospect
     * @return RedFlag
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
        $attributes =  array(
            $this->unemployed, 
            $this->needy, 
            $this->children, 
            $this->smoker, 
            $this->snore,  
            $this->hygiene,
            $this->religion
        );
   
        $avg = (array_sum($attributes)/count($attributes))*5;
        
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
        $attributes =  array(
            $this->unemployed, 
            $this->needy, 
            $this->children, 
            $this->smoker, 
            $this->snore,  
            $this->hygiene,
            $this->religion
        );
        
        $avg = ((array_sum($attributes))/count($attributes))*5;
        $percentAvg = round($avg, 1) * 20;
                
        $this->percentAverage = $percentAvg;
    }
}

