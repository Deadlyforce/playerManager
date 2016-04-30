<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

/**
 * Description of PhotoRepository
 *
 * @author Norman
 */
class PhotoRepository extends EntityRepository
{
    /**
     * Returns the primary photo of each prospect from that user.
     * 
     * @param User $user
     * @return array
     */
    public function getAlbum(User $user)
    {
        $qb = $this->_em->createQuery('
            SELECT ph
            FROM AppBundle:Photo ph
            WHERE ph.prospect IN (SELECT pr FROM AppBundle:Prospect pr WHERE pr.user = :user)
            AND ph.selected = 1
            GROUP BY ph.prospect
            ORDER BY ph.id DESC
        ')        
        ->setParameter('user', $user);
        
        return $qb->getResult();
    }

}
