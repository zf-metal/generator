<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of AbstractGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
abstract class AbstractClassGenerator implements ClassGeneratorInterface {

    /**
     * Description
     * 
     * @var \Zend\Code\Generator\ClassGenerator
     */
    protected $classGenerator;

    /**
     * Description
     * 
     * @var \Zend\Code\Generator\FileGenerator
     */
    protected $file;

    /**
     * fileGenerate by \Zend\Code\Generator\FileGenerator
     * 
     */
    protected $fileGenerate;

    /**
     * path
     * 
     * @var string
     */
    protected $path;

    /**
     * path
     * 
     * @var string
     */
    protected $completePath;

    /**
     * name
     * 
     * @var string
     */
    protected $name;

    /**
     * fileName
     * 
     * @var string
     */
    protected $fileName;

    /**
     * Status
     * 
     * @var string
     */
    protected $status;

    /**
     * msj
     * 
     * @var string
     */
    protected $msj;

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

    public function generate() {
        $this->genClass();
        $this->genNamespace();
        $this->genUse();
        $this->genDockBlockClass();
        $this->genExtendClass();
        $this->genFile();
    }

    public function getFullClassName() {
        return $this::CLASS_PREFIX . $this->getClassName() . $this::CLASS_SUBFFIX;
    }

    /**
     * [1] Generate class Generator
     */
    protected function genClass() {
        $this->setClassGenerator(new \Zend\Code\Generator\ClassGenerator());
        $this->getClassGenerator()->setName($this->getFullClassName());
    }

    /**
     * [2] Generate Namespace
     */
    protected function genNamespace() {
        $namespace = $this::NAMESPACE_PREFIX . $this->getNamespaceName() . $this::NAMESPACE_SUBFFIX;
        $this->getClassGenerator()->setNamespaceName($namespace);
    }

    /**
     * [3] Generate USE
     */
    protected function genUse() {
        foreach ($this::USES as $USE) {
            $this->classGenerator->addUse($USE["class"],$USE["alias"]);
        }
    }

    /**
     * [4] Generate DockBlock
     */
    protected function genDockBlockClass() {
        $dockBlock = new \Zend\Code\Generator\DocBlockGenerator();
        $dockBlock->setShortDescription($this->getShortDescription());
        $dockBlock->setLongDescription($this->getLongDescription());
        $a = [
            ["name" => "author", 'description' => $this->getAuthor()],
            ["name" => "license", 'description' => $this->getLicense()],
            ["name" => "link", 'description' => $this->getLink()],
        ];

        $a = array_merge_recursive($a, $this->getTags());

        $dockBlock->setTags($a);

        $this->classGenerator->setDocBlock($dockBlock);
    }

    /**
     * [5] Generate Extends
     */
    protected function genExtendClass() {
        $this->classGenerator->setExtendedClass($this->getExtendsName());
    }

    /**
     * [6] Generate FILE
     */
    protected function genFile() {
        $this->file = new \Zend\Code\Generator\FileGenerator();
        $this->getFile()->setClass($this->getClassGenerator());
    }

    /**
     * INSERT FILE
     */
    protected function insertFile() {
        try {
            $dir = realpath(__DIR__ . "/../../../../../");

            $this->path = $this->getPath() . $this::PATH_SUBFFIX;
            $this->completePath = $dir . $this->path;
            $this->name = $this->getFullClassName() . ".php";
            $this->fileName = $this->completePath . $this->name;

            $this->checkFileExist();

            if ($this->getOverwrite() == true || !$this->exists) {

                $this->makeDir();
                $this->putFile();
                $this->status = true;
            } else {
                $this->msj = "File exists";
                $this->status = false;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    protected function makeDir() {
        if (!is_dir($this->completePath)) {
            try {
                mkdir($this->completePath, 0777, true);
            } catch (Exception $ex) {
                //LOG ERROR
                throw $ex;
            }
        }
    }

    protected function checkFileExist() {
        $this->exists = file_exists($this->fileName);
        if ($this->exists) {
            $this->msj = "File overwritten";
        } else {
            $this->msj = "Generated file";
        }
    }

    protected function putFile() {
        $this->fileGenerate = $this->getFile()->generate();

        try {
            file_put_contents($this->fileName, $this->fileGenerate);
        } catch (Exception $ex) {
            //LOG ERROR
            throw $ex;
        }
    }

    function getClassGenerator() {
        return $this->classGenerator;
    }

    function getFile() {
        return $this->file;
    }

    function getFileGenerate() {
        return $this->fileGenerate;
    }

    function getPath() {
        return $this->path;
    }

    function getCompletePath() {
        return $this->completePath;
    }

    function getName() {
        return $this->name;
    }

    function getFileName() {
        return $this->fileName;
    }

    function getStatus() {
        return $this->status;
    }

    function getMsj() {
        return $this->msj;
    }

    function getOverwrite() {
        return $this->overwrite;
    }

    function getExists() {
        return $this->exists;
    }

    function setClassGenerator(\Zend\Code\Generator\ClassGenerator $classGenerator) {
        $this->classGenerator = $classGenerator;
    }

    function setFile(\Zend\Code\Generator\FileGenerator $file) {
        $this->file = $file;
    }

    function setOverwrite($overwrite) {
        $this->overwrite = $overwrite;
    }

}
