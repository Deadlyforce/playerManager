<?php

namespace AppBundle\DependencyInjection\Managers;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Description of PhotoManager
 *
 * @author Norman
 */
class PhotoManager 
{   
    private $em;
    private $tokenStorage;
    
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage) 
    {
        $this->em = $em;        
        $this->tokenStorage = $tokenStorage;
    }    

    /**
     * Updates empty gallery and returns array of missing files pointers (true or false)
     * 
     * @param PersistentCollection $photos
     * @return boolean
     */
    public function updateEmptyGallery(PersistentCollection $photos, $uploadableManager)
    {
        $this->setFirstPhotoPrimary($photos);
                
        $missingFiles = array();
        
        foreach ($photos as $photo) {
            if ($photo->getFile() !== null) {    
                $uploadableManager->markEntityToUpload($photo, $photo->getFile());
                
                $missingFiles[] = true;                
            } else {
                $missingFiles[] = false;
            }   
        }

        return $missingFiles;
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
