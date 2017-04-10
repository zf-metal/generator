<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class PluginGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Controller\Plugin";
    const RELATIVE_PATH = "/src/Controller/Plugin/";

    //BASE NAMES
    public function getBaseName() {
        return $this->getPlugin()->getName();
    }

    public function getBaseNamespace() {
        return $this->getPlugin()->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return "\Zend\Mvc\Controller\Plugin\AbstractPlugin";
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
        return $this->getPlugin()->getModule();
    }

    //NORMAL CLASS TAGS
    public function getLongDescription() {
        return $this->getPlugin()->getDescription();
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Plugin
     */
    private $plugin;

    function __construct($plugin) {
        $this->plugin = $plugin;
    }
    
    function getPlugin(){
        return $this->plugin;
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

    }

}
