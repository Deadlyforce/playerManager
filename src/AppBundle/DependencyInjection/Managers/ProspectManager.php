<?php

namespace AppBundle\DependencyInjection\Managers;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Description of ProspectManager
 *
 * @author Norman
 */
class ProspectManager 
{   
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage) 
    {
        $this->em = $em;        
        $this->tokenStorage = $tokenStorage;
    }        
    
    /**
     * Set first element (photo) as primary selected = true so there's always a primary
     * 
     * @param PersistentCollection $photos
     */
    public function setFirstPhotoPrimary(PersistentCollection $photos)
    {
        if ($photos->first()) {
            $photos->first()->setSelected(true); 
        }
    }
}
