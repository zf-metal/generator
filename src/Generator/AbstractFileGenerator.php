<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of FileTraitGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
abstract class AbstractFileGenerator implements \ZfMetal\Generator\Generator\FileGeneratorInterface {

    const STATUS_OK = 1;
    const STATUS_FAIL = 0;

    /**
     * construct Method
     * 
     * @var \Zend\Code\Generator\FileGenerator
     */
    protected $fg;

    /**
     * Status
     * 
     * @var string
     */
    private $status;

    /**
     * Message
     * 
     * @var string
     */
    protected $message;

    /**
     * overwrite
     * 
     * @var boolean
     */
    protected $overwrite = false;

    /**
     * exist
     * 
     * @var boolean
     */
    protected $exists = null;

    function getFg() {
        if (!$this->fg) {
            $this->fg = new \Zend\Code\Generator\FileGenerator();
        }
        return $this->fg;
    }

    function setFg(\ZfMetal\Generator\Generator\FileGenerator $fg) {
        $this->fg = $fg;
    }

    public function getBasePath() {
        return realpath(__DIR__ . "/../../../../../module/");
    }

    public function getRelativePath() {
        return $this->getModule()->getName() . $this::RELATIVE_PATH;
    }

    public function getAbsolutePath() {
        return $this->getBasePath() . "/" . $this->getRelativePath();
    }

    public function getBaseFileName() {
        return $this->getClassName() . ".php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    public function pushFile($overwrite = true) {
        $this->setOverwrite($overwrite);
        try {
            $this->checkFileExist();
            if ($this->getOverwrite() == true || !$this->exists) {
                $this->makeDir();
                $this->putFile();
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

    protected function makeDir() {
        if (!is_dir($this->getAbsolutePath())) {
            try {
                mkdir($this->getAbsolutePath(), 0777, true);
            } catch (Exception $ex) {
                //LOG ERROR
                throw $ex;
            }
        }
    }

    protected function checkFileExist() {
        $this->exists = file_exists($this->getFileName());
        return $this->exists;
    }

    protected function putFile() {
        try {
            file_put_contents($this->getFileName(), $this->getFg()->generate());
        } catch (Exception $ex) {
            //LOG ERROR
            throw $ex;
        }
    }

    function getStatus() {
        return $this->status;
    }

    function getOverwrite() {
        return $this->overwrite;
    }

    function getExists() {
        return $this->exists;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setOverwrite($overwrite) {
        $this->overwrite = $overwrite;
    }

    function setExists($exists) {
        $this->exists = $exists;
    }

    function getMessage() {
        return $this->message;
    }

    function setMessage($message) {
        $this->message = $message;
    }

}
