<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ModuleOptionsGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "Options";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Options";
    const RELATIVE_PATH = "/src/Options/";

    //BASE NAMES
    public function getBaseName() {
        return "Module";
    }

    public function getBaseNamespace() {
        return $this->getModule()->getName();
    }
    //..
    //CLASS METHODS

    public function getClassExtends() {
        return "Zend\Mvc\Controller\AbstractActionController";
    }

    public function getClassInterfaces() {
        return [];
    }

    public function getClassTags() {
        return [];
    }

    public function getClassUses() {
        return [
            ["class" => "Zend\Mvc\Controller\AbstractActionController", "alias" => null],
        ];
    }

    //MODULE
    public function getModule() {
        return $this->getController()->getModule();
    }

    //NORMAL CLASS TAGS
    public function getLongDescription() {
        return $this->getController()->getDescription();
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Controller
     */
    private $controller;

    function __construct($controller) {
        $this->controller = $controller;
    }

    function getController() {
        return $this->controller;
    }

    function setController(\ZfMetal\Generator\Entity\Controller $controller) {

        $this->controller = $controller;
    }

    public function getConstruct() {
        if (!$this->getCg()->getMethod("__construct")) {
            $this->genConstruct();
        }
        return $this->getCg()->getMethod("__construct");
    }

    protected function genConstruct() {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName("__construct");
        $this->getCg()->addMethodFromGenerator($method);
    }

    public function prepare() {
        //PARENT
        parent::prepare();
        //CUSTOMS
        $this->genCommons();
        //ACTIONS
        $this->genActions();
    }

    protected function genCommons() {
        $c = $this->getController()->getCommons();
        if ($c) {
            //GRID ACTION
            if ($c->getEntityManager()) {
                \ZfMetal\Generator\Generator\Commons\EmGenerator::applyEm($this);
            }

            if ($c->getGridAction()) {
                \ZfMetal\Generator\Generator\Commons\GridActionGenerator::applyGridAction($this);
            }
        }
    }

    protected function genActions() {
//        foreach ($this->getController()->getActions() as $action) {
//            $actionGenerator = new \ZfMetal\Generator\Generator\ActionGenerator($action, $this->classGenerator);
//            $actionGenerator->generate();
//        }
    }

}
