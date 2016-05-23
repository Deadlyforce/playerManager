<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

/**
 * prospectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProspectRepository extends EntityRepository
{
    /**
     * Get prospects (for index)
     * 
     * @param User $user
     * @param int $firstResult
     * @param int $maxResults
     * @return Paginator
     */
    public function getProspectsQuery($user)
    {
//        $qb = $this->createQueryBuilder('p');
//        
//        $qb
//            ->select('p')
//            ->setFirstResult($firstResult)
//            ->setMaxResults($maxResults)
//            ->where('p.user = :user')
//            ->orderBy('p.creationDate', 'DESC')
//            ->setParameter('user', $user)
//        ;
//        
//        $pag = new Paginator($qb);
//        
//        return $pag;
        
        $query = $this->_em->createQuery('
            SELECT p,z
            FROM AppBundle:Prospect p LEFT JOIN p.zodiac z
            WHERE p.user = :user
            ORDER BY p.creationDate DESC, p.id DESC
        ')
        ->setParameter('user', $user);
        
        return $query;
        
    }
    
    /**
     * Get prospects (for index) filtered by sex yes/no
     * 
     * @param User $user
     * @param int $firstResult
     * @param int $maxResults
     * @return Paginator
     */
    public function getProspectsQuery_sex($user)
    {       
        $query = $this->_em->createQuery('
            SELECT p,z
            FROM AppBundle:Prospect p LEFT JOIN p.zodiac z LEFT JOIN p.relationship r
            WHERE p.user = :user
            AND r.fc = 1
            ORDER BY p.creationDate DESC, p.id DESC
        ')
        ->setParameter('user', $user);
        
        return $query;
        
    }
    
    /**
     * Returns an array of all prospect ids from the user.
     * 
     * @param User $user
     * @return array
     */
    public function getProspectIds($user)
    {
        $qb = $this->_em->createQuery('
            SELECT p.id
            FROM AppBundle:Prospect p
            WHERE p.user = :user
        ')
         ->setParameter('user', $user);
        
        return $qb->getResult();
    }
    
    /**
     * Returns flakes On for that user.
     * 
     * @param User $user
     * @return array
     */
    public function getUserFlakesOn($user)
    {        
        $qb = $this->_em->createQuery('
            SELECT COUNT(r.flake)
            FROM AppBundle:Relationship r LEFT JOIN r.prospect p
            WHERE p.user = :user
            AND r.meeting = 0
            AND r.flake = 1
        ')
         ->setParameter('user', $user);
        
        return $qb->getSingleScalarResult();
    }
    /**
     * Returns flakes Off for that user.
     * 
     * @param User $user
     * @return array
     */
    public function getUserFlakesOff($user)
    {        
        $qb = $this->_em->createQuery('
            SELECT COUNT(r.flake)
            FROM AppBundle:Relationship r LEFT JOIN r.prospect p
            WHERE p.user = :user
            AND r.meeting = 1
            AND r.flake = 0
        ')
         ->setParameter('user', $user);
        
        return $qb->getSingleScalarResult();
    }
    
    /**
     * Returns sources (Online) for that user.
     * 
     * @param User $user
     * @return array
     */
    public function getUserSourcesOnline($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(s.wording)
            FROM AppBundle:Prospect p LEFT JOIN p.source s
            WHERE p.user = :user
            AND s.wording = :Online
        ')
        ->setParameter('user', $user)
        ->setParameter('Online', 'Online');
        
        return $qb->getSingleScalarResult();
    }
    /**
     * Returns sources (IRL) for that user.
     * 
     * @param User $user
     * @return array
     */
    public function getUserSourcesIRL($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(s.wording)
            FROM AppBundle:Prospect p LEFT JOIN p.source s
            WHERE p.user = :user
            AND s.wording = :IRL
        ')
        ->setParameter('user', $user)
        ->setParameter('IRL', 'IRL (In Real Life)');
        
        return $qb->getSingleScalarResult();
    }
    
    
}
