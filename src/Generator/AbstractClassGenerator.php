<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of AbstractGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
abstract class AbstractClassGenerator extends AbstractFileGenerator implements \ZfMetal\Generator\Generator\ClassGeneratorInterface {

    /**
     * construct Method
     * 
     * @var \Zend\Code\Generator\ClassGenerator
     */
    protected $cg;

    /**
     *
     * @var array
     */
    protected $classProperties = [];

    /**
     *
     * @var array
     */
    protected $classMethods = [];

    /**
     *
     * @var \Zend\Code\Generator\DocBlockGenerator
     */
    protected $classDockBlock = null;

    /**
     *
     * @var array
     */
    protected $classTags = [];

    /**
     * isPrepared Flag
     * 
     * @var boolean 
     */
    protected $isPrepared = false;

    public function prepare() {

        if (file_exists($this->getFileName()) AND class_exists($this->getClassNamespaceAndName())) {
            $reflectionClass = new \Zend\Code\Reflection\ClassReflection($this->getClassNamespaceAndName());
            if ($reflectionClass->isInstantiable()) {
                $this->setCg(\Zend\Code\Generator\ClassGenerator::fromReflection($reflectionClass));
            } else {
                $this->setCg(\Zend\Code\Generator\ClassGenerator::FromArray($this->getClassArray()));
            }
        } else {
            $this->setCg(\Zend\Code\Generator\ClassGenerator::FromArray($this->getClassArray()));
        }
        
        $this->addUses();

        $this->getFg()->setClass($this->getCg());
        $this->isPrepared = true;
        //USES ??
    }

    public function getClassArray() {
        return [
            'name' => $this->getClassName(), //Needed baseName
            'namespacename' => $this->getClassNamespace(), //Needed baseNamespace
            'flags' => $this->getClassFlags(), //Optional Overwrite
            'extendedclass' => $this->getClassExtends(), //Needed
            'implementedinterfaces' => $this->getClassInterfaces(), //Needed
            'docblock' => $this->getClassDockBlock(), //Optional extension
            'properties' => $this->getClassProperties(), //Optional
            'methods' => $this->getClassMethods(), //Optional
            'containingfile' => $this->getClassFileGenerator(), //Optional Overwrite
        ];
    }

    public function addUses() {
        $uses = $this->getClassUses();
        if (count($uses)) {
            foreach ($uses as $use) {
                if ($use["alias"]) {
                    $this->getCg()->addUse($use["class"], $use["alias"]);
                } else {
                    $this->getCg()->addUse($use["class"]);
                }
            }
        }
    }

    //CLASS METHODS

    public function getClassName() {
        return $this::CLASS_PREFIX . $this->getBaseName() . $this::CLASS_SUBFFIX;
    }

    public function getClassNamespace() {
        return $this::NAMESPACE_PREFIX . $this->getBaseNamespace() . $this::NAMESPACE_SUBFFIX;
    }

    public function getClassNamespaceAndName() {
        return '\\' . $this->getClassNamespace() . '\\' . $this->getClassName();
    }

    public function getClassFlags() {
        return null;
    }

    public function getClassDockBlock() {
        if (!$this->classDockBlock) {
            $this->classDockBlock = $this->genDockBlock();
        }
        return $this->classDockBlock;
    }

    public function getClassProperties() {
        return $this->classProperties;
    }

    public function getClassMethods() {
        return $this->classMethods;
    }

    public function getClassFileGenerator() {
        return $this->getFg();
    }

    //GEN METHODS

    protected function genDockBlock() {
        $dockBlock = new \Zend\Code\Generator\DocBlockGenerator();
        $dockBlock->setShortDescription($this->getShortDescription());
        $dockBlock->setLongDescription($this->getLongDescription());
        $tags = [
            ["name" => "author", 'description' => $this->getAuthor()],
            ["name" => "license", 'description' => $this->getLicense()],
            ["name" => "link", 'description' => $this->getLink()],
        ];

        $tags = array_merge_recursive($tags, $this->getClassTags());

        $dockBlock->setTags($tags);

        return $dockBlock;
    }

    //NORMAL CLASS TAGS
    public function getAuthor() {
        return $this->getModule()->getAuthor();
    }

    public function getLicense() {
        return $this->getModule()->getLicense();
    }

    public function getLink() {
        return $this->getModule()->getLink();
    }

    public function getShortDescription() {
        return $this->getBaseName() . $this::CLASS_SUBFFIX;
    }

    public function getLongDescription() {
        return "";
    }

    //GT-ST

    function getCg() {
        if (!$this->cg) {
            throw new \Exception("ClassGenerator need be prepare");
        }
        return $this->cg;
    }

    function setCg(\Zend\Code\Generator\ClassGenerator $cg) {
        $this->cg = $cg;
    }

    public function setClassProperties($classProperties) {
        $this->classProperties = $classProperties;
    }

    public function setClassMethods($classMethods) {
        $this->classMethods = $classMethods;
    }

    public function addClassProperties($classProperty) {
        $this->classProperties[] = $classProperty;
    }

}
