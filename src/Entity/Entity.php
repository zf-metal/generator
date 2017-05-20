<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="entity")
 *
 * @author Cristian Incarnato
 */
class Entity extends \ZfMetal\Generator\Entity\AbstractEntity {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Module:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Module",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Module")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    protected $module;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Name:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=true, nullable=true, name="name")
     */
    protected $name;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"TblName:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=true, nullable=true, name="tbl_name")
     */
    protected $tblName;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Extends:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="extends")
     */
    protected $extends;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Custom On Table:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":1000}})
     * @ORM\Column(type="string", length=1000, unique=false, nullable=true, name="custom_on_table")
     */
    protected $customOnTable;
    
        /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox", "value": "1"})
     * @Annotation\Options({"label":"Generate ID"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="generate_id")
     */
    protected $generateId = true;
    

    /**
     * @var 
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Property", mappedBy="entity")
     */
    protected $properties;

    public function __construct() {
        $this->properties = new ArrayCollection();
    }

    function getModule() {
        return $this->module;
    }

    function setModule($module) {
        $this->module = $module;
    }

    function getId() {
        return $this->id;
    }

    function getClass() {
        return $this->getModule()->getName() . "\Entity\\" . $this->name;
    }

    function getFullName() {
        return "\\".$this->getModule()->getName() . "\Entity\\" . $this->name;
    }

    function getName() {
        return $this->name;
    }

    function getTblName() {
        return $this->tblName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTblName($tblName) {
        $this->tblName = $tblName;
    }

    function getExtends() {
        return $this->extends;
    }

    function setExtends($extends) {
        $this->extends = $extends;
    }

    function getProperties() {
        return $this->properties;
    }

    function setProperties($properties) {
        $this->properties = $properties;
    }

    public function __toString() {
        return $this->getModule()->getName() . "\Entity\\" . $this->getName();
    }

    function getCustomOnTable() {
        return $this->customOnTable;
    }

    function setCustomOnTable($customOnTable) {
        $this->customOnTable = $customOnTable;
    }
    
    function getGenerateId() {
        return $this->generateId;
    }

    function setGenerateId($generateId) {
        $this->generateId = $generateId;
        return $this;
    }



}
