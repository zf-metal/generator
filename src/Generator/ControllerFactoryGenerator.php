<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ControllerFactoryGenerator extends AbstractClassGenerator {
    //INIT ClassGeneratorInterface

    /**
     * Prefix
     */
    const CLASS_PREFIX = "";

    /**
     * Subffix
     */
    const CLASS_SUBFFIX = "ControllerFactory";

    /**
     * Namespace Prefix
     */
    const NAMESPACE_PREFIX = "";

    /**
     * Namespace Subffix
     */
    const NAMESPACE_SUBFFIX = "\Factory\Controller";

    /**
     * PATH Subffix
     */
    const PATH_SUBFFIX = "/src/Factory/Controller/";

    /**
     * USES
     * 
     * Remember: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @type array
     */
    const USES = [
        ["class" => "Interop\Container\ContainerInterface", "alias" => null],
        ["class" => "Zend\ServiceManager\Factory\FactoryInterface", "alias" => null],
    ];

   
    public function getTags(){
        return [];
    }

    public function getClassName() {
        return $this->getController()->getName();
    }

    public function getNamespaceName() {
        return $this->getController()->getModule()->getName();
    }

    public function getExtendsName() {
        return "Zend\Mvc\Controller\AbstractActionController";
    }

    public function getPath() {
        return $this->getController()->getModule()->getPath();
    }

    public function getAuthor() {
        return $this->getController()->getModule()->getAuthor();
    }

    public function getLicense() {
        return $this->getController()->getModule()->getLicense();
    }

    public function getLink() {
        return $this->getController()->getModule()->getLink();
    }

    public function getShortDescription() {
        return $this->getController()->getName() . $this::CLASS_SUBFFIX;
    }

    public function getLongDescription() {
        return $this->getController()->getDescription();
    }

    //END ClassGeneratorInterface

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Controller
     */
    private $controller;

    function __construct(\ZfMetal\Generator\Entity\Controller $controller) {
        $this->controller = $controller;
    }

    function getController() {
        return $this->controller;
    }

    function setController(\ZfMetal\Generator\Entity\Controller $controller) {
        $this->controller = $controller;
    }

    public function generate() {
        parent::generate();
        $this->genInvoke();
        $this->insertFile();
    }

    /**
     * [6] Se generan Actions
     */
    protected function genInvoke() {
        $m = new \Zend\Code\Generator\MethodGenerator();
        $m->setName("__invoke");
        $m->setBody($this->getInvokeBody());
        $m->setParameters($this->getInvokeParameter());
        $this->getClassGenerator()->addMethodFromGenerator($m);
    }

    protected function getInvokeParameter() {
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("container", "Interop\Container\ContainerInterface");
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("requestedName", null);
        $parameters[] = new \Zend\Code\Generator\ParameterGenerator("options", "array", null);
        return $parameters;
    }

    protected function getInvokeBody() {
        $body = "return new \\" . $this->getNamespaceName() . "\Controller\\" . $this->getClassName() . "Controller();";
        return $body;
    }

}
