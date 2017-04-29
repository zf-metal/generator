<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
        return array('grid' => $this->grid);
    }

    public function manageAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        return ["module" => $module];
    }

    public function createAction() {

        $module = new \ZfMetal\Generator\Entity\Module();


        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Module');
        $form->bind($module);


        //Process Form
        $formProcess = $this->formProcess($this->getEm(), $form);

        if ($formProcess->getStatus()) {
            $module = $form->getObject();
            $this->redirect('generator/main/'.$module->getId());
        }


        $view = new ViewModel(array('form' => $form));
        return $view;
    }

    public function editAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->findOneBy(['module' => $moduleId]);

        if (!$module) {
            $module = new \ZfMetal\Generator\Entity\Module();
        }

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Module');
        $form->bind($module);


        //Custom Form
        $form->get("module")->setValue($moduleId);
        $form->setAttribute('class', 'form-vertical');
        $form->setAttribute('action', 'javascript:MetalModule.EditSubmit()');

        //Process Form
        $this->formProcess($this->getEm(), $form);


        $view = new ViewModel(array('form' => $form, 'moduleId' => $moduleId));
        $view->setTerminal(true);
        return $view;
    }

}
