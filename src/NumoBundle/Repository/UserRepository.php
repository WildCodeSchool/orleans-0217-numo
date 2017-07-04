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
//    /**
//     *
//     * @return array
//     */
//    public function findByRoles()
//    {
////        $query = $this->getDoctrine()>getManager()
////                ->createQuery(
////                    'SELECT u FROM NumoBundle:User u WHERE u.roles LIKE :role'
////                )->setParameter('role', '%"ROLE_MODERATOR"%');
////
////        $users = $query->getResult();
////
////        return $users;
//
////        $em = $this->getEntityManager();
////        $usersRepository = $em->getRepository('NumoBundle:User');
////        $qb = $usersRepository->createQueryBuilder('r');
////
////        foreach ($formData as $field => $value) {
////            if($field == "roles"){
////                $qb->andWhere(":value_$field MEMBER OF r.roles")->setParameter("value_$field", $value);
////            }else{
////                $qb->andWhere("r.$field = :value_$field")->setParameter("value_$field", $value);
////            }
////        }
////        return $qb->getQuery()->getResult();
//
//        $query = $this->getDoctrine()->getEntityManager()
//            ->createQuery(
//                'SELECT u FROM NumoBundle:User u WHERE u.roles LIKE :role'
//            )->setParameter('role', '%"ROLE_MODERATOR"%'
//            );
//        $users = $query->getResult();
//
//        return $users;
//    }

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