<?php

namespace AppBundle\DependencyInjection\Managers;

use Doctrine\ORM\EntityManagerInterface;
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
    
    
}
