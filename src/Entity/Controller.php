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
     * @ORM\Column(type="string", length=100, unique=false, nullable=false, name="name")
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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Entity:",
     * "description":"If select an Entity the EntityManager will be Injected to the controller and a getRepository method of this entity will be created",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Entity"})
     * @Annotation\Attributes({"class":"form-control"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;

    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="grid_action")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"Grid"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $gridAction;

    /**
     * @var 
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Action", mappedBy="controller")
     */
    protected $actions;

    public function __construct() {
        $this->actions = new ArrayCollection();
    }

    function getClass() {
        return "\\" . $this->getModule()->getName() . "\Controller\\" . $this->name . "Controller";
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

    
    function getGridAction() {
        return $this->gridAction;
    }

    function setGridAction($gridAction) {
        $this->gridAction = $gridAction;
        return $this;
    }


}
