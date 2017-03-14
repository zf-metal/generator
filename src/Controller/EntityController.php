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
     * @var \CdiDataGrid\Grid 
     */
    protected $grid;

    function __construct(\Doctrine\ORM\EntityManager $em, \CdiDataGrid\Grid $grid) {
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

    public function moduleAction() {

        //Limitamos las Entity al module correspondiente

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('ZfMetal\Generator\Entity\Entity', 'u')
                ->where("u.module = :moduleId")
                ->setParameter("moduleId", $moduleId);
        $source = new \CdiDataGrid\Source\DoctrineSource($this->getEm(), "ZfMetal\Generator\Entity\Entity", $query);
        $this->grid->setSource($source);

        ##################################################

        $this->grid->addExtraColumn("PROPERTIES", "<a class='btn btn-warning btn-xs fa fa-database ' onclick='modalProperties({{id}},\"{{name}}\")' ></a>", "right", false);
        $this->grid->addExtraColumn("GENERATOR", "<a class='btn btn-warning btn-xs fa fa-file-code-o' onclick='modalEntityGenerator({{id}},\"{{name}}\")' ></a>", "right", false);
        $this->grid->addExtraColumn("ABM", "<a class='btn btn-warning btn-xs fa fa-file-code-o' onclick='modalAbm({{id}},\"{{name}}\")' ></a>", "right", false);

        
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

    public function propertiesAction() {
        $entityId = $this->params("entityId");
        $entity = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Entity")->find($entityId);

        return ["entity" => $entity];
    }

  

}
