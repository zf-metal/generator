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

    public function moduleAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $ModuleGenerator = new \ZfMetal\Generator\Generator\ModuleGenerator($module);
        $ModuleGenerator->prepare();
        $ModuleGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "moduleGenerator" => $ModuleGenerator]);
        $view->setTerminal(true);
        return $view;
    }
    
    public function moduleConfigAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $ModuleGenerator = new \ZfMetal\Generator\Generator\Config\ModuleConfigGenerator($module);
        $ModuleGenerator->prepare();
        $ModuleGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "moduleGenerator" => $ModuleGenerator]);
        $view->setTerminal(true);
        return $view;
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

    public function navigationAction() {
        $moduleId = $this->params("moduleId");
        $module = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Module")->find($moduleId);

        $navCollection = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Navigation")->findWhitoutParent($moduleId);

        $navConfigGenerator = new \ZfMetal\Generator\Generator\Config\NavigationConfigGenerator($module, $navCollection);
        $navConfigGenerator->prepare();
        $navConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "navConfigGenerator" => $navConfigGenerator]);
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

        $controllerConfigGenerator = new \ZfMetal\Generator\Generator\Config\ControllerConfigGenerator($controller);
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

        $plugin = new \ZfMetal\Generator\Entity\Plugin();
        $plugin->setName('Options');
        $plugin->setModule($module);

        $pluginGenerator = new \ZfMetal\Generator\Generator\OptionPluginGenerator($plugin);
        $pluginGenerator->prepare();
        $pluginGenerator->pushFile(true);

        $pluginFactoryGenerator = new \ZfMetal\Generator\Generator\OptionPluginFactoryGenerator($plugin);
        $pluginFactoryGenerator->prepare();
        $pluginFactoryGenerator->pushFile(true);

        $pluginsConfigGenerator = new \ZfMetal\Generator\Generator\Config\PluginsConfigGenerator($plugin);
        $pluginsConfigGenerator->prepare();
        $pluginsConfigGenerator->pushFile(true);

        $viewHelper = new \ZfMetal\Generator\Entity\ViewHelper();
        $viewHelper->setName('Options');
        $viewHelper->setModule($module);

        $viewHelperGenerator = new \ZfMetal\Generator\Generator\OptionViewHelperGenerator($viewHelper);
        $viewHelperGenerator->prepare();
        $viewHelperGenerator->pushFile(true);

        $viewHelperFactoryGenerator = new \ZfMetal\Generator\Generator\OptionViewHelperFactoryGenerator($viewHelper);
        $viewHelperFactoryGenerator->prepare();
        $viewHelperFactoryGenerator->pushFile(true);

        $viewHelperConfigGenerator = new \ZfMetal\Generator\Generator\Config\ViewConfigGenerator($viewHelper);
        $viewHelperConfigGenerator->prepare();
        $viewHelperConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "optionGenerator" => $optionGenerator,
            'optionFactoryGenerator' => $optionFactoryGenerator
        ]);
        $view->setTerminal(true);
        return $view;
    }

    public function pluginAction() {
        $pluginId = $this->params("pluginId");

        $plugin = $this->getEm()->getRepository("ZfMetal\Generator\Entity\Plugin")->find($pluginId);

        $pluginGenerator = new \ZfMetal\Generator\Generator\PluginGenerator($plugin);
        $pluginGenerator->prepare();
        $pluginGenerator->pushFile(true);

        $pluginFactoryGenerator = null;
        if (!$plugin->getInvokable()) {
            $pluginFactoryGenerator = new \ZfMetal\Generator\Generator\PluginFactoryGenerator($plugin);
            $pluginFactoryGenerator->prepare();
            $pluginFactoryGenerator->pushFile(true);
        }

        $pluginsConfigGenerator = new \ZfMetal\Generator\Generator\Config\PluginsConfigGenerator($plugin);
        $pluginsConfigGenerator->prepare();
        $pluginsConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "pluginGenerator" => $pluginGenerator,
            "pluginFactoryGenerator" => $pluginFactoryGenerator,
        ]);
        $view->setTerminal(true);
        return $view;
    }

    public function viewHelperAction() {
        $viewHelperId = $this->params("viewHelperId");

        $viewHelper = $this->getEm()->getRepository("ZfMetal\Generator\Entity\ViewHelper")->find($viewHelperId);

        $viewHelperGenerator = new \ZfMetal\Generator\Generator\ViewHelperGenerator($viewHelper);
        $viewHelperGenerator->prepare();
        $viewHelperGenerator->pushFile(true);

        $viewHelperFactoryGenerator = null;
        if (!$viewHelper->getInvokable()) {
            $viewHelperFactoryGenerator = new \ZfMetal\Generator\Generator\ViewHelperFactoryGenerator($viewHelper);
            $viewHelperFactoryGenerator->prepare();
            $viewHelperFactoryGenerator->pushFile(true);
        }

        $viewHelperConfigGenerator = new \ZfMetal\Generator\Generator\Config\ViewConfigGenerator($viewHelper);
        $viewHelperConfigGenerator->prepare();
        $viewHelperConfigGenerator->pushFile(true);

        $view = new \Zend\View\Model\ViewModel([
            "viewHelperGenerator" => $viewHelperGenerator,
            "viewHelperFactoryGenerator" => $viewHelperFactoryGenerator,
        ]);
        $view->setTerminal(true);
        return $view;
    }

}
