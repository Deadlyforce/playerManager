<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Photo;

/**
 * CachePhotoListener
 *
 * @author Norman
 */
class CachePhotoListener 
{
    protected $cacheManager;
    
    public function __construct($cacheManager) 
    {
        $this->cacheManager = $cacheManager;
    }
    
    // Case : update photo (crop or different photo)
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();        
        
        if ($entity instanceof Photo) {
            // Remove all the cached images for that user
            $this->cacheManager->remove($entity->userPath());
        }
    }
    
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        $filters = array('thumb_prospect_250', 'thumb_prospect_175');
        
        foreach($filters as $filter){
            if ($entity instanceof Photo) {
                // when a previous postUpdate deleted the whole cache folder without regenerating the thumbs           
                $cacheExists = $this->cacheManager->isStored($entity->getPath(), $filter);  

                if ($cacheExists) {
                    $this->cacheManager->resolve($entity->getPath(), $filter);
                    $this->cacheManager->remove($entity->getPath());
                }
            }
        }
    }
}
