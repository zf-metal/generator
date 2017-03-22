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

    protected $controllerConfig;
    protected $controllerCollection;
    protected $module;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "controller.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module, $controllerCollection) {
        $this->module = $module;
        $this->controllerCollection = $controllerCollection;
    }

    public function getModule() {
        return $this->module;
    }

    public function prepare() {
        $this->pushFileContent();
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \Zend\Code\Generator\ValueGenerator($this->getControllerConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY);
         $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
        return $this->normalizeBodyConfig($body);
    }
    
    protected function normalizeBodyConfig($body){
        $n = str_replace("\\\\", "\\", $body);
        $n = str_replace("\'\\", "", $n);
        $n = str_replace("CLASS\'", "CLASS", $n);
        return $n;
    }

    protected function genArrayConfig() {
        foreach ($this->getControllerCollection() as $controller) {
            $a["controllers"]["factories"][$this->getControllerClass($controller)] = $this->getControllerFactory($controller);
        }
        return $a;
    }

    protected function getControllerClass($controller) {
        $str = "\\" . $controller->getModule() . "\Controller\\" . $controller->getName() . 'Controller::CLASS';
        $vg = new \Zend\Code\Generator\ValueGenerator($str, \Zend\Code\Generator\ValueGenerator::TYPE_);
        return $vg->generate();
    }

    protected function getControllerFactory($controller) {
        $str = '\\' . $controller->getModule() . '\Factory\Controller\\' . $controller->getName() . 'ControllerFactory::CLASS';
        $vg = new \Zend\Code\Generator\ValueGenerator($str, \Zend\Code\Generator\ValueGenerator::TYPE_OTHER);
        return $vg->generate();
    }

    function getControllerConfig() {
        if (!$this->controllerConfig) {
            $this->controllerConfig = $this->genArrayConfig();
        }
        var_dump($this->controllerConfig);
        return $this->controllerConfig;
    }

    function getControllerCollection() {
        return $this->controllerCollection;
    }

}
