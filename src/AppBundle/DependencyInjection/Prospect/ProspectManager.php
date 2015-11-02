<?php

namespace AppBundle\DependencyInjection\Prospect;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Acl\Dbal\AclProvider;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\Prospect;

/**
 * Description of ProspectManager
 *
 * @author Norman
 */
class ProspectManager 
{   
    public function __construct(EntityManagerInterface $em, AclProvider $aclProvider, TokenStorageInterface $tokenStorage) 
    {
        $this->em = $em;
        $this->aclProvider = $aclProvider;
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * Création d'un ACL
     * 
     * @param Prospect $prospect
     */
    public function createACL($prospect)
    {              
        // Création de l'ACL        
        $objectIdentity = ObjectIdentity::fromDomainObject($prospect);
        $acl = $this->aclProvider->createAcl($objectIdentity);
        
        // retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
//        $tokenStorage = $this->get('security.token_storage');        
//        $user = $tokenStorage->getToken()->getUser();
        $user = $this->tokenStorage->getToken()->getUser();
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // Donne accès au propriétaire
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $this->aclProvider->updateAcl($acl);
    }
}
