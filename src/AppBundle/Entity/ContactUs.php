<?php

namespace AppBundle\Entity;

/**
 * Description of ContactUs
 *
 * @author Norman
 */
class ContactUs 
{
    private $name;
    private $email;
    private $subject;
    private $message;
    
    public function __construct() 
    {
        $this->name = null;
        $this->email = null;
        $this->subject = null;
        $this->message = null;
    }
    
    /**
     * 
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * 
     * @param string $name
     * @return \AppBundle\Entity\ContactUs
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * 
     * @param string $email
     * @return \AppBundle\Entity\ContactUs
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * 
     * @param string $subject
     * @return \AppBundle\Entity\ContactUs
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * 
     * @param string $message
     * @return \AppBundle\Entity\ContactUs
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}
