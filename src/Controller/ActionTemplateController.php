<?php

namespace ZfMetal\Generator\Controller;

/**
 * ActionTemplateController
 *
 *
 *
 * @author Cristian Incarnato
 * @license MIT
 * @link
 */
class ActionTemplateController extends \Zend\Mvc\Controller\AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var \ZfMetal\Datagrid\Grid
     */
    public $grid = null;

    public function getEm() {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Datagrid\Grid $grid) {
        $this->em = $em;
        $this->grid = $grid;
    }

    public function getGrid() {
        return $this->grid;
    }

    public function setGrid(\ZfMetal\Datagrid\Grid $grid) {
        $this->grid = $grid;
    }

    public function gridAction() {
        $this->grid->prepare();
        return array("grid" => $this->grid);
    }

}
