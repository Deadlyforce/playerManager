<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Returns the count of all registered users
     * 
     * @return integer
     */
    public function countUsers()
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(u)
            FROM AppBundle:User u
        ');
        
        return $qb->getSingleScalarResult();
    }
    
}
