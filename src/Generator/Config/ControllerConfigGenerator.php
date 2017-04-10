<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ControllerConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $controllerConfig = array();
    protected $controllerCollection;
    protected $module;
    protected $toClass = true;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "controller.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module, $controllerCollection, $toClass = true) {
        $this->module = $module;
        $this->controllerCollection = $controllerCollection;
        $this->toClass = $toClass;
    }

    public function getModule() {
        return $this->module;
    }

    public function prepare() {
        $this->getActualContent();
        $this->pushFileContent();
    }

    public function getActualContent() {
        if (file_exists($this->getFileName())) {
            $config = include $this->getFileName();
            if (is_array($config)) {
                $this->controllerConfig = $config;
                $this->applyClassConstant();
            }
        }
        return $this->controllerConfig;
    }

    public function applyClassConstant() {
        if ($this->toClass) {
            foreach ($this->controllerConfig["controllers"] as $key => $conf) {

                foreach ($conf as $k => $v) {

                    if (class_exists($v)) {
                        $v = new \Zend\Code\Generator\ValueGenerator("\\".$v . "::CLASS", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
                    }


                    if (class_exists($k)) {
                        unset($this->controllerConfig["controllers"][$key][$k]);
                        $this->controllerConfig["controllers"][$key]["\\".$k . "::CLASS"] = $v;
                    }
                }
            }
        }
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getControllerConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }

    protected function genArrayConfig() {
        foreach ($this->getControllerCollection() as $controller) {
            $a["controllers"]["factories"][$this->getControllerClass($controller)->generate()] = $this->getControllerFactory($controller);
        }
        return $a;
    }

    protected function getControllerClass($controller) {
        $str = "\\" . $controller->getModule() . "\Controller\\" . $controller->getName() . 'Controller::CLASS';
        $vg = new \Zend\Code\Generator\ValueGenerator($str, \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
        return $vg;
    }

    protected function getControllerFactory($controller) {
        $str = '\\' . $controller->getModule() . '\Factory\Controller\\' . $controller->getName() . 'ControllerFactory::CLASS';
        $vg = new \Zend\Code\Generator\ValueGenerator($str, \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
        return $vg;
    }

    function getControllerConfig() {
        if (!$this->controllerConfig) {
            $this->controllerConfig = $this->genArrayConfig();
        }
        return $this->controllerConfig;
    }

    function getControllerCollection() {
        return $this->controllerCollection;
    }

}
