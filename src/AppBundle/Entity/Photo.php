<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Photo
 * 
 * @ORM\Table(name="photo")
 * @ORM\Entity
 * @Gedmo\Uploadable(pathMethod="userPath", filenameGenerator="SHA1", allowOverwrite=true)
 */
class Photo {
    
    public function __construct()
    {
        $this->path = "";
        $this->name = "";        
    }
    
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
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     * @Gedmo\UploadableFilePath
     */
    private $path;
    
    /**
     * @ORM\Column(name="name", type="string")
     * @Gedmo\UploadableFileName 
     */
    private $name;
    
    /**
     * @var file 
     * 
     * @Assert\NotBlank()
     * @Assert\Image(maxSize="5000000") 
     */
    private $file;
            
    /**
     * Utilisé pour la création des dossier d'upload utilisateur
     * 
     * @var integer 
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $user_id;
    
    
    /************************* GETTERS SETTERS ********************************/
    
    /**
     * Callback function
     * Returns the path used by Doctrine Extensions Uploadable
     * 
     * @return string
     */
    public function userPath()
    {    
        return 'uploads/photoPrincipale/'. $this->getUserId();
    }
    
    /**
     * Get absolute path to uploaded picture
     * 
     * @return string
     */
    public function getUploadAbsolutePath()
    {
        return __DIR__ . '/../../../web/' . $this->getPath();
    }
    
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
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     * @return \AppBundle\Entity\Photo
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Get name
     * 
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set file
     *
     * @param file file
     *
     * @return Photo
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return file
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set user_id
     *
     * @param integer $user_id
     * @return Photo
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
     * Removes physically the photo from the directory
     * 
     * @ORM\PostRemove
     */
//    public function removeUpload()
//    {
//        $file = $this->getUploadAbsolutePath();
//        if($file){
//            unlink($file);
//        }
//    }
}