<?php

namespace ZfMetal\Generator\Generator;

/**
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
interface ClassGeneratorInterface {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "";

    //BASE NAMES
    public function getBaseName();

    public function getBaseNamespace();

    //CLASS METHODS
    
    public function getClassArray();

    public function getClassName();

    public function getClassNamespace();

    public function getClassFlags();

    public function getClassExtends();

    public function getClassInterfaces();

    public function getClassProperties();

    public function getClassMethods();

    public function getClassDockBlock();

    public function getClassFileGenerator();

    public function getClassTags();

    public function getClassUses();

    //MODULE
     public function getModule();
    
    //NORMAL CLASS TAGS
    public function getAuthor();

    public function getLicense();

    public function getLink();

    public function getShortDescription();

    public function getLongDescription();

    public function getRelativePath();


    //PREPARE
    public function prepare();

}
