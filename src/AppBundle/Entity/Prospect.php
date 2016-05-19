<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\Relationship;
use AppBundle\Entity\Encounter;
use AppBundle\Entity\Photo;
use AppBundle\Entity\Chat;

/**
 * Prospect
 *
 * @ORM\Table(name="prospects")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProspectRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Prospect
{        
    public function __construct()
    {
        $this->echanges = new ArrayCollection();
        $this->encounters = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->relationship = null;
        $this->creationDate = new \DateTime();
    }   
   
    /**
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
       
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Chat", mappedBy="prospect") 
     */
    private $chats;
    
    /**
     * @var Relationship 
     * 
     * @ORM\OneToOne(targetEntity="Relationship", inversedBy="prospect", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="relationship_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $relationship;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Encounter", mappedBy="prospect") 
     */
    private $encounters;
    
    /**
     * @var Source
     * 
     * @ORM\ManyToOne(targetEntity="Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     */
    private $source;
    /**
     * @var Source
     * 
     * @ORM\ManyToOne(targetEntity="Zodiac")
     * @ORM\JoinColumn(name="zodiac_id", referencedColumnName="id", nullable=true)
     */
    private $zodiac;
    
    /**
     * @var Rating 
     * 
     * @ORM\OneToOne(targetEntity="Rating", inversedBy="prospect", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="rating_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $rating;
    
    /**
     * @var RedFlag 
     * 
     * @ORM\OneToOne(targetEntity="RedFlag", inversedBy="prospect", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="redflag_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $redflag;
    
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
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string 
     * 
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;
    
    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=7, nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="cell_number", type="string", length=15, nullable=true)
     */
    private $cellNumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="home_number", type="string", length=15, nullable=true)
     */
    private $homeNumber;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="job", type="string", length=100, nullable=true)
     */
    private $job;
    
    /**
     * @var \Date
     * 
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;    
    
    /**
     * @var ArrayCollection
     * 
     * @Assert\Count(
     *      max = "5",
     *      maxMessage = "You cannot specify more than {{ limit }} photos"
     * )
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="prospect", cascade={"persist", "remove"}) 
     */
    private $photos;
    
    
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
     * Set nickname
     *
     * @param string $nickname
     * @return Prospect     
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;        
        return $this;
    }

    /**
     * Get fnickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Prospect
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Prospect
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
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
     * Set address
     *
     * @param string $address
     * @return Prospect
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Set city
     *
     * @param string $city
     * @return Prospect
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
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
     * @return Prospect
     */
    public function setSource($source)
    {
        $this->source = $source;
        
        return $this;
    }
    
    /**
     * Get zodiac
     *
     * @return string 
     */
    public function getZodiac()
    {
        return $this->zodiac;
    } 
    
    /**
     * Set zodiac
     * 
     * @param string $zodiac
     * @return Prospect
     */
    public function setZodiac($zodiac)
    {
        $this->zodiac = $zodiac;
        
        return $this;
    }
    
    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Prospect
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        
        return $this;
    }
    
    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Prospect
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set cellNumber
     *
     * @param string $cellNumber
     * @return Prospect
     */
    public function setCellNumber($cellNumber)
    {
        $this->cellNumber = $cellNumber;
        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getCellNumber()
    {
        return $this->cellNumber;
    }
    
    /**
     * Set homeNumber
     *
     * @param string $homeNumber
     * @return Prospect
     */
    public function setHomeNumber($homeNumber)
    {
        $this->homeNumber = $homeNumber;
        return $this;
    }

    /**
     * Get homeNumber
     *
     * @return string 
     */
    public function getHomeNumber()
    {
        return $this->homeNumber;
    }
    
    /**
     * Set Job
     *
     * @param string $job
     * @return Prospect
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * Get Job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Add chat
     *
     * @param Chat $chat
     * @return Prospect
     */
    public function addChat(Chat $chat)
    {
        $this->chats[] = $chat;
        return $this;
    }

    /**
     * Remove chat
     *
     * @param Chat $chat
     */
    public function removeChat(Chat $chat)
    {
        $this->chats->removeElement($chat);
    }

    /**
     * Get chats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChats()
    {
        return $this->chats;
    }

    /**
     * Set relationship
     *
     * @param Relationship $relationship
     * @return Prospect
     */
    public function setRelationship(Relationship $relationship)
    {
        $this->relationship = $relationship;
        $relationship->setProspect($this);

        return $this;
    }

    /**
     * Get relationship
     *
     * @return Relationship 
     */
    public function getRelationship()
    {
        return $this->relationship;
    }    
    
    /**
     * Get encounters
     *
     * @return Encounter 
     */
    public function getEncounters()
    {
        return $this->encounters;
    }
    
    /**
     * Add Encounter
     *
     * @param Encounter $encounter
     * @return Prospect
     */
    public function addEncounter(Encounter $encounter)
    {
        $this->encounters[] = $encounter;
        return $this;
    }

    /**
     * Remove Encounter
     *
     * @param Encounter $encounter
     */
    public function removeEncounter(Encounter $encounter)
    {
        $this->encounters->removeElement($encounter);
    }
    
    /**
     * Set rating
     *
     * @param Rating $rating
     * @return Prospect
     */
    public function setRating(Rating $rating)
    {
        $this->rating = $rating;
        $rating->setProspect($this);

        return $this;
    }

    /**
     * Get rating
     *
     * @return Rating 
     */
    public function getRating()
    {
        return $this->rating;
    } 
    
    /**
     * Set redflag
     *
     * @param RedFlag $redflag
     * @return Prospect
     */
    public function setRedflag(RedFlag $redflag)
    {
        $this->redflag = $redflag;
        $redflag->setProspect($this);

        return $this;
    }

    /**
     * Get redflag
     *
     * @return RedFlag 
     */
    public function getRedflag()
    {
        return $this->redflag;
    } 
    
    /**
     * Render a Prospect as a string
     * 
     * @return string
     */
    public function __toString() 
    {
        return $this->getFirstname();
    }
    
    /**
     * Get web path to upload directory
     * 
     * @return string
     *  Relative path.
     */
//    protected function getUploadPath()
//    {
//        return 'uploads/photoPrincipale/'.$this->user->getId();
//    }
    
    /**
     * Get absolute path to upload directory
     * 
     * @return string
     *  Absolute path.
     */
//    protected function getUploadAbsolutePath()
//    {
//        return __DIR__ . '/../../../web/' . $this->getUploadPath();
//    }
    
    /**
     * Get last updated photo
     *
     * @return string 
     */
    public function getLastUpdatedPhoto()
    {
        if($this->getPhotos() !== null){
            $count = count($this->getPhotos());
            return $this->getPhotos()[$count-1]->getPath();
        }else{
            return null;
        }        
    }
    
    /**
     * @ORM\PostRemove
     */
//    public function removePhotoUploads()
//    {
//        if($this->getPhotos() != null){
//            
//            foreach($this->getPhotos() as $photo){
//               $file = $photo->getUploadAbsolutePath();
//               
//               if($file){
//                    unlink($file);
//                }
//            }
//        }           
//    }
    
    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Prospect
     */
    public function setCreationDate($creationDate)
    {
         $this->creationDate = $creationDate;

         return $this;
    }

    /**
     * Get $creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
         return $this->creationDate;
    }
   
   /**
    * Get photos
    * 
    * @return Array
    */
   public function getPhotos()
   {
        return $this->photos;
   }
   
   /**
    * Set Photo
    * 
    * @param Photo $photo
    * @return Prospect
    */
   public function addPhoto(Photo $photo)
   {
        $this->photos[] = $photo;
        $photo->setProspect($this);
        
        return $this;
   }
   
   /**
     * Remove Photo
     *
     * @param Photo $photo
     */
    public function removePhoto(Photo $photo)
    {
        $this->photos->removeElement($photo);
    }
   
   /**
    * Get User
    * 
    * @return User
    */
   public function getUser()
   {
        return $this->user;
   }
   
   /**
    * Set User
    * 
    * @param User $user
    * @return Prospect
    */
   public function setUser($user)
   {
        $this->user = $user;
        
        return $this;
   }
}
