<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Photo
 * 
 * @ORM\Table(name="photo")
 * @ORM\Entity
 * @Gedmo\Uploadable(filenameGenerator="SHA1", allowOverwrite=true)
 */
class Photo {
    
}
