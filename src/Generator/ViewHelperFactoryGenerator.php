<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ViewHelperFactoryGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "Factory";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Factory\Helper\View";
    const RELATIVE_PATH = "/src/Factory/Helper/View/";

    //BASE NAMES
    public function getBaseName() {
        return $this->getViewHelper()->getName();
    }

    public function getBaseNamespace() {
        return $this->getViewHelper()->getModule()->getName();
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
        return $this->getViewHelper()->getModule();
    }

    /**
     * Description
     * 
     * @var arrray
     */
    private $dependencies = [];

    /**
     * Description
     * 
     * @var \Zend\Code\Generator\MethodGenerator
     */
    private $invoke;

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\ViewHelper
     */
    private $viewHelper;

    function __construct($viewHelper) {
        $this->viewHelper = $viewHelper;
    }

    function getViewHelper(){
        return $this->viewHelper;
    }

    
    public function prepare() {
        parent::prepare();
        $this->genInvoke();
    }

    function addDependency($name, $type) {
        if (!key_exists($name, $this->dependencies)) {
            $this->dependencies[$name] = ["name" => $name, "type" => $type];
        }
    }

    function getParamters() {
        $parameters = "";
        foreach ($this->dependencies as $p) {
            $parameters .= "$" . $p["name"] . ",";
        }
        return trim($parameters, ",");
    }

    function getInvokeReturn() {
        return "return new \\" . $this->getModule()->getName() . "\Controller\Plugin\\" . $this->getBaseName() . "(" . $this->getParamters() . ");" . PHP_EOL;
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
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("options", "array", null);
        return $parameters;
    }

    protected function getInvokeBody() {
        $body = $this->getInvoke()->getBody();
        $body .= $this->getInvokeReturn();
        return $body;
    }

}
