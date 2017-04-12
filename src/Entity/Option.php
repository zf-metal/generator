<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="option")
 *
 * @author Cristian Incarnato
 */
class Option extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * @ORM\Column(type="string", length=100, unique=false, nullable=false, name="name")
     */
    protected $name;
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Type:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="type")
     */
    protected $type;
    
    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Default Value:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="default_value")
     */
    protected $defaultValue;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Options({"label":"Description:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":300}})
     * @ORM\Column(type="string", length=300, unique=false, nullable=true, name="description")
     */
    protected $description;

    function getId() {
        return $this->id;
    }

    function getModule() {
        return $this->module;
    }

    function getName() {
        return $this->name;
    }

    function getType() {
        return $this->type;
    }

    function getDescription() {
        return $this->description;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setModule($module) {
        $this->module = $module;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setDescription($description) {
        $this->description = $description;
    }
    
    function getDefaultValue() {
        return $this->defaultValue;
    }

    function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
    }

}
