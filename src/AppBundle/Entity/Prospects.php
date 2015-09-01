<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Prospects
 *
 * @ORM\Table(name="prospects")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProspectsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Prospects
{
        
    public function __construct()
    {
        $this->echanges = new ArrayCollection();
        $this->rencontres = new ArrayCollection();
    }
    
    // Enum de la colonne "site"    
    const SITE_VAL1 = "AdopteUnMec";
    const SITE_VAL2 = "OkCupid";
    const SITE_VAL3 = "Tinder";
    const SITE_VAL4 = "NightGame";
    const SITE_VAL5 = "DayGame";
    const SITE_VAL6 = "SocialCircle";
    const SITE_VAL7 = "Facebook";
    
    static private $siteValues = NULL;
    
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
     * @ORM\OneToMany(targetEntity="Echanges", mappedBy="prospect") 
     */
    private $echanges;
    
    /**
     * @var Relations 
     * 
     * @ORM\OneToOne(targetEntity="Relations", inversedBy="prospects", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="relations_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $relations;
    
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Rencontre", mappedBy="prospect") 
     */
    private $rencontres;
    
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
     * @ORM\Column(name="pays", type="string", length=255)
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
    private $numeroDom;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_etranger", type="string", length=50, nullable=true)
     */
    private $numeroEtranger;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string")
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_principale", type="string", length=255, nullable=true)
     */
    private $photoPrincipale;
    
    /**
     * @var \Datetime 
     * 
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;    
    
    /**
     *
     * @Assert\File(maxSize="2000000")
     */
    private $file;
    

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
     * @return Prospects
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
     * @return Prospects     
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
     * @return Prospects
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
     * @return Prospects
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
     * @return Prospects
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
     * @return Prospects
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
     * Set arrondissement
     *
     * @param integer $arrondissement
     * @return Prospects
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
     * @return Prospects
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
     * @return Prospects
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
     * Set numeroDom
     *
     * @param string $numeroDom
     * @return Prospects
     */
    public function setNumeroDom($numeroDom)
    {
        $this->numeroDom = $numeroDom;

        return $this;
    }

    /**
     * Get numeroDom
     *
     * @return string 
     */
    public function getNumeroDom()
    {
        return $this->numeroDom;
    }

    /**
     * Set numeroEtranger
     *
     * @param string $numeroEtranger
     * @return Prospects
     */
    public function setNumeroEtranger($numeroEtranger)
    {
        $this->numeroEtranger = $numeroEtranger;

        return $this;
    }

    /**
     * Get numeroEtranger
     *
     * @return string 
     */
    public function getNumeroEtranger()
    {
        return $this->numeroEtranger;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Prospects
     */
    public function setSite($site)
    {
        if(!in_array($site, self::getSiteChoices())){
           throw new \InvalidArgumentException("Entrée non valide");
        }
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set photoPrincipale
     *
     * @param string $photoPrincipale
     * @return Prospects
     */
    public function setPhotoPrincipale($photoPrincipale)
    {
        $this->photoPrincipale = $photoPrincipale;
        
        return $this;
    }

    /**
     * Get photoPrincipale
     *
     * @return string 
     */
    public function getPhotoPrincipale()
    {
        return $this->photoPrincipale;
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
        if(isset($this->photoPrincipale)){
            // store the old name to delete after the update
            $this->temp = $this->photoPrincipale;
            $this->photoPrincipale = NULL;
        }else{
            $this->photoPrincipale = 'initial';
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
     * @param \AppBundle\Entity\Echanges $echanges
     * @return Prospects
     */
    public function addEchange(\AppBundle\Entity\Echanges $echanges)
    {
        $this->echanges[] = $echanges;

        return $this;
    }

    /**
     * Remove echanges
     *
     * @param \AppBundle\Entity\Echanges $echanges
     */
    public function removeEchange(\AppBundle\Entity\Echanges $echanges)
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
     * Set relations
     *
     * @param \AppBundle\Entity\Relations $relations
     * @return Prospects
     */
    public function setRelations(\AppBundle\Entity\Relations $relations = null)
    {
        $this->relations = $relations;
        $relations->setProspects($this);

        return $this;
    }

    /**
     * Get relations
     *
     * @return \AppBundle\Entity\Relations 
     */
    public function getRelations()
    {
        return $this->relations;
    }    
    
    /**
     * Set rencontres
     *
     * @param \AppBundle\Entity\Rencontres $rencontres
     * @return Prospect
     */
    public function setRencontres(\AppBundle\Entity\Rencontres $rencontres = null)
    {
        $this->rencontres = $rencontres;
        $rencontres->setProspect($this);

        return $this;
    }
    
    /**
     * Get rencontres
     *
     * @return \AppBundle\Entity\Rencontre 
     */
    public function getRencontres()
    {
        return $this->rencontres;
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
        return __DIR__ . '/../../../../web/' . $this->getUploadPath();
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
            $this->photoPrincipale = $filename.'.'.$extension;
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
        // File property can be empty.
        if(NULL === $this->getFile()){
            return;
        }
        
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadAbsolutePath(), $this->photoPrincipale);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadAbsolutePath().'/'.$this->temp);
            // clear the temp image path
            $this->temp = NULL;
        }
        
        $this->file = NULL;
        
//        // use the original file name here but you should
//        // sanitize it at least to avoid any security issues        
//        $filename = $this->getFile()->getClientOriginalName();
//        
//        // Move the uploaded file to the target directory using original name.
//        $this->getFile()->move($this->getUploadAbsolutePath(), $filename);
//        
//        // Set the photo principale.
//        $this->setPhotoPrincipale($filename);
//        
//        // Cleanup de "file"
//        $this->setFile();
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
    * Set dateCreation
    *
    * @param \DateTime $dateCreation
    * @return Prospects
    */
   public function setDateCreation($dateCreation)
   {
           $this->dateCreation = $dateCreation;

           return $this;
   }

   /**
    * Get dateCreation
    *
    * @return \DateTime 
    */
   public function getDateCreation()
   {
           return $this->dateCreation;
   }
   
   /**
    * Construis et retourne un tableau de valeurs enum pour la colonne "site"
    * 
    * @return array $siteValues
    */
   static public function getSiteChoices()
   {
       // Build $siteValues if that is the first call
       if(self::$siteValues == NULL){
           self::$siteValues = array();
           $myClass = new \ReflectionClass('\AppBundle\Entity\Prospects'); // ReflectionClass récupère toutes infos sur une classe
           $classConstants = $myClass->getConstants();
           $constantPrefix = "SITE_";
           
           foreach($classConstants as $key => $value){
               if(substr($key, 0, strlen($constantPrefix)) === $constantPrefix){
                self::$siteValues[$value] = $value;
               }
           }         
       }
    
       return self::$siteValues;
   }
   
//   public function setSiteChoices($site)
//   {
//       if(!in_array($site, self::getSiteChoices())){
//           throw new \InvalidArgumentException("Entrée non valide");
//       }
//       $this->site = $site;
//   }
}
