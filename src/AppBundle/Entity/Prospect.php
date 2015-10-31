<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use AppBundle\Entity\Rencontre;

/**
 * Prospect
 *
 * @ORM\Table(name="prospects")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ProspectRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Prospect
{        
    public function __construct()
    {
        $this->echanges = new ArrayCollection();
        $this->rencontres = new ArrayCollection();
    }   
   
    /**
     * Utilisé pour la création des dossier d'upload utilisateur
     * 
     * @var integer 
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $user_id;
    
    /**
     * Contient temporairement le chemin de la photo ($photoPrincipale)
     * 
     * @var string 
     */
    private $temp;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Echange", mappedBy="prospect") 
     */
    private $echanges;
    
    /**
     * @var Relation 
     * 
     * @ORM\OneToOne(targetEntity="Relation", inversedBy="prospect", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="relation_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $relation;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Rencontre", mappedBy="prospect") 
     */
    private $rencontres;
    
    /**
     * @var Source
     * 
     * @ORM\ManyToOne(targetEntity="Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     */
    private $source;
    
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
     * @ORM\Column(name="pseudo", type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="arrondissement", type="integer", nullable=true)
     */
    private $arrondissement;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=10, nullable=true)
     */
    private $numero;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero_dom", type="string", length=10, nullable=true)
     */
    private $numero_dom;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_etranger", type="string", length=50, nullable=true)
     */
    private $numero_etranger;   

    /**
     * @var string
     *
     * @ORM\Column(name="photo_principale", type="string", length=255, nullable=true)
     */
    private $photo_principale;
    
    /**
     * @var \Date
     * 
     * @ORM\Column(name="date_creation", type="date")
     */
    private $date_creation;    
    
    /**
     *
     * @Assert\File(maxSize="2000000")
     */
    private $file;
    
    // GETTERS AND SETTERS *****************************************************

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
     * Set user_id
     *
     * @param string $user_id
     * @return Prospect
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;        
        return $this;
    }
    
    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     * @return Prospect     
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;        
        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string 
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Prospect
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Prospect
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Prospect
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Prospect
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Get Source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }
    
    /**
     * Set source
     * 
     * @param string $source
     * @return \AppBundle\Entity\Prospect
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }
    
    /**
     * Set arrondissement
     *
     * @param integer $arrondissement
     * @return Prospect
     */
    public function setArrondissement($arrondissement)
    {
        $this->arrondissement = $arrondissement;
        return $this;
    }
    
    /**
     * Get arrondissement
     *
     * @return integer 
     */
    public function getArrondissement()
    {
        return $this->arrondissement;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Prospect
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Prospect
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    /**
     * Set numero_dom
     *
     * @param string $numero_dom
     * @return Prospect
     */
    public function setNumeroDom($numero_dom)
    {
        $this->numero_dom = $numero_dom;
        return $this;
    }

    /**
     * Get numero_dom
     *
     * @return string 
     */
    public function getNumeroDom()
    {
        return $this->numero_dom;
    }

    /**
     * Set numero_etranger
     *
     * @param string $numero_etranger
     * @return Prospect
     */
    public function setNumeroEtranger($numero_etranger)
    {
        $this->numero_etranger = $numero_etranger;
        return $this;
    }

    /**
     * Get numero_etranger
     *
     * @return string 
     */
    public function getNumeroEtranger()
    {
        return $this->numero_etranger;
    }

    /**
     * Set photo_principale
     *
     * @param string $photo_principale
     * @return Prospect
     */
    public function setPhotoPrincipale($photo_principale)
    {
        $this->photo_principale = $photo_principale;
        
        return $this;
    }

    /**
     * Get photo_principale
     *
     * @return string 
     */
    public function getPhotoPrincipale()
    {
        return $this->photo_principale;
    }
            
    /**
     * Sets file
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(UploadedFile $file = NULL)
    {
        $this->file = $file;
        
        // check if we have an old image path
        if(isset($this->photo_principale)){
            // store the old name to delete after the update
            $this->temp = $this->photo_principale;
            $this->photo_principale = NULL;
        }else{
            $this->photo_principale = 'initial';
        }
    }
    
    /**
     * Get file.
     * 
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add echanges
     *
     * @param \AppBundle\Entity\Echange $echanges
     * @return Prospect
     */
    public function addEchange(\AppBundle\Entity\Echange $echanges)
    {
        $this->echanges[] = $echanges;
        return $this;
    }

    /**
     * Remove echanges
     *
     * @param \AppBundle\Entity\Echange $echanges
     */
    public function removeEchange(\AppBundle\Entity\Echange $echanges)
    {
        $this->echanges->removeElement($echanges);
    }

    /**
     * Get echanges
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEchanges()
    {
        return $this->echanges;
    }

    /**
     * Set relation
     *
     * @param \AppBundle\Entity\Relation $relation
     * @return Prospect
     */
    public function setRelation(\AppBundle\Entity\Relation $relation = null)
    {
        $this->relation = $relation;
        $relation->setProspect($this);

        return $this;
    }

    /**
     * Get relation
     *
     * @return \AppBundle\Entity\Relation 
     */
    public function getRelation()
    {
        return $this->relation;
    }    
    
    /**
     * Get rencontres
     *
     * @return Rencontre 
     */
    public function getRencontres()
    {
        return $this->rencontres;
    }
    
    /**
     * Add Rencontre
     *
     * @param \AppBundle\Entity\Rencontre $rencontre
     * @return Prospect
     */
    public function addRencontre(\AppBundle\Entity\Rencontre $rencontre)
    {
        $this->rencontres[] = $rencontre;
        return $this;
    }

    /**
     * Remove Rencontre
     *
     * @param \AppBundle\Entity\Rencontre $rencontre
     */
    public function removeRencontre(\AppBundle\Entity\Rencontre $rencontre)
    {
        $this->rencontres->removeElement($rencontre);
    }
    
    /**
     * Render a Prospect as a string
     * 
     * @return string
     */
    public function __toString() 
    {
        return $this->getPrenom();
    }
    
    /**
     * Get web path to upload directory
     * 
     * @return string
     *  Relative path.
     */
    protected function getUploadPath()
    {
        return 'uploads/photoPrincipale/'.$this->user_id;
    }
    
    /**
     * Get absolute path to upload directory
     * 
     * @return string
     *  Absolute path.
     */
    protected function getUploadAbsolutePath()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadPath();
    }
    
    /**
     * Get web path to a photo principale.
     * 
     * @return null|string
     *  Relative path.
     */
    public function getPhotoPrincipaleWeb()
    {
        return NULL === $this->getPhotoPrincipale()
                ? NULL
                : $this->getUploadPath() . '/' . $this->getPhotoPrincipale();
    }
    
    /**
     * Get path on disk to a photo principale.
     * 
     * @return null|string
     *  Absolute path.
     */
    public function getPhotoPrincipaleAbsolute()
    {
        return NULL === $this->getPhotoPrincipale()
                ? NULL
                : $this->getUploadAbsolutePath() . '/' . $this->getPhotoPrincipale();
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(NULL !== $this->getFile()){
            // Generate a unique name
            $filename = sha1(uniqid(mt_rand(), TRUE));
            $extension = $this->getFile()->guessExtension();
            $this->photo_principale = $filename.'.'.$extension;
var_dump($this->photo_principale);

        }
    }
    
    /**
     * Upload une photo principale
     * 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
var_dump($this->getFile());

        // File property can be empty.
        if(NULL === $this->getFile()){
            return;
        }
var_dump($this->getFile());
var_dump($this->getUploadAbsolutePath());
var_dump($this->photo_principale);
var_dump($this->temp);
      
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadAbsolutePath(), $this->photo_principale);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadAbsolutePath().'/'.$this->temp);
            // clear the temp image path
            $this->temp = NULL;
        }
        
        $this->file = NULL;
    }
    
    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        $file = $this->getPhotoPrincipaleAbsolute();
        if($file){
            unlink($file);
        }
    }
    
    /**
    * Set date_creation
    *
    * @param \DateTime $date_creation
    * @return Prospect
    */
   public function setDateCreation($date_creation)
   {
           $this->date_creation = $date_creation;

           return $this;
   }

   /**
    * Get date_creation
    *
    * @return \DateTime 
    */
   public function getDateCreation()
   {
           return $this->date_creation;
   }
}
