<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ComposerConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "";

    protected $composerConfig = array();
    protected $controller;
    protected $module;
    protected $toClass = true;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    //Override
    public function getBasePath() {
        return realpath(__DIR__ . "/../../../../../..");
    }

    //Override
    public function getAbsolutePath() {
        return $this->getBasePath();
    }

    public function getBaseFileName() {
        return "composer.json";
    }

    function getFileName() {
        return $this->getAbsolutePath() . "/" . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module) {
        $this->module = $module;
    }

    public function getModule() {
        return $this->module;
    }

    public function prepare() {
        $this->getActualContent();
        $this->agregateContent();
    }

    public function getActualContent() {
        if (file_exists($this->getFileName())) {
           $this->composerConfig = json_decode(file_get_contents($this->getFileName()),true);
        }
        return $this->composerConfig;
    }

    protected function agregateContent() {
        $this->composerConfig["autoload"]["psr-4"][$this->getModule()->getName() . "\\"] = "module/" . $this->getModule()->getName() . "/src/";
    }

    protected function getBody() {
        return json_encode($this->composerConfig, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
      
    }

    //Overrride
    public function pushFile($overwrite = true) {
        $this->overwrite = $overwrite;
        try {
            $this->checkFileExist();
            if ($this->getOverwrite() == true || !$this->exists) {
                file_put_contents($this->getFileName(), $this->getBody());
                $this->setStatus(true);
                $this->setMessage("File write ok.");
            } else {
                $this->setMessage("File exists and overwrite option is false.");
                $this->setStatus(false);
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function getControllerConfig() {
        return $this->composerConfig;
    }

}
