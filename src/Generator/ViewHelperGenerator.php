<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ViewHelperGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Helper\View";
    const RELATIVE_PATH = "/src/Helper/View/";

    //BASE NAMES
    public function getBaseName() {
        return $this->getViewHelper()->getName();
    }

    public function getBaseNamespace() {
        return $this->getViewHelper()->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return "\Zend\View\Helper\AbstractHelper";
    }

    public function getClassInterfaces() {
        return [];
    }

    public function getClassTags() {
        return [];
    }

    public function getClassUses() {
        return [];
    }

    //MODULE
    public function getModule() {
        return $this->getViewHelper()->getModule();
    }

    //NORMAL CLASS TAGS
    public function getLongDescription() {
        return $this->getViewHelper()->getDescription();
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\ViewHelper
     */
    private $viewHelper;

    function __construct($viewHelper) {
        $this->viewHelper = $viewHelper;
    }

    function getViewHelper() {
        return $this->viewHelper;
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
        if (!$this->getCg()->hasMethod('__invoke')) {
            $this->getCg()->addMethodFromGenerator($this->addInvokeMethod());
        }
        if (!$this->getViewHelper()->getInvokable()) {
            if (!$this->getCg()->hasMethod('__construct')) {
                $this->getCg()->addMethodFromGenerator($this->addConstructMethod());
            }
        }
    }

    function addConstructMethod() {
        $construct = new \Zend\Code\Generator\MethodGenerator();
        $construct->setName('__construct');

        return $construct;
    }

    function addInvokeMethod() {
        $invoke = new \Zend\Code\Generator\MethodGenerator();
        $invoke->setName('__invoke');

        return $invoke;
    }

}
