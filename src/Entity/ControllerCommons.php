<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="controller_commons")
 *
 * @author Cristian Incarnato
 */
class ControllerCommons extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * @ORM\OneToOne(targetEntity="ZfMetal\Generator\Entity\Controller")
     * @ORM\JoinColumn(name="controller_id", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    protected $controller;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "label":"Entity:",
     * "description":"Select entity asociated to Controller",
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Entity",
     * "property": "name"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;

    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="entity_repository")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"EntityRepository:","description":"Inject entityRepository to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $entityRepository;

    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="entity_manager")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"EntityManager:","description":"Inject entityManager to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $entityManager;

    
    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="list")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"CRUD-LIST:","description":"Inject Action List to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $list;
    
      /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="create")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"CRUD-CREATE:","description":"Inject Action Create to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $create;
    
    
         /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="edit")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"CRUD-EDIT:","description":"Inject Action Edit to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $edit;
    
         /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="delete")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"CRUD-DELETE:","description":"Inject Action Delete to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $delete;
    
         /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="view")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"CRUD-VIEW:","description":"Inject Action View to Controller"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $view;
    
    function getId() {
        return $this->id;
    }

    function getController() {
        return $this->controller;
    }

    function getEntity() {
        return $this->entity;
    }

    function getEntityRepository() {
        return $this->entityRepository;
    }

    function getEntityManager() {
        return $this->entityManager;
    }

    function getList() {
        return $this->list;
    }

    function getCreate() {
        return $this->create;
    }

    function getEdit() {
        return $this->edit;
    }

    function getDelete() {
        return $this->delete;
    }

    function getView() {
        return $this->view;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setController($controller) {
        $this->controller = $controller;
    }

    function setEntity($entity) {
        $this->entity = $entity;
    }

    function setEntityRepository($entityRepository) {
        $this->entityRepository = $entityRepository;
    }

    function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    function setList($list) {
        $this->list = $list;
    }

    function setCreate($create) {
        $this->create = $create;
    }

    function setEdit($edit) {
        $this->edit = $edit;
    }

    function setDelete($delete) {
        $this->delete = $delete;
    }

    function setView($view) {
        $this->view = $view;
    }


    
}
