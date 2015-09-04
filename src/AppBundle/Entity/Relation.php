<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relations")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RelationRepository")
 */
class Relation
{
    const RELTYPE_Discussion = 0;
    const RELTYPE_Dating = 1;
    const RELTYPE_OneNightStand = 2;
    const RELTYPE_FuckBuddy = 3;
    const RELTYPE_Girlfriend = 4;
    const RELTYPE_OpenRelationship = 5;
    
    private static $relTypeValues = NULL;
    
    /**     
     * @var Prospect 
     * 
     * @ORM\OneToOne(targetEntity="Prospect", mappedBy="relations", cascade={"persist"})
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prospect;
    
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

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="rel_type", type="string")
//     */
//    private $relType;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="rel_type", type="integer")
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
     * Construit et retourne un tableau de valeurs pour la colonne "relType"
     * 
     * @return array $relTypeValues
     */
    static public function getRelTypeChoices()
    {
        // Build $relTypeValues if that is the first call
       if(self::$relTypeValues == NULL){
           
           self::$relTypeValues = array();
           
           $myClass = new \ReflectionClass('\AppBundle\Entity\Relation'); // ReflectionClass récupère toutes infos sur une classe
           $classConstants = $myClass->getConstants();
           $constantPrefix = "RELTYPE_";
           
           foreach($classConstants as $key => $value){
               $valueName = substr($key, 8);
//               if(substr($key, 0, strlen($constantPrefix)) === $constantPrefix){
                    self::$relTypeValues[$value] = $valueName;
//               }
           }         
       }
  
       return self::$relTypeValues;
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
     * Set relType
     *
     * @param integer $relType
     * @return Relation
     */
    public function setRelType($relType)
    {
        if(!array_key_exists($relType, self::getRelTypeChoices())){
            throw new \InvalidArgumentException('Entrée non valide');
        }
        $this->relType = $relType;
        
        return $this;
    }

    /**
     * Get relType
     *
     * @return integer 
     */
    public function getRelType()
    {
        return $this->relType;
    }
    
    /**
     * Transforme la valeur en base de relType (integer) en chaîne de caractères pour l'affichage
     * 
     * @param integer $relType
     * @return string $relType
     */
    public function getRelTypeString($relType)
    {
        $array = self::getRelTypeChoices(); 
// var_dump($array);

        $this->relType = $array[$relType];
// var_dump($this->relType);
// die();        
        return $this->relType;
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
