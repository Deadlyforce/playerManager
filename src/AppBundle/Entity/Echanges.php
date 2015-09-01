<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Echanges
 *
 * @ORM\Table(name="echanges")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EchangesRepository")
 */
class Echanges
{
    /**
     * @var Prospects 
     * 
     * @ORM\ManyToOne(targetEntity="Prospects", inversedBy="echanges")
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prospect;
    
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;


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
     * @return Echanges
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
     * Set contenu
     *
     * @param string $contenu
     * @return Echanges
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }   

    /**
     * Set prospects
     *
     * @param \AppBundle\Entity\Prospects $prospect
     * @return Echanges
     */
    public function setProspect(\AppBundle\Entity\Prospects $prospect = null)
    {
        $this->prospect = $prospect;

        return $this;
    }

    /**
     * Get prospects
     *
     * @return \AppBundle\Entity\Prospects 
     */
    public function getProspect()
    {
        return $this->prospect;
    }
}
