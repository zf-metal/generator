<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="viewhelper")
 *
 * @author Cristian Incarnato
 */
class ViewHelper extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Invokable"})
     * @ORM\Column(type="boolean", length=100, unique=false, nullable=true, name="invokable")
     * @Annotation\AllowEmpty({"true"})
     */
    protected $invokable;
    
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

    function getInvokable() {
        return $this->invokable;
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

    function setInvokable($invokable) {
        $this->invokable = $invokable;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
