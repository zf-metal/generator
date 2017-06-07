<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ViewActionGenerator extends AbstractFileGenerator {

    //CONSTS
    const RELATIVE_PATH = "/view";

    public function getRelativePath() {
        return "/module/" . $this->getModule()->getName() . $this::RELATIVE_PATH . "/" . \ZfMetal\Generator\Generator\Util::camelToDash($this->getModule()->getName()) . "/" . \ZfMetal\Generator\Generator\Util::camelToDash($this->getAction()->getController()->getName()) . "/";
    }

    //Override
    public function getBasePath() {
        return realpath(__DIR__ . "/../../../../..");
    }

    //Override
    public function getAbsolutePath() {
        return $this->getBasePath() . $this->getRelativePath();
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    //BASE NAMES
    public function getBaseName() {
        return \ZfMetal\Generator\Generator\Util::camelToDash($this->getAction()->getName());
    }

    public function getBaseFileName() {
        return $this->getBaseName() . ".phtml";
    }


    public function getBaseNamespace() {
        return "";
    }

    //MODULE
    public function getModule() {
        return $this->getAction()->getController()->getModule();
    }

    /**
     * action
     * 
     * @var \ZfMetal\Generator\Entity\Action
     */
    private $action;
    private $body;

    function __construct($action) {
        $this->action = $action;
    }

    function getAction() {
        return $this->action;
    }

    function setAction(\ZfMetal\Generator\Entity\Action $action) {
        $this->action = $action;
        return $this;
    }

    public function prepare() {
        if ($this->action->getTemplate()) {
            $this->body = $this->getAction()->getTemplate()->getViewContent();
            return $this->body;
        }
        $this->body = "";
    }

    public function getBody() {
        return $this->body;
    }

    function setBody($body) {
        $this->body = $body;
        return $this;
    }

    //Overrride
    public function pushFile($overwrite = false) {
        $this->overwrite = $overwrite;
        try {
            $this->checkFileExist();
            if ($this->getOverwrite() == true || !$this->exists) {
                $this->makeDir();
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

}
