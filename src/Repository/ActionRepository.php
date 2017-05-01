<?php

namespace ZfMetal\Generator\Repository;

/**
 * RouteRepository
 *
 * @author Cristian Incarnato
 * @license MIT
 * @link
 */
class ActionRepository extends \Doctrine\ORM\EntityRepository {

    const ENTITY = '\ZfMetal\Generator\Entity\Action';

    public function save(\ZfMetal\Generator\Entity\Route $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Generator\Entity\Route $entity) {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }


    public function findGridAction($controller) {
        return $this->getEntityManager()->createQueryBuilder()
                        ->select("u")
                        ->from(self::ENTITY, "u")
                        ->where("u.name = 'grid' ")
                        ->andWhere("u.controller = :controller")
                        ->setParameter("controller", $controller)
                        ->getQuery()->getOneOrNullResult();
    }

}
