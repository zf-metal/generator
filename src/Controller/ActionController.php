<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ActionController extends AbstractActionController {

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

    public function controllerAction() {

        //Limitamos las Entity al module correspondiente

        $controllerId = $this->params("controllerId");
        $controller = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Controller")->find($controllerId);

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('ZfMetal\Generator\Entity\Action', 'u')
                ->where("u.controller = :controllerId")
                ->setParameter("controllerId", $controllerId);
        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($this->getEm(), "ZfMetal\Generator\Entity\Action", $query);
        $this->grid->setSource($source);

        ##################################################
        $this->grid->setRecordsPerPage(100);
        $this->grid->setTableClass("table-condensed");
        $this->grid->prepare();

        $this->grid->getFormFilters()->remove("controller");

        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add" || $this->request->getPost("crudAction") == "editSubmit" || $this->request->getPost("crudAction") == "addSubmit") {
            $this->grid->getCrudForm()->remove("controller");
            $hidden = new \Zend\Form\Element\Hidden("controller");
            $hidden->setValue($controllerId);
            $this->grid->getCrudForm()->add($hidden);
        }


        $view = new ViewModel(array('grid' => $this->grid));
        $view->setTerminal(true);
        return $view;
    }

    public function jsonByControllerAction() {
        $controllerId = $this->getRequest()->getQuery("id");
        $col = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Action")->findByController($controllerId);
        $a = array();
        $a [] = "";
        foreach ($col as $item) {
            $a[$item->getId()] = $item->__toString();
        }
        return new jsonModel($a);
    }

}
