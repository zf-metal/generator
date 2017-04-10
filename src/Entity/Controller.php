<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="controller")
 *
 * @author Cristian Incarnato
 */
class Controller extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * @ORM\Column(type="string", length=100, unique=true, nullable=false, name="name")
     */
    protected $name;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Options({"label":"Description:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":300}})
     * @ORM\Column(type="string", length=300, unique=false, nullable=true, name="description")
     */
    protected $description;

    /**
     * @var 
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Action", mappedBy="controller")
     */
    protected $actions;

    /**
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\OneToOne(targetEntity="ZfMetal\Generator\Entity\ControllerCommons", mappedBy="controller")
     * @var \ZfMetal\Generator\Entity\ControllerCommons
     */
    protected $commons;

    public function __construct() {
        $this->actions = new ArrayCollection();
    }
    
    function getClass() {
        return "\\".$this->getModule()->getName() . "\Controller\\" . $this->name."Controller";
    }

    function getCommons() {
        return $this->commons;
    }

    function setCommons($commons) {
        $this->commons = $commons;
    }

    function getEntity() {
        return $this->entity;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function getActions() {
        return $this->actions;
    }

    function setActions($actions) {
        $this->actions = $actions;
    }

    function getId() {
        return $this->id;
    }

    function getModule() {
        return $this->module;
    }

    function getName() {
        return $this->name;
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

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    public function __toString() {
        return $this->getClass();
    }

}
