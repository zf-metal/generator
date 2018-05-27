<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="navigation")
 * @ORM\Entity(repositoryClass="ZfMetal\Generator\Repository\NavigationRepository")
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
     * @Annotation\Type("ZfMetal\Commons\DoctrineModule\Form\Element\ObjectHidden")
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Module")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    protected $module;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Parent:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Navigation"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Navigation")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id",nullable=true)
     */
    protected $parent;

    /**
     * @Annotation\Exclude()
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Navigation", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
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
     * @Annotation\Options({"label":"Uri:", "description": "Only if Route is not set"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $uri;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Route:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Route"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Route")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id", nullable=true,onDelete="CASCADE")
     */
    protected $route;

    /**
     * @var string
     * @Annotation\Options({"label":"Detail:", "description": ""})
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

    function getRoute() {
        return $this->route;
    }

    function setRoute($route) {
        $this->route = $route;
        return $this;
    }

    function getChilds() {
        return $this->childs;
    }

    function setChilds($childs) {
        $this->childs = $childs;
    }

    public function hasChilds() {
        return count($this->childs) ? true : false;
    }

    public function hasParent() {
        return isset($this->parent) ? true : false;
    }

    public function addChilds(\Doctrine\Common\Collections\ArrayCollection $childs)
    {
        foreach ($childs as $child) {
            $this->addChild($child);
        }
    }

    public function removeChilds(\Doctrine\Common\Collections\ArrayCollection $childs)
    {
        foreach ($childs as $child) {
            $this->removeChild($child);
        }
    }

    public function addChild(Route $child)
    {
        if ($this->childs->contains($child)) {
            return;
        }
        $child->setParent($this);
        $this->childs[] = $child;
    }

    public function removeChild(Route $child)
    {
        if (!$this->childs->contains($child)) {
            return;
        }
        $child->setParent(null);
        $this->childs->removeElement($child);
    }

}
