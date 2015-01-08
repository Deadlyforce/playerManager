<?php

namespace playerManager\WelcomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relations
 *
 * @ORM\Table(name="relations")
 * @ORM\Entity(repositoryClass="playerManager\WelcomeBundle\Entity\RelationsRepository")
 */
class Relations
{
    /**     
     * @var Prospects 
     * 
     * @ORM\OneToOne(targetEntity="Prospects", mappedBy="relations", cascade={"persist"})
     * @ORM\JoinColumn(name="prospects_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prospects;
    
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
     * @var string
     *
     * @ORM\Column(name="rel_type", type="string", columnDefinition="enum('discussion','dating','ons','fb','gf','or')")
     */
    private $relType;

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
     * @return Relations
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
     * @return Relations
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
     * @return Relations
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
     * @return Relations
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
     * @return Relations
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
     * @return Relations
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
     * Set relType
     *
     * @param string $relType
     * @return Relations
     */
    public function setRelType($relType)
    {
        $this->relType = $relType;

        return $this;
    }

    /**
     * Get relType
     *
     * @return string 
     */
    public function getRelType()
    {
        return $this->relType;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Relations
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
     * @return Relations
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
     * @return Relations
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
     * Set prospects
     *
     * @param \playerManager\WelcomeBundle\Entity\Prospects $prospects
     * @return Relations
    */
    public function setProspects(\playerManager\WelcomeBundle\Entity\Prospects $prospects = null)
    {
        $this->prospects = $prospects;
        
        return $this;
    }

    /**
     * Get prospects
     *
     * @return \playerManager\WelcomeBundle\Entity\Prospects 
    */
    public function getProspects()
    {
        return $this->prospects;
    }

}
