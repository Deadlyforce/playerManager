<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Prospect;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Photo
 * 
 * @ORM\Table(name="photo")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PhotoRepository")
 * @Gedmo\Uploadable(pathMethod="userPath", filenameGenerator="SHA1", maxSize=1200000, allowOverwrite=true, allowedTypes="image/jpeg")
 */
class Photo {
    
    public function __construct()
    {
        $this->path = "";
        $this->name = "";        
    }
    
    /**
     * @var Prospect
     * 
     * @ORM\ManyToOne(targetEntity="Prospect", inversedBy="photos")
     * @ORM\JoinColumn(name="prospect_id", referencedColumnName="id") 
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
     * @ORM\Column(type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;
    
    /**
     * @var file 
     * 
     * @Assert\NotBlank()     
     */
    private $file;   
    
    /**
     * Primary picture as selected by the user
     * 
     * @var integer
     * @ORM\Column(name="selected", type="boolean", nullable=false)
     */
    private $selected;
    
    /**
     * Set selected
     *
     * @param boolean $selected
     * @return Photo
     */
    public function setSelected($selected)
    {
            $this->selected = $selected;     

            return $this;
    }

    /**
     * Get selected
     * 
     * @return boolean
     */
    public function getSelected()
    {
            return $this->selected;
    }
    
    /************************* GETTERS SETTERS ********************************/
    
    /**
     * Callback function
     * Returns the path used by Doctrine Extensions Uploadable
     * 
     * @return string
     */
    public function userPath()
    {    
        return 'uploads/photos/'. $this->getProspect()->getUser()->getId();
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
     * Set size
     * 
     * @param string $size
     * @return \AppBundle\Entity\Photo
     */
    public function setSize($size)
    {
        $this->size = $size;
        
        return $this;
    }
    
    /**
     * Get size
     * 
     * @return decimal $size
     */
    public function getSize()
    {
        return $this->size;
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
     * Set prospect
     *
     * @param Prospect $prospect
     * @return Photo
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect;     
        
        return $this;
    }
    
    /**
     * Get prospect
     *
     * @return Prospect 
     */
    public function getProspect()
    {
        return $this->prospect;
    }
}