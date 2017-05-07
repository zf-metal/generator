<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class NavigationController extends AbstractActionController {

    const ENTITY = \ZfMetal\Generator\Entity\Navigation::class;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;


    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;

    }

    function getEm() {
        return $this->em;
    }

    function setEm(Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    /**
     * 
     * @return \ZfMetal\Generator\Repository\NavigationRepository;
     */
    function getNavigationRepository() {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function mainAction() {

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $navs = $this->getNavigationRepository()->findWhitoutParent($moduleId);

        $view = new ViewModel(array('navs' => $navs, "moduleId" => $moduleId));
        $view->setTerminal(true);
        return $view;
    }

    public function jsonAction() {

        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $navs = $this->getNavigationRepository()->findWhitoutParent($moduleId);

        $data = array();
        foreach ($navs as $nav) {
            $data[] = $this->treeNavigation($nav);
        }

        return new jsonModel($data);
    }

    protected function treeNavigation($nav) {

        $data["text"] = $nav->getLabel();
        $data["navid"] = $nav->getId();
        if ($nav->getRoute()) {
            $data["nav_route"] = $nav->getRoute()->finalRouteName();
        }else{
             $data["nav_route"] = "";
        }

        $data["nav_uri"] = $nav->getUri();

        if ($nav->hasChilds()) {
            $data["tags"][] = count($nav->getChilds());
            foreach ($nav->getChilds() as $child) {
                $data["nodes"][] = $this->treeNavigation($child);
            }
        }
        return $data;
    }

   

    public function createFormAction() {
        $moduleId = $this->params("moduleId");
        $navParentId = $this->params("navParentId");

        $nav = new \ZfMetal\Generator\Entity\Navigation();

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Navigation');

        $form->setAttribute('class', 'form-vertical');
        $form->setAttribute('action', 'javascript:MetalNavigation.createSubmit()');

        //Custom Form
        $form->get("module")->setValue($moduleId);
        if ($navParentId) {
            $form->get("parent")->setValue($navParentId);
        }

        if ($navParentId) {
            $navParent = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Navigation")->find($navParentId);
            $form->get("label")->setOption("description", "Parent: " . $navParent->getLabel());
        }


        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        return $view;
    }

    public function createAction() {
        $nav = new \ZfMetal\Generator\Entity\Navigation();

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Navigation');
        $form->bind($nav);

        //Process Form
        $result = $this->formProcess($this->getEm(), $form, false)->getResult();
        return new JsonModel($result);
    }

    public function editFormAction() {

        $navId = $this->params("navId");

        $nav = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Navigation")->find($navId);

        if (!$nav) {
            throw new \Exception("Navigation not found in DB");
        }

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Navigation');
        $form->bind($nav);


        $form->setAttribute('class', 'form-vertical');
        $form->setAttribute('action', 'javascript:MetalNavigation.editSubmit(' . $navId . ')');

        if ($nav->hasParent()) {
            $form->get("label")->setOption("description", "Parent: " . $nav->getParent()->getLabel());
        }

        //Process Form
        $this->formProcess($this->getEm(), $form);


        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        return $view;
    }

    public function editAction() {

        $navId = $this->params("navId");
        $nav = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Navigation")->find($navId);

        if (!$nav) {
            throw new \Exception("Navigation not found in DB");
        }

        //Generate Form
        $form = $this->formBuilder($this->getEm(), 'ZfMetal\Generator\Entity\Navigation');
        $form->bind($nav);

        //Process Form
        $result = $this->formProcess($this->getEm(), $form, false)->getResult();
        return new JsonModel($result);
    }

    public function deleteAction() {
        $navId = $this->params("navId");
        $nav = $this->getNavigationRepository()->find($navId);
        try {
            $this->getNavigationRepository()->remove($nav);
            $view = new JsonModel(array("status" => "ok", 'navId' => $navId));
        } catch (Exception $ex) {
            $view = new JsonModel(array("status" => "error", 'navId' => $navId));
        }

        return $view;
    }

}
