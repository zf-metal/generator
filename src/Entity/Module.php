<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="module")
 *
 * @author Cristian Incarnato
 */
class Module extends \ZfMetal\Generator\Entity\AbstractEntity {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

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
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Prefix:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":15}})
     * @ORM\Column(type="string", length=15, unique=true, nullable=true, name="prefix")
     */
    protected $prefix;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Relative Path:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="path")
     */
    protected $path;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Options({"label":"Description:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":300}})
     * @ORM\Column(type="string", length=300, unique=false, nullable=true, name="description")
     */
    protected $description;
    
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Author:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="author")
     */
    protected $author;
    
     /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"License:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true, name="license")
     */
    protected $license;

      /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Link:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":150}})
     * @ORM\Column(type="string", length=150, unique=false, nullable=true, name="link")
     */
    protected $link;
    

    /**
     * @var \DateTime createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     * @Annotation\Exclude()
     */
    protected $createdAt;

    /**
     * @var \DateTime updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     * @Annotation\Exclude()
     */
    protected $updatedAt;

    /**
     * @var 
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Entity", mappedBy="module")
     */
    protected $entities;

    /**
     * @var 
     * @ORM\OneToMany(targetEntity="ZfMetal\Generator\Entity\Controller", mappedBy="module")
     */
    protected $controllers;

    public function __construct() {
        $this->entities = new ArrayCollection();
        $this->controllers = new ArrayCollection();
    }

    function getControllers() {
        return $this->controllers;
    }

    function setControllers($controllers) {
        $this->controllers = $controllers;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPath() {
        return $this->path;
    }

    function getEntities() {
        return $this->entities;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setEntities($entities) {
        $this->entities = $entities;
    }

    public function __toString() {
        return $this->name;
    }

    function getPrefix() {
        return $this->prefix;
    }

    function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }
    
    function getAuthor() {
        return $this->author;
    }

    function getLicense() {
        return $this->license;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setLicense($license) {
        $this->license = $license;
    }
    
    function getLink() {
        return $this->link;
    }

    function setLink($link) {
        $this->link = $link;
    }





}
