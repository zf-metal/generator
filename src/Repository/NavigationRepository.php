<?php

namespace ZfMetal\Generator\Repository;

/**
 * NavigationRepository
 *
 * @author Cristian Incarnato
 * @license MIT
 * @link
 */
class NavigationRepository extends \Doctrine\ORM\EntityRepository {

    const ENTITY = '\ZfMetal\Generator\Entity\Navigation';

    public function save(\ZfMetal\Generator\Entity\Navigation $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Generator\Entity\Navigation $entity) {
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
