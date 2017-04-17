<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class OptionViewHelperGenerator extends ViewHelperGenerator {

    public function prepare() {
        //PARENT
        $this->addProperty();

        parent::prepare();
        if (!$this->getCg()->hasMethod('__invoke')) {
            $this->getCg()->addMethodFromGenerator($this->addInvokeMethod());
        }
        if (!$this->getCg()->hasMethod('__construct')) {
            $this->getCg()->addMethodFromGenerator($this->addConstructMethod());
        }
    }

    function addConstructMethod() {
        $construct = new \Zend\Code\Generator\MethodGenerator();
        $construct->setName('__construct');

        $param = new \Zend\Code\Generator\ParameterGenerator('moduleOptions', $this->getModule()->getName() . '\Options\ModuleOptions');
        $construct->setParameter($param);
        $construct->setBody('$this->moduleOptions = $moduleOptions;');

        return $construct;
    }

    function addInvokeMethod() {
        $invoke = new \Zend\Code\Generator\MethodGenerator();
        $invoke->setName('__invoke');
        $invoke->setBody('return $this->moduleOptions;');
        
        return $invoke;
    }

    function addProperty() {
        $property = new \Zend\Code\Generator\PropertyGenerator('moduleOptions', null, \Zend\Code\Generator\PropertyGenerator::FLAG_PRIVATE);
        $this->addClassProperties($property);
    }

}
