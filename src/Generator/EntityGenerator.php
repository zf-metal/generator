<?php

namespace ZfMetal\Generator\Generator;

/**
 * EntityGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class EntityGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Entity";
    const RELATIVE_PATH = "/src/Entity/";

    //BASE NAMES
    public function getBaseName() {
        return $this->getEntity()->getName();
    }

    public function getBaseNamespace() {
        return $this->getEntity()->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return ""; //OPTIONAL 
    }

    public function getClassInterfaces() {
        return []; //OPTIONAL 
    }

    public function getClassTags() {
        return [
            ["name" => 'ORM\Table(name="' . $this->genTableName() . '"' . $this->genCustomTable() . ')'],
            ["name" => 'ORM\Entity(repositoryClass="' . $this->genRepositoryClass() . '")'],
        ];
    }

    public function getClassUses() {
        return [
            ["class" => "Doctrine\Common\Collections\ArrayCollection", "alias" => "ArrayCollection"],
            ["class" => "Zend\Form\Annotation", "alias" => "Annotation"],
            ["class" => "Doctrine\ORM\Mapping", "alias" => "ORM"],
            ["class" => "Doctrine\ORM\Mapping\UniqueConstraint", "alias" => "UniqueConstraint"],
            ['class' => 'Gedmo\Mapping\Annotation', 'alias' => 'Gedmo']
        ];
    }

    //MODULE
    public function getModule() {
        return $this->getEntity()->getModule(); // return \ZfMetal\Generator\Entity\Module
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Entity
     */
    private $entity;

    function __construct(\ZfMetal\Generator\Entity\Entity $entity) {
        $this->entity = $entity;
    }

    public function prepare() {
        parent::prepare();
        $this->genProperties();
        $this->genToString();
    }

    /**
     * [6] Se generan Properties
     */
    protected function genProperties() {
        foreach ($this->getEntity()->getProperties() as $property) {
            //GENERATE AND ADD Property +(Getter&Setter) to Class 
            $propertyGenerator = new \ZfMetal\Generator\Generator\PropertyGenerator($property, $this->cg);
            $propertyGenerator->generate();
        }
    }

    /**
     * [7] Se genera ToString
     */
    protected function genToString() {

        if ($this->getCg()->hasMethod("__toString")) {
            $this->getCg()->removeMethod("__toString");
        }

        //BODY
        $toString = "return (string)";
        foreach ($this->getEntity()->getProperties() as $property) {
            if ($property->getTostring()) {
                $toString .= ' $this->' . $property->getName() . '." ". ';
            }
        }
        $toString = trim($toString, '." ".');
        $toString .= ';';

        //GENERATE
        $m = new \Zend\Code\Generator\MethodGenerator("__toString");
        $m->setBody($toString);
        $this->getCg()->addMethodFromGenerator($m);
    }

    /**
     * Generate RepositoryClass Name
     */
    protected function genRepositoryClass() {
        return $this->getEntity()->getModule()->getName() . '\\Repository\\' . $this->getEntity()->getName() . 'Repository';
    }

    /**
     * Generate Table Name
     */
    protected function genTableName() {
        return $this->getEntity()->getModule()->getPrefix() . '_' . $this->getEntity()->getTblName();
    }

    /**
     * Generate Custom Table
     */
    protected function genCustomTable() {
        if ($this->getEntity()->getCustomOnTable()) {
            return ", " . $this->getEntity()->getCustomOnTable();
        }
        return null;
    }

    function getEntity() {
        if (!$this->entity) {
            throw new Exception("Entity no set");
        }
        return $this->entity;
    }

    function setEntity(\ZfMetal\Generator\Entity\Entity $entity) {
        $this->entity = $entity;
    }

}
