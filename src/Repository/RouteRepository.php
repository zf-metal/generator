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

    public function findRouteModule($moduleId, $moduleName) {
        return $this->getEntityManager()->createQueryBuilder()
                        ->select("u")
                        ->from(self::ENTITY, "u")
                        ->where("u.name = :moduleName")
                        ->andWhere("u.module = :module")
                        ->andWhere("u.parent is null")
                        ->setParameter("module", $moduleId)
                        ->setParameter("moduleName", $moduleName)
                        ->getQuery()->getOneOrNullResult();
    }

    public function findRouteController($moduleId, $controllerName, $parent) {
        return $this->getEntityManager()->createQueryBuilder()
                        ->select("u")
                        ->from(self::ENTITY, "u")
                        ->where("u.name = :controllerName")
                        ->andWhere("u.module = :module")
                        ->andWhere("u.parent = :parent")
                        ->setParameter("module", $moduleId)
                        ->setParameter("controllerName", $controllerName)
                        ->setParameter("parent", $parent)
                        ->getQuery()->getOneOrNullResult();
    }

    public function findRouteAction($moduleId, $actionName, $parent) {
        return $this->getEntityManager()->createQueryBuilder()
                        ->select("u")
                        ->from(self::ENTITY, "u")
                        ->where("u.name = :actionName")
                        ->andWhere("u.module = :module")
                        ->andWhere("u.parent = :parent")
                        ->setParameter("module", $moduleId)
                        ->setParameter("actionName", $actionName)
                        ->setParameter("parent", $parent)
                        ->getQuery()->getOneOrNullResult();
    }

}
