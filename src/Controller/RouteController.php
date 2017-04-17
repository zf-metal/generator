<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

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
    function getRouteRepository() {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function mainAction() {

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $routes = $this->getRouteRepository()->findWhitoutParent($moduleId);

        $view = new ViewModel(array('routes' => $routes, "moduleId" => $moduleId));
        $view->setTerminal(true);
        return $view;
    }

    public function jsonAction() {

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $routes = $this->getRouteRepository()->findWhitoutParent($moduleId);

        $data = array();
        foreach ($routes as $route) {
            $data[] = $this->treeRoute($route);
        }

        return new jsonModel($data);
    }

    protected function treeRoute($route) {

        $data["text"] = $route->getName();
        $data["routeid"] = $route->getId();
        $data["route_name"] = $route->getName();
        $data["route_url"] = $route->getRoute();
        if ($route->hasParent()) {
            $data["parent_route_name"] = $route->parentRouteName()."/";
            $data["parent_route_url"] = $route->parentRouteUrl();
        } else {
            $data["parent_route_name"] = "";
            $data["parent_route_url"] = "";
        }
        $data["final_route_url"] = $route->finalRouteUrl();
        $data["final_route_name"] = $route->finalRouteName();

        if ($route->hasChilds()) {
            $data["tags"][] = count($route->getChilds());
            foreach ($route->getChilds() as $child) {
                $data["nodes"][] = $this->treeRoute($child);
            }
        }
        return $data;
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

    public function createFormAction() {
        $moduleId = $this->params("moduleId");
        $routeParentId = $this->params("routeParentId");

        $route = new \ZfMetal\Generator\Entity\Route();

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Route');

        $form->setAttribute('class', 'form-vertical');
        $form->setAttribute('action', 'javascript:MetalRoutes.createSubmit()');

        //Custom Form
        $form->get("module")->setValue($moduleId);
        if ($routeParentId) {
            $form->get("parent")->setValue($routeParentId);
        }

        if ($routeParentId) {
            $routeParent = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Route")->find($routeParentId);
            $form->get("route")->setOption("description", "Parent Route URL: " . $routeParent->finalRouteUrl());
            $form->get("name")->setOption("description", "Parent Route Name: " . $routeParent->finalRouteName());
        }


        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        return $view;
    }

    public function createAction() {
        $route = new \ZfMetal\Generator\Entity\Route();

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Route');
        $form->bind($route);

        //Process Form
        $result = $this->formProcess($this->getEm(), $form, false)->getResult();
        return new JsonModel($result);
    }

    public function editFormAction() {

        $routeId = $this->params("routeId");

        $route = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Route")->find($routeId);

        if (!$route) {
            throw new \Exception("Route not found in DB");
        }

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Route');
        $form->bind($route);


        $form->setAttribute('class', 'form-vertical');
        $form->setAttribute('action', 'javascript:MetalRoutes.editSubmit(' . $routeId . ')');

        if ($route->hasParent()) {
            $form->get("route")->setOption("description", "Parent Route URL: " . $route->getParent()->finalRouteUrl());
            $form->get("name")->setOption("description", "Parent Route Name: " .  $route->getParent()->finalRouteName());
        }

        //Process Form
        $this->formProcess($this->getEm(), $form);


        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        return $view;
    }

    public function editAction() {

        $routeId = $this->params("routeId");
        $route = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Route")->find($routeId);

        if (!$route) {
            throw new \Exception("Route not found in DB");
        }

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Route');
        $form->bind($route);

        //Process Form
        $result = $this->formProcess($this->getEm(), $form, false)->getResult();
        return new JsonModel($result);
    }

    public function deleteAction() {
        $routeId = $this->params("routeId");
        $route = $this->getRouteRepository()->find($routeId);
        try {
            $this->getRouteRepository()->remove($route);
            $view = new JsonModel(array("status" => "ok", 'routeId' => $routeId));
        } catch (Exception $ex) {
            $view = new JsonModel(array("status" => "error", 'routeId' => $routeId));
        }

        return $view;
    }

}
