<?php

namespace ZfMetal\Generator\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="route_type")
 *
 * @author Cristian Incarnato
 */
class RouteType extends \ZfMetal\Generator\Entity\AbstractEntity {

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
     * @Annotation\Options({"label":"Name:", "description": ""})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":200}})
     * @ORM\Column(type="string", length=200, unique=false, nullable=true, name="name")
     */
    protected $name;

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

}
