<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class OptionGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Options";
    const RELATIVE_PATH = "/src/Options/";

    //BASE NAMES
    public function getBaseName() {
        return "ModuleOptions"; //COMPLETE
    }

    public function getBaseNamespace() {
        return $this->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return "\Zend\Stdlib\AbstractOptions"; //OPTIONAL 
    }

    public function getClassInterfaces() {
        return []; //OPTIONAL 
    }

    public function getClassTags() {
        return []; //OPTIONAL 
    }

    public function getClassUses() {
        return []; //OPTIONAL. Format:  ["class" => "", "alias" => ""],
    }

    //MODULE
    public function getModule() {
        return $this->module;
    }

    //NORMAL CLASS TAGS

    public function getLongDescription() {
        return ""; //OPTIONAL 
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Module
     */
    private $module;

    /**
     * Description
     * 
     * @var array
     */
    private $optionCollection;

    function getOptionCollection() {
        return $this->optionCollection;
    }

    function __construct($module, $optionCollection) {
        $this->module = $module;
        $this->optionCollection = $optionCollection;
    }

    public function prepare() {

        //PARENT
        parent::prepare();

        $this->addProperties();
    }

    protected function addProperties() {
        foreach ($this->getOptionCollection() as $option) {
            $property = new \Zend\Code\Generator\PropertyGenerator($option->getName(), $option->getDefaultValue(), \Zend\Code\Generator\PropertyGenerator::FLAG_PRIVATE);
            
            if(!$this->getCg()->hasProperty($option->getName())){
                $this->getCg()->addPropertyFromGenerator($property);
            }
            
            $getter = $this->getMethodGetter($option);
            $setter = $this->getMethodSetter($option);
            
            if(!$this->getCg()->hasMethod($getter->getName())){
                $this->getCg()->addMethodFromGenerator($getter);
            }
            
            
            if(!$this->getCg()->hasMethod($setter->getName())){
                $this->getCg()->addMethodFromGenerator($setter);
            }
        }
    }

    protected function getMethodSetter($option) {
        $name = 'set' . ucfirst($option->getName());
        $parameter = new \Zend\Code\Generator\ParameterGenerator($option->getName());
        $body = '$this->' . $option->getName() . '= $' . $option->getName() . ';' . PHP_EOL;
        $setter = new \Zend\Code\Generator\MethodGenerator($name, [$parameter], \Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC, $body);

        return $setter;
    }

    protected function getMethodGetter($option) {
        $name = 'get' . ucfirst($option->getName());
        $body = 'return $this->' . $option->getName() . ';' . PHP_EOL;
        $setter = new \Zend\Code\Generator\MethodGenerator($name, [], \Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC, $body);

        return $setter;
    }

}
