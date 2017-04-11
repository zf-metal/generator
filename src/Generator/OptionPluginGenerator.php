<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class OptionPluginGenerator extends PluginGenerator {

    public function prepare() {
        $this->addProperty();
        $this->addConstructMethod();
        $this->addInvokeMethod();
        parent::prepare();
    }

    function addConstructMethod() {
        $construct = new \Zend\Code\Generator\MethodGenerator();
        $construct->setName('__construct');
        $param = new \Zend\Code\Generator\ParameterGenerator('moduleOptions', $this->getModule()->getName() . '\Options\ModuleOptions');
        $construct->setParameter($param);
        $construct->setBody('$this->moduleOptions = $moduleOptions;');

        $this->classMethods[] = $construct;
    }

    function addProperty() {
        $property = new \Zend\Code\Generator\PropertyGenerator('moduleOptions', null, \Zend\Code\Generator\PropertyGenerator::FLAG_PRIVATE);
        $this->addClassProperties($property);
    }

    function addInvokeMethod() {
        $invoke = new \Zend\Code\Generator\MethodGenerator();
        $invoke->setName('__invoke');
        $invoke->setBody('return $this->moduleOptions;');

        $this->classMethods[] = $invoke;
    }

}
