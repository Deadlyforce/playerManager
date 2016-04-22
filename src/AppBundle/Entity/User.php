<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * Description of User
 *
 * @author Norman
 * 
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();        
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var int
     * 
     * @Assert\NotBlank(groups={"Registration"})
     * @Assert\Length(
     *      min=1,
     *      max=2,
     *      groups={"Registration"}
     * )
     * @ORM\Column(name="genre", type="integer") 
     */
    protected $genre;
    
    /**
     * @var Datetime 
     * 
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="ip", type="string", length=45)
     */
    protected $ip;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="locale", type="string", length=2, nullable=true) 
     */
    protected $locale;
    
    /**
     * 
     * @return int
     */
    public function getGenre()
    {
        return $this->genre;
    }
    
    /**
     * 
     * @param int $genre
     * @return User
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        
        return $this;
    }
    
    /**
     * 
     * @return Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * 
     * @param Datetime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
    
    /**
     * 
     * @param string $ip
     * @return User
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * 
     * @param string $locale
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
}
