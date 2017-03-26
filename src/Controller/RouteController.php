<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RouteController extends AbstractActionController {

    
    const ENTITY = \ZfMetal\Generator\Entity\Route::class;
    
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

    /**
     * 
     * @return \ZfMetal\Generator\Repository\RouteRepository;
     */
   function getRouteRepository(){
       return $this->getEm()->getRepository(self::ENTITY);
   }

    public function mainAction() {

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);
        
        $routes = $this->getRouteRepository()->findWhitoutParent($moduleId);
        
        $view = new ViewModel(array('routes' => $routes));
        $view->setTerminal(true);
        return $view;
    }

    public function gridAction() {

        //Limitamos las Entity al module correspondiente

        $moduleId = $this->params("moduleId");
        //$module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $query = $this->getEm()->createQueryBuilder()
                ->select('u')
                ->from('ZfMetal\Generator\Entity\Route', 'u')
                ->where("u.module = :moduleId")
                ->setParameter("moduleId", $moduleId);
        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($this->getEm(), "ZfMetal\Generator\Entity\Route", $query);
        $this->grid->setSource($source);

        ##################################################

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
        $view->setTerminal(false);
        return $view;
    }

}
