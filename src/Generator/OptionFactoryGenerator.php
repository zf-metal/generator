<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class OptionFactoryGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Factory\Options";
    const RELATIVE_PATH = "/src/Factory/Options/";

    //BASE NAMES
    public function getBaseName() {
        return "ModuleOptionsFactory";
    }

    public function getBaseNamespace() {
        return $this->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return null;
    }

    public function getClassInterfaces() {
        return [\Zend\ServiceManager\Factory\FactoryInterface::class];
    }

    public function getClassTags() {
        return [];
    }

    public function getClassUses() {
        return [
                ["class" => "Interop\Container\ContainerInterface", "alias" => null],
                ["class" => "Zend\ServiceManager\Factory\FactoryInterface", "alias" => null],
        ];
    }

    //MODULE
    public function getModule() {
        return $this->module;
    }


    /**
     * Description
     * 
     * @var \Zend\Code\Generator\MethodGenerator
     */
    private $invoke;

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Module
     */
    private $module;


    function __construct($module) {
        $this->module = $module;
    }

    public function prepare() {
        parent::prepare();
        $this->genInvoke();
    }

    function getInvokeReturn() {
        $body = '$config = $container->get(\'Config\');'. PHP_EOL;
        $body.= ' return new \\'. $this->getClassNamespace() .'\Options\ModuleOptions(isset($config[\''.$this->getBaseNamespace().'.options\']) ? $config[\''.$this->getBaseNamespace().'.options\'] : array());';
        return $body;
    }

    function getInvoke() {
        if (!$this->invoke) {
            $this->setInvoke(new \Zend\Code\Generator\MethodGenerator("__invoke"));
        }
        return $this->invoke;
    }

    function setInvoke(\Zend\Code\Generator\MethodGenerator $invoke) {
        $this->invoke = $invoke;
    }

    protected function genInvoke() {
        $this->getInvoke()->setBody($this->getInvokeBody());
        $this->getInvoke()->setParameters($this->getInvokeParameter());
        if ($this->getCg()->hasMethod("__invoke")) {
            $this->getCg()->removeMethod("__invoke");
        }
        $this->getCg()->addMethodFromGenerator($this->getInvoke());
    }

    protected function getInvokeParameter() {
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("container", "\Interop\Container\ContainerInterface");
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("requestedName", null);
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("options", "array", array());
        return $parameters;
    }

    protected function getInvokeBody() {
        $body = $this->getInvoke()->getBody();
        $body .= $this->getInvokeReturn();
        return $body;
    }

    function getController() {
        return $this->controller;
    }

    function setController(\ZfMetal\Generator\Entity\Controller $controller) {
        $this->controller = $controller;
    }

}
