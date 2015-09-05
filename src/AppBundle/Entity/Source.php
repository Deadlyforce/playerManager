<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Source
 *
 * @ORM\Table(name="sources")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SourceRepository")
 */
class Source
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false)
     */
    private $libelle;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Source
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
    
    /**
     * Retourne le libellé de l'entité (son nom)
     *  
     * @return string
     */
    public function __toString() 
    {
        return $this->getLibelle();
    }
}

