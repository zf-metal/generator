<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="route")
 * @ORM\Entity(repositoryClass="ZfMetal\Generator\Repository\RouteRepository")
 * @author Cristian Incarnato
 */
class Route extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * "label":"Route Parent:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Route",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Route")
     * @ORM\JoinColumn(name="route_id", referencedColumnName="id",nullable=true)
     */
    protected $parent;

    /**
     * @Annotation\Exclude()
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Route", mappedBy="parent")
     */
    protected $childs;

    /**
     * @var string
     * @Annotation\Options({"label":"Name:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true)
     */
    protected $name;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Route Type:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\RouteType",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\RouteType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id",nullable=true)
     */
    protected $type;

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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Action:",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Action",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Action")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $action;

    /**
     * @var string
     * @Annotation\Options({"label":"Route:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":500}})
     * @Annotation\Filter({"name": "Zend\Filter\StringTrim"})
     * @ORM\Column(type="string", length=500, unique=false, nullable=true)
     */
    protected $route;

    public function __construct() {
        $this->childs = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getModule() {
        return $this->module;
    }

    function getParent() {
        return $this->parent;
    }

    function getChilds() {
        return $this->childs;
    }

    function getName() {
        return $this->name;
    }

    function getType() {
        return $this->type;
    }

    function getController() {
        return $this->controller;
    }

    function getAction() {
        return $this->action;
    }

    function getRoute() {
        return $this->route;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setModule($module) {
        $this->module = $module;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function setChilds($childs) {
        $this->childs = $childs;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setController($controller) {
        $this->controller = $controller;
    }

    function setAction($action) {
        $this->action = $action;
    }

    function setRoute($route) {
        $this->route = $route;
    }

    public function hasChilds() {
        return count($this->childs)?true:false;
    }

    public function addChild(\ZfMetal\Generator\Entity\Route $route) {
        if ($this->childs->contains($route)) {
            return;
        }
        $this->childs[] = $route;
        $route->setParent($this);
    }

    public function removeChild() {
        if (!$this->childs->contains($route)) {
            return;
        }
        $this->childs->removeElement($route);
        $route->setParent(null);
    }

    public function __toString() {
        return $this->name." (".$this->route.")";
    }

}
