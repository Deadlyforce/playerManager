<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RelationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RelationRepository extends EntityRepository
{
    /**
     * Return all relations by user, order by date creation of prospect
     * 
     * @param User $user
     * @return Array
     */
    public function findByUser($user)
    {
        $query = $this->_em->createQuery('
            SELECT r
            FROM AppBundle:Relation r
            LEFT JOIN r.prospect p
            WHERE  p.user = :user
            ORDER BY p.date_creation DESC
        ')
        ->setParameter('user', $user);
        
        return $query->getResult();
    }
    
}
