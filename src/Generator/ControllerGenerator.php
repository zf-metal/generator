<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ControllerGenerator extends AbstractClassGenerator {
    //INIT ClassGeneratorInterface

    /**
     * Prefix
     */
    const CLASS_PREFIX = "";

    /**
     * Subffix
     */
    const CLASS_SUBFFIX = "Controller";

    /**
     * Namespace Prefix
     */
    const NAMESPACE_PREFIX = "";

    /**
     * Namespace Subffix
     */
    const NAMESPACE_SUBFFIX = "\Controller";

    /**
     * PATH Subffix
     */
    const PATH_SUBFFIX = "/src/Controller/";

    /**
     * USES
     * 
     * Remember: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @type array
     */
    const USES = [
        ["class" => "Zend\Mvc\Controller\AbstractActionController", "alias" => null],
    ];

    public function getTags() {
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
//        $this->genActions();
        $this->insertFile();
    }

    /**
     * [6] Se generan Actions
     */
    protected function genActions() {
        foreach ($this->getController()->getActions() as $action) {
            //GENERATE AND ADD Action 
            $actionGenerator = new \ZfMetal\Generator\Generator\ActionGenerator($action, $this->classGenerator);
            $actionGenerator->generate();
        }
    }

}
