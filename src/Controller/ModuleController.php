<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ModuleController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * Description
     * 
     * @var \ZfMetal\Datagrid\Grid
     */
    protected $grid;

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Datagrid\Grid $grid) {
        $this->em = $em;
        $this->grid = $grid;
    }

    function getEm() {
        return $this->em;
    }

    function setEm(Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function indexAction() {      
        $this->grid->addExtraColumn("admin", "<a class='btn btn-warning btn-xs fa fa-database' href='/generator/module/manage/{{id}}' ></a>", "right", false);
        $this->grid->prepare();
        return array('grid' =>  $this->grid);
    }
    
     public function manageAction() {      
          $moduleId = $this->params("moduleId");
         $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);
         
         return ["module" => $module];
     }

}
