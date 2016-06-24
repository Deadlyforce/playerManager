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
     * @return Paginator
     */
    public function getProspectsQuery($orderby, $user, $status, $sex, $relationshipLevel)
    {  
        $qb = $this->_em->createQueryBuilder();

        $qb
            ->select('p', 'z')
            ->from('AppBundle:Prospect', 'p')
            ->leftJoin('p.zodiac', 'z')
            ->leftJoin('p.relationship', 'r')
            ->leftJoin('r.relationshipRank', 'rr')
            ->leftJoin('p.rating', 'rat')
            ->leftJoin('p.redflag', 'red')
            ->where('p.user = :user')            
            ->setParameter('user', $user)
        ;
        
        switch ($orderby) {
            case 'rating': 
                $qb
                    ->addOrderBy('rat.percentAverage', 'DESC')
                    ->addOrderBy('rat.id', 'DESC');
                break;
            case 'redflag': 
                $qb
                    ->addOrderBy('red.percentAverage', 'DESC')
                    ->addOrderBy('red.id', 'DESC');
                break;
            default: 
                $qb
                    ->addOrderBy('p.creationDate', 'DESC')
                    ->addOrderBy('p.id', 'DESC');
        }
        
        if ($status !== null) {
            $qb                
                ->andWhere('r.status = :status')
                ->setParameter('status', $status)
            ;
        }
//var_dump($sex);
//die();
        if ($sex != null) {
            $qb                
                ->andWhere('r.fc = :sex')
                ->setParameter('sex', intval($sex))
            ;
        }
        if ($relationshipLevel != null) {
            $qb                
                ->andWhere('rr.id = :relationshipLevel')
                ->setParameter('relationshipLevel', intval($relationshipLevel))
            ;
        }
        
        return $qb->getQuery();     
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
    
    // RELATIONSHIP TYPES COUNT ************************************************
    
    public function getUserTotalChatting($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(p)
            FROM AppBundle:Prospect p LEFT JOIN p.relationship r LEFT JOIN r.relationshipRank rr
            WHERE p.user = :user
            AND rr.id = 1
        ')
        ->setParameter('user', $user)
        ;
        
        return $qb->getSingleScalarResult();
    }
    public function getUserTotalONS($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(p)
            FROM AppBundle:Prospect p LEFT JOIN p.relationship r LEFT JOIN r.relationshipRank rr
            WHERE p.user = :user
            AND rr.id = 2
        ')
        ->setParameter('user', $user)
        ;
        
        return $qb->getSingleScalarResult();
    }
    public function getUserTotalFuckFriend($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(p)
            FROM AppBundle:Prospect p LEFT JOIN p.relationship r LEFT JOIN r.relationshipRank rr
            WHERE p.user = :user
            AND rr.id = 3
        ')
        ->setParameter('user', $user)
        ;
        
        return $qb->getSingleScalarResult();
    }
    public function getUserTotalDating($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(p)
            FROM AppBundle:Prospect p LEFT JOIN p.relationship r LEFT JOIN r.relationshipRank rr
            WHERE p.user = :user
            AND rr.id = 4
        ')
        ->setParameter('user', $user)
        ;
        
        return $qb->getSingleScalarResult();
    }
    public function getUserTotalOpenRelationship($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(p)
            FROM AppBundle:Prospect p LEFT JOIN p.relationship r LEFT JOIN r.relationshipRank rr
            WHERE p.user = :user
            AND rr.id = 5
        ')
        ->setParameter('user', $user)
        ;
        
        return $qb->getSingleScalarResult();
    }
    public function getUserTotalMonogamousRelationship($user)
    {
        $qb = $this->_em->createQuery('
            SELECT COUNT(p)
            FROM AppBundle:Prospect p LEFT JOIN p.relationship r LEFT JOIN r.relationshipRank rr
            WHERE p.user = :user
            AND rr.id = 6
        ')
        ->setParameter('user', $user)
        ;
        
        return $qb->getSingleScalarResult();
    }
}
