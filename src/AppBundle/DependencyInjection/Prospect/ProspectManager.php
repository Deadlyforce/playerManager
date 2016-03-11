<?php

namespace AppBundle\DependencyInjection\Prospect;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\Prospect;

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
    

   
}
