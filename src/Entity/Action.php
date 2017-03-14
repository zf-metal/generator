<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="action")
 *
 * @author Cristian Incarnato
 */
class Action extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * "label":"Controller:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Controller",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Controller")
     * @ORM\JoinColumn(name="controller_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $controller;

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
     * "label":"Template:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\ActionTemplate",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\ActionTemplate")
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $template;
    


    function getId() {
        return $this->id;
    }

    function getController() {
        return $this->controller;
    }

    function getName() {
        return $this->name;
    }

    function getTemplate() {
        return $this->template;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setController($controller) {
        $this->controller = $controller;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setTemplate($template) {
        $this->template = $template;
    }



}
