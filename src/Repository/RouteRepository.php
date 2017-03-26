<?php

namespace ZfMetal\Generator\Repository;

/**
 * RouteRepository
 *
 * @author Cristian Incarnato
 * @license MIT
 * @link
 */
class RouteRepository extends \Doctrine\ORM\EntityRepository {

    const ENTITY = '\ZfMetal\Generator\Entity\Route';

    public function save(\ZfMetal\Generator\Entity\Route $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Generator\Entity\Route $entity) {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function findWhitoutParent($moduleId) {
        $col = $this->getEntityManager()->createQueryBuilder()
                        ->select("u")
                        ->from(self::ENTITY, "u")
                        ->where("u.module = :module")
                        ->andWhere("u.parent is null")
                        ->setParameter("module", $moduleId)
                        ->getQuery()->getResult();

        return $col;
    }

}
