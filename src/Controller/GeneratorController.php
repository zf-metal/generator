<?php

namespace ZfMetal\Generator\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class GeneratorController extends AbstractActionController {

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

    public function entityAction() {
        $entityId = $this->params("entityId");
        $entity = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Entity")->find($entityId);

        $entityGenerator = new \ZfMetal\Generator\Generator\EntityGenerator($entity);
        $entityGenerator->prepare();
        $entityGenerator->pushFile(true);

        $repositoryGenerator = new \ZfMetal\Generator\Generator\RepositoryGenerator($entity);
        $repositoryGenerator->prepare();
        $repositoryGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "entityGenerator" => $entityGenerator,
            "repositoryGenerator" => $repositoryGenerator,
            "entity" => $entity]);
        $view->setTerminal(true);
        return $view;
    }

    public function routeAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $routeCollection = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Route")->findWhitoutParent($moduleId);

        $routeConfigGenerator = new \ZfMetal\Generator\Generator\Config\RouteConfigGenerator($module, $routeCollection);
        $routeConfigGenerator->prepare();
        $routeConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "routeConfigGenerator" => $routeConfigGenerator]);
        $view->setTerminal(true);
        return $view;
    }

    public function controllerAction() {
        $controllerId = $this->params("controllerId");
        $controller = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Controller")->find($controllerId);
        $module = $controller->getModule();

        $controllerGenerator = new \ZfMetal\Generator\Generator\ControllerGenerator($controller);
        $controllerGenerator->prepare();
        $controllerGenerator->pushFile(true);


        $controllerFactoryGenerator = new \ZfMetal\Generator\Generator\ControllerFactoryGenerator($controller);
        $controllerFactoryGenerator->prepare();
        $controllerFactoryGenerator->pushFile(true);

        $controllerCollection = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Controller")->findByModule($module->getId());

        $controllerConfigGenerator = new \ZfMetal\Generator\Generator\Config\ControllerConfigGenerator($module, $controllerCollection);
        $controllerConfigGenerator->prepare();
        $controllerConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "controllerGenerator" => $controllerGenerator,
            "controllerFactoryGenerator" => $controllerFactoryGenerator,
            "controller" => $controller]);
        $view->setTerminal(true);
        return $view;
    }

    public function optionAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $optionCollection = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Option")->findByModule($moduleId);

        $optionGenerator = new \ZfMetal\Generator\Generator\OptionGenerator($module, $optionCollection);
        $optionGenerator->prepare();
        $optionGenerator->pushFile(true);

        $optionFactoryGenerator = new \ZfMetal\Generator\Generator\OptionFactoryGenerator($module);
        $optionFactoryGenerator->prepare();
        $optionFactoryGenerator->pushFile(true);

        $servicesConfigGenerator = new \ZfMetal\Generator\Generator\Config\ServicesConfigGenerator($module);
        $servicesConfigGenerator->prepare();
        $servicesConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "optionGenerator" => $optionGenerator,
            'optionFactoryGenerator' => $optionFactoryGenerator
        ]);
        $view->setTerminal(true);
        return $view;
    }

}
