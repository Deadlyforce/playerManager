<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relations")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RelationRepository")
 */
class Relation
{        
    /**     
     * @var Prospect 
     * 
     * @ORM\OneToOne(targetEntity="Prospect", mappedBy="relations", cascade={"persist"})
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prospect;
    
    /**
     * @var Categorie
     * 
     * @ORM\ManyToOne(targetEntity="Categorie") 
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     */
    private $categorie;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="boolean")
     */
    private $statut;

    /**
     * @var integer
     *
     * @ORM\Column(name="rencontre", type="integer")
     */
    private $rencontre;

    /**
     * @var integer
     *
     * @ORM\Column(name="rencontre_count", type="integer", nullable=true)
     */
    private $rencontreCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="boolean")
     */
    private $numero;

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
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;


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
     * Set statut
     *
     * @param string $statut
     * @return Relation
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set rencontre
     *
     * @param integer $rencontre
     * @return Relation
     */
    public function setRencontre($rencontre)
    {
        $this->rencontre = $rencontre;

        return $this;
    }

    /**
     * Get rencontre
     *
     * @return integer 
     */
    public function getRencontre()
    {
        return $this->rencontre;
    }    
    
    /**
     * Set rencontreCount
     *
     * @param integer $rencontreCount
     * @return Relation
     */
    public function setRencontreCount($rencontreCount)
    {
        $this->rencontreCount = $rencontreCount;

        return $this;
    }

    /**
     * Get rencontreCount
     *
     * @return integer 
     */
    public function getRencontreCount()
    {
        return $this->rencontreCount;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Relation
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set kc
     *
     * @param integer $kc
     * @return Relation
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
     * @return Relation
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
     * Set Categorie
     *
     * @param string $categorie
     * @return Relation
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get Categorie
     *
     * @return string 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }      

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Relation
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
     * @return Relation
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
     * Set commentaire
     *
     * @param string $commentaire
     * @return Relation
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
    
    /*
     * Set prospect
     *
     * @param \AppBundle\Entity\Prospect $prospect
     * @return Relation
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
     * Render a Relation as a string
     * 
     * @return string
     */
    public function __toString() 
    {
        return $this->getRelTypeString($this->getRelType());
    }
}
