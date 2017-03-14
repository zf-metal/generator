<?php

namespace ZfMetal\Generator\Generator;

/**
 * EntityGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class EntityGenerator extends AbstractClassGenerator {
    //INIT ClassGeneratorInterface

    /**
     * Prefix
     */
    const CLASS_PREFIX = "";

    /**
     * Subffix
     */
    const CLASS_SUBFFIX = "";

    /**
     * Namespace Prefix
     */
    const NAMESPACE_PREFIX = "";

    /**
     * Namespace Subffix
     */
    const NAMESPACE_SUBFFIX = "\Entity";

    /**
     * PATH Subffix
     */
    const PATH_SUBFFIX = "/src/Entity/";

    /**
     * USES
     * 
     * Remember: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @type array
     */
    const USES = [
        ["class" => "Doctrine\Common\Collections\ArrayCollection", "alias" => null],
        ["class" => "Zend\Form\Annotation", "alias" => null],
        ["class" => "Doctrine\ORM\Mapping", "alias" => "ORM"],
        ["class" => "Doctrine\ORM\Mapping\UniqueConstraint", "alias" => "UniqueConstraint"],
    ];

    /**
     * getTags
     * 
     * Remember, return: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @return array
     */
    public function getTags() {
        $a = [
            ["name" => 'ORM\Table(name="' . $this->genTableName() . '"' . $this->genCustomTable() . ')'],
            ["name" => 'ORM\Entity(repositoryClass="' . $this->genRepositoryClass() . '")'],
        ];
        return $a;
    }

    public function getClassName() {
        return $this->getEntity()->getName();
    }

    public function getNamespaceName() {
        return $this->getEntity()->getModule()->getName();
    }

    public function getExtendsName() {
        return null;
    }

    public function getPath() {
        return $this->getEntity()->getModule()->getPath();
    }

    public function getAuthor() {
        return $this->getEntity()->getModule()->getAuthor();
    }

    public function getLicense() {
        return $this->getEntity()->getModule()->getLicense();
    }

    public function getLink() {
        return $this->getEntity()->getModule()->getLink();
    }

    public function getShortDescription() {
        return $this->getEntity()->getName();
    }

    public function getLongDescription() {
        return "";
    }

    //END ClassGeneratorInterface

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Entity
     */
    private $entity;

    function __construct(\ZfMetal\Generator\Entity\Entity $entity) {
        $this->entity = $entity;
    }

    public function generate() {
        parent::generate();
        $this->genProperties();
        $this->genToString();
        $this->insertFile();
    }

    /**
     * [6] Se generan Properties
     */
    protected function genProperties() {
        foreach ($this->getEntity()->getProperties() as $property) {
            //GENERATE AND ADD Property +(Getter&Setter) to Class 
            $propertyGenerator = new \ZfMetal\Generator\Generator\PropertyGenerator($property, $this->classGenerator);
            $propertyGenerator->generate();
        }
    }

    /**
     * [7] Se genera ToString
     */
    protected function genToString() {

        //BODY
        $toString = "return ";
        foreach ($this->getEntity()->getProperties() as $property) {
            if ($property->getTostring()) {
                $toString .= ' $this->' . $property->getName() . '." ". ';
            }
        }
        $toString = trim($toString, '." ".');
        $toString .= ';';

        //GENERATE
        $m = new \Zend\Code\Generator\MethodGenerator ( );
        $m->setName(
                "__toString");
        $m->setBody($toString);
        $this->classGenerator->addMethodFromGenerator($m);
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
