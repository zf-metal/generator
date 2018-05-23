<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EntityController extends AbstractActionController {

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
                ->from('ZfMetal\Generator\Entity\Entity', 'u')
                ->where("u.module = :moduleId")
                ->setParameter("moduleId", $moduleId);
        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($this->getEm(), "ZfMetal\Generator\Entity\Entity", $query);
        $this->grid->setSource($source);

        ##################################################

        $this->grid->addExtraColumn("property-list", "<a class='btn btn-warning btn-xs glyphicon glyphicon-th-list' onclick='MetalEntities.propertiesAction({{id}},\"{{name}}\")' ></a>", "right", false);
        // $this->grid->addExtraColumn("quick", "<a class='btn btn-primary btn-xs glyphicon glyphicon-fast-forward' onclick='MetalEntities.xxxx({{id}},\"{{name}}\")' ></a>", "right", false);
        $this->grid->addExtraColumn("Fieldset", "<a class='btn btn-danger btn-xs glyphicon glyphicon-th' onclick='MetalEntities.generatorFieldsetAction({{id}},\"{{name}}\")' ></a>", "right", false);
        $this->grid->addExtraColumn("generator", "<a class='btn btn-danger btn-xs glyphicon glyphicon-play' onclick='MetalEntities.generatorAction({{id}},\"{{name}}\")' ></a>", "right", false);

        $this->grid->setRecordsPerPage(100);
        $this->grid->setTableClass("table-condensed");


        //Add ID
        $em = $this->getEm();
        $this->grid->getSource()->getEventManager()->attach("saveRecord_before", function($e) use($em) {
            $record = $e->getParam('record');
            if ($record->getGenerateId()) {
                $property = new \ZfMetal\Generator\Entity\Property();
                $property->setName("id");
                $property->setType("integer");
                $property->setLabel("ID");
                $property->setBeNullable(false);
                 $property->setLength(11);
                $property->setCreatedAt(false);
                $property->setUpdatedAt(false);
                $property->setPrimarykey(true);
                $property->setAutoGeneratedValue(true);
                $property->setEntity($record);
                $em->persist($property);
               
            }
        });


        $this->grid->prepare();

        $this->grid->getFormFilters()->remove("module");

        if ($this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "edit" || 
                $this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "add" || 
                $this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "editSubmit" || 
                $this->request->getPost(\ZfMetal\Datagrid\Crud::inputAction) == "addSubmit") {
            $this->grid->getCrudForm()->remove("module");
            $hidden = new \Zend\Form\Element\Hidden("module");
            $hidden->setValue($moduleId);
            $this->grid->getCrudForm()->add($hidden);
        }

        

        $view = new ViewModel(array('grid' => $this->grid));
        $view->setTerminal(true);
        return $view;
    }

    public function propertiesAction() {
        $entityId = $this->params("entityId");
        $entity = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Entity")->find($entityId);

        return ["entity" => $entity];
    }

}
