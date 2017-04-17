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
    protected $controller;
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

    function __construct(\ZfMetal\Generator\Entity\Controller $controller) {
        $this->controller = $controller;
    }

    public function getModule() {
        return $this->controller->getModule();
    }

    public function prepare() {
        $this->getActualContent();
        $this->mergeContent();
        $this->pushFileContent();
    }

    public function getActualContent() {
        if (file_exists($this->getFileName())) {
            $config = include $this->getFileName();
            if (is_array($config)) {
                $this->controllerConfig = $config;
            }
        }
        return $this->controllerConfig;
    }

    protected function mergeContent() {
        $this->controllerConfig = \Zend\Stdlib\ArrayUtils::merge($this->getControllerConfig(), $this->generateControllerConfig(), TRUE);
        $this->applyClassConstant();
    }

    protected function getControllerKey() {
        return $this->getModule()->getName() . "\Controller\\" . $this->getController()->getName() . 'Controller';
    }

    protected function getControllerValue() {
        return $this->getModule()->getName() . '\Factory\Controller\\' . $this->getController()->getName() . 'ControllerFactory';
    }

    protected function generateControllerConfig() {
        return [
            'controllers' => [
                'factories' => [
                    $this->getControllerKey() => $this->getControllerValue(),
                ],
            ]
        ];
    }

    public function applyClassConstant() {
        if (key_exists('controllers', $this->controllerConfig)) {
            foreach ($this->controllerConfig["controllers"] as $key => $conf) {

                foreach ($conf as $k => $v) {
                    if (class_exists($v) || $v == $this->getControllerValue()) {
                        $v = new \Zend\Code\Generator\ValueGenerator("\\" . $v . "::class", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
                    }

                    if (class_exists($k) || $k == $this->getControllerKey()) {
                        unset($this->controllerConfig["controllers"][$key][$k]);
                        $this->controllerConfig["controllers"][$key]["\\" . $k . "::class"] = $v;
                    } else {
                        $this->controllerConfig["controllers"][$key][$k] = $v;
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

    function getControllerConfig() {
        return $this->controllerConfig;
    }

    function getController() {
        return $this->controller;
    }

    function setController($controller) {
        $this->controller = $controller;
        return $this;
    }

}
