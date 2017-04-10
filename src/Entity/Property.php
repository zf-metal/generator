<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="property")
 *
 * @author Cristian Incarnato
 */
class Property extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * "label":"Entity:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Entity",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;

    /**
     * @var string
     * @Annotation\Options({"label":"Name:", "description": "Solo se admiten nombres alfanumericos, sin espacios"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Zend\Validator\Regex", "options":{"pattern": "/^[a-zA-Z]*$/"}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=false, name="name")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, unique=false, nullable=false, name="type")
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Type:", "description": "string: Campo de tipo texto limitado|integer: campo numerico|text: campo de texto variable|boolean: true o false"})
     * @Annotation\Attributes({"type":"select","options":{"":"type","string":"string","stringarea":"stringarea","date":"date","datetime":"datetime","time":"time","text":"text","integer":"integer","decimal":"decimal","boolean":"boolean","file":"file","oneToOne":"oneToOne","manyToOne":"manyToOne","oneToMany":"oneToMany","manyToMany":"manyToMany"}})
     * @Annotation\Attributes({"onchange":"changetype()"}) 
     */
    protected $type;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Related Entity:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Entity"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Entity")
     * @ORM\JoinColumn(name="related_entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $relatedEntity;

    /**
     * @var string
     * @Annotation\Options({"label":"Length:", "description": "Cantidad de caracteres del campo"})
     * @Annotation\Validator({"name":"Between", "options":{"min":0, "max":1000}})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true, name="length")
     */
    protected $length;

    /**
     * @var string
     * @Annotation\Options({"label":"Absolutepath:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":200}})
     * @ORM\Column(type="string", length=200, unique=false, nullable=true, name="absolutepath")
     */
    protected $absolutepath;

    /**
     * @var string
     * @Annotation\Options({"label":"WebPath:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="webpath")
     */
    protected $webpath;

    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="be_unique")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"Unique:"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $beUnique;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox", "value": "1"})
     * @Annotation\Options({"label":"Nulleable:", "value": "1"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="be_nullable")
     */
    protected $beNullable = true;

    /**
     * @var string
     * @Annotation\Options({"label":"Label:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":200}})
     * @ORM\Column(type="string", length=200, unique=false, nullable=true, name="label")
     */
    protected $label;

    /**
     * @var string
     * @Annotation\Options({"label":"Description:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":500}})
     * @ORM\Column(type="string", length=500, unique=false, nullable=true, name="description")
     */
    protected $description;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox", "value": "1"})
     * @Annotation\Options({"label":"Exclude:", "value": "0"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="exclude")
     */
    protected $exclude = false;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"Hidden:", "value": "0"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="hidden")
     */
    protected $hidden = false;
    
    
       /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"Mandatory:", "value": "0"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="mandatory")
     */
    protected $mandatory = false;
    
      /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"Tostring:", "value": "0"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="tostring")
     */
    protected $tostring = false;
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"Primarykey:", "value": "0"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="primarykey")
     */
    protected $primarykey = false;
    
    
      /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Checkbox") 
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"AutoGeneratedValue:", "value": "0"})
     * @Annotation\AllowEmpty({"true"})
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="auto_generated_value")
     */
    protected $autoGeneratedValue= false;


    public function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getEntity() {
        return $this->entity;
    }

    function getName() {
        return $this->name;
    }

    function getTblName() {
        return $this->tblName;
    }

    function getType() {
        return $this->type;
    }

    function getLength() {
        return $this->length;
    }

    function getBeUnique() {
        return $this->beUnique;
    }

    function getBeNullable() {
        return $this->beNullable;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTblName($tblName) {
        $this->tblName = $tblName;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setLength($length) {
        $this->length = $length;
    }

    function setBeUnique($beUnique) {
        $this->beUnique = $beUnique;
    }

    function setBeNullable($beNullable) {
        $this->beNullable = $beNullable;
    }

    function getRelatedEntity() {
        return $this->relatedEntity;
    }

    function setRelatedEntity($relatedEntity) {
        $this->relatedEntity = $relatedEntity;
    }

    public function __toString() {
        return $this->name;
    }

    function getAbsolutepath() {
        return $this->absolutepath;
    }

    function getWebpath() {
        return $this->webpath;
    }

    function setAbsolutepath($absolutepath) {
        $this->absolutepath = $absolutepath;
    }

    function setWebpath($webpath) {
        $this->webpath = $webpath;
    }

    function getLabel() {
        return $this->label;
    }

    function getDescription() {
        return $this->description;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getExclude() {
        return $this->exclude;
    }

    function setExclude($exclude) {
        $this->exclude = $exclude;
    }

    function getHidden() {
        return $this->hidden;
    }

    function setHidden($hidden) {
        $this->hidden = $hidden;
    }
    

    function getMandatory() {
        return $this->mandatory;
    }

    function setMandatory($mandatory) {
        $this->mandatory = $mandatory;
    }


    function getTostring() {
        return $this->tostring;
    }

    function getPrimarykey() {
        return $this->primarykey;
    }

 
    function setTostring($tostring) {
        $this->tostring = $tostring;
    }

    function setPrimarykey($primarykey) {
        $this->primarykey = $primarykey;
    }

    function getAutoGeneratedValue() {
        return $this->autoGeneratedValue;
    }

    function setAutoGeneratedValue($autoGeneratedValue) {
        $this->autoGeneratedValue = $autoGeneratedValue;
    }





}
