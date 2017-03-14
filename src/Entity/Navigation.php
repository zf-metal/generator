<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="navigation")
 *
 * @author Cristian Incarnato
 */
class Navigation extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Menu Parent:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Navigation",
     * "property": "label"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Navigation")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id",nullable=true)
     */
    protected $parent;

    /**
     * @Annotation\Exclude()
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Navigation", mappedBy="parent")
     */
    protected $childs;

    /**
     * @var string
     * @Annotation\Options({"label":"Label:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $label;

    /**
     * @var string
     * @Annotation\Options({"label":"Uri:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $uri;

    /**
     * @var string
     * @Annotation\Options({"label":"Detail:", "description": "Solo se admiten nombres alfanumericos"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $detail;

    /**
     * @var string
     * @Annotation\Options({"label":"Icon:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $icon;

    /**
     * @var string
     * @Annotation\Options({"label":"Permission:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $permission;



    public function __construct() {
        $this->childs = new ArrayCollection();
    }

    function getModule() {
        return $this->module;
    }

    function setModule($module) {
        $this->module = $module;
    }

    public function __toString() {
        return $this->label;
    }

    function getId() {
        return $this->id;
    }

    function getLabel() {
        return $this->label;
    }

    function getUri() {
        return $this->uri;
    }

    function getDetail() {
        return $this->detail;
    }

    function getIcon() {
        return $this->icon;
    }

    function getPermission() {
        return $this->permission;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setUri($uri) {
        $this->uri = $uri;
    }

    function setDetail($detail) {
        $this->detail = $detail;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setPermission($permission) {
        $this->permission = $permission;
    }

    function getParent() {
        return $this->parent;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function getChilds() {
        return $this->childs;
    }

    function setChilds($childs) {
        $this->childs = $childs;
    }



}
