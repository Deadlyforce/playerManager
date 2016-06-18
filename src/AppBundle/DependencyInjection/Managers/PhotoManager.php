<?php

namespace AppBundle\DependencyInjection\Managers;

use Doctrine\ORM\PersistentCollection;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;

/**
 * Description of PhotoManager
 *
 * @author Norman
 */
class PhotoManager 
{       
    public function __construct() 
    {        

    }    

    /**
     * Updates empty gallery and returns array of missing files pointers (true or false)
     * 
     * @param PersistentCollection $photos
     * @return boolean
     */
    public function updateEmptyGallery(PersistentCollection $photos, UploadableManager $uploadableManager)
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
