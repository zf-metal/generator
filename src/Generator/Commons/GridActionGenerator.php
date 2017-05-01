<?php

namespace ZfMetal\Generator\Generator\Commons;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class GridActionGenerator {

    static function applyGridinFactory(\ZfMetal\Generator\Generator\ControllerFactoryGenerator $cgf) {
        $cgf->addDependency("grid", "\ZfMetal\Datagrid\Grid");
        $fullName = str_replace("\\", "-", $cgf->getController()->getEntity()->getFullName());
        $body = $cgf->getInvoke()->getBody();
        $body .= '/* @var $grid \ZfMetal\Datagrid\Grid */' . PHP_EOL;
        $body .= '$grid = $container->build("zf-metal-datagrid", ["customOptionsKey" => "' . $fullName . '"]);' . PHP_EOL;
        $cgf->getInvoke()->setBody($body);
    }

    static function applyGridAction(\ZfMetal\Generator\Generator\ControllerGenerator $controllerGenerator) {
        self::genGridProperty($controllerGenerator);
        self::genConstruct($controllerGenerator);

        if (!$controllerGenerator->getCg()->hasMethod("gridAction")) {
            self::genGridAction($controllerGenerator);
        }
    }

    static protected function genGridProperty($controllerGenerator) {
        if (!$controllerGenerator->getCg()->hasProperty("grid")) {
            $controllerGenerator->getCg()->addPropertyFromGenerator(self::getGridProperty());
        }

        if (!$controllerGenerator->getCg()->hasMethod("getGrid")) {
            $controllerGenerator->getCg()->addMethodFromGenerator(self::getGridGetter());
        }

        if (!$controllerGenerator->getCg()->hasMethod("setGrid")) {
            $controllerGenerator->getCg()->addMethodFromGenerator(self::getGridSetter());
        }
    }

    static protected function genConstruct($controllerGenerator) {
        $cm = $controllerGenerator->getConstruct();

        //BODY
        $body = $cm->getBody();

        //CHECK IF EM EXIST
        if (!preg_match("/grid/", $body)) {
            $body .= ' $this->grid = $grid;' . PHP_EOL;
            $cm->setBody($body);
        }

        //PARAMETERS
        $grid = new \Zend\Code\Generator\ParameterGenerator("grid", "\ZfMetal\Datagrid\Grid");
        $cm->setParameter($grid);
    }

    static protected function genGridAction($controllerGenerator) {
        $controllerGenerator->getCg()->addMethodFromGenerator(self::getGridAction());
    }

    static protected function getGridProperty() {
        $p = new \Zend\Code\Generator\PropertyGenerator();
        $p->setName("grid");
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = [["name" => 'var \ZfMetal\Datagrid\Grid']];
        $d->setTags($a);
        $p->setDocBlock($d);
        return $p;
    }

    static protected function getGridGetter() {
        return \ZfMetal\Generator\Generator\Util::genGetter("grid");
    }

    static protected function getGridSetter() {
        return \ZfMetal\Generator\Generator\Util::genSetter("grid", "\ZfMetal\Datagrid\Grid");
    }

    static protected function getGridAction() {

        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName("gridAction");

        //BODY

        $body = '$this->grid->prepare();' . PHP_EOL;
        $body .= 'return array("grid" => $this->grid);' . PHP_EOL;
        $method->setBody($body);

        return $method;
    }

}
