<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rencontre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RencontreRepository")
 */
class Rencontre
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
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var integer
     *
     * @ORM\Column(name="depenses_total", type="integer", nullable=true)
     */
    private $depensesTotal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="changement_lieu", type="boolean", nullable=true)
     */
    private $changementLieu;

    /**
     * @var json
     *
     * @ORM\Column(name="liste_lieux", type="json_array", nullable=true)
     */
    private $listeLieux;
    
    /**
     * @var Prospect
     * @ORM\ManyToOne(targetEntity="Prospect", inversedBy="rencontres")
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
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Rencontre
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Rencontre
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set depensesTotal
     *
     * @param integer $depensesTotal
     *
     * @return Rencontre
     */
    public function setDepensesTotal($depensesTotal)
    {
        $this->depensesTotal = $depensesTotal;

        return $this;
    }

    /**
     * Get depensesTotal
     *
     * @return integer
     */
    public function getDepensesTotal()
    {
        return $this->depensesTotal;
    }

    /**
     * Set changementLieu
     *
     * @param boolean $changementLieu
     *
     * @return Rencontre
     */
    public function setChangementLieu($changementLieu)
    {
        $this->changementLieu = $changementLieu;

        return $this;
    }

    /**
     * Get changementLieu
     *
     * @return boolean
     */
    public function getChangementLieu()
    {
        return $this->changementLieu;
    }

    /**
     * Set listeLieux
     *
     * @param json $listeLieux
     *
     * @return Rencontre
     */
    public function setListeLieux($listeLieux)
    {
        $this->listeLieux = $listeLieux;

        return $this;
    }

    /**
     * Get listeLieux
     *
     * @return json
     */
    public function getListeLieux()
    {
        return $this->listeLieux;
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

