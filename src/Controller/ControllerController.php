<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ControllerController extends AbstractActionController {

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

    public function mainAction() {

        //Limitamos las Entity al module correspondiente

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('ZfMetal\Generator\Entity\Controller', 'u')
                ->where("u.module = :moduleId")
                ->setParameter("moduleId", $moduleId);
        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($this->getEm(), "ZfMetal\Generator\Entity\Controller", $query);
        $this->grid->setSource($source);

        ##################################################
        $this->grid->addExtraColumn("action-list", "<a class='btn btn-warning btn-xs glyphicon glyphicon-th-list' onclick='MetalControllers.actionsAction({{id}},\"{{name}}\")' ></a>", "right", false);
        $this->grid->addExtraColumn("quick", "<a class='btn btn-primary btn-xs glyphicon glyphicon-fast-forward' onclick='MetalControllers.commonsAction({{id}},\"{{name}}\")' ></a>", "right", false);
        $this->grid->addExtraColumn("generator", "<a class='btn btn-danger btn-xs glyphicon glyphicon-play' onclick='MetalControllers.generatorAction({{id}},\"{{name}}\")' ></a>", "right", false);
        
        
        $this->grid->setRecordsPerPage(100);
        $this->grid->setTableClass("table-condensed");
        $this->grid->prepare();

        $this->grid->getFormFilters()->remove("module");

        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add" || $this->request->getPost("crudAction") == "editSubmit" || $this->request->getPost("crudAction") == "addSubmit") {
            $this->grid->getCrudForm()->remove("module");
            $hidden = new \Zend\Form\Element\Hidden("module");
            $hidden->setValue($moduleId);
            $this->grid->getCrudForm()->add($hidden);
        }


        $view = new ViewModel(array('grid' => $this->grid));
        $view->setTerminal(true);
        return $view;
    }


  

}
