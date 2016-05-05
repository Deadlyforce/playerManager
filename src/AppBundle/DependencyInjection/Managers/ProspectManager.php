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
     * Check if some photos were modified, added or deleted
     * 
     * @param ArrayCollection $originalPhotos
     * @param ArrayCollection $photos
     * @return boolean
     */
    public function checkPhotoChange(ArrayCollection $originalPhotos, PersistentCollection $photos)
    {
        $changed = false;
        
        foreach ($originalPhotos as $originalPhoto) {
            if ($photos->contains($originalPhoto)) {

            } else {
                $changed = true;
            }
        }
        foreach ($photos as $photo) {
            if ($originalPhotos->contains($photo)) {

            } else {
                $changed = true;
            }
        }
        
        return $changed;
    } 
}
