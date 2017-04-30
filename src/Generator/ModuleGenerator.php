<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ModuleGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "";
    const RELATIVE_PATH = "/src/";

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
        return null;
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
        return $this->module;
    }

    //NORMAL CLASS TAGS
    public function getLongDescription() {
        return "";
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Controller
     */
    private $module;

    function __construct($module) {
        $this->module = $module;
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
        $this->genMethodGetConfig();
    }

    protected function genMethodGetConfig() {
        $method = new \Zend\Code\Generator\MethodGenerator("getConfig");
        $method->setBody($this->getConfigBody());

        if ($this->getCg()->hasMethod("getConfig")) {
            $this->getCg()->removeMethod("getConfig");
        }
        $this->getCg()->addMethodFromGenerator($method);
    }

    protected function getConfigBody() {
        $body = " return include __DIR__ . '/../config/module.config.php';";
        return $body;
    }

}
