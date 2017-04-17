<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ServicesConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $servicesConfig = array();
    protected $module;
    protected $toClass = true;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "services.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module, $toClass = true) {
        $this->module = $module;
        $this->toClass = $toClass;
    }

    public function getModule() {
        return $this->module;
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
                $this->servicesConfig = $config;
            }
        }
        return $this->servicesConfig;
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getServicesConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }
    
    protected function getKeyOption(){
        return $this->getModule()->getName().'.options';
    }

    protected function getOptionFactory() {
        $str = '\\' . $this->getModule()->getName() . '\Factory\Options\\ModuleOptionsFactory::class';
        $vg = new \Zend\Code\Generator\ValueGenerator($str, \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
        return $vg;
    }

    function getServicesConfig() {

        return $this->servicesConfig;
    }

    protected function mergeContent() {
        $this->servicesConfig = \Zend\Stdlib\ArrayUtils::merge($this->getServicesConfig(), $this->generateOptionServices(), TRUE);
    }

    protected function generateOptionServices() {
        return [
            'service_manager' => [
                'factories' => [
                    $this->getKeyOption() => $this->getOptionFactory(),
                ]
            ]
        ];
    }

}
