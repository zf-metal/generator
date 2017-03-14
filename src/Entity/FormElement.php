<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="form_element")
 *
 * @author Cristian Incarnato
 */
class FormElement extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * "label":"Form:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Form",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Form")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $form;

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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Type:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\FormElementType",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\FormElementType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;
    
    
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

    function getId() {
        return $this->id;
    }

    function getForm() {
        return $this->form;
    }

    function getName() {
        return $this->name;
    }

    function getType() {
        return $this->type;
    }

    function getEntity() {
        return $this->entity;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setForm($form) {
        $this->form = $form;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }





}
