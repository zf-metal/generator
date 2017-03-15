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
     * "empty_option": "",
     * "target_class":"ZfMetal\Generator\Entity\Entity"})
     * @ORM\ManyToOne(targetEntity="ZfMetal\Generator\Entity\Entity")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entity;

    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="entity_repository")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"EntityRepository"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $entityRepository;

    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="entity_manager")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"EntityManager"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $entityManager;

    
    /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="list_action")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"list"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $listAction;
    
      /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="create_action")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"create"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $createAction;
    
    
         /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="edit_action")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"edit"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $editAction;
    
         /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="delete_action")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"delete"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $deleteAction;
    
         /**
     * @var string
     * @ORM\Column(type="boolean", unique=false, nullable=true, name="view_action")
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Attributes({"type":"checkbox"})
     * @Annotation\Options({"label":"view"})
     * @Annotation\AllowEmpty({"true"})
     */
    protected $viewAction;
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

    function getListAction() {
        return $this->listAction;
    }

    function getCreateAction() {
        return $this->createAction;
    }

    function getEditAction() {
        return $this->editAction;
    }

    function getDeleteAction() {
        return $this->deleteAction;
    }

    function getViewAction() {
        return $this->viewAction;
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

    function setListAction($listAction) {
        $this->listAction = $listAction;
    }

    function setCreateAction($createAction) {
        $this->createAction = $createAction;
    }

    function setEditAction($editAction) {
        $this->editAction = $editAction;
    }

    function setDeleteAction($deleteAction) {
        $this->deleteAction = $deleteAction;
    }

    function setViewAction($viewAction) {
        $this->viewAction = $viewAction;
    }


}
