<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ModuleConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $moduleConfig = array();
    protected $module;
    protected $body;
    protected $toClass = true;

    public function getRelativePath() {
        return $this->getModule()->getName() . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "module.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module) {
        $this->module = $module;
    }

    public function getModule() {
        return $this->module;
    }

    public function prepare() {
        $this->generateContent();

        $this->pushFileContent();
    }

    public function generateContent() {
        $cc = 0;
        if (is_dir($this->getAbsolutePath())) {
            $dir = scandir($this->getAbsolutePath());

            $body = '$setting = array_merge_recursive(' . PHP_EOL;
            foreach ($dir as $file) {
                if (preg_match("/config/", $file) && $file != "module.config.php") {
                    $body .= 'include "' . $file . '",' . PHP_EOL;
                    $cc++;
                }
            }
            $body = trim($body, "," . PHP_EOL) . PHP_EOL;
            $body .= ');' . PHP_EOL . PHP_EOL;

            $body .= 'return $setting;' . PHP_EOL;
        }



        if (!$cc) {
            $body = "return array();";
        }



        $this->body = $body;
    }

    protected function getBody() {
        return $this->body;
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    function getModuleConfig() {
        return $this->moduleConfig;
    }

}
