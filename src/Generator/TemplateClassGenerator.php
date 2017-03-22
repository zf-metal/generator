<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class TemplateGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "Template";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Template";
    const RELATIVE_PATH = "/src/Template/";

    //BASE NAMES
    public function getBaseName() {
        return ""; //COMPLETE
    }

    public function getBaseNamespace() {
       return ""; //COMPLETE
    }

    //CLASS METHODS

    public function getClassExtends() {
       return ""; //OPTIONAL 
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
       return new \ZfMetal\Generator\Entity\Module(); // return \ZfMetal\Generator\Entity\Module
    }
    
    //NORMAL CLASS TAGS
    
    public function getLongDescription() {
        return ""; //OPTIONAL 
    }


    //CUSTOM

    function __construct() {
    }

    public function prepare() {
        //CUSTOMS

        //PARENT
        parent::prepare();
        
    }

  

}
