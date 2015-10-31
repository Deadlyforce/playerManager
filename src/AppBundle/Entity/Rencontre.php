<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rencontre
 *
 * @ORM\Table(name="rencontres")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RencontreRepository")
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
    private $depenses_total;

    /**
     * @var boolean
     *
     * @ORM\Column(name="changement_lieu", type="boolean", nullable=true)
     */
    private $changement_lieu;

    /**
     * @var json
     *
     * @ORM\Column(name="liste_lieux", type="json_array", nullable=true)
     */
    private $liste_lieux;
    
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
     * Set depenses_total
     *
     * @param integer $depenses_total
     *
     * @return Rencontre
     */
    public function setDepensesTotal($depenses_total)
    {
        $this->depenses_total = $depenses_total;

        return $this;
    }

    /**
     * Get depenses_total
     *
     * @return integer
     */
    public function getDepensesTotal()
    {
        return $this->depenses_total;
    }

    /**
     * Set changement_lieu
     *
     * @param boolean $changement_lieu
     *
     * @return Rencontre
     */
    public function setChangementLieu($changement_lieu)
    {
        $this->changement_lieu = $changement_lieu;

        return $this;
    }

    /**
     * Get changement_lieu
     *
     * @return boolean
     */
    public function getChangementLieu()
    {
        return $this->changement_lieu;
    }

    /**
     * Set liste_lieux
     *
     * @param json $liste_lieux
     *
     * @return Rencontre
     */
    public function setListeLieux($liste_lieux)
    {
        $this->liste_lieux = $liste_lieux;

        return $this;
    }

    /**
     * Get liste_lieux
     *
     * @return json
     */
    public function getListeLieux()
    {
        return $this->liste_lieux;
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

