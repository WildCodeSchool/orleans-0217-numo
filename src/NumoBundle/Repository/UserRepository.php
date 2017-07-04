<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 30/06/17
 * Time: 16:49
 */

namespace NumoBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findByRoles($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('NumoBundle:User', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%'.$role.'%');

        return $qb->getQuery()->getResult();
    }
}