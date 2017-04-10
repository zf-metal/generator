<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ControllerCommonsController extends AbstractActionController {

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

        $controllerId = $this->params("controllerId");
        $controllerCommons = $this->getEm()->getRepository("ZfMetal\Generator\Entity\ControllerCommons")->findOneBy(['controller' => $controllerId]);
         
        if (!$controllerCommons) {
            $controllerCommons = new \ZfMetal\Generator\Entity\ControllerCommons();
          }

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\ControllerCommons');
        $form->bind($controllerCommons);

        
        //Custom Form
        $form->get("controller")->setValue($controllerId);
        $form->setAttribute('class', 'form-vertical');
        $form->setAttribute('action', 'javascript:submitCommons()');
        
        //Process Form
        $this->formProcess($this->getEm(), $form);


        $view = new ViewModel(array('form' => $form, 'controllerId' => $controllerId));
        $view->setTerminal(true);
        return $view;
    }

}
