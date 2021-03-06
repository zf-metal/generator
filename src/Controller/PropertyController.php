<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PropertyController extends AbstractActionController {

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

    public function entityAction() {

        //Limitamos las Entity al module correspondiente

        $entityId = $this->params("entityId");
        //$entity = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Entity")->find($entityId);

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('ZfMetal\Generator\Entity\Property', 'u')
                ->where("u.entity = :entityId")
                ->setParameter("entityId", $entityId);
        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($this->getEm(), "ZfMetal\Generator\Entity\Property", $query);
        $this->grid->setSource($source);

        ##################################################
        $this->grid->setRecordsPerPage(100);
        $this->grid->setTableClass("table-condensed");
        $this->grid->prepare();

        $this->grid->getFormFilters()->remove("entity");

        if ($this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "edit" || $this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "add" || $this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "editSubmit" || $this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "addSubmit") {
            $this->grid->getCrudForm()->remove("entity");
            $hidden = new \Zend\Form\Element\Hidden("entity");
            $hidden->setValue($entityId);
            $this->grid->getCrudForm()->add($hidden);
        }


        $view = new ViewModel(array('grid' => $this->grid));
        $view->setTerminal(true);
        return $view;
    }

}
